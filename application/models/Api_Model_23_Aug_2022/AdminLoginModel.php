<?php

defined('BASEPATH') OR exit('No direct script access allowed');

Class AdminLoginModel extends MY_Model {


    public function adminLogin($postdata) {

        $this->db->where(['email' => $postdata['email']]);
        $this->db->where(['type' => 'Superadmin']);
        $this->db->where(['password' => md5($postdata['password'])]);
        $query = $this->db->get('users');
        if ($query->num_rows() > 0) {
            return  $query->row_array();
        } else {         
            return  false;
        }

    }

}
