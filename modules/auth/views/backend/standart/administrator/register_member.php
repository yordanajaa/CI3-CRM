<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Daftar Akun Testing Demo | MetaforaCRM - Aplikasi Pengelola Pelanggan & Beli Ulang</title>
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
      padding: 36px 16px;
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

    .register-container {
      position: relative;
      z-index: 10;
      width: 100%;
      max-width: 540px;
      margin: auto;
    }

    /* Clean Pure White SaaS Register Card */
    .register-card {
      background: #FFFFFF;
      border-radius: 24px;
      border: 1px solid #E2E8F0;
      box-shadow: 0 20px 40px -15px rgba(15, 23, 42, 0.07), 0 1px 3px 0 rgba(15, 23, 42, 0.04);
      padding: 40px 36px;
      transition: all 0.2s ease;
    }

    @media (max-width: 540px) {
      .register-card {
        padding: 28px 22px;
        border-radius: 20px;
      }
    }

    .brand-header {
      display: flex;
      flex-direction: column;
      align-items: center;
      text-align: center;
      margin-bottom: 24px;
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

    .brand-badge {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      padding: 4px 14px;
      border-radius: 9999px;
      background: #F0FDF4;
      border: 1px solid #BBF7D0;
      color: #166534;
      font-size: 11px;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      margin-bottom: 12px;
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
      line-height: 1.3;
      margin-bottom: 6px;
    }

    .card-subtitle {
      font-size: 13.5px;
      color: #64748B;
      line-height: 1.5;
    }

    .form-group {
      margin-bottom: 18px;
      text-align: left;
    }

    .form-row {
      display: flex;
      gap: 14px;
    }

    @media (max-width: 600px) {
      .form-row {
        flex-direction: column;
        gap: 0;
      }
    }

    .form-row .form-group {
      flex: 1;
    }

    .form-label {
      display: block;
      font-size: 12.5px;
      font-weight: 600;
      color: #334155;
      margin-bottom: 6px;
      font-family: 'Plus Jakarta Sans', sans-serif;
    }

    .form-label span.req {
      color: #EF4444;
      margin-left: 2px;
      font-weight: 700;
    }

    .input-wrapper {
      position: relative;
    }

    .input-wrapper i.input-icon {
      position: absolute;
      left: 14px;
      top: 50%;
      transform: translateY(-50%);
      color: #94A3B8;
      font-size: 14px;
      pointer-events: none;
      transition: color 0.15s ease;
    }

    .form-input {
      width: 100%;
      height: 48px;
      padding: 10px 14px 10px 40px;
      font-size: 13.5px;
      font-family: inherit;
      color: #0F172A;
      background-color: #F8FAFC;
      border: 1.5px solid #CBD5E1;
      border-radius: 12px;
      outline: none;
      transition: all 0.2s ease;
    }

    .form-input:focus {
      border-color: #10B981;
      box-shadow: 0 0 0 3.5px rgba(16, 185, 129, 0.15);
      background-color: #FFFFFF;
    }

    .form-input:focus + i.input-icon,
    .input-wrapper:focus-within i.input-icon {
      color: #10B981;
    }

    .form-input::placeholder {
      color: #94A3B8;
    }

    /* Vibrant Emerald Green Pill Button */
    .btn-submit {
      width: 100%;
      height: 48px;
      padding: 12px 18px;
      font-size: 14.5px;
      font-weight: 800;
      font-family: 'Plus Jakarta Sans', sans-serif;
      color: #FFFFFF !important;
      background: linear-gradient(135deg, #10B981 0%, #059669 100%);
      border: none;
      border-radius: 9999px;
      cursor: pointer;
      box-shadow: 0 6px 20px rgba(16, 185, 129, 0.35);
      transition: all 0.2s ease;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      margin-top: 24px;
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

    .alert-box {
      border-radius: 12px;
      padding: 12px 16px;
      margin-bottom: 20px;
      font-size: 13px;
      line-height: 1.5;
    }

    .alert-danger {
      background-color: #FEF2F2;
      border: 1px solid #FECACA;
      color: #991B1B;
    }

    .alert-success {
      background-color: #F0FDF4;
      border: 1px solid #BBF7D0;
      color: #166534;
    }

    /* Notice Callout Box */
    .notice-callout {
      font-size: 12px;
      color: #166534;
      background: #F0FDF4;
      border: 1px solid #BBF7D0;
      padding: 12px 14px;
      border-radius: 12px;
      margin-top: 4px;
      line-height: 1.5;
      display: flex;
      align-items: center;
      gap: 8px;
    }

    .notice-callout i {
      color: #10B981;
      font-size: 14px;
      flex-shrink: 0;
    }

    /* Success Card State */
    .success-card {
      text-align: center;
      padding: 20px 0;
    }

    .success-icon-wrap {
      width: 76px;
      height: 76px;
      border-radius: 50%;
      background: #F0FDF4;
      border: 2px solid #BBF7D0;
      color: #10B981;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      font-size: 32px;
      margin-bottom: 18px;
      box-shadow: 0 8px 20px rgba(16, 185, 129, 0.2);
    }

    .success-title {
      font-family: 'Plus Jakarta Sans', sans-serif;
      font-size: 22px;
      font-weight: 800;
      color: #0F172A;
      margin-bottom: 10px;
    }

    .success-desc {
      font-size: 14px;
      color: #64748B;
      line-height: 1.6;
      margin-bottom: 24px;
    }

    .info-callout {
      background: #F8FAFC;
      border: 1px solid #E2E8F0;
      border-radius: 14px;
      padding: 16px 18px;
      margin-bottom: 24px;
      text-align: left;
      font-size: 13px;
      color: #334155;
    }

    .info-callout ul {
      margin-left: 18px;
      margin-top: 6px;
    }

    .info-callout li {
      margin-bottom: 5px;
    }

    .btn-secondary {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      width: 100%;
      height: 46px;
      padding: 12px 18px;
      font-size: 14px;
      font-weight: 700;
      font-family: 'Plus Jakarta Sans', sans-serif;
      color: #334155;
      background: #F1F5F9;
      border: 1.5px solid #CBD5E1;
      border-radius: 9999px;
      text-decoration: none;
      transition: all 0.2s ease;
    }

    .btn-secondary:hover {
      background: #E2E8F0;
      border-color: #94A3B8;
      color: #0F172A;
    }

    .card-footer-links {
      text-align: center;
      margin-top: 24px;
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
  </style>
</head>
<body>
  <!-- Ambient Glow Elements -->
  <div class="glow-shape-1"></div>
  <div class="glow-shape-2"></div>

  <div class="register-container">
    <div class="register-card">

      <?php if ($this->input->get('success') == '1' || $this->session->flashdata('success_register')): ?>
        <!-- State: Registrasi Berhasil, Menunggu Approval -->
        <div class="success-card">
          <div class="success-icon-wrap">
            <i class="fa fa-check"></i>
          </div>
          <h2 class="success-title">Permohonan Akun Berhasil!</h2>
          <p class="success-desc">
            Terima kasih telah mendaftar, <strong><?= htmlspecialchars($this->session->flashdata('reg_name') ?: 'Calon Customer'); ?></strong>. 
            Permohonan akun demo Anda sedang dalam antrean verifikasi &amp; persetujuan (approval) oleh Tim Administrator Metafora.
          </p>

          <div class="info-callout">
            <strong><i class="fa fa-info-circle text-primary"></i> Apa langkah berikutnya?</strong>
            <ul>
              <li>Akun Anda akan ditinjau oleh Administrator dalam waktu singkat.</li>
              <li>Setelah disetujui, Anda dapat langsung login menggunakan username <strong><?= htmlspecialchars($this->session->flashdata('reg_user') ?: ''); ?></strong>.</li>
              <li>Anda dapat mengakses fitur lengkap: Penjualan Marketplace, POS Kasir, Manajemen Stok, CRM &amp; Analisis RFM.</li>
            </ul>
          </div>

          <a href="<?= site_url('administrator/login'); ?>" class="btn-submit" style="text-decoration: none; margin-top: 0;">
            <i class="fa fa-sign-in"></i> Menuju Halaman Login
          </a>

          <div style="margin-top: 14px;">
            <a href="<?= site_url(''); ?>" class="btn-secondary">
              <i class="fa fa-home"></i> Kembali ke Beranda
            </a>
          </div>
        </div>

      <?php else: ?>

        <!-- State: Form Pendaftaran Calon Customer -->
        <div class="brand-header">
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

          <div class="brand-badge">
            <span class="pill-dot"></span>
            <span>Akses Uji Coba Calon Customer</span>
          </div>

          <h1 class="card-title">Daftar Akun Testing Demo</h1>
          <p class="card-subtitle">
            Coba langsung seluruh modul bisnis MetaforaCRM: Penjualan Multi-Channel, Kasir Toko &amp; Beli Ulang via WhatsApp.
          </p>
        </div>

        <?php if (!empty($error)): ?>
          <div class="alert-box alert-danger">
            <i class="fa fa-exclamation-triangle"></i> <?= $error; ?>
          </div>
        <?php endif; ?>

        <?= form_open('administrator/register', ['id' => 'form_register', 'method' => 'POST']); ?>

          <div class="form-row">
            <div class="form-group">
              <label class="form-label">Nama Lengkap <span class="req">*</span></label>
              <div class="input-wrapper">
                <input type="text" class="form-input" name="full_name" placeholder="Contoh: Budi Santoso" value="<?= set_value('full_name'); ?>" required autofocus>
                <i class="fa fa-user input-icon"></i>
              </div>
            </div>

            <div class="form-group">
              <label class="form-label">Nama Bisnis / Toko <span class="req">*</span></label>
              <div class="input-wrapper">
                <input type="text" class="form-input" name="company_name" placeholder="Contoh: Toko Berkah Mandiri" value="<?= set_value('company_name'); ?>" required>
                <i class="fa fa-building input-icon"></i>
              </div>
            </div>
          </div>

          <div class="form-row">
            <div class="form-group">
              <label class="form-label">No. WhatsApp / HP <span class="req">*</span></label>
              <div class="input-wrapper">
                <input type="text" class="form-input" name="phone" placeholder="Contoh: 081234567890" value="<?= set_value('phone'); ?>" required>
                <i class="fa fa-whatsapp input-icon"></i>
              </div>
            </div>

            <div class="form-group">
              <label class="form-label">Email Bisnis <span class="req">*</span></label>
              <div class="input-wrapper">
                <input type="email" class="form-input" name="email" placeholder="nama@email.com" value="<?= set_value('email'); ?>" required>
                <i class="fa fa-envelope input-icon"></i>
              </div>
            </div>
          </div>

          <div class="form-row">
            <div class="form-group">
              <label class="form-label">Username Login <span class="req">*</span></label>
              <div class="input-wrapper">
                <input type="text" class="form-input" name="username" id="reg_username" placeholder="Contoh: budi_demo" value="<?= set_value('username'); ?>" pattern="^[a-zA-Z0-9_.-]+$" title="Gunakan kombinasi huruf, angka, titik atau underscore tanpa simbol @ atau spasi" required>
                <i class="fa fa-user-circle input-icon"></i>
              </div>
              <small id="username_hint" style="display: block; font-size: 11px; color: #64748B; margin-top: 5px; line-height: 1.4;">
                <i class="fa fa-info-circle" style="color: #10B981;"></i> Huruf &amp; angka saja (bukan email, tanpa simbol @). Contoh: <b>budi_demo</b>
              </small>
            </div>

            <div class="form-group">
              <label class="form-label">Password <span class="req">*</span></label>
              <div class="input-wrapper">
                <input type="password" class="form-input" name="password" placeholder="Minimal 5 karakter" required>
                <i class="fa fa-lock input-icon"></i>
              </div>
            </div>
          </div>

          <div class="notice-callout">
            <i class="fa fa-shield"></i>
            <span>Akun baru akan melalui proses peninjauan singkat oleh Admin untuk aktivasi akses testing demo.</span>
          </div>

          <button type="submit" class="btn-submit">
            <span>Ajukan Akun Demo Sekarang</span>
            <i class="fa fa-arrow-right"></i>
          </button>

        <?= form_close(); ?>

        <div class="card-footer-links">
          Sudah memiliki akun? <a href="<?= site_url('administrator/login'); ?>">Masuk ke Sistem di sini</a>
          <div style="margin-top: 10px;">
            <a href="<?= site_url(''); ?>">&larr; Kembali ke Beranda MetaforaCRM</a>
          </div>
        </div>

      <?php endif; ?>

    </div>
  </div>
  <script>
    const userField = document.getElementById('reg_username');
    const userHint = document.getElementById('username_hint');
    if (userField && userHint) {
      userField.addEventListener('input', function() {
        const val = this.value;
        if (val.includes('@')) {
          userHint.innerHTML = '<span style="color: #DC2626; font-weight: 600;"><i class="fa fa-exclamation-circle"></i> Jangan gunakan format email (@). Gunakan nama/angka saja!</span>';
          userField.style.borderColor = '#EF4444';
        } else if (/\s/.test(val)) {
          userHint.innerHTML = '<span style="color: #DC2626; font-weight: 600;"><i class="fa fa-exclamation-circle"></i> Username tidak boleh mengandung spasi.</span>';
          userField.style.borderColor = '#EF4444';
        } else {
          userHint.innerHTML = '<i class="fa fa-info-circle" style="color: #10B981;"></i> Huruf &amp; angka saja (bukan email, tanpa simbol @). Contoh: <b>budi_demo</b>';
          userField.style.borderColor = '';
        }
      });
    }
  </script>
</body>
</html>
