<section class="content">
    <div class="row">
        <div class="col-md-12">
            <!-- Horizontal Form -->
            <div class="box box-teal box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">Course Lecture Add </h3>
                    <div class="box-tools pull-right">
                        <a href="<?php echo base_url() ?>admin/course_lecture/list" type="submit" class="btn bg-purple btn-sm" style="color: white;"> <i class="fa fa-list"></i> Course Lecture List </a>
                    </div>
                </div>
                <div class="box-body">

                    <div class="row">
                        <form action="<?php echo base_url("admin/course_lecture/add"); ?>" method="post" enctype="multipart/form-data" class="form-horizontal">

                            <div class="col-md-4">

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label>Title </label>
                                            <input name="title" placeholder="Title " class="form-control inner_shadow_teal" type="text">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label>Course</label>
                                            <select name="course_id" class=" form-control">
                                                <option value="" selected disabled> Select Course </option>
                                                <?php foreach ($course_data as $value) { ?>
                                                    <option value="<?= $value->id; ?>"> <?= $value->course_title; ?> </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label>Instructor </label>
                                            <select name="instructor_id" class=" form-control">
                                                <option value="" selected disabled> Select Instructor </option>
                                                <?php foreach ($instructor_data as $value) { ?>
                                                    <option value="<?= $value->id; ?>"> <?= $value->firstname. ' ' .$value->lastname; ?> </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label>Lecture Section </label>
                                            <select name="course_lecture_section_id" class=" form-control">
                                                <option value="" > Select Section </option>
                                                <?php foreach ($lecture_section_data as $value) { ?>
                                                    <option value="<?= $value->id; ?>"> <?= $value->section_name; ?> </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="col-md-4">

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label>Video Server</label>                                            
                                            <select name="video_server" class=" form-control">
                                                <option value="" selected disabled> Select Server </option>
                                                <option value="server"> Server </option>
                                                <option value="youtube"> Youtube</option>
                                                <option value="vimeo"> Vimeo </option>
                                                <option value="dailymotion"> Dailymotion </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label>Video Link</label>
                                            <input name="video_link" placeholder="Video Link" class="form-control inner_shadow_teal" type="text">
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label>Lecture Price </label>
                                            <input name="lecture_price" placeholder="Lecture Price " class="form-control inner_shadow_teal" type="number">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label>Discount Price </label>
                                            <input name="lecture_discount" placeholder="Discount Price " class="form-control inner_shadow_teal" type="number">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12">                                    
                                    <div class="form-group">                          
                                        <div class="col-sm-12">
                                            <label for="title_one">Keywords</label>
                                            <input id="title" type="text" name="keywords[]" class="form-control inner_shadow_teal" placeholder="keywords">
                                            <span id="add_keywords" style="width: 100%; margin-bottom: 10px;"></span>                                            
                                            <span onclick="add_keywords()"  style="background-color: #cad4e3; color: #4f5359; padding:0 5px;"> <i class="fa fa-plus"></i> More keywords Add</span>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="col-md-4">

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label><?php echo $this->lang->line('description'); ?></label>
                                            <textarea name="sort_description" id="body" rows="1" class="form-control inner_shadow_teal"></textarea>
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


<script type="text/javascript">
    CKEDITOR.replace('body');
</script>

<script type="text/javascript">

    function add_keywords() {
        $('#add_keywords').append('<input name="keywords[]" style="margin-top:7px" placeholder="keywords" class="form-control inner_shadow_teal" type="text">')
    }

</script>