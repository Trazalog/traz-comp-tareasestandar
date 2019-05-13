<div class="form-group">
    <label>Plantillas</label>
    <select id="plantilla" class="select2 form-control" style="width: 100%;">
        <option value="0">Seleccionar...</option>
        <?php

        foreach ($plantillas as $o) {
            echo '<option value="' . $o['plan_id'] . '">' . $o['nombre'] . ': ' . $o['descripcion'] . '</option>';
        }

        ?>
    </select>
</div>


<div class="box box-default collapsed-box box-solid">
    <div class="box-header with-border">
        <h3 id="tit_sub2" class="box-title">Esperando Selección...</h3>

        <div class="box-tools pull-right">
            <button id="collapse2" onclick="collapse(this)" type="button" class="btn btn-box-tool"
                data-widget="collapse"><i class="fa fa-plus"></i>
            </button>
        </div>
        <!-- /.box-tools -->
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <ul id="tareas_plantilla" class="todo-list ui-sortable">

        </ul>
        <br>
        <button class="btn btn-primary" style="float:right">Agregar</button>
    </div>
    <!-- /.box-body -->
</div>

<script>
var row =
    '<li><span class="handle ui-sortable-handle"><i class="fa fa-ellipsis-v"></i><i class="fa fa-ellipsis-v"></i></span><input type="checkbox" value=""><span class="text">Design a nice theme</span></li>';
$('select#plantilla').select2().on('change', function() {
    var data = $(this).select2('data')[0];
    if (data.id == 0) return;
    $('#tit_sub2').html(data.text);
    get_tareas_plantilla(data.id);
});

function get_tareas_plantilla(id) {
    $.ajax({
        type: 'POST',
        url: 'tareas/Tarea/getTareasPlantilla',
        data: {
            id
        },
        dataType: 'json',
        success: function(data) {
            $('#tareas_plantilla').empty();
            for (let i = 0; i < data.length; i++) {
                const element = data[i];
                $('#tareas_plantilla').append(
                    '<li><span class="handle ui-sortable-handle"><i class="fa fa-ellipsis-v"></i> <i class="fa fa-ellipsis-v"></i></span><input type="checkbox" value="" checked><span class="text">' +
                    element.nombre + '  | ' + element.descripcion +
                    '</span><div class="tools"><i class="fa fa-edit"></i><i class="fa fa-trash-o"></i></div></li>'
                );
            }
            collapse_open('#collapse2');
        },
        error: function(error) {
            alert('Error');
        }

    });
}
</script>