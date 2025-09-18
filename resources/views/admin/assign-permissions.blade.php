@php use Illuminate\Support\Str; @endphp
@extends('layouts.admin')

@section('content')
<nav class="main-navbar fixed-navbar">
    <div class="navbar-content breadcrumb-nav breadcrumb-nav-top">
        <a href="{{ route('admin.admins.index') }}">المشرفون</a>
        <span class="breadcrumb-sep">&larr;</span>
        <span class="breadcrumb-current">تعيين الصلاحيات</span>
    </div>
</nav>
<div class="container perms-container perms-wide no-bg">
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    
    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    <div class="row mb-4">
        <div class="col-md-6">
            <label for="admin_role" class="form-label" style="font-weight:700;font-family:'Cairo',sans-serif;">دور المشرف:</label>
            <select name="admin_role" id="admin_role" class="form-control" style="border-radius:8px;border:1.5px solid #d4af37;font-family:'Cairo',sans-serif;">
                <option value="admin" {{ $admin->role == 'admin' ? 'selected' : '' }}>مشرف عادي</option>
                <option value="super_admin" {{ $admin->role == 'super_admin' ? 'selected' : '' }}>مشرف عام</option>
            </select>
            <script>
                // Define handleRoleChange function globally
                function handleRoleChange() {
                    const select = document.getElementById('admin_role');
                    const isSuperAdmin = select.value === 'super_admin';
                    console.log('Role changed to:', select.value, 'isSuperAdmin:', isSuperAdmin);
                    
                    // Update hidden input field
                    const hiddenInput = document.getElementById('admin_role_hidden');
                    if (hiddenInput) {
                        hiddenInput.value = select.value;
                        console.log('Updated hidden input value to:', select.value);
                    }
                    
                    // Get all permission checkboxes
                    const checkboxes = document.querySelectorAll('.permissions-tree input[type="checkbox"]');
                    console.log('Found', checkboxes.length, 'checkboxes');
                    
                    // Update each checkbox
                    checkboxes.forEach(checkbox => {
                        checkbox.checked = isSuperAdmin;
                        // Don't disable checkboxes for super_admin, just make them readonly visually
                        checkbox.disabled = false;
                        checkbox.readOnly = isSuperAdmin;
                        if (isSuperAdmin) {
                            checkbox.setAttribute('data-super-admin', 'true');
                        } else {
                            checkbox.removeAttribute('data-super-admin');
                        }
                    });
                }
                
                // Debug the initial value
                document.addEventListener('DOMContentLoaded', function() {
                    const select = document.getElementById('admin_role');
                    console.log('Initial select value:', select.value);
                    console.log('Initial selected option:', select.options[select.selectedIndex].text);
                    
                    // Add change event listener
                    select.addEventListener('change', handleRoleChange);
                    
                    // Run once on page load
                    handleRoleChange();
                });
            </script>
        </div>
    </div>
    <form method="POST" action="{{ route('admin.admins.permissions.update', $admin->id) }}" id="permissions-form">
        @csrf
        <!-- Hidden input for admin_role -->
        <input type="hidden" name="admin_role" id="admin_role_hidden" value="{{ $admin->role }}">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="permissions-tree perms-tree-modern">
            <ul class="tree-list">
                <!-- Masjids -->
                <li>
                    <span class="tree-folder" onclick="toggleTree(this)">
                        <i class="fas fa-folder-open"></i> المساجد
                    </span>
                    <ul class="tree-children open">
                        @foreach($masjids as $masjid)
                            <li>
                                <label class="tree-label">
                                    <input type="checkbox" 
                                        name="permissions[1][masjids][]" 
                                        value="{{ $masjid->id }}"
                                        @if($assigned->where('id', 1)->where('pivot.masjid_id', $masjid->id)->count()) checked @endif>
                                    إدارة {{ $masjid->name }}
                                </label>
                            </li>
                        @endforeach
                    </ul>
                </li>

                <!-- Programs Super Link -->
                <li>
                    <span class="tree-folder" onclick="toggleTree(this)">
                        <i class="fas fa-folder-open"></i> البرامج
                    </span>
                    <ul class="tree-children open">
                        @foreach($programTypes as $type)
                            <li>
                                <label class="tree-label">
                                    <input type="checkbox" 
                                         name="permissions[23][program_types][]" 
                                         value="{{ $type->id }}"
                                         @if($assigned->where('id', 23)->where('pivot.program_type', $type->id)->count()) checked @endif>
                                    إدارة {{ $type->name }}
                                </label>
                            </li>
                        @endforeach
                    </ul>
                </li>

                <!-- Data Super Link -->
                <li>
                    <span class="tree-folder" onclick="toggleTree(this)">
                        <i class="fas fa-folder-open"></i> البيانات
                    </span>
                    <ul class="tree-children open">
                        <li>
                            <label class="tree-label">
                                 <input type="checkbox" 
                                     name="permissions[15][general]" 
                                     value="1"
                                     @if($assigned->where('id', 15)->where('pivot.masjid_id', null)->where('pivot.program_type', null)->count()) checked @endif>
                                 إدارة البيانات
                             </label>
                        </li>
                        <li>
                            <label class="tree-label">
                                 <input type="checkbox" 
                                     name="permissions[16][general]" 
                                     value="1"
                                     @if($assigned->where('id', 16)->where('pivot.masjid_id', null)->where('pivot.program_type', null)->count()) checked @endif>
                                 إضافة بيانات جديدة
                             </label>
                        </li>
                    </ul>
                </li>

                <!-- Announcements Super Link -->
                <li>
                    <span class="tree-folder" onclick="toggleTree(this)">
                        <i class="fas fa-folder-open"></i> الإعلانات
                    </span>
                    <ul class="tree-children open">
                        <li>
                            <label class="tree-label">
                                 <input type="checkbox" 
                                     name="permissions[11][general]" 
                                     value="1"
                                     @if($assigned->where('id', 11)->where('pivot.masjid_id', null)->where('pivot.program_type', null)->count()) checked @endif>
                                 إدارة الإعلانات
                             </label>
                        </li>
                        <li>
                            <span class="tree-folder sub-folder" onclick="toggleTree(this)">
                                <i class="fas fa-folder-open"></i> إضافة إعلانات
                            </span>
                            <ul class="tree-children open">
                                <li>
                                    <label class="tree-label">
                                         <input type="checkbox" 
                                             name="permissions[12][general]" 
                                             value="1"
                                             @if($assigned->where('id', 12)->where('pivot.masjid_id', null)->where('pivot.program_type', null)->count()) checked @endif>
                                         إضافة إعلان عادي
                                     </label>
                                </li>
                                <li>
                                    <label class="tree-label">
                                         <input type="checkbox" 
                                             name="permissions[13][general]" 
                                             value="1"
                                             @if($assigned->where('id', 13)->where('pivot.masjid_id', null)->where('pivot.program_type', null)->count()) checked @endif>
                                         إضافة إعلان عاجل
                                     </label>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>

                <!-- Admins Super Link -->
                <li>
                    <span class="tree-folder" onclick="toggleTree(this)">
                        <i class="fas fa-folder-open"></i> المشرفون
                    </span>
                    <ul class="tree-children open">
                        <li>
                            <label class="tree-label">
                                 <input type="checkbox" 
                                     name="permissions[7][general]" 
                                     value="1"
                                     @if($assigned->where('id', 7)->where('pivot.masjid_id', null)->where('pivot.program_type', null)->count()) checked @endif>
                                 إدارة المشرفين
                             </label>
                        </li>
                        <li>
                            <label class="tree-label">
                                 <input type="checkbox" 
                                     name="permissions[8][general]" 
                                     value="1"
                                     @if($assigned->where('id', 8)->where('pivot.masjid_id', null)->where('pivot.program_type', null)->count()) checked @endif>
                                 إضافة مشرف جديد
                             </label>
                        </li>
                        <li>
                            <label class="tree-label">
                                 <input type="checkbox" 
                                     name="permissions[10][general]" 
                                     value="1"
                                     @if($assigned->where('id', 10)->where('pivot.masjid_id', null)->where('pivot.program_type', null)->count()) checked @endif>
                                 تعيين الصلاحيات
                             </label>
                        </li>
                    </ul>
                </li>

                <!-- Constants Super Link -->
                <li>
                    <span class="tree-folder" onclick="toggleTree(this)">
                        <i class="fas fa-folder-open"></i> الثوابت
                    </span>
                    <ul class="tree-children open">
                        <li>
                             <label class="tree-label">
                                  <input type="checkbox" 
                                      name="permissions[17][general]" 
                                      value="1"
                                      @if($assigned->where('id', 17)->where('pivot.masjid_id', null)->where('pivot.program_type', null)->count()) checked @endif>
                                  إدارة الرموز
                              </label>
                        </li>
                        <li>
                             <label class="tree-label">
                                  <input type="checkbox" 
                                      name="permissions[18][general]" 
                                      value="1"
                                      @if($assigned->where('id', 18)->where('pivot.masjid_id', null)->where('pivot.program_type', null)->count()) checked @endif>
                                  إدارة العام الهجري
                              </label>
                        </li>
                        <li>
                             <label class="tree-label">
                                  <input type="checkbox" 
                                      name="permissions[19][general]" 
                                      value="1"
                                      @if($assigned->where('id', 19)->where('pivot.masjid_id', null)->where('pivot.program_type', null)->count()) checked @endif>
                                  الأقسام
                              </label>
                        </li>
                        <li>
                             <label class="tree-label">
                                  <input type="checkbox" 
                                      name="permissions[20][general]" 
                                      value="1"
                                      @if($assigned->where('id', 20)->where('pivot.masjid_id', null)->where('pivot.program_type', null)->count()) checked @endif>
                                  المستويات
                              </label>
                        </li>
                        <li>
                             <label class="tree-label">
                                  <input type="checkbox" 
                                      name="permissions[21][general]" 
                                      value="1"
                                      @if($assigned->where('id', 21)->where('pivot.masjid_id', null)->where('pivot.program_type', null)->count()) checked @endif>
                                  التخصصات
                              </label>
                        </li>
                        <li>
                             <label class="tree-label">
                                  <input type="checkbox" 
                                      name="permissions[22][general]" 
                                      value="1"
                                      @if($assigned->where('id', 22)->where('pivot.masjid_id', null)->where('pivot.program_type', null)->count()) checked @endif>
                                  الكتب
                              </label>
                        </li>
                        <li>
                             <label class="tree-label">
                                  <input type="checkbox" 
                                      name="permissions[23][general]" 
                                      value="1"
                                      @if($assigned->where('id', 23)->where('pivot.masjid_id', null)->where('pivot.program_type', null)->count()) checked @endif>
                                  المجالات
                              </label>
                        </li>
                        <li>
                             <label class="tree-label">
                                  <input type="checkbox" 
                                      name="permissions[24][general]" 
                                      value="1"
                                      @if($assigned->where('id', 24)->where('pivot.masjid_id', null)->where('pivot.program_type', null)->count()) checked @endif>
                                  المعلمين
                              </label>
                        </li>
                        <li>
                             <label class="tree-label">
                                  <input type="checkbox" 
                                      name="permissions[28][general]" 
                                      value="1"
                                      @if($assigned->where('id', 28)->where('pivot.masjid_id', null)->where('pivot.program_type', null)->count()) checked @endif>
                                 المساجد
                              </label>
                        </li>
                        <li>
                             <label class="tree-label">
                                  <input type="checkbox" 
                                      name="permissions[29][general]" 
                                      value="1"
                                      @if($assigned->where('id', 29)->where('pivot.masjid_id', null)->where('pivot.program_type', null)->count()) checked @endif>
                                 المباني
                              </label>
                        </li>
                    </ul>
                </li>


            </ul>
        </div>

        <div class="form-actions">
            <button type="submit" class="submit-btn" id="submit-btn">حفظ الصلاحيات</button>
            <a href="{{ route('admin.admins.index') }}" class="cancel-btn">إلغاء</a>
            <div id="loading-indicator" style="display: none; margin-right: 10px; color: #2176FF; font-weight: bold;">
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" style="border: 2px solid currentColor; border-right-color: transparent; width: 1.2rem; height: 1.2rem; display: inline-block; vertical-align: middle; border-radius: 50%; animation: spinner-border .75s linear infinite;"></span>
                    <span style="margin-right: 5px; vertical-align: middle;">جاري الحفظ...</span>
                </div>
                <style>
                @keyframes spinner-border {
                    to { transform: rotate(360deg); }
                }
                </style>
        </div>
    </form>
</div>

<style>
/* Style for readonly checkboxes */
input[type="checkbox"][data-super-admin="true"] {
    opacity: 0.7;
    cursor: not-allowed;
    background-color: #f0f0f0;
}

input[type="checkbox"][data-super-admin="true"] + span {
    opacity: 0.7;
}

body {
    font-family: 'Cairo', sans-serif;
    background-color: #f4f6f9;
    color: #333;
}

/* Title */
.page-title {
    font-weight: 900;
    font-size: 2rem;
    text-align: center;
    color: #174032;
    margin-bottom: 1.5rem;
}
.page-title span { color: #2176FF; }

/* Container */
.perms-container {
    max-width: 95%;
    margin: 2rem auto;
    background: #fff;
    padding: 2.5rem;
    border-radius: 18px;
    box-shadow: 0 8px 40px rgba(0,0,0,0.06);
}

/* Tree structure */
.tree-list, .tree-children {
    list-style: none;
    padding-right: 1.2em;
    margin: 0;
    position: relative;
}
.tree-list > li, .tree-children > li {
    position: relative;
    padding-right: 1.5em;
    margin-bottom: 0.5em;
}
.tree-list > li::before, .tree-children > li::before {
    content: '';
    position: absolute;
    top: 0;
    right: 0.6em;
    width: 1px;
    height: 100%;
    background: #d1d5db;
}
.tree-list > li:last-child::before, .tree-children > li:last-child::before {
    height: 1.2em;
}

/* Folder styling */
.tree-folder {
    font-weight: 700;
    font-size: 1.2rem;
    color: #174032;
    display: flex;
    align-items: center;
    gap: 0.5em;
    padding: 0.5em 1em;
    border-radius: 10px;
    cursor: pointer;
}
.tree-folder i { color: #F7A600; }
.sub-folder { font-size: 1rem; color: #14532D; }

/* Labels */
.tree-label {
    display: flex;
    align-items: center;
    font-size: 1rem;
    font-weight: 500;
    color: #374151;
    gap: 0.5em;
    padding: 0.3em 0.7em;
    border-radius: 6px;
    transition: background 0.2s, color 0.2s;
}
.tree-label:hover { background: #f1f9f5; color: #174032; }

/* Checkboxes */
.tree-label input[type="checkbox"] {
    appearance: none;
    width: 18px;
    height: 18px;
    border: 2px solid #F7A600;
    border-radius: 4px;
    cursor: pointer;
    position: relative;
}
.tree-label input[type="checkbox"]:checked {
    background-color: #F7A600;
    border-color: #F7A600;
}
.tree-label input[type="checkbox"]:checked::after {
    content: '✔';
    position: absolute;
    top: -2px;
    left: 3px;
    font-size: 14px;
    color: #fff;
}

/* Buttons */
.form-actions {
    margin-top: 2rem;
    display: flex;
    justify-content: center;
    gap: 1rem;
}
.submit-btn {
    background: linear-gradient(135deg, #174032 0%, #14532d 100%);
    color: #d4af37;
    padding: 0.75rem 2rem;
    border: none;
    border-radius: 12px;
    font-size: 1.1rem;
    font-weight: 700;
    font-family: 'Cairo', sans-serif;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    text-decoration: none;
}
.submit-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(23, 64, 50, 0.2);
}
.cancel-btn {
    background: #f8f9fa;
    color: #6c757d;
    border: 2px solid #e8e8e8;
    padding: 0.75rem 2rem;
    border-radius: 12px;
    font-size: 1.1rem;
    font-weight: 700;
    font-family: 'Cairo', sans-serif;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    text-decoration: none;
    border: none;
}
.cancel-btn:hover {
    background: #e9ecef;
    color: #2176FF;
    border-color: #d4af37;
}

/* Tree open/collapse states */
.tree-children { display: block; }
.tree-children.collapsed { display: none; }

.breadcrumb-nav {
    display: flex;
    align-items: center;
    gap: 0.7em;
    font-size: 1.08rem;
    font-weight: 700;
    color: #174032;
    margin-bottom: 0.7rem;
    direction: rtl;
    justify-content: flex-end;
}
.breadcrumb-nav a {
    color: #174032;
    text-decoration: none;
    transition: color 0.18s;
}
.breadcrumb-nav a:hover {
    color: #14532d;
    text-decoration: underline;
}
.breadcrumb-sep {
    color: #b0b6be;
    font-size: 1.2em;
    margin: 0 0.2em;
}
.breadcrumb-current {
    color: #d4af37;
}
.breadcrumb-nav-top {
    max-width: 95vw;
    margin: 2.5rem auto 0 auto;
    padding: 0 2vw;
    justify-content: flex-start !important;
    background: none;
    border: none;
}
.no-bg {
    background: none !important;
    box-shadow: none !important;
    border: none !important;
    padding-top: 0.5rem !important;
}
.breadcrumb-admin-name {
    color: #174032;
    font-weight: 900;
    font-size: 1.08rem;
}
.tree-folder:hover {
    background: #eafaf3;
    color: #14532d;
    box-shadow: 0 2px 8px rgba(20,83,45,0.07);
}

/* Sub-folder styling for nested program types */
.sub-folder {
    font-size: 0.95em;
    padding: 8px 12px 8px 24px;
    margin: 4px 0;
    background: #f8f9fa;
    border-left: 3px solid #d4af37;
    border-radius: 6px;
}

.sub-folder:hover {
    background: #e9ecef;
    color: #174032;
    box-shadow: 0 1px 4px rgba(20,83,45,0.1);
}

.sub-folder i {
    color: #d4af37;
    margin-left: 8px;
}
.main-navbar {
    width: 100vw;
    background: #174032;
    padding: 0.7rem 0 0.7rem 0;
    margin-bottom: 1.5rem;
    box-shadow: 0 2px 12px rgba(23,64,50,0.07);
    position: relative;
    z-index: 10;
    margin-right: 68px;
    transition: margin-right 0.35s cubic-bezier(.4,0,.2,1);
}
.sider:not(.sider-collapsed) ~ .main-navbar {
    margin-right: 320px;
}
@media (max-width: 900px) {
    .main-navbar {
        margin-right: 56px;
    }
    .sider:not(.sider-collapsed) ~ .main-navbar {
        margin-right: 160px;
    }
}
.navbar-content {
    max-width: 95vw;
    margin: 0 auto;
    display: flex;
    align-items: center;
    justify-content: flex-start;
    direction: rtl;
    gap: 0.7em;
    font-size: 1.08rem;
    font-weight: 700;
}
.main-navbar .breadcrumb-nav a {
    color: #d4af37;
}
.main-navbar .breadcrumb-nav a:hover {
    color: #fff;
}
.main-navbar .breadcrumb-sep {
    color: #b0b6be;
    font-size: 1.2em;
    margin: 0 0.2em;
}
.main-navbar .breadcrumb-current {
    color: #fff;
}
.main-navbar .breadcrumb-admin-name {
    color: #fff;
    font-weight: 900;
    font-size: 1.08rem;
}
.main-navbar.fixed-navbar {
    position: fixed;
    top: 0;
    right: 0;
    left: 0;
    width: 100vw;
    background: #174032;
    padding: 0.7rem 0 0.7rem 0;
    margin-bottom: 1.5rem;
    box-shadow: 0 2px 12px rgba(23,64,50,0.07);
    z-index: 900;
    border-radius: 0 0 18px 0;
    transition: right 0.35s cubic-bezier(.4,0,.2,1), width 0.35s cubic-bezier(.4,0,.2,1);
}
.sider {
    z-index: 1001 !important;
}
@media (max-width: 900px) {
    .main-navbar.fixed-navbar {
        right: 0;
        width: 100vw;
    }
}
.sider:not(.sider-collapsed) ~ .main-navbar.fixed-navbar {
    right: 0;
    width: 100vw;
}
.perms-container {
    margin-top: 4.5rem !important;
}

/* Super permission styling */
.super-permission {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border: 2px solid #F7A600;
    border-radius: 8px;
    padding: 0.75rem 1rem;
    margin: 0.5rem 0;
    box-shadow: 0 2px 8px rgba(247, 166, 0, 0.15);
}

.super-permission strong {
    color: #174032;
    font-size: 1.1rem;
}

.super-permission input[type="checkbox"] {
    transform: scale(1.2);
    margin-left: 0.75rem;
}
</style>

<script>
// Function to display validation errors
    function displayErrors(errors, container) {
        // Clear previous errors
        container.innerHTML = '';
        container.style.display = 'block';
        
        if (typeof errors === 'string') {
            // Single error message
            const alertDiv = document.createElement('div');
            alertDiv.className = 'alert alert-danger';
            alertDiv.innerHTML = errors;
            container.appendChild(alertDiv);
        } else if (typeof errors === 'object') {
            // Multiple validation errors
            const alertDiv = document.createElement('div');
            alertDiv.className = 'alert alert-danger';
            
            if (Array.isArray(errors)) {
                // Array of error messages
                const ul = document.createElement('ul');
                ul.style.marginBottom = '0';
                errors.forEach(error => {
                    const li = document.createElement('li');
                    li.textContent = error;
                    ul.appendChild(li);
                });
                alertDiv.appendChild(ul);
            } else {
                // Object with error fields
                const ul = document.createElement('ul');
                ul.style.marginBottom = '0';
                Object.entries(errors).forEach(([field, messages]) => {
                    if (Array.isArray(messages)) {
                        messages.forEach(message => {
                            const li = document.createElement('li');
                            li.textContent = message;
                            ul.appendChild(li);
                        });
                    } else {
                        const li = document.createElement('li');
                        li.textContent = messages;
                        ul.appendChild(li);
                    }
                });
                alertDiv.appendChild(ul);
            }
            
            container.appendChild(alertDiv);
        }
        
        // Scroll to error container
        container.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }
    
    // Function to clear error container
    function clearErrors(container) {
        if (container) {
            container.innerHTML = '';
            container.style.display = 'none';
        }
    }
    
    // Function to display success message
    function displaySuccess(message, container) {
        // Clear previous content
        container.innerHTML = '';
        container.style.display = 'block';
        
        // Create success alert
        const alertDiv = document.createElement('div');
        alertDiv.className = 'alert alert-success';
        alertDiv.innerHTML = message;
        container.appendChild(alertDiv);
        
        // Scroll to container
        container.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }

window.onerror = function(message, source, lineno, colno, error) {
    console.error('JavaScript error:', message, 'at', source, ':', lineno, ':', colno);
    const errorContainer = document.getElementById('error-container');
    if (errorContainer) {
        displayErrors('حدث خطأ في JavaScript: ' + message, errorContainer);
    } else {
        alert('حدث خطأ في JavaScript: ' + message);
    }
    return false;
};

// Add AJAX error handler
$(document).ajaxError(function(event, jqXHR, settings, thrownError) {
    console.error('AJAX Error:', thrownError, '\nStatus:', jqXHR.status, '\nResponse:', jqXHR.responseText);
    const errorContainer = document.getElementById('error-container');
    if (errorContainer) {
        displayErrors('حدث خطأ في AJAX: ' + thrownError, errorContainer);
    } else {
        alert('حدث خطأ في AJAX: ' + thrownError);
    }
});

document.addEventListener('DOMContentLoaded', function() {
    const adminRoleSelect = document.getElementById('admin_role');
    const permissionCheckboxes = document.querySelectorAll('.permissions-tree input[type="checkbox"]');
    
    // Debug - check if checkboxes are found
    console.log('Number of permission checkboxes found:', permissionCheckboxes.length);
    if (permissionCheckboxes.length === 0) {
        console.error('No permission checkboxes found with selector: .permissions-tree input[type="checkbox"]');
        alert('لم يتم العثور على مربعات اختيار الصلاحيات!');
    }
    const errorContainer = document.getElementById('error-container');
    
    // Clear any errors on page load
    clearErrors(errorContainer);
    
    // Check for success parameter in URL
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has('success')) {
        displaySuccess('تم حفظ الصلاحيات بنجاح!', errorContainer);
    }

    // Initial state on page load - use the global handleRoleChange function
    handleRoleChange();

    // Listen for changes to the role select
    adminRoleSelect.addEventListener('change', handleRoleChange);

    // Existing toggleTree function
    function toggleTree(el) {
        const children = el.nextElementSibling;
        if (!children) return;
        const icon = el.querySelector('i');

        children.classList.toggle('collapsed');

        if (children.classList.contains('collapsed')) {
            icon.classList.replace('fa-folder-open', 'fa-folder');
        }
        else {
            icon.classList.replace('fa-folder', 'fa-folder-open');
        }
    }

    // Handle announcement permissions dependency
    const manageAnnouncementsCheckbox = document.querySelector('input[name="permissions[11][general]"]');
    const addNormalCheckbox = document.querySelector('input[name="permissions[12][general]"]');
    const addUrgentCheckbox = document.querySelector('input[name="permissions[13][general]"]');

    if (manageAnnouncementsCheckbox && addNormalCheckbox && addUrgentCheckbox) {
        // When add normal announcement is checked, automatically check manage announcements
        addNormalCheckbox.addEventListener('change', function() {
            if (this.checked) {
                manageAnnouncementsCheckbox.checked = true;
            }
        });

        // When add urgent announcement is checked, automatically check manage announcements
        addUrgentCheckbox.addEventListener('change', function() {
            if (this.checked) {
                manageAnnouncementsCheckbox.checked = true;
            }
        });

        // When manage announcements is unchecked, uncheck both add permissions
        manageAnnouncementsCheckbox.addEventListener('change', function() {
            if (!this.checked) {
                addNormalCheckbox.checked = false;
                addUrgentCheckbox.checked = false;
            }
        });
    }
    
    // Debug form submission
    const form = document.getElementById('permissions-form');
    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault(); // Prevent default form submission
            
            // Check if super_admin is selected
            const adminRoleSelect = document.getElementById('admin_role');
            const isSuperAdmin = adminRoleSelect && adminRoleSelect.value === 'super_admin';
            console.log('Is super_admin selected:', isSuperAdmin);
            
            try {
                console.log('Form submission triggered');
                
                // If super_admin is selected, we'll handle permissions differently
                if (!isSuperAdmin) {
                    // Only check for permissions if not super_admin
                    const checkedPermissions = document.querySelectorAll('.permissions-tree input[type="checkbox"]:checked');
                    if (checkedPermissions.length === 0) {
                        const errorContainer = document.getElementById('error-container');
                        clearErrors(errorContainer);
                        displayErrors('يجب تحديد صلاحية واحدة على الأقل', errorContainer);
                        return false;
                    }
                }
                // Continue with form submission
                if (!isSuperAdmin) {
                    // Only check for permissions if not super_admin
                    const checkedPermissions = document.querySelectorAll('.permissions-tree input[type="checkbox"]:checked');
                    if (checkedPermissions.length === 0) {
                        const errorContainer = document.getElementById('error-container');
                        clearErrors(errorContainer);
                        displayErrors('يجب تحديد صلاحية واحدة على الأقل', errorContainer);
                        return false;
                    }
                }
                // Ensure form is valid
                const isValid = form.checkValidity();
                console.log('Form validity:', isValid);
                
                if (!isValid) {
                    console.error('Form validation failed');
                    return false;
                }
                
                // Create form data
                const formData = new FormData(form);
                
                // Add admin_role to form data
                formData.append('admin_role', adminRoleSelect.value);
                console.log('Added admin_role to form data:', adminRoleSelect.value);
                
                // Special handling for super_admin role
                if (isSuperAdmin) {
                    console.log('Super admin role detected, ensuring all permissions are included');
                    
                    // Get all checkboxes and ensure they're included in the form data
                    const allCheckboxes = document.querySelectorAll('.permissions-tree input[type="checkbox"]');
                    allCheckboxes.forEach(checkbox => {
                        // For super_admin, all checkboxes should be checked
                        // We need to ensure the form data includes these values
                        const name = checkbox.getAttribute('name');
                        const value = checkbox.getAttribute('value');
                        
                        // Only add if not already in the form data
                        if (name && value && !formData.has(name)) {
                            formData.append(name, value);
                            console.log('Added to form data:', name, value);
                        }
                    });
                }
                
                // Log form data for debugging
                console.log('Form data entries:');
                for (let pair of formData.entries()) {
                    console.log(pair[0] + ': ' + pair[1]);
                }
                
                // Show loading indicator
                 const loadingIndicator = document.getElementById('loading-indicator');
                 const submitBtn = document.getElementById('submit-btn');
                 const manualSubmitBtn = document.getElementById('manual-submit');
                 
                 if (loadingIndicator) loadingIndicator.style.display = 'inline-block';
                 if (submitBtn) submitBtn.disabled = true;
                 if (manualSubmitBtn) manualSubmitBtn.disabled = true;
                 
                 // Submit form using fetch API
                 console.log('Submitting form using fetch...');
                 fetch(form.action, {
                     method: 'POST',
                     body: formData,
                     headers: {
                         'X-Requested-With': 'XMLHttpRequest',
                         'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                     }
                 })
                 .then(response => {
                        // Parse the response as JSON regardless of status
                        return response.json().catch(() => response.text())
                            .then(data => {
                                // If response is not ok, throw an error with the data
                                if (!response.ok) {
                                    const error = new Error('Server error: ' + response.status);
                                    error.data = data;
                                    throw error;
                                }
                                return data;
                            });
                    })
                    .then(data => {
                        console.log('Form submission successful:', data);
                        
                        // Clear any error messages
                        const errorContainer = document.getElementById('error-container');
                        clearErrors(errorContainer);
                        
                        // Show success message
                        displaySuccess('تم حفظ الصلاحيات بنجاح!', errorContainer);
                        
                        // Redirect after a short delay to show the success message
                        setTimeout(function() {
                            if (typeof data === 'object' && data.redirect) {
                                window.location.href = data.redirect;
                            } else {
                                window.location.href = '{{ route("admin.admins.index") }}?success=true';
                            }
                        }, 1500); // 1.5 second delay
                    })
                 .catch(error => {
                          console.error('Error during fetch submission:', error);
                          
                          const errorContainer = document.getElementById('error-container');
                          
                          // Check if we have structured error data from the server
                          if (error.data && typeof error.data === 'object') {
                              if (error.data.message) {
                                  displayErrors('خطأ: ' + error.data.message, errorContainer);
                              } else if (error.data.errors) {
                                  // Use the validation errors directly
                                  displayErrors(error.data.errors, errorContainer);
                              } else {
                                  displayErrors('حدث خطأ أثناء إرسال النموذج', errorContainer);
                              }
                          } else {
                              displayErrors('حدث خطأ أثناء إرسال النموذج: ' + error.message, errorContainer);
                          }
                          
                          // Hide loading indicator on error
                          if (loadingIndicator) loadingIndicator.style.display = 'none';
                          if (submitBtn) submitBtn.disabled = false;
                          if (manualSubmitBtn) manualSubmitBtn.disabled = false;
                      });
            } catch (error) {
                console.error('Error during form submission:', error);
                const errorContainer = document.getElementById('error-container');
                displayErrors('حدث خطأ أثناء إرسال النموذج: ' + error.message, errorContainer);
                
                // Hide loading indicator on error
                if (loadingIndicator) loadingIndicator.style.display = 'none';
                if (submitBtn) submitBtn.disabled = false;
                if (manualSubmitBtn) manualSubmitBtn.disabled = false;
                
                return false;
            }
        });}
        
        // Manual submit button
        const manualSubmitBtn = document.getElementById('manual-submit');
        if (manualSubmitBtn) {
            manualSubmitBtn.addEventListener('click', function() {
                try {
                    console.log('Manual form submission triggered');
                    
                    // Check if super_admin is selected
                    const adminRoleSelect = document.getElementById('admin_role');
                    const isSuperAdmin = adminRoleSelect && adminRoleSelect.value === 'super_admin';
                    console.log('Is super_admin selected:', isSuperAdmin);
                    
                    // Add admin_role to form data
                    const adminRoleInput = document.createElement('input');
                    adminRoleInput.type = 'hidden';
                    adminRoleInput.name = 'admin_role';
                    adminRoleInput.value = adminRoleSelect.value;
                    form.appendChild(adminRoleInput);
                    
                    // If super_admin is selected, we'll handle permissions differently
                    if (!isSuperAdmin) {
                        // Only check for permissions if not super_admin
                        const checkedPermissions = document.querySelectorAll('.permissions-tree input[type="checkbox"]:checked');
                        if (checkedPermissions.length === 0) {
                            const errorContainer = document.getElementById('error-container');
                            clearErrors(errorContainer);
                            displayErrors('يجب تحديد صلاحية واحدة على الأقل', errorContainer);
                            return false;
                        }
                    }
                    
                    // Show loading indicator
                    const loadingIndicator = document.getElementById('loading-indicator');
                    const submitBtn = document.getElementById('submit-btn');
                    
                    if (loadingIndicator) loadingIndicator.style.display = 'inline-block';
                    if (submitBtn) submitBtn.disabled = true;
                    if (manualSubmitBtn) manualSubmitBtn.disabled = true;
                    
                    // Get form data
                    const formData = new FormData(form);
                    formData.append('manual_submit', '1');
                    
                    // Add admin_role to form data
                    const adminRoleSelect = document.getElementById('admin_role');
                    formData.append('admin_role', adminRoleSelect.value);
                    console.log('Added admin_role to form data:', adminRoleSelect.value);
                    
                    // Special handling for super_admin role
                    if (isSuperAdmin) {
                        console.log('Super admin role detected, ensuring all permissions are included');
                        
                        // Get all checkboxes and ensure they're included in the form data
                        const allCheckboxes = document.querySelectorAll('.permissions-tree input[type="checkbox"]');
                        allCheckboxes.forEach(checkbox => {
                            // For super_admin, all checkboxes should be checked
                            // We need to ensure the form data includes these values
                            const name = checkbox.getAttribute('name');
                            const value = checkbox.getAttribute('value');
                            
                            // Only add if not already in the form data
                            if (name && value && !formData.has(name)) {
                                formData.append(name, value);
                                console.log('Added to form data:', name, value);
                            }
                        });
                    }
                    
                    // Submit using fetch API
                    fetch(form.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                        }
                    })
                    .then(response => {
                        // Parse the response as JSON regardless of status
                        return response.json().catch(() => response.text())
                            .then(data => {
                                // If response is not ok, throw an error with the data
                                if (!response.ok) {
                                    const error = new Error('Server error: ' + response.status);
                                    error.data = data;
                                    throw error;
                                }
                                return data;
                            });
                    })
                    .then(data => {
                          console.log('Manual form submission successful:', data);
                          
                          // Clear any error messages
                          const errorContainer = document.getElementById('error-container');
                          clearErrors(errorContainer);
                          
                          // Show success message
                          displaySuccess('تم حفظ الصلاحيات بنجاح!', errorContainer);
                          
                          // Redirect after a short delay to show the success message
                          setTimeout(function() {
                              if (typeof data === 'object' && data.redirect) {
                                  window.location.href = data.redirect;
                              } else {
                                  window.location.href = '{{ route("admin.admins.index") }}?success=true';
                              }
                          }, 1500); // 1.5 second delay
                      })
                    .catch(error => {
                        console.error('Error during fetch submission:', error);
                        
                        const errorContainer = document.getElementById('error-container');
                        
                        // Check if we have structured error data from the server
                        if (error.data && typeof error.data === 'object') {
                            if (error.data.message) {
                                displayErrors('خطأ: ' + error.data.message, errorContainer);
                            } else if (error.data.errors) {
                                // Use the validation errors directly
                                displayErrors(error.data.errors, errorContainer);
                            } else {
                                displayErrors('حدث خطأ أثناء إرسال النموذج', errorContainer);
                            }
                        } else {
                            displayErrors('حدث خطأ أثناء إرسال النموذج: ' + error.message, errorContainer);
                        }
                        
                        // Hide loading indicator on error
                        if (loadingIndicator) loadingIndicator.style.display = 'none';
                        if (submitBtn) submitBtn.disabled = false;
                        if (manualSubmitBtn) manualSubmitBtn.disabled = false;
                    });
                } catch (error) {
                    console.error('Error during manual form submission:', error);
                    const errorContainer = document.getElementById('error-container');
                    displayErrors('حدث خطأ أثناء محاولة حفظ الصلاحيات. يرجى المحاولة مرة أخرى.', errorContainer);
                    
                    // Hide loading indicator on error
                    if (loadingIndicator) loadingIndicator.style.display = 'none';
                    if (submitBtn) submitBtn.disabled = false;
                    if (manualSubmitBtn) manualSubmitBtn.disabled = false;
                }
            });
        }
    }
});
</script>
@endsection
