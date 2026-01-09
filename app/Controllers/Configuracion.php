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

            $response = $client->post($url, [
                'headers' => [
                    'Authorization' => "Bearer $token"
                ],
                'multipart' => [
                    [
                        'name'     => 'imagen',
                        'contents' => fopen($file->getTempName(), 'r'),
                        'filename' => $file->getName(),
                        'headers'  => [
                            'Content-Type' => 'image/png'
                        ]
                    ],
                    [
                        'name'     => 'ruc',
                        'contents' => session()->get('user')['username'] // o la variable que uses
                    ]
                ],
                'http_errors' => false
            ]);

            $result = json_decode($response->getBody(), true);

            if ($result['status'] === true) {
                return $this->response->setJSON([
                    'status' => 'success',
                    'message' => 'Imagen subida correctamente'
                ]);
            } else {
                $msg = 'Error al subir imagen';

                if (isset($result['message']) && is_string($result['message'])) {
                    $msg = $result['message'];
                }

                if (isset($result['errors']) && is_array($result['errors'])) {
                    // Convertir errores en texto legible
                    $msg = implode(' | ', $result['errors']);
                }

                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => $msg
                ]);
            }
        } catch (\Exception $e) {
            var_dump($e);
            exit;
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Error al subir imagen frontend: ' . $e->getMessage()
            ]);
        }
    }
}
