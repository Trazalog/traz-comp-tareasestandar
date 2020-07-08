<!-- The Modal -->
<div class="modal modal-fade" id="mdl-usuarios">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><i class="fa fa-user text-primary mr-2"></i> Selecccionar Usuario</h4>
            </div>
            <!-- Modal body -->
            <div class="">
                <table class="table table-striped table-hover" id="usuarios">
                    <tbody>
                        <?php 
                            foreach ($usuarios as $o) {
                                echo "<tr id='$o->user_id' class='data-json' data-json='".json_encode($o)."'>";
                                echo "<td class='text-center'><img width='30px' height='30px' src='$o->img' class='img-circle' alt='User Image'></td>";
                                echo "<td><h5>$o->nombre $o->apellido</h5></td>";
                                echo "</tr>";
                            }
                        ?>
                    </tbody>
                </table>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<script>
$('table#usuarios > tbody').find('.data-json').on('click', function() {
    var user = getJson(this);
    setAttr(this, 'user_id', user.user_id);
    $(s_tarea).find('span').remove();
    $(s_tarea).append(bolita(user.nombre.charAt(0).toUpperCase() + user.apellido.charAt(0).toUpperCase(),
        'orange'));
    guardarTarea();
    $('#mdl-usuarios').modal('hide');
});
</script>