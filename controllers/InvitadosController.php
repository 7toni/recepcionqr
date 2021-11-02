<?php

class InvitadosController {

    public function __construct() {
        $this->name = "invitados";   
        $this->model = [
            'invitados' => new Invitados(),
        ];    
    }

    public function index() {         
        include view($this->name . '.read');
    }

    public function form_ajax(){
        $code = $_POST[0];

        $data= $this->model['invitados']->find_by(['code'=>$code],"view_invitados");        
        //var_dump($data);
        echo json_encode($data);
    }
    
}