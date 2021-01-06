<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Tstareas extends CI_Model
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

        $aux = new StdClass();
        $aux->color = 'primary';
        $aux->texto = "Estado: " . ucfirst($data->estado);
        $array['info'][] = $aux;

        $aux = new StdClass();
        $aux->color = 'primary';
        $aux->texto = "Origen: $data->origen";
        $array['info'][] = $aux;
        
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
        $this->load->model('general/Etapas');
        $data['tarea'] = $this->Tareas->obtenerXCaseId($tarea->caseId)['data'][0];
        $data['etapa'] = $this->Etapas->buscar($data['tarea']->orta_id)->etapa;
        return $this->load->view(TST.'proceso/cabecera_tarea', $data, true);
    }


}
