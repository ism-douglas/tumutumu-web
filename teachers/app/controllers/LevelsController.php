<?php 
/**
 * Levels Page Controller
 * @category  Controller
 */
class LevelsController extends BaseController{
	function __construct(){
		parent::__construct();
		$this->tablename = "levels";
	}
}
