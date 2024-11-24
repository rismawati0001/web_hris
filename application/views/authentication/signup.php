<?php
    $attributes = array(
        'enctype'       => 'multipart/form-data',
        'name'          => 'signup_form', 
        'id'            => 'myform', 
        'autocomplete'  => 'off', 
        'class'         => 'card auth_form',
        'style'         => 'border:0px solid red; margin-top: 30px'
    );
    echo form_open('signup', $attributes);
    ?>
    <div class="header">
        <img class="logo" src="<?php echo base_url() ?>assets/template/images/logo.svg" alt="">
        <h5><?= $h5_title; ?></h5>
    </div>
    <div class="body">

        <?php
        $flashmessagesuccess = $this->session->flashdata('messageinsertuser');
        $flashmessagefailed = $this->session->flashdata('messageinsertuserfailed');
        if (isset($flashmessagesuccess)) {
        ?>
            <div class="alert alert-success" role="alert">
                <strong>Success </strong> <?php echo !empty($flashmessagesuccess) ? $flashmessagesuccess : ''; ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true"><i class="zmdi zmdi-close"></i></span>
                </button>
            </div>
        <?php } 
            if (isset($flashmessagefailed)){
        ?>
            <div class="alert alert-danger" role="alert">
                <strong>Failed </strong> <?php echo !empty($flashmessagefailed) ? $flashmessagefailed : ''; ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true"><i class="zmdi zmdi-close"></i></span>
                </button>
            </div>
        <?php } ?>

        <div class="row clearfix">
            <div class="col-sm-6">
                <div class="input-group mb-3">
                    <div class="input-group-append">
                        <span class="input-group-text"><i class="zmdi zmdi-pin-account"></i></span>
                    </div>
                    <input type="text" class="form-control" placeholder="Full Name" name="fullname" tabindex="1" value="<?php echo set_value('v_fullname', isset($default['v_fullname']) ? $default['v_fullname'] : ''); ?>" autofocus>
                    <?php echo form_error('fullname', '<div class="input-group" style="height:20px"><label id="name-error" class="error" for="name" style="color: red;">', '</label></div>'); ?>

                </div>
            </div>
            <div class="col-sm-6">
                <div class="input-group mb-3">
                    <div class="input-group-append">
                        <span class="input-group-text"><i class="zmdi zmdi-account-box-mail"></i></span>
                    </div>
                    <input type="text" autocomplete="unInput" class="form-control" placeholder="User ID" name="userid" tabindex="4" value="<?php echo set_value('v_userid', isset($default['v_userid']) ? $default['v_userid'] : ''); ?>">


                    <?php echo form_error('userid', '<div class="input-group" style="height:20px"><label id="name-error" class="error" for="name" style="color: red;">', '</label></div>'); ?>

                </div>
            </div>

            <div class="col-sm-6">
                <div class="input-group mb-3">
                    <div class="input-group-append">
                        <span class="input-group-text"><i class="zmdi zmdi-email"></i></span>
                    </div>
                    <input type="text" autocomplete="off" class="form-control" placeholder="Email Name" name="email" id="txtusername" tabindex="5" value="<?php echo set_value('v_email', isset($default['v_email']) ? $default['v_email'] : ''); ?>">
                    <?php echo form_error('email', '<div class="input-group" style="height:20px"><label id="name-error" class="error" for="name" style="color: red;">', '</label></div>'); ?>

                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group-append">
                    <div class="radio inlineblock m-r-20">
                        <input type="radio" name="gender" id="male" class="with-gap" value="Male" tabindex="2"
                            <?php if (isset($default['v_gender']) && $default['v_gender']=='male') {  ?>
                                checked
                            <?php } ?>
                        >
                        <label for="male">Male</label>
                    </div>
                    <div class="radio inlineblock">
                        <input type="radio" name="gender" id="Female" class="with-gap" value="Female" tabindex="3" 
                            <?php if (isset($default['v_gender']) && $default['v_gender']=='female') {  ?>
                                checked
                            <?php } ?>
                        >
                        <label for="Female">Female</label>
                    </div>
                    <label id="name-error" class="error" for="name" style="color: red;"><?php if (!isset($default['v_gender'])) {  ?>
                            <?php echo form_error('gender'); ?>
                        <?php } ?></label>

                </div>
            </div>
            <div class="col-sm-12">
                <div class="input-group mb-3">
                    <div class="input-group-append">
                        <span class="input-group-text"><i class="zmdi zmdi-face"></i></span>
                    </div>
                    <input type="file" name="file_avatar" class="form-control" accept="image/*">
                    <div class="col-sm-12" style="font-size: 11px;font-style: italic;padding:0px">Optional - Only image file are allowed and max file size : 5 MB </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="input-group mb-3">
                    <div class="input-group-append">
                        <span class="input-group-text"><i class="zmdi zmdi-lock"></i></span>
                    </div>

                    <input class="form-control" type="password" placeholder="Password" name="password" id="v_pass" tabindex="6" value="<?php echo set_value('v_password', isset($default['v_password']) ? $default['v_password'] : ''); ?>">
                    <span toggle="#v_pass" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                    <?php echo form_error('password', '<div class="col-sm-12" style="padding:0px" ><label id="name-error" class="error" for="name" style="color: red;">', '</label></div>'); ?>
                    <div class="col-sm-12" style="font-size: 11px;font-style: italic;padding:0px">Passwords must consist of uppercase, lowercase, symbol and numbers with minimal 8 digits</div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="input-group mb-3">
                    <div class="input-group-append">
                        <span class="input-group-text"><i class="zmdi zmdi-lock-outline"></i></span>
                    </div>
                    <input id="v_conf_pass" type="password" class="form-control" placeholder="Confirm Password" name="conf_password" tabindex="7" value="<?php echo set_value('v_conf_password', isset($default['v_conf_password']) ? $default['v_conf_password'] : ''); ?>">
                    <span toggle="#v_conf_pass" class="fa fa-fw fa-eye field-icon-conf toggle-password"></span>
                    <?php echo form_error('conf_password', '<div class="input-group" style="height:20px"><label id="name-error" class="error" for="name" style="color: red;">', '</label></div>'); ?>
                </div>
            </div>


        </div>

        <input type="hidden" name="v_submit_login" id="submit_login_temp" />
        <input type="submit" name="submit_login" id="submit_login" style="display: none;" />
        <a href="javascript: $('#submit_login_temp').val('posting'); $('#myform').submit();" class="btn btn-primary btn-block waves-effect waves-light">SIGN UP</a>
        Already have an account click on <a href="<?php echo base_url(); ?>">Sign In</a>
    </div>
    </form>