<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Log extends BaseController
{
    public function __construct()
    {
        helper('form');
        $this->validation = \Config\Services::validation();
        $this->session = session();
    }
    public function index()
    {
        $logModel = new \App\Models\LogModel();

        $data = [
            'log' => $logModel->orderBy('change_date', 'DESC')->paginate(10),
            'pager' => $logModel->pager,
        ];
        return view('log/index', [
            'data' => $data,
            'title' => 'Log Data'
        ]);
    }
    public function logTanggal()
    {
        if ($this->request->getPost('datepicker') != '') {
            $date = $this->request->getPost('datepicker');
            $logModel = new \App\Models\LogModel();

            if ($this->request->getPost('opt') == 'month') {
                $start = date("Y-m-d", strtotime($date));
                $end = date("Y-m-t", strtotime($date));
            } else  if ($this->request->getPost('opt') == 'date') {
                $start = $date;
                $end = $date;
            } else if ($this->request->getPost('opt') == 'week') {
                $start = date("Y-m-d", strtotime($date));
                $end = date('Y-m-d', strtotime($start . " +7 days"));
            }


            $data = [
                'log' => $logModel->where("change_date BETWEEN '$start' AND '$end'")->orderBy('change_date', 'DESC')->paginate(10),
                'pager' => $logModel->pager,
            ];
            return view('log/index', [
                'data' => $data,
                'title' => 'Log Data'
            ]);
        } else {
            return redirect()->to('Log/index');
        }
    }
}
