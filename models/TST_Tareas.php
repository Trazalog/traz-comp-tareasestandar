<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class TST_Tareas extends CI_Model
{
    public function __construct()
    {
        parent::__construct();

    }

    public function map($tarea)
    {
        $this->load->model(TST.'/Tareas');
        $data = $this->Tareas->obtenerXCaseId($tarea->caseId)['data'][0];

        $aux = new StdClass();
        $aux->color = 'default';
        $aux->texto = "Fecha: ".formatFechaPG($data->fecha);
        $array['info'][] = $aux;

        $aux = new StdClass();
        $aux->color = 'primary';
        $aux->texto = "Estado: $data->estado";
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
        $data = $this->Tareas->obtenerXCaseId($tarea->caseId)['data'][0];
        return $this->load->view(TST.'proceso/cabecera_tarea', $data, true);
    }


}
