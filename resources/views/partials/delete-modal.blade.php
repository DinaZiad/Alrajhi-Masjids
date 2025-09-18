<div class="modal fade" id="deleteEntityModal" tabindex="-1" aria-labelledby="deleteEntityModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header" style="background:linear-gradient(135deg,#174032 0%,#14532d 100%);color:#d4af37;">
        <h5 class="modal-title" id="deleteEntityModalLabel"><i class="fas fa-exclamation-triangle"></i> تأكيد حذف {{ $entityType ?? 'العنصر' }}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="إغلاق"></button>
      </div>
      <div class="modal-body" style="font-family:'Cairo',sans-serif;">
        <p>هل أنت متأكد أنك تريد حذف {{ $entityType ?? 'العنصر' }} التالي؟</p>
        <div id="entityNameToDelete" style="font-weight:900;color:#174032;font-size:1.2rem;"></div>
        <p class="text-danger mt-2 mb-0"><i class="fas fa-info-circle"></i> لا يمكن التراجع عن هذا الإجراء.</p>
      </div>
      <div class="modal-footer" style="display: flex; flex-direction: row; gap: 0.5rem; align-items: center; justify-content: flex-end; direction: rtl;">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
        <button type="button" class="btn btn-danger" id="confirmDeleteEntityBtn"><i class="fas fa-trash-alt"></i> حذف</button>
      </div>
    </div>
  </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    let formToDelete = null;
    const modal = new bootstrap.Modal(document.getElementById('deleteEntityModal'));
    const entityNameElem = document.getElementById('entityNameToDelete');
    document.querySelectorAll('.delete-entity-btn').forEach(function(btn) {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            formToDelete = btn.closest('form');
            const entityName = formToDelete.getAttribute('data-entity-name');
            entityNameElem.textContent = entityName;
            modal.show();
        });
    });
    document.getElementById('confirmDeleteEntityBtn').addEventListener('click', function() {
        if (formToDelete) {
            formToDelete.submit();
        }
        modal.hide();
    });
});
</script> 