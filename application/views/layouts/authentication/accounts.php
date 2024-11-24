<!doctype html>
<html class="no-js " lang="en">

<!-- Mirrored from wrraptheme.com/templates/aero/html/sign-in.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 15 Feb 2021 04:32:15 GMT -->
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<meta name="description" content="Responsive Bootstrap 4 and web Application ui kit.">

<title>.:: HRIS ::. <?= $title; ?></title>
<!-- Favicon-->
<!-- <link rel="icon" href="favicon.ico" type="image/x-icon"> -->
<link rel="icon" href="<?= base_url() ?>assets/template/images/logo-title.png" type="image/x-icon">
<!-- Custom Css -->
<link rel="stylesheet" href="<?= base_url() ?>assets/template/plugins/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="<?= base_url() ?>assets/template/css/style.min.css">   
<link rel="stylesheet" href="<?= base_url() ?>assets/template/font-awesome/css/fontawesome.min.css">
<link rel="stylesheet" href="<?= base_url() ?>assets/template/font-awesome/css/solid.css">
<link rel="stylesheet" href="<?= base_url() ?>assets/template/css/style_pass.css">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:ital,wght@0,100..700;1,100..700&display=swap" rel="stylesheet">
<style>
    body {
        font-family: "Josefin Sans", sans-serif;
        font-optical-sizing: auto;
        font-weight: <weight>;
        font-style: normal;

        background-image: url(https://static.pexels.com/photos/512694/pexels-photo-512694.jpeg);
        background-position: center center;
        background-repeat: no-repeat;
        background-attachment: fixed;
        background-size: cover;
        background-color: #464646;
    }
</style> 

</head>

<body class="theme-blush">

    <div class="authentication">
        <div class="container">
            <div class="row h-100 justify-content-center align-items-center">
                <div class="<?= $classBox; ?>">
                    <?php $this->load->view($content_view); ?>
                    <!-- <div class="copyright text-center">
                        &copy;
                        <script>document.write(new Date().getFullYear())</script>,
                        <span>Designed by <a href="#" target="_blank">IT Developer</a></span>
                    </div> -->
                </div>
                
            </div>
        </div>
    </div>

    <script type="text/javascript">
        var baseURL = '<?= base_url(); ?>';
    </script>

    <!-- Jquery Core Js -->
    <script src="assets/template/bundles/libscripts.bundle.js"></script>
    <script src="assets/template/bundles/vendorscripts.bundle.js"></script> <!-- Lib Scripts Plugin Js -->

    <?php if ($content_view == "authentication/signin") { ?>
        <script src="<?= base_url() ?>assets/functions/accounts/signin.js"></script>
    <?php } ?>

    <?php if ($content_view == "authentication/signup") { ?>
        <script src="<?= base_url() ?>assets/functions/accounts/signup.js"></script>
    <?php } ?>

    <?php if ($content_view == "authentication/reset_password") { ?>
        <script src="<?= base_url() ?>assets/functions/accounts/reset_password.js"></script>
    <?php } ?>

</body>

<!-- Mirrored from wrraptheme.com/templates/aero/html/sign-in.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 15 Feb 2021 04:32:16 GMT -->
</html>