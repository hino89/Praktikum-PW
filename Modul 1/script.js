// Menunggu sampai semua HTML selesai dimuat
document.addEventListener('DOMContentLoaded', () => {

    const themeToggleBtn = document.getElementById('theme-toggle');

    // Cek jika user SUDAH pernah memilih tema (simpan di localStorage)
    const currentTheme = localStorage.getItem('theme');
    if (currentTheme === 'light') {
        document.body.classList.add('light-mode');
        themeToggleBtn.innerText = "SWITCH TO DARK MODE";
    }

    // Tambahkan event listener ke tombol
    themeToggleBtn.addEventListener('click', () => {
        // Toggle class 'light-mode' di <body>
        document.body.classList.toggle('light-mode');

        // Cek apakah light-mode sekarang aktif?
        if (document.body.classList.contains('light-mode')) {
            // JIKA IYA: Ganti teks tombol & simpan pilihan
            themeToggleBtn.innerText = "SWITCH TO DARK MODE";
            localStorage.setItem('theme', 'light');
        } else {
            // JIKA TIDAK: Ganti teks tombol & simpan pilihan
            themeToggleBtn.innerText = "SWITCH TO LIGHT MODE";
            localStorage.setItem('theme', 'dark');
        }
    });
});