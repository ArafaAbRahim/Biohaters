
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <!-- Horizontal Form -->
            <div class="box box-solid box-purple">
                <div class="box-header with-border">
                    <h3 class="box-title"> <?php
                        if (isset($edit_info))
                            echo 'Time Edit';
                        else
                            echo 'Time Add';
                        ?> </h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <?php if (isset($edit_info)) { ?>
                    <form action="<?php echo base_url("admin/time/edit/" . $edit_info->id); ?>" method="post" enctype="multipart/form-data" class="form-horizontal">
                        <div class="box-body">
                            <div class="row" style="box-shadow: 1px 1px 5px 1px #605CA8; margin: 10px 25px 25px 25px; padding: 35px 25px 25px 25px;">    
                                <div class="col-md-1"></div>                        
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="name" class="col-sm-4 control-label">Time to Time *</label>
                                        <div class="col-sm-8">
                                            <input id="name" type="text" name="time_to_time" value="<?= $edit_info->time_to_time; ?>" class="name form-control inner_shadow_purple" placeholder="Time to Time" required >
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-2">                                    
                                    <button type="submit" class="btn bg-red"><?php echo $this->lang->line('update'); ?></button>
                                </div>
                            </div>
                        </div>
                        <!-- /.box-body -->
                    </form>
                <?php } else { ?>
                    <form action="<?php echo base_url("admin/time/add"); ?>" method="post" enctype="multipart/form-data" class="form-horizontal">
                        <div class="box-body">
                            <div class="row" style="box-shadow: 1px 1px 5px 1px #605CA8; margin: 10px 25px 25px 25px; padding: 35px 25px 25px 25px;">   

                                <div class="col-md-1"></div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="name" class="col-sm-4 control-label">Time to Time *</label>
                                        <div class="col-sm-8">
                                            <input id="name" type="text" name="time_to_time" class="name form-control inner_shadow_purple" placeholder="Time to Time" required >
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-2">                                    
                                    <button type="submit" class="btn bg-red"><?php echo $this->lang->line('save'); ?></button>
                                </div>
                            </div>
                        </div>

                        <!-- /.box-body -->
                    </form>
                <?php } ?>
            </div>
            <!-- /.box -->
        </div>
        <!--/.col (right) -->
    </div>
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-purple">
                <div class="box-header with-border">
                    <h3 class="box-title"><strong>Time List</strong></h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table  class="table table-bordered table-striped table_th_purple">
                        <thead>
                            <tr>
                                <th style="width: 10%;"><?php echo $this->lang->line('sl'); ?></th>
                                <th style="width: 70%;">Time to Time</th>
                                <th style="width: 20%; "><?php echo $this->lang->line('action'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sl = 0;
                            foreach ($time_list as $value) {
                                ?>
                                <tr>
                                    <td> <?php echo ++$sl; ?> </td>
                                    <td> <?php echo $value->time_to_time; ?> </td>                                
                                    <td>
                                        <a class="btn bg-olive " href="<?php echo base_url() . 'admin/time/edit/' . $value->id; ?>"> <i class="fa fa-edit"></i></a>
                                        <a class="btn bg-maroon" href="<?php echo base_url() . 'admin/time/delete/' . $value->id; ?>" onclick="return confirm('Are you sure?')" > <i class="fa fa-trash"></i> </a>
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
    $(function() {
        $("#userListTable").DataTable();
    });
</script>