<!DOCTYPE html>
<html data-bs-theme="light" lang="en-US" dir="ltr">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- ===============================================-->
        <!--    Document Title-->
        <!-- ===============================================-->
        <title> <?= $title ?? 'Admin Dashboard' ?> </title>
        <!-- ===============================================-->
        <!--    Favicons-->
        <!-- ===============================================-->
        <link rel="apple-touch-icon" sizes="180x180" href="../assets/img/favicons/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="../assets/img/favicons/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="../assets/img/favicons/favicon-16x16.png">
        <link rel="shortcut icon" type="image/x-icon" href="../assets/img/favicons/favicon.ico">
        <link rel="manifest" href="../assets/img/favicons/manifest.json">
        <meta name="msapplication-TileImage" content="../assets/img/favicons/mstile-150x150.png">
        <meta name="theme-color" content="#ffffff">
        <script src="../assets/js/config.js"></script>
        <script src="../vendors/simplebar/simplebar.min.js"></script>
        <!-- ===============================================-->
        <!--    Stylesheets-->
        <!-- ===============================================-->
        <link href="../vendors/select2/select2.min.css" rel="stylesheet">
        <link href="../vendors/select2-bootstrap-5-theme/select2-bootstrap-5-theme.min.css" rel="stylesheet">
        <link href="../vendors/datatables.net-bs5/dataTables.bootstrap5.min.css" rel="stylesheet">
        <link href="../vendors/prism/prism-okaidia.css" rel="stylesheet">
        <link href="../vendors/prism/prism-okaidia.css" rel="stylesheet">
        <link href="../vendors/leaflet/leaflet.css" rel="stylesheet">
        <link href="../vendors/leaflet.markercluster/MarkerCluster.css" rel="stylesheet">
        <link href="../vendors/leaflet.markercluster/MarkerCluster.Default.css" rel="stylesheet">
        <link href="../vendors/flatpickr/flatpickr.min.css" rel="stylesheet">
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,500,600,700%7cPoppins:300,400,500,600,700,800,900&amp;display=swap" rel="stylesheet">
        <link href="../vendors/simplebar/simplebar.min.css" rel="stylesheet">
        <link href="../assets/css/theme-rtl.min.css" rel="stylesheet" id="style-rtl">
        <link href="../assets/css/theme.min.css" rel="stylesheet" id="style-default">
        <link href="../assets/css/user-rtl.min.css" rel="stylesheet" id="user-style-rtl">
        <link href="../assets/css/user.min.css" rel="stylesheet" id="user-style-default">
          <script src="../vendors/jquery/jquery.min.js"> </script>
        <script>
            var isRTL = JSON.parse(localStorage.getItem('isRTL'));
            if (isRTL) {
                var linkDefault = document.getElementById('style-default');
                var userLinkDefault = document.getElementById('user-style-default');
                linkDefault.setAttribute('disabled', true);
                userLinkDefault.setAttribute('disabled', true);
                document.querySelector('html').setAttribute('dir', 'rtl');
            } else {
                var linkRTL = document.getElementById('style-rtl');
                var userLinkRTL = document.getElementById('user-style-rtl');
                linkRTL.setAttribute('disabled', true);
                userLinkRTL.setAttribute('disabled', true);
            }
        </script>
    </head>


  <body>
    <!-- ===============================================--><!--    Main Content--><!-- ===============================================-->
    <main class="main" id="top">
      <div class="container" data-layout="container">

        <script>
          var isFluid = JSON.parse(localStorage.getItem('isFluid'));
          if (isFluid) {
            var container = document.querySelector('[data-layout]');
            container.classList.remove('container');
            container.classList.add('container-fluid');
          }
        </script>


        <!-- NAV 1  -->
        <?php include __DIR__ . '/partials/_nav_1.php'; ?>

        <!-- NAV 2  -->
        <?php include __DIR__ . '/partials/_nav_2.php'; ?>

        <!-- NAV 3  -->
        <?php include __DIR__ . '/partials/_nav_3.php'; ?>

        
        <div class="content">

          <!-- CONTENT NAV 1  -->
          <?php include __DIR__ . '/partials/_content_nav_1.php'; ?>

          <!-- CONTENT NAV 2  -->
          <?php include __DIR__ . '/partials/_content_nav_2.php'; ?>

          <script>
            var navbarPosition = localStorage.getItem('navbarPosition');
            var navbarVertical = document.querySelector('.navbar-vertical');
            var navbarTopVertical = document.querySelector('.content .navbar-top');
            var navbarTop = document.querySelector('[data-layout] .navbar-top:not([data-double-top-nav');
            var navbarDoubleTop = document.querySelector('[data-double-top-nav]');
            var navbarTopCombo = document.querySelector('.content [data-navbar-top="combo"]');

            if (localStorage.getItem('navbarPosition') === 'double-top') {
              document.documentElement.classList.toggle('double-top-nav-layout');
            }

            if (navbarPosition === 'top') {
              navbarTop.removeAttribute('style');
              navbarTopVertical.remove(navbarTopVertical);
              navbarVertical.remove(navbarVertical);
              navbarTopCombo.remove(navbarTopCombo);
              navbarDoubleTop.remove(navbarDoubleTop);
            } else if (navbarPosition === 'combo') {
              navbarVertical.removeAttribute('style');
              navbarTopCombo.removeAttribute('style');
              navbarTop.remove(navbarTop);
              navbarTopVertical.remove(navbarTopVertical);
              navbarDoubleTop.remove(navbarDoubleTop);
            } else if (navbarPosition === 'double-top') {
              navbarDoubleTop.removeAttribute('style');
              navbarTopVertical.remove(navbarTopVertical);
              navbarVertical.remove(navbarVertical);
              navbarTop.remove(navbarTop);
              navbarTopCombo.remove(navbarTopCombo);
            } else {
              navbarVertical.removeAttribute('style');
              navbarTopVertical.removeAttribute('style');
              navbarTop.remove(navbarTop);
              navbarDoubleTop.remove(navbarDoubleTop);
              navbarTopCombo.remove(navbarTopCombo);
            }
          </script>


          <?php include $content; ?>

        
          <!-- FOOTER  -->
          <?php include __DIR__ . '/partials/_footer.php'; ?>


        </div>

        <!-- AUTH MODAL RANDOM FOR SESSION EXPIRE  -->
        <?php include __DIR__ . '/partials/_session_auth_modal.php'; ?>

        <!-- CALENDER MODALS  -->
        <?php include __DIR__ . '/partials/_calender_modals.php'; ?>




      </div> 
    </main><!-- ===============================================--><!--    End of Main Content--><!-- ===============================================-->

    <!-- OFF CANVAS  -->
    <?php include __DIR__ . '/partials/_offcanvas.php'; ?>

    <!-- ===============================================--><!--    JavaScripts--><!-- ===============================================-->
        <script src="../vendors/popper/popper.min.js"></script>
        <script src="../vendors/bootstrap/bootstrap.min.js"></script>
        <script src="../vendors/anchorjs/anchor.min.js"></script>
        <script src="../vendors/is/is.min.js"></script>
      
        <script src="../vendors/prism/prism.js"></script>
        <script src="../vendors/select2/select2.min.js"> </script>
        <script src="../vendors/select2/select2.full.min.js"> </script>
        <script src="../vendors/datatables.net/dataTables.min.js"></script>
        <script src="../vendors/datatables.net-bs5/dataTables.bootstrap5.min.js"> </script>
        <script src="../vendors/datatables.net-fixedcolumns/dataTables.fixedColumns.min.js"> </script>
        <script src="../vendors/prism/prism.js"></script>
        <script src="../vendors/chart/chart.umd.js"></script>
        <script src="../vendors/leaflet/leaflet.js"></script>
        <script src="../vendors/leaflet.markercluster/leaflet.markercluster.js"></script>
        <script src="../vendors/leaflet.tilelayer.colorfilter/leaflet-tilelayer-colorfilter.min.js"></script>
        <script src="../vendors/countup/countUp.umd.js"></script>
        <script src="../vendors/echarts/echarts.min.js"></script>
        <script src="../vendors/fullcalendar/index.global.min.js"></script>
        <script src="../vendors/flatpickr/flatpickr.min.js"></script>
        <script src="../vendors/dayjs/dayjs.min.js"></script>
        <script src="../vendors/fontawesome/all.min.js"></script>
        <script src="../vendors/lodash/lodash.min.js"></script>
        <script src="../vendors/list.js/list.min.js"></script>
        <script src="../vendors/bootstrap/pages-js/holidays-export.js"></script> 
        <script src="../vendors/bootstrap/xlsx.full.min.js"></script> 
        <script src="../assets/js/theme.js"></script>
  </body>

  

</html>