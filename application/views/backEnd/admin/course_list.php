

<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-teal box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">Course List</h3>
                    <div class="box-tools pull-right">
                        <a href="<?php echo base_url('admin/course/add') ?>" class="btn bg-purple btn-sm"><i class="fa fa-plus"></i>Course Add</a>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table id="userListTable" class="table table-bordered table-striped table_th_teal">
                        <thead>
                            <tr>
                                <th style="width: 5%;"><?php echo $this->lang->line('sl'); ?></th>
                                <th style="width: 15%;"><?php echo $this->lang->line('name'); ?></th>
                                <th style="width: 15%;">Category</th>
                                <th style="width: 10%;">Level</th>
                                <th style="width: 25%;">Day & Time</th>
                                <th style="width: 10%;">Price</th>
                                <th style="width: 10%;">Status</th>                           
                                <th style="width: 10%;"><?php echo $this->lang->line('action'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                $sl = 1;
                                foreach ($courses as $value) {
                                	?>
                            <tr>
                                <td> <?= $sl++ ; ?> </td>
                                <td> <?= $value->course_title; ?> </td>
                                <td> <?= $value->title; ?> </td>
                                <td> 
                                    <?php if($value->course_level == 3){
                                        echo 'Expert';
                                    }elseif($value->course_level == 2){
                                        echo 'Advance';
                                    }else{
                                        echo 'Beginner';
                                    }?>
                                </td>
                                <td> Day: <?= $value->day_to_day; ?> <br> Time: <?= $value->time_to_time; ?> </td>
                                <td>
                                    <?php if($value->is_free_course == 0){ ?>
                                        <?= $value->course_price; ?>
                                    <?php }else{
                                        echo 'Free';
                                    }?>
                                </td>
                                <td> 
                                    <?php if($value->course_level == 1){
                                        echo 'Published';
                                    }else{
                                        echo 'Unpublished';
                                    }?>
                                </td>
                                <td> 
                                    <a href="<?php echo base_url('admin/course/edit/'.$value->id); ?>" class="btn btn-sm bg-teal"><i class="fa fa-edit"></i></a>
                                    <a href="<?php echo base_url('admin/course/delete/'.$value->id); ?>" class="btn btn-sm btn-danger" onclick = 'return confirm("Are You Sure?")'><i class="fa fa-trash"></i></a>
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

