<?php 

/**
 * SharedController Controller
 * @category  Controller / Model
 */
class SharedController extends BaseController{
	
	/**
     * resources_subject_option_list Model Action
     * @return array
     */
	function resources_subject_option_list(){
		$db = $this->GetModel();
		$sqltext = "SELECT  DISTINCT code AS value,subject AS label FROM subjects ORDER BY subject ASC";
		$queryparams = null;
		$arr = $db->rawQuery($sqltext, $queryparams);
		return $arr;
	}

	/**
     * resources_category_option_list Model Action
     * @return array
     */
	function resources_category_option_list(){
		$db = $this->GetModel();
		$sqltext = "SELECT  DISTINCT category AS value,category AS label FROM resource_categories ORDER BY category ASC";
		$queryparams = null;
		$arr = $db->rawQuery($sqltext, $queryparams);
		return $arr;
	}

	/**
     * resources_level_option_list Model Action
     * @return array
     */
	function resources_level_option_list(){
		$db = $this->GetModel();
		$sqltext = "SELECT  DISTINCT code AS value,level AS label FROM levels ORDER BY level ASC";
		$queryparams = null;
		$arr = $db->rawQuery($sqltext, $queryparams);
		return $arr;
	}

	/**
     * resources_academic_year_option_list Model Action
     * @return array
     */
	function resources_academic_year_option_list(){
		$db = $this->GetModel();
		$sqltext = "SELECT  DISTINCT academic_year AS value,academic_year AS label FROM academic_years ORDER BY academic_year ASC";
		$queryparams = null;
		$arr = $db->rawQuery($sqltext, $queryparams);
		return $arr;
	}

	/**
     * getcount_resources Model Action
     * @return Value
     */
	function getcount_resources(){
		$db = $this->GetModel();
		$sqltext = "SELECT COUNT(*) AS num FROM resources";
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

	/**
     * getcount_categories Model Action
     * @return Value
     */
	function getcount_categories(){
		$db = $this->GetModel();
		$sqltext = "SELECT COUNT(*) AS num FROM resource_categories";
		$queryparams = null;
		$val = $db->rawQueryValue($sqltext, $queryparams);
		
		if(is_array($val)){
			return $val[0];
		}
		return $val;
	}

}
