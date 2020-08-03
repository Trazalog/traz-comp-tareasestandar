<div class="reload" data-link="<?php echo base_url(TST."Tarea/tablaSubtareas/".(isset($tare_id)?$tare_id:'')) ?>">
    <table id="subtareas" class="table table-striped table-hover">
        <thead>
            <th width="5%">N°</th>
            <th>Descripción Subtarea</th>
            <th>Formulario</th>
            <th width="15%">Acciones</th>
        </thead>
        <tbody>
            <?php
        if(isset($subtareas) && sizeof($subtareas)){
            foreach ($subtareas as $key => $o) {
                echo "<tr id='$o->suta_id' class='data-json'>";
                echo "<td>".($key+1)."</td>";
                echo "<td>$o->descripcion</td>";
                echo "<td><a hef='#'>Formulario Usuario</a></td>";
                echo "<td><button class='btn btn-link' onclick='eliminarSubtarea(this)'><i class='fa fa-trash'></i></button></td>";
                echo "</tr>";
            }
        }else{
            echo "<tr><td colspan='4'>Sin subtareas asociadas</td></tr>";
        }
        ?>
        </tbody>
    </table>
</div>

