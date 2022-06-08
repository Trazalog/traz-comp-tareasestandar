<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Tareas extends CI_Model
{
    private $recurso = REST_TST . '/tareas';

    public function __construct()
    {
        parent::__construct();

    }

    public function obtener($id = false)
    {
        $rsp = $this->rest->callAPI('GET', $this->recurso . ($id ? "/$id" : '') . '/' . empresa());
        if ($rsp['status']) {
            $aux = json_decode($rsp['data']);
            if (isset($aux->tareas->tarea)) {
                $rsp['data'] = json_decode($rsp['data'])->tareas->tarea;
            } else {
                $rsp['data'] = [];
            }

        }

        return $rsp;
    }
    /**
	* Recibe los datos de la tarea estadar y la guarda
	* @param array datos tarea standard
	* @return array respuesta del servicio
	*/
    public function guardar($data){
        log_message('DEBUG', '#TRAZA | #TRAZ-COMP-TAREASESTANDAR | Tareas | guardar()');

        $data =  $this->mapTarea($data);
        $data['empr_id'] = strval(empresa());
        $post['post_tarea'] = $data;
        $rsp = $this->rest->callAPI('POST', $this->recurso, $post);
        return $rsp;
    }
    /**
	* Formatea data para el DS
	* @param array datos tarea standard
	* @return array datos formateados
	*/
    public function mapTarea($data){
        log_message('DEBUG', '#TRAZA | #TRAZ-COMP-TAREASESTANDAR | Tareas | mapTarea()');

        if(!isset($data['form_id'])) $data['form_id'] = "0";
        if(!isset($data['rece_id'])) $data['rece_id'] = "";
        if(!isset($data['proc_id'])) $data['proc_id'] = "0";
        return $data;
    }

    public function guardarSubtarea($data)
    {
        $post['post_subtarea'] = $data;
        $rsp = $this->rest->callAPI('POST', REST_TST . "/subtareas", $post);
        return $rsp;
    }

    public function obtenerPlantillas()
    {
        $rsp = $this->rest->callAPI('GET', REST_TST . '/plantillas/' . empresa());
        if ($rsp['status']) {
            $aux = json_decode($rsp['data']);
            if (isset($aux->plantillas->plantilla)) {
                $rsp['data'] = json_decode($rsp['data'])->plantillas->plantilla;
            } else {
                $rsp['data'] = [];
            }

        }

        return $rsp;
    }

    public function guardarPlantilla($data)
    {
        if (isset($data['plan_id'])) {
            $post['post_plantilla'] = $data;
            $rsp = $this->rest->callAPI('PUT', REST_TST . "/plantillas", $post);
        } else {
            $data['empr_id'] = strval(empresa());
            $post['post_plantilla'] = $data;
            $rsp = $this->rest->callAPI('POST', REST_TST . "/plantillas", $post);
        }
        return $rsp;
    }

    public function obtenerTareasPlantilla($id)
    {
        $rsp = $this->rest->callAPI('GET', REST_TST . "/plantillas/tareas/$id");
        if ($rsp['status']) {
            $aux = json_decode($rsp['data']);
            if (isset($aux->tareas->tarea)) {
                $rsp['data'] = json_decode($rsp['data'])->tareas->tarea;
            } else {
                $rsp['data'] = [];
            }

        }

        return $rsp;
    }

    public function asociarTareaPlantilla($data)
    {
        $post['post_plantillas_tareas'] = $data;
        $rsp = $this->rest->callAPI('POST', REST_TST . "/plantillas/tareas", $post);
        return $rsp;
    }

    public function eliminarTareaPlantilla($data)
    {
        $post['delete_plantillas_tareas'] = $data;
        $rsp = $this->rest->callAPI('DELETE', REST_TST . "/plantillas/tareas", $post);
        return $rsp;
    }

    public function eliminarPlantilla($id)
    {
        $data['delete_plantilla']['plan_id'] = $id;
        $rsp = $this->rest->callAPI('DELETE', REST_TST . "/plantillas", $data);
        return $rsp;
    }

    public function obtenerSubtareas($id)
    {
        $rsp = $this->rest->callAPI('GET', REST_TST . "/subtareas/$id");
        if ($rsp['status']) {
            $aux = json_decode($rsp['data']);
            if (isset($aux->subtareas->subtarea)) {
                $rsp['data'] = json_decode($rsp['data'])->subtareas->subtarea;
            } else {
                $rsp['data'] = [];
            }

        }
        return $rsp;
    }

    public function eliminarSubtarea($id)
    {
        $data['delete_subtarea']['suta_id'] = $id;
        $rsp = $this->rest->callAPI('DELETE', REST_TST . "/subtareas", $data);
        return $rsp;
    }
    /**
	* Edita una tarea std a partir de su id
	* @param array datos tarea standard
	* @return array respuesta del service
	*/
    public function editar($id, $data){
        log_message('DEBUG', '#TRAZA | #TRAZ-COMP-TAREASESTANDAR | Tareas | editar()');
        
        $data =  $this->mapTarea($data);
        $data['tare_id'] = $id;
        $put['put_tarea'] = $data;
        $rsp = $this->rest->callAPI('PUT', $this->recurso, $put);
        return $rsp;
    }

    public function eliminar($id)
    {
        $data['delete_tarea']['tare_id'] = $id;
        $rsp = $this->rest->callAPI('DELETE', $this->recurso, $data);
        return $rsp;
    }
    /**
        * Guarda la tarea planificada, realiza el pedido de materiales y lanza el proceso de tarea generica si se le asigna un usuario
        * @param array datos tarea planificada
        * @return array
	*/
    public function guardarPlanificada($data){
        log_message('DEBUG', "#TRAZA | #TRAZ-COMP-TAREASESTANDAR | Tareas | guardarPlanificada()".json_encode($data));

        #PEDIDO DE MATERIALES
        if(isset($data['pedido']) && isset($data['origen']['orta_id'])){
            $this->load->model(TST.'Pedidos');
            $this->Pedidos->pedidoMateriales($data['pedido'], $data['origen']['orta_id']);
        }

        #PROCESO GENERICO TAREAS
        $res = $this->lanzarProceso($data);
        if($res){
            $data['case_id'] = (string) $res->payload->caseId;
            
            #SI EL PROCESO FUE LANZADO SE INSTANCIA EL FORMULARIO ASOCIADO A LA TAREA
            if($data['form_id']){
                $this->load->model(FRM.'Forms');
                $data['info_id'] = intval($this->Forms->guardar($data['form_id']));
            }
        }
        
        #GUARDA O UPDATE LOS DATOS DE LA TAREA INSTANCIADA
        $post['_post_tarea_planificar'] = $this->map($data);
        $rsp = $this->rest->callAPI('POST', REST_TST . "/tarea/planificar", $post);
        if ($rsp['status']) {
            $rsp['data'] = json_decode($rsp['data']);
            $data['tapl_id'] = $rsp['data']->respuesta->tapl_id;
            $data['origen']['tapl_id'] = $rsp['data']->respuesta->tapl_id;
            $this->asignarOrigen($data['origen']);
            #Guardar Recursos Trabajo
            if (isset($data['equipos'])) {
                $this->asignarRecursos($data['tapl_id'], $data['equipos']);
            }
						//TODO: LA TAREA TIENE NOMBRE DISTINTO VINIENDO DESDE LA VISTA, EN BPM ES DISPLAYNAME CON EL QUE BUSCAMOS COINCIDENCIA
						// si hay usuario, lo asigno a tarea
						//if (isset($data['user_id']) && $data['user_id'] != "") {

								$actividad = $this->bpm->ObtenerActividades(BPM_PROCESS_ID_TAREA_GENERICA, $data['case_id']);
								$nombre = $actividad[0]['displayName'];
								$task = $this->bpm->ObtenerTaskidXNombre(BPM_PROCESS_ID_TAREA_GENERICA, $data['case_id'], $nombre);

								// con nickname local, traigo id de usuario en bpm para asignar l tarea
								$usrBpm = $this->bpm->getUser($data['user_id']);
								$resp_asign = $this->bpm->setUsuario($task, $usrBpm['data']['id']);
						//}
        }

        unset($data['origen']);
        return $data;
    }
    /**
        * Lanza el proceso de la tarea genérica
        * @param array datos termicos
        * @return bool true or false
	*/
    public function lanzarProceso($tarea){
        if(isset($tarea['proc_id']) && $tarea['proc_id'] == ""){
            log_message('DEBUG','#TRAZA | TRAZ-COMP-TAREASESTANDAR | TAREAS | lanzarProceso($tarea) | No hay proceso asociado');
            return; 
        }
        // SI YA TIENE PROCESO LANZADO, RETORNA A FUNCION PADRE
        if(isset($tarea['case_id']) && $tarea['case_id'] != "0" && $tarea['case_id'] != "") return;

        #Validacion de Lanzar Proceso
        if (isset($tarea['fecha']) && ($tarea['fecha'] != '3000-12-31+00:00') && isset($tarea['nombre']) && isset($tarea['user_id']) && isset($tarea['tapl_id'])) {
            $contract['nombre_proceso'] = $tarea['proc_id'];
            $contract['session'] = $this->session->has_userdata('bpm_token') ? $this->session->userdata('bpm_token') : '';
            $contract['emprId'] = empresa();
            $contract['payload']['nombreTarea'] = $tarea['nombre'];
            $contract['payload']['userNick'] = $tarea['user_id'];
            $contract['payload']['taplId'] = $tarea['tapl_id'];
            $res = wso2(REST_API_BPM, 'POST', $contract);
            return $res['data'];
        }else{
            log_message('DEBUG','#TRAZA | TRAZ-COMP-TAREASESTANDAR | TAREAS | lanzarProceso($tarea) | Validacion de proceso fallida');
        }

    }


    public function asignarOrigen($data)
    {
        if($data['orta_id'] != "0"){
            $post['_post_tarea_origen'] = $data;
            $url = REST_TST . '/tarea/origen';
            $rsp = $this->rest->callApi('POST', $url, $post);
            return $rsp;
        }
    }

    public function map($data)
    {
        $aux = array();
        $aux['nombre'] = $data['nombre'];
        $aux['fecha'] = (isset($data['fecha']) && $data['fecha'] != "0031-01-01+00:00") ? $data['fecha'] : '3000-12-31';
        $aux['info_id'] = strval(isset($data['info_id']) ? $data['info_id'] : '');
        $aux['tare_id'] = strval(isset($data['tare_id']) ? $data['tare_id'] : '');
        $aux['case_id'] = strval(isset($data['case_id']) && $data['case_id'] != "" ? $data['case_id'] : '');
        $aux['user_id'] = strval(isset($data['user_id']) ? $data['user_id'] : '');
        $aux['form_id'] = strval(isset($data['form_id']) ? $data['form_id'] : '');
        $aux['proc_id'] = strval(isset($data['proc_id']) ? $data['proc_id'] : '');
        $aux['tapl_id'] = strval(isset($data['tapl_id']) ? $data['tapl_id'] : '');
        $aux['rece_id'] = strval(isset($data['rece_id']) ? $data['rece_id'] : '');
        $aux['descripcion'] = strval(isset($data['descripcion']) ? $data['descripcion'] : '');
        $aux['hora_duracion'] = isset($data['duracion']) ? $data['duracion'] : '';
        $aux['empr_id'] = strval(empresa());

        if($aux['fecha'] != '3000-12-31+00:00'){
            $aux['fec_inicio'] = $aux['fecha'];
            $min = $this->timeToMinutes($data['duracion']);
            $aux['fec_fin'] = date('Y-m-d+H:i', strtotime("+$min minute", strtotime( $aux['fec_inicio'])));
            $aux['fec_inicio'] .='+00:00';
        }else{
            $aux['fec_inicio'] = $aux['fecha'].'+00:00';
            $aux['fec_fin'] = $aux['fecha'].'+00:00';
        }   

        return $aux;
    }

    public function eliminarPlanificada($id)
    {
        $delete['delete_tarea_planificar']['tapl_id'] = $id;
        $url = REST_TST . '/tarea/planificar';
        $rsp = $this->rest->callApi('DELETE', $url, $delete);
        return $rsp;
    }

    public function asignarRecursos($tapl_id, $equipos)
    {
        $rb[] = $this->eliminarRecursos($tapl_id);

        $rec = '_post_tarea_recursos';
        foreach ($equipos as $o) {
            $data[$rec . '_batch_req'][$rec][] = array(
                'tapl_id' => $tapl_id,
                'recu_id' => $o['recu_id'],
            );
        }

        $rb[] = $data;

        $rsp = requestBox(REST_TST.'/', $rb);

        return $rsp;
    }

    public function eliminarRecursos($tapl_id)
    {
        $rec = '_delete_tarea_recursos';

        $data[$rec] = array(
            "tapl_id" => $tapl_id,
        );

        return $data;
    }

    public function obtenerPlanificadas($origen, $orta_id)
    {
        $url = REST_TST . "/tareas/planificar/$origen/$orta_id";
        $rsp = $this->rest->callApi('GET', $url);
        if ($rsp['status']) {
            $rsp['data'] = $this->mapRespuesta(json_decode($rsp['data'])->tareas->tarea);
        }
         return $rsp;
    }

    public function mapRespuesta($data)
    {
        foreach ($data as $key => $o) {

            $rec = isset($o->recursos->recurso) ? $o->recursos->recurso : false;
            if (!$rec) {
                continue;
            }

            unset($data[$key]->recursos);

            foreach ($rec as $ro) {

                if ($ro->tipo == "TRABAJO") {

                    $data[$key]->equipos[] = array('recu_id' => $ro->recu_id, 'codigo' => $ro->codigo);

                }
            }

        }
        return $data;
    }

    public function obtenerXCaseId($caseId)
    {
        $url = REST_TST."/tareas/planificadas/case/$caseId";
        return wso2($url);
    }

    
    public function obtenerTareaPlanificada($id)
    {
        $url = REST_TST."/tarea/planificada/$id";
        
          $rsp = $this->rest->callApi('GET', $url);

          if ($rsp['status']) {
            $rsp['data'] = json_decode($rsp['data'])->tareaPlanificada;
            }
            return  $rsp['data'];
       
    }



    function timeToMinutes($time){
        $time = explode(':', $time);
        return ($time[0]*60) + $time[1];
    }

    public function eliminarTareasSinOrigen($emprId)
    {
        $url = REST_TST . '/tareas/planificadas/sinorigen';
        $data['_delete_tareas_planificadas_sinorigen']['empr_id'] = $emprId;
        return wso2($url, 'DELETE', $data);
    }

    // AGREGADO DE MERGE CHECHO
			public function obtenerPestaticopetr_id($petr_id)
			{
					$url = REST_PRO."/getInfotrabajo/$petr_id";
					return wso2($url);
			}
			public function obtenerform($info_id)
			{
					$this->db->select('name, label,valor, requerido, valo_id, orden, A.form_id, tipo_dato, C.nombre');
					$this->db->from('frm.instancias_formularios as A');
					$this->db->join('frm.formularios as C', 'C.form_id = A.form_id');
					$this->db->where('A.info_id', $info_id);
					$this->db->where('A.eliminado', false);
					$this->db->order_by('A.orden');

					$res = $this->db->get();

					$aux = new StdClass();
					$aux->info_id = $info_id;
					$aux->nombre = $res->row()->nombre;
					$aux->id = $info_id;
					$aux->items = $res->result();

					foreach ($aux->items as $key => $o) {

							if ($o->tipo_dato == 'radio' || $o->tipo_dato == 'check' || $o->tipo_dato == 'select') {

									$aux->items[$key]->values = $this->obtenerValores($o->valo_id);

							}
					}

					return $aux;
			}
			public function obtenerValores($id)
			{
					$this->db->select('valor as value, valor as label');
					return $this->db->get_where('frm.utl_tablas', array('tabla' => $id))->result();
			}
		// FIN AGREGADO DE MERGE CHECHO

		/**
		* Devuelve usuarios activos segun empresa
		* @param 
		* @return lista de usuarios por empresa
		*/
		function obtenerUsuarios()
		{
            
            $aux = $this->rest->callAPI("GET",REST_CORE."/users/".empresa());
			$aux = json_decode($aux["data"]);

			log_message("DEBUG", "#TRAZA | #TRAZ-COMP-TAREASESTANDAR | TAREAS | obtenerUsuarios() response >> ".json_encode($aux));

			return $aux;
		}

/**
		*Obtiene datos de clientes 
		* @param empr_id
		* @return lista de clientes por empresa
		**/
        public function obtenerClientes()
        {
            $empr_id = empresa();

            $resource = "/clientes/porEmpresa/$empr_id/porEstado/ACTIVO";
            $url = REST_CORE . $resource;
            return wso2($url);                                
        }
   
		/**
		* Devuelve petr_id por hito_id
		* @param int $hito_id
		* @return int $petr_id
		*/
		function getPetrIdXHitoId($orta_id)
		{     
			log_message('INFO','#TRAZA|| >> ');
			$aux = $this->rest->callAPI("GET",REST_TST."/petrid/hito/".$orta_id);
			$aux =json_decode($aux["data"]);
			return $aux->pedidoTrabajoId->petr_id;
			
		}

		/**
		* Agrega a tareas planificadas nombre de usuarios asignados a cada una
		* @param array tareas, array usuarios
		* @return array tareas
		*/
		function marcarAsignados($tareas, $usuarios)
		{

			foreach ($tareas as $key => $tar) {

				//guardo el nickname de usuario asignado
				$nick = $tar->user_id;

				foreach ($usuarios as $ind => $usr) {

					if($usr->usernick == $nick){

						$tar->nombreAsignado = $usr->first_name;
						$tar->apellidoAsignado = $usr->last_name; break;
					}else{

						$tar->nombreAsignado = "";
						$tar->apellidoAsignado = "";
					}
				}
			}

			return $tareas;
		}


        public function ActualizarFecha_inicio($data)
        {
        
            $url = REST_TST . "/tarea/iniciar";

            return wso2($url, 'PUT', $data);
            }


        public function ActualizarFecha_fin($data)
        {
            
            $url = REST_TST . "/tarea/finalizar";
    
            return wso2($url, 'PUT', $data);
            }

}
