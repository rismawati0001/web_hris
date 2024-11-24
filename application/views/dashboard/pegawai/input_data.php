<!-- Main Content -->
<section class="content">
    <?php $this->load->view($headerView); ?>
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="card">
                    <!-- <div class="header">
                        <h2><strong>Masked</strong> Input</h2>
                        <ul class="header-dropdown">
                            <li class="dropdown"> <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="zmdi zmdi-more"></i> </a>
                                <ul class="dropdown-menu dropdown-menu-right slideUp">
                                    <li><a href="javascript:void(0);">Edit</a></li>
                                    <li><a href="javascript:void(0);">Delete</a></li>
                                    <li><a href="javascript:void(0);">Report</a></li>
                                </ul>
                            </li>
                            <li class="remove">
                                <a role="button" class="boxs-close"><i class="zmdi zmdi-close"></i></a>
                            </li>
                        </ul>
                    </div> -->
                    <div class="body">
                        <!-- <p>Taken from <a href="https://github.com/RobinHerbots/jquery.inputmask" target="_blank">github.com/RobinHerbots/jquery.inputmask</a></p> -->
                        <div class="row clearfix">
                            <div class="col-lg-4 col-md-6">
                                <label>Nama Pegawai</label>
                                <div class="input-group masked-input">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="zmdi zmdi-calendar"></i></span>
                                    </div>
                                    <input type="text" class="form-control" placeholder="">
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <label>Email</label>
                                <div class="input-group masked-input mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="zmdi zmdi-email"></i></span>
                                    </div>
                                    <input type="text" class="form-control" placeholder="">
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <label>Password</label>
                                <div class="input-group masked-input mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="zmdi zmdi-time"></i></span>
                                    </div>
                                    <input type="password" class="form-control" placeholder="">
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <label>ID Pegawai</label>
                                <div class="input-group masked-input mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="zmdi zmdi-calendar-note"></i></span>
                                    </div>
                                    <input type="text" class="form-control" placeholder="">
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <label>Alamat</label>
                                <div class="input-group masked-input mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="zmdi zmdi-smartphone"></i></span>
                                    </div>
                                    <input type="text" class="form-control" placeholder="">
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <label>No Telp</label>
                                <div class="input-group masked-input mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="zmdi zmdi-phone"></i></span>
                                    </div>
                                    <input type="text" class="form-control" placeholder="">
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <label>Status Karyawan</label>
                                <div class="input-group masked-input mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="zmdi zmdi-money"></i></span>
                                    </div>
                                    <input type="text" class="form-control" placeholder="">
                                </div>
                            </div>                               
                            <div class="col-lg-4 col-md-6">
                                <label>Tanggal Masuk Kerja</label>
                                <div class="input-group masked-input mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="zmdi zmdi-laptop"></i></span>
                                    </div>
                                    <input type="text" class="form-control" placeholder="">
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <label>Divisi</label>
                                <div class="input-group masked-input mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="zmdi zmdi-card"></i></span>
                                    </div>
                                    <input type="text" class="form-control" placeholder="">
                                </div>
                            </div>
                            

                            <div class="col-lg-12 col-md-6">
                                <button class="btn btn-primary" data-toggle="modal" data-target="#modalConfSaveDataPegawai">Submit</button>
                                <button class="btn btn-danger">Reset</button>
                            </div>

                            

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- Modal Confirmation Export Data -->
<div class="modal fade" id="modalConfSaveDataPegawai" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h7 class="modal-title">Simpan Data Pegawai</h7>
      </div>
      <div class="modal-body" style="padding-top:0px" >
        <hr style="border-bottom:0px solid grey;padding-top:0px">
        <span>Anda yakin ingin menyimpan data pegwai ini ?</span>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i> NO</button>
        <button id="btnSubmitDataPegawai" type="button" class="btn btn-primary" data-dismiss="modal"><i class="fa fa-check" aria-hidden="true"></i> YES</button>
      </div>
    </div>
  </div>
</div>