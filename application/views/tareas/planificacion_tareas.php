<div class="row">
    <div class="col-md-6">
        <div class="box box-success">
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
            <table id="tareas-planificadas" class="table table-striped table-hover">
                <thead>
                    <th>Tareas Planificadas</th>
                    <td width="5%"></td>
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
    <div class="col-md-6">
        <div class="box box-success">
            <div class="box-body">
                <div class="form-input-group">
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
            </div>
            <div class="box-body">
                <table class="table table-striped table-hover" id="tareas">
                    <thead>
                        <th>Lista de Tareas</th>
                        <th width="10%">Duración</th>
                        <th width="5%"></th>
                    </thead>
                    <tbody>
                        <?php
                            foreach ($tareas as $o) {
                                echo "<tr id='$o->tare_id' class='data-json' data-json='".json_encode($o)."'>";
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
            <div class="box-footer">
                <button onclick="agregarTareas()" class="btn btn-success" id="btn-agregar" style="display:none;">Agregar
                    Todas</button>
            </div>
        </div>
    </div>
</div>
<div class="box box-primary">
    <div class="box-header">
        <button class="btn btn-success" onclick="planificarTareas()"><i class="fa fa-check mr-2"></i>Planificar
            Tareas</button>
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
            url: 'Tarea/tablaSubtareas/' + tarea,
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


function agregarTarea(tarea) {
    if (tarea.nombre) {
        const t = '#tareas-planificadas';
        $(t).append(
            `<tr data-json='${JSON.stringify(tarea)}'>
            <td>${tarea.nombre}</td>
            <td><i class='fa fa-times text-danger' onclick="$(this).closest('tr').remove(); if($('${t} > tbody').find('tr').length==0)$('${t}').find('tfoot').show();"></i></td>
            </tr>`
        );
        $(t).find('tfoot').hide();
    }
}

function agregarTareas() {
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
</script>