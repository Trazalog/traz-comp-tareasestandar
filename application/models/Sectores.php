<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Sectores extends CI_Model
{
  public function obtener()
  {
      $url = REST_TST.'sectores';
      $rsp = $this->rest->callAPI('GET', $url);
      if($rsp['status']){
          $rsp['data'] = json_decode($rsp['data'])->sectores->sector;

          foreach ($rsp['data'] as $key => $o) {
            
               $rsp['data'][$key]->equipos = $o->equipos->equipo; 

          }
      }
      return $rsp;
  }
}
