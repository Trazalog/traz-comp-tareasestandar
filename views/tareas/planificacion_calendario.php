<?php
    $this->load->view('tareas/planificacion/modal_equipos');
    $this->load->view('tareas/planificacion/modal_pedido_materiales');
    $this->load->view('tareas/planificacion/modal_asignar_usuario');
?>

<div class="row">
    <div class="col-md-6">
        <div class="box box-calendario">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Sector:</label>
                            <select name="sector" id="sector" class="form-control">
                                <option value="0">- Seleccionar -</option>
                                <?php
                                    foreach ($sectores as $o) {
                                        echo "<option value='$o->sect_id' data-json='".json_encode($o->equipos)."'>$o->descripcion</option>";
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Equipo:</label>
                            <select name="equipo" id="equipo" class="form-control">
                                <option value="0">- Seleccionar -</option>
                            </select>
                        </div>
                    </div>
                </div>
                <?php $this->load->view(CAL.'calendario'); ?>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="box">
            <div class="box-body">
                <div class="table-responsive" style="height: 600px;">
                    <table class="table table-striped table-hover table-fixed" id="tareas-calendario">
                        <thead>
                            <th>Tareas Planificadas</th>
                            <th width="50%"></th>
                        </thead>
                        <tbody>
                            <?php
                                if($tareas_planificadas){

                                    foreach ($tareas_planificadas as $o) {
                                        
                                        echo "<tr class='data-json' data-json='".json_encode($o)."'>";
                                        echo "<td><h5>$o->nombre</h5></td>";
                                        echo "<td class='text-right acciones'></td>";
                                        echo "</tr>";
                                        
                                    }
                                }
                            
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>



<script>
var s_tarea = null;

function clickCalendario(info) {
    //HARDCODE
    const hora = " 00:00";
    var fecha = dateFormat(info.dateStr);
    if (selectCalendario) {
        setAttr(s_tarea, 'fecha', fecha);
        $(s_tarea).find('span').remove();
        $(s_tarea).append(bolita(fecha + hora, 'blue'));
        guardarTarea(s_tarea);

        //Actualizar Vista
        foco();
        selectCalendario = false;
    }
}


function guardarTarea(id) {

    var tarea = getJson2(id);
    tarea.origen =  getJson2($('#origen'));

    $.ajax({
        type: 'POST',
        dataType: 'JSON',
        url: '<?php echo TST ?>Tarea/guardarPlanificada',
        data: tarea,
        success: function(res) {
            console.log(res);
            if (res.status) {
                setAttr(id, 'tapl_id', res.data.respuesta.tapl_id);
                // hecho();
            } else {
                falla();
            }
        },
        error: function(res) {
            error();
        },
        complete: function() {
            s_tarea = false;
            wc();
        }
    });

}
</script>