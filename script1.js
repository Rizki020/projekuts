// Kode untuk sidebar
const sidebarToggle = document.getElementById("sidebarToggle");
const mySidebar = document.getElementById("mySidebar");
const main = document.getElementById("main");
let sidebarOpen = false; // Menandakan status sidebar

sidebarToggle.addEventListener("click", toggleNav);

function toggleNav() {
    sidebarOpen = !sidebarOpen; // Toggle status sidebar
    mySidebar.style.left = sidebarOpen ? "0" : "-250px"; // Tampilkan atau sembunyikan sidebar
    main.style.marginLeft = sidebarOpen ? "250px" : "0"; // Geser konten utama
    document.querySelector(".navbar").style.marginLeft = sidebarOpen ? "250px" : "0"; // Geser navbar
    sidebarToggle.innerHTML = sidebarOpen ? "&times;" : "☰"; // Ubah ikon tombol
}

// Kode untuk kamera
$(document).ready(function() {
    const startCameraButton = document.getElementById('startCameraButton');
    const cameraContainer = document.getElementById('cameraContainer');
    const video = document.getElementById('video');
    const canvas = document.getElementById('canvas');
    const snapButton = document.getElementById('snap');
    const takenImage = document.getElementById('takenImage');
    const removeImageButton = document.getElementById('removeImage');
    const gambarInput = document.getElementById('gambarInput');

    let stream;

    // Memulai kamera saat tombol di klik
    startCameraButton.addEventListener('click', async () => {
        try {
            stream = await navigator.mediaDevices.getUserMedia({ video: true });
            video.srcObject = stream;
            cameraContainer.style.display = 'block';
        } catch (error) {
            alert('Kamera tidak dapat diakses: ' + error.message);
        }
    });

    // Mengambil gambar dari video
    snapButton.addEventListener('click', () => {
        const context = canvas.getContext('2d');
        context.drawImage(video, 0, 0, canvas.width, canvas.height);
        const data = canvas.toDataURL('image/jpeg');
        takenImage.src = data;
        takenImage.style.display = 'block'; // Tampilkan gambar yang diambil
        gambarInput.value = data; // Simpan data gambar ke input tersembunyi
        removeImageButton.style.display = 'inline'; // Tampilkan tombol hapus
        stopVideo(); // Hentikan video setelah gambar diambil
    });

    // Hentikan video
    function stopVideo() {
        if (stream) {
            stream.getTracks().forEach(track => track.stop());
            video.srcObject = null; // Matikan video dari elemen video
        }
    }

    // Tombol untuk menghapus gambar
    removeImageButton.addEventListener('click', () => {
        takenImage.style.display = 'none';
        gambarInput.value = ''; // Hapus input gambar
        removeImageButton.style.display = 'none'; // Sembunyikan tombol hapus
        video.style.display = 'block'; // Tampilkan video kembali
        startCameraButton.style.display = 'inline'; // Tampilkan tombol ambil foto
        stopVideo(); // Hentikan video jika gambar dihapus
    });

    // Mengupload gambar dari file
    document.getElementById('uploadImage').addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                takenImage.src = e.target.result;
                takenImage.style.display = 'block'; // Tampilkan gambar yang di-upload
                gambarInput.value = e.target.result; // Simpan data gambar ke input tersembunyi
                removeImageButton.style.display = 'inline'; // Tampilkan tombol hapus
            }
            reader.readAsDataURL(file); // Bacalah file sebagai URL data
        }
    });

    // Fungsi untuk memvalidasi gambar sebelum mengirim form
    window.validateForm = function() {
        const gambarInputValue = gambarInput.value;
        const uploadInput = document.getElementById('uploadImage').files.length;

        if (!gambarInputValue && uploadInput === 0) {
            alert('Harap ambil foto atau unggah gambar!');
            return false;
        }
        return true;
    }
});
        // Konfirmasi logout
        $(document).ready(function() {
            $(".btn-logout").click(function (e) {
                e.preventDefault();  // Mencegah aksi default dari tombol logout
                var result = confirm("Apakah Anda yakin ingin keluar?");
                if (result) {
                    window.location.href = $(this).attr("href");  // Redirect ke URL logout
                }
            });
            console.log("script1.js loaded successfully.");
        });

