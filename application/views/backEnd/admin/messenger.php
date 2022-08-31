<style>
    input {
        background-color: #bae3d3;
        width: 90%;
        height: 30px;
        border-radius: 6px;
        padding: 10px 10px;
        border: none;
        margin: 5px 15px;
    }


    table:hover {
        background-color: #f2f3f5;
        width: 100%;
    }

    table:active {
        background-color: #bae3d3;
        width: 100%;
    }
</style>

<section class="content">
    <div class="row">
        <div class="col-md-12">

            <form action="<?php echo base_url("admin/messenger/add"); ?>" method="post" enctype="multipart/form-data">
                <div class="col-md-4">
                    <div class="box box-success ">
                        <div class="box-header with-border">
                            <h3 class="box-title"> Student List </h3>
                        </div>


                        <div class="box-body ">
                            <?php foreach ($student_list as $value) { ?>


                                <table style="margin-top: 10px;">

                                    <tr onclick="get_messages_list('<?= $value->id; ?>')">
                                        <td>
                                            <img <?php if ($value->student_photo) { ?> src="<?php echo base_url($value->student_photo); ?>" <?php } else { ?> src="<?= base_url(); ?>assets/Profile-Avatar-PNG.png" <?php } ?> class="user-image" style="height: 60px; width: 60px; border-radius:50px;">
                                        </td>
                                        <td> <span style="padding: 0 20px; font-size: 16px; font-weight:bold;"> <?= $value->student_name ?>
                                            </span> <br>
                                            <small style="margin-left: 20px;">Roll : <?= $value->student_roll ?></small>
                                        </td>


                                    </tr>

                                </table>


                            <?php } ?>
                        </div>
                    </div>
                </div>

                <div class="col-md-8">

                    <div class="box box-success">
                        <div class="box-header with-border">
                            <h3 class="box-title"> Messages </h3>
                        </div>

                        <div class="box-body" style="background-color: #d3f0e1;" id="set_new_messages_list">

                        </div>

                        <div class="box-footer">
                            <input type="text" name="office_message" placeholder="Write a message...">
                            <button type="submit" class="btn btn-sm bg-green"><i class="fa fa-paper-plane"></i></button>
                        </div>

                    </div>

                </div>

            </form>

        </div>

</section>

<script>
    function get_messages_list(student_id) {


        $.post("<?php echo base_url() . "admin/get_student_wise_message_list/"; ?>", {
                student_id: student_id
            },
            function(data2) {

                $("#set_new_messages_list").html(data2);
            });

    }
</script>