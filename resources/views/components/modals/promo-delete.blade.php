{{-- resources/views/modals/promo-delete.blade.php --}}
<div class="modal fade" id="promoDeleteModal" tabindex="-1">
    <div class="modal-dialog">
        <form method="POST" action="" id="promo-delete-form">
            @csrf @method('DELETE')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Supprimer la promotion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Êtes‑vous sûr de vouloir supprimer <strong id="promo-delete-name"></strong> ?</p>
                </div>
                <div class="modal-footer">
                    <x-ui.button color="default" size="sm" data-bs-dismiss="modal">Annuler</x-ui.button>
                    <x-ui.button color="danger" size="sm" type="submit">Supprimer</x-ui.button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('.promo-delete-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                const id   = btn.dataset.id;
                const name = btn.dataset.name;
                document.getElementById('promo-delete-name').textContent = name;
                document.getElementById('promo-delete-form').action      = `/cohort/${id}`;
            });
        });
    });
</script>
