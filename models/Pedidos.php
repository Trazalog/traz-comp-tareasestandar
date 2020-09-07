<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Pedidos extends CI_Model
{
    public function obtener($pema_id)
    {
        $url = REST_ALM . "pedidos/$pema_id/" . empresa();
        $rsp = $this->rest->callApi('GET', $url);
        if ($rsp['status']) {
            $rsp['data'] = json_decode($rsp['data'])->pedidos->pedido[0];

            if (isset($rsp['data']->detalles->detalle)) {
                $rsp['data']->detalles = $rsp['data']->detalles->detalle;
            }

        }
        return $rsp;
    }

    public function guardar($data)
    {
        
        $post['_post_pedidos'] = $this->map($data['pedido']);
        $url = REST_ALM . 'pedidos';
        $rsp = $this->rest->callApi('POST', $url, $post);

        if ($rsp['status']) {
            $pema_id = json_decode($rsp['data'])->respuesta->pema_id;
        }

        $rsp = $this->guardarDetalle($pema_id, $data['detalle']);

        if($rsp)
        {
            $this->lanzarPedidoEtapa($pema_id);
        }

        return $rsp;
    }

    public function map($data)
    {
        return array(
            "justificacion" => isset($data['justificacion']) ? $data['justificacion'] : '',
            "fecha" => date('Y-m-d H:i'),
            "case_id" => isset($data['case_id']) ? $data['case_id'] : '0',
            "estado" => isset($data['case_id']) ? 'Solicitado' : 'Pendiente',
            "batch_id" => isset($data['batch_id']) ? $data['batch_id'] : '0',
            "empr_id" => strval(empresa()),
        );
    }

    public function guardarDetalle($pema_id, $data)
    {
        $this->eliminarDetalle($pema_id);
        $rec = '_post_pedidos_detalle';
        foreach ($data as $o) {
            $post[$rec . "_batch_req"][$rec][] = $this->mapDetalle($pema_id, $o);
        }

        $url = REST_ALM . 'pedidos/detalle_batch_req';
        $rsp = $this->rest->callApi('POST', $url, $post);
        if ($rsp['status']) {
            $rsp['data'] = $pema_id;
        }
        return $rsp;
    }

    public function eliminarDetalle($pema_id)
    {
        $data['_delete_pedidos_detalle']['pema_id'] = $pema_id;
        $url = REST_ALM . 'pedidos/detalle';
        $rsp = $this->rest->callApi('DELETE', $url, $data);
        return $data;
    }

    public function mapDetalle($pema_id, $data)
    {
        return array(
            "pema_id" => $pema_id,
            "cantidad" => $data['cantidad'],
            "arti_id" => $data['arti_id'],
        );
    }

    public function pedidoMateriales($dataPedido, $batchId)
    {
        $this->load->model('general/Etapas');
        $arrayPost['fecha'] = date('Y-m-d');
        $arrayPost['empr_id'] = (string) empresa();
        $arrayPost['batch_id'] = strval($batchId);

        $cab['_post_notapedido'] = $arrayPost;
        $response = $this->Etapas->setCabeceraNP($cab);
        $pema_id = $response->nota_id->pedido_id;

        if (!$pema_id) {
            log_message('ERROR', 'Error en generación de Cabecera Pedido Materiales. pema_id: >>' . $pema_id);
            echo ("Error en generacion de Cabecera Pedido Materiales");
            return;
        }

        $dataPedido = toStd($dataPedido);
        $aux = array();
        foreach ($dataPedido as $o) {
            $pedido['pema_id'] = strval($pema_id);
            $pedido['arti_id'] = $o->arti_id;
            $pedido['cantidad'] = $o->cantidad;
            $aux['_post_notapedido_detalle_batch_req']['_post_notapedido_detalle'][] = $pedido;
        }
        $rsp = $this->Etapas->setDetaNP($aux);
        if ($rsp == 202) {
            $this->lanzarPedidoEtapa($pema_id);
        }
        return $rsp;
    }

    public function lanzarPedidoEtapa($pema_id)
    {
        log_message("DEBUG", __METHOD__ . " | Pedidos Receta >> pema_id: $pema_id");

        $contract['pIdPedidoMaterial'] = $pema_id;

        $rsp = $this->bpm->lanzarProceso(BPM_PROCESS_ID_PEDIDOS_NORMALES, $contract);

        if (!$rsp['status']) {
            log_message('ERROR', __METHOD__ . ' >> Error al lanzar pedido');
            return $rsp;
        }

        $this->load->model(ALM . 'Notapedidos');
        $rsp = $this->Notapedidos->setCaseId($pema_id, $rsp['data']['caseId']);

        // AVANZA PROCESO A TAREA SIGUIENTE
        if (PLANIF_AVANZA_TAREA) {
            $this->aceptarPedidoMateriales($rsp['data']['caseId']);
        }

        return $rsp;
    }

    public function aceptarPedidoMateriales($case_id)
    {
        $taskId = $this->bpm->ObtenerTaskidXNombre(BPM_PROCESS_ID_PEDIDOS_NORMALES, $case_id, 'Aprueba pedido de Recursos Materiales');

        if ($taskId) {
            $user = userId();
            $resultSetUsuario = $this->bpm->setUsuario($taskId, $user);
            $contract["apruebaPedido"] = true;

            if ($resultSetUsuario['status']) {
                $resulCerrar = $this->bpm->cerrarTarea($taskId, $contract);
                return;
            }
        }
    }

    public function obtenerXTarea($taplId)
    {
        $url = REST_ALM."pedidos/tareas/$taplId";
        return wso2($url);
    }

    public function obtenerDetalle($pemaId)
    {   
        $url = REST_ALM."pedidos/detalle/$pemaId";
        return wso2($url);
    }

    public function asociarTarea($taplId, $pemaId)
    {
        $data['pema_id'] = $pemaId;
        $data['tapl_id'] = $taplId;

        $post['_post_pedidos_tareas'] = array_map('strval',$data);
        $url = REST_ALM.'pedidos/tareas';
        return wso2($url, 'POST', $post);   
    }
}
