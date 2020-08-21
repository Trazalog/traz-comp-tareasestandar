<form id="<?php echo isset($id)?$id:'frm-tarea'?>">
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label>Nombre:</label>
                <input id="nombre" name="nombre" class="form-control" type="text">
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <label>Descripción:</label>
                <textarea id="descripcion" name="descripcion" class="form-control" type="text"></textarea>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>Duración Standar:</label>
                <input id="duracion" name="duracion" class="form-control" type="text">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>Formulario Asociado:</label>
                <select id="form_id" name="form_id" class="form-control"  style='width: 100%;' >
                    <option value="0" selected> - Seleccionar Item -</option>
                </select>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>Receta Asociada:</label>
                <select id="rece_id" name="rece_id" class="form-control" style='width: 100%;'>
                    <option value="0" selected> - Seleccionar Item -</option>
                </select>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>Proceso Asociado:</label>
                <?php
                    echo selectFromCore('proc_id','Selecccionar Proceso', 'procesos');
                ?>
            </div>
        </div>
    </div>
</form>