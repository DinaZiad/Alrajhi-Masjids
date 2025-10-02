@extends('layouts.admin')

@section('content')
<x-breadcrumb :items="[
    ['title' => 'المشرفون', 'url' => route('admin.admins.index')],
    ['title' => 'إضافة مشرف جديد']
]" />
<div style="height:2.5rem;"></div>
<div class="create-admin-container" style="max-width:1200px;margin:0 auto;">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="create-admin-title" style="font-weight:900;color:#174032;font-size:1.5rem;letter-spacing:0.5px;font-family:'Cairo',sans-serif;">إضافة مشرف جديد</h2>
    </div>

    <div class="form-card">
        <div class="card-header">
            <div class="card-icon">
                <i class="fas fa-user-plus"></i>
            </div>
            <div class="card-title">
                <h2>بيانات المشرف</h2>
                <p>يرجى ملء جميع الحقول المطلوبة</p>
            </div>
        </div>

        <form method="POST" action="{{ route('admin.users.store') }}" class="admin-form">
            @csrf
            
            <div class="form-grid-row">
                <div class="form-group">
                    <label for="name" class="form-label">الاسم الكامل</label>
                    <div class="input-icon-wrapper">
                        <i class="fas fa-user input-inside-icon"></i>
                    <input type="text" id="name" name="name" class="form-input" 
                           value="{{ old('name') }}" required 
                           placeholder="أدخل الاسم الكامل" autocomplete="off">
                    </div>
                    @error('name')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="email" class="form-label">البريد الإلكتروني</label>
                    <div class="input-icon-wrapper">
                        <i class="fas fa-envelope input-inside-icon"></i>
                    <input type="email" id="email" name="email" class="form-input" 
                           value="{{ old('email') }}" required 
                           placeholder="أدخل البريد الإلكتروني" autocomplete="off">
                    </div>
                    @error('email')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="form-grid-row form-grid-row-3">
                <div class="form-group">
                    <label for="role" class="form-label">الدور</label>
                    <div class="input-icon-wrapper">
                        <i class="fas fa-user-shield input-inside-icon"></i>
                        <select id="role" name="role" class="form-input" required>
                            <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>مشرف</option>
                            <option value="super_admin" {{ old('role') == 'super_admin' ? 'selected' : '' }}>مشرف عام</option>
                        </select>
                    </div>
                    @error('role')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="phone" class="form-label">رقم الهاتف</label>
                    <div class="input-icon-wrapper">
                        <i class="fas fa-phone input-inside-icon"></i>
                        <input type="tel" id="phone" name="phone" class="form-input" 
                               value="{{ old('phone') }}" 
                               placeholder="أدخل رقم الهاتف (مثال: 0551234567)" autocomplete="off">
                    </div>
                    @error('phone')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="password" class="form-label">كلمة المرور</label>
                    <div class="input-icon-wrapper">
                        <i class="fas fa-lock input-inside-icon"></i>
                    <input type="password" id="password" name="password" class="form-input" 
                           required placeholder="أدخل كلمة المرور" autocomplete="off">
                    </div>
                    @error('password')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="form-grid-row">
                <div class="form-group">
                    <label for="password_confirmation" class="form-label">تأكيد كلمة المرور</label>
                    <div class="input-icon-wrapper">
                        <i class="fas fa-lock input-inside-icon"></i>
                    <input type="password" id="password_confirmation" name="password_confirmation" 
                           class="form-input" required placeholder="أعد إدخال كلمة المرور" autocomplete="off">
                    </div>
                </div>
                <div class="form-group">
                    <label for="note" class="form-label">ملاحظة</label>
                    <div class="input-icon-wrapper">
                        <i class="fas fa-sticky-note input-inside-icon"></i>
                        <textarea id="note" name="note" class="form-input" rows="2" placeholder="أدخل ملاحظة عن المشرف (اختياري)">{{ old('note') }}</textarea>
                    </div>
                    @error('note')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <!-- Permissions Assignment Tree Structure -->
            <div class="permissions-section">
                <h3 class="section-title">صلاحيات المشرف</h3>
                
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
                                            value="{{ $masjid->id }}" class="permission-checkbox">
                                        إدارة {{ $masjid->name }}
                                    </label>
                                </li>
                                @endforeach
                            </ul>
                        </li>

                        <!-- Programs -->
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
                                                value="{{ $type->id }}" class="permission-checkbox">
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
                                             value="1" class="permission-checkbox">
                                         إدارة البيانات
                                     </label>
                                </li>
                                <li>
                                    <label class="tree-label">
                                         <input type="checkbox" 
                                             name="permissions[16][general]" 
                                             value="1" class="permission-checkbox">
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
                                            value="1" class="permission-checkbox">
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
                                                    value="1" class="permission-checkbox">
                                                إضافة إعلان عادي
                                            </label>
                                        </li>
                                        <li>
                                            <label class="tree-label">
                                                <input type="checkbox" 
                                                    name="permissions[13][general]" 
                                                    value="1" class="permission-checkbox">
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
                                            value="1" class="permission-checkbox">
                                        إدارة المشرفين
                                    </label>
                                </li>
                                <li>
                                    <label class="tree-label">
                                        <input type="checkbox" 
                                            name="permissions[8][general]" 
                                            value="1" class="permission-checkbox">
                                        إضافة مشرف جديد
                                    </label>
                                </li>
                                <li>
                                    <label class="tree-label">
                                        <input type="checkbox" 
                                            name="permissions[10][general]" 
                                            value="1" class="permission-checkbox">
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
                                            value="1" class="permission-checkbox">
                                        إدارة الرموز
                                    </label>
                                </li>
                                <li>
                                    <label class="tree-label">
                                        <input type="checkbox" 
                                            name="permissions[18][general]" 
                                            value="1" class="permission-checkbox">
                                        العام الهجري
                                    </label>
                                </li>
                                <li>
                                    <label class="tree-label">
                                        <input type="checkbox" 
                                            name="permissions[19][general]" 
                                            value="1" class="permission-checkbox">
                                        الأقسام
                                    </label>
                                </li>
                                <li>
                                    <label class="tree-label">
                                        <input type="checkbox" 
                                            name="permissions[20][general]" 
                                            value="1" class="permission-checkbox">
                                        المستويات
                                    </label>
                                </li>
                                <li>
                                    <label class="tree-label">
                                        <input type="checkbox" 
                                            name="permissions[21][general]" 
                                            value="1" class="permission-checkbox">
                                        التخصصات
                                    </label>
                                </li>
                                <li>
                                    <label class="tree-label">
                                        <input type="checkbox" 
                                            name="permissions[22][general]" 
                                            value="1" class="permission-checkbox">
                                        الكتب
                                    </label>
                                </li>
                                <li>
                                    <label class="tree-label">
                                        <input type="checkbox" 
                                            name="permissions[23][general]" 
                                            value="1" class="permission-checkbox">
                                        أنواع البرامج
                                    </label>
                                </li>
                                <li>
                                    <label class="tree-label">
                                        <input type="checkbox" 
                                            name="permissions[24][general]" 
                                            value="1" class="permission-checkbox">
                                        المعلمون
                                    </label>
                                </li>
                                <li>
                                    <label class="tree-label">
                                        <input type="checkbox" 
                                            name="permissions[28][general]" 
                                            value="1" class="permission-checkbox">
                                     المساجد
                                    </label>
                                </li>
                                <li>
                                    <label class="tree-label">
                                        <input type="checkbox" 
                                            name="permissions[29][general]" 
                                            value="1" class="permission-checkbox">
                                     المباني
                                    </label>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Add JavaScript for toggling tree nodes -->
            <script>
                function toggleTree(element, event) {
                    // Prevent toggling if a checkbox was clicked
                    if (event && event.target.type === 'checkbox') {
                        return;
                    }

                    // If clicked on text/icon area, toggle the checkbox
                    const checkbox = element.querySelector('input[type="checkbox"]');
                    if (checkbox && (event.target.tagName === 'I' || event.target === element || event.target.nodeType === Node.TEXT_NODE)) {
                        checkbox.checked = !checkbox.checked;
                        // Trigger change event to update related checkboxes
                        checkbox.dispatchEvent(new Event('change', { bubbles: true }));
                        return;
                    }

                    const children = element.nextElementSibling;
                    if (children) {
                        children.classList.toggle('open');
                        const icon = element.querySelector('i');
                        if (icon) {
                            if (children.classList.contains('open')) {
                                icon.className = icon.className.replace('fa-folder', 'fa-folder-open');
                            } else {
                                icon.className = icon.className.replace('fa-folder-open', 'fa-folder');
                            }
                        }
                    }
                }



                document.addEventListener('DOMContentLoaded', function() {
                    // No special checkbox listeners needed for simplified structure
                });
                
                // Initialize all trees as closed except the main categories
                document.addEventListener('DOMContentLoaded', function() {
                    const mainFolders = document.querySelectorAll('.tree-list > li > .tree-folder');
                    mainFolders.forEach(folder => {
                        const children = folder.nextElementSibling;
                        if (children) {
                            children.classList.add('open');
                        }
                    });

                });
            </script>

            <div class="form-actions">
                <button type="submit" class="submit-btn">
                    <i class="fas fa-save"></i>
                    إضافة المشرف
                </button>
                <a href="{{ route('admin.dashboard') }}" class="cancel-btn">
                    <i class="fas fa-times"></i>
                    إلغاء
                </a>
            </div>
        </form>
    </div>
</div>

<style>
.create-admin-container {
    font-family: 'Cairo', sans-serif;
    /* background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); */
    /* min-height: 100vh; */
    padding: 0.5rem 0.5rem 0.5rem 0.5rem;
}

/* Form Card */
.form-card {
    background: #faf9f6;
    border-radius: 16px;
    padding: 1rem 1rem;
    box-shadow: 0 4px 24px rgba(30,41,59,0.07);
    border-top: 5px solid #d4af37;
    width: 100%;
}

.card-header {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 1rem;
    padding-bottom: 0.5rem;
    border-bottom: 2px solid #f0f0f0;
}

.card-icon {
    width: 50px;
    height: 50px;
    background: linear-gradient(135deg, #d4af37 0%, #b8941f 100%);
    border-radius: 15px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    font-size: 1.3rem;
}

.card-title h2 {
    color: #174032;
    font-size: 1.6rem;
    font-weight: 800;
    margin-bottom: 0.2rem;
}

.card-title p {
    color: #6c757d;
    font-size: 1rem;
    margin: 0;
}

/* Form Grid */
.form-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
    gap: 0.5rem;
    margin-bottom: 1rem;
}

.form-group {
    position: relative;
    margin-bottom: 1.1rem;
    display: flex;
    flex-direction: column;
    justify-content: center;
}

.form-label {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: #174032;
    font-weight: 700;
    font-size: 1rem;
    margin-bottom: 0.3rem;
}

.form-label i {
    color: #d4af37;
    font-size: 1.1rem;
}

.input-icon-wrapper {
    position: relative;
    display: flex;
    align-items: center;
}
.input-inside-icon {
    position: absolute;
    right: 1rem;
    color: #d4af37;
    font-size: 1.1rem;
    pointer-events: none;
    z-index: 2;
}
.form-input, select.form-input, textarea.form-input {
    width: 100%;
    padding: 0.75rem 1rem 0.75rem 3rem;
    border: 2px solid #e8e8e8;
    border-radius: 12px;
    font-size: 1rem;
    font-family: 'Cairo', sans-serif;
    background: #fff;
    color: #2c3e50;
    transition: all 0.3s ease;
    box-sizing: border-box;
    padding-right: 2.5rem;
}
textarea.form-input {
    min-height: 45px;
    resize: vertical;
}

.form-input:focus {
    outline: none;
    border-color: #F7A600;
    background: #fffbe6;
    box-shadow: 0 4px 16px rgba(247, 166, 0, 0.1);
}

/* Checkbox styles to match assign-permissions page */
.tree-label input[type="checkbox"] {
    appearance: none;
    width: 18px;
    height: 18px;
    border: 2px solid #F7A600;
    border-radius: 4px;
    cursor: pointer;
    position: relative;
    transition: all 0.2s ease;
}

.tree-label input[type="checkbox"]:checked {
    background-color: #F7A600;
    border-color: #F7A600;
}

.tree-label input[type="checkbox"]:checked::after {
    content: '✓';
    position: absolute;
    color: white;
    font-size: 14px;
    font-weight: bold;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
}

.form-input::placeholder {
    color: #6c757d;
    opacity: 0.7;
}

.error-message {
    color: #dc3545;
    font-size: 0.85rem;
    margin-top: 0.25rem;
    display: block;
}

/* Form Actions */
.form-actions {
    display: flex;
    gap: 0.5rem;
    justify-content: center;
    margin-top: 1rem;
}

.submit-btn, .cancel-btn {
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

.submit-btn {
    background: linear-gradient(135deg, #174032 0%, #14532d 100%);
    color: #d4af37;
}

.submit-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(23, 64, 50, 0.2);
}

.cancel-btn {
    background: #f8f9fa;
    color: #6c757d;
    border: 2px solid #e8e8e8;
}

.cancel-btn:hover {
    background: #e9ecef;
    color: #495057;
    transform: translateY(-2px);
}

/* Responsive Design */
@media (max-width: 768px) {
    .create-admin-container {
        padding: 0.5rem;
    }
    
    .page-header {
        padding: 2rem 1rem;
    }
    
    .page-title {
        font-size: 2rem;
    }
    
    .form-card {
        padding: 1rem;
    }
    
    .form-grid {
        grid-template-columns: 1fr;
    }
    
    .form-actions {
        flex-direction: column;
    }
    
    .submit-btn, .cancel-btn {
        width: 100%;
        justify-content: center;
    }
}

@media (max-width: 480px) {
    .page-title {
        font-size: 1.8rem;
    }
    
    .card-header {
        flex-direction: column;
        text-align: center;
    }
    
    .card-icon {
        width: 50px;
        height: 50px;
        font-size: 1.3rem;
    }
}
.custom-admin-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1rem;
}
.custom-admin-grid > .form-group:nth-child(4),
.custom-admin-grid > .form-group:nth-child(5) {
    grid-column: span 1;
}
.custom-admin-grid > .form-group:nth-child(6) {
    grid-column: 1 / span 3;
}
@media (max-width: 900px) {
    .custom-admin-grid {
        grid-template-columns: 1fr 1fr;
    }
    .custom-admin-grid > .form-group:nth-child(6) {
        grid-column: 1 / span 2;
    }
}
@media (max-width: 600px) {
    .custom-admin-grid {
        grid-template-columns: 1fr;
    }
    .custom-admin-grid > .form-group {
        grid-column: 1 / span 1 !important;
    }
}
.custom-admin-grid-v2 {
    display: grid;
    grid-template-columns: 1fr 1fr 1fr;
    gap: 1rem;
}
.custom-admin-grid-v2 > .form-group {
    margin-bottom: 0;
}
.custom-admin-grid-v2 > .form-group[style*="grid-column: 1 / span 1"]:nth-child(1),
.custom-admin-grid-v2 > .form-group[style*="grid-column: 2 / span 1"]:nth-child(2) {
    /* First row: two inputs, each half width */
    grid-column: span 1;
}
.custom-admin-grid-v2 > .form-group[style*="grid-column: 1 / span 1"]:nth-child(3),
.custom-admin-grid-v2 > .form-group[style*="grid-column: 2 / span 1"]:nth-child(4),
.custom-admin-grid-v2 > .form-group[style*="grid-column: 3 / span 1"]:nth-child(5) {
    /* Second row: three inputs, each third width */
    grid-column: span 1;
}
.custom-admin-grid-v2 > .form-group[style*="grid-column: 1 / span 1"]:nth-child(6),
.custom-admin-grid-v2 > .form-group[style*="grid-column: 2 / span 1"]:nth-child(7) {
    /* Third row: two inputs, each half width */
    grid-column: span 1;
}
@media (max-width: 900px) {
    .custom-admin-grid-v2 {
        grid-template-columns: 1fr 1fr;
    }
    .custom-admin-grid-v2 > .form-group {
        grid-column: span 1 !important;
    }
}
@media (max-width: 600px) {
    .custom-admin-grid-v2 {
        grid-template-columns: 1fr;
    }
    .custom-admin-grid-v2 > .form-group {
        grid-column: span 1 !important;
    }
}
.form-grid-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
    margin-bottom: 0.5rem;
}
.form-grid-row-3 {
    grid-template-columns: 1fr 1fr 1fr;
}
@media (max-width: 900px) {
    .form-grid-row {
        grid-template-columns: 1fr;
    }
    .form-grid-row-3 {
        grid-template-columns: 1fr;
    }
}
/* Tree structure styles */
.permissions-section {
    margin-top: 2rem;
    padding: 1.5rem;
    background: #f8fafc;
    border-radius: 12px;
    box-shadow: 0 2px 12px rgba(0,0,0,0.05);
}

.section-title {
    font-weight: 800;
    font-size: 1.3rem;
    color: #174032;
    margin-bottom: 1.5rem;
    text-align: center;
    position: relative;
}

.section-title:after {
    content: '';
    position: absolute;
    bottom: -10px;
    left: 50%;
    transform: translateX(-50%);
    width: 80px;
    height: 3px;
    background: #d4af37;
    border-radius: 2px;
}

.permissions-tree {
    margin-top: 1.5rem;
}

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

.tree-children {
    display: none;
    padding-right: 2em;
}

.tree-children.open {
    display: block;
}

.tree-folder {
    display: flex;
    align-items: center;
    gap: 0.5em;
    padding: 0.7em 0.5em;
    font-weight: 700;
    color: #174032;
    cursor: pointer;
    border-radius: 8px;
    transition: background 0.2s;
}

.tree-folder:hover {
    background: #f1f5f9;
}

.tree-folder i {
    color: #d4af37;
}

.sub-folder {
    font-size: 0.95rem;
    color: #14532D;
}

.tree-label {
    display: flex;
    align-items: center;
    gap: 0.5em;
    padding: 0.5em;
    font-size: 0.9rem;
    color: #374151;
    cursor: pointer;
    border-radius: 6px;
    transition: background 0.2s;
}

.tree-label:hover {
    background: #f1f9f5;
}

.tree-label input[type="checkbox"] {
    width: 18px;
    height: 18px;
    border: 2px solid #d4af37;
    border-radius: 4px;
    cursor: pointer;
}

.tree-label input[type="checkbox"]:checked {
    background-color: #d4af37;
    border-color: #d4af37;
}
</style>
@endsection