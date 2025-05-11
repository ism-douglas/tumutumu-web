<?php 

/**
 * SharedController Controller
 * @category  Controller / Model
 */
class SharedController extends BaseController{
	
	/**
     * notes_subject_option_list Model Action
     * @return array
     */
	function notes_subject_option_list(){
		$db = $this->GetModel();
		$sqltext = "SELECT  DISTINCT code AS value,subject AS label FROM subjects ORDER BY subject ASC";
		$queryparams = null;
		$arr = $db->rawQuery($sqltext, $queryparams);
		return $arr;
	}

	/**
     * notes_level_option_list Model Action
     * @return array
     */
	function notes_level_option_list(){
		$db = $this->GetModel();
		$sqltext = "SELECT  DISTINCT code AS value,level AS label FROM levels ORDER BY level ASC";
		$queryparams = null;
		$arr = $db->rawQuery($sqltext, $queryparams);
		return $arr;
	}

	/**
     * past_papers_exam_type_option_list Model Action
     * @return array
     */
	function past_papers_exam_type_option_list(){
		$db = $this->GetModel();
		$sqltext = "SELECT  DISTINCT id AS value,exam_type AS label FROM exam_types ORDER BY exam_type ASC";
		$queryparams = null;
		$arr = $db->rawQuery($sqltext, $queryparams);
		return $arr;
	}

	/**
     * past_papers_subject_option_list Model Action
     * @return array
     */
	function past_papers_subject_option_list(){
		$db = $this->GetModel();
		$sqltext = "SELECT  DISTINCT code AS value,subject AS label FROM subjects ORDER BY subject ASC";
		$queryparams = null;
		$arr = $db->rawQuery($sqltext, $queryparams);
		return $arr;
	}

	/**
     * past_papers_exam_year_option_list Model Action
     * @return array
     */
	function past_papers_exam_year_option_list(){
		$db = $this->GetModel();
		$sqltext = "SELECT  DISTINCT academic_year AS value,academic_year AS label FROM academic_years ORDER BY academic_year DESC";
		$queryparams = null;
		$arr = $db->rawQuery($sqltext, $queryparams);
		return $arr;
	}

	/**
     * past_papers_term_option_list Model Action
     * @return array
     */
	function past_papers_term_option_list(){
		$db = $this->GetModel();
		$sqltext = "SELECT  DISTINCT id AS value,term_name AS label FROM academic_terms ORDER BY term_name ASC";
		$queryparams = null;
		$arr = $db->rawQuery($sqltext, $queryparams);
		return $arr;
	}

	/**
     * past_papers_level_option_list Model Action
     * @return array
     */
	function past_papers_level_option_list(){
		$db = $this->GetModel();
		$sqltext = "SELECT  DISTINCT code AS value,level AS label FROM levels ORDER BY level ASC";
		$queryparams = null;
		$arr = $db->rawQuery($sqltext, $queryparams);
		return $arr;
	}

	/**
     * past_papers_paper_type_option_list Model Action
     * @return array
     */
	function past_papers_paper_type_option_list(){
		$db = $this->GetModel();
		$sqltext = "SELECT  DISTINCT id AS value,paper_type AS label FROM paper_types ORDER BY paper_type ASC";
		$queryparams = null;
		$arr = $db->rawQuery($sqltext, $queryparams);
		return $arr;
	}

	/**
     * teachers_username_value_exist Model Action
     * @return array
     */
	function teachers_username_value_exist($val){
		$db = $this->GetModel();
		$db->where("username", $val);
		$exist = $db->has("teachers");
		return $exist;
	}

	/**
     * teachers_email_value_exist Model Action
     * @return array
     */
	function teachers_email_value_exist($val){
		$db = $this->GetModel();
		$db->where("email", $val);
		$exist = $db->has("teachers");
		return $exist;
	}

	/**
     * teachers_phone_value_exist Model Action
     * @return array
     */
	function teachers_phone_value_exist($val){
		$db = $this->GetModel();
		$db->where("phone", $val);
		$exist = $db->has("teachers");
		return $exist;
	}

	/**
     * teachers_tsc_no_value_exist Model Action
     * @return array
     */
	function teachers_tsc_no_value_exist($val){
		$db = $this->GetModel();
		$db->where("tsc_no", $val);
		$exist = $db->has("teachers");
		return $exist;
	}

	/**
     * assignments_subject_option_list Model Action
     * @return array
     */
	function assignments_subject_option_list(){
		$db = $this->GetModel();
		$sqltext = "SELECT  DISTINCT code AS value,subject AS label FROM subjects ORDER BY subject ASC";
		$queryparams = null;
		$arr = $db->rawQuery($sqltext, $queryparams);
		return $arr;
	}

	/**
     * assignments_level_option_list Model Action
     * @return array
     */
	function assignments_level_option_list(){
		$db = $this->GetModel();
		$sqltext = "SELECT  DISTINCT code AS value,level AS label FROM levels ORDER BY level ASC";
		$queryparams = null;
		$arr = $db->rawQuery($sqltext, $queryparams);
		return $arr;
	}

	/**
     * assignments_academic_year_option_list Model Action
     * @return array
     */
	function assignments_academic_year_option_list(){
		$db = $this->GetModel();
		$sqltext = "SELECT  DISTINCT academic_year AS value,academic_year AS label FROM academic_years ORDER BY academic_year DESC";
		$queryparams = null;
		$arr = $db->rawQuery($sqltext, $queryparams);
		return $arr;
	}

	/**
     * assignments_academic_term_option_list Model Action
     * @return array
     */
	function assignments_academic_term_option_list(){
		$db = $this->GetModel();
		$sqltext = "SELECT  DISTINCT id AS value,term_name AS label FROM academic_terms ORDER BY term_name ASC";
		$queryparams = null;
		$arr = $db->rawQuery($sqltext, $queryparams);
		return $arr;
	}

	/**
     * getcount_studentnotes Model Action
     * @return Value
     */
	function getcount_studentnotes(){
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
     * getcount_examtypes Model Action
     * @return Value
     */
	function getcount_examtypes(){
		$db = $this->GetModel();
		$sqltext = "SELECT COUNT(*) AS num FROM exam_types";
		$queryparams = null;
		$val = $db->rawQueryValue($sqltext, $queryparams);
		
		if(is_array($val)){
			return $val[0];
		}
		return $val;
	}

	/**
	* piechart_notesbylevel Model Action
	* @return array
	*/
	function piechart_notesbylevel(){
		
		$db = $this->GetModel();
		$chart_data = array(
			"labels"=> array(),
			"datasets"=> array(),
		);
		
		//set query result for dataset 1
		$sqltext = "SELECT  COUNT(n.id) AS count_of_notes, n.level FROM notes AS n GROUP BY n.level";
		$queryparams = null;
		$dataset1 = $db->rawQuery($sqltext, $queryparams);
		$dataset_data =  array_column($dataset1, 'count_of_notes');
		$dataset_labels =  array_column($dataset1, 'level');
		$chart_data["labels"] = array_unique(array_merge($chart_data["labels"], $dataset_labels));
		$chart_data["datasets"][] = $dataset_data;

		return $chart_data;
	}

	/**
	* barchart_pastpaperbyyear Model Action
	* @return array
	*/
	function barchart_pastpaperbyyear(){
		
		$db = $this->GetModel();
		$chart_data = array(
			"labels"=> array(),
			"datasets"=> array(),
		);
		
		//set query result for dataset 1
		$sqltext = "SELECT  COUNT(pp.id) AS count_of_papers, pp.exam_year FROM past_papers AS pp GROUP BY pp.exam_year";
		$queryparams = null;
		$dataset1 = $db->rawQuery($sqltext, $queryparams);
		$dataset_data =  array_column($dataset1, 'count_of_papers');
		$dataset_labels =  array_column($dataset1, 'exam_year');
		$chart_data["labels"] = array_unique(array_merge($chart_data["labels"], $dataset_labels));
		$chart_data["datasets"][] = $dataset_data;

		return $chart_data;
	}

}
