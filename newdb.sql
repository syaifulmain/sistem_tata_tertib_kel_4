USE
    master;
GO

IF
    DB_ID('sistem_tata_tertib_db_test_new') IS NOT NULL
    DROP
        DATABASE sistem_tata_tertib_db_test_new;

IF
    @@ERROR = 3702
    RAISERROR ('Database cannot be dropped because there are still open connections.', 127, 127) WITH NOWAIT, LOG;

CREATE
    DATABASE sistem_tata_tertib_db_test_new;
GO

USE sistem_tata_tertib_db_test_new;
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

-- prodi
INSERT INTO Core.Prodi (prodi)
VALUES ('Teknik Informatika'),
       ('Sistem Informasi Bisnis');

CREATE TABLE Core.Dosen
(
    dosen_id     INT           NOT NULL IDENTITY,
    nip          NVARCHAR(20)  NOT NULL UNIQUE,
    nama_lengkap NVARCHAR(100) NOT NULL,
    no_telepon   NVARCHAR(15)  NOT NULL,
    email        NVARCHAR(100) NOT NULL,
    dpa          BIT           NOT NULL DEFAULT 0,
    CONSTRAINT PK_Dosen PRIMARY KEY (dosen_id)
);

-- dosen
INSERT INTO Core.Dosen (nip, nama_lengkap, no_telepon, email, dpa)
VALUES ('12345678901234567890', 'Dosen 1', '081234567890', 'examle@example.com',  1),
       ('12345678911234567891', 'Dosen 2', '081234567891', 'examle@example.com',  1);

CREATE TABLE Core.Kelas
(
    kelas_id INT IDENTITY PRIMARY KEY,
    kelas    CHAR(2) NOT NULL UNIQUE,
    dosen_id INT     NOT NULL,
    CONSTRAINT FK_Kelas_Dosen FOREIGN KEY (dosen_id)
        REFERENCES Core.Dosen (dosen_id)
);
-- prodi
INSERT INTO Core.Kelas (kelas, dosen_id)
VALUES ('1A', 1),
       ('1B', 2);

CREATE TABLE Core.Mahasiswa
(
    mahasiswa_id INT           NOT NULL IDENTITY,
    nim          NVARCHAR(10)  NOT NULL UNIQUE,
    nama_lengkap NVARCHAR(100) NOT NULL,
    no_telepon   NVARCHAR(15)  NULL,
    email        NVARCHAR(100) NULL,
    prodi_id     INT           NOT NULL,
    kelas_id     INT           NOT NULL,
    CONSTRAINT PK_Mahasiswa PRIMARY KEY (mahasiswa_id),
    CONSTRAINT FK_Mahasiswa_Prodi FOREIGN KEY (prodi_id)
        REFERENCES Core.Prodi (prodi_id),
    CONSTRAINT FK_Mahasiswa_Kelas FOREIGN KEY (kelas_id)
        REFERENCES Core.Kelas (kelas_id)
);

-- mahasiswa
INSERT INTO Core.Mahasiswa (nim, nama_lengkap, no_telepon, email, prodi_id, kelas_id)
VALUES ('1234567890', 'Mahasiswa 1', '081234567890', 'examle@example.com', 1, 1),
       ('1234567891', 'Mahasiswa 2', '081234567891', 'examle@example.com', 1, 1),
       ('1234567892', 'Mahasiswa 3', '081234567891', 'examle@example.com', 2, 1),
       ('1234567893', 'Mahasiswa 4', '081234567891', 'examle@example.com', 2, 1),
       ('1234567894', 'Mahasiswa 5', '081234567891', 'examle@example.com', 2, 2),
       ('1234567895', 'Mahasiswa 6', '081234567891', 'examle@example.com', 2, 2);


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
VALUES ('admin', 'admin', 'admin'),
       ('12345678901234567890', '1234', 'dosen'),
       ('12345678911234567891', '1234', 'dosen'),
       ('1234567890', '1234', 'mahasiswa'),
       ('1234567891', '1234', 'mahasiswa'),
       ('1234567892', '1234', 'mahasiswa'),
       ('1234567893', '1234', 'mahasiswa'),
       ('1234567894', '1234', 'mahasiswa'),
       ('1234567895', '1234', 'mahasiswa');


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
VALUES (1, 'Peringatan Lisan'),
       (2, 'Peringatan Tertulis'),
       (3, 'Dikeluarkan dari Kelas'),
       (4, 'Dikeluarkan dari Program Studi'),
       (5, 'Dikeluarkan dari Kampus');


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

-- klasifikasi
INSERT INTO Rules.KlasifikasiPelanggaran (tingkat, pelanggaran, sanki_id)
VALUES (1, 'Terlambat masuk kelas', 1),
       (2, 'Tidak membawa alat tulis', 2),
       (3, 'Tidak mengerjakan tugas', 3),
       (4, 'Tidak mengikuti ujian', 4),
       (5, 'Tidak mengikuti perkuliahan', 5);

CREATE TABLE Rules.Pelaporan
(
    pelaporan_id        INT           NOT NULL IDENTITY,
    mahasiswa_id        INT           NOT NULL,
    dosen_id            INT           NOT NULL,
    tanggal_pelanggaran DATE          NOT NULL,
    klasifikasi_id      INT           NOT NULL,
    deskripsi           NVARCHAR(255) NOT NULL,
    bukti               NVARCHAR(255) NOT NULL,
    verifikasi          BIT           NOT NULL DEFAULT 0,
    batal               BIT           NOT NULL DEFAULT 0,
    CONSTRAINT PK_Pelaporan PRIMARY KEY (pelaporan_id),
    CONSTRAINT FK_Pelaporan_Mahasiswa FOREIGN KEY (mahasiswa_id)
        REFERENCES Core.Mahasiswa (mahasiswa_id),
    CONSTRAINT FK_Pelaporan_Dosen FOREIGN KEY (dosen_id)
        REFERENCES Core.Dosen (dosen_id),
    CONSTRAINT FK_Pelaporan_KlasifikasiPelanggaran FOREIGN KEY (klasifikasi_id)
        REFERENCES Rules.KlasifikasiPelanggaran (klasifikasi_pelanggaran_id)
);

-- pelaporan
INSERT INTO Rules.Pelaporan (mahasiswa_id, dosen_id, tanggal_pelanggaran, klasifikasi_id, deskripsi, bukti)
VALUES (1, 1, '2021-01-01', 1, 'Terlambat masuk kelas', 'bukti');

INSERT INTO Rules.Pelaporan (mahasiswa_id, dosen_id, tanggal_pelanggaran, klasifikasi_id, deskripsi, bukti, verifikasi,
                             batal)
VALUES (1, 1, '2021-01-01', 1, 'Terlambat masuk kelas', 'bukti', 0, 0),
       (2, 2, '2021-01-01', 2, 'Tidak membawa alat tulis', 'bukti', 0, 0)

CREATE TABLE Rules.PelanggaranMahasiswa
(
    pelanggaran_id          INT           NOT NULL IDENTITY,
    pelaporan_id            INT           NOT NULL,
    status                  BIT           NOT NULL DEFAULT 0,
    surat_pernyataan        NVARCHAR(255) NULL,
    bukti_bebas_pelanggaran NVARCHAR(255) NULL,
    CONSTRAINT PK_Pelanggaran PRIMARY KEY (pelanggaran_id),
    CONSTRAINT FK_Pelanggaran_Pelaporan FOREIGN KEY (pelaporan_id)
        REFERENCES Rules.Pelaporan (pelaporan_id)
);