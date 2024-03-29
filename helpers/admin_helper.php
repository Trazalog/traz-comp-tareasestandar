<?php defined('BASEPATH') or exit('No direct script access allowed');

function bolita($texto, $color = 'gray', $detalle = null)
    {
        return "<span data-toggle='tooltip' title='$detalle' class='badge bg-$color estado'>$texto </span>";
    }

if (!function_exists('dropdown')) {

    function opcionesTabla($items)
    {
        if(isAndroid()){

            return dropdown($items);

        }else{

            return iconos($items);

        }
    }
}

if (!function_exists('iconos')) {

    function iconos($items)
    {
        $html = '';
        if(sizeof($items)){

            foreach ($items as $key => $o) {

                $html.= "<button class='btn btn-link' onclick='".$o['accion']."' title='".$o['title']."'><i class='text-primary fa ".$o['icon']."'></i></button>";
              
            }
        }

        return $html;
    }

}

if (!function_exists('dropdown')) {

    function dropdown($items)
    {
        $html = '';
        $ban = true;
        if(sizeof($items)){

            $html = '<div class="input-group-btn">
            <button type="button" class="btn btn-link dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
            <span class="fa fa-ellipsis-v fa-lg"></span></button>
            <ul class="dropdown-menu dropdown-menu-right">';

            foreach ($items as $key => $o) {

                if(!$ban){

                    $html.= '<li class="divider"></li>';

                }else{

                    $ban = false;
                    
                }

                $html.= "<li><a href='#' onclick='".$o['accion']."'><i class='text-primary fa ".$o['icon']."'></i>$key</a></li>";
              
            }
            
            $html.= "</ul></div>";

        }

        return $html;
    }

}

if (!function_exists('selectBusquedaAvanzada')) {
    function selectBusquedaAvanzada($id, $name = false, $list = false, $value = false, $label = false, $descripcion = false, $button = false)
    {
        #Convertir Datos a Arreglo
        $list = json_decode(json_encode($list), true);

        $opt = $list?"<option value='0' data-foo='' selected disabled> -  Seleccionar  - </option>":null;
        
        # Si Trae Datos Construir Opciones
        if($list) {
            foreach ($list as $o) {
                $opt .= "<option value='$o[$value]' data-json='" . json_encode($o) . "' ";

                if ($descripcion) {
                    $aux = '';
                    if (is_array($descripcion)) {

                        foreach ($descripcion as $i => $e) {
                            $o[$e] = $o[$e] ? "\"$o[$e]\"" : ' - ';
                            $aux .= '<small class"text-blue"><cite>' . (is_numeric($i) ? $o[$e] : sprintf("$i %s", $o[$e])) . '</cite></small>  <label class="text-blue">♦ </label>   ';
                        }

                    } else {
                        $aux = $o[$descripcion];
                    }
                }
                $opt .= " data-foo='$aux'>$o[$label]</option>";
            }
        }

        # Si solo pide las opciones retorna $OPT
        if(!$id) return $opt;

        $html = "<select class='form-control select2 data-json' style='width: 100%;' id='$id' name='$name' data-json=''>$opt</select>";

        # Boton de Busqueda avanzada
        if ($button) {
            $button = '<div class="input-group">%s<span class="input-group-btn"><button class="btn btn-primary" data-toggle="modal" data-target="#modal_articulos"><i class="glyphicon glyphicon-search"></i></button></span></div>';
            $html = sprintf($button, $html);

        }

        $html .= "<label id='detalle' class='select-detalle' class='text-blue'></label>";
        $html .= "<script>$('#$id').select2({matcher: matchCustom,templateResult: formatCustom}).on('change', function() { selectEvent(this);})</script>";
        return $html;
    }
}

if (!function_exists('estado')) {
	function estado($estado){
        switch (strtoupper($estado)) {
            //Estado Generales
            case 'CREADA':
                    return bolita('Creada', 'yellow');
                    break;
            case 'INICIADA':
                    return bolita('En Curso', 'green');
                    break;
            case 'FINALIZADA':
                    return bolita('Finalizado', 'red');
                    break;
            case 'PLANIFICADA':
                return bolita('Planificado', 'blue');
                break;
            //Estado por Defecto
            default:
                return bolita('S/E', '');
                break;
        }
	}
}