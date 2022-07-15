<form id="<?php echo isset($id)?$id:'frm-tarea'?>">
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label>Nombre<?php echo hreq() ?>:</label>
                <input id="nombre" name="nombre" class="form-control" type="text" <?php echo req() ?>>
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
                <label>Duración Standard<?php echo hreq() ?>:</label>
                <input id="duracion" name="duracion" class="form-control" <?php echo req() ?>>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>Formulario Asociado:</label>
                <?php
                    echo selectFromFont('form_id','Seleccionar Formulario', REST_FRM.'/formularios/'.empresa(),['value'=>'form_id', 'descripcion'=>'nombre'], false);
                ?>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>Receta Asociada:</label>
                <?php
                    echo selectFromFont('rece_id', 'Seleccionar Receta', REST_PRD_ETAPAS.'/getFormulas/'.empresa(), array('value' => 'form_id', 'descripcion'=>'descripcion'), false);
                ?>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>Proceso Asociado:</label>
                <?php
                    echo selectFromCore('proc_id','Seleccionar Proceso', 'procesos', false);
                ?>
            </div>
        </div>
    </div>
</form>

<script>
initForm();
$("input[name='duracion']").inputmask({ 
    regex: "[0-9]*",
    mask: "99:99",
    inputFormat: "HH:MM"
});
</script>