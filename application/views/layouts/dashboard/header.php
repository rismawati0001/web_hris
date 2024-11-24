<div class="block-header">
    <div class="row">
        <div class="col-lg-7 col-md-6 col-sm-12">
            <h2><?= isset($headerTitle) ? $headerTitle : '';?></h2>
            <p></p>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><i class="<?= $iconPathHeader; ?>"></i> <?= $pathHeader; ?></li>
            </ul>
            <button class="btn btn-primary btn-icon mobile_menu" type="button"><i class="zmdi zmdi-sort-amount-desc"></i></button>
        </div>
        <div class="col-lg-5 col-md-6 col-sm-12">   
        <div class="float-right">
                <div class="chat-about">
                    
                    <div class="chat-with"><small>User ID : </small><strong id="usrLogin"><?= $this->session->userdata('logged_user_id');?> </strong> &nbsp;| &nbsp;<a href="<?= base_url();?>signout">SignOut</a></div>
                    <div class="chat-num-messages"><small>Last Login: <?= $this->session->userdata('logged_last_login') ;?></small></div>
                    
                    <?php
                    $flashmessageexp = $this->session->userdata('expired_pass_in');
                    if (isset($flashmessageexp)) {
                    ?>
                    <div class="chat-num-messages"><i><small style="color: red;">Expired Password In : <?= $this->session->userdata('expired_pass_in');?> Days</small></i></div>
                    <?php } ?>
                
                </div>
        </div>             
        </div>
    </div>
</div>