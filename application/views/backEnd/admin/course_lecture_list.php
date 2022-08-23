

<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-teal box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">Course Lecture List</h3>
                    <div class="box-tools pull-right">
                        <a href="<?php echo base_url('admin/course_lecture/add') ?>" class="btn bg-purple btn-sm"><i class="fa fa-plus"></i>Course Lecture Add</a>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table id="userListTable" class="table table-bordered table-striped table_th_teal">
                        <thead>
                            <tr>
                                <th style="width: 5%;"><?php echo $this->lang->line('sl'); ?></th>
                                <th style="width: 20%;">Title</th>
                                <th style="width: 15%;">Lecture Section</th>
                                <th style="width: 15%;">Course</th>
                                <th style="width: 25%;">Instructor</th>
                                <th style="width: 10%;">Price</th>                                                           
                                <th style="width: 10%;"><?php echo $this->lang->line('action'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                $sl = 1;
                                foreach ($course_lectures_list as $value) {
                                	?>
                            <tr>
                                <td> <?= $sl++ ; ?> </td>
                                <td> <?= $value->title; ?> </td>
                                <td> <?= $value->section_name; ?> </td>                                
                                <td> <?= $value->course_title; ?> </td>
                                <td> <?= $value->firstname. ' '.$value->lastname; ?> </td>
                                <td> Price: <?= $value->lecture_price; ?> <br> Discount: <?= $value->lecture_discount; ?></td>                                                  
                                <td> 
                                    <a href="<?php echo base_url('admin/course_lecture/edit/'.$value->id); ?>" class="btn btn-sm bg-teal"><i class="fa fa-edit"></i></a>
                                    <a href="<?php echo base_url('admin/course_lecture/delete/'.$value->id); ?>" class="btn btn-sm btn-danger" onclick = 'return confirm("Are You Sure?")'><i class="fa fa-trash"></i></a>
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

