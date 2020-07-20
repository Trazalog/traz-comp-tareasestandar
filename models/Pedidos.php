<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Pedidos extends CI_Model
{
    public function obtener($pema_id)
    {
        $url = REST_ALM . "pedidos/$pema_id/" . empresa();
        $rsp = $this->rest->callApi('GET', $url);
        if($rsp['status']){
            $rsp['data'] = json_decode($rsp['data'])->pedidos->pedido[0];
           
                
            if(isset($rsp['data']->detalles->detalle)){
                $rsp['data']->detalles = $rsp['data']->detalles->detalle;
            }

            
        }
        return $rsp;
    }

    public function guardar($pema_id, $data)
    {
        if (!$pema_id) {
            $post['_post_pedidos'] = $this->map($data['pedido']);
            $url = REST_ALM . 'pedidos';
            $rsp = $this->rest->callApi('POST', $url, $post);

            if ($rsp['status']) {
                $pema_id = json_decode($rsp['data'])->respuesta->pema_id;
            }
        }

        $rsp = $this->guardarDetalle($pema_id, $data['detalle']);
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
            "empr_id" => strval(empresa())
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
        if($rsp['status']){
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

}
