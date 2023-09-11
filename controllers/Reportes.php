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
	* Obtiene los valores de los filtros
	* @param array filtros tiposTrabajos y usuarios
	* @return array filtros
	*/
  public function obtenerFiltros(){
    log_message("DEBUG", "#TRAZA | #TRAZ-COMP-TAREASESTANDAR | TAREA | obtenerFiltros() ");
    $url['tiposTrabajos'] = REST_CORE."/tabla/tipos_pedidos_trabajo/empresa/".empresa();

    $filtros['tiposTrabajos'] = $this->Koolreport->depurarJson($url['tiposTrabajos'])->tablas->tabla;      
    $filtros['usuarios'] = $this->Tareas->obtenerUsuarios()->usuarios->usuario;

    echo json_encode($filtros);
  }
  
  /**
	* Obtiene los filtros y renderiza el listado
	* @param array filtros
	* @return array respuesta del servicio
	*/
  public function indicadores(){

    $data = $this->input->post('data');

    $usuario = $data['usuario'] ? $data['usuario'] : '';
    $tipoTrabajo = $data['tipo_trabajo'] ? $data['tipo_trabajo'] : '';
    $estado = $data['estado'] ? $data['estado'] : '';
    $desde = $data['datepickerDesde'] ? date("Y-m-d", strtotime($data['datepickerDesde'])) : '';
    $hasta = $data['datepickerHasta'] ? date("Y-m-d", strtotime($data['datepickerHasta'])) : '';

    // $desde = ($desde) ? date("d-m-Y", strtotime($desde)) : '';
    // $hasta = ($hasta) ? date("d-m-Y", strtotime($hasta)) : '';
    
    log_message('DEBUG', '#TRAZA | #TRAZ-COMP TAREASESTANDAR | #REPORTES | indicadores() | #DESDE: >>' . $desde . '#HASTA: >>' . $hasta);

    $url =  REST_TST."/tareas/kpi/basico/desde/".$desde."/hasta/".$hasta."/usuario/".$usuario."/tipoTrabajo/".$tipoTrabajo."/estado/".$estado."/empresa/".empresa();
    $json = $this->Koolreport->depurarJson($url)->tareas->tarea;
    
    $reporte = new Indicadores($json);
    $reporte->run()->render();
  }

}
