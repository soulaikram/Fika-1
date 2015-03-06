<?php
/**
 * Created by PhpStorm.
 * User: ikram
 * Date: 2/27/15
 * Time: 11:54 AM
 */

class page extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
       $this->load->model('page_m');


    }

    public function index(){
    $users=$this->page_m->get();
        var_dump($users);


    }

    public function save(){
        $data=array(
            'id'=>'3',
            'email'=>'qsqsqaaasqsq',
            'created_on'=>'2015-02-04 00:00:00',
            'modified_on'=>'2015-02-04 00:00:00',
            'last_logon'=>'2015-02-04 00:00:00',
            'groupId'=>'3',
            'token'=>'dcdcdcdcdcd',

        );

        $id=$this->page_m->save($data);
        var_dump($id);
    }


    public function delete(){
        $this->page_m->delete(1);
    }





}