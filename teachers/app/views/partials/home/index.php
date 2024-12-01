<?php 
$page_id = null;
$comp_model = new SharedController;
$current_page = $this->set_current_page_link();
?>
<div>
    <div  class="bg-light p-3 mb-3">
        <div class="container">
            <div class="row ">
                <div class="col-md-12 comp-grid">
                    <h4 >Teachers' Dashboard</h4>
                </div>
            </div>
        </div>
    </div>
    <div  class="">
        <div class="container">
            <div class="row ">
                <div class="col-md-12 comp-grid">
                </div>
                <div class="col-md-4 comp-grid">
                    <?php $rec_count = $comp_model->getcount_notes();  ?>
                    <a class="animated zoomIn record-count card bg-light text-dark"  href="<?php print_link("notes/") ?>">
                        <div class="row">
                            <div class="col-2">
                                <i class="fa fa-book fa-2x"></i>
                            </div>
                            <div class="col-10">
                                <div class="flex-column justify-content align-center">
                                    <div class="title">Notes</div>
                                    <small class="">All notes uploaded</small>
                                </div>
                            </div>
                            <h4 class="value"><strong><?php echo $rec_count; ?></strong></h4>
                        </div>
                    </a>
                </div>
                <div class="col-md-4 comp-grid">
                    <?php $rec_count = $comp_model->getcount_pastpapers();  ?>
                    <a class="animated zoomIn record-count card bg-light text-dark"  href="<?php print_link("past_papers/") ?>">
                        <div class="row">
                            <div class="col-2">
                                <i class="fa fa-bookmark fa-2x"></i>
                            </div>
                            <div class="col-10">
                                <div class="flex-column justify-content align-center">
                                    <div class="title">Past Papers</div>
                                    <small class="">Total past papers uploaded</small>
                                </div>
                            </div>
                            <h4 class="value"><strong><?php echo $rec_count; ?></strong></h4>
                        </div>
                    </a>
                </div>
                <div class="col-md-4 comp-grid">
                    <?php $rec_count = $comp_model->getcount_subjects();  ?>
                    <a class="animated zoomIn record-count card bg-light text-dark"  href="<?php print_link("subjects/") ?>">
                        <div class="row">
                            <div class="col-2">
                                <i class="fa fa-list-alt fa-2x"></i>
                            </div>
                            <div class="col-10">
                                <div class="flex-column justify-content align-center">
                                    <div class="title">Subjects</div>
                                    <small class="">Total school subject</small>
                                </div>
                            </div>
                            <h4 class="value"><strong><?php echo $rec_count; ?></strong></h4>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
