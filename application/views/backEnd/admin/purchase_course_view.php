<section class="content">
    <div class="row">
        <div class="col-md-12">
            <!-- Horizontal Form -->
            <div class="box box-primary box-solid">
                <div class="box-header with-border">
                    <h4 class="box-title">
                        Purchase Course Details</h4>
                        
                </div>
                <div class="box-body">
                    <form action="<?php echo base_url() ?>admin/purchase_course/add" method="post" enctype="multipart/form-data" class="form-horizontal">
                        <div class="row">
                            <center style="margin-top: 0px;margin-bottom: 15px;">
                                <span style="border-bottom: 2px solid #00c0ef;text-align: center;font-size: 20px;color: #46808e;"><?php echo $this->lang->line('invoice_details'); ?></span>
                            </center>
                            <div class="col-md-12">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label>Student Roll: </label>
                                            
                                            <span><?= $purchase_info->student_roll; ?></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label>Purchase Date: </label>
                                            
                                            <span><?php echo date('d M Y', strtotime($purchase_info->purchase_date));?></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label>Student Information</label>
                                            <img id="student_photo" src="<?php echo base_url($purchase_info->student_photo) ?>" style="width: 50px; height: 50px;float: left;margin-right: 10px;margin-top: 10px;" />
                                            <p id="student_name" style="padding: 0;margin: 0;"><?= $purchase_info->student_name; ?></p>
                                            <p id="student_phone" style="padding: 0;margin: 0;"><?= $purchase_info->student_phone; ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <br>
                                <table class="table table-bordered table-striped table_th_primary" style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th style="width: 5%;"><?php echo $this->lang->line('sl'); ?></th>
                                            <th style="width: 15%;">Category</th>
                                            <th style="width: 15%;">Course</th>
                                            <th style="width: 20%;">Lecture</th>
                                            <th style="width: 15%;">Price</th>
                                            <th style="width: 15%;">Discount</th>
                                            <th style="width: 15%;">Total Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $total = 0;
                                        foreach ($purchase_courses_data as $key => $value) {
                                        ?>
                                            <tr>
                                                <td> <?= ++$key; ?></td>
                                                <td> <?= $value->catrgory_title; ?> </td>
                                                <td> <?= $value->course_title; ?> </td>
                                                <td> <?= $value->title; ?> </td>
                                                <td> <?= $value->amount; ?> </td>
                                                <td> <?= $value->discount; ?> </td>
                                                <td> <?= $value->net_payable; ?> </td>
                                            </tr>

                                        <?php  } ?>
                                        <tr>
                                            <td colspan="6" style="text-align: right; font-size: 18px; font-weight: bold;">Sub Total: </td>
                                            <td> <strong> <?php echo number_format(($purchase_info->sub_total), 2); ?> </strong></td>
                                        </tr>
                                        <tr>
                                            <td colspan="6" style="text-align: right; font-size: 18px; font-weight: bold;">Discount: </td>
                                            <td> <strong> <?php echo number_format(($purchase_info->discount_amount), 2); ?> </strong></td>
                                        </tr>
                                  
                                        <tr >
                                            <td colspan="6" style="text-align: right; font-size: 18px; font-weight: bold;">Discount by </td>
                                            <td> <strong> <?= $purchase_info->discount_by; ?> </strong></td>
                                        </tr>
                                        <tr>
                                            <td colspan="6" style="text-align: right; font-size: 18px; font-weight: bold;">Discount Reason </td>
                                            <td> <strong> <?= $purchase_info->discount_details; ?> </strong></td>
                                        </tr>
                                        <tr>
                                            <td colspan="6" style="text-align: right; font-size: 18px; font-weight: bold;">Total Payable: </td>
                                            <td> <strong> <?php echo number_format(($purchase_info->total_bill), 2); ?> </strong></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                       
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
