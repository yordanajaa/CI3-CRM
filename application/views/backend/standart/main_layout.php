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
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
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
  <link rel="stylesheet" href="<?= BASE_ASSET; ?>css/custom.css?v=<?= VERSION; ?>">
  <link rel="stylesheet" href="<?= BASE_ASSET; ?>datetimepicker/jquery.datetimepicker.css"/>
  <link rel="stylesheet" href="<?= BASE_ASSET; ?>js-scroll/style/jquery.jscrollpane.css" rel="stylesheet" media="all" />
  <link rel="stylesheet" href="<?= BASE_ASSET; ?>flag-icon/css/flag-icon.css" rel="stylesheet" media="all" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  
  <!-- Smooth Sidebar & Page Navigation Transition Animations -->
  <style>
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

    /* Sidebar Menu Styling & Hover Transitions */
    .sidebar-menu li a {
      transition: all 0.25s ease-in-out !important;
      position: relative;
    }
    .sidebar-menu li a:hover {
      background: rgba(255, 255, 255, 0.08) !important;
      padding-left: 20px !important;
    }
    .sidebar-menu li a i.fa {
      transition: transform 0.25s ease !important;
    }
    .sidebar-menu li a:hover i.fa {
      transform: scale(1.2);
    }
    .sidebar-menu .treeview-menu {
      background: rgba(0, 0, 0, 0.25) !important;
    }
    .sidebar-menu .treeview-menu > li > a {
      padding-left: 20px !important;
      color: #94a3b8 !important;
      transition: all 0.2s ease !important;
    }
    .sidebar-menu .treeview-menu > li > a:hover {
      padding-left: 26px !important;
      color: #ffffff !important;
    }
    .sidebar-menu .treeview-menu > li.active > a {
      font-weight: 700 !important;
      color: #38bdf8 !important;
    }
    .text-indigo { color: #818cf8 !important; }
    .text-teal { color: #2dd4bf !important; }
    .text-yellow { color: #facc15 !important; }
    .text-purple { color: #c084fc !important; }
    .text-green { color: #4ade80 !important; }
    .text-blue { color: #60a5fa !important; }
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
        "positionClass": "toast-top-center",
      }

      var f_message = '<?= str_replace("'", "\'", $this->session->flashdata('f_message') ?? ''); ?>';
      var f_type = '<?= $this->session->flashdata('f_type') ?: 'info'; ?>';
      <?php 
      // Force clear flashdata to prevent it from persisting across pages due to session race conditions
      $this->session->unset_userdata('f_message'); 
      $this->session->unset_userdata('f_type'); 
      ?>

      if (f_message.length > 0) {
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
            <ul class="dropdown-menu" style="width: 320px; border-radius: 6px; box-shadow: 0 5px 25px rgba(0,0,0,0.15); border: none;">
              <li class="header" style="background: #f8f9fa; padding: 12px 15px; font-weight: 700; color: #2c3e50; border-bottom: 1px solid #eee; display: flex; justify-content: space-between; align-items: center;">
                <span><i class="fa fa-bell text-yellow" style="margin-right: 5px;"></i> <span id="notif-header-title">Notifikasi</span></span>
                <span class="badge bg-yellow" id="notif-header-count">0</span>
              </li>
              <li>
                <ul class="menu" id="notif-approval-list" style="max-height: 280px; overflow-y: auto; padding: 0; margin: 0; list-style: none;">
                  <li style="text-align: center; padding: 20px; color: #95a5a6;"><i class="fa fa-spin fa-spinner"></i> Memuat notifikasi...</li>
                </ul>
              </li>
              <li class="footer" style="background: #f8f9fa; text-align: center; padding: 8px; border-top: 1px solid #eee;">
                <a href="<?= site_url('administrator/purchase_order'); ?>" id="notif-footer-link" style="color: #3498db; font-weight: 600; font-size: 12px;"><i class="fa fa-list"></i> Lihat Selengkapnya</a>
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
             <span class="flag-icon <?= get_current_initial_lang(); ?>"></span> <?= get_current_lang(); ?> </a>
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

    <section class="sidebar" style="padding-top:0% !important">
      <ul class="sidebar-menu sidebar-admin tree" data-widget="tree" style="padding-bottom: 80px !important;">
        
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

   // Web Audio API Synth Chime for Ultra-Realtime WA Notification Sound
   var sharedAudioCtx = null;
   function getAudioContext() {
      try {
         if (!sharedAudioCtx) {
            var AudioCtx = window.AudioContext || window.webkitAudioContext;
            if (AudioCtx) sharedAudioCtx = new AudioCtx();
         }
         if (sharedAudioCtx && sharedAudioCtx.state === 'suspended') {
            sharedAudioCtx.resume();
         }
      } catch(e) {}
      return sharedAudioCtx;
   }

   $(document).on('click keydown touchstart', function() {
      getAudioContext();
   });

   function playNotifChime() {
      try {
         var ctx = getAudioContext();
         if (!ctx) return;
         if (ctx.state === 'suspended') {
            ctx.resume().then(function() {
               _executeNotifChime(ctx);
            }).catch(function() {
               _executeNotifChime(ctx);
            });
         } else {
            _executeNotifChime(ctx);
         }
      } catch(e) {}
   }

   function _executeNotifChime(ctx) {
      try {
         var now = ctx.currentTime;
         var osc = ctx.createOscillator();
         var gain = ctx.createGain();
         osc.type = 'sine';
         // Crisp 3-tone WhatsApp/iOS chime: E6 (1318 Hz) -> A6 (1760 Hz) -> B6 (1975 Hz)
         osc.frequency.setValueAtTime(1318.5, now);
         osc.frequency.exponentialRampToValueAtTime(1760.0, now + 0.08);
         osc.frequency.exponentialRampToValueAtTime(1975.5, now + 0.16);
         gain.gain.setValueAtTime(0.65, now);
         gain.gain.exponentialRampToValueAtTime(0.01, now + 0.45);
         osc.connect(gain);
         gain.connect(ctx.destination);
         osc.start(now);
         osc.stop(now + 0.45);
      } catch(e) {}
   }

   // Instant Real-Time Notification Loader (2-second polling with sessionStorage persistence)
   var lastNotifiedWaId = parseInt(sessionStorage.getItem('lastNotifiedWaId') || '0');
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
                  var maxWaId = 0;
                  $.each(res.items, function(i, item) {
                     if (item.type === 'incoming_wa' && item.id) {
                        var itemId = parseInt(item.id);
                        if (itemId > maxWaId) maxWaId = itemId;

                        // Trigger instant Toastr popup & audio sound chime for NEW incoming WhatsApp message
                        if (lastNotifiedWaId > 0 && itemId > lastNotifiedWaId) {
                           playNotifChime();
                           if (typeof toastr !== 'undefined') {
                              toastr.info(
                                 '<b>' + item.title + '</b><br>' + item.subtitle,
                                 '💬 Pesan WhatsApp Masuk',
                                 {
                                    timeOut: 8000,
                                    extendedTimeOut: 3000,
                                    closeButton: true,
                                    progressBar: true,
                                    onclick: function() { window.location.href = item.url; }
                                 }
                              );
                           }

                           // HTML5 Desktop Notification
                           if (window.Notification && Notification.permission === 'granted') {
                              try {
                                 new Notification(item.title, {
                                    body: item.subtitle,
                                    icon: BASE_URL + 'asset/img/icon-wide.png'
                                 });
                              } catch(e) {}
                           }
                        }
                     }

                     html += '<li style="border-bottom: 1px solid #f4f4f4;" class="notif-item" data-notif-id="' + item.id + '" data-notif-type="' + item.type + '">';
                     html += '  <a href="' + item.url + '" class="notif-link" data-chat-id="' + item.id + '" data-type="' + item.type + '" style="display: flex; align-items: flex-start; padding: 10px 15px; color: #333; text-decoration: none; transition: background 0.2s;" onmouseover="this.style.background=\'#f9f9f9\'" onmouseout="this.style.background=\'transparent\'">';
                     html += '    <div style="margin-right: 12px; font-size: 18px; line-height: 1;" class="' + item.icon_bg + '"><i class="fa ' + item.icon + '"></i></div>';
                     html += '    <div style="flex: 1; overflow: hidden;">';
                     html += '      <div style="font-weight: 600; font-size: 12px; text-overflow: ellipsis; overflow: hidden; white-space: nowrap; color: #2c3e50;">' + item.title + '</div>';
                     html += '      <div style="font-size: 11px; color: #7f8c8d; margin-top: 2px;">' + item.subtitle + '</div>';
                     html += '    </div>';
                     html += '    <div style="font-size: 10px; color: #bdc3c7; margin-left: 8px; white-space: nowrap;">' + item.date + '</div>';
                     html += '  </a>';
                     html += '</li>';
                  });

                  if (maxWaId > 0) {
                     if (lastNotifiedWaId === 0) {
                        lastNotifiedWaId = maxWaId; // Baseline on first load
                     } else if (maxWaId > lastNotifiedWaId) {
                        lastNotifiedWaId = maxWaId;
                     }
                     sessionStorage.setItem('lastNotifiedWaId', lastNotifiedWaId);
                  }
               } else {
                  html = '<li style="text-align: center; padding: 25px 15px; color: #7f8c8d; font-size: 13px;"><i class="fa fa-check-circle-o text-green" style="font-size: 24px; display: block; margin-bottom: 5px;"></i> Tidak ada notifikasi baru</li>';
               }
               $('#notif-approval-list').html(html);
            }
         }
      });
   }

   if ($('#notif-approval-menu').length > 0) {
      loadApprovalNotifications();
      setInterval(loadApprovalNotifications, 2000);

      // Click handler: mark notification as read, remove from list, then navigate
      $(document).on('click', '.notif-link', function(e) {
         e.preventDefault();
         var $link = $(this);
         var $item = $link.closest('.notif-item');
         var chatId = $link.data('chat-id');
         var itemType = $link.data('type');
         var targetUrl = $link.attr('href');

         // Instantly remove from visual list
         $item.slideUp(150, function() { $(this).remove(); });

         // Update badge count
         var currentCount = parseInt($('#notif-header-count').text()) || 0;
         var newCount = Math.max(0, currentCount - 1);
         if (newCount > 0) {
            $('#notif-approval-badge').text(newCount > 99 ? '99+' : newCount);
            $('#notif-header-count').text(newCount);
         } else {
            $('#notif-approval-badge').hide();
            $('#notif-header-count').text('0');
         }

         // Mark as read via AJAX (fire-and-forget)
         if (itemType === 'incoming_wa' && chatId) {
            $.post(BASE_URL + 'administrator/crm/mark_notification_read_ajax', { chat_id: chatId });
         }

         // Navigate immediately — force reload if already on same page
         if (window.location.href.indexOf(targetUrl.split('?')[0]) !== -1) {
            window.location.href = targetUrl;
            window.location.reload(true);
         } else {
            window.location.href = targetUrl;
         }
      });
   }
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
<script src="<?= BASE_ASSET; ?>js/custom.js?v=<?= VERSION ?>"></script>
<script>
  /* Global Modal Backdrop Fix: Append modal to body to prevent z-index blocking in some browsers */
  $(document).ready(function() {
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
</body>
</html>
