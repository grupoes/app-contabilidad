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
}
