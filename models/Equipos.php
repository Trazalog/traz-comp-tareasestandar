<?php defined('BASEPATH') or exit('No direct script access allowed');

class Equipos extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function obtener($sectId)
    {
        $url = REST_CORE."/equipos/sector/$sectId";
        return wso2($url);
    }
}
