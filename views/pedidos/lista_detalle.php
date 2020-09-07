<table class="table table-hover">
    <thead>
        <th>Detadalle Pedido N° <?php echo bolita($detalle['data'][0]->pema_id, 'orange') ?></th>
        <th width="10%">Estado</th>
        <th width="10%">Entregado/Cantidad</th>
    </thead>
    <tbody>
        <?php
            foreach ($detalle['data'] as $o) {
                echo "<tr>";
                echo "<td><p>$o->barcode</p><small>$o->descripcion</small></td>";
                echo "<td>".($o->resto > 0 ?bolita('Incompleto'):bolita('Entregado','green'))."</td>";
                echo "<td class='text-center'>".($o->cantidad-$o->resto)." / ".round($o->cantidad,2)."</td>";
                echo "</tr>";
            }
        ?>
    </tbody>
</table>