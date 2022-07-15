<input class="hidden" type="text" id="ortaId" value="<?php echo $orta_id?>">
<input class="hidden" type="text" id="estadoTarea" value="<?php echo $estado?>">
<input class="hidden" type="text" id="tipoTarea" value="planificada">
<br><br>
<div class="box-header with-border">
    <div class="box-title">Lista de subtareas</div>
</div>
<div id="listadoSubtareas" class="box-body" style="display: none">
    <table class="table table-hover table-striped">
        <tbody>
            <?php
            foreach ($subtareas->subtarea as $i => $subt) {
                echo "<tr>";
                echo "<td><div class='checkbox'>
                                <label>
                                    <input type='checkbox' name='terminado[]' class='flat-red i-check' value=''>
                                    $subt->descripcion
                                </label>
                            </div>
                     </td>";
 
                echo "<td width='5%'><button class='btn btn-link' data-toggle='collapse' data-target='#{$i}' aria-expanded='false' aria-controls='{$i}'><i class='fa fa-file-text text-primary'></i></button></td>";
                echo "</tr>";
                echo "<tr class='collapse animated fadeInLeft' id='{$i}'><td>";
                echo "<div class='card card-body'><div class='frm-new' data-form='{$subt->form_id}'></div></div>";
                echo "</td></tr>";
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
//Detecto e inicio los formularios dinamicos
detectarForm();
initForm();

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
    if(!validarTareasFinalizadas()) return;
    if($('#tipoTarea').val() == 'planificada'){
     closeTask();
    }else{    
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
}
function validarTareasFinalizadas() {
    var flag = true;
    $('input[name="terminado[]"]').each(function(i, obj) {
        if(!$(obj).is(':checked')){
            error('Error!','No se marcaron como finalizadas todas las subtareas!');
            flag = false;
        }
    });
    return flag;
}
function closeTask() {
    wo();
    $.ajax({
        type: 'POST',
        dataType: 'JSON',
        url: '<?php echo base_url(BPM)?>Proceso/cerrarTarea/' + $('#taskId').val(),
        success: function(res) {
            fun = () => {linkTo('<?php echo BPM ?>Proceso/');}
            confRefresh(fun);
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