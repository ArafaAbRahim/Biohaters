<section class="content">
    <div class="row">
        <div class="col-md-12">
            <!-- Horizontal Form -->
            <div class="box box-solid box-purple">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        <?php
                        if (isset($edit_info))
                            echo 'Payment Method Edit';
                        else
                            echo 'Payment Method Add';
                        ?> </h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <?php if (isset($edit_info)) { ?>

                    <form action="<?php echo base_url("admin/payment_method/edit/" . $edit_info->id); ?>" method="post" enctype="multipart/form-data" class="form-horizontal">
                        <div class="box-body">
                            <div class="row" style="box-shadow: 1px 1px 5px 1px #605CA8; margin: 10px 25px 25px 25px; padding: 35px 25px 25px 25px;">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label>Name *</label>
                                            <input name="name" value="<?= $edit_info->name; ?>" class="form-control inner_shadow_purple date" placeholder="Name" type="text" autocomplete="off">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label>Priority</label><small>(min to max)</small>
                                            <input name="priority" value="<?= $edit_info->priority; ?>" class="form-control inner_shadow_purple date" placeholder="Priority" type="number" autocomplete="off">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-5">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label>Information</label>
                                            <?php $fields_array = explode("**", $edit_info->input_field_format); ?>
                                            <?php foreach ($fields_array as $single_field) { ?>
                                                <input name="input_field_format[]" value="<?= $single_field; ?>" class="form-control inner_shadow_purple date" placeholder="Info" type="text" >
                                            <?php } ?>
                                            <span id="add_fields" style="width: 100%; margin-bottom: 10px;"></span>
                                            <span onclick="add_fields()" style="background-color: #cad4e3; color: #4f5359; padding:0 5px;"> <i class="fa fa-plus"></i> More Info Add</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12">                                    
                                    <center><button type="submit" class="btn btn-sm btn bg-purple">Update</button></center>                                                                            
                                </div>
                            </div>
                        </div>
                        <!-- /.box-body -->
                    </form>
                <?php } else { ?>

                    <form action="<?php echo base_url("admin/payment_method/add"); ?>" method="post" enctype="multipart/form-data" class="form-horizontal">
                        <div class="box-body">
                            <div class="row" style="box-shadow: 1px 1px 5px 1px #605CA8; margin: 10px 25px 25px 25px; padding: 35px 25px 25px 25px;">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label>Name *</label>
                                            <input name="name" class="form-control inner_shadow_purple date" placeholder="Name" type="text" autocomplete="off">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label>Priority</label><small>(min to max)</small>
                                            <input name="priority" class="form-control inner_shadow_purple date" placeholder="Priority" type="number" autocomplete="off">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-5">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label>Information</label>
                                            <input name="input_field_format[]" class="form-control inner_shadow_purple date" placeholder="Info" type="text" autocomplete="off">
                                            <span id="add_fields" style="width: 100%; margin-bottom: 10px;"></span>
                                            <span onclick="add_fields()" style="background-color: #cad4e3; color: #4f5359; padding:0 5px;"> <i class="fa fa-plus"></i> More Info Add</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12">                                    
                                    <center><button type="submit" class="btn btn-sm btn bg-purple">Save</button></center>                                                                            
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
                    <h3 class="box-title"><strong>Payment Method List</strong></h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table class="table table-bordered table-striped table_th_purple">
                        <thead>
                            <tr>
                                <th style="width: 10%;"><?php echo $this->lang->line('sl'); ?></th>
                                <th style="width: 20%;">Name</th>
                                <th style="width: 10%;">Priority</th>
                                <th style="width: 40%;">Information</th>
                                <th style="width: 20%;"><?php echo $this->lang->line('action'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sl = 0;
                            foreach ($payment_method_list as $value) {
                            ?>
                                <tr>
                                    <td> <?php echo ++$sl; ?> </td>
                                    <td> <?php echo $value->name; ?> </td>
                                    <td> <?php echo $value->priority; ?> </td>
                                    <td> <?php echo $value->input_field_format; ?> </td>
                                    <td>
                                        <a class="btn bg-olive " href="<?php echo base_url() . 'admin/payment-method/edit/' . $value->id; ?>"> <i class="fa fa-edit"></i></a>
                                        <a class="btn bg-maroon" href="<?php echo base_url() . 'admin/payment-method/delete/' . $value->id; ?>" onclick="return confirm('Are you sure?')"> <i class="fa fa-trash"></i> </a>
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

<script>
    function add_fields() {
        $('#add_fields').append('<input name="input_field_format[]" style="margin-top:7px" placeholder="Info" class="form-control inner_shadow_purple" type="text">')
    }
</script>