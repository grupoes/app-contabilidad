<?php

namespace App\Controllers;

class Personal extends BaseController
{
    public function index()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to(base_url('/'));
        }

        return view('personal/index');
    }

    public function getListaPersonal()
    {
        $ruc = session()->get('user')['username'];
        $client = \Config\Services::curlrequest();
        try {
            $url = getenv('URL_SERVIDOR');
            $response = $client->get($url . 'lista-personal/' . $ruc, [
                'headers' => [
                    'Authorization' => 'Bearer ' . session()->get('token'),
                    'Content-Type' => 'application/json',
                ],
                'http_errors' => false,
                'timeout' => 10,
            ]);

            $result = json_decode($response->getBody(), true);

            if ($response->getStatusCode() === 401) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Sesión expirada o no autorizado.',
                    'redirect' => base_url('/')
                ]);
            }

            return $this->response->setJSON($result);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Error de conexión: ' . $e->getMessage()
            ]);
        }
    }

    public function resetPersonal($id)
    {
        $client = \Config\Services::curlrequest();
        try {
            $url = getenv('URL_SERVIDOR');
            $response = $client->get($url . 'resetear-usuario/' . $id, [
                'headers' => [
                    'Authorization' => 'Bearer ' . session()->get('token'),
                    'Content-Type' => 'application/json',
                ],
                'http_errors' => false,
                'timeout' => 10,
            ]);

            $result = json_decode($response->getBody(), true);

            if ($response->getStatusCode() === 401) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Sesión expirada o no autorizado.',
                    'redirect' => base_url('/')
                ]);
            }

            return $this->response->setJSON($result);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Error de conexión: ' . $e->getMessage()
            ]);
        }
    }
}
