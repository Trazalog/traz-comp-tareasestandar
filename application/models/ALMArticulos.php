<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class ALMArticulos extends CI_Model
{
  public function obtener()
  {
    $url = REST_ALM . 'articulos/'. empresa();
    $rsp = $this->rest->callApi('GET', $url);
    if($rsp['status']){
      $rsp['data'] = json_decode($rsp['data']);
      $rsp['data'] = isset($rsp['data']->articulos->articulo)?$rsp['data']->articulos->articulo:[];
    }
    return $rsp;
  }
}
