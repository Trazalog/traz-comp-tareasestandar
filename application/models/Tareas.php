<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Tareas extends CI_Model
{
    private $recurso = REST_TST . 'tareas';

    public function __construct()
    {
        parent::__construct();

    }

    public function obtener($id = false)
    {
        $rsp = $this->rest->callAPI('GET', $this->recurso . ($id ? "/$id" : '') . '/' . empresa());
        if ($rsp['status']) {
            $aux = json_decode($rsp['data']);
            if (isset($aux->tareas->tarea)) {
                $rsp['data'] = json_decode($rsp['data'])->tareas->tarea;
            } else {
                $rsp['data'] = [];
            }

        }

        return $rsp;
    }

    public function guardar($data)
    {
        $data['empr_id'] = strval(empresa());
        $post['post_tarea'] = $data;
        $rsp = $this->rest->callAPI('POST', $this->recurso, $post);
        return $rsp;
    }

    public function guardarSubtarea($data)
    {
        $post['post_subtarea'] = $data;
        $rsp = $this->rest->callAPI('POST', REST_TST . "subtareas", $post);
        return $rsp;
    }

    public function obtenerPlantillas()
    {
        $rsp = $this->rest->callAPI('GET', REST_TST . 'plantillas/' . empresa());
        if ($rsp['status']) {
            $aux = json_decode($rsp['data']);
            if (isset($aux->plantillas->plantilla)) {
                $rsp['data'] = json_decode($rsp['data'])->plantillas->plantilla;
            } else {
                $rsp['data'] = [];
            }

        }

        return $rsp;
    }

    public function guardarPlantilla($data)
    {
        if (isset($data['plan_id'])) {
            $post['post_plantilla'] = $data;
            $rsp = $this->rest->callAPI('PUT', REST_TST . "plantillas", $post);
        } else {
            $data['empr_id'] = strval(empresa());
            $post['post_plantilla'] = $data;
            $rsp = $this->rest->callAPI('POST', REST_TST . "plantillas", $post);
        }
        return $rsp;
    }

    public function obtenerTareasPlantilla($id)
    {
        $rsp = $this->rest->callAPI('GET', REST_TST . "plantillas/tareas/$id");
        if ($rsp['status']) {
            $aux = json_decode($rsp['data']);
            if (isset($aux->tareas->tarea)) {
                $rsp['data'] = json_decode($rsp['data'])->tareas->tarea;
            } else {
                $rsp['data'] = [];
            }

        }

        return $rsp;
    }

    public function asociarTareaPlantilla($data)
    {
        $post['post_plantillas_tareas'] = $data;
        $rsp = $this->rest->callAPI('POST', REST_TST . "plantillas/tareas", $post);
        return $rsp;
    }

    public function eliminarTareaPlantilla($data)
    {
        $post['delete_plantillas_tareas'] = $data;
        $rsp = $this->rest->callAPI('DELETE', REST_TST . "plantillas/tareas", $post);
        return $rsp;
    }

    public function eliminarPlantilla($id)
    {
        $data['delete_plantilla']['plan_id'] = $id;
        $rsp = $this->rest->callAPI('DELETE', REST_TST . "plantillas", $data);
        return $rsp;
    }

    public function obtenerSubtareas($id)
    {
        $rsp = $this->rest->callAPI('GET', REST_TST . "subtareas/$id");
        if ($rsp['status']) {
            $aux = json_decode($rsp['data']);
            if (isset($aux->subtareas->subtarea)) {
                $rsp['data'] = json_decode($rsp['data'])->subtareas->subtarea;
            } else {
                $rsp['data'] = [];
            }

        }
        return $rsp;
    }

    public function eliminarSubtarea($id)
    {
        $data['delete_subtarea']['suta_id'] = $id;
        $rsp = $this->rest->callAPI('DELETE', REST_TST . "subtareas", $data);
        return $rsp;
    }

    public function editar($id, $data)
    {
        $data['tare_id'] = $id;
        $put['put_tarea'] = $data;
        $rsp = $this->rest->callAPI('PUT', $this->recurso, $put);
        return $rsp;
    }

    public function eliminar($id)
    {
        $data['delete_tarea']['tare_id'] = $id;
        $rsp = $this->rest->callAPI('DELETE', $this->recurso, $data);
        return $rsp;
    }

    public function guardarPlanificada($data)
    {
       $data = $this->map($data);

        if (!isset($data['tapl_id'])) {
            $post['post_tarea_planificar'] = $data;
            $rsp = $this->rest->callAPI('POST', REST_TST . "tarea/planificar", $post);
            if($rsp['status']){
                $rsp['data'] = json_decode($rsp['data']);
            }
        } else {
            $post['put_tarea_planificar'] = $data;
            $rsp = $this->rest->callAPI('PUT', REST_TST . "tarea/planificar", $post);
        }
        return $rsp;
    }

    function map($tarea){

        $data['tapl_id'] = isset($data['tabl_id'])?$data['tabl_id']:"0";
        $data['nombre'] = $tarea['nombre'];
        $data['tare_id'] = $tarea['tare_id'];
        $data['fecha'] = format($data['fecha']);

        return $tarea;

    }

}
