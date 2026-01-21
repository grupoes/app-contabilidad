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
            ]);

            $result = json_decode($response->getBody(), true);

            if (!$result || empty($result['status'])) {
                return redirect()->back()->with('error', 'Credenciales incorrectas');
            }

            // Guardar token en sesión
            session()->set([
                'token' => $result['token'],
                'user' => $result['user'],
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
                'message' => 'Error de conexión al servidor de autenticación'
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
}
