<?php defined('BASEPATH') or exit('No direct script access allowed');

class Pedido extends CI_Controller
{
    public function verDetalle($pema_id = 660)
    {
        $this->load->model('ALMArticulos');
        $data['articulos'] = $this->ALMArticulos->obtener()['data'];

        if ($pema_id) {
            $this->load->model('Pedidos');
            $data['pedido'] = $this->Pedidos->obtener($pema_id)['data'];
        }
        $this->load->view('pedidos/detalle', $data);
    }

    public function guardar($pema_id = false)
    {
        $this->load->model('Pedidos');
        $data = $this->input->post();
        $rsp = $this->Pedidos->guardar($pema_id, $data);
        echo json_encode($rsp);
    }
}
