<!-- The Modal -->
<div class="modal modal-fade" id="mdl-pere">
    <div class="modal-dialog modal-lm">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><i class="fa fa-cogs mr-2 text-primary"></i>Pedido Rec. Trabajo</h4>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Sector:</label>
                            <select name="sector" id="pl-sector" class="form-control sectores">
                                <option value="0">- Seleccionar -</option>
                                <?php
                                    foreach ($sectores as $o) {
                                        echo "<option value='$o->sect_id' data-json='".json_encode($o->equipos)."'>$o->descripcion</option>";
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Equipo:</label>
                            <select style='width: 100%;' name="equipo" id="pl-equipo" class="form-control equipos"
                                name="states[]" multiple="multiple">
                                <option value="0">- Seleccionar -</option>
                            </select>
                        </div>
                    </div>
                </div>

            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-success" data-dismiss="modal"
                    onclick="guardarEquipos()">Guardar</button>
                <button type="button" class="btn" data-dismiss="modal" onclick="$('#pl-equipo').empty()">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<script>
$("#pl-equipo").select2();

$('#pl-sector').change(function() {

    var aux = $('#pl-equipo').val();

    var equipos = getJson($(this).find('option:selected'));

    $('#pl-equipo').find('option').each(function(i, e) {
        if (!aux.includes($(e).attr('value'))) $(e).remove();
    });

    if (equipos) {
        equipos.forEach(function(e) {
            $('#pl-equipo').select2({
                data: [{
                    id: JSON.stringify({recu_id: e.recu_id, codigo:e.codigo}),
                    text: e.codigo
                }]
            });
        });
    }
});

function editarEquipos() {
    var data = getJson2(s_tarea);
    var aux = [];

    if (data.equipos) {
        data.equipos.forEach(function(e) {
            $('#pl-equipo').select2({
                data: [{
                    id: JSON.stringify({recu_id: e.recu_id, codigo:e.codigo}),
                    text: e.codigo
                }]
            });
            aux.push(JSON.stringify({recu_id: e.recu_id, codigo:e.codigo}));
        });
        $('#pl-equipo').val(aux).trigger('change');

    }
}

function guardarEquipos() {
    var equipos = $('#pl-equipo').val();
    var aux = [];
    equipos.forEach(function(e) {
        aux.push(JSON.parse(e));
    })
    setAttr(s_tarea, 'equipos', aux);
    $('#pl-sector').val("0");
    $('#pl-equipo').empty();

    guardarTarea(s_tarea);
}
</script>