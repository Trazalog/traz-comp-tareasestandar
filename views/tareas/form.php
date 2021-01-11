<form id="<?php echo isset($id)?$id:'frm-tarea'?>">
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label>Nombre:</label>
                <input id="nombre" name="nombre" class="form-control" type="text" <?php echo req() ?>>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <label>Descripción:</label>
                <textarea id="descripcion" name="descripcion" class="form-control" type="text" <?php echo req() ?>></textarea>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>Duración Standar:</label>
                <input id="duracion" name="duracion" class="form-control" type="text" <?php echo req() ?>>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>Formulario Asociado:</label>
                <?php
                    echo selectFromFont('form_id','Seleccionar Formulario', REST_FRM.'/formularios/1',['value'=>'form_id', 'descripcion'=>'nombre']);
                ?>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>Receta Asociada:</label>
                <?php
                    echo selectFromFont('rece_id', 'Seleccionar Receta', REST_PRD_ETAPAS.'/getFormulas', array('value' => 'form_id', 'descripcion'=>'descripcion'));
                ?>
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

<script>
initForm();
</script>