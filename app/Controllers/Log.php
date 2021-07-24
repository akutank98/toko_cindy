<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Log extends Controller
{
    public function __construct()
    {
        $this->validation = \Config\Services::validation();
        $this->session = session();
    }
    public function index()
    {
        $logModel = new \App\Models\LogModel();

        $data = [
            'log' => $logModel->paginate(10),
            'pager' => $logModel->pager,
        ];
        return view('log/index', [
            'data' => $data,
        ]);
    }
}
