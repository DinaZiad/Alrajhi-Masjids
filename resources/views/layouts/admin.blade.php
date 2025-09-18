<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>لوحة التحكم</title>
    <link rel="icon" href="/favicon.png" type="image/svg+xml">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    @stack('styles')
    <style>
        body {
            margin: 0;
            font-family: 'Cairo', sans-serif;
            background: #f8fafc;
            color: #1e293b;
            direction: rtl;
        }
        .admin-layout {
            display: flex;
            min-height: 100vh;
            position: relative;
        }
        .sider {
            width: 88px;
            background: rgba(255,255,255,0.82);
            backdrop-filter: blur(12px);
            box-shadow: 4px 0 24px 0 rgba(30,41,59,0.10);
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 0;
            position: fixed;
            right: 0;
            top: 0;
            bottom: 0;
            z-index: 100;
            transition: width 0.35s cubic-bezier(.4,0,.2,1), background 0.25s, box-shadow 0.25s;
        }
        .sider:not(.sider-collapsed) {
            width: 320px;
            background: rgba(255,255,255,0.96);
            box-shadow: 8px 0 32px 0 rgba(30,41,59,0.13);
        }
        .sider-header {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 68px;
            padding: 0;
            margin-bottom: 1.5rem;
            transition: all 0.35s cubic-bezier(.4,0,.2,1);
        }
        .sider:not(.sider-collapsed) .sider-header {
            height: 80px;
            padding: 0 20px;
        }
        .sider-logo {
            width: 38px;
            height: 38px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.35s cubic-bezier(.4,0,.2,1);
        }
        .sider-logo.has-icon {
            background: #174032cc;
            color: #fff;
            font-size: 1.5rem;
            box-shadow: 0 2px 8px rgba(23,64,50,0.10);
        }
        .sider:not(.sider-collapsed) .sider-logo {
            width: 280px;
            height: 60px;
            transform: scale(1.02);
            border-radius: 16px;
        }
        .sider:not(.sider-collapsed) .sider-logo.has-icon {
            box-shadow: 0 4px 16px rgba(23,64,50,0.13);
        }
        .sider-logo-img {
            width: 38px;
            height: 38px;
            object-fit: contain;
            transition: all 0.35s cubic-bezier(.4,0,.2,1);
        }
        .sider:not(.sider-collapsed) .sider-logo-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .sider-toggle {
            background: none;
            border: none;
            outline: none;
            cursor: pointer;
            color: #b0b6be;
            font-size: 1.5rem;
            padding: 0.3rem 0.5rem;
            border-radius: 8px;
            transition: background 0.18s, color 0.18s, right 0.35s cubic-bezier(.4,0,.2,1);
            position: fixed;
            right: 88px;
            top: 50%;
            transform: translateY(-50%);
            z-index: 201;
            box-shadow: 0 2px 8px rgba(30,41,59,0.07);
            background: #fff;
            border: 1px solid #e5e7eb;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .sider:not(.sider-collapsed) ~ .sider-toggle {
            right: 320px;
        }
        .sider-toggle:hover {
            background: #f1f5f9;
            color: #174032;
        }
        .sider-toggle .chevron {
            transition: transform 0.35s cubic-bezier(.4,0,.2,1);
            display: inline-block;
        }
        .sider:not(.sider-collapsed) ~ .sider-toggle .chevron {
            transform: rotate(180deg);
        }
        .sider-nav {
            flex: 1;
            min-height: 0; /* allow flex child to shrink and scroll */
            display: flex;
            flex-direction: column;
            gap: 0.2rem;
            width: 100%;
            overflow-y: auto;
            overscroll-behavior: contain;
            -webkit-overflow-scrolling: touch;
            padding-bottom: 1rem;
            direction: ltr; /* place scrollbar on the right in RTL layouts */
        }
        /* Keep inner content RTL while scrollbar remains on the right */
        .sider-nav .sider-expanded-links,
        .sider-nav .sider-collapsed-links,
        .sider-nav .sider-menu,
        .sider-nav .sider-submenu,
        .sider-nav .sider-link {
            direction: rtl;
        }
        .sider-link {
            display: flex;
            align-items: center;
            gap: 1.1rem;
            padding: 0.95rem 1.2rem;
            color: #1e293b;
            text-decoration: none;
            font-size: 1.09rem;
            border-right: 3px solid transparent;
            border-radius: 0 18px 18px 0;
            transition: background 0.18s, color 0.18s, border-color 0.18s, padding 0.28s cubic-bezier(.4,0,.2,1), font-weight 0.18s;
            width: 100%;
            position: relative;
            will-change: background, color, border-color, padding;
        }
        .sider-link i {
            color: #b0b6be;
            font-size: 1.25em;
            min-width: 28px;
            text-align: center;
            transition: color 0.18s, transform 0.22s cubic-bezier(.4,0,.2,1), opacity 0.22s;
            opacity: 0.85;
        }
        .sider-link span {
            opacity: 0;
            max-width: 0;
            overflow: hidden;
            white-space: nowrap;
            transition: opacity 0.28s cubic-bezier(.4,0,.2,1), max-width 0.28s cubic-bezier(.4,0,.2,1), transform 0.28s cubic-bezier(.4,0,.2,1);
            font-weight: 500;
            transform: translateX(12px) scale(0.98);
        }
        .sider:not(.sider-collapsed) .sider-link span {
            opacity: 1;
            max-width: 160px;
            margin-right: 0.2rem;
            transform: translateX(0) scale(1);
        }
        .sider-link.active, .sider-link:hover {
            background: rgba(241,245,249,0.95);
            color: #174032;
            border-right: 3px solid #174032;
            font-weight: 700;
        }
        .sider-link.active i, .sider-link:hover i {
            color: #174032;
            opacity: 1;
        }
        .sider-link .menu-chevron {
            color: #b0b6be;
            transition: transform 0.35s cubic-bezier(.4,0,.2,1), color 0.18s;
        }
        .sider-link.active .menu-chevron, .sider-link:hover .menu-chevron {
            color: #174032;
        }
        .sider-footer {
            width: 100%;
            padding: 1.2rem 0.5rem;
            font-size: 0.93rem;
            color: #b0b6be;
            text-align: center;
            border-top: none;
        }
        .main-content {
            flex: 1;
            margin-right: 88px;
            padding: 2.5rem 2.5rem 2.5rem 2rem;
            min-height: 100vh;
            background: #f8fafc;
            transition: margin-right 0.35s cubic-bezier(.4,0,.2,1);
        }
        .sider:not(.sider-collapsed) ~ .main-content {
            margin-right: 320px;
        }
        .sider-menu {
            width: 100%;
        }
        .sider-menu-toggle {
            width: 100%;
            background: none;
            border: none;
            outline: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 1.1rem;
            padding: 0.95rem 1.2rem;
            color: #1e293b;
            font-size: 1.09rem;
            border-right: 3px solid transparent;
            border-radius: 0 18px 18px 0;
            transition: background 0.18s, color 0.18s, border-color 0.18s, padding 0.28s cubic-bezier(.4,0,.2,1), font-weight 0.18s;
            position: relative;
            font-weight: 500;
        }
        .sider-menu-toggle .menu-chevron {
            margin-right: auto;
            transition: transform 0.35s cubic-bezier(.4,0,.2,1);
        }
        .sider-submenu {
            display: flex;
            flex-direction: column;
            gap: 0.1rem;
            background: rgba(241,245,249,0.95);
            border-radius: 0 0 12px 12px;
            margin-right: 1.5rem;
            margin-left: 0.5rem;
            margin-bottom: 0.2rem;
            box-shadow: 0 2px 8px rgba(30,41,59,0.04);
            padding: 0.2rem 0.2rem 0.2rem 0.2rem;
            max-height: 0;
            overflow: hidden;
            opacity: 0;
            transition: max-height 1.2s cubic-bezier(.4,0,.2,1), opacity 1.2s cubic-bezier(.4,0,.2,1);
        }
        .sider-submenu.open {
            max-height: 500px;
            opacity: 1;
            transition: max-height 1.2s cubic-bezier(.4,0,.2,1), opacity 1.2s cubic-bezier(.4,0,.2,1);
        }
        .sider-submenu.closing {
            transition: max-height 0.7s cubic-bezier(.4,0,.2,1), opacity 0.7s cubic-bezier(.4,0,.2,1);
        }
        .sider-submenu .sider-link {
            font-size: 0.98rem;
            padding: 0.7rem 1.2rem 0.7rem 1.2rem;
            border-radius: 0 12px 12px 0;
            border-right: 2px solid transparent;
            background: none;
        }
        .sider-menu-toggle[aria-expanded="true"] {
            background: rgba(241,245,249,0.95);
            color: #174032;
            border-right: 3px solid #174032;
            font-weight: 700;
        }
        .sider-menu-toggle[aria-expanded="true"] i {
            color: #174032;
        }
        .sider-menu-toggle:focus {
            outline: 2px solid #174032;
        }
        .sider-collapsed .sider-menu-toggle,
        .sider-collapsed .sider-submenu {
            display: none !important;
        }
        .sider-collapsed .sider-menu > .sider-link.sider-menu-toggle {
            display: none !important;
        }
        .sider-collapsed .sider-menu {
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .sider-collapsed .sider-menu {
            padding: 0;
        }
        .sider-collapsed .sider-menu > .sider-link.sider-menu-toggle > span,
        .sider-collapsed .sider-menu > .sider-link.sider-menu-toggle > .menu-chevron {
            display: none !important;
        }
        .sider-collapsed .sider-menu > .sider-link.sider-menu-toggle > i {
            margin: 0;
            font-size: 1.4em;
        }
        .sider-collapsed .sider-menu {
            width: 100%;
        }
        .sider-collapsed-links {
            display: none;
            flex-direction: column;
            align-items: center;
            width: 100%;
            gap: 1.2rem;
            margin-top: 1.5rem;
        }
        .sider-expanded-links {
            display: block;
        }
        .sider-collapsed .sider-nav > *:not(.sider-collapsed-links) {
            display: none !important;
        }
        .sider-collapsed .sider-collapsed-links {
            display: flex !important;
        }
        @media (max-width: 900px) {
            .sider {
                width: 72px;
            }
            .sider:not(.sider-collapsed) {
                width: 160px;
            }
            .main-content {
                margin-right: 72px;
                padding: 1.2rem 1.2rem 1.2rem 1rem;
            }
            .sider-footer {
                font-size: 0.85rem;
            }
            .sider:not(.sider-collapsed) ~ .main-content {
                margin-right: 160px;
            }
            .sider-submenu {
                margin-right: 1rem;
                margin-left: 0.2rem;
            }
        }
    </style>
</head>
<body>
<div class="admin-layout">
    <aside class="sider sider-collapsed" id="sider">
        <div class="sider-header">
            @php
                $iconPath = \App\Models\Setting::get('sidebar_icon_path');
                $iconUrl = $iconPath && Illuminate\Support\Facades\Storage::disk('public')->exists($iconPath)
                    ? Illuminate\Support\Facades\Storage::disk('public')->url($iconPath)
                    : null;
            @endphp
            <div class="sider-logo{{ !$iconUrl ? ' has-icon' : '' }}">
                @if($iconUrl)
                    <img src="{{ $iconUrl }}" alt="Logo" class="sider-logo-img" style="filter: drop-shadow(0 1px 2px rgba(0,0,0,0.1));" />
                @else
                    <i class="fas fa-mosque"></i>
                @endif
            </div>
        </div>
        <nav class="sider-nav" id="sidebarNav">
            <div class="sider-collapsed-links">
                <a href="{{ route('admin.dashboard') }}" class="sider-link" title="الرئيسية"><i class="fas fa-chart-bar"></i></a>

                @if(auth()->user()->hasPermission('manage_announcements'))
                <a href="{{ route('announcements.index') }}" class="sider-link" title="الإعلانات"><i class="fas fa-bullhorn"></i></a>
                @endif
                @if(auth()->user()->hasPermission('manage_admins'))
                <a href="{{ route('admin.admins.index') }}" class="sider-link" title="المشرفون"><i class="fas fa-users"></i></a>
                @endif
                @if(auth()->user()->hasPermission('manage_icons'))
                <a href="{{ route('constants.icons') }}" class="sider-link" title="إدارة الرموز"><i class="fas fa-image"></i></a>
                @endif
                @if(auth()->user()->hasPermission('manage_hijri_years'))
                <a href="{{ route('constants.hijri-years') }}" class="sider-link" title="إدارة العام الهجري"><i class="fas fa-calendar-alt"></i></a>
                @endif
                @if(auth()->user()->hasPermission('manage_sections'))
                <a href="{{ route('constants.sections') }}" class="sider-link" title="الأقسام"><i class="fas fa-folder"></i></a>
                @endif
                @if(auth()->user()->hasPermission('manage_levels'))
                <a href="{{ route('constants.levels') }}" class="sider-link" title="المستويات"><i class="fas fa-layer-group"></i></a>
                @endif
                @if(auth()->user()->hasPermission('manage_majors'))
                <a href="{{ route('constants.majors') }}" class="sider-link" title="التخصصات"><i class="fas fa-graduation-cap"></i></a>
                @endif
                @if(auth()->user()->hasPermission('manage_books'))
                <a href="{{ route('constants.books') }}" class="sider-link" title="الكتب"><i class="fas fa-book"></i></a>
                @endif
                @if(auth()->user()->hasPermission('manage_program_types'))
                <a href="{{ route('constants.program-types') }}" class="sider-link" title="المجالات"><i class="fas fa-list"></i></a>
                @endif
                @if(auth()->user()->hasPermission('manage_teachers'))
                <a href="{{ route('constants.teachers') }}" class="sider-link" title="المعلمين"><i class="fas fa-chalkboard-teacher"></i></a>
                @endif
                @if(auth()->user()->hasPermission('manage_data'))
                <a href="{{ route('data.programs') }}" class="sider-link" title="عرض البيانات"><i class="fas fa-table"></i></a>
                @endif
                @if(auth()->user()->hasPermission('add_new_data'))
                <a href="{{ route('masjids.programs.create', 0) }}" class="sider-link" title="إضافة البيانات"><i class="fas fa-database"></i></a>
                @endif
                <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                    @csrf
                    <a href="{{ route('logout') }}" class="sider-link" title="تسجيل الخروج" onclick="event.preventDefault(); this.closest('form').submit();"><i class="fas fa-sign-out-alt"></i></a>
                </form>
            </div>
            <div class="sider-expanded-links">
                <!-- Dashboard - visible to all admins -->
                <a href="{{ route('admin.dashboard') }}" class="sider-link{{ request()->routeIs('admin.dashboard') ? ' active' : '' }}" title="الرئيسية"><i class="fas fa-chart-bar"></i> <span>الرئيسية</span></a>

                <!-- Announcements -->
                @if(auth()->user()->hasPermission('manage_announcements') && !auth()->user()->hasPermission('add_normal_announcement') && !auth()->user()->hasPermission('add_urgent_announcement'))
                <!-- Users with only manage_announcements permission see the main page -->
                <a href="{{ route('announcements.index') }}" class="sider-link{{ request()->routeIs('announcements.index') ? ' active' : '' }}" title="الإعلانات"><i class="fas fa-bullhorn"></i> <span>الإعلانات</span></a>
                @elseif(auth()->user()->hasPermission('manage_announcements') && (auth()->user()->hasPermission('add_normal_announcement') || auth()->user()->hasPermission('add_urgent_announcement')))
                <!-- Users with manage_announcements + add permissions see the full menu -->
                <div class="sider-menu">
                    <button class="sider-link sider-menu-toggle" type="button" aria-expanded="false" aria-controls="announcementsMenu">
                        <i class="fas fa-bullhorn"></i> <span>الإعلانات</span>
                        <i class="fas fa-chevron-down menu-chevron"></i>
                    </button>
                    <div class="sider-submenu" id="announcementsMenu">
                        <a href="{{ route('announcements.index') }}" class="sider-link{{ request()->routeIs('announcements.index') ? ' active' : '' }}"><i class="fas fa-list"></i> <span>كل الإعلانات</span></a>
                        @if(auth()->user()->hasPermission('add_normal_announcement'))
                        <a href="{{ route('announcements.create') }}" class="sider-link{{ request()->routeIs('announcements.create') ? ' active' : '' }}"><i class="fas fa-plus"></i> <span>إضافة إعلان عادي</span></a>
                        @endif
                        @if(auth()->user()->hasPermission('add_urgent_announcement'))
                        <a href="{{ route('announcements.urgent.create') }}" class="sider-link{{ request()->routeIs('announcements.urgent.*') ? ' active' : '' }}" style=" font-weight: bold;"><i class="fas fa-bolt"></i> <span>إضافة إعلان عاجل</span></a>
                        @endif
                    </div>
                </div>
                @elseif(auth()->user()->hasPermission('add_normal_announcement') || auth()->user()->hasPermission('add_urgent_announcement'))
                <!-- Users with only add permissions see direct links -->
                @if(auth()->user()->hasPermission('add_normal_announcement'))
                <a href="{{ route('announcements.create') }}" class="sider-link{{ request()->routeIs('announcements.create') ? ' active' : '' }}" title="إضافة إعلان عادي"><i class="fas fa-plus"></i> <span>إضافة إعلان عادي</span></a>
                @endif
                @if(auth()->user()->hasPermission('add_urgent_announcement'))
                <a href="{{ route('announcements.urgent.create') }}" class="sider-link{{ request()->routeIs('announcements.urgent.*') ? ' active' : '' }}" title="إضافة إعلان عاجل" style="font-weight: bold;"><i class="fas fa-bolt"></i> <span>إضافة إعلان عاجل</span></a>
                @endif
                @endif
                
                <!-- Admins -->
                @if(auth()->user()->hasPermission('manage_admins') || auth()->user()->hasPermission('add_new_admin'))
                <div class="sider-menu">
                    <button class="sider-link sider-menu-toggle" type="button" aria-expanded="false" aria-controls="adminsMenu">
                        <i class="fas fa-users"></i> <span>المشرفون</span>
                        <i class="fas fa-chevron-down menu-chevron"></i>
                    </button>
                    <div class="sider-submenu" id="adminsMenu">
                        @if(auth()->user()->hasPermission('manage_admins'))
                        <a href="{{ route('admin.admins.index') }}" class="sider-link{{ request()->routeIs('admin.admins.index') ? ' active' : '' }}"><i class="fas fa-list"></i> <span>إدارة المشرفين</span></a>
                        @endif
                        @if(auth()->user()->hasPermission('add_new_admin'))
                        <a href="{{ route('admin.users.create') }}" class="sider-link{{ request()->routeIs('admin.users.create') ? ' active' : '' }}"><i class="fas fa-user-plus"></i> <span> إضافة مشرف جديد</span></a>
                        @endif
                    </div>
                </div>
                @endif
                <!-- Data Management -->
                @if(auth()->user()->hasPermission('manage_data') || auth()->user()->hasPermission('add_new_data'))
                <div class="sider-menu">
                    <button class="sider-link sider-menu-toggle" type="button" aria-expanded="false" aria-controls="dataMenu">
                        <i class="fas fa-database"></i> <span>إدارة البيانات</span>
                        <i class="fas fa-chevron-down menu-chevron"></i>
                    </button>
                    <div class="sider-submenu" id="dataMenu">
                        @if(auth()->user()->hasPermission('manage_data'))
                        <a href="{{ route('data.programs') }}" class="sider-link{{ request()->routeIs('data.programs') ? ' active' : '' }}"><i class="fas fa-table"></i> <span>عرض البيانات</span></a>
                        @endif
                        @if(auth()->user()->hasPermission('add_new_data'))
                        <a href="{{ route('admin.structured-programs.create') }}" class="sider-link{{ request()->routeIs('admin.structured-programs.create') ? ' active' : '' }}"><i class="fas fa-plus-square"></i> <span>إضافة البيانات</span></a>
                        @endif
                    </div>
                </div>
                @endif
                <!-- Constants -->
                @if(auth()->user()->hasAnyConstantsPermission())
                <div class="sider-menu">
                    <button class="sider-link sider-menu-toggle" type="button" aria-expanded="false" aria-controls="constantsMenu">
                        <i class="fas fa-sliders-h"></i> <span>الثوابت</span>
                        <i class="fas fa-chevron-down menu-chevron"></i>
                    </button>
                    <div class="sider-submenu" id="constantsMenu">
                        @if(auth()->user()->hasPermission('manage_icons'))
                        <a href="{{ route('constants.icons') }}" class="sider-link{{ request()->routeIs('constants.icons') ? ' active' : '' }}"><i class="fas fa-image"></i> <span>إدارة الرموز</span></a>
                        @endif
                        @if(auth()->user()->hasPermission('manage_hijri_years'))
                        <a href="{{ route('constants.hijri-years') }}" class="sider-link{{ request()->routeIs('constants.hijri-years') ? ' active' : '' }}"><i class="fas fa-calendar-alt"></i> <span>إدارة العام الهجري</span></a>
                        @endif
                        @if(auth()->user()->hasPermission('manage_sections'))
                        <a href="{{ route('constants.sections') }}" class="sider-link{{ request()->routeIs('constants.sections*') ? ' active' : '' }}"><i class="fas fa-folder"></i> <span>الأقسام</span></a>
                        @endif
                        @if(auth()->user()->hasPermission('manage_levels'))
                        <a href="{{ route('constants.levels') }}" class="sider-link{{ request()->routeIs('constants.levels*') ? ' active' : '' }}"><i class="fas fa-layer-group"></i> <span>المستويات</span></a>
                        @endif
                        @if(auth()->user()->hasPermission('manage_majors'))
                        <a href="{{ route('constants.majors') }}" class="sider-link{{ request()->routeIs('constants.majors*') ? ' active' : '' }}"><i class="fas fa-graduation-cap"></i> <span>التخصصات</span></a>
                        @endif
                        @if(auth()->user()->hasPermission('manage_books'))
                        <a href="{{ route('constants.books') }}" class="sider-link{{ request()->routeIs('constants.books*') ? ' active' : '' }}"><i class="fas fa-book"></i> <span>الكتب</span></a>
                        @endif
                        @if(auth()->user()->hasPermission('manage_program_types'))
                        <a href="{{ route('constants.program-types') }}" class="sider-link{{ request()->routeIs('constants.program-types*') ? ' active' : '' }}"><i class="fas fa-list"></i> <span>المجالات</span></a>
                        @endif
                        @if(auth()->user()->hasPermission('manage_teachers'))
                        <a href="{{ route('constants.teachers') }}" class="sider-link{{ request()->routeIs('constants.teachers*') ? ' active' : '' }}"><i class="fas fa-chalkboard-teacher"></i> <span>المعلمين</span></a>
                        @endif
                        @if(auth()->user()->hasPermission('manage_masjids'))
                        <a href="{{ route('masjids.index') }}" class="sider-link{{ request()->routeIs('masjids.*') ? ' active' : '' }}"><i class="fas fa-mosque"></i> <span>المساجد</span></a>
                        @endif
                        @if(auth()->user()->hasPermission('manage_buildings'))
                        <a href="{{ route('admin.constants.buildings.index') }}" class="sider-link{{ request()->routeIs('admin.constants.buildings.*') ? ' active' : '' }}"><i class="fas fa-building"></i> <span>المباني</span></a>
                        @endif
                    </div>
                </div>
                @endif
                
                <!-- Logout -->
                <div class="sider-menu">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a href="{{ route('logout') }}" class="sider-link" onclick="event.preventDefault(); this.closest('form').submit();">
                            <i class="fas fa-sign-out-alt"></i> <span>تسجيل الخروج</span>
                        </a>
                    </form>
                </div>
                
        </nav>
        <div class="sider-footer">
            &copy; {{ date('Y') }} إدارة المساجد
        </div>
    </aside>
    <button class="sider-toggle" id="siderToggle" aria-label="Toggle sidebar">
        <i class="fas fa-chevron-left chevron"></i>
    </button>
    <main class="main-content">
        @yield('content')
    </main>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const sider = document.getElementById('sider');
        const toggle = document.getElementById('siderToggle');
        toggle.addEventListener('click', function() {
            sider.classList.toggle('sider-collapsed');
            // Toggle expanded/collapsed links
            if (sider.classList.contains('sider-collapsed')) {
                document.querySelector('.sider-collapsed-links').style.display = 'flex';
                document.querySelector('.sider-expanded-links').style.display = 'none';
            } else {
                document.querySelector('.sider-collapsed-links').style.display = 'none';
                document.querySelector('.sider-expanded-links').style.display = 'block';
            }
        });

        // Collapsible sidebar menus
        const menuToggles = document.querySelectorAll('.sider-menu-toggle');
        menuToggles.forEach(function(btn) {
            btn.addEventListener('click', function() {
                const submenu = btn.parentElement.querySelector('.sider-submenu');
                const expanded = btn.getAttribute('aria-expanded') === 'true';
                btn.setAttribute('aria-expanded', !expanded);
                if (!expanded) {
                    // Close all other submenus
                    document.querySelectorAll('.sider-submenu.open').forEach(function(otherSubmenu) {
                        if (otherSubmenu !== submenu) {
                            otherSubmenu.classList.remove('open');
                            otherSubmenu.classList.remove('closing');
                        }
                    });
                    document.querySelectorAll('.sider-menu-toggle').forEach(function(otherBtn) {
                        if (otherBtn !== btn) {
                            otherBtn.setAttribute('aria-expanded', 'false');
                            otherBtn.querySelector('.menu-chevron').style.transform = 'rotate(0deg)';
                        }
                    });
                    submenu.classList.remove('closing');
                    submenu.classList.add('open');
                } else {
                    submenu.classList.remove('open');
                    submenu.classList.add('closing');
                    setTimeout(() => submenu.classList.remove('closing'), 700);
                }
                btn.querySelector('.menu-chevron').style.transform = expanded ? 'rotate(0deg)' : 'rotate(180deg)';
            });
            // By default, collapse all
            btn.setAttribute('aria-expanded', 'false');
            const submenu = btn.parentElement.querySelector('.sider-submenu');
            if (submenu) {
                submenu.classList.remove('open');
                submenu.classList.remove('closing');
            }
        });
        // Auto-open the menu if a child is active
        document.querySelectorAll('.sider-submenu').forEach(function(submenu) {
            if (submenu.querySelector('.active')) {
                submenu.classList.add('open');
                submenu.classList.remove('closing');
                const btn = submenu.parentElement.querySelector('.sider-menu-toggle');
                if (btn) {
                    btn.setAttribute('aria-expanded', 'true');
                    btn.querySelector('.menu-chevron').style.transform = 'rotate(180deg)';
                }
            }
        });
    });
</script>
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Bootstrap 5 JS (for modals) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
@yield('scripts')
</body>
</html>