<?php 
/**
 * Assignments Page Controller
 * @category  Controller
 */
class AssignmentsController extends SecureController{
	function __construct(){
		parent::__construct();
		$this->tablename = "assignments";
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
		$fields = array("assignments.id", 
			"subjects.subject AS subjects_subject", 
			"assignments.level", 
			"assignments.academic_year", 
			"academic_terms.term_name AS academic_terms_term_name", 
			"assignments.document", 
			"assignments.views");
		$pagination = $this->get_pagination(MAX_RECORD_COUNT); // get current pagination e.g array(page_number, page_limit)
		//search table record
		if(!empty($request->search)){
			$text = trim($request->search); 
			$search_condition = "(
				assignments.id LIKE ? OR 
				subjects.subject LIKE ? OR 
				assignments.subject LIKE ? OR 
				assignments.level LIKE ? OR 
				assignments.academic_year LIKE ? OR 
				assignments.academic_term LIKE ? OR 
				academic_terms.term_name LIKE ? OR 
				assignments.document LIKE ? OR 
				assignments.date_created LIKE ? OR 
				assignments.uploaded_by LIKE ? OR 
				assignments.date_updated LIKE ? OR 
				assignments.remarks LIKE ? OR 
				assignments.views LIKE ? OR 
				academic_terms.id LIKE ? OR 
				subjects.id LIKE ? OR 
				subjects.code LIKE ? OR 
				subjects.date_created LIKE ? OR 
				subjects.date_updated LIKE ? OR 
				subjects.subject_group LIKE ?
			)";
			$search_params = array(
				"%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%"
			);
			//setting search conditions
			$db->where($search_condition, $search_params);
			 //template to use when ajax search
			$this->view->search_template = "assignments/search.php";
		}
		$db->join("academic_terms", "assignments.academic_term = academic_terms.id", "INNER");
		$db->join("subjects", "assignments.subject = subjects.code", "INNER");
		if(!empty($request->orderby)){
			$orderby = $request->orderby;
			$ordertype = (!empty($request->ordertype) ? $request->ordertype : ORDER_TYPE);
			$db->orderBy($orderby, $ordertype);
		}
		else{
			$db->orderBy("assignments.id", ORDER_TYPE);
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
		$page_title = $this->view->page_title = "Assignments";
		$this->view->report_filename = date('Y-m-d') . '-' . $page_title;
		$this->view->report_title = $page_title;
		$this->view->report_layout = "report_layout.php";
		$this->view->report_paper_size = "A4";
		$this->view->report_orientation = "portrait";
		$this->render_view("assignments/list.php", $data); //render the full page
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
		$fields = array("assignments.id", 
			"subjects.subject AS subjects_subject", 
			"assignments.level", 
			"assignments.academic_year", 
			"academic_terms.term_name AS academic_terms_term_name", 
			"assignments.document", 
			"assignments.views", 
			"assignments.date_created", 
			"assignments.remarks");
		if($value){
			$db->where($rec_id, urldecode($value)); //select record based on field name
		}
		else{
			$db->where("assignments.id", $rec_id);; //select record based on primary key
		}
		$db->join("academic_terms", "assignments.academic_term = academic_terms.id", "INNER ");
		$db->join("subjects", "assignments.subject = subjects.code", "INNER ");  
		$record = $db->getOne($tablename, $fields );
		if($record){
			$record['date_created'] = human_datetime($record['date_created']);
			$page_title = $this->view->page_title = "Assignments Details";
		$this->view->report_filename = date('Y-m-d') . '-' . $page_title;
		$this->view->report_title = $page_title;
		$this->view->report_layout = "report_layout.php";
		$this->view->report_paper_size = "A4";
		$this->view->report_orientation = "portrait";
		}
		else{
			if($db->getLastError()){
				$this->set_page_error();
			}
			else{
				$this->set_page_error("No record found");
			}
		}
		return $this->render_view("assignments/view.php", $record);
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
			$fields = $this->fields = array("subject","level","academic_year","academic_term","document","remarks");
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'subject' => 'required',
				'level' => 'required',
				'academic_year' => 'required',
				'academic_term' => 'required',
				'document' => 'required',
			);
			$this->sanitize_array = array(
				'subject' => 'sanitize_string',
				'level' => 'sanitize_string',
				'academic_year' => 'sanitize_string',
				'academic_term' => 'sanitize_string',
				'document' => 'sanitize_string',
				'remarks' => 'sanitize_string',
			);
			$this->filter_vals = true; //set whether to remove empty fields
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			if($this->validated()){
				$rec_id = $this->rec_id = $db->insert($tablename, $modeldata);
				if($rec_id){
		# Statement to execute after adding record
		$USER_ID = get_active_user('id');
$db->rawQuery("UPDATE assignments SET uploaded_by = $USER_ID  WHERE id='$rec_id'");
		# End of after add statement
					$this->set_flash_msg("Assignment added successfully", "success");
					return	$this->redirect("assignments");
				}
				else{
					$this->set_page_error();
				}
			}
		}
		$page_title = $this->view->page_title = "Add New Assignments";
		$this->render_view("assignments/add.php");
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
		$fields = $this->fields = array("id","subject","level","academic_year","academic_term","document","remarks");
		if($formdata){
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'subject' => 'required',
				'level' => 'required',
				'academic_year' => 'required',
				'academic_term' => 'required',
				'document' => 'required',
			);
			$this->sanitize_array = array(
				'subject' => 'sanitize_string',
				'level' => 'sanitize_string',
				'academic_year' => 'sanitize_string',
				'academic_term' => 'sanitize_string',
				'document' => 'sanitize_string',
				'remarks' => 'sanitize_string',
			);
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			if($this->validated()){
				$db->where("assignments.id", $rec_id);;
				$bool = $db->update($tablename, $modeldata);
				$numRows = $db->getRowCount(); //number of affected rows. 0 = no record field updated
				if($bool && $numRows){
					$this->set_flash_msg("Record updated successfully", "success");
					return $this->redirect("assignments");
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
						return	$this->redirect("assignments");
					}
				}
			}
		}
		$db->where("assignments.id", $rec_id);;
		$data = $db->getOne($tablename, $fields);
		$page_title = $this->view->page_title = "Edit  Assignments";
		if(!$data){
			$this->set_page_error();
		}
		return $this->render_view("assignments/edit.php", $data);
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
		$db->where("assignments.id", $arr_rec_id, "in");
		$bool = $db->delete($tablename);
		if($bool){
			$this->set_flash_msg("Record deleted successfully", "success");
		}
		elseif($db->getLastError()){
			$page_error = $db->getLastError();
			$this->set_flash_msg($page_error, "danger");
		}
		return	$this->redirect("assignments");
	}
}
