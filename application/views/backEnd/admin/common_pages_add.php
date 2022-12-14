
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <!-- Horizontal Form -->
            <div class="box box-teal box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">Common Page Add </h3>
                    <div class="box-tools pull-right">
                        <a href="<?php echo base_url() ?>admin/common_pages/list" type="submit" class="btn bg-purple btn-sm" style="color: white;"> <i class="fa fa-list"></i> Common Page List </a>
                    </div>
                </div>
                <div class="box-body">
                    
                    <div class="row">
                        <form action="<?php echo base_url("admin/common_pages/add");?>" method="post" enctype="multipart/form-data" class="form-horizontal">
                            <br>
                            <div class="col-md-6">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label><?php echo $this->lang->line('name'); ?> </label>
                                            <input name="title" placeholder="<?php echo $this->lang->line('name'); ?> " class="form-control inner_shadow_teal" required="" type="text">
                                        </div>
                                    </div>
                                </div>
                      
                                <div class="col-md-12"> 
                                    <br><br>
                                    <div class="col-md-2"></div> 
                                    <div class="col-md-8">                          
                                        <div class="box box-teal">
                                            <div class="box-header"> <label> Photo </label> </div>
                                            <div class="box-body box-profile">
                                                <center>
                                                    <img id="common_pages_picture_change" class="img-responsive" src="//placehold.it/400x400" alt="profile picture" style="max-width: 120px;"><small style="color: gray">width : 400px, Height : 400px</small>
                                                    <br>
                                                    <input type="file" name="photo" onchange="readpicture(this);">
                                                </center>
                                            </div>                                
                                        </div> 
                                    </div>                               
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <label><?php echo $this->lang->line('description'); ?></label>
                                        <textarea name="body" id="body" rows="1" class="form-control inner_shadow_teal"></textarea>
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
    // profile picture change
    function readpicture(input) {
      if (input.files && input.files[0]) {
          var reader = new FileReader();
    
          reader.onload = function (e) {
            $('#common_pages_picture_change')
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