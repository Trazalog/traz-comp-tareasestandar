<input type="text hidden" id="ortaId" value="<?php echo $orta_id?>">
<?php
    echo getForm($info_id);
?>
<script>
function cerrarTarea() {
    validarFormularioCalidad();
    return;
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

function validarFormularioCalidad() {
    wo();
    var id = $('#ortaId').val();
    $.ajax({
        ansync: true,
        type: 'GET',
        dataType: 'JSON',
        url: '<?php echo base_url() ?>general/etapa/validarFormularioCalidad/'+id,
        success: function(res) {
            console.log(res);
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