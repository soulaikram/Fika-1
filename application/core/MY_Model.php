<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// -----------------------------------------------------------------------------

class MY_Model extends CI_Model
{
    //setting some variables (properties)
    protected $table_name='';
    protected $primary_key = 'id';
    protected $primary_filter = 'intval'; //default filter to filter the primary key with
    protected $order_by = ''; //default order



    public function MY_Model()
    {
        $this->__construct();
    }

    /*public function __construct()
    {
        parent::__construct();
        $this->load->helper('security');

    }*/

    public function get($id= NULL, $single= FALSE){// we enter the id


        if  ($id != NULL) //if we have id !NULL
        {

        $filter= $this->primary_filter;
        $id= $filter($id);                            //we filter it
        $this->db->where($this->primary_key, $id);    //we do the where statement in the id
        $method = 'row';                            // we return a single row
        }

        elseif($single= TRUE){
            $method='row';

        }
        else {
        $method= 'result';
        }
       // if(!count($this->db->order_by)){ //if this array ie empty we set the default order
            //$this->db->order_by($this->order_by);


        //}
        return $this->db->get($this->table_name)->$method();
    }


    public function get_by($where, $single=FALSE){
        $this->db->where($where);
        return $this ->get(NULL,$single);

    }




    public function save($data, $id=NULL){ //if we have data to save : insert it  !, if we pass an id it will be an update
        //insert
        if ($id==NULL){
            !isset($data[$this->primary_key]) || $data[$this->primary_key]= NULL;
            $this->db->set($data); //setting the data
            $this->db->insert($this->table_name); //insert it to the table

        }
        //update

        else {
            $filter=$this->primary_filter;  //we filter the primary key
            $id=$filter($id);
            $this->db->set($data); //we set the data
            $this->db->where($this->primary_key,$id); //the where statement
            $this->db->update($this->$table_name); //we update


        }
        return $id;

    }


    public function delete($id){

        $filter=$this->primary_filter; //filtering the id
        $id=$filter($id);


        if(!$id){
            return FALSE; //if there is no id it return false.
        }
         //else
        $this->db->where($this->primary_key, $id);
        $this->db->limit(1);
        $this->db->delete($this->table_name); //delete id in the table_name


    }


}
/**
 * Created by PhpStorm.
 * User: ikram
 * Date: 2/25/15
 * Time: 2:37 PM
 */