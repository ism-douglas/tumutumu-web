<?php
/**
 * Menu Items
 * All Project Menu
 * @category  Menu List
 */

class Menu{
	
	
			public static $navbartopleft = array(
		array(
			'path' => 'home', 
			'label' => 'Home', 
			'icon' => '<i class="fa fa-home "></i>'
		),
		
		array(
			'path' => 'notes', 
			'label' => 'Notes', 
			'icon' => '<i class="fa fa-book "></i>'
		),
		
		array(
			'path' => 'past_papers', 
			'label' => 'Past Papers', 
			'icon' => '<i class="fa fa-bookmark "></i>'
		),
		
		array(
			'path' => 'assignments', 
			'label' => 'Assignments', 
			'icon' => '<i class="fa fa-paperclip "></i>'
		)
	);
		
	
	
			public static $account_status = array(
		array(
			"value" => "Active", 
			"label" => "Active", 
		),
		array(
			"value" => "Pending", 
			"label" => "Pending", 
		),
		array(
			"value" => "Blocked", 
			"label" => "Blocked", 
		),);
		
}