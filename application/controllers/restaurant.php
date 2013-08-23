<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Restaurant extends CI_Controller {

	protected $id;
	protected $page = NULL;
	protected $home_search = NULL;
	protected $inside_search = NULL;
	protected $restaurants_results = NULL;
	protected $html = NULL;
	protected $checked_box = NULL;
	protected $total_average = NULL;
	protected $restaurants_sorted = NULL;
	protected $restaurants_info = NULL;

	public function __construct()
	{
		parent::__construct();
		date_default_timezone_set('America/Los_Angeles');
	}
	
	public function index()
	{
		$this->load->view('restaurant_home.php');
	}

	public function process_home_search()
	{	
		// $name = $this->input->post('name');
		// if(! empty($name))
		// {
		// 	$this->home_search['name'] = $name;
		// }
		// else
		// {
		$this->home_search['name'] = $this->input->post('name');				
		// }

		$this->home_search['location'] = $this->input->post('location');
		
		//this finds out which boxes were checked and assigns to array with key of category id.
		for ($i=1; $i < 5; $i++)
		{
			if($this->input->post($i) === "checked")
			{
				$this->checked_box[$i] = $this->input->post($i);
			}
		}
		//this sets the variable/array created to session to be avilable in other function (didn't need here because the variable was created outside this function, so it can be accessed through calling $this->variable)
		$this->session->set_userdata('checked_box', $this->checked_box);
		$this->html['check'] = $this->checked_box;
		$this->html['list'] = $this->get_restaurants_list($this->home_search);
		//this sets the placeholder for the input field on inside page based on which input fields were filled out on home page.
		// if($this->home_search['name'] === $this->home_search['location'])
		// {
			if(!empty($this->home_search['name']) and !empty($this->home_search['location']))
			{
				$this->html['placeholder'] = $this->home_search['name'] . ", " . $this->home_search['location'];
			}
			elseif(!empty($this->home_search['location']))
			{
				$this->html['placeholder'] = $this->home_search['location'];
			}
			elseif(!empty($this->home_search['name']))
			{
				$this->html['placeholder'] = $this->home_search['name'];
			}
		// }
		// else
		// {
		// 	$this->html['placeholder'] = $this->home_search['location'];
		// }
		$this->html['title'] = "List of Restaurants";
		$this->load->view('restaurant_list.php', $this->html);
	}

	public function process_inside_search()
	{	
		$this->inside_search['location'] = $this->input->post('location');

		for ($i=1; $i < 5; $i++)
		{
			if($this->input->post($i) === "checked")
			{
				$this->checked_box[$i] = $this->input->post($i);
			}
		}
		$this->session->set_userdata('checked_box', $this->checked_box);
		$this->html['placeholder'] = $this->inside_search['location'];
		$this->html['check'] = $this->checked_box;
		$this->html['list'] = $this->get_restaurants_list_inside($this->inside_search);
		$this->html['title'] = "List of Restaurants";
		$this->load->view('restaurant_list.php', $this->html);
	}

	public function get_restaurants_list_inside($search)
	{
		$this->load->model('Restaurant_model');
		$this->restaurants_results = $this->Restaurant_model->get_restaurants_info_inside($search);
		$this->checked_box = $this->session->userdata('checked_box');
		if(! empty($this->restaurants_results))
		{		
			foreach($this->restaurants_results as $restaurant)
			{
				$ratings = 0;
				for($i=1; $i<5; $i++)
				{
					if(isset($this->checked_box[$i]))
					{
						$ratings += $restaurant[$i];
					}
				}

				$this->total_average[strval($restaurant['id'])] = $ratings;

				arsort($this->total_average);
			}

			foreach ($this->total_average as $key => $value) 
			{
				foreach ($this->restaurants_results as $restaurant) 
				{
					if($key == $restaurant['id'])
					{
						$this->restaurants_sorted[] = $restaurant;
					}
				}
			}

			$this->html['list'] = "";
			$this->session->set_userdata('restaurants_sorted', $this->restaurants_sorted);

			foreach($this->restaurants_sorted as $restaurant)
	    	{
	    		$this->html['list'] .= "
		    		<div class='restaurant_info'>
						<h3>
							<img class='float_left' src='{$restaurant['image_path']}' alt='restaurant image'>
							<a href='/ci/restaurant/get_restaurant_details/?={$restaurant['id']}'>{$restaurant['name']}</a>
						</h3>
						<p>{$restaurant['address']}</p>
						<p>{$restaurant['city']}, {$restaurant['state']}</p>
						<ul class='categories'>
							<li>Affordability</li>
							<li>Ambiance</li>
							<li>Food Quality</li>
							<li>Service</li>
						</ul>
						<ul class='ratings'>
							<li><img src='/ci/ssets/images/{$restaurant[1]}_star.png' alt'star_ratings' /></li>
							<li><img src='/ci/assets/images/{$restaurant[2]}_star.png' alt'star_ratings' /></li>
							<li><img src='/ci/assets/images/{$restaurant[3]}_star.png' alt'star_ratings' /></li>
							<li><img src='/ci/assets/images/{$restaurant[4]}_star.png' alt'star_ratings' /></li>
						</ul>
					</div>";
	    	}
	    	return $this->html;
		}
		else
		{
			$this->html['error_message'] = "Please put in a valid input!";
			return $this->html;
		}
	}

	public function get_restaurants_list($search)
	{
		//go to modal get the restaurant info, with total rating info
		$this->load->model('Restaurant_model');
		$this->restaurants_results = $this->Restaurant_model->get_restaurants_info($search);
		//this unsets the session data back to a local variable
		$this->checked_box = $this->session->userdata('checked_box');
		//this for loops through the restaurant results multidimensinal array to determine which restaurant has the highest percentage result to display in desending order. 
		foreach($this->restaurants_results as $restaurant)
		{
			//variable to use to add the rates in to.
			$ratings = 0;
			//once inside the first array in the 'parent' array, will go in to the fields, and find the first 'number' field, (which in our case are the fields which hold the ratings).
			for($i=1; $i<5; $i++)
			{
				// Go through each one of these on till finds the one that equals the number found in the checked box variable.
				if(isset($this->checked_box[$i]))
				{
					// When it finds it, it will store the value of the rating (from the current 'key' number) in to the ratings variable.
					$ratings += $restaurant[$i];
				}
			}
			//set this new variable to the ratings total of this restaurant
			$this->total_average[strval($restaurant['id'])] = $ratings;
			//then start the loop over for the next restaurant array in 'parent' array.
		}
		//will sort the new array (which holds in it 'key' (as - restaurant id), 'value' (as - rating total for that restaurant) ) in order of the highest average in reverse order (meaning highest first)
		arsort($this->total_average);
		//this will reset our original restaurant result array in to our new order that we have in the total average array.
		//Go in to total average array
		foreach ($this->total_average as $key => $value) 
		{	
			//Go in to the restaurant result array
			foreach ($this->restaurants_results as $restaurant) 
			{
				//see if the key of the current total average array equals the restaurant id of the restaurant result array
				if($key == $restaurant['id'])
				{	
					//if it doe's, send the current restaurant array (with the restaurant id just found) in to the new array
					$this->restaurants_sorted[] = $restaurant;
				}
				//then all the other restaurant results id's don't match the current key of the total average array
			}
			//then go to next key value pair in the total average array and run through the second forloop again putting the next restaurant result array id that matches the key in to the restaurant_sorted new array. And then are new array will be ordered in the order we want it in, and we display that in the html coming up next.
		}

		$this->session->set_userdata('restaurants_sorted', $this->restaurants_sorted);

		$this->html['list'] = "";
		foreach($this->restaurants_sorted as $restaurant)
    	{
    		$this->html['list'] .= "
	    		<div class='restaurant_info'>
					<h3>
						<img class='float_left' src='{$restaurant['image_path']}' alt='restaurant image'>
						<a href='/ci/restaurant/get_restaurant_details/?={$restaurant['id']}'>{$restaurant['name']}</a>
					</h3>
					<p>{$restaurant['address']}</p>
					<p>{$restaurant['city']}, {$restaurant['state']}</p>
					<ul class='categories'>
						<li>Affordability</li>
						<li>Ambiance</li>
						<li>Food Quality</li>
						<li>Service</li>
					</ul>
					<ul class='ratings'>
						<li><img src='/ci/assets/images/{$restaurant[1]}_star.png' alt'star_ratings' /></li>
						<li><img src='/ci/assets/images/{$restaurant[2]}_star.png' alt'star_ratings' /></li>
						<li><img src='/ci/assets/images/{$restaurant[3]}_star.png' alt'star_ratings' /></li>
						<li><img src='/ci/assets/images/{$restaurant[4]}_star.png' alt'star_ratings' /></li>
					</ul>
				</div>";
    	}
    	return $this->html['list'];
	}

	public function get_restaurant_details()
	{
		$this->id = $_SERVER['REQUEST_URI'];
		$this->id = explode("=", $this->id);

		// var_dump($this->session->all_userdata());
		// die();
		$this->restaurants_info['restaurants_results'] = $this->session->userdata('restaurants_sorted');
		$this->restaurants_sorted = $this->restaurants_info['restaurants_results'];
		// var_dump($this->restaurants_sorted);
		// die();
		$this->html['list'] = "";
		foreach($this->restaurants_sorted as $restaurant) 
		{
			if($restaurant['id'] === $this->id[1])
			{
				$this->html['detailed'] = "
					<h3 id='restaurant_name'>
						<img class='float_left' src='' alt=''>
						<a href=''>{$restaurant['name']}</a>
					</h3>
					<p>{$restaurant['address']}</p>
					<p>{$restaurant['city']}, {$restaurant['state']}</p>
					<a data-toggle='modal' href='#rate' class='rate_button btn btn-primary btn-lg'>Rate this restaurant</a>
					<a class='clear float_left' href=''>{$restaurant['website']}</a>";
			}
			else
			{
				$this->html['list'] .= "
	    		<div class='restaurant_info'>
					<h3>
						<img class='float_left' src='{$restaurant['image_path']}' alt='restaurant image'>
						<a href='/ci/restaurant/get_restaurant_details/?={$restaurant['id']}'>{$restaurant['name']}</a>
					</h3>
					<p>{$restaurant['address']}</p>
					<p>{$restaurant['city']}, {$restaurant['state']}</p>
					<ul class='categories'>
						<li>Affordability</li>
						<li>Ambiance</li>
						<li>Food Quality</li>
						<li>Service</li>
					</ul>
					<ul class='ratings'>
						<li><img src='/ci/assets/images/{$restaurant[1]}_star.png' alt'star_ratings' /></li>
						<li><img src='/ci/assets/images/{$restaurant[2]}_star.png' alt'star_ratings' /></li>
						<li><img src='/ci/assets/images/{$restaurant[3]}_star.png' alt'star_ratings' /></li>
						<li><img src='/ci/assets/images/{$restaurant[4]}_star.png' alt'star_ratings' /></li>
					</ul>
				</div>";
			}
		}
		$this->html['title'] = "Detailed Restaurant Page";
		$this->load->view('restaurant_details.php', $this->html);
	}
	
}

/* End of file restaurant.php */
/* Location: /application/controllers/restaurant.php */