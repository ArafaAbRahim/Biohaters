<section class="content">
    <div class="row">
        <div class="col-md-12">
            <!-- Horizontal Form -->
            <div class="box box-primary box-solid">
                <div class="box-header with-border">
                    <h4 class="box-title">
                    Purchase Course</h3>
                    <div class="box-tools pull-right">
                        <a href="<?php echo base_url() ?>admin/test-details/list" type="submit" class="btn bg-purple btn-sm" style="color: white;"> <i class="fa fa-list"></i> <?php echo $this->lang->line('test_details_list'); ?> </a>
                    </div>
                </div>
                <div class="box-body">
                    <form action="<?php echo base_url() ?>admin/purchase_course/add" method="post" enctype="multipart/form-data" class="form-horizontal">
                        <div class="row" > 
                            <center style="margin-top: 0px;margin-bottom: 15px;">
                                <span style="border-bottom: 2px solid #00c0ef;text-align: center;font-size: 20px;color: #46808e;"><?php echo $this->lang->line('invoice_details'); ?></span>
                            </center>
                            <div class="col-md-12">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label>Student Roll*</label>
                                            <input name="student_roll" id="student_roll" onchange="get_student_id_from_roll()" placeholder="Student Roll" class="form-control inner_shadow_primary" type="text" autocomplete="off" required>
                                            <input type="hidden" name="student_id" id="student_id">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label>Purchase Date*</label>
                                            <input name="purchase_date"  class="form-control inner_shadow_primary date"  type="text" autocomplete="off" required>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label>Student Information</label>
                                            <img id="student_photo" src="" style="width: 50px; height: 50px;float: left;margin-right: 10px;margin-top: 10px;"/>
                                            <p id="student_name" style="padding: 0;margin: 0;" ></p>
                                            <p id="student_phone" style="padding: 0;margin: 0;" ></p>
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
                                        <input type="hidden" name="showrowid" id="showrowid" value="3">
                                        <?php
                                            // 61 is the max limit, change to javascript also from botom of the code.
                                            
                                            for ($i = 1; $i <= 10; $i++) { ?>
                                        <tr id="trid<?= $i; ?>" style="<?php if ($i > 2) echo 'display: none'; ?>">
                                            <td><?php echo $i; ?></td>
                                            <td>
                                                <select class="form-control select2" style="width:100%" onchange="load_course(this.value, '<?= $i; ?>')">
                                                    <option value="">Select Category</option>
                                                    <?php foreach ($category_list as $key => $value) : ?>
                                                    <option data-keyid="<?= $i; ?>" value="<?php echo $value->id; ?>"><?php echo $value->title; ?></option>
                                                    <?php endforeach ?>
                                                </select>
                                            </td>
                                            <td>
                                                <select name="course_id[]" id="course_id_<?= $i; ?>" onchange="load_lectures(this.value, <?= $i; ?>)" class="select2 form-control inner_shadow_teal" style="width:100%">
                                                    <option value="">Select Category First</option>
                                                </select>
                                            </td>
                                            <td>
                                                <select name="course_lecture_id[]" id="lecture_id_<?= $i; ?>" class="select2 form-control inner_shadow_teal" onchange="load_amount_from_lecture(this.value, <?= $i; ?>)" style="width:100%">
                                                    <option value="">Select Course First</option>
                                                </select>
                                            </td>
                                            <td>
                                                <input type="number" class="form-control inner_shadow_primary numberconvert" name="amount[]" value="0" id="course_fee<?= $i; ?>" placeholder="Price" readonly>
                                            </td>
                                            <td>
                                                <input type="number" class="form-control inner_shadow_primary numberconvert" name="discount[]" value="0" id="discount<?= $i; ?>" placeholder="discount" readonly>
                                            </td>
                                            <td>
                                                <input type="number" class="form-control inner_shadow_primary numberconvert" name="net_payable[]" value="0" id="net_payable<?= $i; ?>" placeholder="<?php echo $this->lang->line('amount'); ?>" readonly>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                        <tr>
                                            <td colspan="6" style="text-align: right; font-size: 18px; font-weight: bold;">Sub Total: </td>
                                            <td>
                                                <input type="text" readonly id="total_amount_id" name="sub_total" class="form-control inner_shadow_primary" value="0">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="6" style="text-align: right; font-size: 18px; font-weight: bold;">Discount: </td>
                                            <td>
                                                <input type="checkbox" name="is_discount" id="discount_check" class="pull-right">
                                            </td>
                                        </tr>
                                        <tr id="discount_tr" style="display: none;">
                                            <td colspan="6" style="text-align: right; font-size: 18px; font-weight: bold;">Discount Amount: </td>
                                            <td>
                                                <input type="text" name="discount_amount" id="discount_amount" class="form-control inner_shadow_primary" onkeyup="discount_cal()" autocomplete="off">
                                            </td>
                                        </tr>
                                        <tr id="discount_by" style="display: none;">
                                            <td colspan="6" style="text-align: right; font-size: 18px; font-weight: bold;">Discount by </td>
                                            <td>
                                                <input type="text" id="permit_by" name="discount_by" class="form-control inner_shadow_primary">
                                            </td>
                                        </tr>
                                        <tr id="discount_option" style="display: none;">
                                            <td colspan="6" style="text-align: right; font-size: 18px; font-weight: bold;">Discount Reason </td>
                                            <td>
                                                <input type="text" id="reason" name="discount_details" class="form-control inner_shadow_primary">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="6" style="text-align: right; font-size: 18px; font-weight: bold;">Total Payable: </td>
                                            <td>
                                                <input type="text" id="payable" name="total_bill" class="form-control inner_shadow_primary" readonly="">
                                            </td>
                                        </tr>
                                    </tbody>
                                </table> 
                            </div>
                            <div class="col-md-12">
                                <center>
                                    <button type="reset" class="btn btn-sm btn-danger"><?php echo $this->lang->line('reset'); ?></button>
                                    <button type="submit" class="btn btn-sm bg-purple"><?php echo $this->lang->line('save'); ?></button>
                                    <a class="btn btn-info" onclick="makerowvisible();"><i class="fa fa-plus"></i> </a>
                                </center>
                            </div> 
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    $(function(){
    
        $('.date').datepicker({
    
            autoclose: true,
            changeYear:true,
            changeMonth:true,
            dateFormat: "dd-mm-yy",
            yearRange: "-10:+10"
        });
    
        $('.timepicker').timepicker({
            
            showInputs: false
        });       
    });
</script>
<script>
    function load_amount_from_course(course_id, keyid) {
    
       $.post("<?php echo base_url() . "admin/get_course_amount/"; ?>" + course_id, {
             'nothing': 'nothing'
          },
          function(data2) {
    
             var data = JSON.parse(data2);
    
             $('#course_fee' + keyid).val(data.course_price);
             $('#discount' + keyid).val(data.course_discount);
    
    
             $("#net_payable" + keyid).val(data.course_price - data.course_discount);
    
             var total_amount = 0;
    
             for (var i = 1; i < 10; i++) {
    
                var tempamount = $('#net_payable' + i).val();
                total_amount += Number(tempamount);
             }
    
             $('#total_amount_id').val(total_amount);
             $('#payable').val(total_amount);
    
          });
    
    }
    
    function load_amount_from_lecture(lecture_id, keyid) {
    
       $.post("<?php echo base_url() . "admin/get_lecture_amount/"; ?>" + lecture_id, {
             'nothing': 'nothing'
          },
          function(data2) {
             var data = JSON.parse(data2);
    
             $('#course_fee' + keyid).val(data.lecture_price);
             $('#discount' + keyid).val(data.lecture_discount);
    
             $("#net_payable" + keyid).val(data.lecture_price - data.lecture_discount);
    
             var total_amount = 0;
    
             for (var i = 1; i < 10; i++) {
    
                var tempamount = $('#net_payable' + i).val();
                total_amount += Number(tempamount);
             }
    
             $('#total_amount_id').val(total_amount);
             $('#payable').val(total_amount);
    
          });
    
    }
</script>
<script>
    let sub_total;
    let discount_amount;
    let payable_amount;
    
    function discount_cal() {
    
       sub_total = parseInt($("#total_amount_id").val());
       discount_amount = parseInt($("#discount_amount").val()) || 0;
       payable_amount = 0;
    
       if (sub_total > 0) {
          payable_amount = sub_total - discount_amount;
          $("#payable").val(payable_amount);
       }
    
    }
    
    function makerowvisible() {
    
       var nextrownumber = $("#showrowid").val();
       $("#trid" + Number(nextrownumber)).show();
       $("#showrowid").val(Number(nextrownumber) + 1);
       $("#discount_amount").val('');
    }
</script>
<script type="text/javascript">
    $(document).ready(function() {
    
       $("#discount_check").click(function() {
    
          if ($("#discount_check").is(":checked")) {
             //show the hidden div
             $("#discount_tr").show();
             $("#permit_tr").show();
             $("#discount_by").show();
             $("#discount_option").show();
    
          } else {
             //otherwise, hide it
             $("#discount_tr").hide();
             $("#permit_tr").hide();
             $("#discount_by").hide();
             $("#discount_option").hide();
          }
       });
    
    });
</script>
<script>
    function load_course(course_category_id, row_id) {
    
       $('#lecture_id_' + row_id).find('option').remove().end().append("<option value=''>Select Lecture</option>");
       $('#course_id_' + row_id).find('option').remove().end().append("<option value=''>Select Course</option>");
    
       $.post("<?php echo base_url() . "admin/get_course_from_category/"; ?>" + course_category_id, {
             'nothing': 'nothing'
          },
          function(data2) {
             var data = JSON.parse(data2);
             $.each(data, function(i, item) {
    
                $("#course_id_" + row_id).append($('<option>', {
                   value: this.id,
                   text: this.course_title,
                }));
             });
          });
    
    }
    
    function load_lectures(course_id, row_id) {
    
       load_amount_from_course(course_id, row_id)
    
       $.post("<?php echo base_url() . "admin/get_lecture_from_course_category/"; ?>" + course_id, {
             'nothing': 'nothing'
          },
          function(data2) {
             var data = JSON.parse(data2);
             $.each(data, function(i, item) {
    
                $("#lecture_id_" + row_id).append($('<option>', {
                   value: this.id,
                   text: this.title,
                }));
             });
          });
    }
</script>
<script>
    function get_student_id_from_roll (){
        
        var student_rollnumber = $("#student_roll").val();
        
        
        
        if(student_rollnumber.length > 4) { 
            
            $.post("<?php echo base_url() . "admin/get_student_id_from_roll/"; ?>", {
                student_rollnumber: student_rollnumber },
                function(data2) {
                var data = JSON.parse(data2);
                
                $("#student_id").val(data.student_id); 
                $("#student_name").html(data.student_name); 
                $("#student_phone").html(data.student_phone); 
                $("#student_photo").attr("src", base_url + data.student_photo); 
             });
            
        }
        
    }
</script>
