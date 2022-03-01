<?php

require  APPPATH . "/modules/".TST. "/libraries/koolreport/core/autoload.php";

//Specify some data processes that will be used to process
// use \koolreport\processes\Group;
use \koolreport\processes\Sort;
use \koolreport\processes\Limit;
// use \koolreport\processes\RemoveColumn;
use \koolreport\processes\OnlyColumn;

//Define the class
class Indicadores extends \koolreport\KoolReport
{
  // use \koolreport\clients\Bootstrap;
  use \koolreport\codeigniter\Friendship;
  /*Filtros Avanzados*/
  /*Enlace de datos entre los parámetros del informe y los Controles de entrada */
  // use \koolreport\inputs\Bindable;
  // use \koolreport\inputs\POSTBinding;

  function cacheSettings()
  {
    return array(
      "ttl" => 60, //determina cuántos segundos será válido el caché
    );
  }

  protected function settings()
  {
    log_message('DEBUG', '#TRAZA| #PRODUCCION.PHP|#PRODUCCION|#SETTINGS| #INGRESO');
    $json = $this->params;
    $data = json_encode($json);

    return array(
      "dataSources" => array(
        "apiarray" => array(
          "class" => '\koolreport\datasources\ArrayDataSource',
          "dataFormat" => "associate",
          "data" => json_decode($data, true),
        )
      )
    );

  }

  protected function setup()
  {
    log_message('DEBUG', '#TRAZA| #PRODUCCION.PHP|#TAREA|#SETUP| #KPIBASICO');
    $this->src("apiarray")
      ->pipe($this->dataStore("data_kpi_basico_table"));

    $this->src("apiarray")
      ->pipe(new OnlyColumn(array(
        "user_id", "cant_inicio", "cant_fin"
      )))
      ->pipe($this->dataStore("data_kpi_basico_columnChart"));
  

  }
}
