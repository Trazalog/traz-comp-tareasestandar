<?php
defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . '/modules/'.TST."reports/Indicadores.php";

class Reportes extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->load->model('Tareas');
    $this->load->model(PRD.'koolreport/Koolreport');
    $this->load->model(PRD.'koolreport/Opcionesfiltros');
  }

  /**
		*Obtiene datos de Usuarios segun empresa 
		**/
  public function obtenerUsuarios()
  {
      log_message("DEBUG", "#TRAZA | #TRAZ-COMP-TAREASESTANDAR | TAREA | obtenerUsuarios() ");
      
      $usuarios = $this->Tareas->obtenerUsuarios();
      echo json_encode($usuarios);
  }
  
  /**
    *Obtiene datos de Clientes segun empresa 
  **/
  public function obtenerClientes()
  {
      log_message("DEBUG", "#TRAZA | #TRAZ-COMP-TAREASESTANDAR | TAREA | obtenerClientes() ");
      
      $clientes = $this->Tareas->obtenerClientes();
      echo json_encode($clientes);
  }
  
  public function indicadores(){

    $data = $this->input->post('data');

    $usuario = $data['usuario'] ? $data['usuario'] : '';
    $cliente = $data['cliente'] ? $data['cliente'] : '';
    $desde = $data['datepickerDesde'] ? date("Y-m-d", strtotime($data['datepickerDesde'])) : '';
    $hasta = $data['datepickerHasta'] ? date("Y-m-d", strtotime($data['datepickerHasta'])) : '';

    // $desde = ($desde) ? date("d-m-Y", strtotime($desde)) : '';
    // $hasta = ($hasta) ? date("d-m-Y", strtotime($hasta)) : '';
    
    log_message('DEBUG', '#TRAZA | #TRAZ-COMP TAREASESTANDAR | #REPORTES | indicadores() | #DESDE: >>' . $desde . '#HASTA: >>' . $hasta);

    $url =  REST_TST."/tareas/kpi/basico/desde/".$desde."/hasta/".$hasta."/usuario/".$usuario."/cliente/".$cliente."/empresa/".empresa();

    $json = $this->Koolreport->depurarJson($url)->tareas->tarea;
    
    $reporte = new Indicadores($json);
    $reporte->run()->render();
  }

  public function salidas(){
    log_message('DEBUG', '#TRAZA | #TRAZ-COMP-TAREASESTANDAR | #REPORTES | salidas() | #INGRESO');
    $data = $this->input->post('data');
    $json = $this->Opcionesfiltros->getSalidas($data);
    $reporte = new Salidas($json);
    $reporte->run()->render();
  }

  public function filtroSalidas(){
    log_message('DEBUG', '#TRAZA | #TRAZ-COMP-TAREASESTANDAR | #REPORTES | filtroSalidas() | #INGRESO');
    $rsp['clientes'] = $this->Opcionesfiltros->getClientes();
    $rsp['transportista'] = $this->Opcionesfiltros->getTransportistas();
    echo json_encode($rsp);
  }
}
