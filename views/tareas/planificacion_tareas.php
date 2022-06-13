<div class="row">
	<!-- Nueva Tarea -->
    <div class="col-md-6">
        <div class="box">
            <div class="form-group-input">
                <div class="input-group margin">
                    <label>Nueva Tarea:</label>
                    <input type="text" class="form-control" id="nueva-tarea" placeholder="Ingrese Nueva Tarea">
                    <div class="input-group-btn">
                        <button style="margin-top: 25px;" type="button" class="btn btn-success"
                            onclick="agregarTareaPlanificada({nombre:$('#nueva-tarea').val(), proc_id: '<?php echo TAREAS_DEFAULT_PROC ?>'}); $('#nueva-tarea').val('')"><i
                                class="fa fa-plus"></i></button>
                    </div>
                </div>
            </div>
            <div class="table-responsive" style="height: 400px;">
                <table id="tareas-planificadas" class="table table-striped table-hover table-fixed">
                    <thead>
                        <th>Tareas Planificadas</th>
                        <!-- <th style="display:none;"></th> -->
                        <td width="50%"></td>
                    </thead>
                    <tbody>

                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="2" class="text-center">
                                <h4>No hay Tareas Planificadas</h4>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
	<!-- / Nueva Tarea -->

	<!-- Seleccionar Plantilla -->
    <div class="col-md-6">
        <div class="box">
            <div class="box-body">
                <div class="form-group">
                    <label>Seleccionar Plantilla:</label>
                    <select id="plantilla" placeholder="Seleccionar Plantilla" class="form-control">
                        <option value="0">- Seleccionar Plantilla -</option>
                        <?php 
                            foreach ($plantillas as $o) {
                                echo "<option class='data-json' value='$o->plan_id' data-json='".json_encode($o->tareas->tarea)."'>$o->nombre</option>";
                            }
                        ?>
                    </select>
                </div>

                <div class="table-responsive" style="height: 400px;">
                    <table class="table table-striped table-hover table-fixed" id="tareas">
                        <thead>
                            <th>Lista de Tareas</th>
                            <th width="20%">Duración</th>
                            <th width="10%"></th>
                        </thead>
                        <tbody>
                            <?php
                               foreach ($tareas as $o) {
                                echo "<tr id='$o->tare_id' class='data-json' data-json='".json_encode($o)."' title='".$o->descripcion."'>";
                                echo "<td><a href='#' onclick='obtenerSubtareas($o->tare_id)'>$o->nombre</a></td>";
                                echo "<td>".bolita($o->duracion)."</td>";
                                echo "<td><i class='fa fa-plus text-primary btnAccionPlantilla' onclick='agregarTareaPlanificada(".(json_encode($o)).")'></i></td>";
                                echo "</tr>";
                            }
                        ?>
                        </tbody>
                        <tfoot style="display:none;">
                            <tr>
                                <td class="text-center" colspan="2"><a href="#"
                                        onclick="$('#plantilla').val(0).trigger('change');">Mostrar Todas</a></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <div class="box-footer">
                <button onclick="agregarTareas()" class="btn btn-success" id="btn-agregar">Agregar
                    Todas</button>
            </div>
        </div>
    </div>
	<!-- / Seleccionar Plantilla -->
</div>
<script>
function obtenerSubtareas(tarea) {
    if (tarea) {
        $.ajax({
            type: 'GET',
            url: '<?php echo base_url(TST) ?>Tarea/tablaSubtareas/' + tarea,
            success: function(res) {
                $('#mdl-generico').find('h4').html('Listado Subtareas')
                $('#mdl-generico').find('.modal-body').html(res);
                $('#mdl-generico').modal('show');
            },
            error: function(res) {
                error();
            },
            complete: function() {

            }
        });
    }

}

// Acciones de la tabla Tareas Planificadas
var accion =
    `<accion style="display:none">
    <button class="btn btn-link btn-sm btn-estado"><i class=""></i></button>
    <button class="btn btn-link btn-sm btn-planificado"><i class=""></i></button>
    <button class="btn btn-link btn-sm btn-planificar" onclick="planificar(this)"><i class="fa fa-calendar text-success mr-1"></i></button>
    <button class="btn btn-link btn-sm btn-asignar" title="Asignar Usuario" onclick="s_tarea = this;$('#mdl-usuarios').modal('show')"><i class="fa fa-user text-success mr-1"></i></button>
    <button class="btn btn-sm btn-link" title="Rec.Trabajo" onclick="s_tarea=this; editarEquipos(); $('#mdl-pere').modal('show')"><i class="fa fa-cogs"></i></button>
    <button class="btn btn-sm btn-link" title="Rec. Materiales" onclick="s_tarea=this; verDetallePedido();"><i class="fa fa-check-square-o"></i></button>
    <button class="btn btn-sm btn-link" title="Formulario Tarea" onclick="showForm(this)"><i class="fa fa-file-text"></i></button>
    </accion>
    <button class="btn btn-link btn-xs" onclick="conf(et,this)"><i class='fa fa-times text-danger'></i></button>`;


// Agrega las acciones a la Tabla  planificadas
$('#tareas-calendario').find('.acciones').html(accion);

// Recorre toda la Tabla Tareas Planificadas Marcando los usuarios asignados
$('#tareas-calendario > tbody > tr').each(function() {
    var data = getJson(this);

    estado_tarea = data.estado
    switch (estado_tarea) {
        case 'creada':
            console.log('estado: ' + estado_tarea);
            $(this).find('.btn-estado').append(bolita(estado_tarea, 'purple', 'Estado: '+ estado_tarea));
            break;

        case 'solicitado':
            console.log('estado: ' + estado_tarea);
            $(this).find('.btn-estado').append(bolita(estado_tarea, 'orange', 'Estado: '+ estado_tarea));
            break;
            
        case 'aprobado':
            console.log('estado: ' + estado_tarea);
            $(this).find('.btn-estado').append(bolita(estado_tarea, 'orange', 'Estado: '+ estado_tarea));
            break;

        case 'rechazado':
            console.log('estado: ' + estado_tarea);
            $(this).find('.btn-estado').append(bolita(estado_tarea, 'red', 'Estado: '+ estado_tarea));
            break;

        default:
        console.log('estado: ' + estado_tarea);
        $(this).find('.btn-estado').append(bolita(estado_tarea, 'gray', 'Estado'));
            break;
    }         

    if ( data.fecha >= '31-12-2100') {
        $(this).find('.btn-planificado').append(bolita('Sin Planificar', 'gray', 'Estado: Sin Planificar'));
    } else if (data.hasOwnProperty('fecha') && data.fecha != '31-12-3000') {
        $(this).find('.btn-planificar').append(bolita(dateFormatPG(data.fec_inicio), 'blue' , 'Estado: Planificado'));
        $(this).find('.btn-planificado').append(bolita('Planificado', 'purple', 'Estado: Planificado'));
        $('.btn-estado').hide();
    }
    var user = getJson($('tr#' +$.escapeSelector(data.user_id)));
    if (user) {
        // $(this).find('.btn-asignar').append(bolita(user.first_name.charAt(0).toUpperCase() + user.last_name.charAt(0)
        //     .toUpperCase(),
        //     'orange'));
        $(this).find('.btn-asignar').append(bolita(user.first_name+ ' ' + user.last_name,'orange',''));
    }
});
$('accion').show();

function agregarTarea(tarea) {
    if (tarea.nombre) {
        wo();
        tarea.tare_id = (tarea.tare_id?tarea.tare_id:'');
        const t = '#tareas-planificadas';
        const id = nextVal();
        $(t).append(
            `<tr id="${id}" class="tarea data-json" data-json='${JSON.stringify(tarea)}'>
            <td><h5>${tarea.nombre}</h5></td>
            <td class="text-right">${accion}</td>
            </tr>`
        );
        $(t).find('tfoot').hide();
        guardarTarea($('#' + id));
    }
}
var selectCalendario = false;

function planificar(e) {
    selectCalendario = true;
    s_tarea = e;
    foco('#box-calendario');
}

function agregarTareas() {
    //setWaitCount($('#tareas > tbody').find('tr:visible').length);
    $('#tareas').find('tr:visible').each(function() {
        var json = getJson(this);
        if (json) agregarTarea(json);
    });
}

$('#plantilla').change(function() {
    if (this.value == "0") { //Plantilla no seleccionada
        $('#tareas > tbody').find('tr').show();
        $('#tareas').find('tfoot').hide();
        $('#btn-agregar').hide();
    } else { //Plantilla Seleccionada
        $('#tareas > tbody').find('tr').hide();
        $('#btn-agregar').show();
        $('#tareas').find('tfoot').show();
        var json = getJson($(this).find('option:selected'));
        if (json) {
            json.forEach(function(e) {
                $('#' + e.tare_id).show();
            });
        }
    }
});

var et = function eliminarTarea(e) {
    var data = getJson2(e);
    const id = data.tapl_id;

    if(!data.tapl_id) { error('Error','La tarea seleccionada no posee ID'); return;}
    $(e).closest('tr').remove();

    if ($(e).find('tbody').find('tr').length == 0) $(e).find('tfoot').show();
    $.ajax({
        type: 'DELETE',
        dataType: 'JSON',
        data: {id},
        url: '<?php echo TST ?>Tarea/eliminarPlanificada/'+ id,
        success: function(res) {
            if (res.tareaPlanificada.status) {
                hecho("Hecho!", res.tareaPlanificada.msj);
            }else{
                error("Error!",res.tareaPlanificada.msj);
            }
        },
        error: function(res) {
            error();
        },
        complete: function() {
            calendarRefetchEvents();
        }
    });
}

function nextVal() {
    return Date.now();
}
function agregarTareaPlanificada(tarea) {
    if (tarea.nombre) {
        wo();
        tarea.tare_id = (tarea.tare_id?tarea.tare_id:'');
        const t = '#tareas-planificadas';
        const id = nextVal();
        $(t).append(
            `<tr id="${id}" class="tarea data-json" data-json='${JSON.stringify(tarea)}'>
            <td><h5>${tarea.nombre}</h5></td>
            <td class="text-right">${accion}</td>
            </tr>`
        );
        $(t).find('tfoot').hide();
        guardarTareaPlanificada($('#' + id));
    }
}
</script>