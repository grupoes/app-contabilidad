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

    public function listMonthsFolders()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to(base_url('/'));
        }

        return view('filemanager/months');
    }
}
