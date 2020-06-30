<style>
.nav-tabs > li{
    font-size: 15px;    
}
</style>
<div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
        <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true"><i
                    class="fa fa-arrow-circle-right mr-2"></i>Calendario</a></li>
        <li class=""><a href="#tab_2" data-toggle="tab" aria-expanded="false"><i
                    class="fa fa-arrow-circle-right mr-2"></i>Planifiación Tareas</a></li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane active" id="tab_1">
           Calendario
        </div>
        <!-- /.tab-pane -->
        <div class="tab-pane" id="tab_2">
            <?php $this->load->view('tareas/planificacion_tareas'); ?>
        </div>
        <!-- /.tab-pane -->
    </div>
    <!-- /.tab-content -->
</div>