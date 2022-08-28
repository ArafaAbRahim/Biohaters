<style>
    .message {
        background-color: white;
        border-radius: 6px;
        padding: 2px 10px;
    }

    p {
        font-size: 18px;
    }

    .office-message {
        background-color: #bae3d3;
        border-radius: 6px;
        padding: 2px 10px;
        
    }

    .time {
        background-color: #dae3de;
        border-radius: 6px;
        padding: 2px 10px;
        margin: 20px 450px;
    }
</style>

<input type="hidden" name="student_id" value="<?= $student_id; ?>">

<?php foreach ($message_list as $value) { ?>

    <div class="col-md-12">
        <div class="time">
            <center>
                August 27, 22
            </center>
        </div>
    </div>

    <?php if (strlen($value->replay_user_id) > 0) { ?>
        <?php if ($value->message_text) { ?>
            <div class="col-md-12">
                <div class="col-md-6">
                    <div class="box-header with-border">
                        <h5 class="box-title"><?= $value->student_name; ?></h5>
                        <div class="box-tools pull-right">
                            <i class="fa fa-clock-o"></i> <?php date('h:i', strtotime($value->message_time)); ?>
                        </div>
                    </div>

                    <div class="message">
                        <p><?= $value->message_text ?></p>
                    </div>
                </div>
            </div>
        <?php } ?>
    <?php } ?>

    <?php if (strlen($value->replay_user_id) > 0) { ?>
        <?php if ($value->office_message) { ?>
            <div class="col-md-12">
                <div class="col-md-6"></div>
                <div class="col-md-6">
                    <div class="box-header with-border">
                        <h3 class="box-title"><?= $value->firstname . ' ' . $value->lastname; ?></h3>
                        <div class="box-tools pull-right">
                            <i class="fa fa-clock-o"></i> <?php date('d M Y', strtotime($value->message_time)); ?> 9.15 am
                        </div>
                    </div>

                    <div class="office-message">
                        <p><?= $value->office_message ?></p>
                    </div>
                </div>
            </div>
        <?php } ?>
    <?php } ?>

<?php } ?>