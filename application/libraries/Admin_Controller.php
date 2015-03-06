<?php
/**
 * Created by PhpStorm.
 * User: ikram
 * Date: 2/25/15
 * Time: 4:20 PM
 */
class Admin_Controller extends MY_Controller {


    function __construct()
    {
        // Call the Model constructor
        parent::__construct();

        $this->load->model('admin/User_Model');

    }
}
