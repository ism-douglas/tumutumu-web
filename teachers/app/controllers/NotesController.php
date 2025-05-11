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
				subjects.subject LIKE ? OR 
				notes.subject LIKE ? OR 
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
		$page_title = $this->view->page_title = "List of Notes";
		$this->view->report_filename = date('Y-m-d') . '-' . $page_title;
		$this->view->report_title = $page_title;
		$this->view->report_layout = "report_layout.php";
		$this->view->report_paper_size = "A4";
		$this->view->report_orientation = "portrait";
		$this->render_view("notes/list.php", $data); //render the full page
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
		$fields = array("notes.id", 
			"subjects.subject AS subjects_subject", 
			"notes.level", 
			"notes.document", 
			"notes.views", 
			"notes.uploaded_by", 
			"notes.date_created", 
			"notes.date_updated", 
			"notes.remarks");
		if($value){
			$db->where($rec_id, urldecode($value)); //select record based on field name
		}
		else{
			$db->where("notes.id", $rec_id);; //select record based on primary key
		}
		$db->join("subjects", "notes.subject = subjects.code", "INNER ");  
		$record = $db->getOne($tablename, $fields );
		if($record){
			$this->write_to_log("view", "true");
			$page_title = $this->view->page_title = "Notes Details";
		}
		else{
			if($db->getLastError()){
				$this->set_page_error();
			}
			else{
				$this->set_page_error("No record found");
			}
		}
		return $this->render_view("notes/view.php", $record);
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
			$fields = $this->fields = array("subject","level","document","remarks");
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'subject' => 'required',
				'level' => 'required',
				'document' => 'required',
			);
			$this->sanitize_array = array(
				'subject' => 'sanitize_string',
				'level' => 'sanitize_string',
				'document' => 'sanitize_string',
				'remarks' => 'sanitize_string',
			);
			$this->filter_vals = true; //set whether to remove empty fields
			$modeldata = $this->modeldata = $this->validate_form($postdata);
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
				}
			}
		}
		$page_title = $this->view->page_title = "Add New Notes";
		$this->render_view("notes/add.php");
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
		$fields = $this->fields = array("id","subject","level","document","remarks");
		if($formdata){
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'subject' => 'required',
				'level' => 'required',
				'document' => 'required',
			);
			$this->sanitize_array = array(
				'subject' => 'sanitize_string',
				'level' => 'sanitize_string',
				'document' => 'sanitize_string',
				'remarks' => 'sanitize_string',
			);
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			if($this->validated()){
				$db->where("notes.id", $rec_id);;
				$bool = $db->update($tablename, $modeldata);
				$numRows = $db->getRowCount(); //number of affected rows. 0 = no record field updated
				if($bool && $numRows){
					$this->write_to_log("edit", "true");
					$this->set_flash_msg("Notes updated successfully", "success");
					return $this->redirect("notes");
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
						return	$this->redirect("notes");
					}
				}
			}
		}
		$db->where("notes.id", $rec_id);;
		$data = $db->getOne($tablename, $fields);
		$page_title = $this->view->page_title = "Edit  Notes";
		if(!$data){
			$this->set_page_error();
		}
		return $this->render_view("notes/edit.php", $data);
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
		$db->where("notes.id", $arr_rec_id, "in");
		$bool = $db->delete($tablename);
		if($bool){
			$this->write_to_log("delete", "true");
			$this->set_flash_msg("Record deleted successfully", "success");
		}
		elseif($db->getLastError()){
			$page_error = $db->getLastError();
			$this->set_flash_msg($page_error, "danger");
		}
		return	$this->redirect("notes");
	}
}
