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
        $email = $this->request->getPost('email');

        $client = Services::curlrequest();

        try {
            $url = getenv('URL_SERVIDOR');

            $response = $client->post($url . 'reset-password-link', [
                'headers' => [
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'email' => $email,
                ],
                'timeout' => 10,
                'http_errors' => false
            ]);

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
        if (!session()->get('token')) {
            return redirect()->to(base_url('/'));
        }
        return view('auth/verify_code');
    }

    public function verifyCodePost()
    {
        $code = $this->request->getPost('code');

        $client = Services::curlrequest();

        try {
            $url = getenv('URL_SERVIDOR');

            $response = $client->post($url . 'verify-code', [
                'headers' => [
                    'Authorization' => 'Bearer ' . session()->get('token'),
                    'Content-Type'  => 'application/json',
                ],
                'json' => ['code' => $code],
                'timeout'     => 10,
                'http_errors' => false,
            ]);

            if ($response->getStatusCode() === 401) {
                session()->destroy();
                return $this->response->setJSON(['status' => 'error', 'message' => 'Sesión expirada.']);
            }

            $result = json_decode($response->getBody(), true);

            if (!$result || $result['status'] === 'error') {
                return $this->response->setJSON([
                    'status'  => 'error',
                    'message' => $result['message'] ?? 'Código incorrecto o expirado.',
                ]);
            }

            // Código válido: activar sesión completa
            session()->set('logged_in', true);

            return $this->response->setJSON([
                'status'   => 'success',
                'message'  => 'Código verificado correctamente.',
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
