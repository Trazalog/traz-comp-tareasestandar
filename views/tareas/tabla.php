<div class="reload" data-link='<?php echo base_url(TST.'Tarea/tabla') ?>'>
    <table id="tareas" class="table table-hover table-striped">
        <thead>
            <th style="font-size:18px">Lista de Tareas</th>
            <th class="text-center" <?php echo isAndroid()?'width="5%"':'width="15%"' ?>><button class="btn btn-success" onclick="$('#nuevo').modal('show')"><i class="fa fa-plus"></i> <?php echo isAndroid()?'':'Agregar'?></button></th>
        </thead>
        <tbody>
            <?php
             $aux['Agregar Subtarea']['accion'] = 'agregarSubtareas(this)';
             $aux['Agregar Subtarea']['icon'] = 'fa-plus';
             $aux['Editar']['accion'] = 'editarTarea(this)';
             $aux['Editar']['icon'] = 'fa-edit';
             $aux['Eliminar']['accion'] = 'eliminarTarea(this)';
             $aux['Eliminar']['icon'] = 'fa-trash';
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