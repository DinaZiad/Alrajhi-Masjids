@php
    // Get all masjids from database
    $allMasjids = \App\Models\Masjid::all();
    
    $masjidCards = [
        [
            'id' => 1,
            'name' => 'المسجد الحرام',
            'icon' => '<i class="fas fa-kaaba"></i>'
        ],
        [
            'id' => 2,
            'name' => 'المسجد النبوي',
            'icon' => '<i class="fas fa-mosque"></i>'
        ],
        [
            'id' => 'all',
            'name' => 'الكل',
            'icon' => '<i class="fas fa-mosque"></i>'
        ],
    ];
    
    // Get other masjids (excluding Al-Haram and Nabawi)
    $otherMasjids = $allMasjids->whereNotIn('id', [1, 2]);
    $features = [
        ['icon' => '<i class="fas fa-bullhorn"></i>', 'text' => 'شاشة موزعة في مواقع محددة في المسجد الحرام والمسجد النبوي'],
        ['icon' => '<i class="fas fa-chart-bar"></i>', 'text' => 'إحصائيات عامة عن المسجدين'],
        ['icon' => '<i class="fas fa-bullhorn"></i>', 'text' => 'تسهيل إعلان محاضرة'],
        ['icon' => '<i class="fas fa-tasks"></i>', 'text' => 'إدارة برامج ودروس وخدمات التخطيط'],
        ['icon' => '<i class="fas fa-calendar-check"></i>', 'text' => 'مواعيد التسجيل في البرامج والدروس'],
        ['icon' => '<i class="fas fa-clipboard-list"></i>', 'text' => 'مواعيد الاختبارات'],
        ['icon' => '<i class="fas fa-chalkboard-teacher"></i>', 'text' => 'مواعيد الدورات'],
        ['icon' => '<i class="fas fa-bell"></i>', 'text' => 'إشعار بتأجيل أو إلغاء الدروس والمحاضرات'],
    ];
@endphp
<!DOCTYPE html>
<html lang="ar" dir="rtl" style="height: 100%;">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $siteName }}</title>
    <link rel="icon" href="/favicon.png" type="image/svg+xml">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;700;900&family=Amiri:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --deep-forest: #174032;
            --warm-gold: #d4af37;
            --soft-cream: #faf9f6;
            --pure-white: #ffffff;
            --charcoal-dark: #2c3e50;
            --border-subtle: #e8e8e8;
            --font-heading: 'Cairo', sans-serif;
            --font-body: 'Cairo', sans-serif;
        }
        body {
            background: var(--soft-cream);
            color: var(--charcoal-dark);
            font-family: var(--font-body);
            margin: 0;
            padding: 0;
            height: 100vh;
            display: flex;
            flex-direction: column;
            overflow: hidden; /* منع التمرير */
        }
        body.menu-open {
            overflow-y: auto;
        }
        .main-header {
            background: var(--deep-forest);
            border: none;
            box-shadow: none;
            padding: 1.2rem 0 1.1rem 0;
            position: relative;
        }
        .main-header::after {
            content: '';
            display: block;
            height: 4px;
            width: 100%;
            background: var(--warm-gold);
            position: absolute;
            bottom: 0;
            left: 0;
            border-radius: 0 0 8px 8px;
        }
        .header-content {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        .logo-icon {
            width: 40px;
            height: 40px;
            background: white;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--warm-gold);
            font-size: 1.3rem;
            border: 2px solid var(--warm-gold);
            margin-right: 1.5rem;
        }
        .logo-title {
            font-family: var(--font-heading);
            font-size: 1.35rem;
            font-weight: 900;
            color: var(--pure-white);
            margin: 0;
            letter-spacing: 0.5px;
        }
        .main-container {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem 2vw;
            max-width: 1400px;
            margin: 0 auto;
            width: 100%;
            gap: 4vw;
            overflow: hidden;
        }
        .masjid-side, .features-side {
            background: none;
            border: none;
            box-shadow: none;
            border-radius: 0;
            padding: 0 3vw;
            margin: 0;
        }
        .masjid-side {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;
            min-width: 320px;
        }
        .features-side {
            flex: 1.1;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            min-width: 320px;
        }
        .features-title {
            font-family: var(--font-heading);
            font-size: 1rem;
            font-weight: 900;
            color: var(--deep-forest);
            margin-bottom: 0.8rem;
            text-align: right;
        }
        .features-list {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            flex-direction: column;
            gap: 0.7rem;
        }
        .features-list li {
            display: flex;
            align-items: flex-start;
            gap: 0.5rem;
            font-size: 0.9rem;
            color: var(--charcoal-dark);
            line-height: 1.3;
        }
        .features-list .icon {
            color: var(--warm-gold);
            font-size: 1rem;
            margin-top: 0.05rem;
            flex-shrink: 0;
        }
        .masjid-side h2 {
            font-family: var(--font-heading);
            font-size: 1.1rem;
            font-weight: 900;
            color: var(--deep-forest);
            margin-bottom: 0.5rem;
            text-align: center;
        }
        .masjid-side p {
            font-size: 0.95rem;
            color: #444;
            margin-bottom: 1.5rem;
            text-align: center;
        }
        .masjid-btns {
            display: flex;
            flex-direction: column;
            gap: 0.8rem;
            margin-bottom: 1rem;
            width: 100%;
            max-width: 280px;
        }
        .masjid-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.6rem;
            background: var(--pure-white);
            border: 2px solid var(--border-subtle);
            border-radius: 8px;
            font-family: var(--font-heading);
            font-size: 1rem;
            font-weight: 700;
            color: var(--deep-forest);
            padding: 0.8rem 0.5rem;
            cursor: pointer;
            transition: border-color 0.2s, box-shadow 0.2s, background 0.2s;
            outline: none;
            width: 100%;
        }
        .masjid-btn.selected, .masjid-btn:focus, .masjid-btn:hover {
            border-color: var(--warm-gold);
            background: #fffbe9;
            box-shadow: 0 4px 16px rgba(212, 175, 55, 0.08);
        }
        .masjid-btn .icon {
            font-size: 1.2rem;
            color: var(--warm-gold);
        }
        .cta-btn {
            background: var(--warm-gold);
            color: var(--deep-forest);
            border: none;
            border-radius: 50px;
            font-family: var(--font-heading);
            font-size: 1rem;
            font-weight: 900;
            padding: 0.8rem 2rem;
            cursor: pointer;
            transition: background 0.2s, color 0.2s, box-shadow 0.2s;
            box-shadow: 0 4px 16px rgba(212, 175, 55, 0.13);
            margin-top: 0.5rem;
            width: 100%;
            max-width: 200px;
        }
        .cta-btn:hover, .cta-btn:focus {
            background: var(--deep-forest);
            color: var(--warm-gold);
            outline: 2px solid var(--warm-gold);
        }
        .footer {
            margin-top: auto; /* تغيير من margin-top محدد إلى auto لدفع التذييل للأسفل */
            padding: 1rem 0;
            text-align: center;
            font-size: 0.95rem;
            color: #888;
            font-family: var(--font-body);
        }
        @media (max-width: 1000px) {
            .main-container { flex-direction: column; align-items: stretch; gap: 3rem; padding-top: 2rem; }
            .masjid-side, .features-side { padding: 0 1.2rem; }
        }
        @media (max-width: 600px) {
            .header-content { flex-direction: column; gap: 0.7rem; }
            .masjid-side, .features-side { padding: 0 0.5rem; }
        }
        .masjid-btns a.masjid-btn {
            text-decoration: none !important;
        }
        .masjid-card {
            position: relative;
            z-index: 1;
            display: flex;
            align-items: flex-start;
            gap: 1rem;
        }
        
        .dropdown-container {
            position: relative;
        }
        
        .dropdown-arrow {
            margin-left: 8px;
            font-size: 12px;
            transition: transform 0.3s ease;
        }
        
        .dropdown-container.active .dropdown-arrow {
            transform: rotate(180deg);
        }
        
        .dropdown-menu {
                position: absolute;
                top: 0;
                left: -250px;
                width: 240px;
                background: white;
                border: 1px solid #ddd;
                border-radius: 8px;
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
                z-index: 1000;
                max-height: 300px;
                overflow-y: auto;
                display: none;
            }
        
        .dropdown-menu.show {
            display: block;
        }
        
        .dropdown-item {
            border-bottom: 1px solid #f0f0f0;
        }
        
        .dropdown-item:last-child {
            border-bottom: none;
        }
        
        .dropdown-btn {
            width: 100%;
            padding: 12px 16px;
            background: none;
            border: none;
            text-align: right;
            cursor: pointer;
            transition: background-color 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: flex-start;
            gap: 10px;
            font-size: 14px;
            color: #333;
        }
        
        .dropdown-btn:hover {
            background-color: #f8f9fa;
        }
        
        .dropdown-btn i {
            color: var(--deep-forest);
            font-size: 16px;
        }
        .masjid-card:has(.filter-section.active) {
            z-index: 20;
        }
        .masjid-btn {
            flex-shrink: 0;
        }
        .filter-section {
            padding: 0.8rem;
            background: #f8f9fa;
            border-radius: 6px;
            border: 1px solid var(--border-subtle);
            display: none;
            position: absolute;
            top: 0;
            right: 100%;
            margin-right: 10px;
            width: 300px;
            z-index: 1000;
            box-shadow: 0 4px 20px rgba(0,0,0,0.15);
            transition: all 0.3s ease;
        }
        .masjid-card {
            position: relative;
        }
        .filter-section.active {
            display: block;
        }
        .masjid-side {
            position: relative;
        }
        .filter-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0.6rem;
        }
        .filter-title {
            font-family: var(--font-heading);
            font-size: 0.9rem;
            font-weight: 700;
            color: var(--deep-forest);
            margin: 0;
        }
        .filter-close {
            background: none;
            border: none;
            color: var(--charcoal-dark);
            font-size: 1rem;
            cursor: pointer;
            padding: 0.2rem;
            border-radius: 50%;
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background-color 0.2s, color 0.2s;
        }
        .filter-close:hover {
            background-color: #e9ecef;
            color: var(--deep-forest);
        }
        .filter-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0.5rem;
            margin-bottom: 0.6rem;
        }
        .filter-group {
            min-width: 100px;
        }
        .filter-group label {
            display: block;
            font-size: 0.75rem;
            color: var(--charcoal-dark);
            margin-bottom: 0.2rem;
            font-weight: 600;
        }
        .filter-group select {
            width: 100%;
            padding: 0.3rem;
            border: 1px solid var(--border-subtle);
            border-radius: 4px;
            font-size: 0.75rem;
            background: white;
            color: var(--charcoal-dark);
        }
        .filter-group select:focus {
            outline: none;
            border-color: var(--warm-gold);
            box-shadow: 0 0 0 2px rgba(212, 175, 55, 0.1);
        }
        .filter-actions {
            display: flex;
            gap: 0.4rem;
            justify-content: center;
            margin-top: 0.6rem;
        }
        .filter-btn {
            padding: 0.4rem 0.8rem;
            border: none;
            border-radius: 4px;
            font-size: 0.75rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
        }
        .filter-btn.primary {
            background: var(--warm-gold);
            color: var(--deep-forest);
        }
        .filter-btn.primary:hover {
            background: var(--deep-forest);
            color: var(--warm-gold);
        }
        .filter-btn.secondary {
            background: #6c757d;
            color: white;
        }
        .filter-btn.secondary:hover {
            background: #5a6268;
        }
    </style>
</head>
<body>
    <header class="main-header">
        <div class="header-content">
            <div class="logo-icon">
                @if($iconUrl)
                    <img src="{{ $iconUrl }}" alt="Logo" style="width: 60px; height: 60px; object-fit: contain;">
                @else
                    <i class="fas fa-mosque"></i>
                @endif
            </div>
            <h1 class="logo-title">{{ $siteName }}</h1>
        </div>
    </header>
    <div class="main-container">
        <div class="masjid-side">
            <h2>اختر المسجد</h2>
            <p>يرجى اختيار المسجد الذي ترغب في عرض فعالياته.</p>
            <div class="masjid-btns" id="masjidBtns">
                @foreach($masjidCards as $i => $masjid)
                    <div class="masjid-card">
                        <button class="masjid-btn" data-masjid-id="{{ $masjid['id'] }}" onclick="{{ $masjid['id'] === 'all' ? 'showBothMosques()' : 'toggleFilters(' . $masjid['id'] . ')' }}" tabindex="0" style="width:100%; display:block; text-align:center;">
                            <span class="icon">{!! $masjid['icon'] !!}</span>
                            <span>{{ $masjid['name'] }}</span>
                        </button>
                        
                        
                        <div class="filter-section" id="filters-{{ $masjid['id'] }}">
                            <div class="filter-header">
                                <div class="filter-title">اختر المرشحات</div>
                                <button type="button" class="filter-close" onclick="closeFilters({{ $masjid['id'] }})" aria-label="إغلاق">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                            <form id="filterForm-{{ $masjid['id'] }}">
                                <div class="filter-row">
                                    <div class="filter-group">
                                        <label for="programType-{{ $masjid['id'] }}">نوع البرنامج</label>
                                        <select name="program_type" id="programType-{{ $masjid['id'] }}">
                                            <option value="">الكل</option>
                                            @if(isset($programTypes))
                                                @foreach($programTypes as $type)
                                                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    <div class="filter-group">
                                        <label for="section-{{ $masjid['id'] }}">القسم</label>
                                        <select name="section" id="section-{{ $masjid['id'] }}">
                                            <option value="">الكل</option>
                                            @if(isset($sections))
                                                @foreach($sections as $section)
                                                    <option value="{{ $section->id }}">{{ $section->name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="filter-row">
                                    <div class="filter-group">
                                        <label for="direction-{{ $masjid['id'] }}">الواجهة</label>
                                        <select name="direction" id="direction-{{ $masjid['id'] }}">
                                            <option value="">الكل</option>
                                            @if(isset($locations))
                                                @foreach($locations->pluck('direction')->unique()->filter() as $direction)
                                                    <option value="{{ $direction }}">{{ $direction }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    <div class="filter-group">
                                        <label for="floors-{{ $masjid['id'] }}">الدور</label>
                                        <select name="floors_count" id="floors-{{ $masjid['id'] }}">
                                            <option value="">الكل</option>
                                            @if(isset($locations))
                                                @foreach($locations->pluck('floors_count')->unique()->sort() as $floors)
                                                    <option value="{{ $floors }}">{{ $floors }} دور</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="filter-row">
                                    <div class="filter-group">
                                        <label for="location-{{ $masjid['id'] }}">الموقع</label>
                                        <select name="location_id" id="location-{{ $masjid['id'] }}">
                                            <option value="">الكل</option>
                                            @if(isset($locations))
                                                @foreach($locations as $location)
                                                    <option value="{{ $location->id }}">مبنى {{ $location->building_number }} - {{ $location->masjid->name ?? '' }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="filter-actions">
                                    <button type="button" class="filter-btn primary" onclick="applyFilters({{ $masjid['id'] }})">عرض النتائج</button>
                                    <button type="button" class="filter-btn secondary" onclick="resetFilters({{ $masjid['id'] }})">إعادة تعيين</button>
                                </div>
                            </form>
                        </div>
                    </div>
                @endforeach
                
                <!-- Filter sections for other masjids from dropdown -->
                @foreach($otherMasjids as $otherMasjid)
                    <div class="filter-section" id="filters-{{ $otherMasjid->id }}">
                        <div class="filter-header">
                            <div class="filter-title">  اختر المرشحات</div>
                            <button type="button" class="filter-close" onclick="closeFilters({{ $otherMasjid->id }})" aria-label="إغلاق">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                        <form id="filterForm-{{ $otherMasjid->id }}">
                            <div class="filter-row">
                                <div class="filter-group">
                                    <label for="programType-{{ $otherMasjid->id }}">نوع البرنامج</label>
                                    <select name="program_type" id="programType-{{ $otherMasjid->id }}">
                                        <option value="">الكل</option>
                                        @if(isset($programTypes))
                                            @foreach($programTypes as $type)
                                                <option value="{{ $type->id }}">{{ $type->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="filter-group">
                                    <label for="section-{{ $otherMasjid->id }}">القسم</label>
                                    <select name="section" id="section-{{ $otherMasjid->id }}">
                                        <option value="">الكل</option>
                                        @if(isset($sections))
                                            @foreach($sections as $section)
                                                <option value="{{ $section->id }}">{{ $section->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="filter-row">
                                <div class="filter-group">
                                    <label for="direction-{{ $otherMasjid->id }}">الواجهة</label>
                                    <select name="direction" id="direction-{{ $otherMasjid->id }}">
                                        <option value="">الكل</option>
                                        @if(isset($locations))
                                            @foreach($locations->pluck('direction')->unique()->filter() as $direction)
                                                <option value="{{ $direction }}">{{ $direction }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="filter-group">
                                    <label for="floors-{{ $otherMasjid->id }}">الدور</label>
                                    <select name="floors_count" id="floors-{{ $otherMasjid->id }}">
                                        <option value="">الكل</option>
                                        @if(isset($locations))
                                            @foreach($locations->pluck('floors_count')->unique()->sort() as $floors)
                                                <option value="{{ $floors }}">{{ $floors }} دور</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="filter-row">
                                <div class="filter-group">
                                    <label for="location-{{ $otherMasjid->id }}">الموقع</label>
                                    <select name="location_id" id="location-{{ $otherMasjid->id }}">
                                        <option value="">الكل</option>
                                        @if(isset($locations))
                                            @foreach($locations as $location)
                                                <option value="{{ $location->id }}">مبنى {{ $location->building_number }} - {{ $location->masjid->name ?? '' }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="filter-actions">
                                <button type="button" class="filter-btn primary" onclick="applyFilters({{ $otherMasjid->id }})">عرض النتائج</button>
                                <button type="button" class="filter-btn secondary" onclick="resetFilters({{ $otherMasjid->id }})">إعادة تعيين</button>
                            </div>
                        </form>
                    </div>
                @endforeach
            </div>
            <button class="cta-btn" id="startBtn" style="display:none;">ابدأ العرض</button>
        </div>
        <div class="features-side" aria-label="الشاشة التفاعلية">
            <div class="features-title">الشاشة التفاعلية</div>
            <ul class="features-list">
                @foreach($features as $feature)
                <li><span class="icon">{!! $feature['icon'] !!}</span> <span>{{ $feature['text'] }}</span></li>
                @endforeach
            </ul>
        </div>
    </div>
    <footer class="footer">
        <span>حقوق الهيئة العامة للعناية بشؤون المسجد الحرام والمسجد النبوي محفوظة</span>
    </footer>
    <script>
        let activeFilters = null;

        function toggleFilters(masjidId, masjidName) {
            // Close all other filter sections first
            document.querySelectorAll('.filter-section').forEach(section => {
                if (section.id !== `filters-${masjidId}`) {
                    section.classList.remove('active');
                }
            });

            const filterSection = document.getElementById(`filters-${masjidId}`);
            const isActive = filterSection.classList.contains('active');

            if (isActive) {
                filterSection.classList.remove('active');
                activeFilters = null;
                document.body.classList.remove('menu-open');
            } else {
                filterSection.classList.add('active');
                activeFilters = masjidId;
                document.body.classList.add('menu-open');
                // Update the filter header title
                const filterTitle = filterSection.querySelector('.filter-title');
                if (filterTitle) {
                    filterTitle.textContent = `اختر المرشحات`;
                }
            }
        }
        
        function closeFilters(masjidId) {
            const filterSection = document.getElementById(`filters-${masjidId}`);
            if (filterSection) {
                filterSection.classList.remove('active');
                activeFilters = null;
                document.body.classList.remove('menu-open');
            }
        }
        
        function showBothMosques() {
            // Directly redirect to show both Al-Haram and Al-Nabawi mosques
            window.location.href = '/masjids/1/display?show_all=true';
        }
        
        function applyFilters(masjidId) {
            const form = document.getElementById(`filterForm-${masjidId}`);
            const formData = new FormData(form);
            const params = new URLSearchParams();
            
            // Add filters to URL parameters
            for (let [key, value] of formData.entries()) {
                if (value.trim() !== '') {
                    params.append(key, value);
                }
            }
            
            // Determine the URL based on masjid selection
            let baseUrl;
            if (masjidId === 'all') {
                // For "الكل", we can use the first masjid or create a combined view
                baseUrl = '/masjids/1/display';
                params.append('show_all', 'true');
            } else {
                baseUrl = `/masjids/${masjidId}/display`;
            }
            
            // Redirect to display page with filters
            const url = baseUrl + (params.toString() ? '?' + params.toString() : '');
            window.location.href = url;
        }
        
        function resetFilters(masjidId) {
            const form = document.getElementById(`filterForm-${masjidId}`);
            form.reset();
        }
        
        // Close filters when clicking outside
        document.addEventListener('click', function(event) {
            if (!event.target.closest('.masjid-card') && !event.target.closest('.filter-section') && activeFilters) {
                document.getElementById(`filters-${activeFilters}`).classList.remove('active');
                document.body.classList.remove('menu-open');
                activeFilters = null;
            }
        });
    </script>
</body>
</html>
