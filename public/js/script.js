document.addEventListener('DOMContentLoaded', function() {
    // Fungsi untuk menambah animasi ke card (jika digunakan)
    const cards = document.querySelectorAll('.card');
    cards.forEach((card, index) => {
        card.style.opacity = 0;
        card.style.transform = 'translateY(20px)';
        setTimeout(() => {
            card.style.transition = 'opacity 0.6s ease-out, transform 0.6s ease-out';
            card.style.opacity = 1;
            card.style.transform = 'translateY(0)';
        }, 100 * index);
    });

    // Fungsi konfirmasi submit form
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function(event) {
            if (this.classList.contains('confirm-submit')) {
                const confirmation = confirm('Apakah Anda yakin ingin mengirim form ini?');
                if (!confirmation) {
                    event.preventDefault();
                }
            }
        });
    });

    // Fungsi pencarian/filter tabel
    const searchInput = document.getElementById('searchInput');
    if (searchInput) {
        searchInput.addEventListener('keyup', function() {
            const filter = this.value.toLowerCase();
            const tableRows = document.querySelectorAll('.table tbody tr');
            tableRows.forEach(row => {
                const text = row.textContent.toLowerCase();
                if (text.includes(filter)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    }

    // Inisialisasi Tooltips (memerlukan Bootstrap JS bundle)
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});