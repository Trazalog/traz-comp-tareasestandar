<div class="reload" data-link="<?php echo base_url(TST."Tarea/tablaTareasPlantilla/$id") ?>">
    <table id="tareas_plantillas" class="table table-striped table-hover">
        <thead>
            <th style="font-size:18px">Tareas Plantilla</th>
            <th></th>
        </thead>
        <tbody>
            <?php
           if(sizeof($tareas_plantilla)){

               foreach ($tareas_plantilla as $key => $o) {
                   echo "<tr id='$o->tare_id' class='data-json' data-json='".json_encode($o)."'>";
                   echo "<td>$o->nombre</td>";
                   echo "<td class='text-right'><button class='btn btn-link' onclick='eliminarTareaPlantilla(this)'><i class='fa fa-trash'></i></button></td>";
                   echo "</tr>";
                }
            }else{
                echo "<tr><td class='text-center' colspan='2'>Sin Tareas Asociadas</td></tr>";
            }
           ?>
        </tbody>
    </table>
</div>

<script>
function eliminarTareaPlantilla(e) {
    var plan_id = selectPlan;
    var tare_id = $(e).closest('.data-json').attr('id');
    $.ajax({
        type: 'POST',
        dataType: 'JSON',
        url: '<?php echo base_url(TST) ?>Tarea/eliminarTareaPlantilla',
        data: {plan_id, tare_id},
        success: function(res) {
            $(e).closest('tr').remove();
            hecho();
        },
        error: function(res) {
            error();
        },
        complete: function() {

        }
    });
}
</script>