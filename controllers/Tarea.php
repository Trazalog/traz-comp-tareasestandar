<?php defined('BASEPATH') or exit('No direct script access allowed');

class Tarea extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Tareas');
        $this->load->model('Sectores');
    }
		/**
		* levanta componente planificacion de tareas(en Planificacion Trabajos)
		* @param 
		* @return
		*/
    public function planificar($origen, $orta_id)
    {
				// (AGREGADO DE MERGE DE CHECHO) extraer el info_id que viene concatenado con orta_id separado por un 0
					$aux = $orta_id;
					$auxorta_id="";
					$auxinfo_id="";
					$petr_id="";
					$o = 1;
					$cont = strlen($aux);
					for($i=0; $i<$cont; $i++)
					{
							if($aux[$i]!=0 && $o!=0)
							{
								$auxorta_id = $auxorta_id.$aux[$i];
							}else{
									$o = 0;
								$auxinfo_id = $auxinfo_id.$aux[$i+1];
							}
					}
					$contcero=0;
					for($i=0; $i<$cont; $i++)
					{
							if($aux[$i]==0)
							{  
									if($contcero == 2)
									{
											$petr_id = $petr_id.$aux[$i];
									}else{
											$contcero++;
									}
							}
					}

					$orta_id = $auxorta_id;
				// (FIN AGREGADO DE MERGE DE CHECHO) fin extraccion

        $data['origen'] = array('orta_id' => $orta_id, 'origen' => $origen);
        $data['tareas'] = $this->Tareas->obtener()['data'];
        $data['plantillas'] = $this->Tareas->obtenerPlantillas()['data'];
        $data['usuarios'] = $this->obtenerUsuarios()->usuarios->usuario;
				$data['sectores'] = $this->Sectores->obtener()['data'];

				// Si la tarea proviene de un pedido de trabajo, es decir desde el Modulo Tareas
				if($origen == 'PETR'){
					$petr_id = $this->Tareas->getPetrIdXHitoId($orta_id);
					$data['estatico'] =  $this->Tareas->obtenerPestaticopetr_id($petr_id)['data'];
				}
				//FIXME: BUSCAR EL HARDCODEO DE INFO ID PUEDE SER ID DE FORMULARIO DE TAREA
				//$auxinfo_id=217;
				// $html = getForm($auxinfo_id);
				$data['info_id'] = $auxinfo_id;
				// (FIN AGREGADO 2 DE MERGE CHECHO)

        $tareas = $this->Tareas->obtenerPlanificadas($origen, $orta_id)['data'];
				$usuarios = $data['usuarios'];
				$data['tareas_planificadas'] = $this->Tareas->marcarAsignados($tareas, $usuarios);
        $this->load->view('tareas/planificacion', $data);
    }

    public function obtener()
    {
        $data = $this->Tareas->obtener();
        echo json_encode($data);
    }
		/**
		* Guarda asignacion de usuario a Tarea, edita (ver otro uso)
		* @param
		* @return 
		*/
    public function guardarPlanificada()
    {
        $data = $this->input->post();
        $res = $this->Tareas->guardarPlanificada($data);
        echo json_encode($res);
    }

    /**
		* eliminar Planificada 
		* @param $id
		* @return Array respuesta del servicio
		*/
    public function eliminarPlanificada($id)
    {
       // $rsp = $this->Tareas->eliminarPlanificada($id);
       //() echo json_encode($rsp);

        // if (!$rsp['status']) {
        //     return $rsp;
        //     log_message("ERROR", "#TRAZA | #TRAZ-COMP-TAREASESTANDAR | TAREA | eliminar Planificada " . json_encode($rsp));    
        // } 
        // else{
        //     return $rsp;
        //     log_message("DEBUG", "#TRAZA | #TRAZ-COMP-TAREASESTANDAR | TAREA | eliminar Planificada " . json_encode($rsp));
     
        //    $processId = TAREAS_DEFAULT_PROC;

          //  $case_id = "";

          //  $rsp2 = $this->bpm->eliminarCaso($processId, $case_id);

            //     if (!$rsp2) {
    
            //     log_message('ERROR', '#TRAZA | #BPM |Pedido Trabajo | Eliminar Caso  >> Error al Eliminar Case_id');
    
            //     //return $rsp;
            //     echo json_encode($rsp2);
    
            // } else {
            //     log_message('DEBUG', '#TRAZA | #BPM |Pedido Trabajo | Eliminar Caso >> Se Elimino Caso y Pedido de trabajo Correctamente');
    
            //     echo json_encode($rsp2);
            
            // }

      //  }

        
    }
		/**
		* Obtien usuarios locales segun empresa (group de BPM)
		* @param
		* @return arrary con listado de usuarios
		*/
    public function obtenerUsuarios()
    {
        log_message("DEBUG", "#TRAZA | #TRAZ-COMP-TAREASESTANDAR | TAREA | obtenerUsuarios() ");
        
        $usuarios = $this->Tareas->obtenerUsuarios();
        return $usuarios;
    }

    public function crear()
    {
        $this->load->view('crear');
    }

    public function index()
    {
        $data['tareas'] = $this->Tareas->obtener()['data'];
        $data['plantillas'] = $this->Tareas->obtenerPlantillas()['data'];
        $this->load->view('tareas/dash', $data);
        $this->load->view('tareas/subtareas');

    }

    public function tabla()
    {
        $data['tareas'] = $this->Tareas->obtener()['data'];
        $this->load->view('tareas/tabla', $data);
    }

    public function guardar($id = false)
    {
        $data = $this->input->post('data');
        if ($data) {
          if(!isset($data['rece_id']))
{
     $data['rece_id'] ='';

}
            if ($id) {
                $rsp = $this->Tareas->editar($id, $data);
            } else {
                $rsp = $this->Tareas->guardar($data);
            }
            if($rsp)
            echo json_encode($rsp);
        } else {
            $this->load->view(TST.'tareas/form');
        }

    }

    public function eliminar($id)
    {
        $rsp = $this->Tareas->eliminar($id);
        echo json_encode($rsp);
    }
    public function guardarSubtarea()
    {
        $post = $this->input->post('data');
        if ($post) {
            $rsp = $this->Tareas->guardarSubtarea($post);
            echo json_encode($rsp);
        } else {
            $this->load->view(TST . '/tareas/form');
        }
    }

    public function tablaSubtareas($id)
    {
        $data['tare_id'] = $id;
        $data['subtareas'] = $this->Tareas->obtenerSubtareas($id)['data'];
        $this->load->view('tareas/tabla_subtareas', $data);
    }

    public function eliminarSubtarea($id)
    {
        $rsp = $this->Tareas->eliminarSubtarea($id);
        echo json_encode($rsp);
    }

    public function guardarPlantilla($id = false)
    {
        $data = $this->input->post('data');
        $rsp = $this->Tareas->guardarPlantilla($data);
        echo json_encode($rsp);
    }

    public function eliminarPlantilla($id)
    {
        $rsp = $this->Tareas->eliminarPlantilla($id);
        echo json_encode($rsp);
    }

    public function tablaPlantillas()
    {
        $data['plantillas'] = $this->Tareas->obtenerPlantillas()['data'];
        $this->load->view('tareas/tabla_plantillas', $data);
    }

    public function tablaTareasPlantilla($id)
    {
        $data['id'] = $id;
        $data['tareas_plantilla'] = $this->Tareas->obtenerTareasPlantilla($id)['data'];
        $this->load->view('tareas/tabla_tareas_plantilla', $data);
    }

    public function asociarTareaPlantilla()
    {
        $data = $this->input->post();
        $res = $this->Tareas->asociarTareaPlantilla($data);
        echo json_encode($res);
    }

    public function eliminarTareaPlantilla()
    {
        $data = $this->input->post();
        $res = $this->Tareas->eliminarTareaPlantilla($data);
        echo json_encode($res);
    }

    public function obtenerEquiposXSector($sectId)
    {
        $this->load->model(TST . 'Equipos');
        $rsp = $this->Equipos->obtener($sectId);
        echo json_encode($rsp);
    }

}
