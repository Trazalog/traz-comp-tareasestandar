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
                    // Por defecto, el proceso de tarea planificada; además la lista general y la de la empresa
                    $procDefault = defined('TAREAS_DEFAULT_PROC') ? TAREAS_DEFAULT_PROC : '';
                    $procesos = $procDefault ? array($procDefault => "Tarea Planificada ($procDefault)") : array();
                    foreach (array(REST_CORE."/tablas/procesos", REST_CORE."/tabla/procesos/empresa/".empresa()) as $urlProc) {
                        $rspProc = wso2($urlProc);
                        if (!empty($rspProc['data'])) {
                            foreach ($rspProc['data'] as $o) {
                                if (!isset($procesos[$o->valor])) $procesos[$o->valor] = $o->descripcion;
                            }
                        }
                    }
                    echo "<select id='proc_id' name='proc_id' class='form-control frm-select' style='width: 100%;'><option value='' disabled> - Seleccionar Proceso - </option>";
                    foreach ($procesos as $valor => $descripcion) {
                        echo "<option value='$valor'".($valor === $procDefault ? ' selected' : '').">$descripcion</option>";
                    }
                    echo "</select>";
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