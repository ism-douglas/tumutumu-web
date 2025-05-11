<?php 
/**
 * App_logs_teachers Page Controller
 * @category  Controller
 */
class App_logs_teachersController extends SecureController{
	function __construct(){
		parent::__construct();
		$this->tablename = "app_logs_teachers";
	}
}
