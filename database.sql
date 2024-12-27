USE
    master;
GO

IF
    DB_ID('sistem_tata_tertib_test_exe') IS NOT NULL
    DROP
        DATABASE sistem_tata_tertib_test_exe;

IF
    @@ERROR = 3702
    RAISERROR ('Database cannot be dropped because there are still open connections.', 127, 127) WITH NOWAIT, LOG;

CREATE
    DATABASE sistem_tata_tertib_test_exe;
GO

USE sistem_tata_tertib_test_exe;
GO

CREATE SCHEMA Core AUTHORIZATION dbo;
GO
CREATE SCHEMA Admin AUTHORIZATION dbo;
GO
CREATE SCHEMA Rules AUTHORIZATION dbo;
GO

CREATE TABLE Admin.Users
(
    user_id       INT           NOT NULL IDENTITY,
    username      NVARCHAR(50)  NOT NULL UNIQUE,
    password_hash NVARCHAR(255) NOT NULL,
    level         VARCHAR(10)   NOT NULL,
    CONSTRAINT PK_Users PRIMARY KEY (user_id),
    CONSTRAINT CHK_Level CHECK (level IN ('admin', 'dosen', 'mahasiswa'))
);

INSERT INTO Admin.Users (username, password_hash, level)
VALUES ('admin', 'admin', 'admin');

CREATE TABLE Core.Prodi
(
    prodi_id INT          NOT NULL IDENTITY,
    prodi    NVARCHAR(50) NOT NULL UNIQUE,
    CONSTRAINT PK_Prodi PRIMARY KEY (prodi_id)
);

INSERT INTO Core.Prodi (prodi)
VALUES ('D4 Teknik Informatika'),
       ('D4 Sistem Informasi Bisnis');

CREATE TABLE Core.Dosen
(
    nip          BIGINT        NOT NULL UNIQUE,
    nama_lengkap NVARCHAR(100) NOT NULL,
    no_telepon   NVARCHAR(15)  NOT NULL,
    email        NVARCHAR(100) NOT NULL,
    dpa          BIT           NOT NULL DEFAULT 0,
    CONSTRAINT PK_Dosen PRIMARY KEY (nip)
);

IF OBJECT_ID('trg_InsertUserAfterDosen', 'TR') IS NOT NULL
    DROP TRIGGER trg_InsertUserAfterDosen;
GO
CREATE TRIGGER trg_InsertUserAfterDosen
    ON Core.Dosen
    AFTER INSERT
    AS
BEGIN
    INSERT INTO Admin.Users (username, password_hash, level)
    SELECT CAST(i.nip AS NVARCHAR(50)), CAST(i.nip AS NVARCHAR(255)), 'dosen'
    FROM inserted i;
END;
GO

INSERT INTO Core.Dosen (nip, nama_lengkap, no_telepon, email, dpa)
VALUES (298110052002051001, 'Ahmadi Yuli Ananta, ST., MM.', '081234567890', 'ahmadi@polinema.ac.id', 1),
       (298102102005011002, 'Ariadi Retno Tri Hayati Ririd, S.Kom., M.Kom', '081234567891',
        'ariadi.retno@polinema.ac.id', 1),
       (297903312008211002, 'Arief Prasetyo, S.Kom', '081234567892', 'arief.prasetyo@polinema.ac.id', 1),
       (297606152005021001, 'Atiqah Nurul Asri, S.Pd., M.Pd', '081234567893', 'atiqah.nurul@polinema.ac.id', 1),
       (298108292010121002, 'Banni Satria Andoko, S.Kom., M.Si', '081234567894', 'ando@polinema.ac.id', 1),
       (296201511990031002, 'Budi Harijanto, ST., MMkom', '081234567895', 'budi.harijanto@polinema.ac.id', 1),
       (297202222005011002, 'Cahya Rahmad, ST., M.Kom., Dr. Eng', '081234567896', 'cahya.rahmad@polinema.ac.id', 1),
       (296211281988211001, 'Deddy Kusbianto Purwoko Aji, Ir., M.MKom', '081234567897',
        'deddy_kusbianto@polinema.ac.id', 1),
       (298311092014142001, 'Dhebys Suryani H, S.Kom., MT', '081234567898', 'example@polinema.ac.id', 1),
       (297911552005012022, 'Dwi Puspitasari, S.Kom., M.Kom', '081234567899', 'dwi.puspitasari@polinema.ac.id', 1);

CREATE TABLE Core.Kelas
(
    kelas_id INT IDENTITY PRIMARY KEY,
    kelas    CHAR(2) NOT NULL UNIQUE,
    nip      BIGINT  NOT NULL,
    CONSTRAINT FK_Kelas_Dosen FOREIGN KEY (nip)
        REFERENCES Core.Dosen (nip)
);

INSERT INTO Core.Kelas (kelas, nip)
VALUES ('2A', 298110052002051001),
       ('2B', 298102102005011002),
       ('2C', 297903312008211002),
       ('2D', 297606152005021001),
       ('2E', 298108292010121002),
       ('2F', 296201511990031002),
       ('2G', 297202222005011002),
       ('2H', 296211281988211001),
       ('2I', 298311092014142001),
       ('2J', 297911552005012022);

CREATE TABLE Core.Mahasiswa
(
    nim          BIGINT        NOT NULL UNIQUE,
    nama_lengkap NVARCHAR(100) NOT NULL,
    no_telepon   NVARCHAR(15)  NULL,
    email        NVARCHAR(100) NULL,
    prodi_id     INT           NOT NULL,
    kelas_id     INT           NOT NULL,
    CONSTRAINT PK_Mahasiswa PRIMARY KEY (nim),
    CONSTRAINT FK_Mahasiswa_Prodi FOREIGN KEY (prodi_id)
        REFERENCES Core.Prodi (prodi_id),
    CONSTRAINT FK_Mahasiswa_Kelas FOREIGN KEY (kelas_id)
        REFERENCES Core.Kelas (kelas_id)
);

IF OBJECT_ID('trg_InsertUserAfterMahasiswa', 'TR') IS NOT NULL
    DROP TRIGGER trg_InsertUserAfterMahasiswa;
GO
CREATE TRIGGER trg_InsertUserAfterMahasiswa
    ON Core.Mahasiswa
    AFTER INSERT
    AS
BEGIN
    INSERT INTO Admin.Users (username, password_hash, level)
    SELECT CAST(i.nim AS NVARCHAR(50)), CAST(i.nim AS NVARCHAR(255)), 'mahasiswa'
    FROM inserted i;
END;
GO

-- Data Mahasiswa kelas 2A
INSERT INTO Core.Mahasiswa (nim, nama_lengkap, no_telepon, email, prodi_id, kelas_id)
VALUES (2341720721, 'ACHMAD MAULANA HAMZAH', '081234567890', 'achmad.2341720721@polinema.ac.id', 1, 1),
       (2341720823, 'ALVANZA SAPUTRA YUDHA', '081234567891', 'alvanza.2341720823@polinema.ac.id', 1, 1),
       (2341720324, 'ANYA CALLISSTA CHRISWANTARI', '081234567892', 'anya.2341720324@polinema.ac.id', 1, 1),
       (2341720526, 'BERYL FUNKY MUBAROK', '081234567893', 'beryl.2341720526@polinema.ac.id', 1, 1),
       (2341720817, 'CANDRA AHMAD DANI', '081234567894', 'candra.2341720817@polinema.ac.id', 1, 1),
       (2341720138, 'CINDY LAILI LARASATI', '081234567895', 'cindy.2341720138@polinema.ac.id', 1, 1),
       (2341720732, 'DIKA ARIE ARRIFKY', '081234567896', 'dika.2341720732@polinema.ac.id', 1, 1),
       (2341720928, 'FAHMI YAHYA', '081234567897', 'fahmi.2341720928@polinema.ac.id', 1, 1),
       (2341720432, 'GILANG PURNOMO', '081234567898', 'gilang.2341720432@polinema.ac.id', 1, 1),
       (2341720123, 'GWIDO PUTRA WIJAYA', '081234567899', 'gwido.2341720123@polinema.ac.id', 1, 1),
       (2341720517, 'HIDAYAT WIDI SAPUTRA', '081234567900', 'hidayat.2341720517@polinema.ac.id', 1, 1),
       (2441070112, 'ILHAM FATURACHMAN', '081234567901', 'ilham.2441070112@polinema.ac.id', 1, 1),
       (2341720835, 'INNAMA MAESA PUTRI', '081234567902', 'innama.2341720835@polinema.ac.id', 1, 1),
       (2341720431, 'JIHA RAMDHAN', '081234567903', 'jiha.2341720431@polinema.ac.id', 1, 1),
       (2341720125, 'LELYTA MEYDA AYU BUDIYANTI', '081234567904', 'lelyta.2341720125@polinema.ac.id', 1, 1),
       (2341720814, 'M. FATIH AL GHIFARY', '081234567905', 'fatih.2341720914@polinema.ac.id', 1, 1),
       (2341720939, 'M. FIRMANSYAH', '081234567906', 'firmansyah.2341720939@polinema.ac.id', 1, 1),
       (2341720424, 'MOCH. ALFIN BURHANUDIN ALQODRI', '081234567907', 'alfin.2341720424@polinema.ac.id', 1, 1),
       (2341720311, 'MUHAMAD SYAIFULLAH', '081234567908', 'muhamad.2341720311@polinema.ac.id', 1, 1),
       (2341720937, 'MUHAMMAD NUR AZIZ', '081234567909', 'nuraziz.2341720937@polinema.ac.id', 1, 1),
       (2341720320, 'NAJWA ALYA NURIZZAH', '081234567910', 'najwa.2341720320@polinema.ac.id', 1, 1),
       (2341720716, 'NECHA SYIFA SYAFITRI', '081234567911', 'necha.2341720716@polinema.ac.id', 1, 1),
       (2341720824, 'NOKLENT FARDIAN ERIX', '081234567912', 'noklent.2341720824@polinema.ac.id', 1, 1),
       (2341720758, 'OCTRIAN ADILUHUNG TITO PUTRA', '081234567913', 'octrian.2341720758@polinema.ac.id', 1, 1),
       (2341720613, 'SATRIO AHMAD RAMADHANI', '081234567914', 'satrio.2341720613@polinema.ac.id', 1, 1),
       (2341720329, 'SESY TANA LINA RAHMATIN', '081234567915', 'sesy.2341720329@polinema.ac.id', 1, 1),
       (2341720621, 'TAUFIK DIMAS EDYSTARA', '081234567916', 'taufik.2341720621@polinema.ac.id', 1, 1),
       (2341720914, 'VINCENTIUS LEONANDA PRABOWO', '081234567917', 'vincentius.2341720914@polinema.ac.id', 1, 1),
       (2341720330, 'YANUAR RIZKI AMINUDIN', '081234567918', 'yanuar.2341720330@polinema.ac.id', 1, 1);


-- Data Mahasiswa kelas 2B
INSERT INTO Core.Mahasiswa (nim, nama_lengkap, no_telepon, email, prodi_id, kelas_id)
VALUES (2341722001, 'Alya Putri Salsabila', '081234567801', '2341722001@example.com', 1, 2),
       (2341722002, 'Bayu Pratama Wijaya', '081234567802', '2341722002@example.com', 1, 2),
       (2341722003, 'Citra Ayu Lestari', '081234567803', '2341722003@example.com', 1, 2),
       (2341722004, 'Dimas Fadilah Kusuma', '081234567804', '2341722004@example.com', 1, 2),
       (2341722005, 'Eka Nur Fitriani', '081234567805', '2341722005@example.com', 1, 2),
       (2341722006, 'Fahmi Rizky Pratama', '081234567806', '2341722006@example.com', 1, 2),
       (2341722007, 'Gita Wulandari Kusuma', '081234567807', '2341722007@example.com', 1, 2),
       (2341722008, 'Hendra Saputra Ramadhan', '081234567808', '2341722008@example.com', 1, 2),
       (2341722009, 'Indah Permatasari', '081234567809', '2341722009@example.com', 1, 2),
       (2341722010, 'Joko Budi Santoso', '081234567810', '2341722010@example.com', 1, 2),
       (2341722011, 'Kiki Amelia Sari', '081234567811', '2341722011@example.com', 1, 2),
       (2341722012, 'Lukman Hakim Prasetyo', '081234567812', '2341722012@example.com', 1, 2),
       (2341722013, 'Melati Ayu Saputri', '081234567813', '2341722013@example.com', 1, 2),
       (2341722014, 'Nanda Fitri Ramadhani', '081234567814', '2341722014@example.com', 1, 2),
       (2341722015, 'Olivia Kartika Putri', '081234567815', '2341722015@example.com', 1, 2),
       (2341722016, 'Prasetyo Wibowo Nugroho', '081234567816', '2341722016@example.com', 1, 2),
       (2341722017, 'Qonita Zahra Syafitri', '081234567817', '2341722017@example.com', 1, 2),
       (2341722018, 'Rizky Anggara Putra', '081234567818', '2341722018@example.com', 1, 2),
       (2341722019, 'Siti Nur Halimah', '081234567819', '2341722019@example.com', 1, 2),
       (2341722020, 'Taufik Dimas Pratama', '081234567820', '2341722020@example.com', 1, 2);

CREATE TABLE Admin.Session
(
    session_token VARCHAR(255) NOT NULL UNIQUE,
    username      NVARCHAR(50) NOT NULL,
    CONSTRAINT PK_Session PRIMARY KEY (session_token),
    CONSTRAINT FK_Session_Users FOREIGN KEY (username)
        REFERENCES Admin.Users (username)
);

CREATE TABLE Rules.SanksiPelanggaran
(
    sanksi_pelanggaran_id INT           NOT NULL IDENTITY,
    tingkat               TINYINT       NOT NULL CHECK (tingkat BETWEEN 1 AND 5),
    sanksi                NVARCHAR(MAX) NOT NULL,
    CONSTRAINT PK_SanksiPelanggaran PRIMARY KEY (sanksi_pelanggaran_id)
)

-- sanksi
INSERT INTO Rules.SanksiPelanggaran (tingkat, sanksi)
VALUES (1, 'Dinonaktifkan (Cuti Akademik/ Terminal) selama dua semester'),
       (2, 'Diberikan nilai D pada mata kuliah terkait saat melakukan pelanggaran'),
       (3,
        'Melakukan tugas khusus, misalnya bertanggungjawab untuk memperbaiki atau membersihkan kembali, dan tugas-tugas lainnya.'),
       (4,
        'Teguran tertulis disertai dengan pemanggilan orang tua/wali dan membuat surat pernyataan tidak mengulangi perbuatan tersebut, dibubuhi materai, ditandatangani mahasiswa, orang tua/wali, dan DPA'),
       (5,
        'Teguran lisan disertai dengan surat pernyataan tidak mengulangi perbuatan tersebut, dibubuhi materai, ditandatangani mahasiswa yang bersangkutan dan DPA');

CREATE TABLE Rules.KlasifikasiPelanggaran
(
    klasifikasi_pelanggaran_id INT           NOT NULL IDENTITY,
    tingkat                    TINYINT       NOT NULL CHECK (tingkat BETWEEN 1 AND 5),
    pelanggaran                NVARCHAR(MAX) NOT NULL,
    sanki_id                   INT           NOT NULL,
    CONSTRAINT PK_KlasifikasiPelanggaran PRIMARY KEY (klasifikasi_pelanggaran_id),
    CONSTRAINT FK_KlasifikasiPelanggaran_SanksiPelanggaran FOREIGN KEY (sanki_id)
        REFERENCES Rules.SanksiPelanggaran (sanksi_pelanggaran_id)
);

INSERT INTO Rules.KlasifikasiPelanggaran (tingkat, pelanggaran, sanki_id)
VALUES (5,
        'Berkomunikasi dengan tidak sopan, baik tertulis atau tidak tertulis kepada mahasiswa, dosen, karyawan, atau orang lain',
        5),
       (4, 'Berbusana tidak sopan dan tidak rapi. Yaitu antara lain adalah: berpakaian ketat, transparan, memakai t-shirt (baju kaos tidak berkerah),
	   tank top, hipster, you can see, rok mini, backless, celana pendek, celana tiga per empat, legging, model celana
	   atau baju koyak, sandal, sepatu sandal di lingkungan kampus', 4),
       (4, 'Mahasiswa Iaki-laki berambut tidak rapi, gondrong yaitu panjang rambutnya melewati batas alis mata di bagian depan, telinga di bagian
	   sarnping atau menyentuh kerah baju di bagian leher', 4),
       (4, 'Mahasiswa berarnbut dengan model punk, dicat selain hitam dan/atau skinned.', 4),
       (4, 'Makan, atau minum di dalam ruang kuliah/ laboratorium/bengkel', 4),
       (3, 'Melanggar peraturan/ ketentuan yang berlaku di Polinema baik diJurusan/ Program Studi', 3),
       (3, 'Tidak menjaga kebersihan di seluruh area Polinema', 3),
       (3, 'Membuat kegaduhan yang mengganggu pelaksanaan perkuliahan atau praktikum yang sedang berlangsung.', 3),
       (3, 'Merokok di luar area kawasan merokok', 3),
       (3, 'Bermain kartu, game online di area kampus', 3),
       (3, 'Mengotori atau mencoret-coret meja, kursi, tembok, dan lain-lain di lingkungan Polinema', 3),
       (3, 'Bertingkah laku kasar atau tidak sopan kepada mahasiswa, dosen, dan/atau karyawan.', 3),
       (2, 'Merusak sarana dan prasarana yang ada di area Polinema', 2),
       (2,
        'Tidak menjaga ketertiban dan keamanan di seluruh area Polinema (misalnya: parkir tidak pada tempatnya, konvoi selebrasi wisuda dll)',
        2),
       (2, 'Melakukan pengotoran/ pengrusakan barang milik orang lain termasuk milik Politeknik Negeri Malang', 2),
       (2, 'Mengakses materi pornografi di kelas atau area kampus', 2),
       (2, 'Membawa dan/atau menggunakan senjata tajam dan/atau senjata api untuk hal kriminal', 2),
       (2, 'Melakukan perkelahian, serta membentuk geng/ kelompok yang bertujuan negatif.', 2),
       (2, 'Melakukan kegiatan politik praktis di dalam kampus', 2),
       (2, 'Melakukan tindakan kekerasan atau perkelahian di dalam kampus. I', 2),
       (2, 'Melakukan penyalahgunaan identitas untuk perbuatan negatif', 2),
       (2, 'Mengancam, baik tertulis atau tidak tertulis kepada mahasiswa, dosen, dan/atau karyawan.', 2),


       (2, 'Mencuri dalam bentuk apapun', 2),
       (2, 'Melakukan kecurangan dalam bidang akademik, administratif, dan keuangan.', 2),
       (2, 'Melakukan pemerasan dan/atau penipuan', 2),
       (2, 'Melakukan pelecehan dan/atau tindakan asusila dalam segala bentuk di dalam dan di luar kampus', 2),
       (2,
        'Berjudi, mengkonsumsi minum-minuman keras, dan/ atau bermabuk-mabukan di lingkungan dan di luar lingkungan Kampus Polinema',
        2),
       (2, 'Mengikuti organisasi dan atau menyebarkan faham-faham yang dilarang oleh Pemerintah.', 2),
       (2, 'Melakukan plagiasi(copy paste) dalam tugas-tugas atau karya ilmiah', 2),

       (1, 'Mencuri dalam bentuk apapun', 1),
       (1, 'Melakukan kecurangan dalam bidang akademik, administratif, dan keuangan.', 1),
       (1, 'Melakukan pemerasan dan/atau penipuan', 1),
       (1, 'Melakukan pelecehan dan/atau tindakan asusila dalam segala bentuk di dalam dan di luar kampus', 1),
       (1,
        'Berjudi, mengkonsumsi minum-minuman keras, dan/ atau bermabuk-mabukan di lingkungan dan di luar lingkungan Kampus Polinema',
        1),
       (1, 'Mengikuti organisasi dan atau menyebarkan faham-faham yang dilarang oleh Pemerintah.', 1),
       (1, 'Melakukan plagiasi(copy paste) dalam tugas-tugas atau karya ilmiah', 1),


       (1,
        'Tidak menjaga nama baik Polinema di masyarakat dan/ atau mencemarkan nama baik Polinema melalui media apapun',
        1),
       (1,
        'Melakukan kegiatan atau sejenisnya yang dapat menurunkan kehormatan atau martabat Negara, Bangsa dan Polinema. ',
        1),
       (1, 'Menggunakan barang-barang psikotropika dan/ atau zat-zat Adiktif lainnya', 1),
       (1, 'Mengedarkan serta menjual barang-barang psikotropika dan/ atau zat-zat Adiktif lainnya ', 1),
       (1, 'Terlibat dalam tindakan kriminal dan dinyatakan bersalah oleh Pengadilan', 1);

CREATE TABLE Rules.Pelaporan
(
    pelaporan_id        INT           NOT NULL IDENTITY,
    nim                 BIGINT        NOT NULL,
    nip                 BIGINT        NOT NULL,
    tanggal_pelanggaran DATE          NOT NULL,
    klasifikasi_id      INT           NOT NULL,
    tingkat             TINYINT       NULL CHECK (tingkat BETWEEN 1 AND 5),
    deskripsi           NVARCHAR(255) NOT NULL,
    bukti               NVARCHAR(255) NOT NULL,
    verifikasi          BIT           NOT NULL DEFAULT 0,
    batal               BIT           NOT NULL DEFAULT 0,
    CONSTRAINT PK_Pelaporan PRIMARY KEY (pelaporan_id),
    CONSTRAINT FK_Pelaporan_Mahasiswa FOREIGN KEY (nim)
        REFERENCES Core.Mahasiswa (nim),
    CONSTRAINT FK_Pelaporan_Dosen FOREIGN KEY (nip)
        REFERENCES Core.Dosen (nip),
    CONSTRAINT FK_Pelaporan_KlasifikasiPelanggaran FOREIGN KEY (klasifikasi_id)
        REFERENCES Rules.KlasifikasiPelanggaran (klasifikasi_pelanggaran_id)
);

IF OBJECT_ID('trg_UpdateTingkat', 'TR') IS NOT NULL
    DROP TRIGGER trg_UpdateTingkat;
GO
CREATE TRIGGER trg_UpdateTingkat
    ON Rules.Pelaporan
    AFTER INSERT
    AS
BEGIN
    DECLARE @nim BIGINT, @tingkat TINYINT, @klasifikasi_id INT, @bukti NVARCHAR(255) , @pelanggaran NVARCHAR(MAX);

    SELECT @nim = nim, @klasifikasi_id = klasifikasi_id, @bukti = bukti
    FROM inserted;

    SELECT @tingkat = tingkat, @pelanggaran = pelanggaran
    FROM Rules.KlasifikasiPelanggaran
    WHERE klasifikasi_pelanggaran_id = @klasifikasi_id;

    IF EXISTS (SELECT 1
               FROM Rules.KlasifikasiPelanggaran
               WHERE pelanggaran = @pelanggaran
               GROUP BY pelanggaran
               HAVING COUNT(*) > 1)
        BEGIN
            UPDATE Rules.Pelaporan
            SET tingkat = null
            WHERE pelaporan_id = (SELECT MAX(pelaporan_id)
                                  FROM Rules.Pelaporan
                                  WHERE nim = @nim
                                    AND klasifikasi_id = @klasifikasi_id
                                    AND bukti = @bukti);
        end
    ELSE
        IF EXISTS (SELECT 1
                   FROM Rules.Pelaporan
                   WHERE nim = @nim
                     AND tingkat = @tingkat
                     AND verifikasi = 1
                   GROUP BY nim, tingkat
                   HAVING COUNT(*) >= 3)
            BEGIN
                DECLARE @newTingkat TINYINT = @tingkat;
                WHILE @newTingkat > 1
                    BEGIN
                        SET @newTingkat = @newTingkat - 1;
                        IF EXISTS (SELECT 1
                                   FROM Rules.Pelaporan
                                   WHERE nim = @nim
                                     AND tingkat = @newTingkat
                                     AND verifikasi = 1
                                   GROUP BY nim, tingkat
                                   HAVING COUNT(*) >= 3)
                            CONTINUE;
                        ELSE
                            BREAK;
                    END
                UPDATE Rules.Pelaporan
                SET tingkat = @newTingkat
                WHERE pelaporan_id = (SELECT MAX(pelaporan_id)
                                      FROM Rules.Pelaporan
                                      WHERE nim = @nim
                                        AND klasifikasi_id = @klasifikasi_id
                                        AND bukti = @bukti);
            END
        ELSE
            BEGIN
                UPDATE Rules.Pelaporan
                SET tingkat = @tingkat
                WHERE pelaporan_id = (SELECT MAX(pelaporan_id)
                                      FROM Rules.Pelaporan
                                      WHERE nim = @nim
                                        AND klasifikasi_id = @klasifikasi_id
                                        AND bukti = @bukti);
            END
END;
GO

CREATE TABLE Rules.PelanggaranMahasiswa
(
    pelanggaran_id     INT           NOT NULL IDENTITY,
    pelaporan_id       INT           NOT NULL,
    status             BIT           NOT NULL DEFAULT 0,
    surat_bebas_sanksi NVARCHAR(255) NULL,
    CONSTRAINT PK_Pelanggaran PRIMARY KEY (pelanggaran_id),
    CONSTRAINT FK_Pelanggaran_Pelaporan FOREIGN KEY (pelaporan_id)
        REFERENCES Rules.Pelaporan (pelaporan_id)
);

IF OBJECT_ID('vw_DetailLaporan', 'V') IS NOT NULL
    DROP VIEW vw_DetailLaporan;
GO

CREATE VIEW vw_DetailLaporan AS
SELECT p.pelaporan_id,
       m.nama_lengkap           as mahasiswa,
       m.nim,
       k.kelas,
       p2.prodi,
       d.nama_lengkap           as dosen,
       p.tanggal_pelanggaran,
       kp.pelanggaran,
       p.tingkat                as tingkat,
       kp.tingkat               as tingkatkp,
       COALESCE(s.sanksi, NULL) as sanksi,
       p.bukti,
       p.deskripsi,
       p.verifikasi,
       p.batal
FROM Rules.Pelaporan p
         JOIN Core.Mahasiswa m ON p.nim = m.nim
         JOIN Core.Kelas k on k.kelas_id = m.kelas_id
         Join Core.Prodi p2 on m.prodi_id = p2.prodi_id
         JOIN Core.Dosen d ON p.nip = d.nip
         JOIN Rules.KlasifikasiPelanggaran kp ON p.klasifikasi_id = kp.klasifikasi_pelanggaran_id
         LEFT JOIN Rules.SanksiPelanggaran s ON p.tingkat = s.tingkat;
GO

IF OBJECT_ID('vm_DetailPelanggaranMahasiswa', 'V') IS NOT NULL
    DROP VIEW vm_DetailPelanggaranMahasiswa;
GO

CREATE VIEW vm_DetailPelanggaranMahasiswa AS
SELECT PM.pelaporan_id,
       m.nama_lengkap,
       m.nim,
       k.kelas,
       p2.prodi,
       p.tanggal_pelanggaran,
       kp.pelanggaran,
       p.tingkat  as tingkat,
       kp.tingkat as tingkatKP,
       s.sanksi,
       p.bukti,
       p.deskripsi,
       PM.surat_bebas_sanksi,
       PM.status
FROM Rules.PelanggaranMahasiswa PM
         join Rules.Pelaporan P on P.pelaporan_id = PM.pelaporan_id
         JOIN Core.Mahasiswa m ON p.nim = m.nim
         JOIN Core.Kelas k on k.kelas_id = m.kelas_id
         Join Core.Prodi p2 on m.prodi_id = p2.prodi_id
         JOIN Rules.KlasifikasiPelanggaran kp ON p.klasifikasi_id = kp.klasifikasi_pelanggaran_id
         JOIN Rules.SanksiPelanggaran s ON p.tingkat = s.tingkat;
GO

IF OBJECT_ID('Rules.GetJumlahPelaporanPerTahun', 'FN') IS NOT NULL
    DROP FUNCTION Rules.GetJumlahPelaporanPerTahun;
GO


CREATE FUNCTION Rules.GetJumlahPelaporanPerTahun(
    @Tahun INT,
    @NIP BIGINT = NULL,
    @NIM BIGINT = NULL
)
    RETURNS TABLE
        AS
        RETURN(SELECT MONTH(tanggal_pelanggaran) AS Bulan,
                      COUNT(*)                   AS JumlahPelaporan
               FROM Rules.Pelaporan
               WHERE verifikasi = 1
                 AND YEAR(tanggal_pelanggaran) = @Tahun
                 AND (@NIP IS NULL OR nip = @NIP)
                 AND (@NIM IS NULL OR nim = @NIM)
               GROUP BY MONTH(tanggal_pelanggaran));
GO

IF OBJECT_ID('Rules.GetJumlahPelaporanKeseluruhan', 'FN') IS NOT NULL
    DROP FUNCTION Rules.GetJumlahPelaporanKeseluruhan;
GO

CREATE FUNCTION Rules.GetJumlahPelaporanKeseluruhan(
    @NIP BIGINT = NULL,
    @NIM BIGINT = NULL
)
    RETURNS TABLE
        AS
        RETURN(SELECT COUNT(*) AS JumlahPelaporan
               FROM Rules.Pelaporan
               WHERE verifikasi = 1
                 AND (@NIP IS NULL OR nip = @NIP)
                 AND (@NIM IS NULL OR nim = @NIM));

