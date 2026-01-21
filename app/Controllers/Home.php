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
                'json' => [
                    'usuario' => $usuario,
                ]
            ]);

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
            'json' => [
                'usuario' => $usuario,
                'ruc' => $ruc,
                'anio' => $anio,
                'mes' => $mes
            ]
        ]);

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
            'json' => [
                'usuario' => $usuario,
                'boleta_id' => $boletaId
            ]
        ]);

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
                'json' => [
                    'mes_inicial' => $mesInicial,
                    'ruc' => $ruc,
                    'anio' => $anio,
                    'mes_final' => $mesFinal
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
}
