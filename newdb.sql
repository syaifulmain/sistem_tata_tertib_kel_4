USE
    master;
GO

IF
    DB_ID('sistem_tata_tertib') IS NOT NULL
    DROP
        DATABASE sistem_tata_tertib;

IF
    @@ERROR = 3702
    RAISERROR ('Database cannot be dropped because there are still open connections.', 127, 127) WITH NOWAIT, LOG;

CREATE
    DATABASE sistem_tata_tertib;
GO

USE sistem_tata_tertib;
GO

CREATE SCHEMA Core AUTHORIZATION dbo;
GO
CREATE SCHEMA Admin AUTHORIZATION dbo;
GO
CREATE SCHEMA Rules AUTHORIZATION dbo;
GO


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

CREATE TABLE Core.Kelas
(
    kelas_id INT IDENTITY PRIMARY KEY,
    kelas    CHAR(2) NOT NULL UNIQUE,
    nip      BIGINT  NOT NULL,
    CONSTRAINT FK_Kelas_Dosen FOREIGN KEY (nip)
        REFERENCES Core.Dosen (nip)
);

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

CREATE TABLE Admin.Users
(
    user_id       INT           NOT NULL IDENTITY,
    username      NVARCHAR(50)  NOT NULL UNIQUE,
    password_hash NVARCHAR(255) NOT NULL,
    level         VARCHAR(10)   NOT NULL,
    CONSTRAINT PK_Users PRIMARY KEY (user_id),
    CONSTRAINT CHK_Level CHECK (level IN ('admin', 'dosen', 'mahasiswa'))
);

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

DELETE FROM Rules.KlasifikasiPelanggaran;

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
CREATE VIEW vw_DetailLaporan AS
SELECT p.pelaporan_id,
       m.nama_lengkap as mahasiswa,
       m.nim,
       k.kelas,
       p2.prodi,
       d.nama_lengkap as dosen,
       p.tanggal_pelanggaran,
       kp.pelanggaran,
       p.tingkat      as tingkat,
       kp.tingkat     as tingkatkp,
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

IF OBJECT_ID('vm_DetailPelanggaranMahasiswa', 'V') IS NOT NULL
    DROP VIEW vm_DetailPelanggaranMahasiswa;
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
         JOIN Rules.SanksiPelanggaran s ON p.tingkat = s.tingkat

CREATE FUNCTION Rules.GetJumlahPelaporanPerTahun (
    @Tahun INT,
    @NIP BIGINT = NULL,
    @NIM BIGINT = NULL
)
    RETURNS TABLE
        AS
        RETURN (
        SELECT
            MONTH(tanggal_pelanggaran) AS Bulan,
            COUNT(*) AS JumlahPelaporan
        FROM Rules.Pelaporan
        WHERE verifikasi = 1
          AND YEAR(tanggal_pelanggaran) = @Tahun
          AND (@NIP IS NULL OR nip = @NIP)
          AND (@NIM IS NULL OR nim = @NIM)
        GROUP BY MONTH(tanggal_pelanggaran)
        );


CREATE FUNCTION Rules.GetJumlahPelaporanKeseluruhan (
    @NIP BIGINT = NULL,
    @NIM BIGINT = NULL
)
    RETURNS TABLE
        AS
        RETURN (
        SELECT
            COUNT(*) AS JumlahPelaporan
        FROM Rules.Pelaporan
        WHERE verifikasi = 1
          AND (@NIP IS NULL OR nip = @NIP)
          AND (@NIM IS NULL OR nim = @NIM)
        );

