<?php defined('BASEPATH') or exit('No direct script access allowed');

class Tarea extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Tareas');
    }

    public function crear()
    {
        $this->load->view('crear');
    }

    public function index()
    {
        $data['tareas'] = $this->Tareas->obtener()['data'];
        $data['plantillas'] = $this->Tareas->obtenerPlantillas()['data'];
        $this->load->view('tareas/dash', $data);
        $this->load->view('tareas/subtareas');
        $this->load->view('tareas/plantillas');
    }

    public function tabla()
    {
        $data['tareas'] = $this->Tareas->obtener()['data'];
        $this->load->view('tareas/tabla', $data);
    }

    public function guardar($id = false)
    {
        $data = $this->input->post('data');

        if ($id) {
            $rsp = $this->Tareas->editar($id, $data);
        } else {
            $rsp = $this->Tareas->guardar($data);
        }

        echo json_encode($rsp);
    }

    public function eliminar($id)
    {
        $rsp = $this->Tareas->eliminar($id);
        echo json_encode($rsp);
    }
    public function guardarSubtarea()
    {
        $data = $this->input->post('data');
        $rsp = $this->Tareas->guardarSubtarea($data);
        echo json_encode($rsp);
    }

    public function tablaSubtareas($id)
    {
        $data['tare_id'] = $id;
        $data['subtareas'] = $this->Tareas->obtenerSubtareas($id)['data'];
        $this->load->view('tareas/tabla_subtareas', $data);
    }

    public function eliminarSubtarea($id)
    {
        $rsp = $this->Tareas->eliminarSubtarea($id);
        echo json_encode($rsp);
    }

    public function guardarPlantilla()
    {
        $data = $this->input->post('data');
        $rsp = $this->Tareas->guardarPlantilla($data);
        echo json_encode($rsp);
    }

    public function eliminarPlantilla($id)
    {
        $rsp = $this->Tareas->eliminarPlantilla($id);
        echo json_encode($rsp);
    }

    public function tablaPlantillas()
    {
        $data['plantillas'] = $this->Tareas->obtenerPlantillas()['data'];
        $this->load->view('tareas/tabla_plantillas', $data);
    }

}
