<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller {

	protected $page = NULL;
	protected $user_logged_in;
	protected $logged_user_info = NULL;
	protected $user_info = NULL;
	protected $register_errors = NULL;
	protected $register_success = NULL;
	protected $signin_errors = NULL;
	protected $notifications = NULL;
	protected $first_entry = NULL;
	protected $user_exists = NULL;
	protected $edit_errors = NULL;
	protected $edit_profile_info = NULL;
	protected $update_success = NULL;
	protected $user_table = NULL;

	protected function outside_header()
	{
		$this->load->view("outside_header.php", $this->page);
	}

	protected function inside_header()
	{
		$this->load->view("inside_header.php", $this->page);
	}

	protected function get_user_info()
	{
		$this->user_info = $this->session->userdata('user_info');
		//get user info to display once logged in, first setting returned data from database in to session
		$this->load->model('User_model');
		$this->logged_user_info = $this->User_model->get_user_info($this->user_info);
		//set session for logged user info to be able to use logged_user_info in other function when called from anywhere
		$this->session->set_userdata('logged_user_info', $this->logged_user_info);
		$this->set_user_level();
	}

	protected function set_user_level()
	{
		$this->logged_user_info = $this->session->userdata('logged_user_info');
		//check if admin or regular user, and redirect to proper place
		if($this->logged_user_info->user_level != '1')
		{
			$this->logged_user_info->user_status = 'admin';
			$this->session->set_userdata('logged_user_info', $this->logged_user_info);
		}
		else
		{
			$this->logged_user_info->user_status = 'normal';
			$this->session->set_userdata('logged_user_info', $this->logged_user_info);
		}
	}

	public function __construct()
	{
		parent::__construct();
		date_default_timezone_set('America/Los_Angeles');
	}
	
	public function index()
	{
		$this->page['title'] = "Home Page";
		$this->outside_header();
		$this->load->view('home.php');
	}

	public function register()
	{
		$this->notifications['register_errors'] = $this->session->flashdata('register_errors');
		$this->page['title'] = "Register";
		$this->outside_header();
		$this->load->view('register.php', $this->notifications);
	}

	public function signin()
	{
		$this->notifications['signin_errors'] = $this->session->flashdata('signin_errors');
		$this->page['title'] = "Sign in Page";
		$this->outside_header();
		$this->load->view('signin.php', $this->notifications);
	}

	public function process_registration()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('first_name', 'First Name', 'alpha|required|xss_clean');
		$this->form_validation->set_rules('last_name', 'Last Name', 'alpha|required|xss_clean');
		$this->form_validation->set_rules('email', 'Email', 'valid_email|required|xss_clean');
		$this->form_validation->set_rules('password', 'Password', 'min_length[8]|required|xss_clean');
		$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'matches[password]|required|xss_clean');

		if($this->form_validation->run() === FALSE)
		{
			$this->register_errors['first_name'] = form_error('first_name');
			$this->register_errors['last_name'] = form_error('last_name');
			$this->register_errors['email'] = form_error('email');
			$this->register_errors['password'] = form_error('password');
			$this->register_errors['confirm_password'] = form_error('confirm_password');
			$this->session->set_flashdata('register_errors', $this->register_errors);
			redirect(base_url('/user/register'));
		}
		else
		{
			//take email and check if user exists
			$this->user_info['email'] = $this->input->post('email');
			//send data to query in model page that will see if this entry exists in database
			$this->load->model('User_model');
			$this->user_exists = $this->User_model->check_user_exist($this->user_info);

			// if someone has that email address
			if($this->user_exists != NULL)
			{
				$this->register_errors['register_error'] = "Error: Email {$this->user_info['email']} is already in use!";
				$this->session->set_flashdata('register_errors', $this->register_errors);
				redirect(base_url('/user/register'));
			}
			else
			{
				$this->load->library('encrypt');
				$encrypted_password = $this->encrypt->encode($this->input->post('password'));
				//set user data into variables to send to database
				$this->user_info['first_name'] = $this->input->post('first_name');
				$this->user_info['last_name'] = $this->input->post('last_name');
				$this->user_info['email'] = $this->input->post('email');
				$this->user_info['password'] = $encrypted_password;
				$this->user_info['created_at'] = date('Y-m-d h:m');
				//send data to query in model page that will see if this first entry in database
				$this->load->model('User_model');
				$this->first_entry = $this->User_model->check_first_entry();
				//logic to set admin or user level
				if($this->first_entry != NULL)
				{
					$this->user_info['user_level'] = '1';
				}
				else
				{
					$this->user_info['user_level'] = '9';
				}

				//send data to query in model page that will set data in database
				$this->load->model('User_model');
				$this->User_model->register_user($this->user_info);
				//set user logged in to TRUE so when go's to welcome page will not be redirected to login page
				$this->user_logged_in = 'TRUE';
				$this->session->set_userdata('user_logged_in', $this->user_logged_in);
				//set session for user info to be able to use user_info in other function when called from anywhere
				$this->session->set_userdata('user_info', $this->user_info);
				$this->get_user_info();
				//get result info from function with user_status
				$this->logged_user_info = $this->session->userdata('logged_user_info');
				//log in based on user_status
				if($this->logged_user_info->user_status != 'admin')
				{
					//set the dashboard link to user_dashboard
					$this->page['dashboard_link'] = "/ci/user/user_dashboard";
					$this->session->set_userdata('dashboard_link', $this->page['dashboard_link']);
					//go to user_dashboard function which will login user and display user dashboard info
					redirect(base_url('/user/user_dashboard'));
				}
				else
				{
					//set the dashboard link to user_dashboard
					$this->page['dashboard_link'] = "/ci/user/admin_dashboard";
					$this->session->set_userdata('dashboard_link', $this->page['dashboard_link']);
					//go to admin_dashboard function which will login user and display admin dashboard info
					redirect(base_url('/user/admin_dashboard'));
				}
			}
		}
	}

	public function process_signin()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('email', 'Email', 'valid_email|required|xss_clean');
		$this->form_validation->set_rules('password', 'Password', 'min_length[8]|required|xss_clean');

		if($this->form_validation->run() === FALSE)
		{
			$this->signin_errors['email'] = form_error('email');
			$this->signin_errors['password'] = form_error('password');
			$this->session->set_flashdata('signin_errors', $this->signin_errors);
			redirect(base_url('/user/signin'));
		}
		else
		{
			//set user data into variables to get user data with query
			$this->user_info['email'] = $this->input->post('email');
			$this->user_info['password'] = $this->input->post('password');
			//get user info to display once logged in, first setting returned data from database in to session
			$this->load->model('User_model');
			$this->logged_user_info = $this->User_model->get_user_info($this->user_info);
			
			if($this->logged_user_info != NULL)
			{	
				$this->load->library('encrypt');
				$decrypted_password = $this->encrypt->decode($this->logged_user_info->password);
				
				if($this->user_info['password'] === $decrypted_password)
				{
					$this->user_logged_in = 'TRUE';
					$this->session->set_userdata('user_logged_in', $this->user_logged_in);
					//set session for logged user info to be able to use logged_user_info in other function when called from anywhere
					$this->session->set_userdata('logged_user_info', $this->logged_user_info);
					//go to function which checks user status
					$this->set_user_level();
					//get result info from function with user_status
					$this->logged_user_info = $this->session->userdata('logged_user_info');
					//log in based on user_status
					if($this->logged_user_info->user_status != 'admin')
					{
						//set the dashboard link to user_dashboard
						$this->page['dashboard_link'] = "/ci/user/user_dashboard";
						$this->session->set_userdata('dashboard_link', $this->page['dashboard_link']);
						//go to user_dashboard function which will login user and display user dashboard info
						redirect(base_url('/user/user_dashboard'));
					}
					else
					{
						//set the dashboard link to user_dashboard
						$this->page['dashboard_link'] = "/ci/user/admin_dashboard";
						$this->session->set_userdata('dashboard_link', $this->page['dashboard_link']);
						//go to admin_dashboard function which will login user and display admin dashboard info
						redirect(base_url('/user/admin_dashboard'));
					}

				}
				else
				{
					$this->signin_errors['signin_error'] = "Error: The information entered does not match any of our records!";
					$this->session->set_flashdata('signin_errors', $this->signin_errors);
					redirect(base_url('/user/signin'));
				}				
			}
			else
			{
				$this->signin_errors['signin_error'] = "Error: The information entered does not match any of our records!";
				$this->session->set_flashdata('signin_errors', $this->signin_errors);
				redirect(base_url('/user/signin'));
			}
		}
	}

	public function admin_dashboard()
	{
		$this->user_logged_in = $this->session->userdata('user_logged_in');
		$this->logged_user_info = $this->session->userdata('logged_user_info');

		if(!empty($this->user_logged_in) and $this->logged_user_info->user_status != 'normal')
		{
			$this->logged_user_info->user_rows = $this->users_list();
			$this->page['dashboard_link'] = $this->session->userdata('dashboard_link');
			$this->page['title'] = "Admin Dashboard";
			// $this->logged_user_info = $this->session->userdata('logged_user_info');
			$this->inside_header();
			$this->load->view('admin_dashboard.php', $this->logged_user_info);
		}
		else
		{
			redirect(base_url('/user/log_off'));
		}
	}

	public function new_user()
	{
		$this->user_logged_in = $this->session->userdata('user_logged_in');
		$this->logged_user_info = $this->session->userdata('logged_user_info');

		if(!empty($this->user_logged_in) and $this->logged_user_info->user_status != 'normal')
		{
			$this->notifications['register_success'] = $this->session->flashdata('register_success');
			$this->notifications['register_errors'] = $this->session->flashdata('register_errors');
			$this->page['dashboard_link'] = $this->session->userdata('dashboard_link');
			$this->page['title'] = "New User";
			$this->inside_header();
			$this->load->view('new_user.php', $this->notifications);
		}
		else
		{
			redirect(base_url('/user/log_off'));
		}	
	}

	public function process_new_user()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('first_name', 'First Name', 'alpha|required|xss_clean');
		$this->form_validation->set_rules('last_name', 'Last Name', 'alpha|required|xss_clean');
		$this->form_validation->set_rules('email', 'Email', 'valid_email|required|xss_clean');
		$this->form_validation->set_rules('password', 'Password', 'min_length[8]|required|xss_clean');
		$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'matches[password]|required|xss_clean');

		if($this->form_validation->run() === FALSE)
		{
			$this->register_errors['first_name'] = form_error('first_name');
			$this->register_errors['last_name'] = form_error('last_name');
			$this->register_errors['email'] = form_error('email');
			$this->register_errors['password'] = form_error('password');
			$this->register_errors['confirm_password'] = form_error('confirm_password');
			$this->session->set_flashdata('register_errors', $this->register_errors);
			redirect(base_url('/user/new_user'));
		}
		else
		{
			//take email and check if user exists
			$this->user_info['email'] = $this->input->post('email');
			//send data to query in model page that will see if this entry exists in database
			$this->load->model('User_model');
			$this->user_exists = $this->User_model->check_user_exist($this->user_info);

			// if someone has that email address
			if($this->user_exists != NULL)
			{
				$this->register_errors['register_error'] = "Error: Email {$this->user_info['email']} is already in use!";
				$this->session->set_flashdata('register_errors', $this->register_errors);
				redirect(base_url('/user/new_user'));
			}
			else
			{
				$this->load->library('encrypt');
				$encrypted_password = $this->encrypt->encode($this->input->post('password'));
				//set user data into variables to send to database
				$this->user_info['first_name'] = $this->input->post('first_name');
				$this->user_info['last_name'] = $this->input->post('last_name');
				$this->user_info['email'] = $this->input->post('email');
				$this->user_info['password'] = $encrypted_password;
				$this->user_info['created_at'] = date('Y-m-d h:m');
				//add success message for new user page
				$this->register_success['message'] = "New user successfully created";
				$this->session->set_flashdata('register_success', $this->register_success);
				//send data to query in model page that will see if this first entry in database
				$this->load->model('User_model');
				$this->first_entry = $this->User_model->check_first_entry();
				//logic to set admin or user level
				if($this->first_entry != NULL)
				{
					$this->user_info['user_level'] = '1';
				}
				else
				{
					$this->user_info['user_level'] = '9';
				}
				//send data to query in model page that will set data in database
				$this->load->model('User_model');
				$this->User_model->register_user($this->user_info);
				//go to new_user function which will display success message
				redirect(base_url('/user/new_user'));
			}
		}
	}

	public function edit_user()
	{
		$this->user_logged_in = $this->session->userdata('user_logged_in');
		$this->logged_user_info = $this->session->userdata('logged_user_info');

		if(!empty($this->user_logged_in)  and $this->logged_user_info->user_status != 'normal')
		{
			$this->notifications['edit_errors'] = $this->session->flashdata('edit_errors');
			$this->page['dashboard_link'] = $this->session->userdata('dashboard_link');
			$this->page['title'] = "Edit User";
			$this->inside_header();
			$this->load->view('edit_user.php', $this->notifications);	
		}
		else
		{
			redirect(base_url('/user/log_off'));
		}
	}

	public function process_edit_user_info()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('first_name', 'First Name', 'alpha|required|xss_clean');
		$this->form_validation->set_rules('last_name', 'Last Name', 'alpha|required|xss_clean');
		$this->form_validation->set_rules('email', 'Email', 'valid_email|required|xss_clean');

		if($this->form_validation->run() === FALSE)
		{
			$this->edit_errors['first_name'] = form_error('first_name');
			$this->edit_errors['last_name'] = form_error('last_name');
			$this->edit_errors['email'] = form_error('email');
			$this->session->set_flashdata('edit_errors', $this->edit_errors);
			redirect(base_url('/user/edit_user'));
		}
		else
		{

		}
	}

	public function process_edit_user_pw()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('password', 'Password', 'min_length[8]|required|xss_clean');
		$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'matches[password]|required|xss_clean');

		if($this->form_validation->run() === FALSE)
		{
			$this->edit_errors['password'] = form_error('password');
			$this->edit_errors['confirm_password'] = form_error('confirm_password');
			$this->session->set_flashdata('edit_errors', $this->edit_errors);
			redirect(base_url('/user/edit_user'));
		}
		else
		{

		}
	}

	public function user_dashboard()
	{
		$this->user_logged_in = $this->session->userdata('user_logged_in');

		if(!empty($this->user_logged_in))
		{
			$this->user_table['user_rows'] = $this->users_list();
			$this->page['dashboard_link'] = $this->session->userdata('dashboard_link');
			$this->page['title'] = "User Dashboard";
			$this->inside_header();
			$this->load->view('user_dashboard.php', $this->user_table);
		}
		else
		{
			redirect(base_url('/user/log_off'));
		}		
	}

	public function users_list()
	{
		$this->load->model('User_model');
		return $this->User_model->get_users_list();
		// $this->session->set_userdata('user_table', $this->user_table['user_rows']);
		// $this->user_dashboard();
	}

	public function user_profile()
	{
		$this->user_logged_in = $this->session->userdata('user_logged_in');

		if(!empty($this->user_logged_in))
		{
			$this->page['dashboard_link'] = $this->session->userdata('dashboard_link');
			$this->page['title'] = "User Information";
			$this->inside_header();
			$this->load->view('user_profile.php');
		}
		else
		{
			redirect(base_url('/user/log_off'));
		}		
	}

	public function edit_profile()
	{
		$this->user_logged_in = $this->session->userdata('user_logged_in');

		if(!empty($this->user_logged_in))
		{
			$this->notifications['update_success'] = $this->session->flashdata('update_success');
			$this->notifications['edit_errors'] = $this->session->flashdata('edit_errors');
			$this->page['dashboard_link'] = $this->session->userdata('dashboard_link');
			$this->page['title'] = "Edit Profile";
			$this->inside_header();
			$this->load->view('edit_profile.php', $this->notifications);
		}
		else
		{
			redirect(base_url('/user/log_off'));
		}
	}

	public function process_edit_profile_info()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('first_name', 'First Name', 'alpha|required|xss_clean');
		$this->form_validation->set_rules('last_name', 'Last Name', 'alpha|required|xss_clean');
		$this->form_validation->set_rules('email', 'Email', 'valid_email|required|xss_clean');

		if($this->form_validation->run() === FALSE)
		{
			$this->edit_errors['first_name'] = form_error('first_name');
			$this->edit_errors['last_name'] = form_error('last_name');
			$this->edit_errors['email'] = form_error('email');
			$this->session->set_flashdata('edit_errors', $this->edit_errors);
			redirect(base_url('/user/edit_profile'));
		}
		else
		{
			$this->logged_user_info = $this->session->userdata('logged_user_info');
			//set user data into variables to send to database
			$this->edit_profile_info['id'] = $this->logged_user_info->id;
			$this->edit_profile_info['first_name'] = $this->input->post('first_name');
			$this->edit_profile_info['last_name'] = $this->input->post('last_name');
			$this->edit_profile_info['email'] = $this->input->post('email');
			$this->edit_profile_info['updated_at'] = date('Y-m-d h:m');
			//add success message for new user page
			$this->update_success['info_message'] = "Information successfully updated";
			$this->session->set_flashdata('update_success', $this->update_success);
			//send data to query in model page that will set data in database
			$this->load->model('User_model');
			$this->User_model->update_profile_info($this->edit_profile_info);
			//go to new_user function which will display success message
			redirect(base_url('/user/edit_profile'));
		}
	}

	public function process_edit_profile_pw()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('password', 'Password', 'min_length[8]|required|xss_clean');
		$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'matches[password]|required|xss_clean');

		if($this->form_validation->run() === FALSE)
		{
			$this->edit_errors['password'] = form_error('password');
			$this->edit_errors['confirm_password'] = form_error('confirm_password');
			$this->session->set_flashdata('edit_errors', $this->edit_errors);
			redirect(base_url('/user/edit_profile'));
		}
		else
		{
			$this->logged_user_info = $this->session->userdata('logged_user_info');
			//load library to encrypt password
			$this->load->library('encrypt');
			$encrypted_password = $this->encrypt->encode($this->input->post('password'));
			//set user data into variables to send to database
			$this->edit_profile_info['id'] = $this->logged_user_info->id;
			$this->edit_profile_info['password'] = $encrypted_password;
			$this->edit_profile_info['updated_at'] = date('Y-m-d h:m');
			//add success message for new user page
			$this->update_success['pw_message'] = "Information successfully updated";
			$this->session->set_flashdata('update_success', $this->update_success);
			//send data to query in model page that will set data in database
			$this->load->model('User_model');
			$this->User_model->update_profile_info($this->edit_profile_info);
			//go to new_user function which will display success message
			redirect(base_url('/user/edit_profile'));
		}
	}

	public function process_edit_profile_description()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('description', 'Description', 'required|xss_clean');

		if($this->form_validation->run() === FALSE)
		{
			$this->edit_errors['description'] = form_error('description');
			$this->session->set_flashdata('edit_errors', $this->edit_errors);
			redirect(base_url('/user/edit_profile'));
		}
		else
		{
			$this->logged_user_info = $this->session->userdata('logged_user_info');
			//set user data into variables to send to database
			$this->edit_profile_info['id'] = $this->logged_user_info->id;
			$this->edit_profile_info['description'] = $this->input->post('description');
			$this->edit_profile_info['updated_at'] = date('Y-m-d h:m');
			//add success message for new user page
			$this->update_success['description_message'] = "Information successfully updated";
			$this->session->set_flashdata('update_success', $this->update_success);
			//send data to query in model page that will set data in database
			$this->load->model('User_model');
			$this->User_model->update_profile_info($this->edit_profile_info);
			//go to new_user function which will display success message
			redirect(base_url('/user/edit_profile'));
		}
	}

	public function log_off()
	{
		$this->session->sess_destroy();
		redirect(base_url('/'));
	}

}

/* End of file user.php */
/* Location: /application/controllers/user.php */