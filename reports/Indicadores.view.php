<?php

use \koolreport\widgets\koolphp\Table;
// use \koolreport\widgets\google\BarChart;
use \koolreport\widgets\google\ColumnChart;
//use \koolreport\widgets\google\PieChart;
// use \koolreport\inputs\Select2;
//use \koolreport\widgets\koolphp\Card;

?>
<!--_________________BODY REPORTE___________________________-->
<div id="reportContent" class="report-content">
  <div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
      <div class="box box-solid">
        <div class="box box-primary">
          <div class="box-header with-border">
              <div class="box-tittle">
                  <h4>KPI Tareas</h4>
              </div>
          </div>
          <br>
          <!--_________________FILTRO_________________-->
            <form id="frm-filtros">
              <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                  <!-- _____ FECHA DESDE _____ -->
                  <div class="form-group col-xs-12 col-sm-3 col-md-3 col-lg-3">
                    <label>Fecha Desde <strong class="text-danger">*</strong> :</label>
                    <div class="input-group date">
                      <a class="input-group-addon" id="daterange-btn" title="Más fechas">
                        <i class="fa fa-magic"></i>
                        <span></span>
                      </a>
                      <input type="date" class="form-control pull-right" id="datepickerDesde" name="datepickerDesde" placeholder="Desde">
                    </div>
                  </div>
                  <!-- _____ FIN FECHA DESDE _____ -->
                  <!-- _____ FECHA HASTA _____ -->
                  <div class="form-group col-xs-12 col-sm-3 col-md-3 col-lg-3">
                    <label>Fecha Hasta  <strong class="text-danger">*</strong> :</label>
                    <div class="input-group">
                      <input type="date" class="form-control" id="datepickerHasta" name="datepickerHasta" placeholder="Hasta">
                      <a style="cursor: pointer;" class="input-group-addon" onclick="MostrarFiltro()">
                        <i class="fa fa-filter" title="Más Filtros"></i>
                      </a>
                    </div>
                  </div>
                  <!-- _____ FIN FECHA HASTA _____ -->
                  <!-- _____ BLOQUE AGRUPAR _____ -->
                  <div class="form-group col-md-4 col-md-offset-1">
                    <label style="margin-left:20%" for="tipoajuste" class="form-label">Agrupar por:</label>
                      <button id="btnFecha" type="button" class="btn btn-default btn-flat col-sm-4 col-md-3 mb-2" style="float: right !important;">Fecha</button>
                      <button id="btnUsuario" type="button" class="btn btn-info btn-flat col-sm-4 col-md-3 mb-2"  style="float: right !important;">Usuario</button>
                  </div>
                  <!-- _____ FIN BLOQUE AGRUPAR _____ -->
                </div>
              </div> <!-- FIN .row -->
                <!-- _____ BLOQUE MAS FILTROS _____ -->
                <div class="row" id="masFiltros" data="false" hidden>
                  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="form-group col-xs-12 col-sm-3 col-md-2 col-lg-3">
                      <label>Tipo de trabajo:</label>
                      <select style="width:100%" class="form-control select2" id="tipo_trabajo" name="tipo_trabajo">
                      </select>
                    </div>
                    <div class="form-group col-xs-12 col-sm-3 col-md-2 col-lg-3">
                      <label>Estado:</label>
                      <select style="width:100%" class="form-control select2" id="estado" name="estado">
                        <option value="" selected disabled>- Seleccionar -</option>
                        <option value="creada">Creada</option>
                        <option value="iniciada">Iniciada</option>
                        <option value="planificada">Planificada</option>
                        <option value="finalizada">Finalizada</option>
                      </select>
                    </div>
                    <div class="form-group col-xs-12 col-sm-3 col-md-2 col-lg-3">
                      <label>Asignado a:</label>
                      <select style="width:100%" class="form-control select2" id="usuarios" name="usuario">
                      </select>
                    </div>
                  </div>
                </div>
                <!-- _____  FIN BLOQUE MAS FILTROS _____ -->
                <div class="row">
                  <div style="margin-right: 20px" class="form-group col-xs-12 col-sm-2 col-md-2 col-lg-2 pull-right">
                    <label class="col-lg-12">&nbsp;</label>
                    <button type="button" class="btn btn-danger btn-flat flt-clear col-lg-6">Limpiar</button>
                    <button type="button" class="btn btn-success btn-flat col-lg-6" onclick="filtrar()">Filtrar</button>
                  </div>
                </div>
            </div>
          </form>
          <hr>
          <!-- _____ FIN FILTROS _____ -->
          <!-- _____ CONTADORES TAREAS _____ -->    
          <div class="row">
            <div class="col-md-12">
              <div class="center-block">
                <button type="button" class="btn btn-danger col-sm-6 col-md-4 col-md-offset-1">
                <h3 id="cantidad_finalizadas">0</h3>
                  <label for="">Tareas Finalizadas</label>
                </button>
                <button type="button" class="btn btn-success col-sm-6 col-md-4 col-md-offset-2">
                <h3 id="cantidad_planificadas">0</h3>
                  <label for="">Tareas Planificadas</label>
                </button>
              </div>
            </div>
          </div>
          <!-- _____ FIN CONTADORES TAREAS _____ -->    
          <!--_______ TABLA _______-->
          <div class="box-body">
            <div class="col-md-12">
         
            <?php
            
    ColumnChart::create(array(
    "title"=>"KPI Tareas",
    "dataStore" => $this->dataStore('data_kpi_basico_table'),
    "columns"=>array(
      "category",
        "cant_inicio"=>array("label" => "tareas planificadas",
        "type"=>"number",
        "prefix"=>""
      ),
        "cant_fin"=>array("label" => "tareas finalizadas",
        "type"=>"number",
        "prefix"=>""
      ),
    )
    ));
              Table::create(array(
              "dataStore" => $this->dataStore('data_kpi_basico_table'),
                "themeBase" => "bs4",
                "showFooter" => true, // cambiar true por "top" para ubicarlo en la parte superior
                "headers" => array(
                  array(
                    "Indicador de Eficiencia" => array("colSpan" => 6),
                    // "Other Information" => array("colSpan" => 2),
                  )
                ), // Para desactivar encabezado reemplazar "headers" por "showHeader"=>false
                "showHeader" => true,
                "columns" => array(
                  "fec_alta" => array(
                    "label" => "Fecha",
                    "type" => "date"
                  ),
                  "tipo_trabajo" => array(
                    "label" => "Tipo de trabajo",
                    "type"=>"string"
                  ),
                  "orden_trabajo" => array(
                    "label" => "Orden de trabajo",
                    "type"=>"string"
                  ),
                  "cod_hito" => array(
                    "label" => "Hito",
                    "type"=>"string"
                  ),
                  "nombre_usuario" => array(
                    "label" => "Asignado a",
                    "type"=>"string"
                  ),
                  "fec_asignacion" => array(
                    "label" => "Fecha de asignación",
                    "type" => "date"
                  ),
                  array(
                    "label" => "Estado",
                    "value" => function($row) {
                      $row["estado"] = estado($row["estado"],'green');
                      return $row["estado"];
                    },
                    "type" => "string"
                  )
                ),
                "cssClass" => array(
                  "table" => "table-scroll table-responsive dataTables_wrapper form-inline dt-bootstrap dataTable table table-bordered table-striped table-hover display",
                  "th" => "sorting"
                )
              ));
              ?>
            </div><!-- FIN .col-md-12  -->
          </div><!-- FIN .box-body -->
          <!--_________________ FIN TABLA ____________________________-->
        </div> <!-- FIN .box box-primary -->
        <!--_________________ FIN BODY REPORTE ____________________________-->
      </div> <!-- FIN .box box-solid -->
    </div><!-- FIN .col-xs-12 col-sm-12 col-md-12 col-lg-12 -->
  </div><!-- FIN .row -->
</div> <!-- FIN #reportContent -->
<script>
function  MostrarFiltro(){
  var masFiltros = $('#masFiltros').attr('data');
  if (masFiltros == "false") {
    $('#masFiltros').removeAttr('hidden');
    $('#masFiltros').attr('data', "true");
  }else{
    $('#masFiltros').attr('hidden', '');
    $('#masFiltros').attr('data', "false");
  }
}


  filtrosIndicadoresTareas();
  fechaMagic();
  //Funcion de datatable para extencion de botones exportar
  //excel, pdf, copiado portapapeles e impresion
  $(document).ready(function() {
    $('.select2').select2();
    $('.dataTable').DataTable({
      responsive: true,
      footerCallback: function ( row, data, start, end, display ) {
        var api = this.api(), data;

        // Remove the formatting to get integer data for summation
        var intVal = function ( i ) {
            return typeof i === 'string' ?
                i.replace(/[\$,]/g, '')*1 :
                typeof i === 'number' ?
                    i : 0;
        };

        // Total Finalizadas
        totalFinalizadas = api
          .column(6)
          .data()
          .filter( function (val, i) {
              return (val.includes('Finalizada')) ? true : false;
          }, 0 );
        $('#cantidad_finalizadas').text(totalFinalizadas.length);

        // Total Planificadas
        totalPlanificadas = api
          .column(6)
          .data()
          .filter( function (val, i) {
              return (val.includes('En Curso')) ? true : false;
          }, 0 );
        $('#cantidad_planificadas').text(totalPlanificadas.length);
      },
      rowGroup: {
        enable: false
      },
      language: {
      url: '<?php base_url() ?>lib/bower_components/datatables.net/js/es-ar.json' //Ubicacion del archivo con el json del idioma.
      },
      dom: 'lBfrtip',
      buttons: [{
        //Botón para Excel
        extend: 'excel',
        exportOptions: {
        columns: [0, 1, 2, 3, 4, 5]
        },
        footer: true,
        title: 'Reporte de Producción',
        filename: 'reporte_produccion',
        //Aquí es donde generas el botón personalizado
        text: '<button class="btn btn-success ml-2 mb-2 mb-2 mt-3">Exportar a Excel <i class="fa fa-file-excel-o"></i></button>'
      },
      // //Botón para PDF
      {
        extend: 'pdf',
        exportOptions: {
            columns: [0, 1, 2, 3, 4, 5]
        },
        footer: true,
        title: 'Reporte de Producción',
        filename: 'reporte_produccion',
        text: '<button class="btn btn-danger ml-2 mb-2 mb-2 mt-3">Exportar a PDF <i class="fa fa-file-pdf-o mr-1"></i></button>'
      },
      {
        extend: 'copy',
        exportOptions: {
            columns: [0, 1, 2, 3, 4, 5]
        },
        footer: true,
        title: 'Reporte de Producción',
        filename: 'reporte_produccion',
        text: '<button class="btn btn-primary ml-2 mb-2 mb-2 mt-3">Copiar <i class="fa fa-file-text-o mr-1"></i></button>'
      },
      {
        extend: 'print',
        exportOptions: {
            columns: [0, 1, 2, 3, 4, 5]
        },
        footer: true,
        title: 'Reporte de Producción',
        filename: 'reporte_produccion',
        text: '<button class="btn btn-default ml-2 mb-2 mb-2 mt-3">Imprimir <i class="fa fa-print mr-1"></i></button>'
      }]
    });
  });



  function filtrar() {
    var data = new FormData($('#frm-filtros')[0]);
    data = formToObject(data);
    wo();
    var url = 'indicadores';
    $.ajax({
      type: 'POST',

      data: {
        data
      },
      url: '<?php echo base_url(TST) ?>Reportes/' + url,
      success: function(result) {
        $('#reportContent').empty();
        $('#reportContent').html(result);
      },
      error: function() {
        alert('Error');
      },
      complete: function(result) {
        wc();
      }
    });
  }

  function filtrosIndicadoresTareas() {
    $.ajax({
      type: "GET",
      dataType: "JSON",
      url: "<?php echo base_url(TST) ?>Reportes/obtenerFiltros",
      success: function(rsp) {
        //Tipos de trabajo
        if (_isset(rsp.tiposTrabajos)) {
          var opcTiposTrabajos = '<option value="" disabled selected>- Seleccionar -</option>';

          rsp.tiposTrabajos.forEach(element => {
              opcTiposTrabajos += "<option value=" + element.tabl_id + ">" + element.descripcion + "</option>";
          });
          $('#tipo_trabajo').html(opcTiposTrabajos);
        }
        //Usuarios
        if (_isset(rsp.usuarios)) {
          var opcUsuarios = '<option value="" disabled selected>- Seleccionar -</option>';

          rsp.usuarios.forEach(element => {
              opcUsuarios += "<option value=" + element.id + ">" + element.first_name + " " + element.last_name + "</option>";
          });
          $('#usuarios').html(opcUsuarios);
        }
      },
      error: function(rsp) {
        error('Error!','Se produjo un error al obtener los filtros del reporte.');
      },
      complete: function() {
        wc();
      }
    })
  }

  //Funcionalidades botones para grupar filas en la tabla
  $(document).on( 'click', '#btnUsuario',function (e) {
    e.preventDefault();
    let tabla = $('.dataTable').DataTable();
    tabla.rowGroup().enable().dataSrc(0).order([[ 4, 'desc' ]]).draw();
  });
 </script>

