@extends('layouts.admin')

@section('content')
<div class="create-admin-container" style="max-width:1200px;margin:0 auto;">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="create-admin-title" style="font-weight:900;color:#174032;font-size:1.5rem;letter-spacing:0.5px;font-family:'Cairo',sans-serif;">تعديل بيانات المشرف</h2>
    </div>

    <div class="form-card">
        <div class="card-header">
            <div class="card-icon">
                <i class="fas fa-user-edit"></i>
            </div>
            <div class="card-title">
                <h2>بيانات المشرف</h2>
                <p>يرجى تعديل الحقول المطلوبة</p>
            </div>
        </div>

        <form method="POST" action="{{ route('admin.admins.update', $admin->id) }}" class="admin-form">
            @csrf
            @method('PUT')
            <div class="form-grid-row">
                <div class="form-group">
                    <label for="name" class="form-label">الاسم الكامل</label>
                    <div class="input-icon-wrapper">
                        <i class="fas fa-user input-inside-icon"></i>
                    <input type="text" id="name" name="name" class="form-input" 
                           value="{{ old('name', $admin->name) }}" required 
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
                           value="{{ old('email', $admin->email) }}" required 
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
                            <option value="admin" {{ old('role', $admin->role) == 'admin' ? 'selected' : '' }}>مشرف</option>
                            <option value="super_admin" {{ old('role', $admin->role) == 'super_admin' ? 'selected' : '' }}>مشرف عام</option>
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
                               value="{{ old('phone', $admin->phone) }}" 
                               placeholder="أدخل رقم الهاتف (مثال: 0551234567)" autocomplete="off">
                    </div>
                    @error('phone')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="password" class="form-label">كلمة المرور الجديدة (اختياري)</label>
                    <div class="input-icon-wrapper">
                        <i class="fas fa-lock input-inside-icon"></i>
                    <input type="password" id="password" name="password" class="form-input" 
                           placeholder="أدخل كلمة المرور الجديدة (اتركها فارغة للإبقاء على الحالية)" autocomplete="new-password">
                    </div>
                    @error('password')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="form-grid-row">
                <div class="form-group">
                    <label for="password_confirmation" class="form-label">تأكيد كلمة المرور الجديدة</label>
                    <div class="input-icon-wrapper">
                        <i class="fas fa-lock input-inside-icon"></i>
                    <input type="password" id="password_confirmation" name="password_confirmation" 
                           class="form-input" placeholder="أعد إدخال كلمة المرور الجديدة" autocomplete="new-password">
                    </div>
                </div>
                <div class="form-group">
                    <label for="note" class="form-label">ملاحظة</label>
                    <div class="input-icon-wrapper">
                        <i class="fas fa-sticky-note input-inside-icon"></i>
                        <textarea id="note" name="note" class="form-input" rows="2" placeholder="أدخل ملاحظة عن المشرف (اختياري)">{{ old('note', $admin->note) }}</textarea>
                    </div>
                    @error('note')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="submit-btn">
                    <i class="fas fa-save"></i>
                    حفظ التعديلات
                </button>
                <a href="{{ route('admin.admins.index') }}" class="cancel-btn">
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
    padding: 0.5rem 0.5rem 0.5rem 0.5rem;
}
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
.form-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
    gap: 0.5rem;
    margin-bottom: 1rem;
}
.form-group {
    position: relative;
    margin-bottom: 1.1rem;
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
.form-input:focus {
    outline: none;
    border-color: #d4af37;
    background: #fffbe6;
    box-shadow: 0 4px 16px rgba(212, 175, 55, 0.1);
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
    color: #174032;
    border-color: #d4af37;
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
</style>
@endsection 