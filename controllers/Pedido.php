<?php defined('BASEPATH') or exit('No direct script access allowed');

class Pedido extends CI_Controller
{
    public function verDetalle($pema_id = false)
    {
        $this->load->model('ALMArticulos');
        $data['articulos'] = $this->ALMArticulos->obtener()['data'];
        $this->load->view('pedidos/detalle', $data);
    }

    public function xTarea($taplId)
    {
        $this->load->model('Pedidos');
        $data['pedidos'] = $this->Pedidos->obtenerXTarea($taplId);
        $this->load->view(TST.'pedidos/lista_pedidos', $data);
    }

    public function detalle($pemaId)
    {
        $this->load->model('Pedidos');
        $data['detalle'] = $this->Pedidos->obtenerDetalle($pemaId);
        $this->load->view(TST.'pedidos/lista_detalle', $data);
       
    }

    public function guardar($taplId)
    {
        $this->load->model('Pedidos');
        $data = $this->input->post();
        $rsp = $this->Pedidos->guardar($data);
        if($rsp) $rsp = $this->Pedidos->asociarTarea($taplId, $rsp['data']);
        echo json_encode($rsp);
    }

    public function verReceta($receId)
    {
        $this->load->model(PRD.'general/Formulas');
        $data['receta'] = $this->Formulas->getReceta($receId);
        $data['artisReceta'] = $this->Formulas->getArticulosReceta($receId)->articulos->articulo;
        $this->load->view(TST.'pedidos/receta', $data);
    }

    public function guardarPedidoReceta()
    {   
        $this->load->model('Pedidos');
        $data = $this->input->post('pedido');
        $batchId = $this->input->post('batch_id');
        $res = $this->Pedidos->pedidoMateriales($data, $batchId);
        echo json_encode($res);
    }

    public function asociarTare()
    {
        $data = $this->input->post();
        $rsp = $this->Pedidos->asociarTarea($data);
        echo json_encode($rsp);
    }

}
