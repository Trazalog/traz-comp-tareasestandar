<div class="box box-primary box-solid collapsed-box">
    <div class="box-header with-border">
        <h3 class="box-title">Detalles Tarea</h3>

        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" onclick="collapse(this)"><i
                    class="fa fa-plus"></i>
            </button>
        </div>
        <!-- /.box-tools -->
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <form>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Tarea:</label>
                        <input class="form-control" type="text" value="<?php echo $nombre ?>" readonly>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Fecha:</label>
                        <input class="form-control" type="text" value="<?php echo formatFechaPG($fecha)?>" readonly>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                       <label>Usuario Asignado:</label>
                       <input class="form-control" type="text" value="<?php echo $user_id ?>" readonly>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!-- /.box-body -->
</div>