@php
function dash($val) {
    if (is_array($val)) {
        $filtered = array_filter($val, function($v) { return $v !== null && $v !== ''; });
        return count($filtered) ? implode('، ', $filtered) : '—';
    }
    return isset($val) && $val !== '' ? $val : '—';
}
@endphp


<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>عرض في شاشات الحرم: {{ $masjid->name }}</title>
    <link rel="icon" href="/favicon.png" type="image/svg+xml">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700;900&family=Amiri:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --deep-forest: #174032;
            --warm-gold: #d4af37;
            --soft-cream: #faf9f6;
            --pure-white: #ffffff;
            --charcoal-dark: #2c3e50;
            --border-subtle: #e8e8e8;
            --urgent-red: #e74c3c;
            --primary-gradient: linear-gradient(135deg, #174032 0%, #174032 100%);
            --gold-gradient: linear-gradient(135deg, #d4af37 0%, #d4af37 100%);
            --background-gradient: linear-gradient(135deg, #faf9f6 0%, #faf9f6 100%);
            --card-gradient: linear-gradient(145deg, #ffffff 0%, #ffffff 100%);
            --border-radius: 10px;
            --border-radius-lg: 50px;
            --transition: all 0.2s ease-in-out;
        }
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
            overflow: hidden;
            background: var(--soft-cream);
            font-family: 'Cairo', 'Amiri', serif;
        }
        body {
            width: 100vw;
            height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: stretch;
            justify-content: flex-start;
        }
        .dashboard-header {
            background: #ffffff;
            color: #174032;
            padding: 0.3vw 2vw;
            font-family: 'Cairo', sans-serif;
            position: relative;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            border-bottom: 3px solid #174032;
            display: flex;
            align-items: center;
            justify-content: space-between;
            min-height: 2vw;
        }
        .navbar-left {
            display: flex;
            align-items: center;
            gap: 1.5vw;
        }
        
        .back-button-container {
            position: absolute;
            left: 1vw;
            top: 50%;
            transform: translateY(-50%);
        }
        
        .back-button {
            background: white;
            color: #174032;
            border: none;
            padding: 0.5vw 1vw;
            border-radius: 8px;
            font-size: 0.8vw;
            font-family: 'Cairo', 'Amiri', serif;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 0.5vw;
            transition: all 0.3s ease;
        }
        
        .back-button:hover {
            background: #f8f9fa;
            transform: translateX(-2px);
        }
        
        .navbar-logo {
            width: auto;
            height: 3.5vw;
            display: flex;
            align-items: center;
            justify-content: center;
            aspect-ratio: 2;
        }
        
        .navbar-logo img {
            width: 100%;
            height: 100%;
            border-radius: 8px;
            object-fit: cover;
        }
        
        .navbar-titles {
            display: flex;
            flex-direction: column;
            gap: 0.2vw;
        }
        
        .site-name {
            color: #174032;
            font-size: 0.8vw;
            font-weight: 600;
            line-height: 1.2;
        }
        
        .masjid-name {
            color: #174032;
            font-size: 0.8vw;
            font-weight: 900;
            line-height: 1.2;
            text-align: center;
        }
        
        .navbar-center {
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            align-items: center;
        }
        
        .info-bar {
            display: flex;
            flex-direction: row;
            justify-content: center;
            align-items: stretch;
            gap: 0.05vw;
            margin: 0.1vw auto 0.05vw auto;
            font-size: 0.6vw;
            width: 98vw;
        }
        .info-item {
            background: var(--pure-white);
            border-radius: var(--border-radius);
            box-shadow: 0 1px 4px rgba(23,64,50,0.07);
            padding: 0.02vw 0.05vw;
            flex: 1 1 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            font-size: 0.6vw;
        }
        .info-item-center {
            background: var(--pure-white);
            border-radius: var(--border-radius);
            box-shadow: 0 1px 4px rgba(23,64,50,0.07);
            padding: 0.3vw 0.5vw;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            font-size: 0.6vw; 
            width: 100%;
            gap: 0.1vw;
            border: 1px solid var(--border-subtle);
            margin: 0 0.01vw;
        }
        .info-label {
            color: var(--charcoal-dark);
            font-size: 0.6vw;
            font-weight: 700;
        }
        .info-value {
            color: var(--deep-forest);
            font-size: 0.8vw;
            font-weight: 900;
        }
        .marquee-container {
            width: 98vw;
            margin: 0.5vw auto;
            background: var(--pure-white);
            border-radius: var(--border-radius);
            box-shadow: 0 1px 4px rgba(23,64,50,0.07);
            padding: 0.2vw 0.5vw;
            overflow: hidden;
            border: 1px solid var(--border-subtle);
            direction: rtl;
        }
        .marquee-wrapper {
            display: flex;
            width: 200%;
            position: relative;
        }
        .marquee {
            white-space: nowrap;
            overflow: hidden;
            font-size: 0.8vw;
            font-weight: 600;
            color: var(--deep-forest);
            display: inline-block;
            position: relative;
            width: 100%;
        }
        .marquee-clone {
            position: relative;
        }
        .marquee span {
            margin-left: 2vw;
        }
        .marquee span.urgent {
            color: var(--urgent-red);
            font-weight: 700;
        }
        .marquee span.normal {
            color: var(--deep-forest);
        }
        
        /* Fullscreen Urgent Announcement */
        .urgent-fullscreen {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background-color: rgba(231, 76, 60, 0.95);
            z-index: 9999;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 2vw;
            box-sizing: border-box;
            animation: pulse 2s infinite;
        }
        
        .urgent-content {
            background-color: var(--pure-white);
            border-radius: var(--border-radius);
            padding: 2vw;
            max-width: 90vw;
            max-height: 80vh;
            overflow-y: auto;
            box-shadow: 0 0 30px rgba(0, 0, 0, 0.3);
            border: 5px solid var(--warm-gold);
            text-align: center;
        }
        
        .urgent-header {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.5vw;
            color: var(--urgent-red);
        }
        
        .urgent-icon {
            font-size: 3vw;
            margin-left: 1vw;
            animation: shake 0.5s infinite;
        }
        
        .urgent-title {
            font-size: 2.5vw;
            font-weight: 900;
            color: var(--urgent-red);
            margin: 0;
        }
        
        .urgent-body {
            font-size: 1.8vw;
            line-height: 1.6;
            color: var(--charcoal-dark);
            margin-bottom: 2vw;
            text-align: right;
        }
        
        .urgent-footer {
            font-size: 1.2vw;
            color: var(--deep-forest);
            font-weight: 700;
            margin-top: 1vw;
        }
        
        .urgent-close {
            background-color: var(--warm-gold);
            color: var(--deep-forest);
            border: none;
            border-radius: var(--border-radius);
            padding: 0.5vw 2vw;
            font-size: 1.2vw;
            font-weight: 700;
            cursor: pointer;
            margin-top: 1vw;
            transition: var(--transition);
        }
        
        .urgent-close:hover {
            background-color: var(--deep-forest);
            color: var(--warm-gold);
        }
        
        @keyframes pulse {
            0% { box-shadow: 0 0 0 0 rgba(231, 76, 60, 0.7); }
            70% { box-shadow: 0 0 0 20px rgba(231, 76, 60, 0); }
            100% { box-shadow: 0 0 0 0 rgba(231, 76, 60, 0); }
        }
        
        @keyframes shake {
            0% { transform: rotate(0deg); }
            25% { transform: rotate(5deg); }
            50% { transform: rotate(0deg); }
            75% { transform: rotate(-5deg); }
            100% { transform: rotate(0deg); }
        }
        
        /* CSS keyframes for marquee animation - continuous movement with no delay */
        @keyframes scroll-right {
            0% { transform: translateX(0); }
            100% { transform: translateX(-200%); }
        }
        
        /* Apply animation to marquee wrapper for seamless scrolling */
        .marquee-wrapper {
            animation: scroll-right 40s linear infinite;
        }
        
        .tables-vertical {
            display: flex;
            flex-direction: column;
            gap: 0.7vw;
            width: 100vw;
            align-items: stretch;
            justify-content: flex-start;
        }
        .table-section {
            background: var(--pure-white);
            border-radius: var(--border-radius);
            box-shadow: 0 2px 8px rgba(23,64,50,0.10);
            padding: 0.5vw 0.5vw 0.5vw 0.5vw;
            min-width: 0;
            width: 98vw;
            margin: 0 auto;
            font-size: 0.95vw;
            overflow: hidden;
            border: 1.5px solid var(--border-subtle);
        }
        .table-section h4 {
            color: var(--deep-forest);
            font-size: 0.9vw;
            font-weight: bold;
            margin-bottom: 0.2vw;
            margin-top: 0.1vw;
            text-align: right;
            background: var(--primary-gradient);
            color: var(--warm-gold);
            padding: 0.3vw 0.7vw;
            border-radius: var(--border-radius) var(--border-radius) 0 0;
            border-bottom: 2px solid var(--warm-gold);
            box-shadow: 0 1px 4px rgba(23,64,50,0.04);
        }
        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            font-size: 0.75vw;
            background: var(--pure-white);
            border-radius: var(--border-radius);
            overflow: hidden;
        }
        th, td {
            border: 1px solid var(--border-subtle);
            padding: 0.15vw 0.2vw;
            text-align: center;
        }
        
        /* Column width consistency */
        th:nth-child(6), td:nth-child(6) { /* من column */
            width: 8%;
            min-width: 8%;
        }
        
        th:nth-child(7), td:nth-child(7) { /* إلى column */
            width: 8%;
            min-width: 8%;
        }
        
        th:nth-child(1), td:nth-child(1) { /* الكتاب column */
            width: 12%;
            min-width: 12%;
        }
        
        th:nth-child(4), td:nth-child(4) { /* المستوى column */
            width: 10%;
            min-width: 10%;
        }
        
        /* Location column width for حلقة تحفيظ table (8th column) */
        th:nth-child(8), td:nth-child(8) { 
            width: 12%;
            min-width: 12%;
        }
        th {
            background: var(--primary-gradient);
            color: var(--warm-gold);
            font-weight: 700;
            border-bottom: 2px solid var(--warm-gold);
        }
        tbody tr {
            transition: var(--transition);
        }
        tbody tr:hover {
            background: #fffbe9;
        }
        
        /* Imama Table Specific Styles */
        .table-section table:has(th:contains("الفجر - أذان")) {
            font-size: 0.7vw;
            min-width: 100%;
        }
        
        .table-section table:has(th:contains("الفجر - أذان")) th,
        .table-section table:has(th:contains("الفجر - أذان")) td {
            padding: 0.1vw 0.15vw;
            font-size: 0.7vw;
            white-space: nowrap;
            min-width: 4.5vw;
        }
        
        .table-section table:has(th:contains("الفجر - أذان")) th:first-child,
        .table-section table:has(th:contains("الفجر - أذان")) td:first-child {
            min-width: 6vw;
        }
        
        .table-section table:has(th:contains("الفجر - أذان")) th:last-child,
        .table-section table:has(th:contains("الفجر - أذان")) td:last-child {
            min-width: 5vw;
        }
        
        /* Alternative approach using class-based targeting */
        .imama-table {
            font-size: 0.7vw !important;
            min-width: 100%;
        }
        
        .imama-table th,
        .imama-table td {
            padding: 0.1vw 0.15vw !important;
            font-size: 0.7vw !important;
            white-space: nowrap;
            min-width: 4.5vw;
        }
        
        .imama-table th:first-child,
        .imama-table td:first-child {
            min-width: 6vw;
        }
        
        .imama-table th:last-child,
        .imama-table td:last-child {
            min-width: 5vw;
        }
        
        @media (max-width: 1200px) {
            .dashboard-header { font-size: 1rem; }
            .site-name { font-size: 0.8rem; }
            .masjid-name { font-size: 0.8rem; }
            .back-button { font-size: 0.7rem; padding: 0.4rem 0.8rem; }
            .info-label, .info-value, .marquee, .table-section h4 { font-size: 0.8rem; }
            .imama-table { font-size: 0.6vw !important; }
            .imama-table th, .imama-table td { font-size: 0.6vw !important; padding: 0.08vw 0.12vw !important; }
        }
        @media (max-width: 900px) {
            .tables-vertical { gap: 0.3vw; }
            .table-section { width: 99vw; padding: 0.3vw; }
            .imama-table { font-size: 0.5vw !important; }
            .imama-table th, .imama-table td { font-size: 0.5vw !important; padding: 0.06vw 0.1vw !important; }
        }
        
        .status-badge {
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 0.8em;
            font-weight: bold;
        }
        
        .status-نشط {
            background-color: #d4edda;
            color: #155724;
        }
        
        .status-متوقف {
            background-color: #f8d7da;
            color: #721c24;
        }
        
        .status-قريباً {
            background-color: #fff3cd;
            color: #856404;
        }
        
        /* Time-based visibility styles */
        .program-upcoming {
            background-color: #fff3cd;
            animation: pulse 2s infinite;
        }
        
        .program-active {
            background-color: #d4edda;
            border-left: 4px solid #28a745;
        }
        
        .program-ending {
            background-color: #f8d7da;
            opacity: 0.7;
        }
        
        .program-hidden {
            display: none;
        }
        
        /* Prayer visibility classes removed since Imama programs are always shown */
        
        @keyframes pulse {
            0% { opacity: 1; }
            50% { opacity: 0.7; }
            100% { opacity: 1; }
        }
    </style>
</head>
<body>

<div id="urgent-announcement" style="display: none;" class="urgent-fullscreen">
    <div class="urgent-content">
        <div class="urgent-header">
            <i class="fas fa-exclamation-triangle urgent-icon"></i>
            <h1 class="urgent-title">إعلان عاجل</h1>
        </div>
        <div id="urgent-body" class="urgent-body"></div>
        <div class="urgent-footer">
            <!-- <button class="urgent-close" onclick="hideUrgentAnnouncement()">إغلاق</button> -->
        </div>
    </div>
</div>

<div style="color:blue"></div>
    <div class="dashboard-header">
        <div class="back-button-container">
            <button class="back-button" onclick="window.history.back()">
                <i class="fas fa-arrow-right"></i>
                <span>رجوع</span>
            </button>
        </div>
        
        <div class="navbar-left">
            @if($iconUrl)
                <div class="navbar-logo">
                    <img src="{{ $iconUrl }}" alt="شعار الهيئة">
                </div>
            @endif
            <div class="navbar-titles">
                <div class="site-name">{{ $siteName }}</div>
            </div>
        </div>
        
        <div class="navbar-center">
            <div class="masjid-name">{{ $masjid->name }}</div>
        </div>
        
        @php
            $currentDate = now();
            $arabicDays = [
                'Sunday' => 'الأحد',
                'Monday' => 'الإثنين', 
                'Tuesday' => 'الثلاثاء',
                'Wednesday' => 'الأربعاء',
                'Thursday' => 'الخميس',
                'Friday' => 'الجمعة',
                'Saturday' => 'السبت'
            ];
            $arabicMonths = [
                1 => 'محرم', 2 => 'صفر', 3 => 'ربيع الأول', 4 => 'ربيع الآخر',
                5 => 'جمادى الأولى', 6 => 'جمادى الآخرة', 7 => 'رجب', 8 => 'شعبان',
                9 => 'رمضان', 10 => 'شوال', 11 => 'ذو القعدة', 12 => 'ذو الحجة'
            ];
            $gregorianMonths = [
                1 => 'يناير', 2 => 'فبراير', 3 => 'مارس', 4 => 'أبريل',
                5 => 'مايو', 6 => 'يونيو', 7 => 'يوليو', 8 => 'أغسطس',
                9 => 'سبتمبر', 10 => 'أكتوبر', 11 => 'نوفمبر', 12 => 'ديسمبر'
            ];
            
            // Get current Hijri year from database
            $hijriYear = \App\Models\HijriYear::where('start_date', '<=', $currentDate->toDateString())
                ->where('end_date', '>=', $currentDate->toDateString())
                ->first();
            
            $dayName = $arabicDays[$currentDate->format('l')];
            $gregorianDay = $currentDate->day;
            $gregorianMonth = $gregorianMonths[$currentDate->month];
            $gregorianYear = $currentDate->year;
            
            if ($hijriYear) {
                // Calculate approximate Hijri date
                $startDate = \Carbon\Carbon::parse($hijriYear->start_date);
                $daysDiff = $currentDate->diffInDays($startDate);
                
                // Handle negative daysDiff (when current date is before start date)
                if ($daysDiff < 0) {
                    $daysDiff = abs($daysDiff);
                    $hijriDay = 30 - ($daysDiff % 30);
                    if ($hijriDay == 0) $hijriDay = 30;
                    $hijriMonth = 12 - intval($daysDiff / 30);
                    if ($hijriMonth <= 0) {
                        $hijriMonth = 12 + ($hijriMonth % 12);
                        if ($hijriMonth == 0) $hijriMonth = 12;
                    }
                } else {
                    $hijriDay = $daysDiff % 30 + 1; // Approximate day in month
                    $hijriMonth = intval($daysDiff / 30) + 1; // Approximate month
                    if ($hijriMonth > 12) {
                        $hijriMonth = $hijriMonth % 12;
                        if ($hijriMonth == 0) $hijriMonth = 12;
                    }
                }
                
                // Ensure month is within valid range (1-12)
                $hijriMonth = max(1, min(12, $hijriMonth));
                $hijriMonthName = $arabicMonths[$hijriMonth];
                $hijriYearNum = $hijriYear->year;
            } else {
                // Fallback if no Hijri year found - set to current month (Rabi' al-Thani)
                $hijriDay = 15;
                $hijriMonthName = 'ربيع الآخر';
                $hijriYearNum = 1446;
            }
        @endphp
        
       
    </div>
    <div class="info-bar">
                <div class="image.png"><div class="info-label">المساحة الكلية</div><div class="info-value">{{ dash($masjid->total_area) }}</div></div>
                <div class="info-item"><div class="info-label">الطاقة الاستيعابية</div><div class="info-value">{{ dash($masjid->capacity) }}</div></div>
                <div class="info-item"><div class="info-label">عدد الأبواب</div><div class="info-value">{{ dash($masjid->gate_count) }}</div></div>
                <div class="info-item"><div class="info-label">عدد الأجنحة</div><div class="info-value">{{ dash($masjid->wing_count) }}</div></div>
                <div class="info-item"><div class="info-label">عدد قاعات الصلاة</div><div class="info-value">{{ dash($masjid->prayer_hall_count) }}</div></div>
                <div class="info-item"><div class="info-label">عدد الطواف بالساعة</div><div class="info-value">{{ dash($masjid->tawaf_per_hour) }}</div></div>

            </div>
    
    <!-- Date and Time Information -->
    <div class="info-bar">
        <div class="info-item-center">
            <div class="info-label">التاريخ والوقت</div>
            <div class="info-value" id="hijri-date-time">جاري التحميل...</div>
        </div>
    </div>
    
    <div class="marquee-container">
        <div class="marquee-wrapper">
            <div id="marquee-js" class="marquee"></div>
            <div id="marquee-js-clone" class="marquee marquee-clone"></div>
        </div>
    </div>
    <script>
        // All announcements as JS objects
        let announcements = @json($announcementsArray);
        let urgentDisplayed = false;
        let urgentTimeout = null;
        let lastMarqueeContent = '';
        let marqueeInterval = null;
        
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
            
            // Display urgent announcement fullscreen if available and not already displayed
            if (urgent.length > 0 && !urgentDisplayed) {
                const urgentAnnouncement = urgent[0]; // Take the first urgent announcement
                document.getElementById('urgent-body').innerHTML = urgentAnnouncement.content;
                document.getElementById('urgent-announcement').style.display = 'flex';
                urgentDisplayed = true;
                
                // Set a timer to automatically hide the urgent announcement after 30 seconds
                urgentTimeout = setTimeout(() => {
                    document.getElementById('urgent-announcement').style.display = 'none';
                    urgentDisplayed = false;
                    urgentTimeout = null;
                }, 30000);
            } else if (urgent.length === 0 && urgentDisplayed) {
                // Hide urgent announcement if no urgent announcements are active
                document.getElementById('urgent-announcement').style.display = 'none';
                urgentDisplayed = false;
                if (urgentTimeout) {
                    clearTimeout(urgentTimeout);
                    urgentTimeout = null;
                }
            }
            
            if (urgent.length || scheduled.length) {
                urgent.forEach(a => {
                    html += `<span class='urgent'><i class='fas fa-exclamation-triangle'></i> ${a.content}</span>`;
                });
                scheduled.forEach(a => {
                    html += `<span class='normal'>${a.content}</span>`;
                });
                
                // Only update marquee content if it has changed
            if (html !== lastMarqueeContent) {
                document.getElementById('marquee-js').innerHTML = html;
                document.getElementById('marquee-js-clone').innerHTML = html;
                lastMarqueeContent = html;
                startMarqueeScroll();
            }
            } else {
                const noAnnouncementsHtml = '<span class="normal">لا توجد إعلانات حالية</span>';
                if (noAnnouncementsHtml !== lastMarqueeContent) {
                    document.getElementById('marquee-js').innerHTML = noAnnouncementsHtml;
                    document.getElementById('marquee-js-clone').innerHTML = noAnnouncementsHtml;
                    lastMarqueeContent = noAnnouncementsHtml;
                    startMarqueeScroll();
                }
            }
        }
        
        function hideUrgentAnnouncement() {
            document.getElementById('urgent-announcement').style.display = 'none';
        }
        
        updateMarquee();
        // Start initial marquee scrolling
        setTimeout(() => {
            startMarqueeScroll();
        }, 100);
        setInterval(updateMarquee, 1000);
        
        // Show urgent announcement every 5 minutes
        setInterval(() => {
            const now = new Date();
            const urgent = announcements.filter(a => a.is_urgent && isActive(a, now));
            if (urgent.length > 0 && !urgentDisplayed) {
                const urgentAnnouncement = urgent[0];
                document.getElementById('urgent-body').innerHTML = urgentAnnouncement.content;
                document.getElementById('urgent-announcement').style.display = 'flex';
                urgentDisplayed = true;
                
                // Hide after 30 seconds
                urgentTimeout = setTimeout(() => {
                    document.getElementById('urgent-announcement').style.display = 'none';
                    urgentDisplayed = false;
                    urgentTimeout = null;
                }, 30000);
            }
        }, 300000); // 5 minutes

        // Real-time updates using AJAX polling
        let lastAnnouncementTimestamp = 0;
        let lastProgramTimestamp = 0;
        
        // Function to handle marquee animation and ensure seamless scrolling
        function startMarqueeScroll() {
            // Reset the animation to ensure it starts fresh
            const wrapper = document.querySelector('.marquee-wrapper');
            if (wrapper) {
                // Briefly pause animation to reset it
                wrapper.style.animationPlayState = 'paused';
                
                // Force a reflow to ensure the animation restarts properly
                void wrapper.offsetWidth;
                
                // Resume animation
                wrapper.style.animationPlayState = 'running';
            }
            
            // Clear any existing interval
            if (marqueeInterval) {
                clearInterval(marqueeInterval);
                marqueeInterval = null;
            }
        }
        
        // Function to update announcements
        function updateAnnouncements() {
            fetch(`/api/masjids/{{ $masjid->id }}/announcements`)
                .then(response => response.json())
                .then(data => {
                    if (data.timestamp > lastAnnouncementTimestamp) {
                        // Update announcements array
                        announcements = data.announcements;
                        lastAnnouncementTimestamp = data.timestamp;
                        
                        // Reset marquee content to trigger update
                        lastMarqueeContent = null;
                        updateMarquee();
                        
                        console.log('Announcements updated');
                    }
                })
                .catch(error => {
                    console.error('Error fetching announcements:', error);
                });
        }
        
        // Function to update programs/table data
        function updatePrograms() {
            const urlParams = new URLSearchParams(window.location.search);
            const queryString = urlParams.toString();
            const apiUrl = `/api/masjids/{{ $masjid->id }}/programs${queryString ? '?' + queryString : ''}`;
            
            fetch(apiUrl)
                .then(response => response.json())
                .then(data => {
                    if (data.timestamp > lastProgramTimestamp) {
                        // Update table content
                        updateTableContent(data.programs);
                        lastProgramTimestamp = data.timestamp;
                        
                        console.log('Programs updated');
                    }
                })
                .catch(error => {
                    console.error('Error fetching programs:', error);
                });
        }
        
        // Function to update table content
        function updateTableContent(programsByType) {
            const tablesContainer = document.querySelector('.tables-vertical');
            if (!tablesContainer) return;
            
            // Check if content has changed by comparing JSON strings
            const newContent = JSON.stringify(programsByType);
            if (tablesContainer.dataset.lastContent === newContent) {
                return; // No changes
            }
            
            // Store new content hash
            tablesContainer.dataset.lastContent = newContent;
            
            // Clear existing content
            tablesContainer.innerHTML = '';
            
            // Rebuild tables
            if (Object.keys(programsByType).length > 0) {
                Object.entries(programsByType).forEach(([programTypeName, programs]) => {
                    const isImama = programTypeName === 'إمامة' || programTypeName === 'الإمامة';
                    
                    const tableSection = document.createElement('div');
                    tableSection.className = 'table-section';
                    
                    const header = document.createElement('h4');
                    header.innerHTML = `<i class="fas fa-${isImama ? 'mosque' : 'book-open'}"></i> ${programTypeName}`;
                    tableSection.appendChild(header);
                    
                    const table = document.createElement('table');
                    if (isImama) {
                        table.className = 'imama-table';
                        table.innerHTML = buildImamaProgramsTable(programs);
                    } else {
                        table.innerHTML = buildRegularProgramsTable(programs);
                    }
                    
                    tableSection.appendChild(table);
                    tablesContainer.appendChild(tableSection);
                });
            } else {
                const noDataSection = document.createElement('div');
                noDataSection.className = 'table-section';
                noDataSection.innerHTML = `
                    <h4><i class="fas fa-info-circle"></i> لا توجد برامج منظمة</h4>
                    <p style="text-align: center; color: #666; padding: 2rem;">لا توجد برامج منظمة مسجلة لهذا المسجد حالياً.</p>
                `;
                tablesContainer.appendChild(noDataSection);
            }
        }
        
        // Imama programs are always shown - no time-based filtering needed
        
        // Helper function to build Imama programs table - always show all programs
        function buildImamaProgramsTable(programs) {
            let html = `
                <thead>
                    <tr>
                        <th colspan="3">الفجر</th>
                        <th colspan="3">الظهر</th>
                        <th colspan="3">العصر</th>
                        <th colspan="3">المغرب</th>
                        <th colspan="3">العشاء</th>
                        <th colspan="3">الجمعة</th>
                    </tr>
                    <tr>
                        <th>أذان</th>
                        <th>إقامة</th>
                        <th>إمام</th>
                        <th>أذان</th>
                        <th>إقامة</th>
                        <th>إمام</th>
                        <th>أذان</th>
                        <th>إقامة</th>
                        <th>إمام</th>
                        <th>أذان</th>
                        <th>إقامة</th>
                        <th>إمام</th>
                        <th>أذان</th>
                        <th>إقامة</th>
                        <th>إمام</th>
                        <th>أذان</th>
                        <th>إقامة</th>
                        <th>إمام</th>
                    </tr>
                </thead>
                <tbody>
            `;
            
            programs.forEach(program => {
                // Always show Imama programs - no time filtering
                const dynamicStatus = getDynamicProgramStatus(program);
                 html += `
                     <tr>
                         <td>${formatTime12Hour(program.adhan_fajr)}</td>
                         <td>${formatTime12Hour(program.iqama_fajr)}</td>
                         <td>${program.imam_fajr || '-'}</td>
                         <td>${formatTime12Hour(program.adhan_dhuhr)}</td>
                         <td>${formatTime12Hour(program.iqama_dhuhr)}</td>
                         <td>${program.imam_dhuhr || '-'}</td>
                         <td>${formatTime12Hour(program.adhan_asr)}</td>
                         <td>${formatTime12Hour(program.iqama_asr)}</td>
                         <td>${program.imam_asr || '-'}</td>
                         <td>${formatTime12Hour(program.adhan_maghrib)}</td>
                         <td>${formatTime12Hour(program.iqama_maghrib)}</td>
                         <td>${program.imam_maghrib || '-'}</td>
                         <td>${formatTime12Hour(program.adhan_isha)}</td>
                         <td>${formatTime12Hour(program.iqama_isha)}</td>
                         <td>${program.imam_isha || '-'}</td>
                         <td>${formatTime12Hour(program.adhan_friday)}</td>
                         <td>${formatTime12Hour(program.iqama_friday)}</td>
                         <td>${program.imam_friday || '-'}</td>
                     </tr>
                 `;
            });
            
            html += '</tbody>';
            return html;
        }
        
        // Time formatting function for 12-hour format with Arabic AM/PM
        function formatTime12Hour(timeString) {
            if (!timeString || timeString === '-') return '-';
            
            // Parse the time string (assuming HH:MM format)
            const [hours, minutes] = timeString.split(':').map(Number);
            
            // Convert to 12-hour format
            let hour12 = hours % 12;
            if (hour12 === 0) hour12 = 12;
            
            // Determine AM/PM in Arabic
            const ampm = hours < 12 ? 'ص' : 'م';
            
            // Format minutes with leading zero if needed
            const formattedMinutes = minutes.toString().padStart(2, '0');
            
            return `${hour12}:${formattedMinutes} ${ampm}`;
        }

        // Time-based visibility functions
        function getCurrentTime() {
            const now = new Date();
            return now.getHours() * 60 + now.getMinutes(); // Convert to minutes since midnight
        }
        
        function parseTimeToMinutes(timeString) {
            if (!timeString || timeString === '-') return null;
            const [hours, minutes] = timeString.split(':').map(Number);
            return hours * 60 + minutes;
        }
        
        function shouldShowProgram(program) {
            const currentTime = getCurrentTime();
            const startTime = parseTimeToMinutes(program.start_time);
            const endTime = parseTimeToMinutes(program.end_time);
            
            if (startTime === null || endTime === null) return true; // Show if no time specified
            
            // Show 30 minutes before start time
            const showTime = startTime - 30;
            // Hide 15 minutes after end time
            const hideTime = endTime + 15;
            
            return currentTime >= showTime && currentTime <= hideTime;
        }
        
        function getProgramVisibilityClass(program) {
            const currentTime = getCurrentTime();
            const startTime = parseTimeToMinutes(program.start_time);
            const endTime = parseTimeToMinutes(program.end_time);
            
            if (startTime === null || endTime === null) return 'program-active';
            
            if (currentTime < startTime - 30) return 'program-hidden';
            if (currentTime >= startTime - 30 && currentTime < startTime) return 'program-upcoming';
            if (currentTime >= startTime && currentTime <= endTime) return 'program-active';
            if (currentTime > endTime && currentTime <= endTime + 15) return 'program-ending';
            return 'program-hidden';
        }
        
        // Helper function to check if current date is within program's date range
        function isDateInRange(program) {
            const currentDate = new Date();
            currentDate.setHours(0, 0, 0, 0); // Reset time to compare dates only
            
            // For Imama programs with specific date
            if (program.date) {
                const programDate = new Date(program.date);
                programDate.setHours(0, 0, 0, 0);
                return currentDate.getTime() === programDate.getTime();
            }
            
            // For regular programs with start_date and end_date
            if (program.start_date && program.end_date) {
                const startDate = new Date(program.start_date);
                const endDate = new Date(program.end_date);
                startDate.setHours(0, 0, 0, 0);
                endDate.setHours(0, 0, 0, 0);
                return currentDate >= startDate && currentDate <= endDate;
            }
            
            return true; // If no date constraints, assume valid
        }
        
        // Helper function to check if current weekday matches program's weekdays
        function isWeekdayValid(program) {
            if (!program.weekdays || !Array.isArray(program.weekdays)) {
                return true; // If no weekday constraints, assume valid
            }
            
            const currentWeekday = new Date().toLocaleDateString('en-US', { weekday: 'long' }).toLowerCase();
            return program.weekdays.includes(currentWeekday);
        }
        
        // Function to get dynamic program status based on current time and date
        function getDynamicProgramStatus(program) {
            // Skip date validation for Imama programs (they appear every day)
            const isImamaProgram = program.date && !program.start_date && !program.end_date;
            
            // For regular programs, check if the program should be visible today
            if (!isImamaProgram && (!isDateInRange(program) || !isWeekdayValid(program))) {
                return 'غير متاح اليوم'; // Not available today
            }
            
            const currentTime = getCurrentTime();
            const startTime = parseTimeToMinutes(program.start_time);
            const endTime = parseTimeToMinutes(program.end_time);
            
            if (startTime === null || endTime === null) {
                return program.status || 'غير محدد';
            }
            
            // If program has ended, show "انتهت" regardless of database status
            if (currentTime > endTime) {
                return 'انتهت';
            }
            
            // If program has started but not ended, show "بدأت"
            if (currentTime >= startTime && currentTime <= endTime) {
                return 'بدأت';
            }
            
            // If program hasn't started yet, show "في الموعد" instead of "لم تبدأ"
            if (program.status === 'لم تبدأ') {
                return 'في الموعد';
            }
            
            // If program hasn't started yet, return original status
            return program.status || 'غير محدد';
        }
        
        // Helper function to build regular programs table
        function buildRegularProgramsTable(programs) {
            // Check if this is حلقة تحفيظ programs
            const isHalaqat = programs.length > 0 && programs[0].program_type && 
                             (programs[0].program_type.name === 'حلقة تحفيظ' || programs[0].program_type === 'حلقة تحفيظ');
            
            let html = `
                <thead>
                    <tr>
            `;
            
            if (isHalaqat) {
                html += `
                        <th>اسم الحلقة</th>
                        <th>المستوى</th>
                        <th>الحالة</th>
                        <th>من</th>
                        <th>إلى</th>
                        <th>اللغة</th>
                        <th>ملاحظات</th>
                        <th>الموقع</th>
                        <th>المحاضر</th>
                        <th>رابط البث</th>
                `;
            } else {
                html += `
                        <th>القسم</th>
                        <th>التخصص</th>
                        <th>الكتاب</th>
                        <th>الدرس</th>
                        <th>المستوى</th>
                        <th>الحالة</th>
                        <th>من</th>
                        <th>إلى</th>
                        <th>اللغة</th>
                        <th>لغة الإشارة</th>
                        <th>المحاضر</th>
                        <th>الموقع</th>
                        <th>رابط البث</th>
                        <th>ملاحظات</th>
                `;
            }
            
            html += `
                    </tr>
                </thead>
                <tbody>
            `;
            
            programs.forEach(program => {
                if (shouldShowProgram(program)) {
                    const visibilityClass = getProgramVisibilityClass(program);
                    const dynamicStatus = getDynamicProgramStatus(program);
                    
                    if (isHalaqat) {
                        html += `
                            <tr class="${visibilityClass}">
                                <td>${program.title || '-'}</td>
                                <td>${program.level ? program.level.name : '-'}</td>
                                <td><span class="status-badge status-${dynamicStatus}">${dynamicStatus}</span></td>
                                <td>${formatTime12Hour(program.start_time)}</td>
                                <td>${formatTime12Hour(program.end_time)}</td>
                                <td>${program.language || '-'}</td>
                                <td>${program.notes || '-'}</td>
                                <td>${program.location ? `${program.location.direction || ''} - ${program.location.building_number || ''} - ${program.location.floors_count || ''}`.replace(/^-|-$/g, '').trim() : '-'}</td>
                                <td>${program.teacher ? program.teacher.name : '-'}</td>
                                <td>${program.broadcast_link ? `<a href="${program.broadcast_link}" target="_blank">رابط البث</a>` : '-'}</td>
                            </tr>
                        `;
                    } else {
                        html += `
                            <tr class="${visibilityClass}">
                                <td>${program.section ? program.section.name : '-'}</td>
                                <td>${program.major ? program.major.name : '-'}</td>
                                <td>${program.book ? program.book.title : '-'}</td>
                                <td>${program.lesson || '-'}</td>
                                <td>${program.level ? program.level.name : '-'}</td>
                                <td><span class="status-badge status-${dynamicStatus}">${dynamicStatus}</span></td>
                                <td>${formatTime12Hour(program.start_time)}</td>
                                <td>${formatTime12Hour(program.end_time)}</td>
                                <td>${program.language || '-'}</td>
                                <td>${program.sign_language_support ? 'نعم' : 'لا'}</td>
                                <td>${program.teacher ? program.teacher.name : '-'}</td>
                                <td>${program.location ? `${program.location.direction || ''} - ${program.location.building_number || ''} - ${program.location.floors_count || ''}`.replace(/^-|-$/g, '').trim() : '-'}</td>
                                <td>${program.broadcast_link ? `<a href="${program.broadcast_link}" target="_blank">رابط البث</a>` : '-'}</td>
                                <td>${program.notes || '-'}</td>
                            </tr>
                        `;
                    }
                }
            });
            
            html += '</tbody>';
            return html;
        }
        
        // Function to update time-based visibility without fetching new data
        function updateTimeBasedVisibility() {
            const tablesContainer = document.querySelector('.tables-vertical');
            if (!tablesContainer) return;
            
            // Get current programs data from the last update
            const lastContent = tablesContainer.dataset.lastContent;
            if (lastContent) {
                try {
                    const programsByType = JSON.parse(lastContent);
                    // Force update by temporarily clearing the lastContent to bypass the change check
                    const originalContent = tablesContainer.dataset.lastContent;
                    tablesContainer.dataset.lastContent = '';
                    updateTableContent(programsByType);
                    // Don't restore the original content - let updateTableContent set the new one
                } catch (error) {
                    console.error('Error parsing stored programs data:', error);
                }
            }
        }
        
        // Function to update date and time
        function updateDateTime() {
            const now = new Date();
            
            // Update current time
            const timeOptions = { 
                hour: '2-digit', 
                minute: '2-digit', 
                second: '2-digit',
                hour12: true 
            };
            const currentTime = now.toLocaleTimeString('ar-SA', timeOptions);
            
            // Update Gregorian date
            const gregorianOptions = { 
                year: 'numeric', 
                month: 'long', 
                day: 'numeric',
                weekday: 'long',
                calendar: 'gregory'
            };
            const gregorianDate = now.toLocaleDateString('ar-SA', gregorianOptions);
            
            // Update Hijri date (using Intl.DateTimeFormat with Islamic calendar)
            try {
                const hijriOptions = { 
                    year: 'numeric', 
                    month: 'long', 
                    day: 'numeric',
                    weekday: 'long',
                    calendar: 'islamic'
                };
                const hijriDate = new Intl.DateTimeFormat('ar-SA', hijriOptions).format(now);
                const hijriDateTime = gregorianDate + ' - ' + hijriDate + ' - ' + currentTime;
                document.getElementById('hijri-date-time').textContent = hijriDateTime;
            } catch (e) {
                // Fallback if Islamic calendar is not supported
                document.getElementById('hijri-date-time').textContent = gregorianDate + ' - التاريخ الهجري غير متاح - ' + currentTime;
            }
        }
        
        // Start polling for updates
        setInterval(updateAnnouncements, 10000); // Every 10 seconds
        setInterval(updatePrograms, 15000); // Every 15 seconds
        setInterval(updateTimeBasedVisibility, 30000); // Every 30 seconds for time-based visibility
        setInterval(updateDateTime, 1000); // Every second for date/time
        

        // Initial update after 2 seconds to allow page to load
        setTimeout(() => {
            updateAnnouncements();
            updatePrograms();
            updateTimeBasedVisibility(); // Also update visibility on initial load
            updateDateTime(); // Initial date/time update
        }, 2000);
        
        // Update time-based visibility every 30 seconds starting after 30 seconds
        setTimeout(() => {
            updateTimeBasedVisibility();
        }, 30000);
    </script>
    <div class="tables-vertical">
        @if(isset($programsByType) && $programsByType->count() > 0)
            @foreach($programsByType as $programTypeName => $programs)
                @php
                    $isImama = $programTypeName === 'إمامة' || $programTypeName === 'الإمامة';
                @endphp
                <div class="table-section">
                    <h4><i class="fas fa-{{ $isImama ? 'mosque' : 'book-open' }}"></i> {{ $programTypeName }}</h4>
                    
                    @if($isImama)
                        <!-- Imama Programs Table -->
                        <table class="imama-table">
                            <thead>
                                <tr>
                                    <th>الفجر - أذان</th>
                                    <th>الفجر - إقامة</th>
                                    <th>الفجر - إمام</th>
                                    <th>الظهر - أذان</th>
                                    <th>الظهر - إقامة</th>
                                    <th>الظهر - إمام</th>
                                    <th>العصر - أذان</th>
                                    <th>العصر - إقامة</th>
                                    <th>العصر - إمام</th>
                                    <th>المغرب - أذان</th>
                                    <th>المغرب - إقامة</th>
                                    <th>المغرب - إمام</th>
                                    <th>العشاء - أذان</th>
                                    <th>العشاء - إقامة</th>
                                    <th>العشاء - إمام</th>
                                    <th>الجمعة - أذان</th>
                                    <th>الجمعة - إقامة</th>
                                    <th>الجمعة - إمام</th>
                                </tr>
                            </thead>
                            <tbody>
                                @include('masjids.partials.table_imama_programs_rows', ['programs' => $programs])
                            </tbody>
                        </table>
                    @else
                        <!-- Regular Programs Table -->
                        @php
                            $isHalaqat = $programTypeName === 'حلقة تحفيظ';
                        @endphp
                        <table>
                            <thead>
                                <tr>
                                    @if($isHalaqat)
                                        <th>اسم الحلقة</th>
                                        <th>المستوى</th>
                                        <th>الحالة</th>
                                        <th>من</th>
                                        <th>إلى</th>
                                        <th>اللغة</th>
                                        <th>ملاحظات</th>
                                        <th>الموقع</th>
                                        <th>المحاضر</th>
                                        <th>رابط البث</th>
                                    @else
                                        <th>القسم</th>
                                        <th>التخصص</th>
                                        <th>الكتاب</th>
                                        <th>الدرس</th>
                                        <th>المستوى</th>
                                        <th>الحالة</th>
                                        <th>من</th>
                                        <th>إلى</th>
                                        <th>اللغة</th>
                                        <th>لغة الإشارة</th>
                                        <th>المحاضر</th>
                                        <th>الموقع</th>
                                        <th>رابط البث</th>
                                        <th>ملاحظات</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @include('masjids.partials.table_structured_programs_rows', ['programs' => $programs, 'isHalaqat' => $isHalaqat])
                            </tbody>
                        </table>
                    @endif
                </div>
            @endforeach
        @else
            <div class="table-section">
                <h4><i class="fas fa-info-circle"></i> لا توجد برامج منظمة</h4>
                <p style="text-align: center; color: #666; padding: 2rem;">لا توجد برامج منظمة مسجلة لهذا المسجد حالياً.</p>
            </div>
        @endif
    </div>
</body>
</html>