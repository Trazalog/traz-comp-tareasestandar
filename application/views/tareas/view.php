<div class="box box-primary">

    <div class="box-body">
        <div class="row">

            <div class="col-sm-6">
                <?php $this->load->view('tareas/componentes/view_tareas'); ?>
            </div>
            <div class="col-sm-6">
                <?php $this->load->view('tareas/componentes/view_plantillas'); ?>
            </div>

        </div>
    </div>
</div>

<div class="box box-primary">

    <div class="box-body">
        <table class="table table-striped table-hover table-bordered">
            <thead class="text-light-blue" style="font-size:110%">
                <tr>
                    <th>#</td>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Duración STD</th>
                    <th class="text-right">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>?</td>
                    <td>???</td>
                    <td>???</td>
                    <td>???</td>
                    <td class="text-right">???</td>
                </tr>
            </tbody>
        </table>
        <button class="btn btn-primary" style="float:right">Guardar</button>
    </div>
</div>