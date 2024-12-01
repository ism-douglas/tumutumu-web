<?php 

/**
 * SharedController Controller
 * @category  Controller / Model
 */
class SharedController extends BaseController{
	
	/**
     * getcount_notes Model Action
     * @return Value
     */
	function getcount_notes(){
		$db = $this->GetModel();
		$sqltext = "SELECT COUNT(*) AS num FROM notes";
		$queryparams = null;
		$val = $db->rawQueryValue($sqltext, $queryparams);
		
		if(is_array($val)){
			return $val[0];
		}
		return $val;
	}

	/**
     * getcount_pastpapers Model Action
     * @return Value
     */
	function getcount_pastpapers(){
		$db = $this->GetModel();
		$sqltext = "SELECT COUNT(*) AS num FROM past_papers";
		$queryparams = null;
		$val = $db->rawQueryValue($sqltext, $queryparams);
		
		if(is_array($val)){
			return $val[0];
		}
		return $val;
	}

	/**
     * getcount_subjects Model Action
     * @return Value
     */
	function getcount_subjects(){
		$db = $this->GetModel();
		$sqltext = "SELECT COUNT(*) AS num FROM subjects";
		$queryparams = null;
		$val = $db->rawQueryValue($sqltext, $queryparams);
		
		if(is_array($val)){
			return $val[0];
		}
		return $val;
	}

}
