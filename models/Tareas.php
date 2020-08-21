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
        $res = $this->lanzarProceso($data);
        if($res){
            $data['case_id'] = (string) $res->payload->caseId;
        }

        $post['_post_tarea_planificar'] = $this->map($data);
        $rsp = $this->rest->callAPI('POST', REST_TST . "tarea/planificar", $post);
        if ($rsp['status']) {
            $rsp['data'] = json_decode($rsp['data']);
            $data['origen']['tapl_id'] = $rsp['data']->respuesta->tapl_id;
            $this->asignarOrigen($data['origen']);
            #Guardar Recursos Trabajo
            if (isset($data['equipos'])) {
                $this->asignarRecursos($data['tapl_id'], $data['equipos']);
            }
        }

        return $rsp;
    }

    public function lanzarProceso($tarea)
    {
        #Validacion de Lanzar Proceso
        if (isset($tarea['fecha']) && ($tarea['fecha'] != '3000-12-31+00:00') && isset($tarea['nombre']) && isset($tarea['user_id']) && isset($tarea['tapl_id'])) {
            $contract['nombre_proceso'] = 'TST01';
            $contract['session'] = $this->session->has_userdata('bpm_token') ? $this->session->userdata('bpm_token') : '';
            $contract['payload']['nombreTarea'] = $tarea['nombre'];
            $contract['payload']['userNick'] = $tarea['user_id'];
            $contract['payload']['taplId'] = $tarea['tapl_id'];
            $res = wso2(REST_API_BPM, 'POST', $contract);
            return $res['data'];
        }
    }

    public function asignarOrigen($data)
    {
        if($data['orta_id'] != "0"){
            $post['_post_tarea_origen'] = $data;
            $url = REST_TST . 'tarea/origen';
            $rsp = $this->rest->callApi('POST', $url, $post);
            return $rsp;
        }
    }

    public function map($data)
    {
        $aux = array();
        $aux['nombre'] = $data['nombre'];
        $aux['fecha'] = (isset($data['fecha']) && $data['fecha'] != "0031-01-01+00:00") ? format($data['fecha']) : '3000-12-31';
        $aux['info_id'] = isset($data['info_id']) ? $data['info_id'] : '0';
        $aux['tare_id'] = isset($data['tare_id']) ? $data['tare_id'] : '0';
        $aux['case_id'] = isset($data['case_id']) ? $data['case_id'] : '0';
        $aux['user_id'] = isset($data['user_id']) ? $data['user_id'] : '0';
        $aux['tapl_id'] = isset($data['tapl_id']) ? $data['tapl_id'] : "";

        return $aux;
    }

    public function eliminarPlanificada($id)
    {
        $delete['delete_tarea_planificar']['tapl_id'] = $id;
        $url = REST_TST . 'tarea/planificar';
        $rsp = $this->rest->callApi('DELETE', $url, $delete);
        return $rsp;
    }

    public function asignarRecursos($tapl_id, $equipos)
    {
        $rb[] = $this->eliminarRecursos($tapl_id);

        $rec = '_post_tarea_recursos';
        foreach ($equipos as $o) {
            $data[$rec . '_batch_req'][$rec][] = array(
                'tapl_id' => $tapl_id,
                'recu_id' => $o['recu_id'],
            );
        }

        $rb[] = $data;

        $rsp = requestBox(REST_TST, $rb);

        return $rsp;
    }

    public function eliminarRecursos($tapl_id)
    {
        $rec = '_delete_tarea_recursos';

        $data[$rec] = array(
            "tapl_id" => $tapl_id,
        );

        return $data;
    }

    public function obtenerPlanificadas($origen, $orta_id)
    {
        $url = REST_TST . "tareas/planificar/$origen/$orta_id";
        $rsp = $this->rest->callApi('GET', $url);
        if ($rsp['status']) {
            $rsp['data'] = $this->mapRespuesta(json_decode($rsp['data'])->tareas->tarea);
        }
        return $rsp;
    }

    public function mapRespuesta($data)
    {
        foreach ($data as $key => $o) {

            $rec = isset($o->recursos->recurso) ? $o->recursos->recurso : false;
            if (!$rec) {
                continue;
            }

            unset($data[$key]->recursos);

            foreach ($rec as $ro) {

                if ($ro->tipo == "TRABAJO") {

                    $data[$key]->equipos[] = array('recu_id' => $ro->recu_id, 'codigo' => $ro->codigo);

                }
            }

        }
        return $data;
    }

    public function obtenerXCaseId($caseId)
    {
        $url = REST_TST."tareas/planificadas/case/$caseId";
        return wso2($url);
    }

}
