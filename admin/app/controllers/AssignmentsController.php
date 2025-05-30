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
			"assignments.views", 
			"assignments.document");
		$pagination = $this->get_pagination(MAX_RECORD_COUNT); // get current pagination e.g array(page_number, page_limit)
		//search table record
		if(!empty($request->search)){
			$text = trim($request->search); 
			$search_condition = "(
				assignments.id LIKE ? OR 
				assignments.subject LIKE ? OR 
				subjects.subject LIKE ? OR 
				assignments.level LIKE ? OR 
				assignments.academic_year LIKE ? OR 
				academic_terms.term_name LIKE ? OR 
				assignments.uploaded_by LIKE ? OR 
				assignments.views LIKE ? OR 
				assignments.document LIKE ? OR 
				assignments.date_created LIKE ? OR 
				assignments.date_updated LIKE ? OR 
				assignments.remarks LIKE ? OR 
				assignments.academic_term LIKE ? OR 
				subjects.id LIKE ? OR 
				subjects.code LIKE ? OR 
				subjects.date_created LIKE ? OR 
				subjects.date_updated LIKE ? OR 
				subjects.subject_group LIKE ? OR 
				academic_terms.id LIKE ?
			)";
			$search_params = array(
				"%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%"
			);
			//setting search conditions
			$db->where($search_condition, $search_params);
			 //template to use when ajax search
			$this->view->search_template = "assignments/search.php";
		}
		$db->join("subjects", "assignments.subject = subjects.code", "INNER");
		$db->join("academic_terms", "assignments.academic_term = academic_terms.id", "INNER");
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
			$fields = $this->fields = array("subject","views","uploaded_by","document","date_created","date_updated","remarks","level","academic_year","academic_term");
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'subject' => 'required',
				'views' => 'required|numeric',
				'uploaded_by' => 'required',
				'document' => 'required',
				'date_created' => 'required',
				'date_updated' => 'required',
				'remarks' => 'required',
				'level' => 'required',
				'academic_year' => 'required',
				'academic_term' => 'required',
			);
			$this->sanitize_array = array(
				'subject' => 'sanitize_string',
				'views' => 'sanitize_string',
				'uploaded_by' => 'sanitize_string',
				'document' => 'sanitize_string',
				'date_created' => 'sanitize_string',
				'date_updated' => 'sanitize_string',
				'remarks' => 'sanitize_string',
				'level' => 'sanitize_string',
				'academic_year' => 'sanitize_string',
				'academic_term' => 'sanitize_string',
			);
			$this->filter_vals = true; //set whether to remove empty fields
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			if($this->validated()){
				$rec_id = $this->rec_id = $db->insert($tablename, $modeldata);
				if($rec_id){
					$this->set_flash_msg("Record added successfully", "success");
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
}
