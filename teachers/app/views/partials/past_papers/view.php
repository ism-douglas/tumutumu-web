<?php
$comp_model = new SharedController;
$page_element_id = "view-page-" . random_str();
$current_page = $this->set_current_page_link();
$csrf_token = Csrf::$token;
//Page Data Information from Controller
$data = $this->view_data;
//$rec_id = $data['__tableprimarykey'];
$page_id = $this->route->page_id; //Page id from url
$view_title = $this->view_title;
$show_header = $this->show_header;
$show_edit_btn = $this->show_edit_btn;
$show_delete_btn = $this->show_delete_btn;
$show_export_btn = $this->show_export_btn;
?>
<section class="page" id="<?php echo $page_element_id; ?>" data-page-type="view"  data-display-type="table" data-page-url="<?php print_link($current_page); ?>">
    <?php
    if( $show_header == true ){
    ?>
    <div  class="bg-light p-3 mb-3">
        <div class="container">
            <div class="row ">
                <div class="col ">
                    <h4 class="record-title">Past Paper Details</h4>
                </div>
            </div>
        </div>
    </div>
    <?php
    }
    ?>
    <div  class="">
        <div class="container">
            <div class="row ">
                <div class="col-md-12 comp-grid">
                    <?php $this :: display_page_errors(); ?>
                    <div  class="card animated fadeIn page-content">
                        <?php
                        $counter = 0;
                        if(!empty($data)){
                        $rec_id = (!empty($data['id']) ? urlencode($data['id']) : null);
                        $counter++;
                        ?>
                        <div id="page-report-body" class="">
                            <table class="table table-hover table-borderless table-striped">
                                <!-- Table Body Start -->
                                <tbody class="page-data" id="page-data-<?php echo $page_element_id; ?>">
                                    <tr  class="td-id">
                                        <th class="title"> Paper ID: </th>
                                        <td class="value"> <?php echo $data['id']; ?></td>
                                    </tr>
                                    <tr  class="td-exam_types_exam_type">
                                        <th class="title"> Exam Type: </th>
                                        <td class="value"> <?php echo $data['exam_types_exam_type']; ?></td>
                                    </tr>
                                    <tr  class="td-subjects_subject">
                                        <th class="title"> Subject: </th>
                                        <td class="value"> <?php echo $data['subjects_subject']; ?></td>
                                    </tr>
                                    <tr  class="td-exam_year">
                                        <th class="title"> Exam Year: </th>
                                        <td class="value"> <?php echo $data['exam_year']; ?></td>
                                    </tr>
                                    <tr  class="td-academic_terms_term_name">
                                        <th class="title"> Academic Term: </th>
                                        <td class="value"> <?php echo $data['academic_terms_term_name']; ?></td>
                                    </tr>
                                    <tr  class="td-level">
                                        <th class="title"> Level: </th>
                                        <td class="value"> <?php echo $data['level']; ?></td>
                                    </tr>
                                    <tr  class="td-paper_types_paper_type">
                                        <th class="title"> Category: </th>
                                        <td class="value"> <?php echo $data['paper_types_paper_type']; ?></td>
                                    </tr>
                                    <tr  class="td-document">
                                        <th class="title"> Document: </th>
                                        <td class="value"><?php Html :: page_link_file($data['document']); ?></td>
                                    </tr>
                                    <tr  class="td-uploaded_by">
                                        <th class="title"> Uploaded By: </th>
                                        <td class="value"> <?php echo $data['uploaded_by']; ?></td>
                                    </tr>
                                    <tr  class="td-views">
                                        <th class="title"> Views: </th>
                                        <td class="value"> <?php echo $data['views']; ?></td>
                                    </tr>
                                    <tr  class="td-date_created">
                                        <th class="title"> Date Uploaded: </th>
                                        <td class="value"> <?php echo $data['date_created']; ?></td>
                                    </tr>
                                </tbody>
                                <!-- Table Body End -->
                            </table>
                        </div>
                        <div class="p-3 d-flex">
                            <a class="btn btn-sm btn-info"  href="<?php print_link("past_papers/edit/$rec_id"); ?>">
                                <i class="fa fa-edit"></i> Edit
                            </a>
                            <a class="btn btn-sm btn-danger record-delete-btn mx-1"  href="<?php print_link("past_papers/delete/$rec_id/?csrf_token=$csrf_token&redirect=$current_page"); ?>" data-prompt-msg="Are you sure you want to delete this record?" data-display-style="modal">
                                <i class="fa fa-times"></i> Delete
                            </a>
                        </div>
                        <?php
                        }
                        else{
                        ?>
                        <!-- Empty Record Message -->
                        <div class="text-muted p-3">
                            <i class="fa fa-ban"></i> No Record Found
                        </div>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
