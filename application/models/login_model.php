<?php

class Login_model extends CI_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    function register_user($user_info)
    {
        $this->db->insert('users', $user_info);
    }

    function get_user_info($user_info)
    {
        return $this->db->query("SELECT * FROM users WHERE email = '{$user_info['email']}'")->row();
    }
}
/* End of file login_model.php */
/* Location: /application/models/login_model.php */