<?php defined('BASEPATH') or exit('No direct script access allowed');

class Tarea extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function crear()
    {
        $this->load->view('crear');
    }

    public function index()
    {
        $data['tareas'] = getJson('tareas')->tareas;
        #$data['subtareas'] = getJson('tareas')->subtareas;
        #$data['plantillas'] = getJson('tareas')->plantillas;
        $this->load->view('tareas/dash', $data);
    }
}
