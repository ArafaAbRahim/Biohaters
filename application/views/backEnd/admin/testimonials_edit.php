<section class="content">
    <div class="row">
        <div class="col-md-12">
            <!-- Horizontal Form -->
            <div class="box box-teal box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title"><?php echo $this->lang->line('update_testimonial'); ?> </h3>
                    <div class="box-tools pull-right">
                        <a href="<?php echo base_url() ?>admin/testimonial/list" type="submit" class="btn bg-purple btn-sm" style="color: white;"> <i class="fa fa-list"></i> <?php echo $this->lang->line('testimonial_list'); ?> </a>
                    </div>
                </div>
                <div class="box-body">

                    <div class="row">
                        <form action="<?php echo base_url("admin/testimonial/edit/" . $edit_info->id); ?>" method="post" enctype="multipart/form-data" class="form-horizontal">

                            <div class="col-md-6">

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label>Student </label>
                                            <select name="student_id" class="select2 form-control">
                                                <option value="">Select Student</option>
                                                <?php foreach ($student_list as $value) { ?>
                                                    <option value="<?= $value->id; ?>" <?php if ($edit_info->student_id == $value->id) echo 'selected'; ?> ><?= $value->student_name . '(' . $value->student_roll . ')'; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label><?php echo $this->lang->line('name'); ?> </label>
                                            <input name="name" placeholder="<?php echo $this->lang->line('name'); ?> " class="form-control inner_shadow_teal" required="" type="text" value="<?php echo $edit_info->name; ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label><?php echo $this->lang->line('priority'); ?></label><small style="color: gray"><?php echo $this->lang->line('sorting_will_be_max_to_min'); ?></small>
                                            <input name="priority" placeholder="<?php echo $this->lang->line('priority'); ?>" class="form-control inner_shadow_teal" type="number" value="<?php echo $edit_info->priority; ?>">
                                        </div>
                                    </div>
                                </div>


                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label>Active</label>
                                            <select name="is_active" class="form-control">
                                                <option value="1" <?php if ($edit_info->is_active == 1) echo 'selected'; ?>>Yes</option>
                                                <option value="0" <?php if ($edit_info->is_active == 0) echo 'selected'; ?>>No</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                            </div>


                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <label><?php echo $this->lang->line('description'); ?></label>
                                        <textarea name="feedback" id="body" class="form-control inner_shadow_teal"><?php echo $edit_info->feedback; ?></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <center>
                                    <button type="reset" class="btn btn-sm btn-danger"><?php echo $this->lang->line('cancel'); ?></button>
                                    <button type="submit" class="btn btn-sm bg-teal"><?php echo $this->lang->line('update'); ?></button>
                                </center>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>

    </div>
</section>

<script type="text/javascript">
    CKEDITOR.replace('body');
</script>