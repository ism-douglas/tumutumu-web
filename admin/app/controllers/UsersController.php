<?php 
/**
 * Users Page Controller
 * @category  Controller
 */
class UsersController extends SecureController{
	function __construct(){
		parent::__construct();
		$this->tablename = "users";
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
		$fields = array("id", 
			"username", 
			"email", 
			"photo", 
			"phone", 
			"date_created");
		$pagination = $this->get_pagination(MAX_RECORD_COUNT); // get current pagination e.g array(page_number, page_limit)
		//search table record
		if(!empty($request->search)){
			$text = trim($request->search); 
			$search_condition = "(
				users.id LIKE ? OR 
				users.username LIKE ? OR 
				users.email LIKE ? OR 
				users.password LIKE ? OR 
				users.photo LIKE ? OR 
				users.phone LIKE ? OR 
				users.date_created LIKE ? OR 
				users.date_updated LIKE ?
			)";
			$search_params = array(
				"%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%"
			);
			//setting search conditions
			$db->where($search_condition, $search_params);
			 //template to use when ajax search
			$this->view->search_template = "users/search.php";
		}
		if(!empty($request->orderby)){
			$orderby = $request->orderby;
			$ordertype = (!empty($request->ordertype) ? $request->ordertype : ORDER_TYPE);
			$db->orderBy($orderby, $ordertype);
		}
		else{
			$db->orderBy("users.id", ORDER_TYPE);
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
		if(	!empty($records)){
			foreach($records as &$record){
				$record['date_created'] = human_datetime($record['date_created']);
			}
		}
		$data = new stdClass;
		$data->records = $records;
		$data->record_count = $records_count;
		$data->total_records = $total_records;
		$data->total_page = $total_pages;
		if($db->getLastError()){
			$this->set_page_error();
		}
		$page_title = $this->view->page_title = "Admin Users";
		$this->view->report_filename = date('Y-m-d') . '-' . $page_title;
		$this->view->report_title = $page_title;
		$this->view->report_layout = "report_layout.php";
		$this->view->report_paper_size = "A4";
		$this->view->report_orientation = "portrait";
		$this->render_view("users/list.php", $data); //render the full page
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
		$fields = array("id", 
			"username", 
			"email", 
			"phone", 
			"date_created");
		if($value){
			$db->where($rec_id, urldecode($value)); //select record based on field name
		}
		else{
			$db->where("users.id", $rec_id);; //select record based on primary key
		}
		$record = $db->getOne($tablename, $fields );
		if($record){
			$this->write_to_log("view", "true");
			$record['date_created'] = human_datetime($record['date_created']);
			$page_title = $this->view->page_title = "User Details";
		}
		else{
			if($db->getLastError()){
				$this->set_page_error();
			}
			else{
				$this->set_page_error("No record found");
			}
			$this->write_to_log("view", "false");
		}
		return $this->render_view("users/view.php", $record);
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
			$fields = $this->fields = array("username","email","password","photo","phone");
			$postdata = $this->format_request_data($formdata);
			$cpassword = $postdata['confirm_password'];
			$password = $postdata['password'];
			if($cpassword != $password){
				$this->view->page_error[] = "Your password confirmation is not consistent";
			}
			$this->rules_array = array(
				'username' => 'required',
				'email' => 'required|valid_email',
				'password' => 'required',
				'photo' => 'required',
				'phone' => 'required',
			);
			$this->sanitize_array = array(
				'username' => 'sanitize_string',
				'email' => 'sanitize_string',
				'photo' => 'sanitize_string',
				'phone' => 'sanitize_string',
			);
			$this->filter_vals = true; //set whether to remove empty fields
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			$password_text = $modeldata['password'];
			//update modeldata with the password hash
			$modeldata['password'] = $this->modeldata['password'] = password_hash($password_text , PASSWORD_DEFAULT);
			$modeldata['date_created'] = datetime_now();
			//Check if Duplicate Record Already Exit In The Database
			$db->where("username", $modeldata['username']);
			if($db->has($tablename)){
				$this->view->page_error[] = $modeldata['username']." Already exist!";
			}
			//Check if Duplicate Record Already Exit In The Database
			$db->where("email", $modeldata['email']);
			if($db->has($tablename)){
				$this->view->page_error[] = $modeldata['email']." Already exist!";
			} 
			if($this->validated()){
				$rec_id = $this->rec_id = $db->insert($tablename, $modeldata);
				if($rec_id){
					$this->write_to_log("add", "true");
					$this->set_flash_msg("Record added successfully", "success");
					return	$this->redirect("users");
				}
				else{
					$this->set_page_error();
					$this->write_to_log("add", "false");
				}
			}
		}
		$page_title = $this->view->page_title = "Add New Users";
		$this->render_view("users/add.php");
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
		$fields = $this->fields = array("id","username","photo","phone");
		if($formdata){
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'username' => 'required',
				'photo' => 'required',
				'phone' => 'required',
			);
			$this->sanitize_array = array(
				'username' => 'sanitize_string',
				'photo' => 'sanitize_string',
				'phone' => 'sanitize_string',
			);
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			$modeldata['date_updated'] = datetime_now();
			//Check if Duplicate Record Already Exit In The Database
			if(isset($modeldata['username'])){
				$db->where("username", $modeldata['username'])->where("id", $rec_id, "!=");
				if($db->has($tablename)){
					$this->view->page_error[] = $modeldata['username']." Already exist!";
				}
			} 
			if($this->validated()){
				$db->where("users.id", $rec_id);;
				$bool = $db->update($tablename, $modeldata);
				$numRows = $db->getRowCount(); //number of affected rows. 0 = no record field updated
				if($bool && $numRows){
					$this->write_to_log("edit", "true");
					$this->set_flash_msg("Record updated successfully", "success");
					return $this->redirect("users");
				}
				else{
					if($db->getLastError()){
						$this->set_page_error();
						$this->write_to_log("edit", "false");
					}
					elseif(!$numRows){
						//not an error, but no record was updated
						$page_error = "No record updated";
						$this->set_page_error($page_error);
						$this->set_flash_msg($page_error, "warning");
						$this->write_to_log("edit", "false");
						return	$this->redirect("users");
					}
				}
			}
		}
		$db->where("users.id", $rec_id);;
		$data = $db->getOne($tablename, $fields);
		$page_title = $this->view->page_title = "Edit Admin User";
		if(!$data){
			$this->set_page_error();
		}
		return $this->render_view("users/edit.php", $data);
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
		$db->where("users.id", $arr_rec_id, "in");
		$bool = $db->delete($tablename);
		if($bool){
			$this->write_to_log("delete", "true");
			$this->set_flash_msg("Record deleted successfully", "success");
		}
		elseif($db->getLastError()){
			$page_error = $db->getLastError();
			$this->set_flash_msg($page_error, "danger");
			$this->write_to_log("delete", "false");
		}
		return	$this->redirect("users");
	}
}
