CREATE TABLE CALONMAHASISWA (
    id INT(11) PRIMARY KEY,
    gambar VARCHAR(255),
    nama VARCHAR(100) NOT NULL,
    tempat_lahir VARCHAR(100) NOT NULL,
    tanggal_lahir DATE,
    alamat TEXT,
    asal_sma VARCHAR(100) NOT NULL,
    jenis_kelamin ENUM('laki-laki', 'perempuan') NOT NULL,
    tahun_tamat INT NOT NULL,
    PASSWORD VARCHAR(100) NOT NULL,
    nama_orangtua VARCHAR(100) NOT NULL,
    jurusan ENUM('Teknik Komputer dan Informatika', 'Administrasi Bisnis', 'Teknik Sipil', 'Teknik Mesin') NOT NULL,
    program_studi ENUM('Teknik Komputer', 'Teknik sipil', 'Administrasi Bisnis', 'Teknik Mesin') NOT NULL,
    status ENUM('Lulus', 'TidakLulus', 'Belum Ditentukan') NOT NULL DEFAULT 'Belum Ditentukan'
);

INSERT INTO CALONMAHASISWA (id, gambar, nama, tempat_lahir, tanggal_lahir, asal_sma, alamat, jenis_kelamin, tahun_tamat, PASSWORD, nama_orangtua, jurusan, program_studi, status) 
VALUES
('2024001', 'images/Agnes.jpg', 'Agnes', 'Yogyakarta', '2004-04-20', 'SMA Negeri 2 Yogyakarta', 'Gg. KH. Zamhari 86-15, Ngupasan, Kec. Gondomanan', 'perempuan', 2022, '1234', 'Sri Wahyuni', 'Administrasi Bisnis', 'Administrasi Bisnis', 'Belum Ditentukan'),
('2024002', 'images/Centis.jpg', 'Centis', 'Banten', '2005-02-08', 'SMA Negeri 4 Kota Serang', 'Sumurpecung, Kec. Serang, Kota Serang', 'perempuan', 2022, '1234', 'Budiono', 'Teknik Komputer dan Informatika', 'Teknik Komputer', 'Belum Ditentukan'),
('2024003', 'images/Ina.jpg', 'Ina', 'Jakarta Barat', '2004-03-05', 'SMK Negeri 11 Jakarta', 'Jl. Kp. Kalimati No.5 12, RT.12/RW.3, Kedun Kaliang', 'perempuan', 2022, '1234', 'Muliono', 'Administrasi Bisnis', 'Administrasi Bisnis', 'Belum Ditentukan'),
('2024004', 'images/Iqbal.jpg', 'Iqbal', 'Padang', '2004-09-11', 'SMKN 6 Kota Padang', 'Jl. Angkasa Puri I 8, Dadok Tunggu Hitam, Kec. Kota', 'laki-laki', 2022, '1234', 'Asep', 'Teknik Sipil', 'Teknik sipil', 'Belum Ditentukan');

CREATE TABLE ADMIN (
    ID_ADMIN INT AUTO_INCREMENT PRIMARY KEY,
    NAMA VARCHAR(13),
    USERNAME VARCHAR(50),
    PASSWORD VARCHAR(100)
);

INSERT INTO ADMIN (NAMA, USERNAME, PASSWORD) VALUES
('Rizki', 'Admin', '1zxa54');