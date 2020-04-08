<div class="box box-primary">
    <div class="box-header">
        <h3 class="box-title">Lista de Tareas</h3><br><br>
        <button class="btn btn-primary" onclick="$('#nuevo').modal('show')"><i class="fa fa-plus mr-2"></i>Nueva Tarea</button>
    </div>
    <div class="box-body">

        <?php $this->load->view('tareas/tabla') ?>

    </div>
</div>

<!-- The Modal -->
<div class="modal modal-fade" id="nuevo">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><i class="fa fa-plus text-primary mr-2"></i>Nueva Tarea</h4>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <?php $this->load->view('tareas/form') ?>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary btn-accion" onclick="guardarTarea(this)"><i class="fa fa-save mr-2"></i>Guardar</button>
            </div>
        </div>
    </div>
</div>