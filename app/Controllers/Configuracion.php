<?php

namespace App\Controllers;

class Configuracion extends BaseController
{
    public function selloFirma()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to(base_url('/'));
        }

        return view('configuracion/selloFirma');
    }

    public function uploadSelloFirma()
    {
        try {
            $file = $this->request->getFile('imagen');

            if (!$file || !$file->isValid()) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'No se ha subido ningún archivo o el archivo es inválido'
                ]);
            }

            $client = \Config\Services::curlrequest();

            $url = getenv('URL_SERVIDOR') . "upload-sello-firma";

            $token = session()->get('token');

            // Archivo para cURL
            $cfile = new \CURLFile(
                $file->getTempName(),
                $file->getMimeType(),   // image/png, image/jpeg, etc
                $file->getName()
            );

            // Datos POST
            $postData = [
                'imagen' => $cfile,
                'ruc'    => session()->get('user')['username']
            ];

            // Inicializar cURL
            $ch = curl_init($url);

            curl_setopt_array($ch, [
                CURLOPT_POST           => true,
                CURLOPT_POSTFIELDS     => $postData,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HTTPHEADER     => [
                    "Authorization: Bearer $token"
                ],
                CURLOPT_SSL_VERIFYPEER => false, // solo si tu servidor no tiene SSL válido
            ]);

            $response = curl_exec($ch);

            // Capturar errores de cURL
            if ($response === false) {
                $error = curl_error($ch);
                curl_close($ch);

                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Error en cURL: ' . $error
                ]);
            }

            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            // Decodificar respuesta
            $result = json_decode($response, true);

            if ($httpCode === 200 && isset($result['status']) && $result['status'] === 'success') {
                return $this->response->setJSON([
                    'status' => 'success',
                    'message' => 'Imagen subida correctamente'
                ]);
            }

            return $this->response->setJSON([
                'status'  => 'error',
                'message' => $result['message'] ?? 'Error al subir imagen',
                'debug'   => $response
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Error al subir imagen frontend: ' . $e->getMessage()
            ]);
        }
    }

    public function getSelloFirma()
    {
        try {
            $ruc = session()->get('user')['username'];

            $client = \Config\Services::curlrequest();

            $url = getenv('URL_SERVIDOR') . 'get-sello-firma/' . $ruc;

            $response = $client->get($url, [
                'headers' => [
                    'Authorization' => "Bearer " . session()->get('token'),
                    'Accept' => 'application/json'
                ]
            ]);

            $data = json_decode($response->getBody(), true);

            if (!$data || empty($data['status'])) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'No se pudo obtener el sello y firma'
                ]);
            }

            $url_image = getenv('URL_BASE') . "archivos/sellos/" . $data['filename'];

            return $this->response->setJSON([
                'status' => 'success',
                'link' => $url_image
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Error al obtener el sello y firma: ' . $e->getMessage()
            ]);
        }
    }
}
