<!-- The Modal -->
<div class="modal modal-fade" id="mdl-hora">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Hora comienzo tarea</h4>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <div class="form-group">
                    <label>Hora:</label>
                    <input id="hora" class="timepicker form-control" type="text">
                </div>

            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" onclick="planificarTarea()">Planificar</button>
            </div>
        </div>
    </div>
</div>

<script>
function planificarTarea() {
    s_fecha = dateFormat(s_fecha) + '+' + $('#hora').val();
    setAttr(s_tarea, 'fecha', s_fecha);
    $(s_tarea).find('span').remove();
    $(s_tarea).append(bolita(s_fecha, 'blue'));
    $('#mdl-hora').modal('hide');
    guardarTarea(s_tarea);
}

$('.timepicker').timepicker({
    timeFormat: 'HH:mm',
    interval: 60,
    minTime: '10',
    maxTime: '<?php echo HORA_FIN_JORNADA ?>',
    defaultTime: '11',
    startTime: '10:00',
    dynamic: false,
    dropdown: true,
    scrollbar: true,
    zindex: 999999999999999
  
});
</script>