<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Metafora CRM - Aplikasi Pengelola Pelanggan & Beli Ulang via WhatsApp</title>
    <meta name="description" content="Kumpulkan data pembeli dari Toko Fisik, Shopee, dan Tokopedia jadi satu. Ingatkan pelanggan belanja lagi secara otomatis lewat WhatsApp tanpa ribet bersama Metafora CRM.">

    <!-- Google Fonts: Plus Jakarta Sans & Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@600;700;800&display=swap" rel="stylesheet">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#FFF1F2',
                            100: '#FFE4E6',
                            200: '#FECDD3',
                            500: '#F43F5E',
                            600: '#E11D48',
                            700: '#BE123C',
                            800: '#1E40AF',
                            900: '#1E3A8A',
                        },
                        accent: {
                            sky: '#FB7185',
                            whatsapp: '#25D366',
                            shopee: '#EE4D2D',
                            tokopedia: '#03AC0E',
                        },
                        dark: '#0F172A',
                    },
                    fontFamily: {
                        heading: ['"Plus Jakarta Sans"', 'sans-serif'],
                        sans: ['"Inter"', 'sans-serif'],
                    },
                    boxShadow: {
                        'soft-rose': '0 20px 40px -15px rgba(225, 29, 72, 0.25)',
                        'card': '0 10px 30px -5px rgba(15, 23, 42, 0.06)',
                        'floating': '0 25px 50px -12px rgba(15, 23, 42, 0.15)',
                    }
                }
            }
        }
    </script>

    <style>
        /* Loading & Preloader Animations */
        @keyframes loaderBar {
            0% { transform: translateX(-100%); }
            50% { transform: translateX(20%); }
            100% { transform: translateX(200%); }
        }
        .animate-loader-bar {
            animation: loaderBar 1.4s cubic-bezier(0.65, 0, 0.35, 1) infinite;
        }

        @keyframes pulseRing {
            0% { transform: scale(0.95); opacity: 0.8; }
            50% { transform: scale(1.08); opacity: 0.3; }
            100% { transform: scale(0.95); opacity: 0.8; }
        }
        .animate-pulse-ring {
            animation: pulseRing 2.2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }

        @keyframes spinSmooth {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        .animate-spin-smooth {
            animation: spinSmooth 1s linear infinite;
        }

        /* Smooth transitions & micro-animations */
        @keyframes floatSlow {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-8px); }
        }
        @keyframes floatDelayed {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-6px); }
        }
        .animate-float-slow {
            animation: floatSlow 4.5s ease-in-out infinite;
        }
        .animate-float-delayed {
            animation: floatDelayed 4s ease-in-out infinite 1.5s;
        }
        
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        /* Active navigation link & Hover Animations */
        .nav-link {
            position: relative;
            transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
            user-select: none;
        }
        .nav-link:hover {
            color: #E11D48 !important;
            background-color: #EFF6FF !important;
            transform: translateY(-1px);
        }
        .nav-link:active {
            transform: scale(0.96);
        }
        .nav-link.active {
            color: #E11D48 !important;
            background-color: #EFF6FF !important;
            font-weight: 700 !important;
        }
        .nav-link::after {
            content: '';
            position: absolute;
            bottom: -3px;
            left: 50%;
            transform: translateX(-50%) scaleX(0);
            width: 20px;
            height: 2.5px;
            background: linear-gradient(90deg, #E11D48, #FB7185);
            border-radius: 9999px;
            transition: transform 0.28s cubic-bezier(0.34, 1.56, 0.64, 1);
        }
        .nav-link:hover::after,
        .nav-link.active::after {
            transform: translateX(-50%) scaleX(1);
        }
        @keyframes navPop {
            0% { transform: scale(0.92); }
            50% { transform: scale(1.06); }
            100% { transform: scale(1); }
        }
        .nav-link.animate-pop {
            animation: navPop 0.32s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
        }
    </style>
</head>
<body class="bg-white text-slate-800 font-sans antialiased selection:bg-rose-600 selection:text-white">

    <!-- ================================================================= -->
    <!-- PRELOADER / ANIMASI LOADING RESMI METAFORA CRM                    -->
    <!-- ================================================================= -->
    <div id="page-preloader" style="background: rgba(255, 255, 255, 0.75) !important; backdrop-filter: blur(16px) !important; -webkit-backdrop-filter: blur(16px) !important;" class="fixed inset-0 z-[99999] flex flex-col items-center justify-center transition-all duration-500 ease-out select-none px-4">
        
        <!-- High-Contrast Elevated Preloader Card (Solid White Inside Blur Background) -->
        <div style="background-color: #ffffff !important;" class="relative w-full max-w-[340px] sm:max-w-[390px] bg-white rounded-3xl p-6 sm:p-8 shadow-[0_25px_60px_-15px_rgba(15,23,42,0.25)] border border-slate-100 flex flex-col items-center text-center">
            
            <!-- Animated Logo Icon with Rotating Spinner Halo -->
            <div class="relative w-20 h-20 flex items-center justify-center mb-4">
                <!-- Rotating Dual-Color Halo -->
                <div class="absolute inset-0 rounded-3xl border-2 border-transparent border-t-[#E11D48] border-r-indigo-500 animate-spin-smooth"></div>
                <!-- Soft Glow Ring Pulse -->
                <div class="absolute -inset-2 rounded-3xl border border-blue-400/30 animate-pulse-ring"></div>
                <!-- Core Logo Badge -->
                <div class="w-16 h-16 rounded-2xl bg-gradient-to-tr from-red-600 to-rose-600 flex items-center justify-center text-white shadow-lg shadow-red-600/25">
                    <svg class="w-8 h-8 text-white animate-bounce" style="animation-duration: 2s;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.3" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="9" cy="21" r="1"></circle>
                        <circle cx="20" cy="21" r="1"></circle>
                        <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                    </svg>
                </div>
            </div>

            <!-- Brand Name: Metafora CRM (High-Contrast & Crisp) -->
            <div class="flex items-center justify-center gap-1.5 font-heading">
                <span class="text-2xl sm:text-[26px] font-extrabold text-[#0F172A] tracking-tight">Metafora</span>
                <span class="text-2xl sm:text-[26px] font-extrabold text-rose-600 tracking-tight">CRM<span class="text-indigo-600">.</span></span>
            </div>
            <p class="text-xs sm:text-sm text-slate-500 font-semibold mt-1 leading-normal">Aplikasi Pengelola Pelanggan & Beli Ulang</p>

            <!-- Gradient Loading Progress Bar -->
            <div class="w-full max-w-[270px] sm:max-w-[310px] h-2.5 bg-slate-100 rounded-full mt-5 overflow-hidden relative shadow-inner p-0.5 border border-slate-200/60">
                <div id="preloader-progress-bar" class="h-full bg-gradient-to-r from-blue-600 via-indigo-500 to-sky-400 rounded-full transition-all duration-500 ease-out" style="width: 15%;"></div>
            </div>

            <!-- Micro Loading Indicator & Status Text (No Clipping/Truncation) -->
            <div class="flex items-center justify-between w-full max-w-[270px] sm:max-w-[310px] mt-3.5 text-xs">
                <div id="preloader-status-text" class="flex items-center gap-2 font-medium text-slate-700 min-w-0 pr-2">
                    <span class="w-2 h-2 rounded-full bg-rose-600 animate-ping shrink-0"></span>
                    <span class="font-bold text-slate-800 text-xs sm:text-[13px] whitespace-nowrap">Menyiapkan sistem...</span>
                </div>
                <span id="preloader-pct" class="text-xs font-black text-rose-600 bg-rose-50 px-2.5 py-0.5 rounded-full shrink-0">15%</span>
            </div>

        </div>
    </div>


    <!-- ================================================================= -->
    <!-- 1. STICKY NAVBAR (ShopTop / CRM Style)                           -->
    <!-- ================================================================= -->
    <header id="main-header" class="fixed top-0 left-0 right-0 z-50 transition-all duration-200 bg-white/95 backdrop-blur-md border-b border-slate-200/80 py-2.5 sm:py-3 shadow-xs">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between">
                
                <!-- Grup Kiri: Logo CRM + Menu Navigasi -->
                <div class="flex items-center gap-6 lg:gap-10">
                    <!-- Brand Logo -->
                    <a href="#hero" class="flex items-center gap-2 sm:gap-2.5 group shrink-0">
                        <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-2xl bg-gradient-to-tr from-red-600 to-rose-600 flex items-center justify-center text-white shadow-md shadow-red-600/20 group-hover:scale-105 transition-transform">
                            <!-- Shopping Cart SaaS Icon -->
                            <svg class="w-5 h-5 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.3" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="9" cy="21" r="1"></circle>
                                <circle cx="20" cy="21" r="1"></circle>
                                <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                            </svg>
                        </div>
                        <span class="font-extrabold text-lg sm:text-xl tracking-tight text-[#0F172A] font-heading">
                            Metafora<span class="text-rose-600">CRM</span>
                        </span>
                    </a>

                    <!-- Navigasi Menu Desktop -->
                    <nav class="hidden md:flex items-center gap-1.5 lg:gap-2">
                        <a href="#overview" class="nav-link px-3 py-1.5 rounded-lg text-sm font-semibold text-slate-700 hover:text-rose-600 transition-colors">Tentang</a>
                        <a href="#features" class="nav-link px-3 py-1.5 rounded-lg text-sm font-semibold text-slate-700 hover:text-rose-600 transition-colors">Fitur</a>
                        <a href="#pricing" class="nav-link px-3 py-1.5 rounded-lg text-sm font-semibold text-slate-700 hover:text-rose-600 transition-colors">Harga</a>
                        <a href="#testimonials" class="nav-link px-3 py-1.5 rounded-lg text-sm font-semibold text-slate-700 hover:text-rose-600 transition-colors">Testimoni</a>
                        <a href="#faq" class="nav-link px-3 py-1.5 rounded-lg text-sm font-semibold text-slate-700 hover:text-rose-600 transition-colors">FAQ</a>
                    </nav>
                </div>

                <!-- Aksi Kanan: Daftar Akun Baru & Login -->
                <div class="hidden md:flex items-center gap-2.5">
                    <a href="<?= base_url('administrator/register'); ?>" class="btn-action-loading inline-flex items-center gap-1.5 px-4 py-2 rounded-full font-bold text-xs text-rose-600 hover:bg-rose-50 transition-all font-heading">
                        <span class="btn-label">Daftar Demo Gratis</span>
                    </a>
                    <a href="<?= base_url('administrator/login'); ?>" class="btn-action-loading inline-flex items-center gap-2 px-5 py-2.5 rounded-full font-bold text-sm text-white bg-gradient-to-r from-red-600 to-rose-600 hover:from-red-700 hover:to-rose-700 shadow-md shadow-red-600/25 transition-all hover:scale-[1.02] active:scale-[0.98] font-heading group">
                        <span class="btn-label">Masuk Dashboard</span>
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                            <polyline points="12 5 19 12 12 19"></polyline>
                        </svg>
                    </a>
                </div>

                <!-- Tombol Mobile Menu Hamburger -->
                <button id="mobile-menu-btn" class="md:hidden p-2 rounded-xl text-slate-700 hover:bg-slate-100 transition-colors focus:outline-none" aria-label="Buka Menu">
                    <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="3" y1="12" x2="21" y2="12"></line>
                        <line x1="3" y1="6" x2="21" y2="6"></line>
                        <line x1="3" y1="18" x2="21" y2="18"></line>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile Drawer Menu (Smooth & Responsive) -->
        <div id="mobile-menu" class="hidden md:hidden px-4 pt-3 pb-5 border-t border-slate-100 bg-white/98 backdrop-blur-md shadow-xl rounded-b-2xl space-y-2">
            <a href="#overview" class="block px-3.5 py-2.5 rounded-xl text-sm font-semibold text-slate-700 hover:bg-rose-50 hover:text-rose-600 active:bg-blue-100 transition-colors mobile-item">Tentang</a>
            <a href="#features" class="block px-3.5 py-2.5 rounded-xl text-sm font-semibold text-slate-700 hover:bg-rose-50 hover:text-rose-600 active:bg-blue-100 transition-colors mobile-item">Fitur</a>
            <a href="#pricing" class="block px-3.5 py-2.5 rounded-xl text-sm font-semibold text-slate-700 hover:bg-rose-50 hover:text-rose-600 active:bg-blue-100 transition-colors mobile-item">Harga</a>
            <a href="#testimonials" class="block px-3.5 py-2.5 rounded-xl text-sm font-semibold text-slate-700 hover:bg-rose-50 hover:text-rose-600 active:bg-blue-100 transition-colors mobile-item">Testimoni</a>
            <a href="#faq" class="block px-3.5 py-2.5 rounded-xl text-sm font-semibold text-slate-700 hover:bg-rose-50 hover:text-rose-600 active:bg-blue-100 transition-colors mobile-item">FAQ</a>
            <div class="pt-3 border-t border-slate-100 space-y-2">
                <a href="<?= base_url('administrator/register'); ?>" class="btn-action-loading w-full text-center py-3 rounded-xl font-bold text-sm text-white bg-gradient-to-r from-red-600 to-rose-600 block shadow-md shadow-red-600/25 font-heading">
                    <span class="btn-label">Daftar Akun Baru &rarr;</span>
                </a>
                <a href="<?= base_url('administrator/login'); ?>" class="btn-action-loading w-full text-center py-2.5 rounded-xl font-bold text-sm text-rose-600 bg-rose-50 hover:bg-blue-100 block font-heading">
                    <span class="btn-label">Login ke Sistem &rarr;</span>
                </a>
            </div>
        </div>
    </header>

    <!-- ================================================================= -->
    <!-- 2. HERO SECTION (Solid Royal Blue Canvas dengan Lengkungan Bawah)-->
    <!-- ================================================================= -->
    <section id="hero" class="relative pt-20 sm:pt-24 pb-12 sm:pb-16 bg-gradient-to-b from-[#070C1B] via-[#0B132B] to-[#0B132B] text-white rounded-b-[36px] sm:rounded-b-[64px] shadow-2xl overflow-hidden">
        
        <!-- Ambient Radial Glow Effects di dalam Hero Canvas -->
        <div class="absolute top-0 right-0 -mr-20 -mt-20 w-96 h-96 rounded-full bg-rose-600/15 blur-3xl pointer-events-none"></div>
        <div class="absolute bottom-10 left-10 w-80 h-80 rounded-full bg-red-600/10 blur-3xl pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-center">
                
                <!-- Kolom Kiri: Copywriting Headline & Tombol CTA (Standard SaaS Flow) -->
                <div class="lg:col-span-6 text-center lg:text-left">
                    
                    <!-- Pill Tagline Kategori -->
                    <div class="inline-flex items-center gap-2 px-3 sm:px-4 py-1 sm:py-1.5 rounded-full bg-white/15 backdrop-blur-md border border-white/20 shadow-xs mb-4 sm:mb-5 max-w-full">
                        <span class="w-2 h-2 rounded-full bg-rose-500 animate-ping shrink-0"></span>
                        <span class="text-[10px] sm:text-xs font-bold tracking-tight sm:tracking-wider text-rose-300 uppercase font-heading truncate sm:overflow-visible">
                            APLIKASI CRM & PENGINGAT REPEAT ORDER OTOMATIS
                        </span>
                    </div>

                    <!-- Headline Kuat ShopTop Style -->
                    <h1 class="text-2xl sm:text-4xl lg:text-[44px] xl:text-5xl font-extrabold text-white tracking-tight leading-[1.2] sm:leading-[1.15] mb-4 sm:mb-5 font-heading">
                        Cara Termudah Bikin Pembeli Balik Belanja Lagi di <span class="text-rose-400">Toko Anda.</span>
                    </h1>

                    <!-- Sub-headline -->
                    <p class="text-sm sm:text-base lg:text-lg text-slate-300 leading-relaxed mb-6 sm:mb-7 max-w-xl mx-auto lg:mx-0">
                        Kumpulkan data pembeli dari Kasir Toko, Shopee, dan Tokopedia ke dalam satu tempat. Kirim pesan WhatsApp otomatis saat produk pelanggan diperkirakan habis, agar mereka langsung belanja lagi.
                    </p>

                    <!-- Tombol Aksi CTA Ganda -->
                    <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-center lg:justify-start gap-3 sm:gap-3.5 mb-6">
                        <!-- Tombol Utama: Mulai Sekarang -->
                        <a href="<?= base_url('administrator/register'); ?>" class="btn-action-loading w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 sm:px-7 py-3 sm:py-3.5 rounded-full font-extrabold text-white bg-gradient-to-r from-red-600 to-rose-600 hover:from-red-700 hover:to-rose-700 shadow-md shadow-red-600/25 transition-all hover:-translate-y-0.5 active:translate-y-0 text-sm sm:text-base font-heading">
                            <span class="btn-label">Mulai Sekarang</span>
                            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"></polyline></svg>
                        </a>

                        <!-- Tombol Kedua: Tanya Tim Kami via WA -->
                        <a href="https://wa.me/6282230700567?text=Halo%20Admin%20Metafora%20CRM%2C%20saya%20ingin%20tanya-tanya%20tentang%20aplikasi%20CRM%20toko." target="_blank" rel="noopener noreferrer" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-5 sm:px-6 py-3 sm:py-3.5 rounded-full font-bold text-white bg-white/10 hover:bg-white/20 border border-white/20 backdrop-blur-xs transition-all text-sm sm:text-base">
                            <svg class="w-4 h-4 text-emerald-400 fill-current shrink-0" viewBox="0 0 448 512">
                                <path d="M380.9 97.1C339 55.1 283.2 32 223.9 32c-122.4 0-222 99.6-222 222 0 39.1 10.2 77.3 29.6 111L0 480l117.7-30.9c32.4 17.7 68.9 27 106.1 27h.1c122.3 0 224.1-99.6 224.1-222 0-59.3-25.2-115-67.1-157zm-157 341.6c-33.2 0-65.7-8.9-94-25.7l-6.7-4-69.8 18.3L72 359.2l-4.4-7c-18.5-29.4-28.2-63.3-28.2-98.2 0-101.7 82.8-184.5 184.6-184.5 49.3 0 95.6 19.2 130.4 54.1 34.8 34.9 56.2 81.2 56.1 130.5 0 101.8-84.9 184.6-186.6 184.6zm101.2-138.2c-5.5-2.8-32.8-16.2-37.9-18-5.1-1.9-8.8-2.8-12.5 2.8-3.7 5.6-14.3 18-17.6 21.8-3.2 3.7-6.5 4.2-12 1.4-32.6-16.3-54-29.1-75.5-66-5.7-9.8 5.7-9.1 16.3-30.3 1.8-3.7.9-6.9-.5-9.7-1.4-2.8-12.5-30.1-17.1-41.2-4.5-10.8-9.1-9.3-12.5-9.5-3.2-.2-6.9-.2-10.6-.2-3.7 0-9.7 1.4-14.8 6.9-5.1 5.6-19.4 19-19.4 46.3 0 27.3 19.9 53.7 22.6 57.4 2.8 3.7 39.1 59.7 94.8 83.8 35.2 15.2 49 16.5 66.6 13.9 10.7-1.6 32.8-13.4 37.4-26.4 4.6-13 4.6-24.1 3.2-26.4-1.3-2.5-5-3.9-10.5-6.6z"/>
                            </svg>
                            <span>Tanya Tim Kami via WA</span>
                        </a>
                    </div>

                    <!-- Bukti Kepercayaan Rating Bintang 5 -->
                    <div class="flex flex-wrap items-center justify-center lg:justify-start gap-2 sm:gap-3">
                        <div class="flex text-amber-300 text-sm">★★★★★</div>
                        <span class="text-xs text-slate-300 text-center sm:text-left">
                            Dipercaya <strong class="text-white">200+ Pemilik Toko &amp; Brand</strong> di Indonesia
                        </span>
                    </div>

                </div>

                <!-- Kolom Kanan: Visual Mockup Showcase (Figma ShopTop Style) -->
                <div class="lg:col-span-6 flex items-center justify-center">
                    <div class="relative w-full max-w-[480px] sm:max-w-[500px] py-2 sm:py-4 select-none mx-auto">
                        
                        <!-- Visual Container Utama (Kartu Dashboard Showcase - Dark Theme) -->
                        <div class="relative bg-[#111827] rounded-3xl p-4 sm:p-6 border border-slate-800 shadow-2xl">
                            
                            <!-- Header Mini Bar Mockup -->
                            <div class="flex items-center justify-between pb-3 mb-3.5 border-b border-slate-800">
                                <div class="flex items-center gap-1.5 sm:gap-2">
                                    <div class="w-2.5 h-2.5 sm:w-3 sm:h-3 rounded-full bg-red-500"></div>
                                    <div class="w-2.5 h-2.5 sm:w-3 sm:h-3 rounded-full bg-amber-400"></div>
                                    <div class="w-2.5 h-2.5 sm:w-3 sm:h-3 rounded-full bg-emerald-400"></div>
                                    <span class="text-[11px] sm:text-xs font-bold text-white ml-1.5 sm:ml-2 font-heading tracking-wide">DATA PENJUALAN TERKUMPUL</span>
                                </div>
                                <span class="px-2 sm:px-2.5 py-0.5 rounded-full bg-slate-800 border border-slate-700 text-[9px] sm:text-[10px] font-bold text-slate-300">
                                    ● Aktif Otomatis
                                </span>
                            </div>

                            <!-- Showcase Konten: Profil Pelanggan & Alur Otomasi -->
                            <div class="space-y-3">
                                <!-- Pelanggan Card -->
                                <div class="bg-white rounded-2xl p-3 sm:p-4 text-slate-800 shadow-lg border border-slate-100 flex items-center justify-between gap-2">
                                    <div class="flex items-center gap-2.5 sm:gap-3 min-w-0">
                                        <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-full overflow-hidden shrink-0 border-2 border-amber-300 ring-2 ring-white shadow-sm bg-rose-50 flex items-center justify-center">
                                            <img src="<?= base_url('asset/img/aditya_pratama.jpg'); ?>" 
                                                 onerror="this.onerror=null; this.src='<?= base_url('asset/img/richard_hegarty.png'); ?>';" 
                                                 alt="Aditya Pratama" 
                                                 class="w-full h-full object-cover">
                                        </div>
                                        <div class="min-w-0">
                                            <div class="text-xs sm:text-sm font-extrabold text-[#0F172A] font-heading truncate">Aditya Pratama</div>
                                            <div class="flex items-center gap-1 mt-0.5 flex-wrap">
                                                <span class="px-1.5 py-0.5 rounded bg-rose-100 text-[#E11D48] text-[9px] sm:text-[10px] font-bold">Shopee &amp; Kasir Toko</span>
                                                <span class="text-[10px] sm:text-[11px] text-slate-500 font-medium">• Surabaya</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-right shrink-0">
                                        <div class="text-[10px] sm:text-xs text-slate-500 font-medium">Total Belanja</div>
                                        <div class="text-xs sm:text-sm font-extrabold text-[#0F172A] font-heading">Rp 4.850.000</div>
                                    </div>
                                </div>

                                <!-- Pesan Otomasi WhatsApp WAHA -->
                                <div class="bg-white rounded-2xl p-3 sm:p-3.5 text-slate-800 shadow-md border border-slate-100">
                                    <div class="flex items-center gap-2 mb-1.5">
                                        <div class="w-4 h-4 sm:w-5 sm:h-5 rounded-full bg-emerald-500 text-white flex items-center justify-center text-[9px] sm:text-[10px] shrink-0 font-bold">
                                            ✓
                                        </div>
                                        <span class="text-[10px] sm:text-[11px] font-bold text-slate-700">Pengingat WhatsApp Otomatis (Tiap 30 Hari)</span>
                                    </div>
                                    <div class="bg-slate-50 p-2 sm:p-2.5 rounded-xl border border-slate-200 text-[11px] sm:text-xs text-slate-600 leading-relaxed">
                                        "Halo Kak Aditya! Serum wajah yang dibeli sebulan lalu mungkin sudah mau habis nih. Khusus hari ini kami siapkan <span class="font-bold text-rose-600">Diskon 15%</span> untuk pemesanan ulang ya 🎁"
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- FLOATING CARD 1: Sumber Pembeli (Dark Theme) -->
                        <div class="absolute -top-4 -right-2 sm:-right-5 bg-[#111827] p-2.5 sm:p-3 rounded-2xl shadow-2xl border border-slate-800 text-white animate-float-slow hidden sm:flex items-center gap-3 z-20">
                            <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl bg-slate-800/80 flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5 sm:w-6 sm:h-6" viewBox="0 0 36 36">
                                    <circle cx="18" cy="18" r="14" fill="none" stroke="#F97316" stroke-width="5" stroke-dasharray="45 55" stroke-dashoffset="25"></circle>
                                    <circle cx="18" cy="18" r="14" fill="none" stroke="#10B981" stroke-width="5" stroke-dasharray="30 70" stroke-dashoffset="80"></circle>
                                    <circle cx="18" cy="18" r="14" fill="none" stroke="#E11D48" stroke-width="5" stroke-dasharray="25 75" stroke-dashoffset="50"></circle>
                                </svg>
                            </div>
                            <div>
                                <div class="text-[9px] sm:text-[10px] font-bold uppercase tracking-wider text-slate-400">Sumber Pembeli</div>
                                <div class="text-xs font-extrabold text-white font-heading">Shopee &amp; Kasir Jadi Satu</div>
                            </div>
                        </div>

                        <!-- FLOATING CARD 2: Repeat Order Closing (Dark Theme) -->
                        <div class="absolute -bottom-3 sm:-bottom-4 left-2 sm:-left-5 max-w-[calc(100%-16px)] sm:max-w-none bg-[#111827] p-2.5 sm:p-3.5 rounded-2xl shadow-2xl border border-slate-800 text-white animate-float-delayed flex items-center gap-2.5 sm:gap-3 z-20">
                            <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-xl bg-rose-950/60 text-rose-500 flex items-center justify-center shrink-0 border border-rose-900/40">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="23 6 13.5 15.5 8.5 10.5 1 18"></polyline>
                                    <polyline points="17 6 23 6 23 12"></polyline>
                                </svg>
                            </div>
                            <div>
                                <div class="text-[9px] sm:text-[10px] font-bold uppercase tracking-wider text-slate-400">Pembelian Ulang</div>
                                <div class="text-xs font-extrabold text-rose-400 font-heading">Pembeli Beli Lagi Naik 3x Lipat</div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- ================================================================= -->
    <!-- 3. FLOATING METRIC STRIP (Kartu Metrik Melintang Antar Section)   -->
    <!-- ================================================================= -->
    <div class="max-w-5xl mx-auto px-4 sm:px-6 -mt-8 sm:-mt-14 relative z-30">
        <div class="bg-white rounded-2xl sm:rounded-3xl p-5 sm:p-8 shadow-xl border border-slate-100 grid grid-cols-1 md:grid-cols-3 gap-4 sm:gap-6 md:gap-8 divide-y md:divide-y-0 md:divide-x divide-slate-100 text-center">
            
            <!-- Metric 1: Users / Pelanggan -->
            <div class="flex items-center justify-center gap-3.5 sm:gap-4 py-2 md:py-0">
                <div class="w-11 h-11 sm:w-12 sm:h-12 rounded-2xl bg-rose-50 text-rose-600 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                        <circle cx="9" cy="7" r="4"></circle>
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                        <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                    </svg>
                </div>
                <div class="text-left">
                    <div class="text-2xl sm:text-3xl font-extrabold text-[#0F172A] font-heading">50.000+</div>
                    <div class="text-xs sm:text-sm font-semibold text-slate-500">Kontak Pembeli Tercatat Rapi</div>
                </div>
            </div>

            <!-- Metric 2: Locations / Brand & Ritel -->
            <div class="flex items-center justify-center gap-3.5 sm:gap-4 pt-4 pb-2 md:py-0 md:pl-6">
                <div class="w-11 h-11 sm:w-12 sm:h-12 rounded-2xl bg-rose-50 text-rose-600 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                        <circle cx="12" cy="10" r="3"></circle>
                    </svg>
                </div>
                <div class="text-left">
                    <div class="text-2xl sm:text-3xl font-extrabold text-[#0F172A] font-heading">200+</div>
                    <div class="text-xs sm:text-sm font-semibold text-slate-500">Toko &amp; Brand Menggunakan</div>
                </div>
            </div>

            <!-- Metric 3: Servers / Kenaikan Repeat Order -->
            <div class="flex items-center justify-center gap-3.5 sm:gap-4 pt-4 pb-2 md:py-0 md:pl-6">
                <div class="w-11 h-11 sm:w-12 sm:h-12 rounded-2xl bg-rose-50 text-rose-600 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="2" y="2" width="20" height="8" rx="2" ry="2"></rect>
                        <rect x="2" y="14" width="20" height="8" rx="2" ry="2"></rect>
                        <line x1="6" y1="6" x2="6.01" y2="6"></line>
                        <line x1="6" y1="18" x2="6.01" y2="18"></line>
                    </svg>
                </div>
                <div class="text-left">
                    <div class="text-2xl sm:text-3xl font-extrabold text-[#0F172A] font-heading">+310%</div>
                    <div class="text-xs sm:text-sm font-semibold text-slate-500">Pembeli Belanja Lagi</div>
                </div>
            </div>

        </div>
    </div>

    <!-- ================================================================= -->
    <!-- 4. OVERVIEW SECTION ("Gak Perlu Cek Banyak Aplikasi")             -->
    <!-- ================================================================= -->
    <section id="overview" class="pt-12 sm:pt-14 pb-6 sm:pb-8 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-14 items-center">
                
                <!-- Teks Pengantar -->
                <div class="lg:col-span-6 space-y-6 text-center lg:text-left">
                    <span class="text-xs font-bold uppercase tracking-widest text-rose-600 font-heading">
                        SATUKAN SEMUA PENJUALAN
                    </span>
                    <h2 class="text-2xl sm:text-4xl font-extrabold text-[#0F172A] tracking-tight leading-tight font-heading">
                        Gak Perlu Cek Banyak Aplikasi.<br>
                        <span class="text-rose-600">Semua Data Pembeli Ada di Satu Tempat.</span>
                    </h2>
                    <p class="text-base text-slate-600 leading-relaxed">
                        Mulai dari riwayat belanja pembeli, perkiraan kapan barang mereka habis, sampai kirim pesan sapaan otomatis. Semua nomor WhatsApp pembeli tersimpan rapi milik toko Anda sendiri, jadi tidak takut hilang saat ganti admin atau ganti kasir.
                    </p>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2 text-left">
                        <div class="p-4 rounded-2xl bg-slate-50/80 border border-slate-200/70 shadow-xs hover:border-blue-300 hover:bg-rose-50/20 transition-all">
                            <div class="w-8 h-8 rounded-xl bg-orange-100 text-[#EA580C] flex items-center justify-center font-bold text-sm mb-2">
                                🏬
                            </div>
                            <div class="font-bold text-slate-800 text-sm">Toko Fisik & Shopee</div>
                            <div class="text-xs text-slate-500 mt-1">Data pembeli dari kasir toko dan Shopee langsung terhubung ke nomor WhatsApp yang sama.</div>
                        </div>

                        <div class="p-4 rounded-2xl bg-slate-50/80 border border-slate-200/70 shadow-xs hover:border-blue-300 hover:bg-rose-50/20 transition-all">
                            <div class="w-8 h-8 rounded-xl bg-emerald-100 text-[#059669] flex items-center justify-center font-bold text-sm mb-2">
                                💬
                            </div>
                            <div class="font-bold text-slate-800 text-sm">Kirim WA Otomatis Bernama</div>
                            <div class="text-xs text-slate-500 mt-1">Kirim pesan WhatsApp pengingat otomatis dengan menyebut nama pembeli satu per satu tanpa repot kirim manual.</div>
                        </div>
                    </div>
                </div>

                <!-- Showcase Ilustrasi Keranjang Pintar -->
                <div class="lg:col-span-6 flex items-center justify-center">
                    <div class="relative w-full max-w-md bg-gradient-to-tr from-blue-600 to-indigo-600 rounded-3xl p-8 text-white shadow-2xl">
                        <div class="absolute -top-4 -right-4 w-20 h-20 bg-sky-400 rounded-full blur-2xl opacity-50"></div>
                        
                        <div class="flex items-center justify-between mb-6">
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 rounded-xl bg-white/20 flex items-center justify-center font-black">
                                    🛒
                                </div>
                                <span class="font-extrabold text-lg tracking-tight font-heading">Catatan Pembeli Pintar</span>
                            </div>
                            <span class="px-2.5 py-1 rounded-full bg-white/20 text-xs font-bold">Bebas Dobel</span>
                        </div>

                        <div class="space-y-3">
                            <div class="bg-white/10 backdrop-blur-md p-3.5 rounded-xl flex items-center justify-between border border-white/10">
                                <div class="flex items-center gap-2.5">
                                    <span class="w-2 h-2 rounded-full bg-orange-400"></span>
                                    <span class="text-xs font-bold">Belanja di Shopee #SHP-9921</span>
                                </div>
                                <span class="text-xs font-bold text-emerald-300">Tersimpan</span>
                            </div>

                            <div class="bg-white/10 backdrop-blur-md p-3.5 rounded-xl flex items-center justify-between border border-white/10">
                                <div class="flex items-center gap-2.5">
                                    <span class="w-2 h-2 rounded-full bg-blue-400"></span>
                                    <span class="text-xs font-bold">Belanja di Kasir Toko #POS-1044</span>
                                </div>
                                <span class="text-xs font-bold text-emerald-300">Tersimpan</span>
                            </div>

                            <div class="bg-white/10 backdrop-blur-md p-3.5 rounded-xl flex items-center justify-between border border-white/10">
                                <div class="flex items-center gap-2.5">
                                    <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                                    <span class="text-xs font-bold">Pesan WA Pengingat Belanja</span>
                                </div>
                                <span class="text-xs font-bold text-sky-300">Siap Terkirim</span>
                            </div>
                        </div>

                        <div class="mt-6 pt-4 border-t border-white/15 flex items-center justify-between text-xs text-blue-100">
                            <span>Jadwal Beli Lagi: 30 Hari Sekali</span>
                            <span class="font-bold text-white">Peluang Beli Ulang: Sangat Tinggi</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- ================================================================= -->
    <!-- 5. FITUR UTAMA (Kontainer Biru Elegan dengan 3 Kartu Berilustrasi) -->
    <!-- ================================================================= -->
    <section id="features" class="pt-10 sm:pt-12 pb-8 sm:pb-10 bg-[#E11D48] text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            
            <!-- Section Header -->
            <span class="text-xs font-bold uppercase tracking-widest text-sky-200 font-heading">
                FITUR SEDERHANA & AMPUH
            </span>
            <h2 class="text-3xl sm:text-4xl font-extrabold tracking-tight mt-2 mb-3 font-heading">
                Cara Mudah Bikin Pelanggan Belanja Terus
            </h2>
            <p class="text-blue-100 max-w-2xl mx-auto mb-8 sm:mb-10 text-base sm:text-lg">
                Dibuat khusus untuk Anda yang punya toko fisik atau jualan online agar tidak repot kirim pesan pengingat satu per satu secara manual.
            </p>

            <!-- 3 Kolom Kartu Fitur (Gaya ShopTop Features) -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                
                <!-- Kartu 1: Ingatkan Pembeli -->
                <div class="bg-white rounded-3xl p-7 text-slate-800 shadow-xl flex flex-col justify-between hover:-translate-y-1.5 transition-transform duration-300">
                    <div>
                        <!-- Header Banner Ilustrasi Simpel: Pengingat WhatsApp -->
                        <div class="w-full h-52 rounded-2xl mb-6 relative overflow-hidden bg-gradient-to-br from-blue-50/80 via-indigo-50/50 to-purple-50/70 border border-indigo-100/70 p-4 flex flex-col justify-center items-center shadow-inner group">
                            <!-- Mini WA Reminder Card -->
                            <div class="w-full max-w-[280px] bg-white rounded-2xl p-3.5 shadow-md border border-slate-100/80 transform group-hover:scale-[1.02] transition-transform duration-300 text-left">
                                <div class="flex items-center justify-between mb-2 pb-1.5 border-b border-slate-50">
                                    <div class="flex items-center gap-2">
                                        <div class="w-7 h-7 rounded-full bg-[#25D366] flex items-center justify-center text-white shadow-xs">
                                            <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 448 512"><path d="M380.9 97.1C339 55.1 283.2 32 223.9 32c-122.4 0-222 99.6-222 222 0 39.1 10.2 77.3 29.6 111L0 480l117.7-30.9c32.4 17.7 68.9 27 106.1 27h.1c122.3 0 224.1-99.6 224.1-222 0-59.3-25.2-115-67.1-157zm-157 341.6c-33.2 0-65.7-8.9-94-25.7l-6.7-4-69.8 18.3L72 359.2l-4.4-7c-18.5-29.4-28.2-63.3-28.2-98.2 0-101.7 82.8-184.5 184.6-184.5 49.3 0 95.6 19.2 130.4 54.1 34.8 34.9 56.2 81.2 56.1 130.5 0 101.8-84.9 184.6-186.6 184.6zm101.2-138.2c-5.5-2.8-32.8-16.2-37.9-18-5.1-1.9-8.8-2.8-12.5 2.8-3.7 5.6-14.3 18-17.6 21.8-3.2 3.7-6.5 4.2-12 1.4-32.6-16.3-54-29.1-75.5-66-5.7-9.8 5.7-9.1 16.3-30.3 1.8-3.7.9-6.9-.5-9.7-1.4-2.8-12.5-30.1-17.1-41.2-4.5-10.8-9.1-9.3-12.5-9.5-3.2-.2-6.9-.2-10.6-.2-3.7 0-9.7 1.4-14.8 6.9-5.1 5.6-19.4 19-19.4 46.3 0 27.3 19.9 53.7 22.6 57.4 2.8 3.7 39.1 59.7 94.8 83.8 35.2 15.2 49 16.5 66.6 13.9 10.7-1.6 32.8-13.4 37.4-26.4 4.6-13 4.6-24.1 3.2-26.4-1.3-2.5-5-3.9-10.5-6.6z"/></svg>
                                        </div>
                                        <div>
                                            <div class="text-[11px] font-bold text-slate-800 leading-tight">Pengingat WhatsApp</div>
                                            <div class="text-[9px] text-emerald-600 font-medium">● Otomatis H-3</div>
                                        </div>
                                    </div>
                                    <span class="text-[9px] text-slate-400">09.41</span>
                                </div>
                                <div class="bg-emerald-50/70 border border-emerald-100 rounded-xl p-2 text-left mb-2">
                                    <p class="text-[10px] text-slate-700 leading-snug">
                                        "Halo Kak Sarah! Sabun wajah Anda kira-kira mau habis nih. Mau diisi ulang sekarang? Ada diskon 10% lho 😊"
                                    </p>
                                </div>
                                <div class="flex items-center gap-1.5 justify-end">
                                    <span class="px-2 py-0.5 rounded-md bg-[#E11D48] text-[9px] font-bold text-white shadow-xs">Pesan Ulang →</span>
                                </div>
                            </div>
                        </div>
                        <h3 class="text-xl font-extrabold text-[#0F172A] font-heading mb-3 text-left">
                            Ingatkan Pembeli di Waktu yang Pas
                        </h3>
                        <p class="text-sm text-slate-600 leading-relaxed text-left">
                            Sistem otomatis menghitung kapan barang yang dibeli pelanggan biasanya habis. Begitu waktunya tiba, pesan WhatsApp otomatis terkirim menawarkan promo isi ulang.
                        </p>
                    </div>
                    <div class="pt-6 mt-6 border-t border-slate-100 text-left">
                        <span class="text-xs font-bold text-rose-600 inline-flex items-center gap-1">
                            Lihat Cara Kerjanya →
                        </span>
                    </div>
                </div>

                <!-- Kartu 2: Pantau Penjualan -->
                <div class="bg-white rounded-3xl p-7 text-slate-800 shadow-xl flex flex-col justify-between hover:-translate-y-1.5 transition-transform duration-300">
                    <div>
                        <!-- Header Banner Ilustrasi Simpel: Grafik Omzet Simpel -->
                        <div class="w-full h-52 rounded-2xl mb-6 relative overflow-hidden bg-gradient-to-br from-emerald-50/80 via-teal-50/50 to-green-50/70 border border-emerald-100/70 p-4 flex flex-col justify-center items-center shadow-inner group">
                            <!-- Mini Sales Analytics Card -->
                            <div class="w-full max-w-[280px] bg-white rounded-2xl p-3.5 shadow-md border border-slate-100/80 transform group-hover:scale-[1.02] transition-transform duration-300 text-left">
                                <div class="flex items-center justify-between mb-1">
                                    <span class="text-[10px] font-bold uppercase tracking-wider text-slate-500">Omzet Toko Bulan Ini</span>
                                    <span class="px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-700 text-[10px] font-extrabold">▲ +28%</span>
                                </div>
                                <div class="text-lg font-black text-white font-heading mb-2">
                                    Rp 128.450.000
                                </div>
                                <!-- Bar Chart Sederhana & Bersih -->
                                <div class="flex items-end justify-between gap-2 h-14 pt-2 border-t border-slate-100">
                                    <div class="flex-1 flex flex-col items-center gap-1">
                                        <div class="w-full bg-emerald-200 rounded-t-md h-5"></div>
                                        <span class="text-[9px] text-slate-400">Mg 1</span>
                                    </div>
                                    <div class="flex-1 flex flex-col items-center gap-1">
                                        <div class="w-full bg-emerald-300 rounded-t-md h-7"></div>
                                        <span class="text-[9px] text-slate-400">Mg 2</span>
                                    </div>
                                    <div class="flex-1 flex flex-col items-center gap-1">
                                        <div class="w-full bg-emerald-400 rounded-t-md h-10"></div>
                                        <span class="text-[9px] text-slate-400">Mg 3</span>
                                    </div>
                                    <div class="flex-1 flex flex-col items-center gap-1">
                                        <div class="w-full bg-emerald-500 rounded-t-md h-14 shadow-xs"></div>
                                        <span class="text-[9px] font-bold text-emerald-600">Mg 4</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <h3 class="text-xl font-extrabold text-[#0F172A] font-heading mb-3 text-left">
                            Pantau Penjualan Tanpa Ribet
                        </h3>
                        <p class="text-sm text-slate-600 leading-relaxed text-left">
                            Lihat berapa total omzet dari Shopee, Tokopedia, dan kasir toko Anda dalam satu layar yang gampang dipahami. Anda langsung tahu produk apa yang paling laris dibeli lagi.
                        </p>
                    </div>
                    <div class="pt-6 mt-6 border-t border-slate-100 text-left">
                        <span class="text-xs font-bold text-rose-600 inline-flex items-center gap-1">
                            Lihat Contoh Laporan →
                        </span>
                    </div>
                </div>

                <!-- Kartu 3: Balas dari HP -->
                <div class="bg-white rounded-3xl p-7 text-slate-800 shadow-xl flex flex-col justify-between hover:-translate-y-1.5 transition-transform duration-300">
                    <div>
                        <!-- Header Banner Ilustrasi Simpel: Chat Balas dari HP -->
                        <div class="w-full h-52 rounded-2xl mb-6 relative overflow-hidden bg-gradient-to-br from-amber-50/80 via-orange-50/50 to-yellow-50/70 border border-amber-100/70 p-4 flex flex-col justify-center items-center shadow-inner group">
                            <!-- Mini Mobile CRM Chat Card -->
                            <div class="w-full max-w-[280px] bg-white rounded-2xl p-3.5 shadow-md border border-slate-100/80 transform group-hover:scale-[1.02] transition-transform duration-300 text-left">
                                <div class="flex items-center justify-between pb-1.5 mb-2 border-b border-slate-100">
                                    <div class="flex items-center gap-2">
                                        <div class="w-6 h-6 rounded-full bg-orange-100 text-orange-600 font-bold text-[10px] flex items-center justify-center">
                                            📱
                                        </div>
                                        <span class="text-[11px] font-bold text-slate-800">Chat WhatsApp dari HP</span>
                                    </div>
                                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                                </div>
                                <div class="space-y-1.5 text-left mb-2">
                                    <div class="bg-slate-100 rounded-lg rounded-tl-none p-1.5 max-w-[85%]">
                                        <p class="text-[10px] text-slate-700 leading-tight">"Kak, pesanan kopi arabika saya sudah dikirim?"</p>
                                    </div>
                                    <div class="bg-[#E11D48] text-white rounded-lg rounded-tr-none p-1.5 max-w-[85%] ml-auto text-right">
                                        <p class="text-[10px] leading-tight">"Sudah kak, resi kurir otomatis masuk ke WA ya! 👍"</p>
                                    </div>
                                </div>
                                <div class="flex items-center justify-between pt-1 text-[9px] text-slate-400">
                                    <span>✓ Buka dari browser HP</span>
                                    <span class="text-emerald-600 font-semibold">Respon Cepat</span>
                                </div>
                            </div>
                        </div>
                        <h3 class="text-xl font-extrabold text-[#0F172A] font-heading mb-3 text-left">
                            Pantau & Balas dari HP Kapan Saja
                        </h3>
                        <p class="text-sm text-slate-600 leading-relaxed text-left">
                            Mau dari rumah, di perjalanan, atau lagi cek toko cabang, Anda dan tim tetap bisa melihat daftar pembeli dan membalas pesan WhatsApp pelanggan langsung dari smartphone tanpa perlu buka laptop.
                        </p>
                    </div>
                    <div class="pt-6 mt-6 border-t border-slate-100 text-left">
                        <span class="text-xs font-bold text-rose-600 inline-flex items-center gap-1">
                            Coba Buka di HP →
                        </span>
                    </div>
                </div>

            </div>

        </div>
    </section>

    <!-- ================================================================= -->
    <!-- 6. PRICING & MATRIX SECTION (Bahasa Sederhana & Transparan)     -->
    <!-- ================================================================= -->
    <section id="pricing" class="pt-8 sm:pt-10 pb-10 sm:pb-12 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            
            <!-- Section Header -->
            <span class="text-xs font-bold uppercase tracking-widest text-rose-600 font-heading">
                HARGA JUJUR & TERJANGKAU
            </span>
            <h2 class="text-3xl sm:text-4xl font-extrabold text-[#0F172A] tracking-tight mt-2 mb-3 font-heading">
                Pilih Paket yang Pas untuk Toko Anda
            </h2>
            <p class="text-slate-600 max-w-xl mx-auto mb-6 text-base">
                Tanpa biaya tambahan tersembunyi. Tidak ada kontrak yang mengikat. Anda bebas berhenti atau ganti paket kapan saja.
            </p>

            <!-- Toggle Switch Bulanan / Tahunan -->
            <div class="inline-flex items-center p-1.5 rounded-full bg-slate-100 border border-slate-200 mb-8 sm:mb-10">
                <button id="toggle-monthly" class="px-5 py-2 rounded-full text-xs sm:text-sm font-extrabold text-white bg-[#E11D48] shadow-sm transition-all font-heading">
                    BAYAR BULANAN
                </button>
                <button id="toggle-yearly" class="px-5 py-2 rounded-full text-xs sm:text-sm font-extrabold text-slate-600 hover:text-white transition-all font-heading flex items-center gap-1.5">
                    <span>BAYAR TAHUNAN</span>
                    <span class="px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-700 text-[10px] font-bold">Hemat 20%</span>
                </button>
            </div>

            <!-- 3 Kartu Paket Harga (Figma ShopTop Style) -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-6xl mx-auto items-stretch mb-10 sm:mb-12">
                
                <!-- Paket 1: Pemula -->
                <div class="rounded-3xl p-8 bg-slate-50 border border-slate-200/90 flex flex-col justify-between text-left hover:border-blue-400 transition-colors">
                    <div>
                        <div class="text-xs font-bold text-slate-400 uppercase tracking-wider font-heading">Paket Pemula</div>
                        <h3 class="text-xl font-extrabold text-[#0F172A] font-heading mt-1 mb-4">Toko Baru / 1 Toko</h3>
                        <div class="mb-6">
                            <div class="flex items-baseline gap-1">
                                <span class="text-3xl sm:text-4xl font-extrabold text-[#0F172A] font-heading price-starter">Rp 249.000</span>
                                <span class="text-xs text-slate-500 font-medium">/bulan</span>
                            </div>
                            <div class="text-[11px] text-slate-500 font-medium mt-1 note-starter">Ditagih bulanan</div>
                        </div>
                        <p class="text-xs text-slate-600 leading-relaxed mb-6">
                            Cocok untuk Anda yang punya 1 toko fisik atau 1 toko online yang ingin mulai merapikan nomor WhatsApp pelanggan.
                        </p>
                        <ul class="space-y-3 text-xs text-slate-700">
                            <li class="flex items-center gap-2">
                                <span class="text-emerald-500 font-bold">✓</span> Muat sampai 2.000 Kontak Pembeli
                            </li>
                            <li class="flex items-center gap-2">
                                <span class="text-emerald-500 font-bold">✓</span> Import Data Penjualan dari 1 Toko (Shopee atau Kasir Toko)
                            </li>
                            <li class="flex items-center gap-2">
                                <span class="text-emerald-500 font-bold">✓</span> Laporan Penjualan Simpel & Jelas
                            </li>
                            <li class="flex items-center gap-2 text-slate-400">
                                <span>—</span> Kirim WhatsApp Pengingat Otomatis
                            </li>
                        </ul>
                    </div>
                    <div class="pt-8 mt-6">
                        <a href="<?= base_url('administrator/register'); ?>" class="btn-action-loading w-full text-center py-3 rounded-full font-bold text-xs text-slate-800 bg-white hover:bg-slate-100 border border-slate-300 block transition-all shadow-xs">
                            <span class="btn-label">Daftar Paket Pemula</span>
                        </a>
                    </div>
                </div>

                <!-- Paket 2: Paling Laris (Featured / Highlighted) -->
                <div class="rounded-3xl p-8 bg-gradient-to-b from-blue-50/70 via-white to-white border-2 border-[#E11D48] shadow-2xl relative flex flex-col justify-between text-left hover:scale-[1.02] transition-transform">
                    <div class="absolute -top-3.5 left-1/2 -translate-x-1/2 px-4 py-1 rounded-full bg-[#E11D48] text-white text-[11px] font-black uppercase tracking-wider font-heading shadow-md">
                        Paling Banyak Dipilih
                    </div>
                    <div>
                        <div class="text-xs font-bold text-rose-600 uppercase tracking-wider font-heading mt-1">Paket Paling Laris</div>
                        <h3 class="text-xl font-extrabold text-[#0F172A] font-heading mt-1 mb-4">Toko Ramai & Banyak Cabang</h3>
                        <div class="mb-6">
                            <div class="flex items-baseline gap-1">
                                <span class="text-3xl sm:text-4xl font-extrabold text-rose-600 font-heading price-pro">Rp 599.000</span>
                                <span class="text-xs text-slate-500 font-medium">/bulan</span>
                            </div>
                            <div class="text-[11px] text-rose-600 font-semibold mt-1 note-pro">Ditagih bulanan</div>
                        </div>
                        <p class="text-xs text-slate-600 leading-relaxed mb-6">
                            Pilihan terbaik untuk toko yang aktif jualan di Shopee, Tokopedia, dan kasir toko fisik sekaligus agar pembeli selalu kembali.
                        </p>
                        <ul class="space-y-3 text-xs text-slate-700">
                            <li class="flex items-center gap-2">
                                <span class="text-emerald-500 font-bold">✓</span> Muat sampai 25.000 Kontak Pembeli
                            </li>
                            <li class="flex items-center gap-2">
                                <span class="text-emerald-500 font-bold">✓</span> Import Data Shopee + Tokopedia + Kasir Toko Fisik
                            </li>
                            <li class="flex items-center gap-2">
                                <span class="text-emerald-500 font-bold">✓</span> Kirim WhatsApp Pengingat Otomatis
                            </li>
                            <li class="flex items-center gap-2">
                                <span class="text-emerald-500 font-bold">✓</span> Pengingat Otomatis Saat Barang Pelanggan Mau Habis
                            </li>
                            <li class="flex items-center gap-2">
                                <span class="text-emerald-500 font-bold">✓</span> Kelompokkan Otomatis Pembeli Baru & Pelanggan Setia
                            </li>
                        </ul>
                    </div>
                    <div class="pt-8 mt-6">
                        <a href="<?= base_url('administrator/register'); ?>" class="btn-action-loading w-full text-center py-3 rounded-full font-bold text-xs text-white bg-[#E11D48] hover:bg-[#BE123C] block transition-all shadow-md shadow-red-600/25">
                            <span class="btn-label">Daftar Paket Terlaris Sekarang</span>
                        </a>
                    </div>
                </div>

                <!-- Paket 3: Paket Lengkap (Enterprise) -->
                <div class="rounded-3xl p-8 bg-slate-50 border border-slate-200/90 flex flex-col justify-between text-left hover:border-blue-400 transition-colors">
                    <div>
                        <div class="text-xs font-bold text-slate-400 uppercase tracking-wider font-heading">Paket Lengkap</div>
                        <h3 class="text-xl font-extrabold text-[#0F172A] font-heading mt-1 mb-4">Bisnis Besar & Banyak Cabang</h3>
                        <div class="mb-6">
                            <div class="flex items-baseline gap-1">
                                <span class="text-3xl sm:text-4xl font-extrabold text-[#0F172A] font-heading price-enterprise">Rp 1.499.000</span>
                                <span class="text-xs text-slate-500 font-medium">/bulan</span>
                            </div>
                            <div class="text-[11px] text-slate-500 font-medium mt-1 note-enterprise">Ditagih bulanan</div>
                        </div>
                        <p class="text-xs text-slate-600 leading-relaxed mb-6">
                            Untuk pemilik jaringan toko besar dengan puluhan cabang, volume pesanan tinggi, dan butuh pendampingan khusus.
                        </p>
                        <ul class="space-y-3 text-xs text-slate-700">
                            <li class="flex items-center gap-2">
                                <span class="text-emerald-500 font-bold">✓</span> Kontak Pembeli Tanpa Batas
                            </li>
                            <li class="flex items-center gap-2">
                                <span class="text-emerald-500 font-bold">✓</span> Bebas Tambah Cabang & Outlet Berapapun
                            </li>
                            <li class="flex items-center gap-2">
                                <span class="text-emerald-500 font-bold">✓</span> Jalur WhatsApp Khusus Super Cepat
                            </li>
                            <li class="flex items-center gap-2">
                                <span class="text-emerald-500 font-bold">✓</span> Sambungkan ke Sistem Logistik & Program Lain
                            </li>
                            <li class="flex items-center gap-2">
                                <span class="text-emerald-500 font-bold">✓</span> Staf Ahli Khusus Siap Bantu Kapan Saja
                            </li>
                        </ul>
                    </div>
                    <div class="pt-8 mt-6">
                        <a href="https://wa.me/6282230700567?text=Halo%2C%20saya%20ingin%20tanya%20paket%20lengkap%20CRM%20untuk%20toko%20besar." target="_blank" class="w-full text-center py-3 rounded-full font-bold text-xs text-slate-800 bg-white hover:bg-slate-100 border border-slate-300 block transition-all shadow-xs">
                            Hubungi Tim Paket Lengkap
                        </a>
                    </div>
                </div>

            </div>


            <!-- Matriks Komparasi Fitur Lengkap (Feature Comparison Table) -->
            <div class="max-w-5xl mx-auto text-left mt-6 sm:mt-8">
                <h3 class="text-lg font-extrabold text-[#0F172A] font-heading mb-4 text-center">
                    Tabel Perbandingan Fitur Paket
                </h3>
                <div class="overflow-x-auto rounded-2xl border border-slate-200 bg-white shadow-xs">
                    <table class="w-full text-xs text-left">
                        <thead class="bg-slate-50 text-slate-700 font-heading font-extrabold border-b border-slate-200">
                            <tr>
                                <th class="p-3.5 sm:p-4">Fitur & Kemampuan</th>
                                <th class="p-3.5 sm:p-4 text-center">Pemula</th>
                                <th class="p-3.5 sm:p-4 text-center text-rose-600">Paling Laris</th>
                                <th class="p-3.5 sm:p-4 text-center">Paket Lengkap</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-slate-600">
                            <tr>
                                <td class="p-3.5 sm:p-4 font-semibold text-slate-800">Nomor HP Pembeli Rapi & Bebas Dobel</td>
                                <td class="p-3.5 sm:p-4 text-center text-emerald-600 font-bold">✓</td>
                                <td class="p-3.5 sm:p-4 text-center text-emerald-600 font-bold">✓</td>
                                <td class="p-3.5 sm:p-4 text-center text-emerald-600 font-bold">✓</td>
                            </tr>
                            <tr>
                                <td class="p-3.5 sm:p-4 font-semibold text-slate-800">Import Data Penjualan Shopee & Tokopedia (Excel)</td>
                                <td class="p-3.5 sm:p-4 text-center text-slate-400">—</td>
                                <td class="p-3.5 sm:p-4 text-center text-emerald-600 font-bold">✓</td>
                                <td class="p-3.5 sm:p-4 text-center text-emerald-600 font-bold">✓</td>
                            </tr>
                            <tr>
                                <td class="p-3.5 sm:p-4 font-semibold text-slate-800">Tersambung Otomatis ke Kasir Toko Fisik</td>
                                <td class="p-3.5 sm:p-4 text-center text-emerald-600 font-bold">✓</td>
                                <td class="p-3.5 sm:p-4 text-center text-emerald-600 font-bold">✓</td>
                                <td class="p-3.5 sm:p-4 text-center text-emerald-600 font-bold">✓</td>
                            </tr>
                            <tr>
                                <td class="p-3.5 sm:p-4 font-semibold text-slate-800">Kirim WhatsApp Pengingat Otomatis</td>
                                <td class="p-3.5 sm:p-4 text-center text-slate-400">—</td>
                                <td class="p-3.5 sm:p-4 text-center text-emerald-600 font-bold">✓</td>
                                <td class="p-3.5 sm:p-4 text-center text-emerald-600 font-bold">✓</td>
                            </tr>
                            <tr>
                                <td class="p-3.5 sm:p-4 font-semibold text-slate-800">Tebak Otomatis Kapan Barang Pembeli Habis</td>
                                <td class="p-3.5 sm:p-4 text-center text-slate-400">—</td>
                                <td class="p-3.5 sm:p-4 text-center text-emerald-600 font-bold">✓</td>
                                <td class="p-3.5 sm:p-4 text-center text-emerald-600 font-bold">✓</td>
                            </tr>
                            <tr>
                                <td class="p-3.5 sm:p-4 font-semibold text-slate-800">Bantuan & Customer Service</td>
                                <td class="p-3.5 sm:p-4 text-center text-slate-400">Email</td>
                                <td class="p-3.5 sm:p-4 text-center text-emerald-600 font-bold">WhatsApp Prioritas Cepat</td>
                                <td class="p-3.5 sm:p-4 text-center text-emerald-600 font-bold">Staf Ahli Khusus 24 Jam</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </section>

    <!-- ================================================================= -->
    <!-- 7. TESTIMONIALS SECTION (Cerita dari Pemilik Toko)             -->
    <!-- ================================================================= -->
    <section id="testimonials" class="pt-8 sm:pt-10 pb-10 sm:pb-12 bg-white border-t border-slate-100">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            
            <span class="text-xs font-bold uppercase tracking-widest text-rose-600 font-heading">
                CERITA DARI PEMILIK TOKO
            </span>
            <h2 class="text-3xl sm:text-4xl font-extrabold text-[#0F172A] tracking-tight mt-2 mb-3 font-heading">
                Apa Kata Mereka yang Sudah Pakai?
            </h2>
            <p class="text-slate-600 text-sm sm:text-base max-w-xl mx-auto mb-8 sm:mb-10">
                Kisah nyata dari para pemilik toko retail, fashion, kosmetik, dan jualan online yang berhasil menaikkan pembelian ulang.
            </p>

            <!-- 3 Kolom Review Pelanggan (Tanpa Gambar - Menggunakan Inisial Monogram Bersih) -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-left items-stretch">
                
                <!-- Review 1: Kosmetik & Skincare -->
                <div class="bg-white rounded-3xl p-6 sm:p-7 shadow-lg shadow-slate-100/80 border border-slate-200/80 flex flex-col justify-between hover:-translate-y-1.5 hover:shadow-xl hover:border-blue-300 transition-all duration-300">
                    <div>
                        <!-- Bintang & Status -->
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex text-amber-400 text-sm">★★★★★</div>
                            <span class="inline-flex items-center gap-1 text-[11px] font-bold text-emerald-600 bg-emerald-50 px-2.5 py-0.5 rounded-full border border-emerald-200/60">
                                <svg class="w-3 h-3 fill-current" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                                Pengguna Aktif
                            </span>
                        </div>

                        <!-- Kutipan Review -->
                        <p class="text-xs sm:text-sm text-slate-700 leading-relaxed mb-6 font-normal">
                            "Dulu pusing mencatat nomor WhatsApp pembeli karena data dari kasir toko fisik dan toko Shopee terpisah-pisah. Sekarang semua kontak otomatis rapi. Pesan pengingat otomatisnya bikin pelanggan rajin balik belanja sampai 3 kali lipat!"
                        </p>
                    </div>

                    <!-- Inisial Monogram (Tanpa Gambar) -->
                    <div class="flex items-center gap-3 pt-4 border-t border-slate-100">
                        <div class="w-10 h-10 rounded-full bg-blue-100 text-rose-600 font-extrabold flex items-center justify-center text-sm font-heading shrink-0 shadow-xs">
                            HK
                        </div>
                        <div>
                            <div class="text-sm font-extrabold text-[#0F172A] font-heading leading-tight">Hendra Kusuma</div>
                            <div class="text-[11px] text-slate-500 font-medium mt-0.5">Toko GlowSkin Retail • Surabaya</div>
                        </div>
                    </div>
                </div>

                <!-- Review 2: Busana & Fashion -->
                <div class="bg-white rounded-3xl p-6 sm:p-7 shadow-lg shadow-slate-100/80 border border-slate-200/80 flex flex-col justify-between hover:-translate-y-1.5 hover:shadow-xl hover:border-blue-300 transition-all duration-300">
                    <div>
                        <!-- Bintang & Status -->
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex text-amber-400 text-sm">★★★★★</div>
                            <span class="inline-flex items-center gap-1 text-[11px] font-bold text-emerald-600 bg-emerald-50 px-2.5 py-0.5 rounded-full border border-emerald-200/60">
                                <svg class="w-3 h-3 fill-current" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                                Pengguna Aktif
                            </span>
                        </div>

                        <!-- Kutipan Review -->
                        <p class="text-xs sm:text-sm text-slate-700 leading-relaxed mb-6 font-normal">
                            "Tiap ada pergantian kasir atau admin toko, biasanya nomor WhatsApp pembeli ikut tercecer di HP lama. Sejak pakai sistem ini, data pembeli 100% aman tersimpan rapi milik toko. Upload laporan Excel penjualan bulanan juga praktis cuma 1 klik."
                        </p>
                    </div>

                    <!-- Inisial Monogram (Tanpa Gambar) -->
                    <div class="flex items-center gap-3 pt-4 border-t border-slate-100">
                        <div class="w-10 h-10 rounded-full bg-indigo-100 text-indigo-700 font-extrabold flex items-center justify-center text-sm font-heading shrink-0 shadow-xs">
                            SR
                        </div>
                        <div>
                            <div class="text-sm font-extrabold text-[#0F172A] font-heading leading-tight">Siti Rahmawati</div>
                            <div class="text-[11px] text-slate-500 font-medium mt-0.5">Busana Al-Madina • Bandung</div>
                        </div>
                    </div>
                </div>

                <!-- Review 3: F&B / Kopi Retail -->
                <div class="bg-white rounded-3xl p-6 sm:p-7 shadow-lg shadow-slate-100/80 border border-slate-200/80 flex flex-col justify-between hover:-translate-y-1.5 hover:shadow-xl hover:border-blue-300 transition-all duration-300">
                    <div>
                        <!-- Bintang & Status -->
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex text-amber-400 text-sm">★★★★★</div>
                            <span class="inline-flex items-center gap-1 text-[11px] font-bold text-emerald-600 bg-emerald-50 px-2.5 py-0.5 rounded-full border border-emerald-200/60">
                                <svg class="w-3 h-3 fill-current" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                                Pengguna Aktif
                            </span>
                        </div>

                        <!-- Kutipan Review -->
                        <p class="text-xs sm:text-sm text-slate-700 leading-relaxed mb-6 font-normal">
                            "Fitur tebak kapan produk pembeli habis sangat manjur. Pas stok kopi langganan diperkirakan tinggal 2 hari, WhatsApp pengingat otomatis terkirim dengan ramah. Pelanggan merasa senang dan sangat diperhatikan, jualan jadi lancar terus."
                        </p>
                    </div>

                    <!-- Inisial Monogram (Tanpa Gambar) -->
                    <div class="flex items-center gap-3 pt-4 border-t border-slate-100">
                        <div class="w-10 h-10 rounded-full bg-emerald-100 text-emerald-700 font-extrabold flex items-center justify-center text-sm font-heading shrink-0 shadow-xs">
                            BS
                        </div>
                        <div>
                            <div class="text-sm font-extrabold text-[#0F172A] font-heading leading-tight">Budi Santoso</div>
                            <div class="text-[11px] text-slate-500 font-medium mt-0.5">Kopi Roastery Nusantara • Jakarta</div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </section>

    <!-- ================================================================= -->
    <!-- 7.5 FAQ SECTION (Tanya Jawab Seputar Layanan)                   -->
    <!-- ================================================================= -->
    <section id="faq" class="pt-8 sm:pt-10 pb-10 sm:pb-12 bg-white border-t border-slate-100">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-8 sm:mb-10">
                <span class="text-xs font-bold uppercase tracking-widest text-rose-600 font-heading">
                    TANYA JAWAB SANTAI (FAQ)
                </span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-[#0F172A] tracking-tight mt-2 mb-3 font-heading">
                    Pertanyaan yang Sering Ditanyakan
                </h2>
                <p class="text-slate-600 text-sm sm:text-base max-w-xl mx-auto">
                    Jawaban praktis dan jelas seputar cara kerja pengingat WhatsApp, import data marketplace, dan keamanan nomor kontak pembeli Anda.
                </p>
            </div>

            <div class="space-y-4">
                <!-- FAQ Item 1 -->
                <div class="border border-slate-200 rounded-2xl p-5 hover:border-blue-300 transition-colors bg-slate-50/50">
                    <button class="w-full flex items-center justify-between text-left font-extrabold text-[#0F172A] font-heading text-sm sm:text-base faq-toggle" onclick="toggleFaq(this)">
                        <span>Bagaimana cara memasukkan data penjualan dari Shopee, Tokopedia, dan kasir toko?</span>
                        <span class="text-xl text-rose-600 ml-3 font-mono transform transition-transform duration-200 faq-icon">+</span>
                    </button>
                    <div class="mt-3 text-xs sm:text-sm text-slate-600 leading-relaxed hidden faq-answer border-t border-slate-100 pt-3">
                        Sangat mudah dan praktis! Anda tidak perlu repot menyambungkan akun toko. Cukup download file laporan pesanan (Excel/CSV) dari Seller Center Shopee, Tokopedia, atau TikTok Shop, lalu upload/import ke dalam sistem CRM. Data nomor WhatsApp, nama pembeli, dan barang belanjaan langsung tersimpan rapi secara otomatis. Untuk kasir toko fisik, data transaksi otomatis tercatat langsung dari kasir.
                    </div>
                </div>

                <!-- FAQ Item 2 -->
                <div class="border border-slate-200 rounded-2xl p-5 hover:border-blue-300 transition-colors bg-slate-50/50">
                    <button class="w-full flex items-center justify-between text-left font-extrabold text-[#0F172A] font-heading text-sm sm:text-base faq-toggle" onclick="toggleFaq(this)">
                        <span>Apakah nomor WhatsApp toko saya aman dari risiko blokir (banned)?</span>
                        <span class="text-xl text-rose-600 ml-3 font-mono transform transition-transform duration-200 faq-icon">+</span>
                    </button>
                    <div class="mt-3 text-xs sm:text-sm text-slate-600 leading-relaxed hidden faq-answer border-t border-slate-100 pt-3">
                        Sangat aman. Sistem CRM menggunakan jalur resmi WhatsApp Business serta mengatur jeda pengiriman pesan secara wajar (tidak membombardir serentak seperti spam). Pesan yang dikirim juga ramah dan personal karena hanya ditujukan ke pelanggan yang memang pernah belanja di toko Anda.
                    </div>
                </div>

                <!-- FAQ Item 3 -->
                <div class="border border-slate-200 rounded-2xl p-5 hover:border-blue-300 transition-colors bg-slate-50/50">
                    <button class="w-full flex items-center justify-between text-left font-extrabold text-[#0F172A] font-heading text-sm sm:text-base faq-toggle" onclick="toggleFaq(this)">
                        <span>Bagaimana sistem tahu kapan harus mengirim pesan pengingat belanja ulang?</span>
                        <span class="text-xl text-rose-600 ml-3 font-mono transform transition-transform duration-200 faq-icon">+</span>
                    </button>
                    <div class="mt-3 text-xs sm:text-sm text-slate-600 leading-relaxed hidden faq-answer border-t border-slate-100 pt-3">
                        Anda bisa menentukan perkiraan waktu habis produk dengan mudah. Misalnya, jika pelanggan membeli produk perawatan atau kopi yang biasa habis dalam 30 hari, sistem otomatis mengirim pesan sapaan ramah di hari ke-27 untuk mengingatkan stoknya yang hampir habis.
                    </div>
                </div>

                <!-- FAQ Item 4 -->
                <div class="border border-slate-200 rounded-2xl p-5 hover:border-blue-300 transition-colors bg-slate-50/50">
                    <button class="w-full flex items-center justify-between text-left font-extrabold text-[#0F172A] font-heading text-sm sm:text-base faq-toggle" onclick="toggleFaq(this)">
                        <span>Saya sudah punya ribuan kontak pelanggan di Excel atau HP, apakah bisa dipindahkan ke sini?</span>
                        <span class="text-xl text-rose-600 ml-3 font-mono transform transition-transform duration-200 faq-icon">+</span>
                    </button>
                    <div class="mt-3 text-xs sm:text-sm text-slate-600 leading-relaxed hidden faq-answer border-t border-slate-100 pt-3">
                        Tentu saja bisa. Anda cukup mengunggah file Excel atau CSV kontak yang sudah ada hanya dalam 1 kali klik. Sistem juga otomatis merapikan nomor yang ganda (dobel) agar pesan tidak terkirim dua kali ke orang yang sama.
                    </div>
                </div>

                <!-- FAQ Item 5 -->
                <div class="border border-slate-200 rounded-2xl p-5 hover:border-blue-300 transition-colors bg-slate-50/50">
                    <button class="w-full flex items-center justify-between text-left font-extrabold text-[#0F172A] font-heading text-sm sm:text-base faq-toggle" onclick="toggleFaq(this)">
                        <span>Apakah aplikasi ini cocok untuk toko kecil atau yang baru punya 1 toko online?</span>
                        <span class="text-xl text-rose-600 ml-3 font-mono transform transition-transform duration-200 faq-icon">+</span>
                    </button>
                    <div class="mt-3 text-xs sm:text-sm text-slate-600 leading-relaxed hidden faq-answer border-t border-slate-100 pt-3">
                        Sangat cocok. Mulai dari toko yang baru merintis hingga bisnis dengan banyak cabang bisa menggunakannya. Mengumpulkan kontak pembeli sejak awal justru membuat toko Anda lebih cepat berkembang tanpa harus terus-menerus keluar biaya iklan mahal.
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ================================================================= -->
    <!-- 8. BOTTOM BANNER CTA ("Siap Bikin Pelanggan Belanja Lagi?")        -->
    <!-- ================================================================= -->
    <section class="py-8 sm:py-10 bg-white">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="relative bg-gradient-to-r from-[#BE123C] via-[#E11D48] to-indigo-600 rounded-3xl p-8 sm:p-14 text-white text-center shadow-2xl overflow-hidden">
                <div class="absolute -top-16 -right-16 w-60 h-60 bg-sky-400 rounded-full blur-3xl opacity-40"></div>
                
                <div class="relative z-10 max-w-2xl mx-auto">
                    <h2 class="text-2xl sm:text-4xl font-extrabold tracking-tight leading-tight mb-4 font-heading">
                        Siap Bikin Pelanggan Belanja Lagi ke Toko Anda?
                    </h2>
                    <p class="text-blue-100 text-sm sm:text-base leading-relaxed mb-8">
                        Mulai rapikan data pembeli toko kasir & jualan online Anda hari ini. Nikmati kenaikan omzet tanpa perlu terus-terusan keluar uang untuk biaya iklan.
                    </p>
                    
                    <div class="flex flex-col sm:flex-row items-center justify-center gap-3.5">
                        <a href="<?= base_url('administrator/register'); ?>" class="btn-action-loading w-full sm:w-auto px-8 py-3.5 rounded-full font-extrabold text-white bg-[#FB7185] hover:bg-[#7dd3fc] shadow-lg shadow-sky-900/30 transition-all font-heading text-sm inline-flex items-center justify-center gap-2">
                            <span class="btn-label">Daftar Akun Sekarang &rarr;</span>
                        </a>
                        <a href="<?= base_url('administrator/login'); ?>" class="btn-action-loading w-full sm:w-auto px-6 py-3.5 rounded-full font-bold text-white bg-white/10 hover:bg-white/20 border border-white/30 transition-all text-sm inline-flex items-center justify-center gap-2">
                            <span class="btn-label">Masuk ke Dashboard</span>
                        </a>
                        <a href="https://wa.me/6282230700567?text=Halo%20Admin%2C%20saya%20ingin%20tanya-tanya%20dulu%20soal%20aplikasi%20CRM%20toko." target="_blank" class="w-full sm:w-auto px-6 py-3.5 rounded-full font-medium text-blue-100 hover:text-white hover:bg-white/10 transition-all text-sm">
                            Tanya via WhatsApp
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ================================================================= -->
    <!-- 9. FOOTER LENGKAP (Blue Royal Theme)                              -->
    <!-- ================================================================= -->
    <footer class="bg-[#1E3A8A] pt-10 sm:pt-12 pb-8 text-blue-100 text-xs sm:text-sm border-t border-blue-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-5 gap-8 sm:gap-10 pb-8 border-b border-white/10">
                
                <!-- Kolom 1: Brand & Keterangan Singkat -->
                <div class="md:col-span-2 space-y-4">
                    <div class="flex items-center gap-2.5">
                        <div class="w-9 h-9 rounded-xl bg-white/15 backdrop-blur-md border border-white/20 flex items-center justify-center text-white font-bold shadow-xs">
                            🛒
                        </div>
                        <span class="font-extrabold text-xl tracking-tight text-white font-heading">
                            Metafora <span class="text-[#FB7185]">CRM.</span>
                        </span>
                    </div>

                    <p class="text-blue-100/80 leading-relaxed max-w-sm text-xs">
                        Aplikasi pengelola pembeli dan pengingat belanja ulang via WhatsApp untuk pemilik toko dan bisnis ritel di Indonesia.
                    </p>
                    <div class="text-xs text-blue-200/60">
                        Didukung oleh sistem Metafora ERP.
                    </div>
                </div>

                <!-- Kolom 2: Navigasi Halaman -->
                <div>
                    <h4 class="font-extrabold text-white font-heading mb-4 uppercase tracking-wider text-xs">Menu Cepat</h4>
                    <ul class="space-y-2.5 text-xs text-blue-100/75">
                        <li><a href="#hero" class="hover:text-white transition-colors">Beranda</a></li>
                        <li><a href="#overview" class="hover:text-white transition-colors">Tentang Sistem</a></li>
                        <li><a href="#features" class="hover:text-white transition-colors">Fitur Toko</a></li>
                        <li><a href="#pricing" class="hover:text-white transition-colors">Paket Harga</a></li>
                    </ul>
                </div>

                <!-- Kolom 3: Fitur & Modul -->
                <div>
                    <h4 class="font-extrabold text-white font-heading mb-4 uppercase tracking-wider text-xs">Kemampuan Utama</h4>
                    <ul class="space-y-2.5 text-xs text-blue-100/75">
                        <li><a href="#features" class="hover:text-white transition-colors">Toko Fisik & Shopee</a></li>
                        <li><a href="#features" class="hover:text-white transition-colors">Kasir POS & Tokopedia</a></li>
                        <li><a href="#features" class="hover:text-white transition-colors">Pengingat WhatsApp Otomatis</a></li>
                        <li><a href="#features" class="hover:text-white transition-colors">Kelompokkan Pelanggan</a></li>
                    </ul>
                </div>

                <!-- Kolom 4: Bantuan & Kontak -->
                <div>
                    <h4 class="font-extrabold text-white font-heading mb-4 uppercase tracking-wider text-xs">Bantuan & Kontak</h4>
                    <ul class="space-y-2.5 text-xs text-blue-100/75">
                        <li><a href="https://wa.me/6282230700567" target="_blank" class="hover:text-white transition-colors">Chat Tim Support WA</a></li>
                        <li><a href="#faq" class="hover:text-white transition-colors">Tanya Jawab (FAQ)</a></li>
                        <li><a href="<?= base_url('administrator/register'); ?>" class="hover:text-white transition-colors font-bold text-sky-300">Daftar Akun Baru</a></li>
                        <li><a href="<?= base_url('administrator/login'); ?>" class="hover:text-white transition-colors">Masuk ke Akun Toko</a></li>
                        <li><span class="text-blue-200/50">Sistem Selalu Aktif 24 Jam</span></li>
                    </ul>
                </div>

            </div>

            <!-- Baris Bawah Copyright -->
            <div class="pt-5 flex flex-col sm:flex-row items-center justify-between text-xs text-blue-200/60 gap-4">
                <div>
                    &copy; <?= date('Y'); ?> Metafora CRM. Hak Cipta Dilindungi Undang-Undang.
                </div>
                <div class="flex items-center gap-6">
                    <a href="#" class="hover:text-white transition-colors">Kebijakan Privasi</a>
                    <a href="#" class="hover:text-white transition-colors">Syarat & Ketentuan</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- ================================================================= -->
    <!-- INTERACTIVE JAVASCRIPT (Toggle Harga & Menu Mobile)                -->
    <!-- ================================================================= -->
    <script>
        // Toggle Menu Mobile Drawer
        const mobileMenuBtn = document.getElementById('mobile-menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');
        if (mobileMenuBtn && mobileMenu) {
            mobileMenuBtn.addEventListener('click', () => {
                mobileMenu.classList.toggle('hidden');
            });
            document.querySelectorAll('.mobile-item').forEach(item => {
                item.addEventListener('click', () => mobileMenu.classList.add('hidden'));
            });
        }

        // Pricing Toggle: Bulanan vs Tahunan (Hemat 20%)
        const toggleMonthly = document.getElementById('toggle-monthly');
        const toggleYearly = document.getElementById('toggle-yearly');
        const priceStarter = document.querySelector('.price-starter');
        const pricePro = document.querySelector('.price-pro');
        const priceEnterprise = document.querySelector('.price-enterprise');
        const noteStarter = document.querySelector('.note-starter');
        const notePro = document.querySelector('.note-pro');
        const noteEnterprise = document.querySelector('.note-enterprise');

        if (toggleMonthly && toggleYearly) {
            toggleMonthly.addEventListener('click', () => {
                toggleMonthly.className = "px-5 py-2 rounded-full text-xs sm:text-sm font-extrabold text-white bg-[#E11D48] shadow-sm transition-all font-heading";
                toggleYearly.className = "px-5 py-2 rounded-full text-xs sm:text-sm font-extrabold text-slate-600 hover:text-white transition-all font-heading flex items-center gap-1.5";
                
                if (priceStarter) priceStarter.textContent = "Rp 249.000";
                if (pricePro) pricePro.textContent = "Rp 599.000";
                if (priceEnterprise) priceEnterprise.textContent = "Rp 1.499.000";

                if (noteStarter) noteStarter.textContent = "Ditagih bulanan";
                if (notePro) notePro.textContent = "Ditagih bulanan";
                if (noteEnterprise) noteEnterprise.textContent = "Ditagih bulanan";
            });

            toggleYearly.addEventListener('click', () => {
                toggleYearly.className = "px-5 py-2 rounded-full text-xs sm:text-sm font-extrabold text-white bg-[#E11D48] shadow-sm transition-all font-heading flex items-center gap-1.5";
                toggleMonthly.className = "px-5 py-2 rounded-full text-xs sm:text-sm font-extrabold text-slate-600 hover:text-white transition-all font-heading";
                
                // Diskon 20% tahunan dalam Rupiah
                if (priceStarter) priceStarter.textContent = "Rp 199.000";
                if (pricePro) pricePro.textContent = "Rp 479.000";
                if (priceEnterprise) priceEnterprise.textContent = "Rp 1.199.000";

                if (noteStarter) noteStarter.textContent = "Ditagih Rp 2.388.000/thn (Hemat Rp 600.000)";
                if (notePro) notePro.textContent = "Ditagih Rp 5.748.000/thn (Hemat Rp 1.440.000)";
                if (noteEnterprise) noteEnterprise.textContent = "Ditagih Rp 14.388.000/thn (Hemat Rp 3.600.000)";
            });
        }

        // FAQ Accordion Toggle Function
        function toggleFaq(btn) {
            const answer = btn.nextElementSibling;
            const icon = btn.querySelector('.faq-icon');
            if (answer.classList.contains('hidden')) {
                answer.classList.remove('hidden');
                icon.textContent = '−';
            } else {
                answer.classList.add('hidden');
                icon.textContent = '+';
            }
        }

        // Smooth Scrolling, Pop Animation & ScrollSpy for Navbar Links
        const navLinks = document.querySelectorAll('.nav-link');
        const spySections = [
            { id: 'overview' },
            { id: 'features' },
            { id: 'pricing' },
            { id: 'testimonials' },
            { id: 'faq' }
        ];
        let isNavClicking = false;
        let navClickTimeout = null;

        function triggerNavPop(link) {
            link.classList.remove('animate-pop');
            void link.offsetWidth; // trigger reflow for animation restart
            link.classList.add('animate-pop');
        }

        navLinks.forEach(link => {
            link.addEventListener('click', (e) => {
                const href = link.getAttribute('href');
                if (href && href.startsWith('#')) {
                    const targetEl = document.querySelector(href);
                    if (targetEl) {
                        e.preventDefault();
                        isNavClicking = true;
                        clearTimeout(navClickTimeout);

                        navLinks.forEach(l => l.classList.remove('active'));
                        link.classList.add('active');
                        triggerNavPop(link);

                        const headerOffset = 70;
                        const elementPosition = targetEl.getBoundingClientRect().top;
                        const offsetPosition = elementPosition + window.pageYOffset - headerOffset;

                        window.scrollTo({
                            top: Math.max(0, offsetPosition),
                            behavior: 'smooth'
                        });

                        navClickTimeout = setTimeout(() => {
                            isNavClicking = false;
                        }, 800);
                    }
                }
            });
        });

        function updateScrollSpy() {
            if (isNavClicking) return;

            const scrollPos = window.pageYOffset + 140;
            let currentActiveId = null;

            spySections.forEach(section => {
                const el = document.getElementById(section.id);
                if (el) {
                    const top = el.offsetTop;
                    const height = el.offsetHeight;
                    if (scrollPos >= top && scrollPos < top + height) {
                        currentActiveId = section.id;
                    }
                }
            });

            navLinks.forEach(link => {
                const href = link.getAttribute('href')?.replace('#', '');
                if (href === currentActiveId) {
                    if (!link.classList.contains('active')) {
                        navLinks.forEach(l => l.classList.remove('active'));
                        link.classList.add('active');
                        triggerNavPop(link);
                    }
                } else if (!currentActiveId) {
                    link.classList.remove('active');
                }
            });
        }

        window.addEventListener('scroll', updateScrollSpy, { passive: true });
        updateScrollSpy();

        // =========================================================
        // PRELOADER & LOADING ANIMATION SCRIPTS (Smoother & Extended Duration)
        // =========================================================
        let preloaderDismissed = false;
        const preloader = document.getElementById('page-preloader');
        const progressBar = document.getElementById('preloader-progress-bar');
        const statusText = document.getElementById('preloader-status-text');
        const pctText = document.getElementById('preloader-pct');

        function updatePreloaderProgress(pct, msg) {
            if (progressBar) progressBar.style.width = pct + '%';
            if (pctText) pctText.textContent = pct + '%';
            if (statusText && msg) {
                const textSpan = statusText.querySelector('span:last-child');
                if (textSpan) textSpan.textContent = msg;
            }
        }

        function dismissPreloader() {
            if (preloaderDismissed || !preloader) return;
            preloaderDismissed = true;
            updatePreloaderProgress(100, 'Sistem siap!');

            setTimeout(() => {
                preloader.classList.add('preloader-dismissed');
                preloader.style.opacity = '0';
                preloader.style.transform = 'scale(1.03)';
                preloader.style.pointerEvents = 'none';
                setTimeout(() => {
                    preloader.style.display = 'none';
                }, 650);
            }, 300);
        }

        // Realistic Step-by-Step Progress Timeline (~2.3 seconds total display duration)
        setTimeout(() => updatePreloaderProgress(42, 'Memuat komponen antarmuka...'), 450);
        setTimeout(() => updatePreloaderProgress(70, 'Menyiapkan modul Metafora CRM...'), 1000);
        setTimeout(() => updatePreloaderProgress(88, 'Sinkronisasi data pelanggan...'), 1550);
        setTimeout(() => dismissPreloader(), 2150);


        // Interactive Button Click Loading Animation
        document.querySelectorAll('.btn-action-loading').forEach(btn => {
            btn.addEventListener('click', function(e) {
                if (this.classList.contains('is-loading')) return;
                this.classList.add('is-loading');
                
                const label = this.querySelector('.btn-label') || this;
                const prevText = label.textContent;
                
                // Keep dimensions stable while showing loading spinner
                this.style.minWidth = this.offsetWidth + 'px';
                
                this.innerHTML = `
                    <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-current inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                    </svg>
                    <span>Memuat...</span>
                `;
            });
        });
    </script>
</body>
</html>

