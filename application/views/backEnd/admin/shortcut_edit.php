
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <!-- Horizontal Form -->
            <div class="box box-purple box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">Shortcut Edit </h3>
                    <div class="box-tools pull-right">
                        <a href="<?php echo base_url() ?>admin/shortcut/list" type="submit" class="btn bg-green btn-sm" style="color: white;"> <i class="fa fa-list"></i> Shortcut List </a>
                    </div>
                </div>
                <div class="box-body">
                    <br>
                    <div class="row">
                        <form action="<?php echo base_url("admin/shortcut/edit/".$edit_info->id);?>" method="post" enctype="multipart/form-data" class="form-horizontal">
                            <br>
                            <div class="col-md-6">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label><?php echo $this->lang->line('name'); ?> </label>
                                            <input name="title" value="<?= $edit_info->title; ?>" placeholder="<?php echo $this->lang->line('name'); ?> " class="form-control inner_shadow_purple" required="" type="text">
                                        </div>
                                    </div>
                                </div>
                      
                                <div class="col-md-12"> 
                                    <br><br>
                                    <div class="col-md-2"></div> 
                                    <div class="col-md-8">                          
                                        <div class="box box-purple">
                                            <div class="box-header"> <label> Icon </label> </div>
                                            <div class="box-body box-profile">
                                                <center>
                                                    <img id="shortcut_picture_change" class="img-responsive" src="<?php if($edit_info->icon) echo base_url($edit_info->icon); ?>" alt="icon" style="max-width: 120px;"><small style="color: gray">width : 400px, Height : 400px</small>
                                                    <br>
                                                    <input type="file" name="icon" onchange="readpicture(this);">
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
                                        <textarea name="value" id="body" rows="1" class="form-control inner_shadow_purple"><?= $edit_info->value; ?></textarea>
                                    </div>
                                </div>
                            </div>


                            <div class="col-md-12">
                                <center>
                                    <button type="reset" class="btn btn-sm btn-danger"><?php echo $this->lang->line('reset'); ?></button>
                                    <button type="submit" class="btn btn-sm bg-purple"><?php echo $this->lang->line('update'); ?></button>
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
            $('#shortcut_picture_change')
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