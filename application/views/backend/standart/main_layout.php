<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="description" content="<?= get_option('site_description'); ?>">
  <meta name="keywords" content="<?= get_option('keywords'); ?>">
  <meta name="author" content="<?= get_option('author'); ?>">

  <title><?= ($fg = get_user_first_group()) && isset($fg->name) ? $fg->name : 'User' ?> | <?= get_option('site_name'); ?> | <?= isset($template['title']) ? $template['title'] : ''; ?></title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

  <link rel="stylesheet" href="<?= BASE_ASSET; ?>admin-lte/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <link rel="stylesheet" href="<?= BASE_ASSET; ?>admin-lte/dist/css/AdminLTE.css">
  <link rel="stylesheet" href="<?= BASE_ASSET; ?>admin-lte/dist/css/skins/_all-skins.min.css">
  <link rel="stylesheet" href="<?= BASE_ASSET; ?>admin-lte/plugins/iCheck/flat/blue.css">
  <link rel="stylesheet" href="<?= BASE_ASSET; ?>admin-lte/plugins/morris/morris.css">
  <link rel="stylesheet" href="<?= BASE_ASSET; ?>admin-lte/plugins/jvectormap/jquery-jvectormap-1.2.2.css">
  <link rel="stylesheet" href="<?= BASE_ASSET; ?>admin-lte/plugins/datepicker/datepicker3.css">
  <link rel="stylesheet" href="<?= BASE_ASSET; ?>admin-lte/plugins/daterangepicker/daterangepicker.css">
  <link rel="stylesheet" href="<?= BASE_ASSET; ?>admin-lte/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
  <link rel="stylesheet" href="<?= BASE_ASSET; ?>admin-lte/plugins/iCheck/all.css">
  <link rel="stylesheet" href="<?= BASE_ASSET; ?>sweet-alert/sweetalert.css">
  <link rel="stylesheet" href="<?= BASE_ASSET; ?>toastr/build/toastr.css">
  <link rel="stylesheet" href="<?= BASE_ASSET; ?>fancy-box/source/jquery.fancybox.css?v=2.1.5" media="screen" />
  <link rel="stylesheet" href="<?= BASE_ASSET; ?>chosen/chosen.css">
  <link rel="stylesheet" href="<?= BASE_ASSET; ?>css/custom.css?v=<?= VERSION; ?>.<?= is_file(FCPATH.'asset/css/custom.css') ? filemtime(FCPATH.'asset/css/custom.css') : '1'; ?>">
  <link rel="stylesheet" href="<?= BASE_ASSET; ?>datetimepicker/jquery.datetimepicker.css"/>
  <link rel="stylesheet" href="<?= BASE_ASSET; ?>js-scroll/style/jquery.jscrollpane.css" rel="stylesheet" media="all" />
  <link rel="stylesheet" href="<?= BASE_ASSET; ?>flag-icon/css/flag-icon.css" rel="stylesheet" media="all" />
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  
  <!-- Smooth Sidebar & Page Navigation Transition Animations & MetaforaCRM Clean Elegant Style -->
  <style>
    /* MetaforaCRM Clean & Elegant Typography */
    body, h1, h2, h3, h4, h5, h6, .content-header, .box-title, .form-control, .btn, label, table, th, td, .select2, input, textarea, select {
      font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif !important;
    }

    /* Soft modern clean background */
    .content-wrapper, .right-side, body {
      background-color: #F8FAFC !important;
    }

    /* Modern clean & elegant cards */
    .box, .form-card {
      border-radius: 14px !important;
      border: 1px solid #E2E8F0 !important;
      box-shadow: 0 4px 20px -2px rgba(15, 23, 42, 0.05), 0 2px 6px -1px rgba(15, 23, 42, 0.03) !important;
      background: #FFFFFF !important;
    }
    .box-header {
      border-bottom: 1px solid #F1F5F9 !important;
    }

    /* Global Bulletproof Modal Stacking Fix */
    .modal-backdrop { pointer-events: none !important; }
    .modal { pointer-events: auto !important; }
    
    /* Fix Z-Index for Dropdowns inside Modals */
    .chosen-container .chosen-drop { z-index: 9999 !important; }
    .select2-dropdown { z-index: 9999 !important; }
    .xdsoft_datetimepicker { z-index: 9999 !important; }
    .datepicker { z-index: 9999 !important; }
    .sweet-alert { z-index: 99999 !important; }

    /* Page Content Transition Animation */
    .content-wrapper {
      animation: fadeInSlide 0.35s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }
    @keyframes fadeInSlide {
      from { opacity: 0.3; transform: translateY(8px); }
      to { opacity: 1; transform: translateY(0); }
    }

    /* ==========================================================================
       SIDEBAR LAYOUT ALIGNMENT & RESPONSIVENESS (PRESERVES EXACT SKIN-BLACK UI/UX)
       ========================================================================== */
    /* 1. Eliminate top gaps: Header is 50px, so sidebar starts directly below it */
    .main-sidebar, .left-side {
      top: 0 !important;
      padding-top: 50px !important;
    }
    .sidebar {
      padding-top: 0 !important;
      margin-top: 0 !important;
      overflow-y: auto !important;
      -webkit-overflow-scrolling: touch !important;
    }
    .sidebar-menu {
      margin-top: 0 !important;
      padding-top: 0 !important;
      list-style: none;
    }

    /* 2. Menu items layout, typography & flex alignment */
    .sidebar-menu li a {
      transition: all 0.2s ease !important;
      position: relative;
      display: flex !important;
      align-items: center !important;
      padding: 12px 16px !important;
      line-height: 1.4 !important;
      white-space: normal !important;
      font-size: 15.5px !important;
      font-weight: 600 !important;
      color: #dce5ec !important;
      letter-spacing: 0.15px;
    }
    .sidebar-menu > li > a {
      font-size: 15.5px !important;
      font-weight: 600 !important;
      color: #e2e8f0 !important;
    }
    .sidebar-menu > li:hover > a,
    .sidebar-menu > li.active > a,
    .sidebar-menu > li.menu-open > a {
      color: #ffffff !important;
      background-color: rgba(255, 255, 255, 0.08) !important;
      font-weight: 600 !important;
    }
    .sidebar-menu li a > span:not(.pull-right-container) {
      flex: 1 1 auto;
      white-space: normal !important;
      word-break: normal;
      overflow-wrap: break-word;
      line-height: 1.4 !important;
    }
    /* Only style the leading menu icon, not the arrow in pull-right-container */
    .sidebar-menu li a > i.fa,
    .sidebar-menu li a > i.glyphicon {
      width: 24px !important;
      min-width: 24px !important;
      text-align: center !important;
      margin-right: 12px !important;
      font-size: 17px !important;
      flex-shrink: 0;
      color: #b0c4d4 !important;
      transition: color 0.2s ease;
    }
    .sidebar-menu > li:hover > a > i.fa,
    .sidebar-menu > li.active > a > i.fa,
    .sidebar-menu > li.menu-open > a > i.fa {
      color: #ffffff !important;
    }
    .sidebar-menu li a > .pull-right-container {
      margin-left: auto;
      display: flex;
      align-items: center;
      justify-content: center;
      position: absolute;
      right: 14px;
      top: 50%;
      transform: translateY(-50%);
    }
    /* Default state when closed: Point LEFT (<) */
    .sidebar-menu li.treeview > a > .pull-right-container .fa-angle-left,
    .sidebar-menu li.treeview > a > .fa-angle-left {
      font-size: 14px !important;
      color: #94a8ba !important;
      width: auto !important;
      min-width: auto !important;
      margin-right: 0 !important;
      display: inline-block !important;
      -webkit-transition: -webkit-transform 0.3s cubic-bezier(0.25, 0.8, 0.25, 1), color 0.2s ease !important;
      transition: transform 0.3s cubic-bezier(0.25, 0.8, 0.25, 1), color 0.2s ease !important;
      -webkit-transform: rotate(0deg) !important;
      transform: rotate(0deg) !important;
    }
    /* Synchronized open state: Rotate -90deg to point DOWN (v) */
    .sidebar-menu li.treeview.menu-open > a > .pull-right-container .fa-angle-left,
    .sidebar-menu li.treeview.menu-open > a > .fa-angle-left {
      -webkit-transform: rotate(-90deg) !important;
      -ms-transform: rotate(-90deg) !important;
      transform: rotate(-90deg) !important;
      color: #ffffff !important;
    }

    /* 3. Submenu Items & Layout Hierarchy Indentation */
    .sidebar-menu .treeview-menu > li > a {
      padding: 10px 16px 10px 34px !important;
      display: flex !important;
      align-items: center !important;
      line-height: 1.4 !important;
      white-space: normal !important;
      font-size: 14px !important;
      font-weight: 500 !important;
      color: #b8c9d6 !important;
    }
    .sidebar-menu .treeview-menu > li:hover > a,
    .sidebar-menu .treeview-menu > li.active > a {
      color: #ffffff !important;
      font-weight: 600 !important;
      background-color: rgba(255, 255, 255, 0.07) !important;
    }
    .sidebar-menu .treeview-menu > li > a > span:not(.pull-right-container) {
      flex: 1 1 auto;
      white-space: normal !important;
      word-break: normal;
      overflow-wrap: break-word;
    }
    .sidebar-menu .treeview-menu > li > a i.fa,
    .sidebar-menu .treeview-menu > li > a i.glyphicon {
      width: 18px !important;
      min-width: 18px !important;
      font-size: 12px !important;
      margin-right: 10px !important;
      text-align: center !important;
      flex-shrink: 0;
      color: #8da4b6 !important;
    }
    .sidebar-menu .treeview-menu > li.active > a i.fa {
      color: #ffffff !important;
    }

    /* Section Header */
    .sidebar-menu li.header {
      font-size: 12.5px !important;
      font-weight: 700 !important;
      letter-spacing: 0.8px !important;
      text-transform: uppercase !important;
      padding: 14px 16px 6px 16px !important;
      color: #7b94a8 !important;
    }

    /* 4. Smooth sidebar scrollbar */
    .sidebar::-webkit-scrollbar {
      width: 5px;
    }
    .sidebar::-webkit-scrollbar-track {
      background: rgba(0, 0, 0, 0.1);
    }
    .sidebar::-webkit-scrollbar-thumb {
      background: rgba(255, 255, 255, 0.2);
      border-radius: 4px;
    }

    /* 5. Comprehensive Universal Mobile Layout & Responsiveness */
    @media (max-width: 767px) {
      /* Prevent horizontal scroll on mobile across all pages */
      html, body {
        overflow-x: hidden !important;
        max-width: 100vw !important;
      }
      .wrapper, .content-wrapper {
        overflow-x: hidden !important;
        max-width: 100vw !important;
      }
      body.fixed .content-wrapper,
      .fixed .content-wrapper,
      .fixed .right-side {
        padding-top: 50px !important;
      }
      .content {
        padding: 10px 8px 30px 8px !important;
        box-sizing: border-box !important;
      }

      /* Compact fixed header */
      .main-header {
        position: fixed !important;
        top: 0 !important;
        left: 0 !important;
        width: 100% !important;
        height: 50px !important;
        z-index: 1000 !important;
      }
      .main-header .logo {
        width: auto !important;
        height: 50px !important;
        line-height: 50px !important;
        float: left !important;
        padding: 0 6px !important;
        display: flex !important;
        align-items: center !important;
      }
      .main-header .logo .logo-mini {
        display: block !important;
      }
      .main-header .logo .logo-lg {
        display: none !important;
      }
      .main-header .sidebar-toggle {
        padding: 15px 12px !important;
        float: left !important;
      }
      .main-header .navbar {
        margin: 0 !important;
        padding: 0 !important;
        float: none !important;
        height: 50px !important;
      }
      .navbar-custom-menu {
        float: right !important;
      }
      .navbar-custom-menu > .navbar-nav {
        display: flex !important;
        align-items: center !important;
        margin: 0 !important;
        float: right !important;
      }
      .navbar-custom-menu > .navbar-nav > li {
        display: inline-block !important;
        float: none !important;
      }
      .navbar-custom-menu > .navbar-nav > li > a {
        padding: 15px 8px !important;
      }
      .navbar-custom-menu .dropdown-menu {
        position: absolute !important;
        right: 4px !important;
        left: auto !important;
        width: auto !important;
        min-width: 280px !important;
        max-width: calc(100vw - 8px) !important;
        box-shadow: 0 8px 32px rgba(0,0,0,0.18) !important;
        border-radius: 8px !important;
        border: 1px solid #e2e8f0 !important;
      }

      /* Compact content header & breadcrumb on mobile */
      .content-header {
        padding: 12px 10px 6px 10px !important;
      }
      .content-header > h1 {
        font-size: 18px !important;
        margin: 0 !important;
        line-height: 1.35 !important;
        word-break: break-word;
      }
      .content-header > h1 > small {
        display: block !important;
        font-size: 11.5px !important;
        margin-top: 2px !important;
      }
      .content-header > .breadcrumb {
        position: static !important;
        float: none !important;
        padding: 4px 0 6px 0 !important;
        margin-top: 4px !important;
        font-size: 11px !important;
        background: transparent !important;
      }

      /* Boxes and cards mobile styling */
      .box {
        border-radius: 10px !important;
        margin-bottom: 14px !important;
        border: 1px solid #e2e8f0 !important;
      }
      .box-header {
        padding: 12px 14px !important;
        display: flex !important;
        flex-direction: column !important;
        align-items: stretch !important;
        gap: 8px !important;
      }
      .box-header > .box-title {
        font-size: 15px !important;
        line-height: 1.35 !important;
        margin: 0 !important;
        word-break: break-word;
      }
      .box-header .box-tools,
      .box-header .pull-right {
        position: static !important;
        float: none !important;
        margin-top: 4px !important;
        width: 100% !important;
        display: flex !important;
        flex-wrap: wrap !important;
        gap: 6px !important;
      }
      .box-header .box-tools .btn,
      .box-header .pull-right .btn {
        flex: 1 1 auto !important;
        text-align: center !important;
        font-size: 12px !important;
        padding: 8px 10px !important;
        white-space: nowrap !important;
        border-radius: 6px !important;
      }
      .box-body {
        padding: 12px 10px !important;
      }
      .box-footer {
        padding: 10px 12px !important;
        text-align: center !important;
      }
      .box-footer .pagination {
        display: inline-flex !important;
        flex-wrap: wrap !important;
        justify-content: center !important;
        margin: 0 !important;
      }

      /* Forms and inputs touch optimization */
      .form-group {
        margin-bottom: 12px !important;
      }
      .form-control {
        font-size: 14px !important; /* Prevents auto-zoom in iOS Safari */
        border-radius: 6px !important;
        height: 38px !important;
      }
      .input-group {
        width: 100% !important;
      }
      .select2-container, .chosen-container {
        width: 100% !important;
        max-width: 100% !important;
      }

      /* Tables smooth touch scroll & prominent mobile scrollbar */
      .table-responsive {
        border: 1px solid #e2e8f0 !important;
        border-radius: 8px !important;
        margin-bottom: 10px !important;
        width: 100% !important;
        overflow-x: auto !important;
        -webkit-overflow-scrolling: touch !important;
      }
      .table-responsive > .table {
        margin-bottom: 0 !important;
        min-width: 580px;
      }
      .table-responsive th,
      .table-responsive td {
        padding: 8px 6px !important;
        font-size: 11.5px !important;
      }
      .table-responsive::-webkit-scrollbar {
        height: 5px !important;
      }
      .table-responsive::-webkit-scrollbar-thumb {
        background: #94a3b8 !important;
        border-radius: 4px !important;
      }

      /* Universal Horizontal Scrollable Tab/Pill Bars on Mobile */
      .cat-pill-scroll-container,
      .nav-tabs-bar,
      .crm-tab-bar,
      .rfm-tab-bar {
        display: flex !important;
        flex-wrap: nowrap !important;
        overflow-x: auto !important;
        -webkit-overflow-scrolling: touch !important;
        scrollbar-width: none !important;
        padding-bottom: 6px !important;
        gap: 6px !important;
        width: 100% !important;
      }
      .cat-pill-scroll-container::-webkit-scrollbar,
      .nav-tabs-bar::-webkit-scrollbar {
        display: none !important;
      }
      .cat-pill,
      .nav-tab-btn {
        flex-shrink: 0 !important;
        white-space: nowrap !important;
        font-size: 11.5px !important;
        padding: 7px 12px !important;
      }

      /* Buttons & Modal responsiveness */
      .btn {
        touch-action: manipulation;
      }
      .modal-dialog {
        margin: 10px auto !important;
        width: auto !important;
        max-width: calc(100vw - 20px) !important;
      }
      .modal-content {
        border-radius: 12px !important;
        overflow: hidden !important;
      }
      .modal-header {
        padding: 12px 14px !important;
      }
      .modal-title {
        font-size: 15px !important;
      }
      .modal-body {
        padding: 14px !important;
        max-height: calc(100vh - 130px) !important;
        overflow-y: auto !important;
        -webkit-overflow-scrolling: touch !important;
      }
      .modal-footer {
        padding: 10px 14px !important;
        display: flex !important;
        flex-wrap: wrap !important;
        gap: 6px !important;
      }
      .modal-footer .btn {
        flex: 1 1 auto !important;
        margin: 0 !important;
      }

      /* Sidebar Offcanvas Smooth Touch Interaction */
      .main-sidebar, .left-side {
        position: fixed !important;
        top: 0 !important;
        bottom: 0 !important;
        padding-top: 50px !important; /* Starts right below the 50px header */
        height: 100% !important;
        min-height: 100vh !important;
        z-index: 850 !important;
      }
      .sidebar {
        height: 100% !important;
        min-height: calc(100vh - 50px) !important;
        padding-top: 0 !important;
        margin-top: 0 !important;
        padding-bottom: 70px !important;
      }
      .sidebar-menu {
        padding-top: 0 !important;
        margin-top: 0 !important;
      }
      .sidebar-open .content-wrapper::before {
        content: "";
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.45);
        z-index: 800;
        backdrop-filter: blur(2px);
      }
    }
  </style>
  <?= $this->cc_html->getCssFileTop(); ?>

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <script src="<?= BASE_ASSET; ?>admin-lte/plugins/jQuery/jquery-2.2.3.min.js"></script>
  <script src="<?= BASE_ASSET; ?>admin-lte/plugins/iCheck/icheck.min.js"></script>
  <script src="<?= BASE_ASSET; ?>sweet-alert/sweetalert-dev.js"></script>
  <script src="<?= BASE_ASSET; ?>admin-lte/plugins/input-mask/jquery.inputmask.js"></script>
  <script src="<?= BASE_ASSET; ?>admin-lte/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
  <script src="<?= BASE_ASSET; ?>admin-lte/plugins/input-mask/jquery.inputmask.extensions.js"></script>
  <script src="<?= BASE_ASSET; ?>toastr/toastr.js"></script>
  <script src="<?= BASE_ASSET; ?>fancy-box/source/jquery.fancybox.js?v=2.1.5"></script>
  <script src="<?= BASE_ASSET; ?>datetimepicker/build/jquery.datetimepicker.full.js"></script>
  <script src="<?= BASE_ASSET; ?>editor/dist/js/medium-editor.js"></script>
  <script src="<?= BASE_ASSET; ?>js/cc-extension.js"></script>
  <script src="<?= BASE_ASSET; ?>js/cc-page-element.js"></script>
  <script>
    var BASE_URL = "<?= base_url(); ?>";
    var HTTP_REFERER = "<?= isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '/' ; ?>";
    var csrf = '<?= $this->security->get_csrf_token_name(); ?>';
    var token = '<?= $this->security->get_csrf_hash(); ?>';

    function show_alert(message, type) {
      var alertType = type || 'info';
      if (alertType === 'error') alertType = 'warning';
      if (typeof toastr !== 'undefined' && typeof toastr[alertType] === 'function') {
        toastr[alertType](message);
      } else if (typeof swal === 'function') {
        swal('Pemberitahuan', message, alertType);
      } else {
        alert(message);
      }
    }

    function set_notif_message(message, type) {
      show_alert(message, type);
    }

    /* Universal Clipboard Copy Helper */
    window.copyToClipboard = function(text, label) {
      if (!text || text === '-') return;
      label = label || 'Data';
      if (navigator.clipboard && window.isSecureContext) {
        navigator.clipboard.writeText(text).then(function() {
          show_alert(label + ' berhasil disalin: ' + text, 'success');
        }).catch(function() {
          window.fallbackCopyText(text, label);
        });
      } else {
        window.fallbackCopyText(text, label);
      }
    };

    window.fallbackCopyText = function(text, label) {
      var textArea = document.createElement("textarea");
      textArea.value = text;
      textArea.style.position = "fixed";
      textArea.style.left = "-999999px";
      textArea.style.top = "-999999px";
      document.body.appendChild(textArea);
      textArea.focus();
      textArea.select();
      try {
        document.execCommand('copy');
        show_alert(label + ' berhasil disalin: ' + text, 'success');
      } catch (err) {
        console.error('Fallback copy error', err);
      }
      document.body.removeChild(textArea);
    };

    window.showCopyNotice = function(msg) {
      show_alert(msg, 'success');
    };

    $(document).ready(function(){

      // Inject CSRF token into every AJAX POST request automatically
      $.ajaxSetup({
        data: { [csrf]: token },
        beforeSend: function(xhr, settings) {
          var reqType = (settings.type || settings.method || 'GET').toUpperCase();
          if (reqType === 'POST' && typeof settings.data === 'string' && settings.data.indexOf(csrf) === -1) {
            settings.data += '&' + csrf + '=' + token;
          }
        }
      });

      toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": true,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "7000",
        "extendedTimeOut": "3000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
      };

      var f_message = <?= json_encode($this->session->flashdata('f_message') ?: ''); ?>;
      var f_type = <?= json_encode($this->session->flashdata('f_type') ?: 'info'); ?>;

      if (f_message && f_message.length > 0) {
        if (typeof toastr !== 'undefined' && typeof toastr[f_type] === 'function') {
          toastr[f_type](f_message);
        } else if (typeof toastr !== 'undefined' && typeof toastr.info === 'function') {
          toastr.info(f_message);
        }
      }

      $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
        checkboxClass: 'icheckbox_minimal-red',
        radioClass: 'iradio_minimal-red'
      });
    });
  </script>
  <?= $this->cc_html->getScriptFileTop(); ?>
</head>
<body class="sidebar-mini skin-black fixed web-body">
<div class="wrapper">

  <header class="main-header">

     <?php 
      $logo =  get_option('logo');
      if ($logo) {
        $logo = 'uploads/setting/'. get_option('logo');
      } else {
        $logo = 'asset/img/icon-wide.png';
      }

      if (!is_file(FCPATH .'/'. $logo)) {
        $logo = 'asset/img/icon-wide.png';
      }
      ?>

    <a href="<?= site_url('/'); ?>" class="logo">
      <span class="logo-mini"><b><img src="<?= BASE_ASSET ?>img/icon-small.png" style="max-height: 40px; width: auto;"></b></span>
      <span class="logo-lg"><b><img src="<?= base_url($logo) ?>" style="max-height: 40px; width: auto;"></b></span>
    </a>
    <nav class="navbar navbar-static-top">

      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <?php if ($this->aauth->get_user()): ?>
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">

          <!-- Notifications Menu -->
          <li class="dropdown notifications-menu" id="notif-approval-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" title="Notifikasi">
              <i class="fa fa-bell-o" style="font-size: 16px;"></i>
              <span class="label label-warning" id="notif-approval-badge" style="display:none; position: absolute; top: 9px; right: 7px; text-align: center; font-size: 9px; padding: 2px 5px; border-radius: 10px;">0</span>
            </a>
            <ul class="dropdown-menu" style="width: 320px; max-width: calc(100vw - 16px); border-radius: 6px; box-shadow: 0 5px 25px rgba(0,0,0,0.15); border: none;">
              <li class="header" style="background: #f8f9fa; padding: 12px 15px; font-weight: 700; color: #2c3e50; border-bottom: 1px solid #eee; display: flex; justify-content: space-between; align-items: center;">
                <span><i class="fa fa-bell text-yellow" style="margin-right: 5px;"></i> <span id="notif-header-title">Peringatan Follow-Up</span></span>
                <span class="badge bg-yellow" id="notif-header-count">0</span>
              </li>
              <li>
                <ul class="menu" id="notif-approval-list" style="max-height: 280px; overflow-y: auto; padding: 0; margin: 0; list-style: none;">
                  <li style="text-align: center; padding: 20px; color: #95a5a6;"><i class="fa fa-spin fa-spinner"></i> Memuat notifikasi...</li>
                </ul>
              </li>
              <li class="footer" style="background: #f8f9fa; text-align: center; padding: 8px; border-top: 1px solid #eee;">
                <a href="<?= site_url('administrator/crm/journal_followup?status_label=belum_direspon'); ?>" id="notif-footer-link" style="color: #3498db; font-weight: 600; font-size: 12px;"><i class="fa fa-list"></i> Lihat Follow-Up Terlewat</a>
              </li>
            </ul>
          </li>

          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="<?= BASE_URL.'uploads/user/'.(!empty(get_user_data('avatar')) ? get_user_data('avatar') :'default.png'); ?>" class="user-image" alt="User Image" onerror="this.onerror=null; this.src='<?= BASE_ASSET; ?>admin-lte/dist/img/avatar.png';">
              <span class="hidden-xs"><?= _ent(ucwords(clean_snake_case(get_user_data('full_name')))); ?></span>
            </a>
            <ul class="dropdown-menu">
              <li class="user-header">
                <img src="<?= BASE_URL.'uploads/user/'.(!empty(get_user_data('avatar')) ? get_user_data('avatar') :'default.png'); ?>" class="img-circle" alt="User Image" onerror="this.onerror=null; this.src='<?= BASE_ASSET; ?>admin-lte/dist/img/avatar.png';">

                <p>
                  <?= _ent(ucwords(clean_snake_case($this->aauth->get_user()->full_name))); ?> 
                  <small>Last Login, <?= date('Y-M-D', strtotime(get_user_data('last_login'))); ?></small>
                </p>
              </li>
              
              <li class="user-footer">
                <div class="pull-left">
                  <a href="<?= site_url('administrator/user/profile'); ?>" class="btn btn-default btn-flat"><?= cclang('profile'); ?></a>
                </div>
                <div class="pull-right">
                  <a href="<?= site_url('administrator/auth/logout'); ?>" class="btn btn-default btn-flat"><?= cclang('sign_out'); ?></a>
                </div>
              </li>
            </ul>
          </li>
          <li class="dropdown ">
             <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
             <span class="flag-icon <?= get_current_initial_lang(); ?>"></span><span class="hidden-xs"> <?= get_current_lang(); ?></span> <i class="fa fa-angle-down hidden-xs" style="font-size: 11px;"></i></a>
             <ul class="dropdown-menu" role="menu">
             <?php foreach (get_langs() as $lang): ?>
                <li><a href="<?= site_url('web/switch_lang/'.$lang['folder_name']); ?>"><span class="flag-icon <?= $lang['icon_name']; ?>"></span> <?= $lang['name']; ?></a></li>
              <?php endforeach; ?>
             </ul>
          </li>
        </ul>
      </div>
      <?php endif ?>

    </nav>
  </header>
  <aside class="main-sidebar">

    <section class="sidebar">
      <ul class="sidebar-menu sidebar-admin tree" data-widget="tree">
        <?= display_menu_admin(0, 1); ?>
      </ul>
    </section>

  </aside>

  <div class="content-wrapper">
    <?php cicool()->eventListen('backend_content_top'); ?>
    <?= $template['partials']['content']; ?>
    <?php cicool()->eventListen('backend_content_bottom'); ?>

    <div class="modal fade  " id="modalPopUp">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title"> <span class="popup-title"></span></h4>
          </div>
          <div class="modal-body">
           
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
  </div>

<script>
$(document).ready(function(){
   // Global Automatic Thousands Separator Formatter (Indonesian Dot Format)
   $(document).on('keyup input', '.rupiah, .money-format', function(e) {
      if (e.which === 37 || e.which === 39) return;
      var rawVal = $(this).val().replace(/[^0-9]/g, '');
      if (rawVal.length > 0) {
         var formatted = parseInt(rawVal, 10).toLocaleString('id-ID');
         $(this).val(formatted);
      } else {
         $(this).val('');
      }
   });

   // Global Qty Integer Whole Number Enforcer (Always whole numbers min 1 for physical goods)
   $(document).on('blur change input', '.qty-input', function() {
      var raw = $(this).val();
      if (raw !== '') {
         var val = parseFloat(raw);
         if (isNaN(val) || val < 1) {
            $(this).val(1);
         } else if (val % 1 !== 0) {
            $(this).val(Math.round(val));
         }
      }
   });

   // Real-Time Notification Loader (Overdue Follow-Up Alerts & Approvals)
   function loadApprovalNotifications() {
      $.ajax({
         url: BASE_URL + 'administrator/dashboard/get_notifications',
         type: 'GET',
         dataType: 'json',
         success: function(res) {
            if (res && res.success) {
               if (res.header_title) {
                  $('#notif-header-title').text(res.header_title);
               }
               if (res.footer_url && res.footer_label) {
                  $('#notif-footer-link').attr('href', res.footer_url).html('<i class="fa fa-list"></i> ' + res.footer_label);
               }

               var count = res.total_count || 0;
               if (count > 0) {
                  $('#notif-approval-badge').text(count > 99 ? '99+' : count).show();
                  $('#notif-header-count').text(count);
               } else {
                  $('#notif-approval-badge').hide();
                  $('#notif-header-count').text('0');
               }

               var html = '';
               if (res.items && res.items.length > 0) {
                  $.each(res.items, function(i, item) {
                     html += '<li style="border-bottom: 1px solid #f4f4f4;" class="notif-item" data-notif-id="' + item.id + '" data-notif-type="' + item.type + '">';
                     html += '  <a href="' + item.url + '" class="notif-link" data-id="' + item.id + '" data-type="' + item.type + '" style="display: flex; align-items: flex-start; padding: 10px 15px; color: #333; text-decoration: none; transition: background 0.2s;" onmouseover="this.style.background=\'#f9f9f9\'" onmouseout="this.style.background=\'transparent\'">';
                     html += '    <div style="margin-right: 12px; font-size: 18px; line-height: 1;" class="' + item.icon_bg + '"><i class="fa ' + item.icon + '"></i></div>';
                     html += '    <div style="flex: 1; overflow: hidden;">';
                     html += '      <div style="font-weight: 600; font-size: 12px; text-overflow: ellipsis; overflow: hidden; white-space: nowrap; color: #2c3e50;">' + item.title + '</div>';
                     html += '      <div style="font-size: 11px; color: #7f8c8d; margin-top: 2px;">' + item.subtitle + '</div>';
                     html += '    </div>';
                     html += '    <div style="font-size: 10px; color: #bdc3c7; margin-left: 8px; white-space: nowrap;">' + item.date + '</div>';
                     html += '  </a>';
                     html += '</li>';
                  });
               } else {
                  html = '<li style="text-align: center; padding: 25px 15px; color: #7f8c8d; font-size: 13px;"><i class="fa fa-check-circle-o text-green" style="font-size: 24px; display: block; margin-bottom: 5px;"></i> Tidak ada peringatan follow-up</li>';
               }
               $('#notif-approval-list').html(html);
            }
         }
      });
   }

   if ($('#notif-approval-menu').length > 0) {
      loadApprovalNotifications();
      setInterval(loadApprovalNotifications, 5000);

      // Trigger instant refresh whenever user clicks the bell icon
      $('#notif-approval-menu > a').on('click', function() {
         loadApprovalNotifications();
      });

      // Click handler: navigate to target URL directly
      $(document).on('click', '.notif-link', function(e) {
         e.preventDefault();
         var targetUrl = $(this).attr('href');
         if (targetUrl) {
            window.location.href = targetUrl;
         }
      });
   }

   // Auto-close mobile sidebar when tapping on content-wrapper
   $(document).on('click', '.content-wrapper', function() {
      if ($('body').hasClass('sidebar-open') && $(window).width() < 768) {
         $('body').removeClass('sidebar-open');
      }
   });
});
</script>
  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b><?= cclang('version') ?></b> <?= VERSION ?>
    </div>
    <strong>Copyright &copy; 2020 -<?=date('Y'); ?> <a href="#"><?= get_option('site_name'); ?></a>.</strong> All rights
    reserved.
  </footer>
  
  <div class="control-sidebar-bg"></div>
</div>

<?= $this->cc_html->getHtmlFileBottom(); ?>

<?= $this->cc_html->getCssFileBottom(); ?>
<?= $this->cc_html->getScriptFileBottom(); ?>
<script>
        var AdminLTEOptions = {
          sidebarExpandOnHover: false,
           navbarMenuSlimscroll: false,
        };
      </script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.6.2/chosen.jquery.min.js" type="text/javascript"></script>
<script src="<?= BASE_ASSET; ?>jquery-ui/jquery-ui.js"></script>
<script src="<?= BASE_ASSET; ?>jquery-switch-button/jquery.switchButton.js"></script>
<script src="<?= BASE_ASSET; ?>js/jquery.ui.touch-punch.js"></script>
<script src="<?= BASE_ASSET; ?>admin-lte/bootstrap/js/bootstrap.min.js"></script>
<script src="<?= BASE_ASSET; ?>admin-lte/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<script src="<?= BASE_ASSET; ?>admin-lte/plugins/fastclick/fastclick.js"></script>
<script src="<?= BASE_ASSET; ?>admin-lte/dist/js/app.min.js"></script>
<script src="<?= BASE_ASSET; ?>js-scroll/script/jquery.jscrollpane.min.js"></script>
<script src="<?= BASE_ASSET; ?>js/custom.js?v=<?= VERSION; ?>.<?= is_file(FCPATH.'asset/js/custom.js') ? filemtime(FCPATH.'asset/js/custom.js') : '1'; ?>"></script>
<script>
  /* Sidebar Treeview Menu Arrow & Open State Synchronization */
  $(document).ready(function() {
    // 1. Initial State Sync: Ensure menu-open matches visibility on page load
    $('.sidebar-menu li.treeview').each(function() {
      var $li = $(this);
      var $menu = $li.children('.treeview-menu');
      if ($li.hasClass('active') || $li.hasClass('menu-open') || $menu.is(':visible')) {
        $li.addClass('menu-open active');
        $menu.show();
      } else {
        $li.removeClass('menu-open');
        $menu.hide();
      }
    });

    // 2. Click Handler Sync: Smoothly toggle menu-open and arrow rotation
    $(document).on('click', '.sidebar-menu li.treeview > a', function(e) {
      var $a = $(this);
      var $li = $a.parent('li.treeview');
      var $menu = $li.children('.treeview-menu');

      if ($menu.length > 0) {
        var willOpen = !$li.hasClass('menu-open');

        if (willOpen) {
          // Close sibling open menus and reset their arrow to point left
          $li.siblings('li.treeview.menu-open').each(function() {
            var $sib = $(this);
            $sib.removeClass('menu-open active');
            $sib.children('.treeview-menu').slideUp(250);
          });

          // Open this menu and rotate arrow down
          $li.addClass('menu-open active');
          $menu.slideDown(250);
        } else {
          // Close this menu and rotate arrow left
          $li.removeClass('menu-open');
          $menu.slideUp(250);
        }

        e.preventDefault();
        e.stopPropagation();
      }
    });

    /* Global Modal Backdrop Fix: Append modal to body to prevent z-index blocking in some browsers */
    $(document).on('show.bs.modal', '.modal', function () {
        if (!$(this).parent().is('body')) {
            $(this).appendTo('body');
        }
    });
    /* Fallback: If a modal is already open and stuck behind backdrop */
    $('.modal:visible').each(function() {
        if (!$(this).parent().is('body')) {
            $(this).appendTo('body');
        }
    });
  });
</script>
<?php 
// Clear flashdata at the end of the page rendering so it doesn't leak into subsequent pages
$this->session->unset_userdata('f_message'); 
$this->session->unset_userdata('f_type'); 
?>
</body>
</html>
