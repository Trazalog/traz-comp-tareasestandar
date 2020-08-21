<?php
    echo getForm(30);
?>
<script>
function cerrarTarea() {
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