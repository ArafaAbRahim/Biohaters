
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <!-- Horizontal Form -->
            <div class="box box-teal box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">Lecture Quiz Edit </h3>
                    <div class="box-tools pull-right">
                        <a href="<?php echo base_url() ?>admin/lecture_quiz/list" type="submit" class="btn bg-purple btn-sm" style="color: white;"> <i class="fa fa-list"></i> Lecture Quiz List </a>
                    </div>
                </div>
                <div class="box-body">
                    
                    <div class="row">
                        <form action="<?php echo base_url("admin/lecture_quiz/edit/".$edit_info->id);?>" method="post" enctype="multipart/form-data" class="form-horizontal">
                            
                            <div class="col-md-12">

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label>Course </label>
                                            <select name="course_id" id="course_id" class=" form-control">
                                                <option value="" selected disabled> Select Course </option>
                                                <?php foreach ($course_data as $value) { ?>
                                                    <option value="<?= $value->id; ?>" <?php if($edit_info->course_id == $value->id) echo 'selected'; ?> > <?= $value->course_title; ?> </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label>Lecture</label>
                                            <select name="lecture_id"  id="lecture_id" class="select2 form-control inner_shadow_teal" >
                                                <option value="" >Select Course First</option> 
                                                <?php foreach ($course_lecture_data as $value) { ?>
                                                    <option value="<?= $value->id; ?>" <?php if($edit_info->lecture_id == $value->id) echo 'selected'; ?> > <?= $value->title; ?> </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label>Quiz Question </label>
                                            <input name="quiz_question" value="<?= $edit_info->quiz_question; ?>" placeholder="Quiz Question " class="form-control inner_shadow_teal" required="" type="text">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label>Option 1 </label>
                                            <input name="option_1" value="<?= $edit_info->option_1; ?>" placeholder="Option 1 " class="form-control inner_shadow_teal" required="" type="text">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label>Option 2 </label>
                                            <input name="option_2" value="<?= $edit_info->option_2; ?>" placeholder="Option 2 " class="form-control inner_shadow_teal" required="" type="text">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label>Option 3 </label>
                                            <input name="option_3" value="<?= $edit_info->option_3; ?>" placeholder="Option 3 " class="form-control inner_shadow_teal" required="" type="text">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label>Option 4 </label>
                                            <input name="option_4" value="<?= $edit_info->option_4; ?>" placeholder="Option 4 " class="form-control inner_shadow_teal" required="" type="text">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label>Option 5 </label>
                                            <input name="option_5" value="<?= $edit_info->option_5; ?>" placeholder="Option 5 " class="form-control inner_shadow_teal" required="" type="text">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label>Correct Option </label>                                            
                                            <select name="correct_options" class=" form-control">
                                                <option value=""> Select Option </option>
                                                <option value="1" <?php if($edit_info->correct_options == 1) echo 'selected'; ?> > 1 </option>
                                                <option value="2" <?php if($edit_info->correct_options == 2) echo 'selected'; ?> > 2 </option>
                                                <option value="3" <?php if($edit_info->correct_options == 3) echo 'selected'; ?> > 3 </option>
                                                <option value="4" <?php if($edit_info->correct_options == 4) echo 'selected'; ?> > 4 </option>
                                                <option value="5" <?php if($edit_info->correct_options == 5) echo 'selected'; ?> > 5 </option>                                                                                                
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label>Explanation</label>
                                            <textarea name="explanation" id="body" rows="1" class="form-control inner_shadow_teal"><?= $edit_info->explanation; ?></textarea>
                                        </div>
                                    </div>
                                </div>


                            <div class="col-md-12">
                                <center>
                                    <button type="reset" class="btn btn-sm btn-danger"><?php echo $this->lang->line('reset'); ?></button>
                                    <button type="submit" class="btn btn-sm bg-teal"><?php echo $this->lang->line('update'); ?></button>
                                </center>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- /.box -->
        </div>
        <!--/.col (right) -->
    </div>
</section>

<script>
    $(document).ready(function () {

        $('#course_id').change(function () {
            $('#lecture_id').find('option').remove().end().append("<option value=''>Select Lecture</option>");            
            load_lecture($(this).find(':selected').val() );
        }); 
    
    }); 

    
    function load_lecture(course_id) {
        $.post("<?php echo base_url() . "admin/get_lecture_from_course_category/"; ?>" + course_id,
                {'nothing': 'nothing'},
                function (data2) {
                    var data = JSON.parse(data2);
                    $.each(data, function (i, item) {
    
                        $("#lecture_id").append($('<option>', {
                            value: this.id,
                            text: this.title,
                        }));
                    });
                });
    }
    
</script>
