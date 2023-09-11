<div class="reload" data-link='<?php echo base_url(TST.'Tarea/tabla') ?>'>
    <div class="row">
        <div class="col-md-6">
            <span style="font-size: 20px;"><b>Lista de Tareas</b></span>
        </div>
        <div class="col-md-6">
            <div class="pull-right" <?php echo isAndroid()?'width="5%"':'width="15%"' ?>><button class="btn btn-success" onclick="$('#nuevo').modal('show')"><i class="fa fa-plus"></i> <?php echo isAndroid()?'':'Agregar'?></button></div>
        </div>
    </div>
    <table id="tareas" class="table table-hover table-striped">
        <thead>
            <th>Información de Tareas</th>
            <th class="text-center">Acciones</th>
        </thead>
        <tbody>
            <?php
             $aux['Agregar Subtarea']['accion'] = 'agregarSubtareas(this)';
             $aux['Agregar Subtarea']['icon'] = 'fa-plus';
             $aux['Agregar Subtarea']['title'] = "Agregar Subtarea";
             $aux['Editar']['accion'] = 'editarTarea(this)';
             $aux['Editar']['icon'] = 'fa-edit';
             $aux['Editar']['title'] = 'Editar';
             $aux['Eliminar']['accion'] = 'conf(eliminarTarea, this)';
             $aux['Eliminar']['icon'] = 'fa-trash';
             $aux['Eliminar']['title'] = 'Eliminar';
             $aux =  opcionesTabla($aux);

            foreach ($tareas as $key => $o) {
                
                echo "<tr id='$o->tare_id' class='data-json' data-json='".json_encode($o)."'>";
                echo "<td>";
                echo "<b>Tarea: </b>$o->nombre<br>";
                echo "<b>Descripción: </b>".substr($o->descripcion,0,200)."...<br>";
                echo "<b>Duración STD: </b>$o->duracion";
                echo "</td>";
                echo "<td class='text-center'>$aux</td>";
                echo '</tr>';

            }
        ?>
        </tbody>
    </table>
</div>