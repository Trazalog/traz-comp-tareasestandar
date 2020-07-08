<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Sectores extends CI_Model
{
  public function obtener()
  {
      $url = MOCK.'/sectores';
      $rsp = $this->rest->callAPI('GET', $url);
      if($rsp['status']){
          $rsp['data'] = json_decode($rsp['data'])->sectores->sector;
      }
      return $rsp;
  }
}
