<?php
/**
 * Created by PhpStorm.
 * User: ikram
 * Date: 2/25/15
 * Time: 4:02 PM
 */
 Class User_Model extends MY_Model
 {

     protected $table_name='users';
     protected $primary_key = 'id';
     protected $primary_filter = 'intval';
     protected $order_by = 'order';





     /*function __construct(){

         parent::MY_Model();
         $this->table_name='users';
         $this->primary_key='id';
         $this->primary_filt='intval';
         $this->order_by='order';
     }

     protected $table = 'users'; // pour les tests*/

 }