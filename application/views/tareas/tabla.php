<div class="reload" data-link='<?php echo base_url('Tarea/tabla') ?>'>
    <table id="tareas" class="table table-hover table-striped" >
        <thead>
            <!-- <th>Nombre Tarea</th> -->
            <th width="15%" class="acciones">Acciones</th>
            <th>Lista de Tareas</th>
            <th width="15%">Duración STD</th>
        </thead>
        <tbody>
            <?php
            foreach ($tareas as $key => $o) {
                
                echo "<tr id='$o->tare_id' data-json='".json_encode($o)."'>";
                echo "<td>";
                echo "<button class='btn btn-link mr-2' onclick='agregarSubtareas(this)' title='Agregar Subtarea'><i class='fa fa-plus'></i></button>";
                echo "<button class='btn btn-link mr-2' onclick='editarTarea(this)' title='Editar Tarea'><i class='fa fa-pencil'></i></button>";
                echo "<button class='btn btn-link' onclick='eliminarTarea(this)' title='Eliminar Tarea'><i class='fa fa-trash'></i></button>";
                echo "</td>";
                echo "<td><b>Tarea: $o->nombre</b><br>";
                echo "<b>Descripción: </b>$o->descripcion</td>";
                echo "<td>$o->duracion</td>";
                echo '</tr>';

            }
        ?>
        </tbody>
    </table>
</div>

<script>
DataTable('table#tareas');
</script>