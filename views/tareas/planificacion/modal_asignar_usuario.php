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
    validarEstadoProceso().then((rsp) => {
        debugger;
        return;
        var user = getJson(this);
        Swal.fire({
        title: 'Desea asignar la tarea a : ' + user.usernick ,
        text: "",
        type: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Asignar',
        cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.value) {                        
                setAttr(s_tarea, 'user_id', user.usernick);//cambiando 3ºparametro  tomo un item distinto del obj user (id o nickuser)
                $(s_tarea).find('span').remove();
                $(s_tarea).append(bolita(user.first_name + ' ' + user.last_name,'orange'));
                guardarTarea(s_tarea);
    
                hecho('Hecho!','Usuario asignado a la tarea correctamente.');
                $('#mdl-usuarios').modal('hide');
            } else if (result.dismiss) {
                error('Cancelado','---');
            }
        });
    }).catch((error) => {
        error('Error', error.msj);
    });
});
//Se verifica el paso del proceso, en el que se encuentra antes de poder asignar un usuario a la tarea
async function validarEstadoProceso(){
    data = {};
    data.case_id = case_id_pedido_trabajo;
    data.proc_id = proc_id_pedido_trabajo;
    var validacion = new Promise((resolve, reject) => {
        $.ajax({
            type: "POST",
            url: '<?php echo TST ?>Tarea/validarEstadoProceso',
            data: data,
            dataType: "JSON",
            success: (rsp) => {
                resolve(rsp);
            },
            error: (rsp) => {
                reject(rsp);
            }
        });
    });
    return await validacion;
}
</script>