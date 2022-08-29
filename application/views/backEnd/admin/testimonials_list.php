

<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-teal box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title"><?php echo $this->lang->line('testimonial_list'); ?></h3>
                    <div class="box-tools pull-right">
                        <a href="<?php echo base_url('admin/testimonial/add') ?>" class="btn bg-purple btn-sm"><i class="fa fa-plus"></i><?php echo $this->lang->line('add_testimonial'); ?></a>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table id="userListTable" class="table table-bordered table-striped table_th_teal">
                        <thead>
                            <tr>
                                <th style="width: 5%;"><?php echo $this->lang->line('sl'); ?></th>
                                <th style="width: 20%;">Student</th>
                                <th style="width: 20%;"><?php echo $this->lang->line('name'); ?></th>                                
                                <th style="width: 10%;"><?php echo $this->lang->line('priority'); ?></th>
                                <th style="width: 35%;">Feedback</th>                                
                                <th style="width: 10%;"><?php echo $this->lang->line('action'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                $sl = 1;
                                foreach ($testimonials as $value) {
                                	?>
                            <tr>
                                <td> <?= $sl++ ; ?> </td>
                                <td> <?= $value->student_name; ?> <br> Roll: <?= $value->student_roll; ?> </td>
                                <td> <?= $value->name; ?> </td>                                
                                <td> <?= $value->priority; ?> </td>
                                <td> <?php echo character_limiter(strip_tags($value->feedback), 150); ?> </td>                               
                                <td> 
                                    <a href="<?php echo base_url('admin/testimonial/edit/'.$value->id); ?>" class="btn btn-sm bg-teal"><i class="fa fa-edit"></i></a>
                                    <a href="<?php echo base_url('admin/testimonial/delete/'.$value->id); ?>" class="btn btn-sm btn-danger" onclick = 'return confirm("Are You Sure?")'><i class="fa fa-trash"></i></a>
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

