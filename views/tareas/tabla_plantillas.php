<div class="reload" data-link="<?php echo base_url(TST."Tarea/tablaPlantillas") ?>">
   <table id="plantillas" class="table table-striped table-hover" >
       <thead>
           <th style="font-size:18px">Lista de Plantillas</th>
           <th class="text-center" <?php echo isAndroid()?'width="5%"':'width="15%"' ?>><button class="btn btn-success" onclick="$('#nueva_plantilla').modal('show')"><i class="fa fa-plus"></i> <?php echo isAndroid()?'':'Agregar'?></button></th>
        </thead>
       <tbody>
           <?php

            $aux['Ver Tareas Asociadas']['accion']='getTareasPlantilla(this)';
            $aux['Ver Tareas Asociadas']['icon']= 'fa-list';
            $aux['Editar']['accion']= 'editarPlantilla(this)';
            $aux['Editar']['icon']= 'fa-pencil';
            $aux['Eliminar']['accion']='conf(eliminarPlantilla, this)';
            $aux['Eliminar']['icon']= 'fa-trash';
            $aux = opcionesTabla($aux); 

           foreach ($plantillas as $key => $o) {
               echo "<tr id='$o->plan_id' class='data-json' data-json='".json_encode($o)."'>";
               echo "<td>$o->nombre</td>";
               echo "<td class='text-center'>$aux</td>";
               echo "</tr>";
           }
           ?>
       </tbody>
   </table>
</div>