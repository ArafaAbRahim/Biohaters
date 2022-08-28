

<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-teal box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">Lecture Quiz List</h3>
                    <div class="box-tools pull-right">
                        <a href="<?php echo base_url('admin/lecture_quiz/add') ?>" class="btn bg-purple btn-sm"><i class="fa fa-plus"></i>Lecture Quiz Add</a>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table id="userListTable" class="table table-bordered table-striped table_th_teal">
                        <thead>
                            <tr>
                                <th style="width: 5%;"><?php echo $this->lang->line('sl'); ?></th>
                                <th style="width: 10%;">Course</th>                     
                                <th style="width: 10%;">Lecture</th>
                                <th style="width: 20%;">Quiz Ques</th>
                                <th style="width: 35%;">Options</th>
                                <th style="width: 10%;">Correct Option</th>                                
                                <th style="width: 10%;"><?php echo $this->lang->line('action'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                $sl = 1;
                                foreach ($lecture_quiz_list as $value) {
                                	?>
                            <tr>
                                <td> <?= $sl++ ; ?> </td>
                                <td> <?= $value->course_title; ?> </td>                              
                                <td> <?= $value->title; ?> </td>
                                <td> <?= $value->quiz_question; ?> </td>
                                <td> (1)<?= $value->option_1; ?> (2)<?= $value->option_2; ?> (3)<?= $value->option_3; ?> (4)<?= $value->option_4; ?> (5)<?= $value->option_5; ?> </td>
                                <td> <?= $value->correct_options; ?> </td>
                                <td> 
                                    <a href="<?php echo base_url('admin/lecture-quiz/edit/'.$value->id); ?>" class="btn btn-sm bg-teal"><i class="fa fa-edit"></i></a>
                                    <a href="<?php echo base_url('admin/lecture-quiz/delete/'.$value->id); ?>" class="btn btn-sm btn-danger" onclick = 'return confirm("Are You Sure?")'><i class="fa fa-trash"></i></a>
                                </td>
                            </tr>
                            <?php
                                }
                                ?>
                        </tbody>
                    </table>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->
    </div>
</section>
<script type="text/javascript">
    $(function () {
      $("#userListTable").DataTable();
    });
    
</script>

