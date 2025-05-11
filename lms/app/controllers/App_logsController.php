<?php 
/**
 * App_logs Page Controller
 * @category  Controller
 */
class App_logsController extends BaseController{
	function __construct(){
		parent::__construct();
		$this->tablename = "app_logs";
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
		$fields = $this->fields = array("log_id","Timestamp","Action","TableName","RecordID","SqlQuery","UserID","ServerIP","RequestUrl","RequestData","RequestCompleted","RequestMsg");
		$page_error = null;
		if($formdata){
			$postdata = array();
			$fieldname = $formdata['name'];
			$fieldvalue = $formdata['value'];
			$postdata[$fieldname] = $fieldvalue;
			$postdata = $this->format_request_data($postdata);
			$this->rules_array = array(
				'Timestamp' => 'required',
				'Action' => 'required',
				'TableName' => 'required',
				'RecordID' => 'required',
				'SqlQuery' => 'required',
				'UserID' => 'required',
				'ServerIP' => 'required',
				'RequestUrl' => 'required',
				'RequestData' => 'required',
				'RequestCompleted' => 'required',
				'RequestMsg' => 'required',
			);
			$this->sanitize_array = array(
				'Timestamp' => 'sanitize_string',
				'Action' => 'sanitize_string',
				'TableName' => 'sanitize_string',
				'RecordID' => 'sanitize_string',
				'SqlQuery' => 'sanitize_string',
				'UserID' => 'sanitize_string',
				'ServerIP' => 'sanitize_string',
				'RequestUrl' => 'sanitize_string',
				'RequestData' => 'sanitize_string',
				'RequestCompleted' => 'sanitize_string',
				'RequestMsg' => 'sanitize_string',
			);
			$this->filter_rules = true; //filter validation rules by excluding fields not in the formdata
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			if($this->validated()){
				$db->where("app_logs.log_id", $rec_id);;
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
