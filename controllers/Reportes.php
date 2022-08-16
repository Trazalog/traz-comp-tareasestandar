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
  public function obtenerFiltros(){
    log_message("DEBUG", "#TRAZA | #TRAZ-COMP-TAREASESTANDAR | TAREA | obtenerFiltros() ");
      
    $usuarios = $this->Tareas->obtenerUsuarios();
    $tiposTrabajos = $this->Opcionesfiltros->obtenerTiposTrabajos();
    echo json_encode($usuarios);
  }
  
  /**
	* Obtiene los filtros y renderiza el listado
	* @param array filtros
	* @return array respuesta del servicio
	*/
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

}
