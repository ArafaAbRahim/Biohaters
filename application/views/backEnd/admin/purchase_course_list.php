<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-teal box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">Course Purchase List</h3>
                    <div class="box-tools pull-right">
                        <a href="<?php echo base_url('admin/purchase_course/add') ?>" class="btn bg-purple btn-sm"><i class="fa fa-plus"></i>Course Purchase Add</a>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table id="userListTable" class="table table-bordered table-striped table_th_teal">
                        <thead>
                            <tr>
                                <th style="width: 5%;"><?php echo $this->lang->line('sl'); ?></th>
                                <th style="width: 10%;">Purchase Date</th>
                                <th style="width: 15%;">Student</th>
                                <th style="width: 10%;">Sub Total</th>
                                <th style="width: 10%;">Discount</th>
                                <th style="width: 10%;">Total Bill</th>
                                <th style="width: 10%;">Status</th>
                                <th style="width: 20%;">Approved By</th>
                                <th style="width: 10%;"><?php echo $this->lang->line('action'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sl = 1;
                            foreach ($purchase_courses_list as $value) {
                            ?>
                                <tr>
                                    <td> <?= $sl++; ?> </td>
                                    <td> <?= date('d M, Y', strtotime($value->purchase_date)); ?> </td>
                                    <td> <?= $value->student_name; ?> <br> Roll: <?= $value->student_roll; ?> </td>
                                    <td> <?= $value->sub_total; ?> </td>
                                    <td> <?= $value->discount_amount; ?> </td>
                                    <td> <?= $value->total_bill; ?> </td>
                                    <td>
                                        <?php if ($value->aprrove_status == 1) { ?>
                                            <span class="badge bg-green">Accepted</span>
                                        <?php } elseif ($value->aprrove_status == 2) { ?>
                                            <span class="badge bg-red">Reject</span>
                                        <?php } else { ?>
                                            <span class="badge bg-orange">Pending</span>
                                        <?php } ?>
                                    </td>
                                    <td></td>
                                    <td>

                                        <?php if ($value->aprrove_status == 1) { ?>
                                            <a href="<?php echo base_url('admin/purchase_course/reject/' . $value->id); ?>" class="btn btn-sm bg-red"><i class="fa fa-thumbs-down"></i></a>
                                        <?php } else { ?>
                                            <a href="<?php echo base_url('admin/purchase_course/accepted/' . $value->id); ?>" class="btn btn-sm bg-green"><i class="fa fa-thumbs-up"></i></a>
                                        <?php } ?>
                                        <a href="<?php echo base_url('admin/purchase_course/view/' . $value->id); ?>" class="btn btn-sm bg-teal"><i class="fa fa-eye"></i></a>
                                        <a href="<?php echo base_url('admin/purchase_course/delete/' . $value->id); ?>" class="btn btn-sm btn-danger" onclick='return confirm("Are You Sure?")'><i class="fa fa-trash"></i></a>
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