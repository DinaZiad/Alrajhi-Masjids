<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>الصفحة الرئيسية لمسجد: {{ $masjid->name }}</title>
    <link rel="icon" href="/favicon.png" type="image/svg+xml">
    <!-- Google Fonts: Cairo & Amiri -->
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700;900&family=Amiri:wght@400;700&display=swap" rel="stylesheet">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Smooth Scrollbar -->
    <script src="https://cdn.jsdelivr.net/npm/smooth-scrollbar@8.8.1/dist/smooth-scrollbar.js"></script>
    <style>
        :root {
            --deep-forest: #174032;
            --warm-gold: #d4af37;
            --soft-cream: #faf9f6;
            --pure-white: #ffffff;
            --charcoal-dark: #2c3e50;
            --border-subtle: #e8e8e8;
            --primary-gradient: linear-gradient(135deg, #174032 0%, #174032 100%);
            --gold-gradient: linear-gradient(135deg, #d4af37 0%, #d4af37 100%);
            --background-gradient: linear-gradient(135deg, #faf9f6 0%, #faf9f6 100%);
            --card-gradient: linear-gradient(145deg, #ffffff 0%, #ffffff 100%);
            --border-radius: 10px;
            --border-radius-lg: 50px;
            --transition: all 0.2s ease-in-out;
        }
        html, body, #scroll-content {
            height: 100%;
        }
        body {
            overflow: hidden;
        }
        header.main-header {
            position: fixed;
            top: 0;
            right: 0;
            left: 0;
            z-index: 100;
            width: 100%;
        }
        #scroll-content {
            height: 100vh;
            overflow: auto;
            padding-top: 80px; /* Increased padding to add more space */
        }
        html {
            scroll-behavior: smooth;
        }
        *:focus {
            outline: 2px solid var(--warm-gold) !important;
            outline-offset: 2px;
        }
        .main-header {
            background: var(--primary-gradient);
            padding: 0;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        .main-header .header-pattern {
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            z-index: 1;
            opacity: 0.08;
            pointer-events: none;
        }
        .main-header .header-content {
            position: relative;
            z-index: 2;
        }
        .bismillah {
            font-family: 'Amiri', serif;
            color: var(--warm-gold);
            font-size: 1.15rem;
            margin-bottom: 0.7rem;
            letter-spacing: 0.5px;
        }
        .logo-container {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 1.1rem;
            margin-bottom: 1.1rem;
        }
        .logo-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 50px;
            height: 50px;
            background: var(--gold-gradient);
            color: var(--deep-forest);
            border-radius: var(--border-radius);
            font-size: 1.7rem;
            border: 2px solid var(--warm-gold);
        }
        .logo-title {
            font-family: 'Amiri', serif;
            font-size: 1.35rem;
            color: var(--pure-white);
            font-weight: 900;
            letter-spacing: 0.5px;
        }
        .logo-title .masjid-name {
            color: var(--warm-gold);
            font-weight: 700;
            margin-right: 0.5rem;
            font-size: 1.15rem;
        }
        .header-subtitle {
            color: var(--warm-gold);
            font-size: 1.05rem;
            font-weight: 400;
            margin-top: 0.3rem;
            font-family: 'Cairo', sans-serif;
        }
        .container {
            max-width: 1400px;
            margin: 0.34rem auto 2.2rem auto;
            padding: 2vw;
            padding-bottom: 4rem;
        }
        .card {
            background: var(--pure-white);
            border-radius: var(--border-radius);
            border: none;
            margin-bottom: 2.2rem;
            box-shadow: none;
            overflow: hidden;
            transition: var(--transition);
        }
        .card-header {
            background: var(--primary-gradient);
            color: var(--warm-gold);
            font-weight: 700;
            font-size: 1.15rem;
            border-radius: var(--border-radius) var(--border-radius) 0 0;
            padding: 1.1rem 1.1rem 1.1rem 0.5rem;
            border-bottom: 2px solid var(--warm-gold);
            display: flex;
            align-items: center;
            gap: 0.7rem;
        }
        .card-header i {
            font-size: 1.2rem;
            color: var(--warm-gold);
        }
        .card-body {
            padding: 1.1rem 1.1rem 1.1rem 1.1rem;
        }
        .info-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.2rem;
        }
        .info-item {
            display: flex;
            align-items: center;
            padding: 1rem;
            background: var(--soft-cream);
            border-radius: var(--border-radius);
            border: 1px solid var(--border-subtle);
            min-height: 90px;
        }
        .info-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 45px;
            height: 45px;
            background: var(--gold-gradient);
            color: var(--deep-forest);
            border-radius: var(--border-radius);
            margin-left: 1rem;
            font-size: 1.2rem;
        }
        .info-label {
            color: var(--charcoal-dark);
            font-size: 1rem;
            font-weight: 700;
            margin-bottom: 0.2rem;
        }
        .info-value {
            color: var(--deep-forest);
            font-size: 1.1rem;
            font-weight: 600;
        }
        .marquee-container {
            background: var(--background-gradient);
            border-radius: var(--border-radius);
            padding: 1.1rem;
            border: 1px solid var(--border-subtle);
            overflow: hidden;
            position: relative;
        }
        .marquee {
            font-size: 1.05rem;
            color: var(--deep-forest);
            font-weight: 700;
            white-space: nowrap;
            animation: scroll-right 30s linear infinite;
        }
        .marquee .urgent {
            color: #e74c3c;
            font-weight: 900;
            margin-left: 2rem;
        }
        .marquee .normal {
            margin-left: 2rem;
        }
        @keyframes scroll-right {
            0% { transform: translateX(100%); }
            100% { transform: translateX(-100%); }
        }
        .filter-section {
            margin-bottom: 2.2rem;
        }
        .filter-tabs {
            display: flex;
            justify-content: center;
            gap: 1.1rem;
            margin-bottom: 2.2rem;
            flex-wrap: wrap;
        }
        .filter-tab {
            background: var(--pure-white);
            color: var(--deep-forest);
            border: 2px solid var(--border-subtle);
            border-radius: var(--border-radius-lg);
            padding: 1rem 2.5rem;
            font-weight: 900;
            font-size: 1.13rem;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .filter-tab.active, .filter-tab:focus {
            background: var(--deep-forest);
            color: var(--warm-gold);
            border: 2px solid var(--warm-gold);
        }
        .filter-tab:hover {
            background: var(--warm-gold);
            color: var(--deep-forest);
            border: 2px solid var(--deep-forest);
        }
        .filter-form {
            background: var(--pure-white);
            padding: 1.1rem;
            border-radius: var(--border-radius);
            margin-bottom: 2.2rem;
            border: 1px solid var(--border-subtle);
            overflow: hidden;
        }
        .filter-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.1rem;
            min-width: 0;
        }
        .input-group {
            position: relative;
            min-width: 0;
        }
        .input-group input {
            width: 100%;
            padding: 1.1rem 2.5rem 1.1rem 1.1rem;
            border: 2px solid var(--border-subtle);
            border-radius: var(--border-radius);
            font-family: 'Cairo', sans-serif;
            font-size: 1.05rem;
            background: var(--pure-white);
            color: var(--charcoal-dark);
            transition: var(--transition);
            box-sizing: border-box;
            max-width: 100%;
        }
        .input-group input:focus {
            border: 2px solid var(--warm-gold);
            background: #fffbe9;
            box-shadow: 0 4px 16px rgba(212, 175, 55, 0.08);
            outline: none;
        }
        .input-group i {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--charcoal-dark);
            font-size: 1.1rem;
            z-index: 1;
        }
        .input-group input:focus + i {
            color: var(--warm-gold);
        }
        .table-section {
            opacity: 0;
            pointer-events: none;
            max-height: 0;
            transition: opacity 0.4s, max-height 0.4s;
            overflow: hidden;
        }
        .table-section.active {
            opacity: 1;
            pointer-events: auto;
            max-height: 5000px;
            transition: opacity 0.4s, max-height 0.4s;
        }
        .section-header {
            display: flex;
            align-items: center;
            gap: 1.1rem;
            margin-bottom: 1.1rem;
            padding-bottom: 0.7rem;
            border-bottom: 2px solid var(--border-subtle);
        }
        .section-header h4 {
            color: var(--deep-forest);
            font-size: 1.25rem;
            font-weight: 900;
            margin: 0;
        }
        .section-header i {
            color: var(--warm-gold);
            font-size: 1.3rem;
        }
        .table-container {
            background: var(--pure-white);
            border-radius: var(--border-radius);
            overflow: hidden;
            border: 1px solid var(--border-subtle);
        }
        .table-responsive {
            overflow-x: auto;
        }
        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            background: var(--pure-white);
            border-radius: var(--border-radius);
            font-size: 0.95rem;
        }
        thead {
            background: var(--primary-gradient);
            color: var(--warm-gold);
        }
        thead th {
            padding: 1.1rem 0.5rem;
            font-weight: 700;
            border-radius: var(--border-radius) var(--border-radius) 0 0;
            border-bottom: 2px solid var(--warm-gold);
            text-align: center;
        }
        tbody tr {
            transition: var(--transition);
        }
        tbody tr:hover {
            background: #fffbe9;
        }
        tbody td {
            padding: 0.7rem 0.5rem;
            border-bottom: 1px solid var(--border-subtle);
            text-align: center;
        }
        tbody tr:last-child td {
            border-bottom: none;
        }
        .status-badge {
            padding: 0.4rem 1rem;
            border-radius: var(--border-radius-lg);
            font-size: 0.95rem;
            font-weight: 700;
            background: var(--warm-gold);
            color: var(--deep-forest);
            border: none;
            display: inline-block;
        }
        .stream-link {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            color: var(--warm-gold);
            text-decoration: none;
            font-weight: 700;
            transition: var(--transition);
        }
        .stream-link:hover, .stream-link:focus {
            color: var(--deep-forest);
            text-decoration: underline;
        }
        @keyframes fade-in {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        .navbar {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0; /* No padding */
            background: var(--primary-gradient);
            box-shadow: 0 2px 8px rgba(23, 64, 50, 0.07);
            border-radius: var(--border-radius);
            margin-bottom: 0;
            min-height: unset;
            height: 60px; 
        }
        .logo-container.single-line {
            flex-direction: row;
            gap: 0.6rem;
            align-items: center;
            justify-content: center;
            display: flex;
            margin-bottom: 0;
        }
        .logo-icon {
            width: 36px;
            height: 36px;
            font-size: 1.25rem;
            border-radius: var(--border-radius);
            border: 2px solid var(--warm-gold);
            background: var(--gold-gradient);
            color: var(--deep-forest);
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .logo-title {
            font-family: 'Amiri', serif;
            font-size: 1.15rem;
            color: var(--pure-white);
            font-weight: 900;
            letter-spacing: 0.5px;
            display: inline-block;
            line-height: 1;
        }
        .logo-title .masjid-name {
            color: var(--warm-gold);
            font-weight: 700;
            margin-right: 0.3rem;
            font-size: 1.05rem;
        }
        @media (max-width: 900px) {
            .container { padding: 1.2rem; }
            table, thead, tbody, th, td, tr { font-size: 0.95rem; }
            .info-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
        @media (max-width: 600px) {
            .container { padding: 0.5rem; }
            .logo-title { font-size: 1rem; }
            .logo-title .masjid-name { font-size: 0.95rem; }
            .card-header, .section-header h4 { font-size: 1rem; }
            .filter-tab { font-size: 1rem; padding: 0.7rem 1.2rem; }
            .info-grid {
                grid-template-columns: 1fr;
            }
        }
        #display-btn, #display-btn:visited {
            display: inline-block !important;
            visibility: visible !important;
            opacity: 1 !important;
        }
        #display-btn-fixed {
            position: fixed;
            bottom: 30px;
            right: 30px;
            z-index: 9999;
        }
        @media (max-width: 600px) {
            #display-btn-fixed {
                bottom: 10px;
                right: 10px;
                font-size: 1rem;
                padding: 0.5rem 1.2rem;
            }
        }
        /* Ensure masjid info card always has space from navbar */
        .container > .card:first-child {
            margin-top: 2.5rem !important;
        }
        @media (max-width: 600px) {
            .container > .card:first-child {
                margin-top: 1.2rem !important;
            }
        }
        /* Add horizontal padding to the 'all' tables section */
        #table-all {
            padding-right: 1.5rem !important;
            padding-left: 1.5rem !important;
        }
        #table-all .table-container {
            margin-right: 0.5rem !important;
            margin-left: 0.5rem !important;
        }
        @media (max-width: 600px) {
            #table-all {
                padding-right: 0.3rem !important;
                padding-left: 0.3rem !important;
            }
            #table-all .table-container {
                margin-right: 0.1rem !important;
                margin-left: 0.1rem !important;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="main-header">
        <div class="header-pattern">
            <!-- Subtle geometric SVG overlay -->
            <svg width="100%" height="100%" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <pattern id="geo" patternUnits="userSpaceOnUse" width="20" height="20">
                        <circle cx="10" cy="10" r="1.5" fill="#d4af37" fill-opacity="0.15" />
                        <rect x="0" y="0" width="20" height="20" fill="none" stroke="#d4af37" stroke-width="0.2" opacity="0.07" />
                    </pattern>
                </defs>
                <rect width="100%" height="100%" fill="url(#geo)" />
            </svg>
        </div>
        <div class="header-content">
            <nav class="navbar">
                <div class="logo-container single-line">
                    <div class="logo-icon" aria-label="شعار المسجد"><i class="fas fa-mosque"></i></div>
                    <h1 class="logo-title">إدارة المساجد - <span class="masjid-name">{{ $masjid->name }}</span></h1>
                </div>
            </nav>
        </div>
    </header>

    <div id="scroll-content">
        <div class="container">
            <!-- Mosque Information Card -->
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-info-circle"></i>
                    <span>معلومات المسجد</span>
                </div>
                <div class="card-body">
                    <div class="info-grid">
                        <div class="info-item">
                            <div class="info-icon">
                                <i class="fas fa-mosque"></i>
                            </div>
                            <div class="info-content">
                                <div class="info-label">اسم المسجد</div>
                                <div class="info-value">{{ $masjid->name }}</div>
                            </div>
                        </div>
                        <div class="info-item">
                            <div class="info-icon">
                                <i class="fas fa-expand-arrows-alt"></i>
                            </div>
                            <div class="info-content">
                                <div class="info-label">المساحة الإجمالية</div>
                                <div class="info-value">{{ $masjid->total_area }}</div>
                            </div>
                        </div>
                        <div class="info-item">
                            <div class="info-icon">
                                <i class="fas fa-users"></i>
                            </div>
                            <div class="info-content">
                                <div class="info-label">الطاقة الاستيعابية</div>
                                <div class="info-value">{{ $masjid->capacity }}</div>
                            </div>
                        </div>
                        <div class="info-item">
                            <div class="info-icon">
                                <i class="fas fa-door-open"></i>
                            </div>
                            <div class="info-content">
                                <div class="info-label">عدد الأبواب</div>
                                <div class="info-value">{{ $masjid->gate_count }}</div>
                            </div>
                        </div>
                        <div class="info-item">
                            <div class="info-icon">
                                <i class="fas fa-building"></i>
                            </div>
                            <div class="info-content">
                                <div class="info-label">عدد الأروقة</div>
                                <div class="info-value">{{ $masjid->wing_count }}</div>
                            </div>
                        </div>
                        <div class="info-item">
                            <div class="info-icon">
                                <i class="fas fa-pray"></i>
                            </div>
                            <div class="info-content">
                                <div class="info-label">عدد المصليات</div>
                                <div class="info-value">{{ $masjid->prayer_hall_count }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Program Filters -->
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-filter"></i>
                    <span>فلترة البرامج</span>
                </div>
                <div class="card-body">
                    <form id="program-filters">
                        <div class="filter-grid">
                            <div class="input-group">
                                <select name="program_type" id="program_type_filter" style="width: 100%; padding: 1.1rem 2.5rem 1.1rem 1.1rem; font-size: 1.05rem; border-radius: var(--border-radius); border: 2px solid var(--border-subtle); background: var(--pure-white); color: var(--charcoal-dark); height: 60px; box-sizing: border-box;">
                                    <option value="">كل أنواع البرامج</option>
                                    @php
                                        $programTypes = $programs->pluck('program_type')->unique()->filter()->sort();
                                    @endphp
                                    @foreach($programTypes as $type)
                                        <option value="{{ $type }}">{{ $type }}</option>
                                    @endforeach
                                </select>
                                <i class="fas fa-list"></i>
                            </div>
                            <div class="input-group">
                                <select name="field" id="section_filter" style="width: 100%; padding: 1.1rem 2.5rem 1.1rem 1.1rem; font-size: 1.05rem; border-radius: var(--border-radius); border: 2px solid var(--border-subtle); background: var(--pure-white); color: var(--charcoal-dark); height: 60px; box-sizing: border-box;">
                                    <option value="">كل المجالات</option>
                                    @php
                                        $fields = $programs->pluck('field')->unique()->filter()->sort();
                                    @endphp
                                    @foreach($fields as $field)
                                        <option value="{{ $field }}">{{ $field }}</option>
                                    @endforeach
                                </select>
                                <i class="fas fa-sitemap"></i>
                            </div>
                            <div class="input-group">
                                <select name="specialty" id="major_filter" style="width: 100%; padding: 1.1rem 2.5rem 1.1rem 1.1rem; font-size: 1.05rem; border-radius: var(--border-radius); border: 2px solid var(--border-subtle); background: var(--pure-white); color: var(--charcoal-dark); height: 60px; box-sizing: border-box;">
                                    <option value="">كل التخصصات</option>
                                    @php
                                        $specialties = $programs->pluck('specialty')->unique()->filter()->sort();
                                    @endphp
                                    @foreach($specialties as $specialty)
                                        <option value="{{ $specialty }}">{{ $specialty }}</option>
                                    @endforeach
                                </select>
                                <i class="fas fa-graduation-cap"></i>
                            </div>
                            <div class="input-group">
                                <select name="location_id" id="location_filter" style="width: 100%; padding: 1.1rem 2.5rem 1.1rem 1.1rem; font-size: 1.05rem; border-radius: var(--border-radius); border: 2px solid var(--border-subtle); background: var(--pure-white); color: var(--charcoal-dark); height: 60px; box-sizing: border-box;">
                                    <option value="">كل المواقع</option>
                                    @php
                                        $locations = \App\Models\Location::orderBy('name')->get();
                                    @endphp
                                    @foreach($locations as $location)
                                        <option value="{{ $location->id }}">{{ $location->name }}</option>
                                    @endforeach
                                </select>
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Announcements -->
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-bullhorn"></i>
                    <span>شريط الإعلانات</span>
                </div>
                <div class="card-body">
                    <div class="marquee-container">
                        <div id="marquee-js" class="marquee"></div>
                    </div>
                </div>
            </div>

            <!-- Filter Tabs -->
            <div class="filter-section">
                <div class="filter-tabs">
                    <button class="filter-tab active" data-target="scientific" aria-label="عرض الدروس العلمية" tabindex="0">
                        <i class="fas fa-book-open"></i>
                        <span>الدروس العلمية</span>
                    </button>
                    <button class="filter-tab" data-target="halaqat" aria-label="عرض الحلقات التحفيظية" tabindex="0">
                        <i class="fas fa-tasks"></i>
                        <span>الحلقات التحفيظية</span>
                    </button>
                    <button class="filter-tab" data-target="imama" aria-label="عرض جدول الأئمة" tabindex="0">
                        <i class="fas fa-user-tie"></i>
                        <span>الأئمة</span>
                    </button>
                    <button class="filter-tab" data-target="all" aria-label="عرض الكل" tabindex="0">
                        <i class="fas fa-layer-group"></i>
                        <span>عرض الكل</span>
                    </button>
                </div>
            </div>

            <!-- Scientific Lessons Section -->
            <div class="table-section active" id="table-scientific">
                <div class="section-header">
                    <i class="fas fa-book-open"></i>
                    <h4>الدروس العلمية</h4>
                </div>
                
                <div class="filter-form">
                    <form id="filter-scientific">
                        <div class="filter-grid">
                            <div class="input-group">
                                <input type="text" name="field" placeholder="المجال">
                                <i class="fas fa-tag"></i>
                            </div>
                            <div class="input-group">
                                <input type="text" name="specialty" placeholder="التخصص">
                                <i class="fas fa-graduation-cap"></i>
                            </div>
                            <div class="input-group">
                                <input type="text" name="teacher" placeholder="اسم الشيخ">
                                <i class="fas fa-user"></i>
                            </div>
                            <div class="input-group">
                                <input type="text" name="status" placeholder="الحالة">
                                <i class="fas fa-info-circle"></i>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="table-container">
                    <div class="table-responsive">
                        <table>
                            <thead>
                                <tr>
                                    <th>الكتاب</th>
                                    <th>المجال</th>
                                    <th>التخصص</th>
                                    <th>المستوى</th>
                                    <th>الحالة</th>
                                    <th>الوقت من</th>
                                    <th>الوقت إلى</th>
                                    <th>الحضور</th>
                                    <th>اللغة</th>
                                    <th>الملاحظات</th>
                                    <th>الموقع</th>
                                    <th>المحاضر</th>
                                    <th>رابط البث</th>
                                </tr>
                            </thead>
                            <tbody id="tbody-scientific">
                                @include('masjids.partials.table_scientific_rows', ['programs' => $programs->where('program_type', 'درس علمي')])
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Halaqat Section -->
            <div class="table-section" id="table-halaqat">
                <div class="section-header">
                    <i class="fas fa-tasks"></i>
                    <h4>الحلقات التحفيظية</h4>
                </div>
                
                <div class="filter-form">
                    <form id="filter-halaqat">
                        <div class="filter-grid">
                            <div class="input-group">
                                <input type="text" name="instructor" placeholder="اسم المعلم">
                                <i class="fas fa-user"></i>
                            </div>
                            <div class="input-group">
                                <input type="text" name="group" placeholder="الحلقة">
                                <i class="fas fa-circle"></i>
                            </div>
                            <div class="input-group">
                                <input type="text" name="status" placeholder="الحالة">
                                <i class="fas fa-info-circle"></i>
                            </div>
                            <div class="input-group">
                                <input type="date" name="date" placeholder="التاريخ">
                                <i class="fas fa-calendar"></i>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="table-container">
                    <div class="table-responsive">
                        <table>
                            <thead>
                                <tr>
                                    <th>الحلقة</th>
                                    <th>المستوى</th>
                                    <th>الحالة</th>
                                    <th>الوقت من</th>
                                    <th>الوقت إلى</th>
                                    <th>الحضور</th>
                                    <th>اللغة</th>
                                    <th>الترجمة</th>
                                    <th>الموقع</th>
                                    <th>المعلم</th>
                                    <th>رابط البث</th>
                                </tr>
                            </thead>
                            <tbody id="tbody-halaqat">
                                @include('masjids.partials.table_halaqat_rows', ['programs' => $programs->where('program_type', 'حلقة تحفيظ')])
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Imama Section -->
            <div class="table-section" id="table-imama">
                <div class="section-header">
                    <i class="fas fa-user-tie"></i>
                    <h4>جدول الأئمة</h4>
                </div>
                <div class="filter-form">
                    <form id="filter-imama">
                        <div class="filter-grid">
                            <div class="input-group">
                                <input type="text" name="imam" placeholder="اسم الإمام">
                                <i class="fas fa-user"></i>
                            </div>
                            <div class="input-group">
                                <select name="day" style="width: 100%; min-width: 0; padding: 1.1rem 2.5rem 1.1rem 1.1rem; font-size: 1.05rem; border-radius: var(--border-radius); border: 2px solid var(--border-subtle); background: var(--pure-white); color: var(--charcoal-dark); height: 60px; box-sizing: border-box;">
                                    <option value="">كل الأيام</option>
                                    <option value="الأحد">الأحد</option>
                                    <option value="الإثنين">الإثنين</option>
                                    <option value="الثلاثاء">الثلاثاء</option>
                                    <option value="الأربعاء">الأربعاء</option>
                                    <option value="الخميس">الخميس</option>
                                    <option value="الجمعة">الجمعة</option>
                                    <option value="السبت">السبت</option>
                                </select>
                                <i class="fas fa-calendar-day"></i>
                            </div>
                            <div class="input-group">
                                <input type="date" name="date" placeholder="التاريخ">
                                <i class="fas fa-calendar"></i>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="table-container">
                    <table style="width:100%; font-size:0.93rem; border-collapse:collapse;">
                        <thead style="background: var(--primary-gradient); color: var(--warm-gold);">
                            <tr>
                                <th style="padding:6px;">التاريخ</th>
                                <th style="padding:6px;">اليوم</th>
                                <th style="padding:6px;">أذان الفجر</th>
                                <th style="padding:6px;">إقامة الفجر</th>
                                <th style="padding:6px;">إمام الفجر</th>
                                <th style="padding:6px;">أذان الظهر</th>
                                <th style="padding:6px;">إقامة الظهر</th>
                                <th style="padding:6px;">إمام الظهر</th>
                                <th style="padding:6px;">أذان العصر</th>
                                <th style="padding:6px;">إقامة العصر</th>
                                <th style="padding:6px;">إمام العصر</th>
                                <th style="padding:6px;">أذان المغرب</th>
                                <th style="padding:6px;">إقامة المغرب</th>
                                <th style="padding:6px;">إمام المغرب</th>
                                <th style="padding:6px;">أذان العشاء</th>
                                <th style="padding:6px;">إقامة العشاء</th>
                                <th style="padding:6px;">إمام العشاء</th>
                            </tr>
                        </thead>
                        <tbody id="tbody-imama">
                            @foreach($programs->where('program_type', 'إمامة') as $program)
                            <tr>
                                <td style="padding:6px;">{{ $program->date }}</td>
                                <td style="padding:6px;">{{ $program->day }}</td>
                                <td style="padding:6px;">{{ $program->adhan_fajr }}</td>
                                <td style="padding:6px;">{{ $program->iqama_fajr }}</td>
                                <td style="padding:6px;">{{ $program->imam_fajr }}</td>
                                <td style="padding:6px;">{{ $program->adhan_dhuhr }}</td>
                                <td style="padding:6px;">{{ $program->iqama_dhuhr }}</td>
                                <td style="padding:6px;">{{ $program->imam_dhuhr }}</td>
                                <td style="padding:6px;">{{ $program->adhan_asr }}</td>
                                <td style="padding:6px;">{{ $program->iqama_asr }}</td>
                                <td style="padding:6px;">{{ $program->imam_asr }}</td>
                                <td style="padding:6px;">{{ $program->adhan_maghrib }}</td>
                                <td style="padding:6px;">{{ $program->iqama_maghrib }}</td>
                                <td style="padding:6px;">{{ $program->imam_maghrib }}</td>
                                <td style="padding:6px;">{{ $program->adhan_isha }}</td>
                                <td style="padding:6px;">{{ $program->iqama_isha }}</td>
                                <td style="padding:6px;">{{ $program->imam_isha }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- All Data Section -->
        <div class="table-section" id="table-all">
            <div class="section-header">
                <i class="fas fa-layer-group"></i>
                <h4>جميع البيانات</h4>
            </div>
            <div class="filter-form">
                <form id="filter-all">
                    <div class="filter-grid">
                        <div class="input-group">
                            <input type="text" name="search" placeholder="بحث عن جميع البيانات">
                            <i class="fas fa-search"></i>
                        </div>
                        <div class="input-group">
                            <input type="date" name="date" placeholder="التاريخ">
                            <i class="fas fa-calendar"></i>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Scientific Lessons Table -->
            <div class="table-container" style="margin-bottom:2rem;">
                <div class="section-header">
                    <i class="fas fa-book-open"></i>
                    <h4>الدروس العلمية</h4>
                </div>
                <div class="table-responsive">
                    <table>
                        <thead>
                            <tr>
                                <th>الكتاب</th>
                                <th>المجال</th>
                                <th>التخصص</th>
                                <th>المستوى</th>
                                <th>الحالة</th>
                                <th>الوقت من</th>
                                <th>الوقت إلى</th>
                                <th>الحضور</th>
                                <th>اللغة</th>
                                <th>الملاحظات</th>
                                <th>الموقع</th>
                                <th>المحاضر</th>
                                <th>رابط البث</th>
                            </tr>
                        </thead>
                        <tbody id="tbody-all-scientific">
                            @include('masjids.partials.table_scientific_rows', ['programs' => $programs->where('program_type', 'درس علمي')])
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Halaqat Table -->
            <div class="table-container" style="margin-bottom:2rem;">
                <div class="section-header">
                    <i class="fas fa-tasks"></i>
                    <h4>الحلقات التحفيظية</h4>
                </div>
                <div class="table-responsive">
                    <table>
                        <thead>
                            <tr>
                                <th>الحلقة</th>
                                <th>المستوى</th>
                                <th>الحالة</th>
                                <th>الوقت من</th>
                                <th>الوقت إلى</th>
                                <th>الحضور</th>
                                <th>اللغة</th>
                                <th>الترجمة</th>
                                <th>الموقع</th>
                                <th>المعلم</th>
                                <th>رابط البث</th>
                            </tr>
                        </thead>
                        <tbody id="tbody-all-halaqat">
                            @include('masjids.partials.table_halaqat_rows', ['programs' => $programs->where('program_type', 'حلقة تحفيظ')])
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Imama Table -->
            <div class="table-container">
                <div class="section-header">
                    <i class="fas fa-user-tie"></i>
                    <h4>جدول الأئمة</h4>
                </div>
                <div class="table-responsive">
                    <table>
                        <thead>
                            <tr>
                                <th>التاريخ</th>
                                <th>اليوم</th>
                                <th>أذان الفجر</th>
                                <th>إقامة الفجر</th>
                                <th>إمام الفجر</th>
                                <th>أذان الظهر</th>
                                <th>إقامة الظهر</th>
                                <th>إمام الظهر</th>
                                <th>أذان العصر</th>
                                <th>إقامة العصر</th>
                                <th>إمام العصر</th>
                                <th>أذان المغرب</th>
                                <th>إقامة المغرب</th>
                                <th>إمام المغرب</th>
                                <th>أذان العشاء</th>
                                <th>إقامة العشاء</th>
                                <th>إمام العشاء</th>
                            </tr>
                        </thead>
                        <tbody id="tbody-all-imama">
                            @foreach($programs->where('program_type', 'إمامة') as $program)
                            <tr>
                                <td>{{ $program->date }}</td>
                                <td>{{ $program->day }}</td>
                                <td>{{ $program->adhan_fajr }}</td>
                                <td>{{ $program->iqama_fajr }}</td>
                                <td>{{ $program->imam_fajr }}</td>
                                <td>{{ $program->adhan_dhuhr }}</td>
                                <td>{{ $program->iqama_dhuhr }}</td>
                                <td>{{ $program->imam_dhuhr }}</td>
                                <td>{{ $program->adhan_asr }}</td>
                                <td>{{ $program->iqama_asr }}</td>
                                <td>{{ $program->imam_asr }}</td>
                                <td>{{ $program->adhan_maghrib }}</td>
                                <td>{{ $program->iqama_maghrib }}</td>
                                <td>{{ $program->imam_maghrib }}</td>
                                <td>{{ $program->adhan_isha }}</td>
                                <td>{{ $program->iqama_isha }}</td>
                                <td>{{ $program->imam_isha }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
    </div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize Smooth Scrollbar for inertia-style smooth scrolling
        if (window.Scrollbar) {
            Scrollbar.init(document.getElementById('scroll-content'), {
                damping: 0.08, // Lower is smoother
                alwaysShowTracks: true
            });
        }

        // Program Filters Functionality
        function filterPrograms() {
            const programType = document.getElementById('program_type_filter').value;
            const field = document.getElementById('section_filter').value;
            const specialty = document.getElementById('major_filter').value;
            const locationId = document.getElementById('location_filter').value;

            // Filter Scientific Programs
            filterProgramTable('tbody-all-scientific', programType, field, specialty, locationId);
            // Filter Halaqat Programs
            filterProgramTable('tbody-all-halaqat', programType, field, specialty, locationId);
            // Filter Imama Programs
            filterProgramTable('tbody-all-imama', programType, field, specialty, locationId);
        }

        function filterProgramTable(tbodyId, programType, field, specialty, locationId) {
            const tbody = document.getElementById(tbodyId);
            if (!tbody) return;
            
            let anyVisible = false;
            Array.from(tbody.querySelectorAll('tr')).forEach(row => {
                // Skip the 'no results' row
                if (row.classList.contains('text-center')) return;
                
                let show = true;
                
                // Get row data attributes
                const rowProgramType = row.getAttribute('data-program-type');
                const rowField = row.getAttribute('data-field');
                const rowSpecialty = row.getAttribute('data-specialty');
                const rowLocationId = row.getAttribute('data-location-id');
                const rowLocationArray = row.getAttribute('data-location-array');
                
                // Apply filters (matching Program model fields)
                if (programType && rowProgramType !== programType) show = false;
                if (field && rowField !== field) show = false;
                if (specialty && rowSpecialty !== specialty) show = false;
                if (locationId && rowLocationId !== locationId) show = false;
                
                row.style.display = show ? '' : 'none';
                if (show) anyVisible = true;
            });
            
            // Show/hide the 'no results' row
            let noResultsRow = tbody.querySelector('tr.text-center');
            if (noResultsRow) {
                noResultsRow.style.display = anyVisible ? 'none' : '';
            }
        }

        // Attach event listeners to program filters
        const programFiltersForm = document.getElementById('program-filters');
        if (programFiltersForm) {
            programFiltersForm.querySelectorAll('select').forEach(select => {
                select.addEventListener('change', filterPrograms);
            });
        }
        const filterTabs = document.querySelectorAll('.filter-tab');
        const tableSections = document.querySelectorAll('.table-section');
        const filterForms = document.querySelectorAll('.filter-form');

        function ajaxFilter(formId, url, tbodyId) {
            const form = document.getElementById(formId);
            if (!form) return;
            // For all input/select in the form, trigger on input/change
            const triggerFilter = function() {
                const params = new URLSearchParams(new FormData(form)).toString();
                fetch(url + '?' + params)
                    .then(res => res.text())
                    .then(html => {
                        document.getElementById(tbodyId).innerHTML = html;
                    });
            };
            form.querySelectorAll('input, select').forEach(el => {
                if (el.tagName === 'SELECT') {
                    el.addEventListener('change', triggerFilter);
                } else {
                    el.addEventListener('input', triggerFilter);
                }
            });
        }

        // Tab switching and AJAX loading
        filterTabs.forEach(tab => {
            tab.addEventListener('click', function() {
                const targetId = this.getAttribute('data-target');
                // Update active tab
                filterTabs.forEach(t => t.classList.remove('active'));
                this.classList.add('active');
                // Show/hide table sections
                tableSections.forEach(section => {
                    section.classList.remove('active');
                    if (section.id === 'table-' + targetId) {
                        section.classList.add('active');
                        // Smooth scroll to the section
                        section.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    }
                });
                // Trigger AJAX load for the selected tab
                if (targetId === 'scientific') {
                    fetch('{{ route('masjids.filter.scientific', $masjid) }}')
                        .then(res => res.text())
                        .then(html => {
                            document.getElementById('tbody-scientific').innerHTML = html;
                        });
                } else if (targetId === 'halaqat') {
                    fetch('{{ route('masjids.filter.halaqat', $masjid) }}')
                        .then(res => res.text())
                        .then(html => {
                            document.getElementById('tbody-halaqat').innerHTML = html;
                        });
                } else if (targetId === 'imama') {
                    fetch('{{ route('masjids.filter.imama', $masjid) }}')
                        .then(res => res.text())
                        .then(html => {
                            document.getElementById('tbody-imama').innerHTML = html;
                        });
                } else if (targetId === 'all') {
                    // This part of the script is now handled by the new HTML structure
                    // No need to call fetch here, as the tables are already included.
                    // The filtering logic for 'all' will be handled by the new filter forms.
                }
            });
        });

        // Initial AJAX load for the default tab
        ajaxFilter('filter-scientific', '{{ route('masjids.filter.scientific', $masjid) }}', 'tbody-scientific');
        ajaxFilter('filter-halaqat', '{{ route('masjids.filter.halaqat', $masjid) }}', 'tbody-halaqat');
        ajaxFilter('filter-imama', '{{ route('masjids.filter.imama', $masjid) }}', 'tbody-imama');
        // Initial AJAX load for the 'all' tab is now handled by the new HTML structure
        // No need to call fetch here for the 'all' tab as the tables are already included.

        // --- Client-side filtering for 'all' tables ---
        function filterAllTables() {
            const search = document.querySelector('#filter-all input[name="search"]').value.trim().toLowerCase();
            const date = document.querySelector('#filter-all input[name="date"]').value;

            // Scientific Table
            filterTableRows('tbody-all-scientific', search, date);
            // Halaqat Table
            filterTableRows('tbody-all-halaqat', search, date);
            // Imama Table
            filterTableRows('tbody-all-imama', search, date);
        }

        function filterTableRows(tbodyId, search, date) {
            const tbody = document.getElementById(tbodyId);
            if (!tbody) return;
            let anyVisible = false;
            Array.from(tbody.querySelectorAll('tr')).forEach(row => {
                // Skip the 'no results' row
                if (row.classList.contains('text-center')) return;
                let text = row.textContent.trim().toLowerCase();
                let show = true;
                if (search && !text.includes(search)) show = false;
                if (date) {
                    // Try to match the date in any cell
                    let dateFound = false;
                    Array.from(row.querySelectorAll('td')).forEach(td => {
                        if (td.textContent.includes(date)) dateFound = true;
                    });
                    if (!dateFound) show = false;
                }
                row.style.display = show ? '' : 'none';
                if (show) anyVisible = true;
            });
            // Show/hide the 'no results' row
            let noResultsRow = tbody.querySelector('tr.text-center');
            if (noResultsRow) {
                noResultsRow.style.display = anyVisible ? 'none' : '';
            }
        }

        // Attach event listeners to 'all' filters
        const filterAllForm = document.getElementById('filter-all');
        if (filterAllForm) {
            filterAllForm.querySelectorAll('input').forEach(input => {
                input.addEventListener('input', filterAllTables);
            });
        }
    });
</script>
<script>
    // All announcements as JS objects
    const announcements = @json($announcementsArray);
    function isActive(a, now) {
        const start = a.start ? new Date(a.start.replace(/-/g, '/')) : null;
        const end = a.end ? new Date(a.end.replace(/-/g, '/')) : null;
        return (!start || now >= start) && (!end || now <= end);
    }
    function updateMarquee() {
        const now = new Date();
        const urgent = announcements.filter(a => a.is_urgent && isActive(a, now));
        const scheduled = announcements.filter(a => !a.is_urgent && isActive(a, now));
        let html = '';
        if (urgent.length || scheduled.length) {
            urgent.forEach(a => {
                html += `<span class='urgent'><i class='fas fa-exclamation-triangle'></i> ${a.content}</span>`;
            });
            scheduled.forEach(a => {
                html += `<span class='normal'>${a.content}</span>`;
            });
        } else {
            html = '<span>لا توجد إعلانات حالياً</span>';
        }
        document.getElementById('marquee-js').innerHTML = html;
    }
    updateMarquee();
    setInterval(updateMarquee, 1000);
</script>
<script>
    document.getElementById('display-btn-fixed').addEventListener('click', function(e) {
        e.preventDefault();
        // Get active table type
        let activeSection = document.querySelector('.table-section.active');
        let activeType = activeSection ? activeSection.id.replace('table-', '') : '';
        let params = new URLSearchParams();
        if (activeType) params.set('type', activeType);
        // Get filters for that type
        let filterForm = document.getElementById('filter-' + activeType);
        if (filterForm) {
            filterForm.querySelectorAll('input, select').forEach(input => {
                if (input.value) params.set(input.name, input.value);
            });
        }
        // Build the URL
        const baseUrl = this.getAttribute('data-base-url');
        window.open(baseUrl + '?' + params.toString(), '_blank');
    });
</script>

<!-- Fixed Display Button: Always visible -->
<a href="{{ route('masjids.display', $masjid->id) }}"
   id="display-btn-fixed"
   class="display-btn-fixed"
   data-base-url="{{ route('masjids.display', $masjid->id) }}">
    <i class="fas fa-tv" style="margin-left: 0.7rem;"></i>
    عرض في شاشات الحرم
</a>

<style>
#display-btn-fixed, .display-btn-fixed {
    display: block !important;
    position: fixed !important;
    bottom: 30px !important;
    right: 30px !important;
    z-index: 99999 !important;
    background: linear-gradient(135deg, #174032 0%, #174032 100%) !important;
    color: #d4af37 !important;
    border: none !important;
    border-radius: 2rem !important;
    font-size: 1.25rem !important;
    font-weight: bold !important;
    padding: 0.7rem 2.5rem !important;
    box-shadow: 0 2px 8px rgba(23,64,50,0.10) !important;
    cursor: pointer !important;
    text-decoration: none !important;
    opacity: 1 !important;
    visibility: visible !important;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var btn = document.getElementById('display-btn-fixed') || document.querySelector('.display-btn-fixed');
    if (btn) {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            let activeSection = document.querySelector('.table-section.active');
            let activeType = activeSection ? activeSection.id.replace('table-', '') : '';
            let params = new URLSearchParams();
            if (activeType) params.set('type', activeType);
            let filterForm = document.getElementById('filter-' + activeType);
            if (filterForm) {
                filterForm.querySelectorAll('input, select').forEach(input => {
                    if (input.value) params.set(input.name, input.value);
                });
            }
            const baseUrl = this.getAttribute('data-base-url');
            window.open(baseUrl + '?' + params.toString(), '_blank');
        });
    }
});
</script>
</body>
</html>