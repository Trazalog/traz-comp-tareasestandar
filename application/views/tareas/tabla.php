<table id="tareas" class="table table-hover table-striped">
    <thead>
        <th>Nombre Tarea</th>
        <th>Descripción</th>
        <th>Duración STD</th>
        <th class="acciones"></th>
    </thead>
    <tbody>
        <?php
            foreach ($tareas as $key => $o) {
                
                echo "<tr id='$o->tare_id' data-json='".json_encode($o)."'>";
                echo "<td>$o->nombre</td>";
                echo "<td>$o->descripcion</td>";
                echo "<td>$o->duracion</td>";
                echo "<td>";
                echo "<button class='btn btn-primary mr-2'><i class='fa fa-pencil'></i></button>";
                echo "<button class='btn btn-danger'><i class='fa fa-trash'></i></button>";
                echo "</td>";
                echo '</tr>';

            }
        ?>
    </tbody>
</table>