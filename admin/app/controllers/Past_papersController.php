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
			"past_papers.exam_year", 
			"subjects.subject AS subjects_subject", 
			"past_papers.term", 
			"past_papers.level", 
			"past_papers.paper_type", 
			"past_papers.document", 
			"past_papers.views");
		$pagination = $this->get_pagination(MAX_RECORD_COUNT); // get current pagination e.g array(page_number, page_limit)
		//search table record
		if(!empty($request->search)){
			$text = trim($request->search); 
			$search_condition = "(
				past_papers.id LIKE ? OR 
				exam_types.exam_type LIKE ? OR 
				past_papers.exam_type LIKE ? OR 
				past_papers.exam_year LIKE ? OR 
				past_papers.subject LIKE ? OR 
				subjects.subject LIKE ? OR 
				past_papers.term LIKE ? OR 
				past_papers.level LIKE ? OR 
				past_papers.paper_type LIKE ? OR 
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
				subjects.subject_group LIKE ?
			)";
			$search_params = array(
				"%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%"
			);
			//setting search conditions
			$db->where($search_condition, $search_params);
			 //template to use when ajax search
			$this->view->search_template = "past_papers/search.php";
		}
		$db->join("exam_types", "past_papers.exam_type = exam_types.id", "INNER");
		$db->join("subjects", "past_papers.subject = subjects.code", "INNER");
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
		$this->render_view("past_papers/list.php", $data); //render the full page
	}
}
