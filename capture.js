// Script untuk mengambil gambar dengan webcam

const startCameraButton = document.getElementById('startCameraButton');
const video = document.getElementById('video');
const canvas = document.getElementById('canvas');
const takenImage = document.getElementById('takenImage');
const gambarInput = document.getElementById('gambarInput');
const removeImageButton = document.getElementById('removeImage');
const cameraContainer = document.getElementById('cameraContainer');

let stream;

// Memulai kamera saat tombol di klik
startCameraButton.addEventListener('click', async () => {
    // Minta izin untuk menggunakan webcam
    try {
        stream = await navigator.mediaDevices.getUserMedia({ video: true });
        video.srcObject = stream;
        cameraContainer.style.display = 'block';
    } catch (error) {
        alert('Kamera tidak dapat diakses: ' + error.message);
    }
});

// Mengambil gambar dari video
document.getElementById('snap').addEventListener('click', () => {
    const context = canvas.getContext('2d');
    context.drawImage(video, 0, 0, canvas.width, canvas.height);
    const data = canvas.toDataURL('image/jpeg');
    takenImage.src = data;
    takenImage.style.display = 'block'; // Tampilkan gambar yang diambil
    gambarInput.value = data; // Simpan data gambar ke input tersembunyi
    removeImageButton.style.display = 'inline'; // Tampilkan tombol hapus

    // Hentikan video setelah gambar diambil
    stopVideo();
});

// Menghentikan video
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

// Fungsi untuk memvalidasi gambar sebelum mengirim form
function validateForm() {
    const gambarInputValue = gambarInput.value;
    const uploadInput = document.getElementById('uploadImage').files.length;

    if (!gambarInputValue && uploadInput === 0) {
        alert('Harap ambil foto atau unggah gambar!');
        return false;
    }
    return true;
}

// Mengatur validasi form saat submit
document.querySelector('form').addEventListener('submit', (event) => {
    if (!validateForm()) {
        event.preventDefault(); // Mencegah form terkirim jika validasi gagal
    }
});
