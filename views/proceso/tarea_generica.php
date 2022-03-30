<input class="hidden" type="text" id="ortaId" value="<?php echo $orta_id?>">

<button class="btn btn-success" type="submit" name="iniciar_tarea" id="iniciar_tarea"><i class="fa fa-play-circle" aria-hidden="true"></i> Inicializar Tarea</button>
<br><br>
<div class="box-header with-border">
    <div class="box-title">Lista de subtareas</div>
</div>
<div class="box-body">
    <table class="table table-hover table-striped">
        <tbody>
            <?php
            foreach ($subtareas->subtarea as $o) {
                echo "<tr>";
                echo "<td><div class='checkbox'>
                                <label>
                                    <input type='checkbox' name='terminado[]' class='flat-red i-check' value='true'>
                                    $o->descripcion
                                </label>
                            </div>
                     </td>";
 
                echo  "<td width='5%'><button class='btn btn-link'><i class='fa fa-paperclip text-primary'></i></button></td>";
                echo "</tr>";
            }
        ?>
        </tbody>
    </table>
</div>

<div class="box-header with-border">
    <div class="box-title">Formulario Tarea</div>
</div>
<div class="box-body">
    <?php
    echo getForm($info_id);
    ?>
</div>
<br><br>
<button class="btn btn-primary" type="submit" name="terminar_tarea" id="terminar_tarea"><i class="fa fa-stop-circle" aria-hidden="true"></i> Terminar Tarea</button>




<script>
function cerrarTarea() {
    var id = $('#ortaId').val();
    var status = false;
    wo();
    $.ajax({
        type: 'GET',
        dataType: 'JSON',
        url: '<?php echo base_url() ?>general/etapa/validarFormularioCalidad/' + id,
        success: function(res) {
            status = res.status;
            if (!res.status) {
                alert('Para cerrar la tarea el formulario de calidad debe estar aprobado');
                wc();
            } else {
                closeTask();
            }
        },
        error: function(res) {
            error();
            wc();
        }
    });
}

function closeTask() {
    wo();
    $.ajax({
        type: 'POST',
        dataType: 'JSON',
        url: '<?php echo base_url(BPM)?>Proceso/cerrarTarea/' + $('#taskId').val(),
        success: function(res) {
            if ($('#miniView').length == 1) {
                closeView();
            } else {
                linkTo('<?php echo BPM ?>Proceso');
            }
        },
        error: function(res) {
            error();
        },
        complete: function() {
            wc();
        }
    });
}
</script>