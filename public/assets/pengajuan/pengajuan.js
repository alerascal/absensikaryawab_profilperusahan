document.addEventListener('DOMContentLoaded', () => {
    // File Preview for Surat Dokter
    const suratDokterInput = document.getElementById('surat_dokter');
    if (suratDokterInput) {
        suratDokterInput.addEventListener('change', (e) => {
            const file = e.target.files[0];
            if (file) {
                const preview = document.createElement('p');
                preview.className = 'file-preview';
                preview.textContent = `Selected: ${file.name}`;
                suratDokterInput.parentNode.appendChild(preview);
            }
        });
    }

    // File Preview for Surat Izin
    const suratIzinInput = document.getElementById('surat_izin');
    if (suratIzinInput) {
        suratIzinInput.addEventListener('change', (e) => {
            const file = e.target.files[0];
            if (file) {
                const preview = document.createElement('p');
                preview.className = 'file-preview';
                preview.textContent = `Selected: ${file.name}`;
                suratIzinInput.parentNode.appendChild(preview);
            }
        });
    }

    // Confirm Delete
    const deleteForms = document.querySelectorAll('.delete-form');
    deleteForms.forEach(form => {
        form.addEventListener('submit', (e) => {
            if (!confirm('Yakin ingin menghapus pengajuan ini?')) {
                e.preventDefault();
            }
        });
    });
});