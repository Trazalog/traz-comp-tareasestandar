<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Opcionesfiltros extends CI_Model
{

  function __construct()
  {
    parent::__construct();
    $this->load->helper('wso2_helper');
    $this->load->helper('sesion_helper');
  }

  public function getClientes()
  {
    $url = REST_CORE . '/clientes/porEmpresa/'.empresa().'/porEstado/ACTIVO';
    return wso2($url)['data'];
  }
}
