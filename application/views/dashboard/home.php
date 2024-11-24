<!-- Main Content -->
<section class="content">
    <?php $this->load->view($headerView); ?>
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-3 col-md-6 col-sm-12">
                <div class="card widget_2 big_icon active_term">
                    <div class="body" style="border: 1px solid #DCDCDC;">
                        <h6>ALL TERMINAL</h6>
                        <h2><a href="<?= base_url(); ?>event_crm_status_terminal"><?= number_format(100); ?></a></h2>
                        <div class="row">
                            <div class="col-sm">
                            <a href="<?= base_url(); ?>event_crm_status_terminal_active"><small> Active : <?= 10; ?> </small></a>
                            </div>
                            <div class="col-sm" style="text-align:right">
                            <a href="<?= base_url(); ?>event_crm_status_terminal_non_active"><small> NonActive : <?= 10; ?> </small></a>
                            </div>
                        </div>
                        <a href="<?= base_url(); ?>atm/inservice"><small> Last Register 10 ATM at 2024-10-12 13:00:56</small></a>
                        <div class="progress" style="border: 1px solid #DCDCDC;">
                            <div class="progress-bar l-green" role="progressbar" aria-valuenow="45"
                                aria-valuemin="0" aria-valuemax="100" style="width: <?= 10; ?>;"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12">
                <div class="card widget_2 big_icon in_service">
                    <div class="body" style="border: 1px solid #DCDCDC;">
                        <h6>IN SERVICE</h6>
                        <h2><?= 0; ?> </h2>
                        <a href="<?= base_url(); ?>event_crm_status_terminal_in_service"><small><?= number_format(0); ?> details</small></a>
                        <div class="progress" style="border: 1px solid #DCDCDC;">
                            <div class="progress-bar l-blue" role="progressbar" aria-valuenow="38" aria-valuemin="0"
                                aria-valuemax="100" style="width: <?= 0; ?>;"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-md-6 col-sm-12">
                <div class="card widget_2 big_icon offline">
                    <div class="body" style="border: 1px solid #DCDCDC;">
                        <h6>OFFLINE</h6>
                        <h2><?= 0; ?></h2>
                        <a href="<?= base_url(); ?>event_crm_status_terminal_off_line"><small><?= number_format(0); ?> details</small></a>
                        <div class="progress" style="border: 1px solid #DCDCDC;">
                            <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="38" aria-valuemin="0"
                                aria-valuemax="100" style="width: <?= 0; ?>;"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-md-6 col-sm-12">
                <div class="card widget_2 big_icon closed">
                    <div class="body" style="border: 1px solid #DCDCDC;">
                        <h6>CLOSED</h6>
                        <h2><?= 0; ?></h2>
                        <a href="<?= base_url(); ?>event_crm_status_terminal_closed"><small><?= number_format(0); ?> details</small></a>
                        <div class="progress" style="border: 1px solid #DCDCDC;">
                            <div class="progress-bar l-amber" role="progressbar" aria-valuenow="38" aria-valuemin="0"
                                aria-valuemax="100" style="width: <?= 0; ?>;"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-md-6 col-sm-12">
                <div class="card widget_2 big_icon supervisor">
                    <div class="body" style="border: 1px solid #DCDCDC;">
                        <h6>SUPERVISOR</h6>
                        <h2><?= 0; ?></h2>
                        <a href="<?= base_url(); ?>event_crm_status_terminal_supervisor"><small><?= number_format(0); ?> details</small></a>
                        <div class="progress" style="border: 1px solid #DCDCDC;">
                            <div class="progress-bar l-amber" role="progressbar" aria-valuenow="38" aria-valuemin="0"
                                aria-valuemax="100" style="width: <?= 0; ?>;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row clearfix">
            <div class="col-lg-12">
                <div class="card">
                    <!-- <div class="header">
                        <h2><strong><i class="zmdi zmdi-chart"></i> Sales</strong> Report</h2>

                    </div> -->
                    <div class="body mb-2" style="border: 1px solid #DCDCDC;">
                        <div class="row clearfix">
                            <div class="col-lg-2 col-md-6 col-sm-6 big_icon faulty">
                                <div class="state_w1 mb-1 mt-1">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h5><?= 0; ?></h5>
                                            <a href="<?= base_url(); ?>atm/inservice"><span><i class="zmdi zmdi-balance"></i> FAULTY</span></a>
                                        </div>
                                    </div>
                                    <div class="progress" style="border: 1px solid #DCDCDC;">
                                        <div class="progress-bar l-amber" role="progressbar" aria-valuenow="38" aria-valuemin="0"
                                            aria-valuemax="100" style="width: 20%;">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-6 col-sm-6 big_icon tran_idle">
                                <div class="state_w1 mb-1 mt-1">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h5>-</h5>
                                            <a href="<?= base_url(); ?>atm/inservice"><span><i class="zmdi zmdi-turning-sign"></i> TRAN IDLE</span></a>
                                        </div>
                                    </div>
                                    <div class="progress" style="border: 1px solid #DCDCDC;">
                                        <div class="progress-bar l-amber" role="progressbar" aria-valuenow="38" aria-valuemin="0"
                                            aria-valuemax="100" style="width: 20%;">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-6 col-sm-6 big_icon dispense">
                                <div class="state_w1 mb-1 mt-1">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h5>-</h5>
                                            <a href="<?= base_url(); ?>atm/inservice"><span><i class="zmdi zmdi-turning-sign"></i> ERROR DISPENSE</span></a>
                                        </div>
                                    </div>
                                    <div class="progress" style="border: 1px solid #DCDCDC;">
                                        <div class="progress-bar l-amber" role="progressbar" aria-valuenow="38" aria-valuemin="0"
                                            aria-valuemax="100" style="width: 20%;">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-6 col-sm-6 big_icon low_balance">
                                <div class="state_w1 mb-1 mt-1">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h5>-</h5>
                                            <a href="<?= base_url(); ?>atm/inservice"><span><i class="zmdi zmdi-turning-sign"></i> LOW BALANCE</span></a>
                                        </div>
                                    </div>
                                    <div class="progress" style="border: 1px solid #DCDCDC;">
                                        <div class="progress-bar l-amber" role="progressbar" aria-valuenow="38" aria-valuemin="0"
                                            aria-valuemax="100" style="width: 20%;">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-6 col-sm-6 big_icon low_balance">
                                <div class="state_w1 mb-1 mt-1">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h5>-</h5>
                                            <a href="<?= base_url(); ?>atm/inservice"><span><i class="zmdi zmdi-turning-sign"></i> FULL CAPACITY</span></a>
                                        </div>
                                    </div>
                                    <div class="progress" style="border: 1px solid #DCDCDC;">
                                        <div class="progress-bar l-amber" role="progressbar" aria-valuenow="38" aria-valuemin="0"
                                            aria-valuemax="100" style="width: 20%;">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-6 col-sm-6 big_icon card_retain">
                                <div class="state_w1 mb-1 mt-1">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h5><?= 0; ?></h5>
                                            <a href="<?= base_url(); ?>atm/inservice"><span><i class="zmdi zmdi-turning-sign"></i> CARD RETAIN</span></a>
                                        </div>
                                    </div>
                                    <div class="progress" style="border: 1px solid #DCDCDC;">
                                        <div class="progress-bar l-amber" role="progressbar" aria-valuenow="38" aria-valuemin="0"
                                            aria-valuemax="100" style="width: 20%;">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-12">
                <div class="card">
                    <div class="header">
                        <h2><strong>TERMINAL</strong> STATUS</h2>
                    </div>
                    <div class="body" style="border: 1px solid #DCDCDC;">
                        <div id="chart-pie" class="c3_chart"></div>
                    </div>
                </div>                
            </div>
            <div class="col-lg-6 col-md-12">
                <div class="card">
                    <div class="header">
                        <h2><strong>TOP 6</strong> TRANSACTIONS</h2>
                    </div>
                    <div class="body" style="border: 1px solid #DCDCDC;">
                        <div id="chart-bar" class="c3_chart"></div>
                    </div>
                </div>                
            </div>
            <!-- <div class="col-lg-6 col-md-12">
                <div class="card">
                    <div class="header">
                        <h2><strong>Donut</strong> Chart</h2>
                    </div>
                    <div class="body" style="border: 1px solid #DCDCDC;">
                        <div id="chart-donut" class="c3_chart"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-12">
                <div class="card">
                    <div class="header">
                        <h2><strong>Employment</strong> Growth</h2>
                    </div>
                    <div class="body" style="border: 1px solid #DCDCDC;">
                        <div id="chart-employment" class="c3_chart"></div>
                    </div>
                </div>
            </div> -->
        </div>
        
    </div>
</section>