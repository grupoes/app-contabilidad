<?php

namespace App\Controllers;

class FileManager extends BaseController
{
    public function index()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to(base_url('/'));
        }

        return view('filemanager/index');
    }

    public function listFoldersMonths()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to(base_url('/'));
        }

        $folderId = $this->request->getGet('folderId');

        return view('filemanager/foldersFilesMonths', ['folderId' => $folderId]);
    }

    public function verifyYear()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to(base_url('/'));
        }

        $token = session()->get('token');

        $year = date('Y');
        $usuario = session()->get('user')['username'];

        $client = \Config\Services::curlrequest();

        $url = getenv('URL_SERVIDOR') . 'api-verify-name-ruc';

        $response = $client->post($url, [
            'headers' => [
                'Authorization' => "Bearer $token",
                'Accept' => 'application/json'
            ],
            'http_errors' => false,
            'json' => [
                'ruc' => $usuario,
                'year' => $year
            ]
        ]);

        // 👀 SI TOKEN EXPIRÓ
        if ($response->getStatusCode() === 401) {
            session()->destroy();
            return redirect()->to(base_url())->send();
            exit;
        }

        $data = json_decode($response->getBody(), true);

        if (!$data || $data['status'] == 'error') {
            return $this->response->setJSON([
                'status' => $data['status'],
                'message' => $data['message']
            ]);
        }

        return $this->response->setJSON([
            'status' => $data['status'],
            'message' => $data['message']
        ]);
    }

    public function folders()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to(base_url('/'));
        }

        $folderParent = $this->request->getPost('folderParentId');

        $token = session()->get('token');

        $usuario = session()->get('user')['username'];

        $client = \Config\Services::curlrequest();

        $url = getenv('URL_SERVIDOR') . 'folder-google-drive';

        $response = $client->post($url, [
            'headers' => [
                'Authorization' => "Bearer $token",
                'Accept' => 'application/json'
            ],
            'http_errors' => false,
            'json' => [
                'ruc' => $usuario,
                'folderParentId' => $folderParent
            ]
        ]);

        // 👀 SI TOKEN EXPIRÓ
        if ($response->getStatusCode() === 401) {
            session()->destroy();
            return redirect()->to(base_url())->send();
            exit;
        }

        $data = json_decode($response->getBody(), true);

        if (!$data || $data['status'] == 'error') {
            return $this->response->setJSON([
                'status' => $data['status'],
                'message' => $data['message']
            ]);
        }

        return $this->response->setJSON([
            'status' => $data['status'],
            'folders' => $data['folders']
        ]);
    }

    public function foldersMonths($folderId)
    {
        if (!session()->get('logged_in')) {
            return redirect()->to(base_url('/'));
        }

        $token = session()->get('token');

        $client = \Config\Services::curlrequest();

        $url = getenv('URL_SERVIDOR') . 'folder-months/' . $folderId;

        $response = $client->get($url, [
            'headers' => [
                'Authorization' => "Bearer $token",
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

        if (!$data || $data['status'] == 'error') {
            return $this->response->setJSON([
                'status' => $data['status'],
                'message' => $data['message']
            ]);
        }

        return $this->response->setJSON([
            'status' => $data['status'],
            'message' => $data['message']
        ]);
    }

    public function loadFolderMonths($folderId)
    {
        if (!session()->get('logged_in')) {
            return redirect()->to(base_url('/'));
        }

        $token = session()->get('token');

        $usuario = session()->get('user')['username'];

        $client = \Config\Services::curlrequest();

        $url = getenv('URL_SERVIDOR') . 'folder-google-drive';

        $response = $client->post($url, [
            'headers' => [
                'Authorization' => "Bearer $token",
                'Accept' => 'application/json'
            ],
            'http_errors' => false,
            'json' => [
                'ruc' => $usuario,
                'folderParentId' => $folderId
            ]
        ]);

        // 👀 SI TOKEN EXPIRÓ
        if ($response->getStatusCode() === 401) {
            session()->destroy();
            return redirect()->to(base_url())->send();
            exit;
        }

        $data = json_decode($response->getBody(), true);

        if (!$data || $data['status'] == 'error') {
            return $this->response->setJSON([
                'status' => $data['status'],
                'message' => $data['message']
            ]);
        }

        return $this->response->setJSON([
            'status' => $data['status'],
            'foldersMonths' => $data['folders']
        ]);
    }

    public function listFoldersFiles()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to(base_url('/'));
        }

        $folderId = $this->request->getGet('folderId');

        return view('filemanager/foldersFiles', ['folderId' => $folderId]);
    }

    public function createFolder()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to(base_url('/'));
        }

        $folderParent = $this->request->getPost('parentFolderId');
        $folderName = $this->request->getPost('folderName');

        $token = session()->get('token');

        $client = \Config\Services::curlrequest();

        $url = getenv('URL_SERVIDOR') . 'create-folder';

        $response = $client->post($url, [
            'headers' => [
                'Authorization' => "Bearer $token",
                'Accept' => 'application/json'
            ],
            'http_errors' => false,
            'json' => [
                'parentFolderId' => $folderParent,
                'folderName' => $folderName
            ]
        ]);

        // 👀 SI TOKEN EXPIRÓ
        if ($response->getStatusCode() === 401) {
            session()->destroy();
            return redirect()->to(base_url())->send();
            exit;
        }

        $data = json_decode($response->getBody(), true);

        if (!$data || $data['status'] == 'error') {
            return $this->response->setJSON([
                'status' => $data['status'],
                'message' => $data['message']
            ]);
        }

        return $this->response->setJSON([
            'status' => $data['status'],
            'message' => $data['message']
        ]);
    }

    public function foldersFiles($parentFolderId)
    {
        if (!session()->get('logged_in')) {
            return redirect()->to(base_url('/'));
        }

        $token = session()->get('token');

        $client = \Config\Services::curlrequest();

        $url = getenv('URL_SERVIDOR') . 'get-folder-files/' . $parentFolderId;

        $response = $client->get($url, [
            'headers' => [
                'Authorization' => "Bearer $token",
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

        if (!$data || $data['status'] == 'error') {
            return $this->response->setJSON([
                'status' => $data['status'],
                'message' => $data['message']
            ]);
        }

        return $this->response->setJSON([
            'status' => $data['status'],
            'message' => $data['message'],
            'foldersFiles' => $data['foldersFiles']
        ]);
    }

    public function uploadFiles()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to(base_url('/'));
        }

        $folderParentId = $this->request->getPost('folderParentId');
        $token = session()->get('token');
        $ruc = session()->get('user')['username'];

        // Obtener archivos
        $files = $this->request->getFiles();

        if (!isset($files['fileFolder'])) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'No se enviaron archivos'
            ]);
        }

        $url = getenv('URL_SERVIDOR') . 'upload-file-multiples';

        // Datos POST base
        $postData = [
            'ruc' => $ruc,
            'folderParentId' => $folderParentId
        ];

        // Agregar archivos al POST
        foreach ($files['fileFolder'] as $index => $file) {
            if ($file->isValid() && !$file->hasMoved()) {
                $postData["files[$index]"] = new \CURLFile(
                    $file->getTempName(),
                    $file->getMimeType(),
                    $file->getName()
                );
            }
        }

        try {
            // Inicializar cURL
            $ch = curl_init($url);

            curl_setopt_array($ch, [
                CURLOPT_POST           => true,
                CURLOPT_POSTFIELDS     => $postData,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HTTPHEADER     => [
                    "Authorization: Bearer $token"
                ],
                CURLOPT_SSL_VERIFYPEER => false, // solo si no tienes SSL válido
            ]);

            $response = curl_exec($ch);

            // Error cURL
            if ($response === false) {
                $error = curl_error($ch);
                curl_close($ch);

                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Error cURL: ' . $error
                ]);
            }

            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            $result = json_decode($response, true);

            if ($httpCode === 200 && isset($result['status']) && $result['status'] === 'success') {
                return $this->response->setJSON([
                    'status' => 'success',
                    'message' => $result['message']
                ]);
            }

            return $this->response->setJSON([
                'status'  => 'error',
                'message' => $result['message'] ?? 'Error al subir archivos',
                'debug'   => $result
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Excepción: ' . $e->getMessage()
            ]);
        }
    }
}
