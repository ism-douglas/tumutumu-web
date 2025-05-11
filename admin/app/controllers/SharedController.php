<?php 

/**
 * SharedController Controller
 * @category  Controller / Model
 */
class SharedController extends BaseController{
	
	/**
     * subjects_code_value_exist Model Action
     * @return array
     */
	function subjects_code_value_exist($val){
		$db = $this->GetModel();
		$db->where("code", $val);
		$exist = $db->has("subjects");
		return $exist;
	}

	/**
     * subjects_subject_group_option_list Model Action
     * @return array
     */
	function subjects_subject_group_option_list(){
		$db = $this->GetModel();
		$sqltext = "SELECT  DISTINCT group_name AS value,group_name AS label FROM subject_groups ORDER BY group_name ASC";
		$queryparams = null;
		$arr = $db->rawQuery($sqltext, $queryparams);
		return $arr;
	}

	/**
     * academic_years_academic_year_value_exist Model Action
     * @return array
     */
	function academic_years_academic_year_value_exist($val){
		$db = $this->GetModel();
		$db->where("academic_year", $val);
		$exist = $db->has("academic_years");
		return $exist;
	}

	/**
     * levels_level_value_exist Model Action
     * @return array
     */
	function levels_level_value_exist($val){
		$db = $this->GetModel();
		$db->where("level", $val);
		$exist = $db->has("levels");
		return $exist;
	}

	/**
     * students_adm_no_value_exist Model Action
     * @return array
     */
	function students_adm_no_value_exist($val){
		$db = $this->GetModel();
		$db->where("adm_no", $val);
		$exist = $db->has("students");
		return $exist;
	}

	/**
     * students_level_option_list Model Action
     * @return array
     */
	function students_level_option_list(){
		$db = $this->GetModel();
		$sqltext = "SELECT  DISTINCT code AS value,level AS label FROM levels ORDER BY level ASC";
		$queryparams = null;
		$arr = $db->rawQuery($sqltext, $queryparams);
		return $arr;
	}

	/**
     * students_stream_option_list Model Action
     * @return array
     */
	function students_stream_option_list(){
		$db = $this->GetModel();
		$sqltext = "SELECT  DISTINCT stream_name AS value,stream_name AS label FROM streams ORDER BY stream_name ASC";
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
     * topics_level_option_list Model Action
     * @return array
     */
	function topics_level_option_list(){
		$db = $this->GetModel();
		$sqltext = "SELECT  DISTINCT code AS value,level AS label FROM levels ORDER BY level ASC";
		$queryparams = null;
		$arr = $db->rawQuery($sqltext, $queryparams);
		return $arr;
	}

	/**
     * topics_subject_option_list Model Action
     * @return array
     */
	function topics_subject_option_list(){
		$db = $this->GetModel();
		$sqltext = "SELECT  DISTINCT code AS value,subject AS label FROM subjects ORDER BY subject ASC";
		$queryparams = null;
		$arr = $db->rawQuery($sqltext, $queryparams);
		return $arr;
	}

	/**
     * topics_topic_value_exist Model Action
     * @return array
     */
	function topics_topic_value_exist($val){
		$db = $this->GetModel();
		$db->where("topic", $val);
		$exist = $db->has("topics");
		return $exist;
	}

	/**
     * exam_types_exam_type_value_exist Model Action
     * @return array
     */
	function exam_types_exam_type_value_exist($val){
		$db = $this->GetModel();
		$db->where("exam_type", $val);
		$exist = $db->has("exam_types");
		return $exist;
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
     * users_username_value_exist Model Action
     * @return array
     */
	function users_username_value_exist($val){
		$db = $this->GetModel();
		$db->where("username", $val);
		$exist = $db->has("users");
		return $exist;
	}

	/**
     * users_email_value_exist Model Action
     * @return array
     */
	function users_email_value_exist($val){
		$db = $this->GetModel();
		$db->where("email", $val);
		$exist = $db->has("users");
		return $exist;
	}

	/**
     * streams_stream_name_value_exist Model Action
     * @return array
     */
	function streams_stream_name_value_exist($val){
		$db = $this->GetModel();
		$db->where("stream_name", $val);
		$exist = $db->has("streams");
		return $exist;
	}

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
	* barchart_papersbyyear Model Action
	* @return array
	*/
	function barchart_papersbyyear(){
		
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

	/**
	* doughnutchart_assignmentsbyterm Model Action
	* @return array
	*/
	function doughnutchart_assignmentsbyterm(){
		
		$db = $this->GetModel();
		$chart_data = array(
			"labels"=> array(),
			"datasets"=> array(),
		);
		
		//set query result for dataset 1
		$sqltext = "SELECT  COUNT(a.id) AS count_of_id, at.term_name FROM assignments AS a JOIN academic_terms AS at ON a.academic_term=at.id GROUP BY at.term_name";
		$queryparams = null;
		$dataset1 = $db->rawQuery($sqltext, $queryparams);
		$dataset_data =  array_column($dataset1, 'count_of_id');
		$dataset_labels =  array_column($dataset1, 'term_name');
		$chart_data["labels"] = array_unique(array_merge($chart_data["labels"], $dataset_labels));
		$chart_data["datasets"][] = $dataset_data;

		return $chart_data;
	}

}
