<style>
.nav-tabs>li {
    font-size: 15px;
}

.table-fixed {
    overflow-y: auto;
    height: 100px;
}

.table-fixed thead th {
    position: sticky;
    top: 0;
    background-color: #FFFFFF;
}

.tDnD_whileDrag td {
    background-color: #eee;
    /*-webkit-box-shadow: 11px 5px 12px 2px #333, 0 1px 0 #ccc inset, 0 -1px 0 #ccc inset;*/
    -webkit-box-shadow: 6px 3px 5px #555, 0 1px 0 #ccc inset, 0 -1px 0 #ccc inset;
    /*-moz-box-shadow: 6px 4px 5px 1px #555, 0 1px 0 #ccc inset, 0 -1px 0 #ccc inset;*/
    /*-box-shadow: 6px 4px 5px 1px #555, 0 1px 0 #ccc inset, 0 -1px 0 #ccc inset;*/
}
</style>
<div class="box" id="pnl-tareas">
    <input id="origen" class="hidden data-json" data-json='<?php echo json_encode($origen) ?>'>
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#tab_11" data-toggle="tab" aria-expanded="true" onclick="copiarTareas()"><i
                        class="fa fa-arrow-circle-right mr-2"></i>Calendario</a></li>
            <li class=""><a href="#tab_22" data-toggle="tab" aria-expanded="false" onclick="copiarTareas(true)"><i
                        class="fa fa-arrow-circle-right mr-2"></i>Planifiación Tareas</a></li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="tab_11">
                <?php $this->load->view('tareas/planificacion_calendario'); ?>
            </div>
            <!-- /.tab-pane -->
            <div class="tab-pane" id="tab_22">
                <?php $this->load->view('tareas/planificacion_tareas'); ?>
						</div>

					<!-- AGREGADO DEL MERGE DE CHECHO -->
            <li class=""><a href="#tab_23" data-toggle="tab" aria-expanded="false" ><i
                class="fa fa-arrow-circle-right mr-2"></i>Notificacion Estandar</a></li>
					<!-- FIN AGREGADO DEL MERGE DE CHECHO -->

            <!-- /.tab-pane -->
        </div>
        <!-- /.tab-content -->
    </div>

</div>
<script>
function copiarTareas(ban = false) {
    if (ban) {
        $('#tareas-planificadas').html($('#tareas-calendario').html()).tableDnD();
        $('accion').hide();
        $('#tareas-planificadas');
    } else {
        $('#tareas-calendario').html($('#tareas-planificadas').html()).tableDnD();
        $('accion').show();
    }
}
</script>