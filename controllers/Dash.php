<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Dash extends CI_Controller {
    function __construct(){

      parent::__construct();
      $this->load->helper('menu_helper');
      $this->load->helper('file');
   }
   function index(){
     
      $data['menu'] = menu(file_get_contents(base_url()."/menu.json"));
      
      $this->load->view('layout/Admin',$data);
   }
}
?>