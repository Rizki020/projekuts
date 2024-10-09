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
    nama_orangtua VARCHAR(100) NOT NULL,
    jurusan ENUM('Teknik Komputer dan Informatika', 'Administrasi Bisnis', 'Teknik Sipil', 'Teknik Mesin') NOT NULL,
    program_studi ENUM('Teknik Komputer', 'Teknik sipil', 'Administrasi Bisnis', 'Teknik Mesin') NOT NULL,
    status ENUM('Lulus', 'TidakLulus', 'Belum Ditentukan') NOT NULL DEFAULT 'Belum Ditentukan'
);


INSERT INTO CALONMAHASISWA (id, gambar, nama, tempat_lahir, tanggal_lahir, asal_sma, alamat, jenis_kelamin, tahun_tamat, nama_orangtua, jurusan, program_studi, status) 
VALUES
('2024001', 'images/Aashiyana.jpg', 'Ashiyana', 'Nagpur', '2004-05-09', 'Shree Swaminarayan Gurukul International School', 'Rambagh, Nagpur', 'perempuan', 2021, 'Zayaan', 'Administrasi Bisnis', 'Administrasi Bisnis', 'Belum Ditentukan'),
('2024002', 'images/Agnes.jpg', 'Agnes', 'Yogyakarta', '2004-04-20', 'SMA Negeri 2 Yogyakarta', 'Gg. KH. Zamhari 86-15, Ngupasan, Kec. Gondomanan', 'perempuan', 2022, 'Sri Wahyuni', 'Administrasi Bisnis', 'Administrasi Bisnis', 'Belum Ditentukan'),
('2024003', 'images/Centis.jpg', 'Centis', 'Banten', '2005-02-08', 'SMA Negeri 4 Kota Serang', 'Sumurpecung, Kec. Serang, Kota Serang', 'perempuan', 2022, 'Budiono', 'Teknik Komputer dan Informatika', 'Teknik Komputer', 'Belum Ditentukan'),
('2024004', 'images/Hotaka.jpg', 'Hotaka', 'Okawa', '2003-03-04', 'Meikei High School', 'T018-1734 Akita, Minamiakita District, Gojome', 'laki-laki', 2022, 'Oka-san', 'Teknik Komputer dan Informatika', 'Teknik Komputer', 'Belum Ditentukan'),
('2024005', 'images/Ina.jpg', 'Ina', 'Jakarta Barat', '2004-03-05', 'SMK Negeri 11 Jakarta', 'Jl. Kp. Kalimati No.5 12, RT.12/RW.3, Kedun Kaliang', 'perempuan', 2022, 'Muliono', 'Administrasi Bisnis', 'Administrasi Bisnis', 'Belum Ditentukan'),
('2024006', 'images/Iqbal.jpg', 'Iqbal', 'Padang', '2004-09-11', 'SMKN 6 Kota Padang', 'Jl. Angkasa Puri I 8, Dadok Tunggu Hitam, Kec. Kota', 'laki-laki', 2022, 'Asep', 'Teknik Sipil', 'Teknik sipil', 'Belum Ditentukan'),
('2024007', 'images/Joseph.jpg', 'Joseph', 'Johor', '2004-11-09', 'SK Komplek UDA, Johor Bahr', 'Jalan Beruas, Taman Gunung Lambak, 86000 Kluang', 'laki-laki', 2022, 'Riza', 'Teknik Komputer dan Informatika', 'Teknik Komputer', 'Belum Ditentukan'),
('2024008', 'images/Lamez.jpg', 'Lamez', 'Jakarta Timur', '2002-03-18', 'SMA Negeri 12 Jakarta', 'Jl. Pahlawan Revolusi Blok Langgar No.10', 'laki-laki', 2022, 'Jisane', 'Teknik Sipil', 'Teknik sipil', 'Belum Ditentukan'),
('2024009', 'images/Robert.jpg', 'Robert', 'Jambi', '2004-08-18', 'SMKN 3 Batang Hari', 'Kelurahan Muara Tebo, Kec. Tebo Tengah', 'laki-laki', 2022, 'Jujuk', 'Teknik Mesin', 'Teknik Mesin', 'Belum Ditentukan'),
('2024010', 'images/Zubaidah.jpg', 'Zubaidah', 'Medan', '2003-10-19', 'SMA SWASTA YAPIM SEI GLUGUR', 'Lorong Kelompok Kamboja V 27-11, Glugur Kota', 'perempuan', 2022, 'Mulyono Asep', 'Administrasi Bisnis', 'Administrasi Bisnis', 'Belum Ditentukan');


CREATE TABLE ADMIN (
    ID_ADMIN INT AUTO_INCREMENT PRIMARY KEY,
    NAMA VARCHAR(13),
    USERNAME VARCHAR(50),
    PASSWORD VARCHAR(100)
);

INSERT INTO ADMIN (NAMA, USERNAME, PASSWORD) VALUES
('Rizki', 'Admin', '1zxa54');