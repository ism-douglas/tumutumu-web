<?php 
/**
 * Students Page Controller
 * @category  Controller
 */
class StudentsController extends BaseController{
	function __construct(){
		parent::__construct();
		$this->tablename = "students";
	}
	/**
     * Update single field
	 * @param $rec_id (select record by table primary key)
	 * @param $formdata array() from $_POST
     * @return array
     */
	function editfield($rec_id = null, $formdata = null){
		$db = $this->GetModel();
		$this->rec_id = $rec_id;
		$tablename = $this->tablename;
		//editable fields
		$fields = $this->fields = array("id","adm_no","full_name","level","stream","kcpe","uploaded_by","password");
		$page_error = null;
		if($formdata){
			$postdata = array();
			$fieldname = $formdata['name'];
			$fieldvalue = $formdata['value'];
			$postdata[$fieldname] = $fieldvalue;
			$postdata = $this->format_request_data($postdata);
			$this->rules_array = array(
				'adm_no' => 'required',
				'full_name' => 'required',
				'level' => 'required',
				'stream' => 'required',
				'kcpe' => 'required',
				'uploaded_by' => 'required',
				'password' => 'required',
			);
			$this->sanitize_array = array(
				'adm_no' => 'sanitize_string',
				'full_name' => 'sanitize_string',
				'level' => 'sanitize_string',
				'stream' => 'sanitize_string',
				'kcpe' => 'sanitize_string',
				'uploaded_by' => 'sanitize_string',
				'password' => 'sanitize_string',
			);
			$this->filter_rules = true; //filter validation rules by excluding fields not in the formdata
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			if($this->validated()){
				$db->where("students.id", $rec_id);;
				$bool = $db->update($tablename, $modeldata);
				$numRows = $db->getRowCount();
				if($bool && $numRows){
					return render_json(
						array(
							'num_rows' =>$numRows,
							'rec_id' =>$rec_id,
						)
					);
				}
				else{
					if($db->getLastError()){
						$page_error = $db->getLastError();
					}
					elseif(!$numRows){
						$page_error = "No record updated";
					}
					render_error($page_error);
				}
			}
			else{
				render_error($this->view->page_error);
			}
		}
		return null;
	}
}