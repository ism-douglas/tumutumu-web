<?php 
/**
 * Most_viewed_subjects Page Controller
 * @category  Controller
 */
class Most_viewed_subjectsController extends SecureController{
	function __construct(){
		parent::__construct();
		$this->tablename = "most_viewed_subjects";
	}
	/**
     * Custom list page
     * @return BaseView
     */
	function index(){
		$request = $this->request;
		$db = $this->GetModel();
		$pagination = null;
		$sqltext = "SELECT SQL_CALC_FOUND_ROWS   s.subject, SUM(n.views) AS number_of_views FROM notes AS n JOIN subjects AS s ON n.subject=s.code GROUP BY s.subject";
		$queryparams = null;
		if(!empty($request->orderby)){
			$orderby = $request->orderby;
			$ordertype = (!empty($request->ordertype) ? $request->ordertype : ORDER_TYPE);
			$db->orderBy($orderby, $ordertype);
		}
		else{
			$db->orderBy("subject", ORDER_TYPE);
		}
		$pagination = $this->get_pagination(6); //Get sql limit from url if not set on the sql command text
		$tc = $db->withTotalCount();
		$records = $db->query($sqltext, $pagination, $queryparams);
		$records_count = count($records);
		$total_records = intval($tc->totalCount);
		$page_limit = (!empty($pagination) ? $pagination[1] : 1);
		$total_pages = ceil($total_records / $page_limit);
		$data = new stdClass;
		$data->records = $records;
		$data->record_count = $records_count;
		$data->total_records = $total_records;
		$data->total_page = $total_pages;
		if($db->getLastError()){
			$this->set_page_error();
		}
		$page_title = $this->view->page_title = "Notes Viewed by Subject";
		$this->render_view("most_viewed_subjects/list.php", $data); //render the full page
	}
}
