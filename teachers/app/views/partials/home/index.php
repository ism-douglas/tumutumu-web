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
                <div class="col-md-4 comp-grid">
                </div>
            </div>
        </div>
    </div>
    <div  class="p-3 mb-3">
        <div class="container">
            <div class="row ">
                <div class="col-md-12 comp-grid">
                </div>
                <div class="col-md-4 col-sm-4 comp-grid">
                    <?php $rec_count = $comp_model->getcount_studentnotes();  ?>
                    <a class="animated zoomIn record-count card bg-light text-dark"  href="<?php print_link("notes/") ?>">
                        <div class="row">
                            <div class="col-2">
                                <i class="fa fa-book fa-2x"></i>
                            </div>
                            <div class="col-10">
                                <div class="flex-column justify-content align-center">
                                    <div class="title">Student Notes</div>
                                    <small class="">Total notes uploaded</small>
                                </div>
                            </div>
                            <h4 class="value"><strong><?php echo $rec_count; ?></strong></h4>
                        </div>
                    </a>
                </div>
                <div class="col-md-4 col-sm-4 comp-grid">
                    <?php $rec_count = $comp_model->getcount_pastpapers();  ?>
                    <a class="animated zoomIn record-count card bg-light text-dark"  href="<?php print_link("past_papers/") ?>">
                        <div class="row">
                            <div class="col-2">
                                <i class="fa fa-bookmark fa-2x"></i>
                            </div>
                            <div class="col-10">
                                <div class="flex-column justify-content align-center">
                                    <div class="title">Past Papers</div>
                                    <small class="">Previous exams uploaded</small>
                                </div>
                            </div>
                            <h4 class="value"><strong><?php echo $rec_count; ?></strong></h4>
                        </div>
                    </a>
                </div>
                <div class="col-md-4 col-sm-4 comp-grid">
                    <?php $rec_count = $comp_model->getcount_examtypes();  ?>
                    <a class="animated zoomIn record-count card bg-light text-dark"  href="<?php print_link("exam_types/") ?>">
                        <div class="row">
                            <div class="col-2">
                                <i class="fa fa-newspaper-o fa-2x"></i>
                            </div>
                            <div class="col-10">
                                <div class="flex-column justify-content align-center">
                                    <div class="title">Exam Types</div>
                                    <small class="">Exam categories available</small>
                                </div>
                            </div>
                            <h4 class="value"><strong><?php echo $rec_count; ?></strong></h4>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div  class="p-3 mb-3">
        <div class="container">
            <div class="row ">
                <div class="col-md-12 comp-grid">
                </div>
                <div class="col-md-4 comp-grid">
                    <div class="card card-body">
                        <?php 
                        $chartdata = $comp_model->piechart_notesbylevel();
                        ?>
                        <div>
                            <h4>Notes by Level</h4>
                            <small class="text-muted">Number of notes per class</small>
                        </div>
                        <hr />
                        <canvas id="piechart_notesbylevel"></canvas>
                        <script>
                            $(function (){
                            var chartData = {
                            labels : <?php echo json_encode($chartdata['labels']); ?>,
                            datasets : [
                            {
                            label: 'Notes',
                            backgroundColor:[
                            <?php 
                            foreach($chartdata['labels'] as $g){
                            echo "'" . random_color(0.9) . "',";
                            }
                            ?>
                            ],
                            borderWidth:3,
                            data : <?php echo json_encode($chartdata['datasets'][0]); ?>,
                            }
                            ]
                            }
                            var ctx = document.getElementById('piechart_notesbylevel');
                            var chart = new Chart(ctx, {
                            type:'pie',
                            data: chartData,
                            options: {
                            responsive: true,
                            scales: {
                            yAxes: [{
                            ticks:{display: false},
                            gridLines:{display: false},
                            scaleLabel: {
                            display: true,
                            labelString: ""
                            }
                            }],
                            xAxes: [{
                            ticks:{display: false},
                            gridLines:{display: false},
                            scaleLabel: {
                            display: true,
                            labelString: ""
                            }
                            }],
                            },
                            }
                            ,
                            })});
                        </script>
                    </div>
                </div>
                <div class="col-md-4 comp-grid">
                    <div class="card card-body">
                        <?php 
                        $chartdata = $comp_model->barchart_pastpaperbyyear();
                        ?>
                        <div>
                            <h4>Past Paper by Year</h4>
                            <small class="text-muted">Previous exams per year</small>
                        </div>
                        <hr />
                        <canvas id="barchart_pastpaperbyyear"></canvas>
                        <script>
                            $(function (){
                            var chartData = {
                            labels : <?php echo json_encode($chartdata['labels']); ?>,
                            datasets : [
                            {
                            label: 'Past Papers',
                            backgroundColor:[
                            <?php 
                            foreach($chartdata['labels'] as $g){
                            echo "'" . random_color(0.9) . "',";
                            }
                            ?>
                            ],
                            type:'',
                            borderWidth:3,
                            data : <?php echo json_encode($chartdata['datasets'][0]); ?>,
                            }
                            ]
                            }
                            var ctx = document.getElementById('barchart_pastpaperbyyear');
                            var chart = new Chart(ctx, {
                            type:'bar',
                            data: chartData,
                            options: {
                            scaleStartValue: 0,
                            responsive: true,
                            scales: {
                            xAxes: [{
                            ticks:{display: true},
                            gridLines:{display: true},
                            categoryPercentage: 1.0,
                            barPercentage: 0.8,
                            scaleLabel: {
                            display: true,
                            labelString: ""
                            },
                            }],
                            yAxes: [{
                            ticks: {
                            beginAtZero: true,
                            display: true
                            },
                            scaleLabel: {
                            display: true,
                            labelString: ""
                            }
                            }]
                            },
                            }
                            ,
                            })});
                        </script>
                    </div>
                </div>
                <div class="col-md-4 comp-grid">
                    <div class=" ">
                        <?php  
                        $this->render_page("most_viewed_subjects/list?limit_count=6" , array( 'show_footer' => false,'show_pagination' => false )); 
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
