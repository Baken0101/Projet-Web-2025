// resources/js/teachers.js

/**
 * Teachers CRUD in modals:
 * - update via AJAX
 * - delete via normal form submit
 */
document.addEventListener('DOMContentLoaded', () => {
    // EDIT buttons
    document.querySelectorAll('.teacher-edit-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            const id    = btn.dataset.id;
            const form  = document.getElementById(`teacher-edit-form-${id}`);
            const first = document.getElementById(`teacher-edit-first-${id}`).value;
            const last  = document.getElementById(`teacher-edit-last-${id}`).value;
            const mail  = document.getElementById(`teacher-edit-email-${id}`).value;

            fetch(form.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept':       'application/json',
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ first_name: first, last_name: last, email: mail }),
            })
                .then(r => r.json())
                .then(() => window.location.reload())
                .catch(console.error);
        });
    });

    // DELETE uses a normal <form method="POST">@method('DELETE')</form>
});
