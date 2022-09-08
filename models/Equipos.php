<?php defined('BASEPATH') or exit('No direct script access allowed');

class Equipos extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    /**
	* Obtiene los equipos asociados a un sector
	* @param integer sectId
	* @return array respuesta del servicio
	*/
    public function obtener($sectId){
        log_message('DEBUG', '#TRAZA | #TRAZ-COMP-TAREASESTANDAR | Equipos | obtener($sectId)');
        $url = REST_CORE."/equipos/sector/$sectId";
        return wso2($url);
    }
}
