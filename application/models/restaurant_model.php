<?php

class Restaurant_model extends CI_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    public function get_restaurants_info($restaurant_search)
    {
    	//query for all restaurants info
    	$restaurants = $this->db->query("SELECT * FROM restaurants AS t1
							    		 WHERE t1.name LIKE '%{$restaurant_search['name']}%'
										 OR t1.address LIKE '%{$restaurant_search['location']}%' 
										 OR t1.city LIKE '%{$restaurant_search['location']}%' 
										 OR t1.state LIKE '%{$restaurant_search['location']}%' 
										 OR t1.country LIKE '%{$restaurant_search['location']}%' 
										 OR t1.zip_code = '{$restaurant_search['location']}'")->result_array();

    	foreach($restaurants as $restaurant)
    	{    		
	    	if(! preg_match("/\b{$restaurant_search['location']}\b/i", $restaurant['address']))
	    	{
	    		$restaurants_results_new[] = $restaurant;
	    	}
	    	else
	    	{
	    		$restaurants_same[] = $restaurant;
	    	}
    	}

    	if(isset($restaurants_results_new))
    	{	
	    	for($i = 0; $i<count($restaurants_results_new); $i++)
	    	{	
	    		$restaurants_results_new[$i] += $this->get_restaurants_ratings_list($restaurants_results_new[$i]['id']);  		
	    	}
	    	return $restaurants_results_new;		
    	}
    	elseif(isset($restaurants_same))
    	{
    		for($i = 0; $i<count($restaurants_same); $i++)
	    	{	
	    		$restaurants_same[$i] += $this->get_restaurants_ratings_list($restaurants_same[$i]['id']);  		
	    	}
	    	return $restaurants_same;
    	}
    }

    public function get_restaurants_info_inside($restaurant_search)
   	{
   		//query for all restaurants info
    	$restaurants = $this->db->query("SELECT * FROM restaurants AS t1
							    		 WHERE t1.name LIKE '%{$restaurant_search['location']}%'
										 OR t1.address LIKE '%{$restaurant_search['location']}%' 
										 OR t1.city LIKE '%{$restaurant_search['location']}%' 
										 OR t1.state LIKE '%{$restaurant_search['location']}%' 
										 OR t1.country LIKE '%{$restaurant_search['location']}%' 
										 OR t1.zip_code = '{$restaurant_search['location']}'")->result_array();

    	foreach($restaurants as $restaurant)
    	{    		
	    	if(! preg_match("/\b{$restaurant_search['location']}\b/i", $restaurant['address']))
	    	{
	    		$restaurants_results_new[] = $restaurant;
	    	}
	    	else
	    	{
	    		$restaurants_same[] = $restaurant;
	    	}
    	}

    	if(isset($restaurants_results_new))
    	{	
	    	for($i = 0; $i<count($restaurants_results_new); $i++)
	    	{	
	    		$restaurants_results_new[$i] += $this->get_restaurants_ratings_list($restaurants_results_new[$i]['id']);  		
	    	}
	    	return $restaurants_results_new;		
    	}
    	elseif(isset($restaurants_same))
    	{
    		for($i = 0; $i<count($restaurants_same); $i++)
	    	{	
	    		$restaurants_same[$i] += $this->get_restaurants_ratings_list($restaurants_same[$i]['id']);  		
	    	}
	    	return $restaurants_same;
    	}
   	}

    public function get_restaurants_ratings_list($restaurant_id)
    {	

    	//getting first (affordability) category ratings 
    	$total_people =  $this->db->query("SELECT COUNT(rating) AS count_people
    							 FROM reviews
								 WHERE restaurant_id = '{$restaurant_id}' 
								 AND category_id = '1'")->row();
    	
    	$total_stars = $this->db->query("SELECT SUM(rating) AS sum_stars
    							 FROM reviews
								 WHERE restaurant_id = '{$restaurant_id}' 
								 AND category_id = '1'")->row();
    	
    	if(floatval($total_people->count_people) != 0)
    	{	
    		$ratings['1'] = round((floatval($total_stars->sum_stars) / floatval($total_people->count_people))*2)/2;
    	}
    	else
    	{
    		$ratings['1'] = 0;
    	}
    	
    	//getting second (ambiance) category ratings 
    	$total_people =  $this->db->query("SELECT COUNT(rating) AS count_people
    							 FROM reviews
								 WHERE restaurant_id = '{$restaurant_id}' 
								 AND category_id = '2'")->row();
    	
    	$total_stars = $this->db->query("SELECT SUM(rating) AS sum_stars
    							 FROM reviews
								 WHERE restaurant_id = '{$restaurant_id}' 
								 AND category_id = '2'")->row();
    	
    	if(floatval($total_people->count_people) != 0)
    	{	
    		$ratings['2'] = round((floatval($total_stars->sum_stars) / floatval($total_people->count_people))*2)/2;
    	}
    	else
    	{
    		$ratings['2'] = 0;
    	}
    	

    	//getting third (food_quality) category ratings 
    	$total_people =  $this->db->query("SELECT COUNT(rating) AS count_people
    							 FROM reviews
								 WHERE restaurant_id = '{$restaurant_id}' 
								 AND category_id = '3'")->row();
    	
    	$total_stars = $this->db->query("SELECT SUM(rating) AS sum_stars
    							 FROM reviews
								 WHERE restaurant_id = '{$restaurant_id}' 
								 AND category_id = '3'")->row();
    	
    	if(floatval($total_people->count_people) != 0)
    	{	
    		$ratings['3'] = round((floatval($total_stars->sum_stars) / floatval($total_people->count_people))*2)/2;
    	}
    	else
    	{
    		$ratings['3'] = 0;
    	}

    	//getting fourth (service) category ratings 
    	$total_people =  $this->db->query("SELECT COUNT(rating) AS count_people
    							 FROM reviews
								 WHERE restaurant_id = '{$restaurant_id}' 
								 AND category_id = '4'")->row();
    	
    	$total_stars = $this->db->query("SELECT SUM(rating) AS sum_stars
    							 FROM reviews
								 WHERE restaurant_id = '{$restaurant_id}' 
								 AND category_id = '4'")->row();
    	
		if(floatval($total_people->count_people) != 0)
    	{	
    		$ratings['4'] = round((floatval($total_stars->sum_stars) / floatval($total_people->count_people))*2)/2;
    	}
    	else
    	{
    		$ratings['4'] = 0;
    	}
    	return $ratings;
    }

    public function add_ratings($rating_info)
    {
    	$this->db->insert('reviews', $rating_info);
    }

    
}
/* End of file restaurant_model.php */
/* Location:/application/models/restaurant_model.php */