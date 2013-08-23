<?php

class User_model extends CI_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    function check_first_entry()
    {
        return $this->db->query("SELECT * FROM users WHERE id = '1'")->row();
    }

    function check_user_exist($user_info)
    {
        return $this->db->query("SELECT * FROM users WHERE email = '{$user_info['email']}'")->row();
    }

    function register_user($user_info)
    {
        $this->db->insert('users', $user_info);
    }

    function get_user_info($user_info)
    {
        return $this->db->query("SELECT * FROM users WHERE email = '{$user_info['email']}'")->row();
    }

    function update_profile_info($edit_info)
    {
        $this->db->where('id', $edit_info['id']);
        $this->db->update('users', $edit_info);
    }

    function get_users_list()
    {
        return $this->db->query("SELECT id, first_name, last_name, email, created_at, user_level 
                                FROM users")->result_array();
        
    }
}
/* End of file login_model.php */
/* Location: /application/models/login_model.php */