@extends('layouts.admin')

@section('content')
<nav class="main-navbar fixed-navbar">
    <div class="navbar-content breadcrumb-nav breadcrumb-nav-top">
        <span class="breadcrumb-current" style="color:#d4af37;">المشرفون</span>
        <span class="breadcrumb-sep" style="color:white">&larr;</span>
        <span class="breadcrumb-current " style="color:white;">ادارة المشرفين</span>
    </div>
</nav>
<div class="admins-list-container" style="max-width:1200px;margin:0 auto; ">
    <div style="height:2.5rem;"></div>
    <form method="GET" class="filter-form" onsubmit="return false;">
        <div class="filter-row filter-row-flex">
            <div class="filter-group filter-half">
                <label for="name">اسم الموظف</label>
                <input type="text" id="name-filter" placeholder="بحث بالاسم...">
            </div>
            <div class="filter-group filter-half">
                <label for="role">مسمى المشرف</label>
                <select id="role-filter">
                    <option value="">الكل</option>
                    <option value="admin">مشرف</option>
                    <option value="super_admin">مشرف عام</option>
                </select>
            </div>
        </div>
    </form>
    <div class="admins-table-card" style="background:#faf9f6;border-radius:16px;box-shadow:0 4px 24px rgba(30,41,59,0.07);padding:2.2rem 1.5rem;border-top:5px solid #d4af37;">
        <table class="admins-table" style="width:100%;border-collapse:separate;border-spacing:0 0.5rem;font-size:1.07rem;font-family:'Cairo',sans-serif;" id="admins-table">
            <thead>
                <tr style="background:linear-gradient(135deg,#174032 0%,#174032 100%);color:#d4af37;font-weight:700;">
                    <th style="padding:1rem 0.5rem;text-align:center;">الاسم الكامل</th>
                    <th style="padding:1rem 0.5rem;text-align:center;">البريد الإلكتروني</th>
                    <th style="padding:1rem 0.5rem;text-align:center;">رقم الهاتف</th>
                    <th style="padding:1rem 0.5rem;text-align:center;">مسمى المشرف</th>
                    <th style="padding:1rem 0.5rem;text-align:center;">إجراءات</th>
                </tr>
            </thead>
            <tbody>
                @forelse($admins as $admin)
                <tr data-name="{{ $admin->name }}" data-role="{{ $admin->role }}">
                    <td style="padding:0.9rem 0.5rem;text-align:center;font-weight:500;">{{ $admin->name }}</td>
                    <td style="padding:0.9rem 0.5rem;text-align:center;">{{ $admin->email }}</td>
                    <td style="padding:0.9rem 0.5rem;text-align:center;">{{ $admin->phone ?? '-' }}</td>
                    <td style="padding:0.9rem 0.5rem;text-align:center;">
                        @if($admin->role === 'super_admin')
                            مشرف عام
                        @else
                            مشرف
                        @endif
                    </td>
                    <td style="padding:0.9rem 0.5rem;text-align:center;">
                        <a href="{{ route('admin.admins.edit', $admin->id) }}" class="btn btn-sm btn-warning" title="تعديل"><i class="fas fa-edit"></i></a>
                        @if(auth()->user()->hasPermission('assign_permissions'))
                        <a href="{{ route('admin.admins.permissions', $admin->id) }}" class="btn btn-sm btn-success" title="تعيين الصلاحيات" style="margin-right: 0.5rem;"><i class="fas fa-key"></i></a>
                        @endif
                        <form action="{{ route('admin.admins.destroy', $admin->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" title="حذف" onclick="return confirm('هل أنت متأكد من حذف هذا المشرف؟');"><i class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center">لا يوجد مشرفون بعد.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<style>
.admins-list-container {
    font-family: 'Cairo', sans-serif;
    background: none;
    padding: 0.5rem;
}
.admins-title {
    margin-bottom: 0;
}
.admins-table th, .admins-table td { border: none !important; }
.admins-row:hover { background: #faf9f6 !important; }
.filter-form {
    margin-bottom: 1.5rem;
    display: flex;
    justify-content: flex-end;
}
.filter-row {
    display: flex;
    gap: 1.5rem;
    align-items: flex-end;
}
.filter-group {
    display: flex;
    flex-direction: column;
    gap: 0.3rem;
}
.filter-group label {
    font-size: 1rem;
    color: #174032;
    font-weight: 700;
    margin-bottom: 0.2rem;
}
.filter-group input, .filter-group select {
    padding: 0.6rem 1rem;
    border: 2px solid #e8e8e8;
    border-radius: 10px;
    font-size: 1rem;
    font-family: 'Cairo', sans-serif;
    background: #faf9f6;
    color: #2c3e50;
    transition: border 0.2s;
}
.filter-group input:focus, .filter-group select:focus {
    border-color: #d4af37;
    outline: none;
}
.filter-row.filter-row-flex {
    display: flex;
    width: 100%;
    gap: 1.5rem;
    align-items: flex-end;
    margin-bottom: 1.5rem;
}
.filter-group.filter-half {
    flex: 1 1 0;
    min-width: 0;
}
.main-navbar.fixed-navbar {
    position: fixed;
    top: 0;
    right: 68px;
    left: 0;
    width: calc(100vw - 68px);
    background: #174032;
    padding: 0.7rem 0 0.7rem 0;
    margin-bottom: 1.5rem;
    box-shadow: 0 2px 12px rgba(23,64,50,0.07);
    z-index: 900;
    border-radius: 0 0 18px 0;
    transition: right 0.35s cubic-bezier(.4,0,.2,1), width 0.35s cubic-bezier(.4,0,.2,1);
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
    padding-right: 2.5rem;
}
@media (max-width: 900px) {
    .navbar-content {
        padding-right: 1rem;
    }
    .main-navbar.fixed-navbar {
        right: 56px;
        width: calc(100vw - 56px);
    }
}
.sider {
    z-index: 1001 !important;
}
.sider:not(.sider-collapsed) ~ .main-navbar.fixed-navbar {
    right: 320px;
    width: calc(100vw - 320px);
}
</style>
@endsection

@section('scripts')
<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteAdminModal" tabindex="-1" aria-labelledby="deleteAdminModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header" style="background:linear-gradient(135deg,#174032 0%,#14532d 100%);color:#d4af37;">
        <h5 class="modal-title" id="deleteAdminModalLabel"><i class="fas fa-exclamation-triangle"></i> تأكيد حذف المشرف</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="إغلاق"></button>
      </div>
      <div class="modal-body" style="font-family:'Cairo',sans-serif;">
        <p>هل أنت متأكد أنك تريد حذف المشرف التالي؟</p>
        <div id="adminNameToDelete" style="font-weight:900;color:#174032;font-size:1.2rem;"></div>
        <p class="text-danger mt-2 mb-0"><i class="fas fa-info-circle"></i> لا يمكن التراجع عن هذا الإجراء.</p>
      </div>
      <div class="modal-footer" style="display: flex; flex-direction: row; gap: 0.5rem; align-items: center; justify-content: flex-end; direction: rtl;">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
        <button type="button" class="btn btn-danger" id="confirmDeleteAdminBtn"><i class="fas fa-trash-alt"></i> حذف</button>
      </div>
    </div>
  </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    let formToDelete = null;
    const modal = new bootstrap.Modal(document.getElementById('deleteAdminModal'));
    const adminNameElem = document.getElementById('adminNameToDelete');
    document.querySelectorAll('.delete-admin-btn').forEach(function(btn) {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            formToDelete = btn.closest('form');
            const adminName = formToDelete.getAttribute('data-admin-name');
            adminNameElem.textContent = adminName;
            modal.show();
        });
    });
    document.getElementById('confirmDeleteAdminBtn').addEventListener('click', function() {
        if (formToDelete) {
            formToDelete.submit();
        }
        modal.hide();
    });

    // Filter logic
    const nameInput = document.getElementById('name-filter');
    const roleSelect = document.getElementById('role-filter');
    const table = document.getElementById('admins-table');
    if (nameInput && roleSelect && table) {
        const rows = Array.from(table.querySelectorAll('tbody tr'));
        function filterTable() {
            const nameVal = nameInput.value.trim().toLowerCase();
            const roleVal = roleSelect.value;
            rows.forEach(row => {
                const rowName = row.getAttribute('data-name').toLowerCase();
                const rowRole = row.getAttribute('data-role');
                const nameMatch = !nameVal || rowName.includes(nameVal);
                const roleMatch = !roleVal || rowRole === roleVal;
                row.style.display = (nameMatch && roleMatch) ? '' : 'none';
            });
        }
        nameInput.addEventListener('input', filterTable);
        roleSelect.addEventListener('change', filterTable);
    }
});
</script>
@endsection