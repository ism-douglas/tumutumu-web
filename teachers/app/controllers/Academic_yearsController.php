<?php 
/**
 * Academic_years Page Controller
 * @category  Controller
 */
class Academic_yearsController extends BaseController{
	function __construct(){
		parent::__construct();
		$this->tablename = "academic_years";
	}
}
