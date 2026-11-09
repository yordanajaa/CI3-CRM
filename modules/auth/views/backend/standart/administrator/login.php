<?php
// If accessed directly outside CI3, redirect to administrator/login
if (!defined('BASEPATH')) {
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == 443)) ? "https://" : "http://";
    $domain = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : 'localhost';
    $baseDir = dirname($_SERVER['SCRIPT_NAME']);
    $baseDir = rtrim(str_replace('\\', '/', $baseDir), '/');
    header("Location: " . $protocol . $domain . $baseDir . "/index.php/administrator/login");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Login | MetaforaCRM - Aplikasi Pengelola Pelanggan & Beli Ulang</title>
  <!-- Responsive Viewport -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%23E11D48' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'><circle cx='9' cy='21' r='1'></circle><circle cx='20' cy='21' r='1'></circle><path d='M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6'></path></svg>" />

  <!-- Google Fonts: Plus Jakarta Sans & Inter -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@500;600;700;800&display=swap" rel="stylesheet">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

  <style type="text/css">
    *, *::before, *::after {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    body {
      font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
      background: #F8FAFC;
      color: #0F172A;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      position: relative;
      overflow-x: hidden;
      padding: 32px 16px;
    }

    /* Ambient Subtle Blur Glows (Soft Emerald Tints) */
    .glow-shape-1 {
      position: absolute;
      top: -120px;
      left: 50%;
      transform: translateX(-50%);
      width: 750px;
      height: 480px;
      border-radius: 50%;
      background: radial-gradient(circle, rgba(16, 185, 129, 0.08) 0%, rgba(241, 245, 249, 0) 70%);
      filter: blur(60px);
      pointer-events: none;
      z-index: 0;
    }

    .glow-shape-2 {
      position: absolute;
      bottom: -60px;
      right: 15%;
      width: 450px;
      height: 350px;
      border-radius: 50%;
      background: radial-gradient(circle, rgba(5, 150, 105, 0.06) 0%, transparent 70%);
      filter: blur(50px);
      pointer-events: none;
      z-index: 0;
    }

    .login-container {
      position: relative;
      z-index: 10;
      width: 100%;
      max-width: 440px;
      margin: auto;
    }

    /* Clean Pure White SaaS Login Card */
    .login-card {
      background: #FFFFFF;
      border-radius: 24px;
      border: 1px solid #E2E8F0;
      box-shadow: 0 20px 40px -15px rgba(15, 23, 42, 0.07), 0 1px 3px 0 rgba(15, 23, 42, 0.04);
      padding: 40px 36px;
      transition: all 0.2s ease;
    }

    /* Header: Logo, Pill, Title, and Subtitle All Centered */
    .card-header-center {
      display: flex;
      flex-direction: column;
      align-items: center;
      text-align: center;
      margin-bottom: 26px;
    }

    .brand-logo-wrap {
      display: inline-flex;
      align-items: center;
      gap: 10px;
      text-decoration: none;
      margin-bottom: 12px;
      transition: transform 0.2s ease;
    }

    .brand-logo-wrap:hover {
      transform: scale(1.02);
    }

    /* Shopping Cart Icon in Emerald Green Gradient */
    .brand-icon {
      width: 44px;
      height: 44px;
      border-radius: 14px;
      background: linear-gradient(135deg, #10B981 0%, #059669 100%);
      color: #FFFFFF;
      display: flex;
      align-items: center;
      justify-content: center;
      box-shadow: 0 6px 16px rgba(16, 185, 129, 0.28);
    }

    .brand-title {
      font-family: 'Plus Jakarta Sans', sans-serif;
      font-size: 24px;
      font-weight: 800;
      color: #0F172A;
      letter-spacing: -0.5px;
    }

    .brand-title span {
      color: #10B981;
    }

    /* Category Pill Tagline */
    .brand-pill {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      padding: 4px 14px;
      border-radius: 9999px;
      background: #F0FDF4;
      border: 1px solid #BBF7D0;
      color: #166534;
      font-size: 10.5px;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      margin-bottom: 14px;
      font-family: 'Plus Jakarta Sans', sans-serif;
    }

    .pill-dot {
      width: 6px;
      height: 6px;
      border-radius: 50%;
      background: #10B981;
      animation: pulseDot 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
    }

    @keyframes pulseDot {
      0%, 100% { opacity: 1; transform: scale(1); }
      50% { opacity: 0.4; transform: scale(0.85); }
    }

    .card-title {
      font-family: 'Plus Jakarta Sans', sans-serif;
      font-size: 22px;
      font-weight: 800;
      color: #0F172A;
      letter-spacing: -0.4px;
      margin-bottom: 6px;
    }

    .card-subtitle {
      font-size: 13.5px;
      color: #64748B;
      line-height: 1.5;
    }

    /* Alerts */
    .alert-modern {
      padding: 12px 14px;
      border-radius: 12px;
      font-size: 13px;
      margin-bottom: 20px;
      display: flex;
      align-items: flex-start;
      gap: 10px;
      line-height: 1.45;
      text-align: left;
    }

    .alert-danger-modern {
      background: #FEF2F2;
      border: 1px solid #FECACA;
      color: #991B1B;
    }

    .alert-danger-modern .alert-icon {
      color: #DC2626;
      font-size: 16px;
      margin-top: 1px;
      flex-shrink: 0;
    }

    /* Form Groups */
    .form-group {
      margin-bottom: 18px;
      text-align: left;
    }

    .form-label {
      display: block;
      font-size: 13px;
      font-weight: 600;
      color: #334155;
      margin-bottom: 6px;
      font-family: 'Plus Jakarta Sans', sans-serif;
    }

    .input-wrapper {
      position: relative;
      display: flex;
      align-items: center;
    }

    .input-icon-left {
      position: absolute;
      left: 14px;
      color: #94A3B8;
      font-size: 15px;
      pointer-events: none;
      display: flex;
      align-items: center;
      justify-content: center;
      width: 18px;
      transition: color 0.15s ease;
    }

    .form-input {
      width: 100%;
      height: 48px;
      padding: 10px 14px 10px 42px;
      font-size: 14px;
      color: #0F172A;
      background-color: #F8FAFC;
      border: 1.5px solid #CBD5E1;
      border-radius: 12px;
      transition: all 0.2s ease;
      outline: none;
      font-family: inherit;
    }

    .form-input.has-toggle {
      padding-right: 44px;
    }

    .form-input:focus {
      border-color: #10B981;
      box-shadow: 0 0 0 3.5px rgba(16, 185, 129, 0.15);
      background-color: #FFFFFF;
    }

    .input-wrapper:focus-within .input-icon-left {
      color: #10B981;
    }

    .form-input::placeholder {
      color: #94A3B8;
      font-size: 13.5px;
    }

    /* Show/Hide Password Toggle */
    .btn-toggle-pwd {
      position: absolute;
      right: 12px;
      background: none;
      border: none;
      color: #94A3B8;
      cursor: pointer;
      padding: 6px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 15px;
      transition: color 0.15s ease;
      border-radius: 6px;
    }

    .btn-toggle-pwd:hover {
      color: #334155;
    }

    /* Options Row: Remember Me & Forgot Password */
    .options-row {
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-top: 4px;
      margin-bottom: 22px;
      font-size: 13px;
    }

    .remember-wrap {
      display: flex;
      align-items: center;
      gap: 7px;
      cursor: pointer;
      user-select: none;
    }

    .remember-wrap input[type="checkbox"] {
      width: 16px;
      height: 16px;
      border-radius: 4px;
      border: 1.5px solid #CBD5E1;
      background: #FFFFFF;
      accent-color: #10B981;
      cursor: pointer;
    }

    .remember-wrap span {
      color: #475569;
      font-weight: 500;
    }

    .forgot-link {
      color: #059669;
      font-weight: 600;
      text-decoration: none;
      transition: color 0.15s ease;
    }

    .forgot-link:hover {
      color: #047857;
      text-decoration: underline;
    }

    /* Submit Button (Vibrant Emerald Green Pill Button) */
    .btn-submit {
      width: 100%;
      height: 48px;
      background: linear-gradient(135deg, #10B981 0%, #059669 100%);
      color: #FFFFFF !important;
      border: none;
      border-radius: 9999px;
      font-size: 14.5px;
      font-weight: 800;
      font-family: 'Plus Jakarta Sans', sans-serif;
      cursor: pointer;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      box-shadow: 0 6px 20px rgba(16, 185, 129, 0.35);
      transition: all 0.2s ease;
    }

    .btn-submit:hover {
      background: linear-gradient(135deg, #059669 0%, #047857 100%);
      transform: translateY(-1.5px);
      box-shadow: 0 10px 25px rgba(16, 185, 129, 0.45);
    }

    .btn-submit:active {
      transform: translateY(0);
      box-shadow: 0 2px 8px rgba(16, 185, 129, 0.25);
    }

    /* Demo Account Registration Box (Cohesive Emerald Green Tone) */
    .register-callout-box {
      margin-top: 22px;
      padding: 16px 18px;
      background: #F0FDF4;
      border: 1px solid #BBF7D0;
      border-radius: 16px;
      text-align: center;
    }

    .register-callout-title {
      font-size: 13px;
      color: #0F172A;
      margin-bottom: 10px;
      font-weight: 700;
      font-family: 'Plus Jakarta Sans', sans-serif;
    }

    .btn-register-action {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      width: 100%;
      height: 42px;
      background: #FFFFFF;
      border: 1.5px solid #10B981;
      color: #047857;
      font-weight: 700;
      font-size: 13.5px;
      font-family: 'Plus Jakarta Sans', sans-serif;
      border-radius: 9999px;
      text-decoration: none;
      transition: all 0.2s ease;
    }

    .btn-register-action:hover {
      background: #10B981;
      border-color: #10B981;
      color: #FFFFFF;
      transform: translateY(-1px);
      box-shadow: 0 6px 16px rgba(16, 185, 129, 0.3);
    }

    .register-callout-note {
      font-size: 11.5px;
      color: #166534;
      margin-top: 9px;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 5px;
      font-weight: 500;
    }

    .register-callout-note i {
      color: #10B981;
    }

    /* Card Footer & Centered Links */
    .card-footer-links {
      margin-top: 22px;
      padding-top: 18px;
      border-top: 1px solid #F1F5F9;
      text-align: center;
      font-size: 13px;
      color: #64748B;
    }

    .card-footer-links a {
      color: #059669;
      font-weight: 600;
      text-decoration: none;
      transition: color 0.15s ease;
    }

    .card-footer-links a:hover {
      color: #047857;
      text-decoration: underline;
    }

    .back-home-wrap {
      margin-top: 22px;
      text-align: center;
    }

    .back-home-link {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      color: #64748B;
      font-size: 13px;
      font-weight: 600;
      text-decoration: none;
      transition: color 0.15s ease;
    }

    .back-home-link:hover {
      color: #059669;
    }

    @media (max-width: 480px) {
      .login-card {
        padding: 30px 22px;
        border-radius: 20px;
      }
      .brand-title {
        font-size: 21px;
      }
      .card-title {
        font-size: 20px;
      }
      .options-row {
        flex-direction: column;
        align-items: flex-start;
        gap: 10px;
      }
    }
  </style>
</head>
<body>

  <!-- Ambient Glow Elements -->
  <div class="glow-shape-1"></div>
  <div class="glow-shape-2"></div>

  <div class="login-container">
    <!-- Login Card (All Elements Centered & Simple) -->
    <div class="login-card">
      
      <!-- Brand & Heading Centered -->
      <div class="card-header-center">
        <a href="<?= site_url(''); ?>" class="brand-logo-wrap" title="MetaforaCRM">
          <div class="brand-icon">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.3" stroke-linecap="round" stroke-linejoin="round">
              <circle cx="9" cy="21" r="1"></circle>
              <circle cx="20" cy="21" r="1"></circle>
              <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
            </svg>
          </div>
          <span class="brand-title">Metafora<span>CRM</span></span>
        </a>

        <div class="brand-pill">
          <span class="pill-dot"></span>
          <span>APLIKASI CRM &amp; PENGINGAT REPEAT ORDER OTOMATIS</span>
        </div>

        <h1 class="card-title">Selamat Datang Kembali</h1>
        <p class="card-subtitle">Masuk untuk mengelola pelanggan, pesanan &amp; WhatsApp</p>
      </div>

      <!-- Error / Flash Message Notification -->
      <?php if(isset($error) AND !empty($error)): ?>
        <div class="alert-modern alert-danger-modern" role="alert">
          <i class="fa fa-exclamation-circle alert-icon"></i>
          <div><?= $error; ?></div>
        </div>
      <?php endif; ?>

      <?php
      $message = $this->session->flashdata('f_message'); 
      $type = $this->session->flashdata('f_type'); 
      if ($message):
      ?>
        <div class="alert-modern alert-danger-modern" role="alert">
          <i class="fa fa-info-circle alert-icon"></i>
          <div><?= $message; ?></div>
        </div>
      <?php endif; ?>

      <!-- Login Form with Auto CSRF Protection -->
      <?= form_open('', [
        'name'    => 'form_login', 
        'id'      => 'form_login', 
        'method'  => 'POST'
      ]); ?>

        <!-- Username / Email Input -->
        <div class="form-group">
          <label class="form-label" for="username">Username atau Email</label>
          <div class="input-wrapper">
            <span class="input-icon-left">
              <i class="fa fa-user-o"></i>
            </span>
            <input 
              type="text" 
              class="form-input" 
              id="username"
              name="username" 
              placeholder="Masukkan username atau email" 
              value="<?= set_value('username'); ?>" 
              autocomplete="username"
              autofocus 
              required
            >
          </div>
        </div>

        <!-- Password Input with Show/Hide Toggle -->
        <div class="form-group">
          <label class="form-label" for="password">Password</label>
          <div class="input-wrapper">
            <span class="input-icon-left">
              <i class="fa fa-lock"></i>
            </span>
            <input 
              type="password" 
              class="form-input has-toggle" 
              id="password"
              name="password" 
              placeholder="Masukkan password Anda" 
              autocomplete="current-password"
              required
            >
            <button type="button" class="btn-toggle-pwd" id="toggle_password" aria-label="Tampilkan atau sembunyikan password" title="Tampilkan Password">
              <i class="fa fa-eye" id="toggle_pwd_icon"></i>
            </button>
          </div>
        </div>

        <!-- Options Row: Ingat Saya -->
        <div class="options-row">
          <label class="remember-wrap">
            <input type="checkbox" name="remember" id="remember" value="1">
            <span>Ingat saya</span>
          </label>
        </div>

        <!-- Submit Button (Crimson Red Pill Button) -->
        <button type="submit" class="btn-submit">
          <span>Masuk ke Dashboard</span>
          <i class="fa fa-arrow-right"></i>
        </button>

      <?= form_close(); ?>

      <!-- Demo Account Registration Box (Cohesive Crimson/Rose Tone) -->
      <div class="register-callout-box">
        <div class="register-callout-title">
          Belum punya akun? Ingin uji coba fitur MetaforaCRM?
        </div>
        <a href="<?= site_url('administrator/register'); ?>" class="btn-register-action">
          <i class="fa fa-user-plus"></i>
          <span>Daftar Akun Demo Gratis</span>
          <i class="fa fa-arrow-right"></i>
        </a>
        <div class="register-callout-note">
          <i class="fa fa-shield"></i> Akun baru akan diverifikasi &amp; disetujui Admin sebelum aktif
        </div>
      </div>

      <!-- Card Footer Links (Centered) -->
      <div class="card-footer-links">
        Kendala akses akun? <a href="https://wa.me/6282230700567?text=Halo%20Administrator%20MetaforaCRM%2C%20saya%20butuh%20bantuan%20akses%20login." target="_blank">Hubungi Administrator</a>
      </div>
    </div>

    <!-- Back to Landing Page Link -->
    <div class="back-home-wrap">
      <a href="<?= site_url(''); ?>" class="back-home-link">
        <i class="fa fa-angle-left"></i>
        <span>Kembali ke Beranda MetaforaCRM</span>
      </a>
    </div>
  </div>

  <!-- jQuery & Show/Hide Password Script -->
  <script src="<?= base_url('asset/admin-lte/plugins/jQuery/jquery-2.2.3.min.js'); ?>"></script>
  <script>
    $(document).ready(function() {
      // Toggle Show/Hide Password
      $('#toggle_password').on('click', function(e) {
        e.preventDefault();
        var pwdInput = $('#password');
        var icon = $('#toggle_pwd_icon');
        
        if (pwdInput.attr('type') === 'password') {
          pwdInput.attr('type', 'text');
          icon.removeClass('fa-eye').addClass('fa-eye-slash');
          $(this).attr('title', 'Sembunyikan Password');
        } else {
          pwdInput.attr('type', 'password');
          icon.removeClass('fa-eye-slash').addClass('fa-eye');
          $(this).attr('title', 'Tampilkan Password');
        }
      });
    });
  </script>
</body>
</html>
