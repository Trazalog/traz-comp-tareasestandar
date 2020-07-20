<?php defined('BASEPATH') or exit('No direct script access allowed');

function requestBox($rest, $data)
{
    $json = '';

    foreach ($data as $key => $o) {
        if ($key) {
            $json .= ',';
        }
        $aux = json_encode($o);
        $json .= substr($aux, 1, strlen($aux)-2);
    }

    $json = '{"request_box":{'.$json.'}}';

    $ci = &get_instance();

    $rsp = $ci->rest->callApi('POST', $rest . 'request_box', $json);

    return $rsp;
}
