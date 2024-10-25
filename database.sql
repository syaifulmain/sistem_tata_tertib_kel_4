USE master;

IF DB_ID('sistem_tata_tertib_db_test') IS NOT NULL DROP DATABASE TSQL;

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
    created_at     DATETIME DEFAULT GETDATE(),
    updated_at     DATETIME DEFAULT GETDATE(),
    CONSTRAINT PK_Mahasiswa PRIMARY KEY (mahasiswa_id),
    CONSTRAINT CHK_tanggal_lahir CHECK (tanggal_lahir <= CURRENT_TIMESTAMP)
);

CREATE TABLE Admin.Users
(
    user_id       INT          NOT NULL IDENTITY,
    username      VARCHAR(50)  NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    role          VARCHAR(20)  NOT NULL,
    created_at    DATETIME DEFAULT GETDATE(),
    updated_at    DATETIME DEFAULT GETDATE(),
    CONSTRAINT PK_Users PRIMARY KEY (user_id),
    CONSTRAINT CHK_role CHECK (role IN ('admin', 'dosen', 'mahasiswa'))
);
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
    created_at             DATETIME DEFAULT GETDATE(),
    updated_at             DATETIME DEFAULT GETDATE(),
    CONSTRAINT PK_TingkatPelanggaran PRIMARY KEY (tingkat_pelanggaran_id),
);

INSERT INTO Rules.TingkatPelanggaran (tingkatan, tingkat, sanksi_pelanggaran)
VALUES
    (1, 'Tingkat I', 'Pemanggilan Orang Tua/Wali, Pembinaan, dan Pembinaan'),
    (2, 'Tingkat II', 'Pemanggilan Orang Tua/Wali, Pembinaan, dan Pembinaan'),
    (3, 'Tingkat III', 'Pemanggilan Orang Tua/Wali, Pembinaan, dan Pembinaan'),
    (4, 'Tingkat IV', 'Pemanggilan Orang Tua/Wali, Pembinaan, dan Pembinaan'),
    (5, 'Tingkat V', 'Pemanggilan Orang Tua/Wali, Pembinaan, dan Pembinaan');

CREATE TABLE Rules.PelanggaranTataTertib
(
    pelanggaran_tata_tertib_id INT           NOT NULL IDENTITY,
    pelanggaran                NVARCHAR(255) NOT NULL,
    tingkatan                  TINYINT       NOT NULL,
    created_at                 DATETIME DEFAULT GETDATE(),
    updated_at                 DATETIME DEFAULT GETDATE(),
    CONSTRAINT PK_TataTertib PRIMARY KEY (pelanggaran_tata_tertib_id),
    CONSTRAINT FK_TataTertib_TingkatPelanggaran FOREIGN KEY (tingkatan)
        REFERENCES Rules.TingkatPelanggaran (tingkatan),
);

INSERT INTO Rules.PelanggaranTataTertib (pelanggaran, tingkatan)
VALUES
    ('Berkomunikasi dengan tidak sopan, baik tertulis atau tidak tertulis kepada mahasiswa, dosen, karyawan, atau orang lain', 5),
    ('Berbusana tidak sopan dan tidak rapi. Yaitu antara lain adalah: berpakaian ketat, transparan, memakai t-shirt (baju kaos tidak berkerah), tank top, hipster, you can see, rok mini, backless, celana pendek, celana tiga per empat, legging, model celana atau baju koyak, sandal, sepatu sandal di lingkungan kampus', 4),
    ('Mahasiswa Iaki-laki berambut tidak rapi, gondrong yaitu panjang rarnbutnya melewati batas alis mata di bagian depan, telinga di bagian sarnping atau menyentuh kerah baju di bagian leher', 4),
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
    created_at               DATETIME               DEFAULT GETDATE(),
    updated_at               DATETIME               DEFAULT GETDATE(),
    CONSTRAINT PK_Pelanggaran PRIMARY KEY (pelanggaran_id),
    CONSTRAINT FK_Pelanggaran_Mahasiswa FOREIGN KEY (mahasiswa_id)
        REFERENCES Core.Mahasiswa (mahasiswa_id),
    CONSTRAINT FK_Pelanggaran_TataTertib FOREIGN KEY (tata_tertib_id)
        REFERENCES Rules.PelanggaranTataTertib (pelanggaran_tata_tertib_id)
);