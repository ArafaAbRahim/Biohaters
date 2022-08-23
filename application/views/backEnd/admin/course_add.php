<section class="content">
    <div class="row">
        <div class="col-md-12">
            <!-- Horizontal Form -->
            <div class="box box-teal box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">Course Add </h3>
                    <div class="box-tools pull-right">
                        <a href="<?php echo base_url() ?>admin/course/list" type="submit" class="btn bg-purple btn-sm" style="color: white;"> <i class="fa fa-list"></i> Course List </a>
                    </div>
                </div>
                <div class="box-body">

                    <div class="row">
                        <form action="<?php echo base_url("admin/course/add"); ?>" method="post" enctype="multipart/form-data" class="form-horizontal">

                            <div class="col-md-4">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label>Course Title </label>
                                            <input name="course_title" placeholder="Course Title " class="form-control inner_shadow_teal" type="text">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label>Course Level</label>
                                            <select name="course_level" class="form-control">
                                                <option value="" selected disabled> Select Level </option>
                                                <option value="1">Beginner</option>
                                                <option value="2">Advance</option>
                                                <option value="3">Expert</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label>Course Category </label>
                                            <select name="course_category_id" class=" form-control">
                                                <option value="" selected disabled> Select Category </option>
                                                <?php foreach ($category_data as $value) { ?>
                                                    <option value="<?= $value->id; ?>"> <?= $value->title; ?> </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label>Course Sub Category </label>
                                            <select name="course_sub_category_id" class=" form-control">
                                                <option value="" selected disabled> Select Sub Category </option>
                                                <?php foreach ($sub_category_data as $value) { ?>
                                                    <option value="<?= $value->id; ?>"> <?= $value->title; ?> </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label>Day </label>
                                            <select name="day_setting_id" class=" form-control">
                                                <option value="" selected disabled> Select Day </option>
                                                <?php foreach ($day_data as $value) { ?>
                                                    <option value="<?= $value->id; ?>"> <?= $value->day_to_day; ?> </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label>Time </label>
                                            <select name="time_setting_id" class=" form-control">
                                                <option value="" selected disabled> Select Time </option>
                                                <?php foreach ($time_data as $value) { ?>
                                                    <option value="<?= $value->id; ?>"> <?= $value->time_to_time; ?> </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label>Course Trailer</label>
                                            <input name="course_trailer" placeholder="Course Trailer" class="form-control inner_shadow_teal" type="text">
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="col-md-4">

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label>Exclusive</label>
                                            <select name="is_exclusive" class=" form-control">
                                                <option value="0">No</option>
                                                <option value="1">Yes</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label>Free Course</label>
                                            <select name="is_free_course" class=" form-control" id="free_course">
                                                <option value="1">Yes</option>
                                                <option value="0">No</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div id="course_price" style="display: none;">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>Course Price </label>
                                                <input name="course_price" placeholder="Course Price " class="form-control inner_shadow_teal" type="number">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>Discount Price </label>
                                                <input name="course_discount" placeholder="Discount Price " class="form-control inner_shadow_teal" type="number">
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label>Publish Status</label>
                                            <select name="publish_status" class=" form-control">
                                                <option value="1">Publish</option>
                                                <option value="0">Unpublished</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12">                                    
                                    <div class="form-group">                          
                                        <div class="col-sm-12">
                                            <label for="title_one">Course Tags</label>
                                            <input id="title" type="text" name="course_tags[]" class="form-control inner_shadow_teal" placeholder="Course Tag">
                                            <span id="add_tags" style="width: 100%; margin-bottom: 10px;"></span>                                            
                                            <span onclick="add_tags()"  style="background-color: #cad4e3; color: #4f5359; padding:0 5px;"> <i class="fa fa-plus"></i> More Tag Add</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12">                                    
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label>Requirements</label>
                                            <input id="title" type="text" name="requirements[]" class="form-control inner_shadow_teal" placeholder="Requirements" >
                                            <span id="add_requirements" style="width: 100%; margin-bottom: 10px;"></span>                                            
                                            <span onclick="add_requirements()"  style="background-color: #cad4e3; color: #4f5359; padding:0 5px;"> <i class="fa fa-plus"></i> More Requirement Add</span>                                            
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <input type="hidden" name="showrowid" id="showrowid2" value="3">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label>Outcomes</label>
                                            <input id="title" type="text" name="outcomes[]" class="form-control inner_shadow_teal" placeholder="Outcomes" >
                                            <span id="add_outcomes" style="width: 100%; margin-bottom: 10px;"></span>                                            
                                            <span onclick="add_outcomes()"  style="background-color: #cad4e3; color: #4f5359; padding:0 5px;"> <i class="fa fa-plus"></i> More Outcome Add</span>                                                                                        
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label><?php echo $this->lang->line('description'); ?></label>
                                            <textarea name="course_description" id="body" rows="1" class="form-control inner_shadow_teal"></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="box box-teal">
                                        <div class="box-header"> <label> Course Photo </label> </div>
                                        <div class="box-body box-profile">
                                            <center>
                                                <img id="courses_picture_change" class="img-responsive" src="//placehold.it/400x400" alt="profile picture" style="max-width: 120px;"><small style="color: gray">width : 400px, Height : 400px</small>
                                                <br>
                                                <input type="file" name="course_photo" onchange="readpicture(this);">
                                            </center>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="col-md-12">
                                <center>
                                    <button type="reset" class="btn btn-sm btn-danger"><?php echo $this->lang->line('reset'); ?></button>
                                    <button type="submit" class="btn btn-sm bg-teal"><?php echo $this->lang->line('save'); ?></button>
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
    function readpicture(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                $('#courses_picture_change')
                    .attr('src', e.target.result)
                    .width(100)
                    .height(100);
            };

            reader.readAsDataURL(input.files[0]);
        }
    }
</script>

<script type="text/javascript">
    CKEDITOR.replace('body');
</script>

<script type="text/javascript">
    $(document).ready(function() {

        $('#free_course').on('change', function() {

            if (this.value == 0) {

                $('#course_price').show();

            } else if (this.value == 1) {

                $('#course_price').hide();
            }
        });
    });

    function add_tags() {
        $('#add_tags').append('<input name="course_tags[]" style="margin-top:7px" placeholder="Course Tag" class="form-control inner_shadow_teal" type="text">')
    }

    function add_requirements() {
        $('#add_requirements').append('<input name="requirements[]" style="margin-top:7px" placeholder="Requirements" class="form-control inner_shadow_teal" type="text">')
    }

    function add_outcomes() {
        $('#add_outcomes').append('<input name="outcomes[]" style="margin-top:7px" placeholder="Outcomes" class="form-control inner_shadow_teal" type="text">')
    }
</script>