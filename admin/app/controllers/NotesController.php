<?php 
/**
 * Notes Page Controller
 * @category  Controller
 */
class NotesController extends SecureController{
	function __construct(){
		parent::__construct();
		$this->tablename = "notes";
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
		$fields = array("notes.id", 
			"subjects.subject AS subjects_subject", 
			"notes.level", 
			"notes.document", 
			"notes.views");
		$pagination = $this->get_pagination(MAX_RECORD_COUNT); // get current pagination e.g array(page_number, page_limit)
		//search table record
		if(!empty($request->search)){
			$text = trim($request->search); 
			$search_condition = "(
				notes.id LIKE ? OR 
				notes.subject LIKE ? OR 
				subjects.subject LIKE ? OR 
				notes.level LIKE ? OR 
				notes.document LIKE ? OR 
				notes.uploaded_by LIKE ? OR 
				notes.views LIKE ? OR 
				notes.date_created LIKE ? OR 
				notes.date_updated LIKE ? OR 
				notes.remarks LIKE ? OR 
				subjects.id LIKE ? OR 
				subjects.code LIKE ? OR 
				subjects.date_created LIKE ? OR 
				subjects.date_updated LIKE ? OR 
				subjects.subject_group LIKE ?
			)";
			$search_params = array(
				"%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%"
			);
			//setting search conditions
			$db->where($search_condition, $search_params);
			 //template to use when ajax search
			$this->view->search_template = "notes/search.php";
		}
		$db->join("subjects", "notes.subject = subjects.code", "INNER");
		if(!empty($request->orderby)){
			$orderby = $request->orderby;
			$ordertype = (!empty($request->ordertype) ? $request->ordertype : ORDER_TYPE);
			$db->orderBy($orderby, $ordertype);
		}
		else{
			$db->orderBy("notes.id", ORDER_TYPE);
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
		$page_title = $this->view->page_title = "Students' Notes";
		$this->render_view("notes/list.php", $data); //render the full page
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
			$fields = $this->fields = array("subject","document","remarks","level");
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'subject' => 'required',
				'document' => 'required',
				'level' => 'required',
			);
			$this->sanitize_array = array(
				'subject' => 'sanitize_string',
				'document' => 'sanitize_string',
				'remarks' => 'sanitize_string',
				'level' => 'sanitize_string',
			);
			$this->filter_vals = true; //set whether to remove empty fields
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			$modeldata['date_created'] = datetime_now();
			if($this->validated()){
				$rec_id = $this->rec_id = $db->insert($tablename, $modeldata);
				if($rec_id){
					$this->write_to_log("add", "true");
		# Statement to execute after adding record
		$USER_ID = get_active_user('id');
$db->rawQuery("UPDATE notes SET uploaded_by = $USER_ID  WHERE id='$rec_id'");
		# End of after add statement
					$this->set_flash_msg("Notes added successfully", "success");
					return	$this->redirect("notes");
				}
				else{
					$this->set_page_error();
					$this->write_to_log("add", "false");
				}
			}
		}
		$page_title = $this->view->page_title = "Add New Notes";
		$this->render_view("notes/add.php");
	}
}
