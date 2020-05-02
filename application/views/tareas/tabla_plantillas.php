<div class="reload" data-link="<?php echo base_url("Tarea/tablaPlantillas") ?>">
   <table id="plantillas" class="table table-striped table-hover" >
       <thead>
           <th width="15%">Acciones</th>
           <th>Lista de Plantillas</th>
        </thead>
       <tbody>
           <?php
           foreach ($plantillas as $key => $o) {
               echo "<tr id='$o->plan_id' class='data-json'>";
               echo "<td>";
               echo "<button class='btn btn-link'><i class='fa fa-list' title='Ver Tareas Asociadas'></i></button>";
               echo "<button class='btn btn-link' onclick='editarPlantilla(this)' title='Editar'><i class='fa fa-pencil'></i></button>";
               echo "<button class='btn btn-link' onclick='eliminarPlantilla(this)' title='Eliminar'><i class='fa fa-trash'></i></button>";
               echo"</td>";
               echo "<td>$o->nombre</td>";
               echo "</tr>";
           }
           ?>
       </tbody>
   </table>
</div>