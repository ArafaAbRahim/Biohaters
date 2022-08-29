

<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-purple box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">Shortcut List</h3>
                    <div class="box-tools pull-right">
                        <a href="<?php echo base_url('admin/shortcut/add') ?>" class="btn bg-green btn-sm"><i class="fa fa-plus"></i> Shortcut Add</a>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table id="userListTable" class="table table-bordered table-striped table_th_purple">
                        <thead>
                            <tr>
                                <th style="width: 5%;"><?php echo $this->lang->line('sl'); ?></th>
                                <th style="width: 15%;"><?php echo $this->lang->line('name'); ?></th>                     
                                <th style="width: 25%;"><?php echo $this->lang->line('description'); ?></th>
                                <th style="width: 10%;"><?php echo $this->lang->line('image'); ?></th>
                                <th style="width: 10%;"><?php echo $this->lang->line('action'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                $sl = 1;
                                foreach ($shortcut as $value) {
                                	?>
                            <tr>
                                <td> <?php echo $sl++ ; ?> </td>
                                <td> <?php echo $value->title; ?> </td>                              
                                <td> <?php echo character_limiter(strip_tags($value->value), 150); ?> </td>
                                <td>
                                    <?php if($value->icon) { ?>
                                        <img src="<?php echo base_url($value->icon) ?>" alt="" width="50px" height="50px">
                                    <?php } ?>
                                </td>
                                <td> 
                                    <a href="<?php echo base_url('admin/shortcut/edit/'.$value->id); ?>" class="btn btn-sm bg-purple"><i class="fa fa-edit"></i></a>
                                    <a href="<?php echo base_url('admin/shortcut/delete/'.$value->id); ?>" class="btn btn-sm btn-danger" onclick = 'return confirm("Are You Sure?")'><i class="fa fa-trash"></i></a>
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

