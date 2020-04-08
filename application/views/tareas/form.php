<form id="<?php echo isset($id)?$id:'frm-tarea'?>">
    <div class="form-group">
        <label>Nombre:</label>
        <input id="nombre" name="nombre" class="form-control" type="text">
    </div>
    <div class="form-group">
        <label>Duración Standar:</label>
        <input id="duracion_std mask" name="duracion_std" class="form-control" type="text">
    </div>
    <div class="form-group">
        <label>Descripción:</label>
        <textarea id="descripcion" name="descripcion" class="form-control" type="text"></textarea>
    </div>
</form>