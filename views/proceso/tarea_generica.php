<input class="hidden" type="text" id="ortaId" value="<?php echo $orta_id?>">
<input class="hidden" type="text" id="estadoTarea" value="<?php echo $estado?>">

<br><br>
<div class="box-header with-border">
    <div class="box-title">Lista de subtareas</div>
</div>
<div id="listadoSubtareas" class="box-body" style="display: none">
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
<div id="formularioTarea" class="box-body" style="display: none">
    <?php
    echo getForm($info_id);
    ?>
</div>
<br><br>


<script>
$(document).ready(function () {
    if($('#estadoTarea').val() != 'creada'){
        $("#btnIniciar_tarea").show();
        $("#btnIniciar_tarea").prop('disabled',true);
        $("#btnHecho").prop('disabled', false);
        $("#listadoSubtareas").show();
        $("#formularioTarea").show();
    }else{
        $('#view').css('pointer-events', 'none');
        $('#view').append('<div class="overlay"></div>');
        habilitarInicioTareaEstandar();
    }
});
function cerrarTarea() {
    var id = $('#ortaId').val();
    var status = false;
    wo();
    $.ajax({
        type: 'GET',
        dataType: 'JSON',
        url: '<?php echo base_url(PRD) ?>general/etapa/validarFormularioCalidad/' + id,
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