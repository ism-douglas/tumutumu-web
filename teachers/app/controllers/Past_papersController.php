<?php 
/**
 * Past_papers Page Controller
 * @category  Controller
 */
class Past_papersController extends SecureController{
	function __construct(){
		parent::__construct();
		$this->tablename = "past_papers";
	}
	/**
     * List page records
     * @param $fieldname (filter record by a field) 
     * @param $fieldvalue (filter field value)
     * @return BaseView
     */
	function index($fieldname = null , $fieldvalue = null){
		$request = $this->request;
		$db = $this->GetModel();
		$tablename = $this->tablename;
		$fields = array("past_papers.id", 
			"exam_types.exam_type AS exam_types_exam_type", 
			"subjects.subject AS subjects_subject", 
			"past_papers.exam_year", 
			"academic_terms.term_name AS academic_terms_term_name", 
			"past_papers.level", 
			"paper_types.paper_type AS paper_types_paper_type", 
			"past_papers.document", 
			"past_papers.views");
		$pagination = $this->get_pagination(MAX_RECORD_COUNT); // get current pagination e.g array(page_number, page_limit)
		//search table record
		if(!empty($request->search)){
			$text = trim($request->search); 
			$search_condition = "(
				past_papers.id LIKE ? OR 
				past_papers.subject LIKE ? OR 
				past_papers.exam_type LIKE ? OR 
				exam_types.exam_type LIKE ? OR 
				subjects.subject LIKE ? OR 
				past_papers.exam_year LIKE ? OR 
				academic_terms.term_name LIKE ? OR 
				past_papers.term LIKE ? OR 
				past_papers.level LIKE ? OR 
				past_papers.paper_type LIKE ? OR 
				paper_types.paper_type LIKE ? OR 
				past_papers.document LIKE ? OR 
				past_papers.uploaded_by LIKE ? OR 
				past_papers.views LIKE ? OR 
				past_papers.date_created LIKE ? OR 
				past_papers.date_updated LIKE ? OR 
				exam_types.id LIKE ? OR 
				exam_types.date_created LIKE ? OR 
				exam_types.date_updated LIKE ? OR 
				subjects.id LIKE ? OR 
				subjects.code LIKE ? OR 
				subjects.date_created LIKE ? OR 
				subjects.date_updated LIKE ? OR 
				subjects.subject_group LIKE ? OR 
				paper_types.id LIKE ? OR 
				paper_types.date_created LIKE ? OR 
				paper_types.date_updated LIKE ? OR 
				academic_terms.id LIKE ?
			)";
			$search_params = array(
				"%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%"
			);
			//setting search conditions
			$db->where($search_condition, $search_params);
			 //template to use when ajax search
			$this->view->search_template = "past_papers/search.php";
		}
		$db->join("exam_types", "past_papers.exam_type = exam_types.id", "INNER");
		$db->join("subjects", "past_papers.subject = subjects.code", "INNER");
		$db->join("paper_types", "past_papers.paper_type = paper_types.id", "INNER");
		$db->join("academic_terms", "past_papers.term = academic_terms.id", "INNER");
		if(!empty($request->orderby)){
			$orderby = $request->orderby;
			$ordertype = (!empty($request->ordertype) ? $request->ordertype : ORDER_TYPE);
			$db->orderBy($orderby, $ordertype);
		}
		else{
			$db->orderBy("past_papers.id", ORDER_TYPE);
		}
		if($fieldname){
			$db->where($fieldname , $fieldvalue); //filter by a single field name
		}
		$tc = $db->withTotalCount();
		$records = $db->get($tablename, $pagination, $fields);
		$records_count = count($records);
		$total_records = intval($tc->totalCount);
		$page_limit = $pagination[1];
		$total_pages = ceil($total_records / $page_limit);
		$data = new stdClass;
		$data->records = $records;
		$data->record_count = $records_count;
		$data->total_records = $total_records;
		$data->total_page = $total_pages;
		if($db->getLastError()){
			$this->set_page_error();
		}
		$page_title = $this->view->page_title = "Past Papers";
		$this->view->report_filename = date('Y-m-d') . '-' . $page_title;
		$this->view->report_title = $page_title;
		$this->view->report_layout = "report_layout.php";
		$this->view->report_paper_size = "A4";
		$this->view->report_orientation = "portrait";
		$this->render_view("past_papers/list.php", $data); //render the full page
	}
	/**
     * View record detail 
	 * @param $rec_id (select record by table primary key) 
     * @param $value value (select record by value of field name(rec_id))
     * @return BaseView
     */
	function view($rec_id = null, $value = null){
		$request = $this->request;
		$db = $this->GetModel();
		$rec_id = $this->rec_id = urldecode($rec_id);
		$tablename = $this->tablename;
		$fields = array("past_papers.id", 
			"exam_types.exam_type AS exam_types_exam_type", 
			"subjects.subject AS subjects_subject", 
			"past_papers.exam_year", 
			"academic_terms.term_name AS academic_terms_term_name", 
			"past_papers.level", 
			"paper_types.paper_type AS paper_types_paper_type", 
			"past_papers.document", 
			"past_papers.uploaded_by", 
			"past_papers.views", 
			"past_papers.date_created");
		if($value){
			$db->where($rec_id, urldecode($value)); //select record based on field name
		}
		else{
			$db->where("past_papers.id", $rec_id);; //select record based on primary key
		}
		$db->join("exam_types", "past_papers.exam_type = exam_types.id", "INNER ");
		$db->join("subjects", "past_papers.subject = subjects.code", "INNER ");
		$db->join("paper_types", "past_papers.paper_type = paper_types.id", "INNER ");
		$db->join("academic_terms", "past_papers.term = academic_terms.id", "INNER ");  
		$record = $db->getOne($tablename, $fields );
		if($record){
			$this->write_to_log("view", "true");
			$record['date_created'] = human_datetime($record['date_created']);
			$page_title = $this->view->page_title = "Past Paper Details";
		}
		else{
			if($db->getLastError()){
				$this->set_page_error();
			}
			else{
				$this->set_page_error("No record found");
			}
		}
		return $this->render_view("past_papers/view.php", $record);
	}
	/**
     * Insert new record to the database table
	 * @param $formdata array() from $_POST
     * @return BaseView
     */
	function add($formdata = null){
		if($formdata){
			$db = $this->GetModel();
			$tablename = $this->tablename;
			$request = $this->request;
			//fillable fields
			$fields = $this->fields = array("exam_type","subject","exam_year","term","level","paper_type","document");
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'exam_type' => 'required',
				'subject' => 'required',
				'exam_year' => 'required',
				'term' => 'required',
				'level' => 'required',
				'paper_type' => 'required',
				'document' => 'required',
			);
			$this->sanitize_array = array(
				'exam_type' => 'sanitize_string',
				'subject' => 'sanitize_string',
				'exam_year' => 'sanitize_string',
				'term' => 'sanitize_string',
				'level' => 'sanitize_string',
				'paper_type' => 'sanitize_string',
				'document' => 'sanitize_string',
			);
			$this->filter_vals = true; //set whether to remove empty fields
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			if($this->validated()){
				$rec_id = $this->rec_id = $db->insert($tablename, $modeldata);
				if($rec_id){
					$this->write_to_log("add", "true");
		# Statement to execute after adding record
		$USER_ID = get_active_user('id');
$db->rawQuery("UPDATE past_papers SET uploaded_by = $USER_ID  WHERE id='$rec_id'");
		# End of after add statement
					$this->set_flash_msg("Past paper added successfully", "success");
					return	$this->redirect("past_papers");
				}
				else{
					$this->set_page_error();
				}
			}
		}
		$page_title = $this->view->page_title = "Add New Past Papers";
		$this->render_view("past_papers/add.php");
	}
	/**
     * Update table record with formdata
	 * @param $rec_id (select record by table primary key)
	 * @param $formdata array() from $_POST
     * @return array
     */
	function edit($rec_id = null, $formdata = null){
		$request = $this->request;
		$db = $this->GetModel();
		$this->rec_id = $rec_id;
		$tablename = $this->tablename;
		 //editable fields
		$fields = $this->fields = array("id","exam_type","subject","exam_year","term","level","paper_type","document");
		if($formdata){
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'exam_type' => 'required',
				'subject' => 'required',
				'exam_year' => 'required',
				'term' => 'required',
				'level' => 'required',
				'paper_type' => 'required',
				'document' => 'required',
			);
			$this->sanitize_array = array(
				'exam_type' => 'sanitize_string',
				'subject' => 'sanitize_string',
				'exam_year' => 'sanitize_string',
				'term' => 'sanitize_string',
				'level' => 'sanitize_string',
				'paper_type' => 'sanitize_string',
				'document' => 'sanitize_string',
			);
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			if($this->validated()){
				$db->where("past_papers.id", $rec_id);;
				$bool = $db->update($tablename, $modeldata);
				$numRows = $db->getRowCount(); //number of affected rows. 0 = no record field updated
				if($bool && $numRows){
					$this->write_to_log("edit", "true");
					$this->set_flash_msg("Past paper updated successfully", "success");
					return $this->redirect("past_papers");
				}
				else{
					if($db->getLastError()){
						$this->set_page_error();
					}
					elseif(!$numRows){
						//not an error, but no record was updated
						$page_error = "No record updated";
						$this->set_page_error($page_error);
						$this->set_flash_msg($page_error, "warning");
						return	$this->redirect("past_papers");
					}
				}
			}
		}
		$db->where("past_papers.id", $rec_id);;
		$data = $db->getOne($tablename, $fields);
		$page_title = $this->view->page_title = "Edit  Past Papers";
		if(!$data){
			$this->set_page_error();
		}
		return $this->render_view("past_papers/edit.php", $data);
	}
	/**
     * Delete record from the database
	 * Support multi delete by separating record id by comma.
     * @return BaseView
     */
	function delete($rec_id = null){
		Csrf::cross_check();
		$request = $this->request;
		$db = $this->GetModel();
		$tablename = $this->tablename;
		$this->rec_id = $rec_id;
		//form multiple delete, split record id separated by comma into array
		$arr_rec_id = array_map('trim', explode(",", $rec_id));
		$db->where("past_papers.id", $arr_rec_id, "in");
		$bool = $db->delete($tablename);
		if($bool){
			$this->write_to_log("delete", "true");
			$this->set_flash_msg("Record deleted successfully", "success");
		}
		elseif($db->getLastError()){
			$page_error = $db->getLastError();
			$this->set_flash_msg($page_error, "danger");
		}
		return	$this->redirect("past_papers");
	}
}
