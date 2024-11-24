<aside id="leftsidebar" class="sidebar">
    <div class="navbar-brand">
        <button class="btn-menu ls-toggle-btn" type="button"><i class="zmdi zmdi-menu"></i></button>
        <a href="index.html"><img src="<?= base_url() ?>assets/template/images/logo.svg" height="30" width="30" alt="HRIS"><span class="m-l-10">HRIS</span></a>
    </div>
    <div class="menu">
        <ul class="list">
            <li>
                <div class="user-info">
                    <a class="image" href="profile.html"><img src="<?= base_url().$this->session->userdata('logged_picture_profile'); ?>" alt="User"></a>
                    <div class="detail">
                        <h4><?= $this->session->userdata('logged_full_name'); ?></h4>
                        <small><?= $this->session->userdata('logged_role_name'); ?></small>
                    </div>
                </div>
            </li>

            <?php
            $beforeIdMenu = 1;
            $beforeCategory = '';
            foreach ($this->session->userdata('listAccessMenu') as $accessMenu) {

                // $arrMenu = explode(" - ",$accessMenu);
                switch (true) {
                    case $accessMenu[2] == 1:
                        echo '<li title="'.$accessMenu[1].'" class="active open"><a href="' . base_url() . $accessMenu[5] . '"><i class="'.$accessMenu[4].'"></i><span>'.$accessMenu[1].'</span></a></li>';
                        break;
                    case $accessMenu[2] > 1:
                        if($beforeCategory != $accessMenu[0] && $accessMenu[3] != $beforeIdMenu){
                            echo '</ul></li>';
                        }
                        if($accessMenu[3] == 1){
                            echo '<li><a href="javascript:void(0);" class="menu-toggle"><i class="'.$accessMenu[4].'"></i><span>'.$accessMenu[0].'</span></a><ul class="ml-menu">
                                  <li title="'.$accessMenu[1].'"><a href="' . base_url() . $accessMenu[5] . '">'.$accessMenu[1].'</a></li>';
                        }else{
                            // echo '<li><a href="' . base_url() . 'admin_card/generatepin">' . $get_menu_home[1] . '</a></li>';
                            echo '<li title="'.$accessMenu[1].'"><a href="' . base_url() . $accessMenu[5] . '">'.$accessMenu[1].'</a></li>';
                            if($accessMenu[3] == 3 and $accessMenu[2] > 3 and $accessMenu[6] > 3){
                                echo '<hr>';
                            }
                        }
                        $beforeIdMenu = $accessMenu[3];
                        $beforeCategory = $accessMenu[0];
                        break;
                }
            }
            echo '</ul></li>';
            ?>
            <li  title="Sign Out"><a href="<?= base_url();?>signout"><i class="zmdi zmdi-power"></i><span>Sign Out</span></a></li>
        </ul>
    </div>
</aside>
        
        

