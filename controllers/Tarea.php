<?php defined('BASEPATH') or exit('No direct script access allowed');

class Tarea extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Tareas');
        $this->load->model('Sectores');
    }

    public function planificar($origen, $orta_id)
    {
        $data['origen'] = array('orta_id' => $orta_id, 'origen' => $origen);
        $data['tareas'] = $this->Tareas->obtener()['data'];
        $data['plantillas'] = $this->Tareas->obtenerPlantillas()['data'];
        $data['usuarios'] = $this->obtenerUsuarios()->usuarios->usuario;
        $data['sectores'] = $this->Sectores->obtener()['data'];

        $data['tareas_planificadas'] =  $this->Tareas->obtenerPlanificadas($origen, $orta_id)['data'];
        $this->load->view('tareas/planificacion', $data);
    }

    public function obtener()
    {
        $data  = $this->Tareas->obtener();
        echo json_encode($data);
    }

    public function guardarPlanificada()
    {
        $data = $this->input->post();
        $res = $this->Tareas->guardarPlanificada($data);
        echo json_encode($res);
    }

    public function eliminarPlanificada($id)
    {
       $rsp = $this->Tareas->eliminarPlanificada($id);
       echo json_encode($rsp);
    }

    public function obtenerUsuarios()
    {
        return json_decode(
            '{
                "usuarios":{
                    "usuario":[
                        {
                            "user_id":"ad.min",
                            "nombre":"Anastasia",
                            "apellido":"Diaz",
                            "img":"lib/dist/img/user2-160x160.jpg"
                        },
                        {
                            "user_id":"ad.min1",
                            "nombre":"Kimberli",
                            "apellido":"Ruterford",
                            "img":"lib/dist/img/user2-160x160.jpg"
                        },
                        {
                            "user_id":"ad.min2",
                            "nombre":"Roberto",
                            "apellido":"Bueno",
                            "img":"lib/dist/img/user2-160x160.jpg"
                        }
                    ]
                }
            }'
        );
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

    public function guardarPlantilla($id = false)
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

    public function tablaTareasPlantilla($id)
    {
        $data['id'] = $id;
        $data['tareas_plantilla'] = $this->Tareas->obtenerTareasPlantilla($id)['data'];
        $this->load->view('tareas/tabla_tareas_plantilla',$data);
    }

    public function asociarTareaPlantilla()
    {
        $data = $this->input->post();
        $res = $this->Tareas->asociarTareaPlantilla($data);
        echo json_encode($res);
    }

    public function eliminarTareaPlantilla()
    {
        $data = $this->input->post();
        $res = $this->Tareas->eliminarTareaPlantilla($data);
        echo json_encode($res);
    }

    public function obtenerEquiposXSector($sectId)
    {
        $this->load->model(TST.'Equipos');
        $rsp = $this->Equipos->obtener($sectId);
        echo json_encode($rsp);
    }

}
