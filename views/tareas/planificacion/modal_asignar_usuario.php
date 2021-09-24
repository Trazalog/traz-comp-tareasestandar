<!-- The Modal -->
<div class="modal modal-fade" id="mdl-usuarios">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><i class="fa fa-user text-primary mr-2"></i> Seleccionar Usuario</h4>
            </div>
            <!-- Modal body -->
            <div class="">
                <table class="table table-striped table-hover" id="usuarios">
                    <tbody>
                        <?php 
                            foreach ($usuarios as $o) {

                                echo "<tr id='$o->usernick' class='data-json' data-json='".json_encode($o)."'>";
                                // echo "<td class='text-center'><img width='30px' height='30px' src='$o->img' class='img-circle' alt='User Image'></td>";
																echo "<td class='text-center'><img width='30px' height='30px' src='lib/dist/img/user2-160x160.jpg' class='img-circle' alt='User Image'></td>";
                                echo "<td><h5>$o->first_name $o->last_name</h5></td>";
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
	debugger;

    var user = getJson(this);
    setAttr(s_tarea, 'user_id', user.usernick);//cambiando 3ºparametro  tomo un item distinto del obj user (id o nickuser)
    $(s_tarea).find('span').remove();
    $(s_tarea).append(bolita(user.first_name.charAt(0).toUpperCase() + user.last_name.charAt(0).toUpperCase(),
        'orange'));
    guardarTarea(s_tarea);
    $('#mdl-usuarios').modal('hide');
});
</script>