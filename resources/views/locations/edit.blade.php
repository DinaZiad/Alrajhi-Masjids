@extends('layouts.admin')

@section('content')
<div class="locations-page-container" style="max-width:1200px;margin:0 auto;">
    <div class="locations-table-card" style="background:#faf9f6;border-radius:16px;box-shadow:0 4px 24px rgba(30,41,59,0.07);padding:2.2rem 1.5rem;border-top:5px solid #d4af37;">
        <h2 class="locations-title" style="font-weight:900;color:#174032;font-size:1.5rem;letter-spacing:0.5px;font-family:'Cairo',sans-serif;text-align:center;margin-bottom:2rem;">تعديل الموقع</h2>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form id="location-form" method="POST" action="{{ route('locations.update', $location) }}">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label class="form-label" style="color:#174032;font-weight:700;font-family:'Cairo',sans-serif;">اسم الموقع</label>
                <input type="text" name="name" class="form-control" required value="{{ old('name', $location->name) }}" style="border-radius:8px;border:1.5px solid #d4af37;font-family:'Cairo',sans-serif;">
            </div>
            <div class="mb-3">
                <label class="form-label" style="color:#174032;font-weight:700;font-family:'Cairo',sans-serif;">تفاصيل إضافية</label>
                <div id="details-fields">
                    @php
                        $details = is_array($location->details) ? $location->details : [];
                    @endphp
                    @if(count($details))
                        @foreach($details as $detail)
                            <div class="input-group mb-2">
                                <input type="text" class="form-control" name="details_field[]" value="{{ $detail }}" placeholder="أدخل تفاصيل..." style="border-radius:8px;border:1.5px solid #d4af37;font-family:'Cairo',sans-serif;">
                                <button type="button" class="btn btn-danger remove-field" style="border-radius:8px;">حذف</button>
                            </div>
                        @endforeach
                    @else
                        <div class="input-group mb-2">
                            <input type="text" class="form-control" name="details_field[]" placeholder="أدخل تفاصيل..." style="border-radius:8px;border:1.5px solid #d4af37;font-family:'Cairo',sans-serif;">
                            <button type="button" class="btn btn-danger remove-field" style="display:none;border-radius:8px;">حذف</button>
                        </div>
                    @endif
                </div>
                <button type="button" class="btn btn-secondary" id="add-detail" style="border-radius:8px;background:#174032;color:#fff;font-family:'Cairo',sans-serif;">إضافة حقل جديد</button>
                <input type="hidden" name="details" id="details-json">
                <small class="text-muted">أضف تفاصيل متعددة، كل حقل يمثل معلومة منفصلة</small>
            </div>
            <div class="d-flex justify-content-center gap-3 mt-4">
                <button type="submit" class="btn btn-primary" style="border-radius:8px;background:#d4af37;color:#174032;font-weight:700;font-family:'Cairo',sans-serif;padding:0.7rem 2.1rem;font-size:1.07rem;min-width:140px;">تحديث الموقع</button>
                <a href="{{ route('locations.index') }}" class="btn btn-secondary" style="border-radius:8px;background:#174032;color:#fff;font-family:'Cairo',sans-serif;padding:0.7rem 2.1rem;font-size:1.07rem;min-width:140px;">إلغاء</a>
            </div>
        </form>
    </div>
</div>
<style>
    .locations-page-container { font-family: 'Cairo', sans-serif; }
    .locations-table-card input.form-control:focus {
        border-color: #174032;
        box-shadow: 0 0 0 2px #d4af37;
        outline: none;
    }
    .locations-table-card .btn-danger.remove-field {
        background: #e74c3c;
        border: none;
        color: #fff;
        font-weight: 600;
        transition: background 0.18s;
    }
    .locations-table-card .btn-danger.remove-field:hover {
        background: #b92d1f;
    }
    .locations-table-card .btn-secondary#add-detail {
        background: #174032;
        color: #fff;
        font-weight: 700;
        border: none;
        margin-top: 0.5rem;
        transition: background 0.18s;
    }
    .locations-table-card .btn-secondary#add-detail:hover {
        background: #254D32;
    }
</style>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const detailsFields = document.getElementById('details-fields');
    const addDetailBtn = document.getElementById('add-detail');
    const form = document.getElementById('location-form');
    const detailsJsonInput = document.getElementById('details-json');

    addDetailBtn.addEventListener('click', function() {
        const div = document.createElement('div');
        div.className = 'input-group mb-2';
        div.innerHTML = `<input type=\"text\" class=\"form-control\" name=\"details_field[]\" placeholder=\"أدخل تفاصيل...\" style=\"border-radius:8px;border:1.5px solid #d4af37;font-family:'Cairo',sans-serif;\">\n            <button type=\"button\" class=\"btn btn-danger remove-field\" style=\"border-radius:8px;\">حذف</button>`;
        detailsFields.appendChild(div);
    });

    detailsFields.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-field')) {
            e.target.parentElement.remove();
        }
    });

    form.addEventListener('submit', function(e) {
        const fields = detailsFields.querySelectorAll('input[name="details_field[]"]');
        const details = {};
        let i = 1;
        fields.forEach(f => {
            if (f.value.trim() !== '') {
                details[i++] = f.value.trim();
            }
        });
        detailsJsonInput.value = Object.keys(details).length ? JSON.stringify(details) : '';
        console.log('Details to be saved:', details);
        console.log('Serialized JSON:', detailsJsonInput.value);
    });
});
</script>
@endsection 