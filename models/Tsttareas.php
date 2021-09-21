<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Tsttareas extends CI_Model
{
    public function __construct()
    {
        parent::__construct();

    }

    public function map($tarea)
    {
        $this->load->model(TST.'/Tareas');
        $data = $this->Tareas->obtenerXCaseId($tarea->caseId)['data'][0];
        
        $array['descripcion'] = $data->descripcion;
        $array['nombreTarea'] = $data->nombre;
        $array['nombreProceso'] = "Tarea Planificada";
        
        
        $aux = new StdClass();
        $aux->color = 'primary';
        $aux->texto = "Estado: " . ucfirst($data->estado);
        $array['info'][] = $aux;

        $origen = new StdClass();
        $id = new StdClass();
        $nro = new StdClass();
        
        $origen->color = 'primary';
        $id->color = 'primary';
        $nro->color = 'primary';

        //Display del Origen en bandeja
        switch ($data->origen) {
            case 'PETR':
                $pedido = $this->getPedidoTrabajo($data->orta_id);
                
                $origen->texto = "Origen: Pedido de trabajo";
                $id->texto = "Id Ped.Trabajo: $data->orta_id";
                $nro->texto = "Nro Pedido: ".($pedido) ? $pedido->cod_proyecto : "";

                break;
            case 'BATCH':
                $lote = $this->getLote($data->orta_id);

                $origen->texto = "Origen: Producción de Lotes";
                $id->texto = "Batch:  $data->orta_id";
                $nro->texto = "Nro Lote: ".($lote) ? $lote->lote : "";

                break;
            case 'ETAP':
                $origen->texto = "Origen: Etapas";
                break;
            default:
                $origen->texto = "Origen: $data->origen";
                $id->texto = "ID: $data->orta_id";
                $nro->texto = "Nro de Pedido: ";
                break;
        }
        $array['info'][] = $origen;
        $array['info'][] = $id;
        $array['info'][] = $nro;
        
        $aux = new StdClass();
        $aux->color = 'primary';
        $aux->texto = "Asignado: $data->user_id";
        $array['info'][] = $aux;

        $aux = new StdClass();
        $aux->color = 'default';
        $aux->texto = "Fecha: ".formatFechaPG($data->fecha);
        $array['info'][] = $aux;

        return $array;
    }

    public function desplegarVista($tarea)
    {
        $this->load->model(TST.'/Tareas');
        $data = $this->Tareas->obtenerXCaseId($tarea->caseId)['data'][0];
        switch ($tarea->nombreTarea) {
            default:
                return $this->load->view(TST.'proceso/tarea_generica', $data, true);
                break;
        }
    }

    public function getContrato($tarea, $form)
    {
        switch ($tarea->nombreTarea) {
            default:
     
                break;
        }
    }

    public function desplegarCabecera($tarea)
    {
        $this->load->model(TST.'/Tareas');
        $this->load->model(PRD.'general/Etapas');
        $data['tarea'] = $this->Tareas->obtenerXCaseId($tarea->caseId)['data'][0];
        $data['etapa'] = $this->Etapas->buscar($data['tarea']->orta_id)->etapa;
        return $this->load->view(TST.'proceso/cabecera_tarea', $data, true);
    }

    /**
	* Obtiene los datos del pedido de trabajo
	* @param $petr_id
	* @return array datos del petr_id especificado
	*/
    public function getPedidoTrabajo($petr_id){
        
        $url = REST_PRO."/pedidoTrabajo/petr_id/".$petr_id;

        $aux = $this->rest->callAPI("GET",$url);
        $resp = json_decode($aux['data']);

        log_message('DEBUG', "#TRAZA | #TRAZ-COMP-TAREASESTANDAR | Tsttareas | getPedidoTrabajo()  resp: >> " . json_encode($resp));

        return $resp->pedidos_info->pedido_info;
    }

    /**
	* Obtiene los datos del lote
	* @param $batch_id
	* @return array datos del batch_id especificado
	*/
    public function getLote($batch_id){
        
        $url = REST_PRD_LOTE."/lote/".$batch_id;

        $aux = $this->rest->callAPI("GET",$url);
        $resp = json_decode($aux['data']);

        log_message('DEBUG', "#TRAZA | #TRAZ-COMP-TAREASESTANDAR | Tsttareas | getLote()  resp: >> " . json_encode($resp));

        return $resp->etapa;
    }

}
