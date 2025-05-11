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
			'path' => 'subjects', 
			'label' => 'Subjects', 
			'icon' => '<i class="fa fa-leanpub "></i>'
		),
		
		array(
			'path' => 'menu10', 
			'label' => 'Resources', 
			'icon' => '<i class="fa fa-paperclip "></i>','submenu' => array(
		array(
			'path' => 'notes', 
			'label' => 'Notes', 
			'icon' => ''
		),
		
		array(
			'path' => 'past_papers', 
			'label' => 'Past Papers', 
			'icon' => ''
		),
		
		array(
			'path' => 'assignments', 
			'label' => 'Assignments', 
			'icon' => ''
		)
	)
		),
		
		array(
			'path' => 'teachers', 
			'label' => 'Teachers', 
			'icon' => '<i class="fa fa-graduation-cap "></i>'
		),
		
		array(
			'path' => 'students', 
			'label' => 'Students', 
			'icon' => '<i class="fa fa-users "></i>'
		),
		
		array(
			'path' => 'menu9', 
			'label' => 'Configurations', 
			'icon' => '<i class="fa fa-cogs "></i>','submenu' => array(
		array(
			'path' => 'topics', 
			'label' => 'Topics', 
			'icon' => ''
		),
		
		array(
			'path' => 'exam_types', 
			'label' => 'Exam Names', 
			'icon' => ''
		),
		
		array(
			'path' => 'levels', 
			'label' => 'Form Levels', 
			'icon' => ''
		),
		
		array(
			'path' => 'streams', 
			'label' => 'Streams', 
			'icon' => ''
		),
		
		array(
			'path' => 'academic_years', 
			'label' => 'Academic Years', 
			'icon' => ''
		),
		
		array(
			'path' => 'academic_terms', 
			'label' => 'Academic Terms', 
			'icon' => ''
		),
		
		array(
			'path' => 'subject_groups', 
			'label' => 'Subject Groups', 
			'icon' => ''
		),
		
		array(
			'path' => 'paper_types', 
			'label' => 'Paper Types', 
			'icon' => ''
		)
	)
		),
		
		array(
			'path' => 'menu8', 
			'label' => 'System Management', 
			'icon' => '<i class="fa fa-suitcase "></i>','submenu' => array(
		array(
			'path' => 'users', 
			'label' => 'Users', 
			'icon' => ''
		),
		
		array(
			'path' => 'app_logs', 
			'label' => 'Admin Logs', 
			'icon' => ''
		),
		
		array(
			'path' => 'app_logs_teachers', 
			'label' => 'Teachers Logs', 
			'icon' => ''
		)
	)
		)
	);
		
	
	
			public static $account_status = array(
		array(
			"value" => "Active", 
			"label" => "Active", 
		),
		array(
			"value" => "Blocked", 
			"label" => "Blocked", 
		),
		array(
			"value" => "Pending", 
			"label" => "Pending", 
		),);
		
}