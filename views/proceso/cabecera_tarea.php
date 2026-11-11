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
                        <input class="form-control" type="text" value="<?php echo $tarea->nombre ?>" readonly>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Estado:</label>
                        <input class="form-control" type="text" value="<?php echo ucfirst($tarea->estado) ?>" readonly>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Usuario Asignado:</label>
                        <input class="form-control" type="text" value="<?php echo $tarea->user_id ?>" readonly>
                    </div>
                </div>

<?php if (isset($pedido)) { ?>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Pedido de Trabajo:</label>
                        <input class="form-control" type="text" value="<?php echo $pedido ? $pedido->cod_proyecto : '' ?>" readonly>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Cliente:</label>
                        <input class="form-control" type="text" value="<?php echo $pedido ? $pedido->nom_cliente : '' ?>" readonly>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Estado del Pedido:</label>
                        <input class="form-control" type="text" value="<?php echo $pedido ? $pedido->estado : '' ?>" readonly>
                    </div>
                </div>
<?php } else { ?>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Etapa:</label>
                        <input class="form-control" type="text" value="<?php echo $etapa->titulo ?>" readonly>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Establecimiento:</label>
                        <input class="form-control" type="text" value="<?php echo $etapa->establecimiento ?>" readonly>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Lote:</label>
                        <input class="form-control" type="text" value="<?php echo $etapa->lote ?>" readonly>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Orden Producción:</label>
                        <input class="form-control" type="text" value="<?php echo $etapa->orden ?>" readonly>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Estado:</label>
                        <input class="form-control" type="text" value="<?php echo $etapa->estado ?>" readonly>
                    </div>
                </div>
<?php } ?>
            </div>
        </form>
    </div>
</div>