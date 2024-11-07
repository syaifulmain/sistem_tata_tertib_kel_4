USE master;

IF DB_ID('sistem_tata_tertib_db_test') IS NOT NULL
    DROP DATABASE sistem_tata_tertib_db_test;
GO;

IF @@ERROR = 3702
    RAISERROR ('Database cannot be dropped because there are still open connections.', 127, 127) WITH NOWAIT, LOG;

CREATE DATABASE sistem_tata_tertib_db_test;
GO

USE sistem_tata_tertib_db_test;
GO

---------------------------------------------------------------------
-- Create Schemas
---------------------------------------------------------------------

CREATE SCHEMA Core AUTHORIZATION dbo;
GO
CREATE SCHEMA Admin AUTHORIZATION dbo;
GO
CREATE SCHEMA Rules AUTHORIZATION dbo;
GO

---------------------------------------------------------------------
-- Create Tables
---------------------------------------------------------------------

CREATE TABLE Core.Mahasiswa
(
    mahasiswa_id   INT          NOT NULL IDENTITY,
    nim            CHAR(10)     NOT NULL UNIQUE,
    nama_lengkap   VARCHAR(100) NOT NULL,
    nik            CHAR(16)     NOT NULL UNIQUE,
    kota_lahir     VARCHAR(50)  NOT NULL,
    tanggal_lahir  DATE         NOT NULL,
    agama          VARCHAR(20)  NOT NULL,
    jenis_kelamin  CHAR(1)      NOT NULL CHECK (jenis_kelamin IN ('L', 'P')),
    golongan_darah CHAR(2)      NULL,
    anak_ke        TINYINT      NULL,
    no_telepon     VARCHAR(15)  NOT NULL,
    email          VARCHAR(100) NOT NULL UNIQUE,
    CONSTRAINT PK_Mahasiswa PRIMARY KEY (mahasiswa_id),
    CONSTRAINT CHK_tanggal_lahir CHECK (tanggal_lahir <= CURRENT_TIMESTAMP)
);

INSERT INTO Core.Mahasiswa (nim, nama_lengkap, nik, kota_lahir, tanggal_lahir, agama, jenis_kelamin, golongan_darah,
                            anak_ke, no_telepon, email)
VALUES ('2341720013', 'Muhamad Syaifullah', 3505022211040001, 'Blitar', '11/22/2004', 'Islam', 'L', 'B', '3',
        '085123123123', 'example@example.com')

CREATE TABLE Admin.Users
(
    user_id       INT          NOT NULL IDENTITY,
    username      VARCHAR(50)  NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    role          VARCHAR(20)  NOT NULL,
    CONSTRAINT PK_Users PRIMARY KEY (user_id),
    CONSTRAINT CHK_role CHECK (role IN ('admin', 'dosen', 'mahasiswa'))
);

INSERT INTO Admin.Users (username, password_hash, role)
VALUES ('2341720013', '1234', 'mahasiswa');

CREATE TABLE Admin.Session
(
    session_token VARCHAR(255) NOT NULL UNIQUE,
    user_id       INT          NOT NULL,
    created_at    DATETIME DEFAULT GETDATE(),
    expires_at    DATETIME     NOT NULL,
    CONSTRAINT PK_Session PRIMARY KEY (session_token),
    CONSTRAINT FK_Session_Users FOREIGN KEY (user_id)
        REFERENCES Admin.Users (user_id)
);

CREATE TABLE Rules.TingkatPelanggaran
(
    tingkat_pelanggaran_id INT           NOT NULL IDENTITY,
    tingkatan              TINYINT       NOT NULL UNIQUE CHECK (tingkatan BETWEEN 1 AND 5),
    tingkat                NVARCHAR(50)  NOT NULL,
    sanksi_pelanggaran     NVARCHAR(MAX) NOT NULL,
    CONSTRAINT PK_TingkatPelanggaran PRIMARY KEY (tingkat_pelanggaran_id),
);

INSERT INTO Rules.TingkatPelanggaran (tingkatan, tingkat, sanksi_pelanggaran)
VALUES (1, 'Tingkat I', 'Pemanggilan Orang Tua/Wali, Pembinaan, dan Pembinaan'),
       (2, 'Tingkat II', 'Pemanggilan Orang Tua/Wali, Pembinaan, dan Pembinaan'),
       (3, 'Tingkat III', 'Pemanggilan Orang Tua/Wali, Pembinaan, dan Pembinaan'),
       (4, 'Tingkat IV', 'Pemanggilan Orang Tua/Wali, Pembinaan, dan Pembinaan'),
       (5, 'Tingkat V', 'Pemanggilan Orang Tua/Wali, Pembinaan, dan Pembinaan');

CREATE TABLE Rules.PelanggaranTataTertib
(
    pelanggaran_tata_tertib_id INT           NOT NULL IDENTITY,
    pelanggaran                NVARCHAR(255) NOT NULL,
    tingkatan                  TINYINT       NOT NULL,
    CONSTRAINT PK_TataTertib PRIMARY KEY (pelanggaran_tata_tertib_id),
    CONSTRAINT FK_TataTertib_TingkatPelanggaran FOREIGN KEY (tingkatan)
        REFERENCES Rules.TingkatPelanggaran (tingkatan),
);

INSERT INTO Rules.PelanggaranTataTertib (pelanggaran, tingkatan)
VALUES ('Berkomunikasi dengan tidak sopan, baik tertulis atau tidak tertulis kepada mahasiswa, dosen, karyawan, atau orang lain',
        5),
       ('Berbusana tidak sopan dan tidak rapi. Yaitu antara lain adalah: berpakaian ketat, transparan, memakai t-shirt (baju kaos tidak berkerah), tank top, hipster, you can see, rok mini, backless, celana pendek, celana tiga per empat, legging, model celana atau baju koyak, sandal, sepatu sandal di lingkungan kampus',
        4),
       ('Mahasiswa Iaki-laki berambut tidak rapi, gondrong yaitu panjang rarnbutnya melewati batas alis mata di bagian depan, telinga di bagian sarnping atau menyentuh kerah baju di bagian leher',
        4),
       ('Mahasiswa berarnbut dengan model punk, dicat selain hitam dan/ atau skinned.', 4),
       ('Makan, atau minum di dalam ruang kuliah/ laboratorium/ bengkel.', 4);


CREATE TABLE Rules.Pelanggaran
(
    pelanggaran_id           INT           NOT NULL IDENTITY,
    mahasiswa_id             INT           NOT NULL,
    tata_tertib_id           INT           NOT NULL,
    tanggal_pelanggaran      DATE          NOT NULL,
    deskripsi                NVARCHAR(MAX) NULL,
    sanksi                   NVARCHAR(255) NULL,
    surat_pertanggungjawaban VARBINARY(MAx),
    verifikasi               BIT           NOT NULL DEFAULT 0,
    CONSTRAINT PK_Pelanggaran PRIMARY KEY (pelanggaran_id),
    CONSTRAINT FK_Pelanggaran_Mahasiswa FOREIGN KEY (mahasiswa_id)
        REFERENCES Core.Mahasiswa (mahasiswa_id),
    CONSTRAINT FK_Pelanggaran_TataTertib FOREIGN KEY (tata_tertib_id)
        REFERENCES Rules.PelanggaranTataTertib (pelanggaran_tata_tertib_id)
);

CREATE TABLE Core.Mahasiswa
(
    mahasiswa_id INT           NOT NULL IDENTITY,
    nim          NVARCHAR(10)  NOT NULL UNIQUE,
    nama_lengkap NVARCHAR(100) NOT NULL,
    no_telepon   NVARCHAR(15)  NOT NULL,
    email        NVARCHAR(100) NOT NULL,
    CONSTRAINT PK_Mahasiswa PRIMARY KEY (mahasiswa_id)
);

CREATE TABLE Core.Dosen
(
    dosen_id     INT           NOT NULL IDENTITY,
    nip          NVARCHAR(20)  NOT NULL UNIQUE,
    nama_lengkap NVARCHAR(100) NOT NULL,
    no_telepon   NVARCHAR(15)  NOT NULL,
    email        NVARCHAR(100) NOT NULL,
    CONSTRAINT PK_Dosen PRIMARY KEY (dosen_id)
);

CREATE TABLE Core.TeknologiInformasi
(
    teknologi_informasi_id INT     NOT NULL IDENTITY,
    mahasiswa_id           INT     NOT NULL,
    dosendpa_id            INT     NOT NULL,
    tingakat               TINYINT NOT NULL,
    kelas                  CHAR(1) NOT NULL,
    CONSTRAINT PK_TeknologiInformasi PRIMARY KEY (teknologi_informasi_id),
    CONSTRAINT FK_TeknologiInformasi_Mahasiswa FOREIGN KEY (mahasiswa_id)
        REFERENCES Core.Mahasiswa (mahasiswa_id),
    CONSTRAINT FK_TeknologiInformasi_DosenDPA FOREIGN KEY (dosendpa_id)
        REFERENCES Core.DosenDPA (dosen_dpa_id)
);

CREATE TABLE Core.DosenDPA
(
    dosen_dpa_id INT NOT NULL IDENTITY,
    dosen_id     INT NOT NULL,
    CONSTRAINT PK_DosenDPA PRIMARY KEY (dosen_dpa_id),
    CONSTRAINT FK_DosenDPA_Dosen FOREIGN KEY (dosen_id)
        REFERENCES Core.Dosen (dosen_id)
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
    user_id       INT          NOT NULL,
    expires_at    DATETIME     NOT NULL,
    CONSTRAINT PK_Session PRIMARY KEY (session_token),
    CONSTRAINT FK_Session_Users FOREIGN KEY (user_id)
        REFERENCES Admin.Users (user_id)
);

CREATE TABLE Rules.TingkatPelanggaran
(
    tingkat_pelanggaran_id INT          NOT NULL IDENTITY,
    tingkatan              TINYINT      NOT NULL UNIQUE,
    deskripsi              VARCHAR(255) NOT NULL,
    CONSTRAINT PK_TingkatPelanggaran PRIMARY KEY (tingkat_pelanggaran_id)
);

CREATE TABLE Rules.KlasifikasiPelanggaran
(
    klasifikasi_pelanggaran_id INT           NOT NULL IDENTITY,
    pelanggaran                NVARCHAR(MAX) NOT NULL,
    tingkat                    TINYINT       NOT NULL,
    CONSTRAINT PK_KlasifikasiPelanggaran PRIMARY KEY (klasifikasi_pelanggaran_id),
    CONSTRAINT FK_KlasifikasiPelanggaran_TingkatPelanggaran FOREIGN KEY (tingkat)
        REFERENCES Rules.TingkatPelanggaran (tingkatan)
);

CREATE TABLE Rules.AkumulasiSanksiPelanggaran
(
    akumulasi_sanksi_pelanggaran_id INT          NOT NULL IDENTITY,
    deskripsi                       VARCHAR(MAX) NOT NULL,
    CONSTRAINT PK_AkumulasiSanksiPelanggaran PRIMARY KEY (akumulasi_sanksi_pelanggaran_id),
);

CREATE TABLE Rules.SanksiPelanggaran
(
    sanksi_pelanggaran_id INT           NOT NULL IDENTITY,
    tingkat               TINYINT       NOT NULL,
    sanksi                NVARCHAR(MAX) NOT NULL,
    CONSTRAINT PK_SanksiPelanggaran PRIMARY KEY (sanksi_pelanggaran_id),
    CONSTRAINT FK_SanksiPelanggaran_TingkatPelanggaran FOREIGN KEY (tingkat)
        REFERENCES Rules.TingkatPelanggaran (tingkatan)
)

CREATE TABLE Rules.Pelaporan
(
    pelaporan_id        INT           NOT NULL IDENTITY,
    mahasiswa_id        INT           NOT NULL,
    dosen_id            INT           NOT NULL,
    tanggal_pelaporan   DATE          NOT NULL,
    tanggal_pelanggaran DATE          NOT NULL,
    klasifikasi_id      INT           NOT NULL,
    deskripsi           NVARCHAR(MAX) NOT NULL,
    bukti               VARBINARY(MAX),
    verifikasi          BIT           NOT NULL DEFAULT 0,
    CONSTRAINT PK_Pelaporan PRIMARY KEY (pelaporan_id),
    CONSTRAINT FK_Pelaporan_Mahasiswa FOREIGN KEY (mahasiswa_id)
        REFERENCES Core.Mahasiswa (mahasiswa_id),
    CONSTRAINT FK_Pelaporan_Dosen FOREIGN KEY (dosen_id)
        REFERENCES Core.Dosen (dosen_id),
    CONSTRAINT FK_Pelaporan_KlasifikasiPelanggaran FOREIGN KEY (klasifikasi_id)
        REFERENCES Rules.KlasifikasiPelanggaran (klasifikasi_pelanggaran_id)
)

CREATE TABLE Rules.Pelanggaran
(
    pelanggaran_id INT           NOT NULL IDENTITY,
    pelaporan_id   INT           NOT NULL,
    sanksi         NVARCHAR(MAX) NOT NULL,
    status         BIT           NOT NULL DEFAULT 0,
    CONSTRAINT PK_Pelanggaran PRIMARY KEY (pelanggaran_id),
    CONSTRAINT FK_Pelanggaran_Pelaporan FOREIGN KEY (pelaporan_id)
        REFERENCES Rules.Pelaporan (pelaporan_id)
);