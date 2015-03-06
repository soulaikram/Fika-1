<?php
/**
 * Authme Authentication Library
 *
 * @package Authentication
 * @category Libraries
 * @author Gilbert Pellegrom
 * @link http://dev7studios.com
 * @version 1.0
 */

class Authme_model extends CI_Model {

	public $users_table;
    public $ikram;
	
	public function __construct()
	{
		parent::__construct();

		$this->load->database();
		$this->config->load('authme');

		$this->users_table = $this->config->item('authme_users_table');
        $this->ikram=$this->get_user(2);
        //print_r($this->ikram); exit;
		
		if(!$this->db->table_exists($this->users_table)) $this->create_users_table();
	}
	
	public function get_user($user_id) // modified by ikram: i tried to built a relation one to many between
                                       //the users table and users_groups table
	{


        $query=$this->db->get_where($this->users_table, array('id' => $user_id));//$query contains the user
                                                                                 //with $id = $user_id
        $id=$query->row()->id_group; //$id contains the $id_group of this user.
        $query1=$this->db->get_where('users_groups', array('id' => $id));// $query1 contains the row of users_groups
                                                                         //in which $id = $id_groups
		if($query->num_rows()) {
            $user=$query->row();
            if($query1->num_rows()) {
                $user->id_group=$query1->row();
            }
            return $user;
        }
		else{
            return false;
        }
	}
	
	public function get_user_by_email($email)
	{
		$query = $this->db->get_where($this->users_table, array('email' => $email));

		if($query->num_rows()) {
            $user=$query->row();
            return $user;
        }else{
            return false;
        }

	}
	
	public function get_users($order_by = 'id', $order = 'asc', $limit = 0, $offset = 0)
	{
		$this->db->order_by($order_by, $order); 
		if($limit) $this->db->limit($limit, $offset);
		$query = $this->db->get($this->users_table);
        $usr=$query->result();

		return $usr;
	}

	public function get_user_count()
	{
		return $this->db->count_all($this->users_table);
	}
	
	public function create_user($email, $password)
	{
		$data = array(
			'email' => filter_var($email, FILTER_SANITIZE_EMAIL),
			'password' => $password, // Should be hashed
			'created' => date('Y-m-d H:i:s')
		);
		$this->db->insert($this->users_table, $data);
		return $this->db->insert_id();
	}
	
	public function update_user($user_id, $data)
	{
		$this->db->where('id', $user_id);
		$this->db->update($this->users_table, $data); 
	}
	
	public function delete_user($user_id)
	{
		$this->db->delete($this->users_table, array('id' => $user_id));
	}
	
	private function create_users_table()
	{
		$this->load->dbforge();
		$this->dbforge->add_field('id INT(11) NOT NULL AUTO_INCREMENT');
		$this->dbforge->add_field('email VARCHAR(200) NOT NULL');
		$this->dbforge->add_field('password VARCHAR(200) NOT NULL');
		$this->dbforge->add_field('created DATETIME NOT NULL');
		$this->dbforge->add_field('last_login DATETIME NOT NULL');
		$this->dbforge->add_key('id', true);
		$this->dbforge->create_table($this->users_table);
	}
	
}

/* End of file: authme_model.php */
/* Location: application/models/authme_model.php */