document.addEventListener('DOMContentLoaded', () => {
    const messages = document.querySelectorAll('.message-popup');
    messages.forEach(message => {
        setTimeout(() => {
            message.classList.add('fade-out');
            setTimeout(() => message.remove(), 500); // Remove after fade-out
        }, 3000);
    });

    const editModal = document.getElementById('editModal');
    editModal.addEventListener('show.bs.modal', event => {
        const button = event.relatedTarget;
        document.getElementById('edit-subid').value = button.getAttribute('data-subid');
        document.getElementById('edit-name').value = button.getAttribute('data-name');
        document.getElementById('edit-code').value = button.getAttribute('data-code');
        document.getElementById('edit-semester').value = button.getAttribute('data-semester');
        document.getElementById('edit-credit').value = button.getAttribute('data-credit');
        document.getElementById('edit-total_hour').value = button.getAttribute('data-total_hour');
    });
});

