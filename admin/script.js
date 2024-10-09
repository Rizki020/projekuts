$(document).ready(function () {
    // Toggle Sidebar
    $("#menu-toggle").click(function (e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });

    // Script untuk memilih semua checkbox di halaman dashboard.php
    $("#select-all").click(function (event) {
        let checkboxes = $('input[type="checkbox"][name="selected_ids[]"]');
        checkboxes.prop('checked', this.checked);
    });

    // Konfirmasi Logout
    $(".btn-logout").click(function (e) {
        e.preventDefault();
        var result = confirm("Apakah Anda yakin ingin keluar?");
        if (result) {
            window.location.href = $(this).attr("href");
        }
    });

    //Pilih semua Cekbox
    document.getElementById('select-all').addEventListener('change', function () {
        const checkboxes = document.querySelectorAll('input[name="selected_ids[]"]');
        checkboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
    });

    

});
