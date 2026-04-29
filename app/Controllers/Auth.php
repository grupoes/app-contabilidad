<?php

namespace App\Controllers;

use Config\Services;

class Auth extends BaseController
{
    public function index()
    {
        if (session()->get('logged_in')) {
            return redirect()->to(base_url('/home'));
        }
        return view('auth/login');
    }

    public function login()
    {
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $client = Services::curlrequest();

        try {
            $url = getenv('URL_SERVIDOR');

            $response = $client->post($url . 'login', [
                'headers' => [
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'username' => $username,
                    'password' => $password,
                ],
                'timeout' => 10,
                'http_errors' => false
            ]);

            $result = json_decode($response->getBody(), true);

            if (!$result || $result['status'] == false) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => $result['message']
                ]);
            }

            if ($username == $password) {
                session()->set([
                    'token' => $result['token'],
                    'user' => $result['user'],
                    'id_usuario' => $result['user']['id'],
                    'nombre' => $result['user']['nombre'],
                    'role' => $result['user']['role'],
                    'primer_nombre' => explode(' ', trim($result['user']['nombre']))[0],
                    'logged_in' => false
                ]);

                return $this->response->setJSON([
                    'status' => 'warning',
                    'message' => 'Contraseña por defecto, cámbiala por una personalizada',
                    'redirect' => base_url('auth/reset-password')
                ]);
            }

            // Guardar token en sesión
            session()->set([
                'token' => $result['token'],
                'user' => $result['user'],
                'id_usuario' => $result['user']['id'],
                'nombre' => $result['user']['nombre'],
                'role' => $result['user']['role'],
                'primer_nombre' => explode(' ', trim($result['user']['nombre']))[0],
                'logged_in' => true
            ]);

            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Inicio de sesión exitoso',
                'redirect' => base_url('/home')
            ]);
        } catch (\Exception $e) {

            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'No se pudo conectar a la api del servidor de autenticación ' . $e->getMessage()
            ]);
        }
    }

    public function logout()
    {
        session()->destroy();
        return $this->response->setJSON(['status' => 'success']);
    }

    public function perfil()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to(base_url('/'));
        }

        return view('auth/perfil');
    }

    public function changePassword()
    {
        $currentPassword = $this->request->getPost('currentPassword');
        $newPassword = $this->request->getPost('NewPassword');
        $confirmPassword = $this->request->getPost('ConfirmPassword');
        $usuario = session()->get('user')['username'];

        $client = Services::curlrequest();

        try {
            $url = getenv('URL_SERVIDOR');

            $response = $client->post($url . 'change-password', [
                'headers' => [
                    'Authorization' => "Bearer " . session()->get('token'),
                    'Content-Type' => 'application/json',
                ],
                'http_errors' => false,
                'json' => [
                    'currentPassword' => $currentPassword,
                    'newPassword' => $newPassword,
                    'confirmPassword' => $confirmPassword,
                    'usuario' => $usuario
                ],
                'timeout' => 10,
            ]);

            // 👀 SI TOKEN EXPIRÓ
            if ($response->getStatusCode() === 401) {
                session()->destroy();
                return redirect()->to(base_url())->send();
                exit;
            }

            $result = json_decode($response->getBody(), true);

            if (!$result || $result['status'] == 'error') {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => $result['message']
                ]);
            }

            return $this->response->setJSON($result);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'error al consultar la api ' . $e->getMessage()
            ]);
        }
    }

    public function resetPasswordLink()
    {
        $email = $this->request->getPost('email') ?: session()->get('reset_email');
        $id_user = session()->get('id_usuario');
        $username = session()->get('user')['username'] ?? null;

        $client = Services::curlrequest();

        try {
            $url = getenv('URL_SERVIDOR');

            $response = $client->post($url . 'auth/reset-password-link', [
                'headers' => [
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'email' => $email,
                    'id_user' => $id_user,
                    'username' => $username
                ],
                'timeout' => 10,
                'http_errors' => false
            ]);

            $result = json_decode($response->getBody(), true);

            if (!$result || empty($result['status'])) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => $result['message'] ?? 'No se pudo enviar el código de verificación.'
                ]);
            }

            session()->set([
                'reset_email' => $email,
                'id_usuario'  => $result['id_user'] ?? $id_user,
            ]);

            if (isset($result['username'])) {
                session()->set('user', ['username' => $result['username']]);
            }

            return $this->response->setJSON([
                'status'   => 'success',
                'message'  => $result['message'] ?? 'Código enviado correctamente.',
                'redirect' => base_url('auth/verify-code')
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'error al consultar la api ' . $e->getMessage()
            ]);
        }
    }

    public function forgotPassword()
    {
        return view('auth/forgot_password');
    }

    public function resetPassword()
    {
        // Permitir acceso solo si hay una sesión iniciada (logged_in=false por contraseña por defecto)
        if (!session()->get('token')) {
            return redirect()->to(base_url('/'));
        }
        return view('auth/reset_password');
    }

    public function verifyCode()
    {
        // Permitir acceso si hay un token (reset por default) O si hay un correo en proceso (olvidó contraseña)
        if (!session()->get('token') && !session()->get('reset_email')) {
            return redirect()->to(base_url('/'));
        }
        return view('auth/verify_code');
    }

    public function verifyCodePost()
    {
        $code = $this->request->getPost('code');
        $id_user = session()->get('id_usuario');
        $username = session()->get('user')['username'] ?? null;

        $client = Services::curlrequest();

        try {
            $url = getenv('URL_SERVIDOR');

            $response = $client->post($url . 'auth/verify-code', [
                'headers' => [
                    'Authorization' => 'Bearer ' . session()->get('token'),
                    'Content-Type'  => 'application/json',
                ],
                'json' => [
                    'code'     => $code,
                    'id_user'  => $id_user,
                    'username' => $username,
                ],
                'timeout'     => 10,
                'http_errors' => false,
            ]);

            if ($response->getStatusCode() === 401) {
                session()->destroy();
                return $this->response->setJSON(['status' => 'error', 'message' => 'Sesión expirada.']);
            }

            $result = json_decode($response->getBody(), true);

            if (!$result || empty($result['status'])) {
                return $this->response->setJSON([
                    'status'  => 'error',
                    'message' => $result['message'] ?? 'Código incorrecto o expirado.',
                ]);
            }

            // Código válido: permitir acceso a cambio de contraseña
            session()->set('password_reset_authorized', true);
            session()->remove('reset_email');

            return $this->response->setJSON([
                'status'   => 'success',
                'message'  => 'Código verificado correctamente.',
                'redirect' => base_url('auth/set-new-password'),
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Error de conexión: ' . $e->getMessage(),
            ]);
        }
    }

    public function setNewPassword()
    {
        // Permitir si ya fue autorizado (verificó código)
        if (!session()->get('password_reset_authorized')) {
            return redirect()->to(base_url('/'));
        }
        return view('auth/set_new_password');
    }

    public function updatePassword()
    {
        if (!session()->get('password_reset_authorized')) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Acceso no autorizado.']);
        }

        $newPassword = $this->request->getPost('new_password');
        $confirmPassword = $this->request->getPost('confirm_password');

        // Validación: Mínimo 8 caracteres
        if (strlen($newPassword) < 8) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'La contraseña debe tener al menos 8 caracteres.'
            ]);
        }

        // Validación: Alfanumérico
        if (!preg_match('/^(?=.*[a-zA-Z])(?=.*[0-9])[a-zA-Z0-9]+$/', $newPassword)) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'La contraseña debe ser alfanumérica (letras y números).'
            ]);
        }

        if ($newPassword !== $confirmPassword) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Las contraseñas no coinciden.'
            ]);
        }

        $id_user = session()->get('id_usuario');
        $username = session()->get('user')['username'] ?? null;

        $client = Services::curlrequest();

        try {
            $url = getenv('URL_SERVIDOR');

            $response = $client->post($url . 'auth/update-password', [
                'headers' => [
                    'Authorization' => 'Bearer ' . session()->get('token'),
                    'Content-Type'  => 'application/json',
                ],
                'json' => [
                    'newPassword'     => $newPassword,
                    'confirmPassword' => $confirmPassword,
                    'id_user'         => $id_user,
                    'username'        => $username,
                ],
                'timeout'     => 10,
                'http_errors' => false,
            ]);

            if ($response->getStatusCode() === 401) {
                session()->destroy();
                return $this->response->setJSON(['status' => 'error', 'message' => 'Sesión expirada.']);
            }

            $result = json_decode($response->getBody(), true);

            if (!$result || empty($result['status'])) {
                return $this->response->setJSON([
                    'status'  => 'error',
                    'message' => $result['message'] ?? 'No se pudo actualizar la contraseña.',
                ]);
            }

            // Éxito: Activar sesión completa y limpiar flags
            session()->set([
                'logged_in'     => true,
                'token'         => $result['token'],
                'user'          => $result['user'],
                'id_usuario'    => $result['user']['id'],
                'nombre'        => $result['user']['nombre'],
                'role'          => $result['user']['role'],
                'primer_nombre' => explode(' ', trim($result['user']['nombre']))[0]
            ]);
            
            session()->remove('password_reset_authorized');

            return $this->response->setJSON([
                'status'   => 'success',
                'message'  => 'Contraseña actualizada con éxito.',
                'redirect' => base_url('/home'),
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Error de conexión: ' . $e->getMessage(),
            ]);
        }
    }
}
