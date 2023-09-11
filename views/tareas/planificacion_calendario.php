<?php
$this->load->view('tareas/planificacion/modal_equipos');
$this->load->view('tareas/planificacion/modal_pedido_materiales');
$this->load->view('tareas/planificacion/modal_asignar_usuario');
$this->load->view('tareas/planificacion/mdl_hora');
?>

<div class="row">
    <!-- Calendario Renderizado -->
    <div class="col-md-6">
        <div id="box-calendario" class="box">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Sector:</label>
                            <select name="sector" id="sector" class="form-control">
                                <option value="" disabled selected>- Seleccionar -</option>
                                <?php
                                foreach ($sectores as $o) {
                                    echo "<option value='$o->sect_id' data-json='" . json_encode($o->equipos) . "'>$o->descripcion</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Equipo:</label>
                            <div class="input-group">
                                <select name="equipo" id="equipo" class="form-control">
                                    <option value="" disabled selected>- Seleccionar -</option>
                                </select>
                                <span style="background-color: #646c6f;cursor: pointer;color: white;" id="add_filtro" class="input-group-addon" onclick="agregarFiltro()" title="Filtrar"><i class="fa fa-tags"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div id="seccionFiltros">

                        </div>
                    </div>
                </div>
                <?php $this->load->view(CAL . 'calendario'); ?>
            </div>
        </div>
    </div>
    <!-- / Calendario Renderizado -->

    <!-- Tareas Planificadas -->
    <div class="col-md-6">
        <div class="box" id="bolsa-tareas">
            <div class="box-body">
                <div class="table-responsive" style="height: 540px;">
                    <table class="table table-striped table-hover table-fixed" id="tareas-calendario">
                        <thead>
                            <th>Tareas :</th>
                            <th width="50%"></th>
                        </thead>
                        <tbody>
                            <?php
                           
                            if ($tareas_planificadas && $origen['orta_id']) {

                                foreach ($tareas_planificadas as $o) {


                                    echo "<tr class='data-json' data-json='" . json_encode($o) . "' title='" . $o->descripcion . "'>";
                                    echo "<td><h5>$o->nombre</h5></td>";
                                    echo "<td class='text-right acciones'></td>";
                                    echo "</tr>";
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- / Tareas Planificadas -->
</div>

<script>
    var s_tarea = null;
    var s_fecha = false;
    
    function clickCalendario(info) {
        if (Date.parse(info.date) >= Date.parse(dateNow())) {
            //HARDCODE
            s_fecha = dateFormat(info.dateStr);
            if (selectCalendario) {
                //Actualizar Vista
                foco();
                selectCalendario = false;
                $('#mdl-hora').modal('show');
            }
        } else {
            Swal.fire({
                type: 'error',
                title: 'Error...',
                text: 'No se puede seleccionar fechas anteriores a la actual!',
                target: document.getElementById('box-calendario'),
            });
        }
    }

    function guardarTodasTareas() {
        $('#tareas-calendario').find('.tarea').each(function() {
            guardarTarea('#' + this.id);
        })
    }
    //Guarda la tarea seleccionada para planificarla, lanzar proceso asociado, realizar el pedido de materiales y asignar los recursos seleccionados
    function guardarTarea(id) {
        var tarea = getJson2(id);
        tarea.origen = getJson2($('#origen'));
        wbox('#bolsa-tareas');
        $.ajax({
            type: 'POST',
            dataType: 'JSON',
            url: '<?php echo TST ?>Tarea/guardarPlanificada',
            data: tarea,
            success: function(res) {
                setJson(id, res);
            },
            error: function(res) {
                error();
            },
            complete: function() {
                s_tarea = false;
                wbox();
                wc();
                calendar.refetchEvents();
            }
        });
    }
    //Muestra la instacia del formulario dinamico asociada a la TAREA STANDAR
    function showForm(e) {
        var data = getJson2(e);
        $mdl = $('#mdl-generico');
        $mdl.find('.modal-title').html('Formulario Asociado');
        $mdl.find('.modal-body').empty();
        if (!data.info_id || data.info_id == "false") {

            Swal.fire({
                type: 'info',
                title: 'Info',
                text: 'Aún no se completó formulario asociado!'

            })
            return;
        }
        wo();
        $.ajax({
            type: 'GET',
            dataType: 'JSON',
            url: '<?php echo base_url(FRM) ?>Form/obtener/' + data.info_id,
            success: function(res) {
                $mdl.find('.modal-body').html(res.html);
                $mdl.modal('show');
            },
            error: function(res) {
                error();
            },
            complete: function() {
                wc();
            }
        });
    }

    $('#sector').on('change', function() {
        wo();
        $.ajax({
            type: 'GET',
            dataType: 'JSON',
            url: '<?php echo base_url(TST) ?>Tarea/obtenerEquiposXSector/' + this.value,
            success: function(res) {
                $('select#equipo').empty();
                if (res.status) {
                    res.data.forEach(function(e, i) {
                        $('select#equipo').append(`<option value='${e.equi_id}'>${e.codigo} - ${e.descripcion}</option>`)
                    });
                }
                //hecho();
            },
            error: function(res) {
                error();
            },
            complete: function() {
                wc();
            }
        });
    })
    //Seccion filtros en el calendario
    function agregarFiltro() {
        id_sector = $("#sector").val();
        id_equipo = $("#equipo").val();
        if (!_isset($("#sector").val())) {
            error('Error!', 'No se seleccionó un sector.');
            return;
        }
        datos = {};
        datos.sector = id_sector;
        datos.equipo = id_equipo;
        equipo = $("#equipo option:selected").text();
        sector = $("#sector option:selected").text();
        $("#seccionFiltros").append(`<button class='btn btn-link btn-sm' onclick='eliminarFiltro(this)'><span data-toggle='tooltip' title='FILTRO' class='badge bg-gray estado' data-json='${JSON.stringify(datos)}'><i class="fa fa-times"></i> ${equipo} | ${sector}</span></button>`)
        calendar.refetchEvents();

    }
    //Elimino y vuelvo a traer los eventos si el filtro eliminado
    function eliminarFiltro(tag) {
        $(tag).remove();
        calendar.refetchEvents();
    }
    //Guarda la tarea seleccionada para planificarla
    function guardarTareaPlanificada(id) {
        var tarea = getJson2(id);
        tarea.origen = getJson2($('#origen'));
        wbox('#bolsa-tareas');

        $.ajax({
            type: 'POST',
            dataType: 'JSON',
            url: '<?php echo TST ?>Tarea/guardarTareaPlanificada',
            data: tarea,
            success: function(res) {
                if (res.status) {
                    hecho('Hecho!', 'Se planificó la tarea correctamente!');
                    setJson(id, res.datosTarea);
                } else {
                    error();
                }
            },
            error: function(res) {
                error();
            },
            complete: function() {
                s_tarea = false;
                wbox();
                wc();
                calendar.refetchEvents();
            }
        });
    }

   
</script>