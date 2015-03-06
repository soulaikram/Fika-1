<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
/**
 * Authme Authentication Library
 *
 * @package Authentication
 * @category Libraries
 * @author Gilbert Pellegrom
 * @link http://dev7studios.com
 * @version 1.0
 */

class Authme {

	private $CI;
	protected $PasswordHash;
	
	public function __construct()
	{
		if(!file_exists($path = dirname(__FILE__) . '/../vendor/PasswordHash.php')){
			show_error('The phpass class file was not found.');
		}
		$this->CI =& get_instance();

		$this->CI->load->database();
		$this->CI->load->library('session');
		$this->CI->load->model('authme_model');
		$this->CI->config->load('authme');
		
		include($path);
		$this->PasswordHash = new PasswordHash(8, $this->CI->config->item('authme_portable_hashes'));
	}
	
	public function logged_in()
	{

		return $this->CI->session->userdata('logged_in');
	}


    public function get_user_info(){// i added this function in order to get all the user informations

        if( !$this->logged_in()){
            return false;
        } else{
            $id=$this->CI->session->userdata('user')->id;
            $result=$this->get_user($id);
            return $result;

        }

    }
    public function get_user($user_id)// modified by ikram: i tried to built a relation one to many between
                                      //the users table and users_groups table
    {
        $query=$this->CI->db->get_where('users', array('id' => $user_id));
        $id=$query->row()->id_group;
        $query1=$this->CI->db->get_where('users_groups', array('id' => $id));
        if($query->num_rows()) {
            $user=$query->row();
            if($query1->num_rows()) {
                $user->groupId=$query1->row();
            }
            return $user;
        }
        else{
            return false;
        }
    }
	
	public function login($email, $password)
	{
		$user = $this->CI->authme_model->get_user_by_email($email);
		if($user){
			if($this->PasswordHash->CheckPassword($password, $user->password)){
				unset($user->password);
				$this->CI->session->set_userdata(array(
					'logged_in' => true,
					'user' => $user
				));
				$this->CI->authme_model->update_user($user->id, array('last_login' => date('Y-m-d H:i:s')));
				return true;
			}
		}
		 
		return false;
	}
	
	public function logout($redirect = false)
	{
		$this->CI->session->sess_destroy();
		if($redirect){
			$this->CI->load->helper('url');
			redirect($redirect, 'refresh');
		}
	}
	
	public function signup($email, $password)
	{
		$user = $this->CI->authme_model->get_user_by_email($email);
		if($user) return false;
		 
		$password = $this->PasswordHash->HashPassword($password);
		$this->CI->authme_model->create_user($email, $password);
		return true;
	}
	
	public function reset_password($user_id, $new_password)
	{
		$new_password = $this->PasswordHash->HashPassword($new_password);
		$this->CI->authme_model->update_user($user_id, array('password' => $new_password));
	}
	
}

/* End of file: authme.php */
/* Location: application/libraries/authme.php */