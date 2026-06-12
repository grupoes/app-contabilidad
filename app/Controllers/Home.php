<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to(base_url('/'));
        }

        $role = session()->get('user')['role'];

        if ($role === 'trabajador') {
            return view('home/index');
        }

        return view('home/contribuyente');
    }

    public function empresas()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to(base_url('/'));
        }

        try {
            $token = session()->get('token');
            $usuario = session()->get('user')['username'];

            $client = \Config\Services::curlrequest();

            $url = getenv('URL_SERVIDOR') . 'empresas';

            $response = $client->post($url, [
                'headers' => [
                    'Authorization' => "Bearer $token",
                    'Accept' => 'application/json'
                ],
                'http_errors' => false,
                'json' => [
                    'usuario' => $usuario,
                ]
            ]);

            // 👀 SI TOKEN EXPIRÓ
            if ($response->getStatusCode() === 401) {
                session()->destroy();
                return redirect()->to(base_url())->send();
                exit;
            }

            $data = json_decode($response->getBody(), true);

            if (!$data || empty($data['status'])) {
                return redirect()->back()->with('error', 'No se pudieron obtener las empresas');
            }

            return $this->response->setJSON([
                'status' => 'success',
                'data' => $data['empresas']
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Error al obtener las empresas: ' . $e->getMessage()
            ]);
        }
    }

    public function listaBoletas($ruc)
    {
        if (!session()->get('logged_in')) {
            return redirect()->to(base_url('/'));
        }

        $client = \Config\Services::curlrequest();

        $url = getenv('URL_SERVIDOR') . 'anios';
        $link = getenv('URL_SERVIDOR') . 'getEmpresa/' . $ruc;

        $response = $client->get($url, [
            'headers' => [
                'Authorization' => "Bearer " . session()->get('token'),
                'Accept' => 'application/json'
            ]
        ]);

        $data = json_decode($response->getBody(), true);

        if (!$data || empty($data['status'])) {
            return redirect()->back()->with('error', 'No se pudieron obtener los años');
        }

        $resp = $client->get($link, [
            'headers' => [
                'Authorization' => "Bearer " . session()->get('token'),
                'Accept' => 'application/json'
            ]
        ]);

        $empresa = json_decode($resp->getBody(), true);

        if (!$empresa || empty($empresa['status'])) {
            return redirect()->back()->with('error', 'No se pudieron obtener los años');
        }

        $name = $empresa['empresa']['razon_social'];

        return view('home/boletas', ['ruc' => $ruc, 'anios' => $data['anios'], 'empresa' => $name]);
    }

    public function listarBoletas()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to(base_url('/'));
        }

        $ruc = $this->request->getPost('ruc');
        $anio = $this->request->getPost('anio');
        $mes = $this->request->getPost('mes');

        $usuario = session()->get('user')['username'];

        $client = \Config\Services::curlrequest();

        $url = getenv('URL_SERVIDOR') . 'lista_boletas';

        $response = $client->post($url, [
            'headers' => [
                'Authorization' => "Bearer " . session()->get('token'),
                'Accept' => 'application/json'
            ],
            'http_errors' => false,
            'json' => [
                'usuario' => $usuario,
                'ruc' => $ruc,
                'anio' => $anio,
                'mes' => $mes
            ]
        ]);

        // 👀 SI TOKEN EXPIRÓ
        if ($response->getStatusCode() === 401) {
            session()->destroy();
            return redirect()->to(base_url())->send();
            exit;
        }

        $data = json_decode($response->getBody(), true);

        if (!$data || empty($data['status'])) {
            return redirect()->back()->with('error', 'No se pudieron obtener las boletas');
        }

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Boletas obtenidas correctamente',
            'data' => $data['boletas']
        ]);
    }

    public function descargarBoleta($boletaId)
    {
        if (!session()->get('logged_in')) {
            return redirect()->to(base_url('/'));
        }

        $usuario = session()->get('user')['username'];

        $client = \Config\Services::curlrequest();

        $url = getenv('URL_SERVIDOR') . 'descargar_boleta';

        $response = $client->post($url, [
            'headers' => [
                'Authorization' => "Bearer " . session()->get('token'),
                'Accept' => 'application/json'
            ],
            'http_errors' => false,
            'json' => [
                'usuario' => $usuario,
                'boleta_id' => $boletaId
            ]
        ]);

        // 👀 SI TOKEN EXPIRÓ
        if ($response->getStatusCode() === 401) {
            session()->destroy();
            return redirect()->to(base_url())->send();
            exit;
        }

        $data = json_decode($response->getBody(), true);

        if (!$data || empty($data['status']) || empty($data['file_content']) || empty($data['file_name'])) {
            return redirect()->back()->with('error', 'No se pudo descargar la boleta');
        }

        $fileContent = base64_decode($data['file_content']);
        $fileName = $data['file_name'];

        return $this->response->setHeader('Content-Type', 'application/pdf')
            ->setHeader('Content-Disposition', 'attachment; filename="' . $fileName . '"')
            ->setBody($fileContent);
    }

    public function pdtRenta()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to(base_url('/'));
        }

        return view('home/pdtRenta');
    }

    public function consultaPdtRenta()
    {
        try {
            $anio = $this->request->getPost('anio');
            $mesInicial = $this->request->getPost('mes_inicial');
            $mesFinal = $this->request->getPost('mes_final');

            $ruc = session()->get('user')['username'];

            $client = \Config\Services::curlrequest();

            $url = getenv('URL_SERVIDOR') . 'consulta-pdt-renta';

            $response = $client->post($url, [
                'headers' => [
                    'Authorization' => "Bearer " . session()->get('token'),
                    'Accept' => 'application/json'
                ],
                'http_errors' => false,
                'json' => [
                    'mes_inicial' => $mesInicial,
                    'ruc' => $ruc,
                    'anio' => $anio,
                    'mes_final' => $mesFinal
                ]
            ]);

            // 👀 SI TOKEN EXPIRÓ
            if ($response->getStatusCode() === 401) {
                session()->destroy();
                return redirect()->to(base_url())->send();
                exit;
            }

            $data = json_decode($response->getBody(), true);

            if (!$data || $data['status'] === 'error') {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => $data['message']
                ]);
            }

            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'consulta obtenida correctamente',
                'data' => $data['data']
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'no se pudo obtener la consulta ' . $e->getMessage()
            ]);
        }
    }

    public function pdtPlame()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to(base_url('/'));
        }

        return view('home/pdtPlame');
    }

    public function consultaPdtPlame()
    {
        try {
            $anio = $this->request->getPost('anio');
            $mes = $this->request->getPost('mes');

            $ruc = session()->get('user')['username'];

            $client = \Config\Services::curlrequest();

            $url = getenv('URL_SERVIDOR') . 'consulta-pdt-plame';

            $response = $client->post($url, [
                'headers' => [
                    'Authorization' => "Bearer " . session()->get('token'),
                    'Accept' => 'application/json'
                ],
                'http_errors' => false,
                'json' => [
                    'mes' => $mes,
                    'ruc' => $ruc,
                    'anio' => $anio
                ]
            ]);

            $data = json_decode($response->getBody(), true);

            if (!$data || $data['status'] === 'error') {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => $data['message']
                ]);
            }

            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'consulta obtenida correctamente',
                'data' => $data['data']
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'no se pudo obtener la consulta ' . $e->getMessage()
            ]);
        }
    }

    public function pdtAnual()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to(base_url('/'));
        }

        return view('home/pdtAnual');
    }

    public function verificarPdtAnual()
    {
        $client = \Config\Services::curlrequest();

        try {
            $usuario = session()->get('user')['username'];

            $url = getenv('URL_SERVIDOR');

            $response = $client->get($url . 'verificar-pdt-anual/' . $usuario, [
                'headers' => [
                    'Authorization' => "Bearer " . session()->get('token'),
                    'Content-Type' => 'application/json',
                ],
                'http_errors' => false
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
                'message' => 'Error al conectar a la api ' . $e->getMessage()
            ]);
        }
    }

    public function consultaPdtAnual()
    {
        try {

            $anio = $this->request->getPost('anio');
            $tipoPdt = $this->request->getPost('tipoPdt');

            $ruc = session()->get('user')['username'];

            $client = \Config\Services::curlrequest();

            $url = getenv('URL_SERVIDOR') . 'consulta-pdt-anual';

            $response = $client->post($url, [
                'headers' => [
                    'Authorization' => "Bearer " . session()->get('token'),
                    'Accept' => 'application/json'
                ],
                'http_errors' => false,
                'json' => [
                    'anio' => $anio,
                    'ruc' => $ruc,
                    'tipoPdt' => $tipoPdt
                ]
            ]);

            // 👀 SI TOKEN EXPIRÓ
            if ($response->getStatusCode() === 401) {
                session()->destroy();
                return redirect()->to(base_url())->send();
                exit;
            }

            $data = json_decode($response->getBody(), true);

            if (!$data || $data['status'] === 'error') {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => $data['message']
                ]);
            }

            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'consulta obtenida correctamente',
                'data' => $data['data']
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'No se pudo conectar con la api ' . $e->getMessage()
            ]);
        }
    }

    public function obtenerAnalisisMovimientos($anio)
    {
        try {
            $ruc = session()->get('user')['username'];

            $client = \Config\Services::curlrequest();

            $url = getenv('URL_SERVIDOR') . 'consulta-analisis';

            $response = $client->post($url, [
                'headers' => [
                    'Authorization' => "Bearer " . session()->get('token'),
                    'Accept' => 'application/json'
                ],
                'http_errors' => false,
                'json' => [
                    'anio' => $anio,
                    'ruc' => $ruc
                ]
            ]);

            // 👀 SI TOKEN EXPIRÓ
            if ($response->getStatusCode() === 401) {
                session()->destroy();
                return redirect()->to(base_url())->send();
                exit;
            }

            $data = json_decode($response->getBody(), true);

            if (!$data || $data['status'] === 'error') {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => $data['message']
                ]);
            }

            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'consulta obtenida correctamente',
                'afp' => $data['afp'],
                'data' => $data['data']
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'no se pudo conectar a la api ' . $e->getMessage()
            ]);
        }
    }

    public function verifyCorreo()
    {

        $id_usuario = session()->get('id_usuario');

        $client = \Config\Services::curlrequest();

        $url = getenv('URL_SERVIDOR') . 'verify-correo/' . $id_usuario;

        $response = $client->get($url, [
            'headers' => [
                'Authorization' => "Bearer " . session()->get('token'),
                'Accept' => 'application/json'
            ],
            'http_errors' => false
        ]);

        // 👀 SI TOKEN EXPIRÓ
        if ($response->getStatusCode() === 401) {
            session()->destroy();
            return redirect()->to(base_url())->send();
            exit;
        }

        $data = json_decode($response->getBody(), true);

        if (!$data || $data['status'] === 'error') {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => $data['message']
            ]);
        }

        return $this->response->setJSON([
            'status' => $data['status'],
            'message' => $data['message']
        ]);
    }

    public function saveCorreo()
    {
        try {
            $id = $this->request->getPost('id');
            $email = $this->request->getPost('emailInput');

            $client = \Config\Services::curlrequest();

            $url = getenv('URL_SERVIDOR') . 'save-correo';

            $response = $client->post($url, [
                'headers' => [
                    'Authorization' => "Bearer " . session()->get('token'),
                    'Accept' => 'application/json'
                ],
                'http_errors' => false,
                'json' => [
                    'id' => $id,
                    'email' => $email
                ]
            ]);

            // 👀 SI TOKEN EXPIRÓ
            if ($response->getStatusCode() === 401) {
                session()->destroy();
                return redirect()->to(base_url())->send();
                exit;
            }

            $data = json_decode($response->getBody(), true);

            if (!$data || $data['status'] === 'error') {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => $data['message']
                ]);
            }

            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'correo guardado correctamente'
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'no se pudo conectar a la api ' . $e->getMessage()
            ]);
        }
    }
}
