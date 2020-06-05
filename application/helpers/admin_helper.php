<?php defined('BASEPATH') or exit('No direct script access allowed');

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

                $html.= "<button class='btn btn-link' onclick='".$o['accion']."'><i class='text-primary fa ".$o['icon']."'></i></button>";
              
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