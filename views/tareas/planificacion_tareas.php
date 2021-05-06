<div class="row">
    <div class="col-md-6">
        <div class="box">
            <div class="form-group-input">
                <div class="input-group margin">
                    <label>Nueva Tarea:</label>
                    <input type="text" class="form-control" id="nueva-tarea" placeholder="Ingrese Nueva Tarea">
                    <div class="input-group-btn">
                        <button style="margin-top: 25px;" type="button" class="btn btn-success"
                            onclick="agregarTarea({nombre:$('#nueva-tarea').val()}); $('#nueva-tarea').val('')"><i
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
                            <th width="10%">Duración</th>
                            <th width="5%"></th>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($tareas as $o) {
                                echo "<tr id='$o->tare_id' class='data-json' data-json='".json_encode($o)."' title='".$o->descripcion."'>";
                                echo "<td><a href='#' onclick='obtenerSubtareas($o->tare_id)'>$o->nombre</a></td>";
                                echo "<td>".bolita($o->duracion)."</td>";
                                echo "<td><i class='fa fa-plus text-primary' onclick='agregarTarea(".(json_encode($o)).")'></i></td>";
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
</div>


<script>
function planificarTareas() {
    $('#tareas-planificadas > tbody').find('tr').each(function() {
        console.log(getJson(this));
    })
}

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
var accion =
    `<accion style="display:none">
    <button class="btn btn-link btn-xs btn-planificar" onclick="planificar(this)"><i class="fa fa-calendar text-success mr-1"></i></button>
    <button class="btn btn-link btn-xs btn-asignar" onclick="s_tarea = this;$('#mdl-usuarios').modal('show')"><i class="fa fa-user text-success mr-1"></i></button>
    <button class="btn btn-xs btn-link" title="Rec.Trabajo" onclick="s_tarea=this; editarEquipos(); $('#mdl-pere').modal('show')"><i class="fa fa-cogs"></i></button>
    <button class="btn btn-xs btn-link" title="Rec. Materiales" onclick="s_tarea=this; verDetallePedido();"><i class="fa fa-check-square-o"></i></button>
    <button class="btn btn-xs btn-link" title="Formulario Tarea" onclick="showForm(this)"><i class="fa fa-file-text"></i></button>
    </accion>
    <button class="btn btn-link btn-xs" onclick="conf(et,this)"><i class='fa fa-times text-danger'></i></button>`;

$('#tareas-calendario').find('.acciones').html(accion);
$('#tareas-calendario > tbody > tr').each(function() {
    var data = getJson(this);
    if (data.hasOwnProperty('fecha') && data.fecha != '3000-12-31+00:00' && data.fecha != '0031-01-01+00:00') {
        $(this).find('.btn-planificar').append(bolita(dateFormatPG(data.fecha), 'blue'));
    }
    console.log('ban');
    console.log(data);
    var user = getJson($('tr#' +$.escapeSelector(data.user_id)));
    console.log(user);
    if (user) {
        $(this).find('.btn-asignar').append(bolita(user.nombre.charAt(0).toUpperCase() + user.apellido.charAt(0)
            .toUpperCase(),
            'orange'));
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
    if(!data.tapl_id) { alert('Error al eliminar Tarea'); return;}
    $(e).closest('tr').remove();
    if ($(e).find('tbody').find('tr').length == 0) $(e).find('tfoot').show();
    $.ajax({
        type: 'DELETE',
        dataType: 'JSON',
        url: '<?php echo TST ?>Tarea/eliminarPlanificada/' + id,
        success: function(res) {
            if (!res.status) falla();
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
</script>