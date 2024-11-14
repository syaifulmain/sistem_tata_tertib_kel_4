USE
    master;

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


CREATE TABLE Core.Mahasiswa
(
    mahasiswa_id INT     NOT NULL IDENTITY,
    nim          NVARCHAR(10)  NOT NULL UNIQUE,
    nama_lengkap NVARCHAR(100) NOT NULL,
    no_telepon   NVARCHAR(15)  NULL,
    email        NVARCHAR(100) NULL,
    kelas        CHAR(2) NOT NULL,
    CONSTRAINT PK_Mahasiswa PRIMARY KEY (mahasiswa_id)
);

CREATE TABLE Core.Dosen
(
    dosen_id     INT NOT NULL IDENTITY,
    nip          NVARCHAR(20)  NOT NULL UNIQUE,
    nama_lengkap NVARCHAR(100) NOT NULL,
    no_telepon   NVARCHAR(15)  NOT NULL,
    email        NVARCHAR(100) NOT NULL,
    dpa_kelas    CHAR(2) NULL,
    CONSTRAINT PK_Dosen PRIMARY KEY (dosen_id)
);

CREATE TABLE Core.Kelas
(
    kelas    CHAR(2) NOT NULL UNIQUE,
);

INSERT INTO Core.Kelas (kelas)
VALUES ('1A'),
       ('1B'),
       ('1C'),
       ('2A'),
       ('2B'),
       ('2C');

CREATE TABLE Admin.Users
(
    user_id       INT         NOT NULL IDENTITY,
    username      NVARCHAR(50)  NOT NULL UNIQUE,
    password_hash NVARCHAR(255) NOT NULL,
    level         VARCHAR(10) NOT NULL,
    CONSTRAINT PK_Users PRIMARY KEY (user_id),
    CONSTRAINT CHK_Level CHECK (level IN ('admin', 'dosen', 'mahasiswa'))
);

INSERT INTO Admin.Users (username, password_hash, level)
VALUES ('admin', 'admin', 'admin');

CREATE TABLE Admin.Session
(
    session_token VARCHAR(255) NOT NULL UNIQUE,
    username      NVARCHAR(50) NOT NULL,
    expires_at    DATETIME NULL,
    CONSTRAINT PK_Session PRIMARY KEY (session_token)
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
    klasifikasi_pelanggaran_id INT     NOT NULL IDENTITY,
    pelanggaran                NVARCHAR(MAX) NOT NULL,
    tingkat                    TINYINT NOT NULL,
    CONSTRAINT PK_KlasifikasiPelanggaran PRIMARY KEY (klasifikasi_pelanggaran_id),
    CONSTRAINT FK_KlasifikasiPelanggaran_TingkatPelanggaran FOREIGN KEY (tingkat)
        REFERENCES Rules.TingkatPelanggaran (tingkatan)
);

CREATE TABLE Rules.AkumulasiSanksiPelanggaran
(
    akumulasi_sanksi_pelanggaran_id INT NOT NULL IDENTITY,
    deskripsi                       NVARCHAR(MAX) NOT NULL,
    CONSTRAINT PK_AkumulasiSanksiPelanggaran PRIMARY KEY (akumulasi_sanksi_pelanggaran_id),
);

CREATE TABLE Rules.SanksiPelanggaran
(
    sanksi_pelanggaran_id INT     NOT NULL IDENTITY,
    tingkat               TINYINT NOT NULL,
    sanksi                NVARCHAR(MAX) NOT NULL,
    CONSTRAINT PK_SanksiPelanggaran PRIMARY KEY (sanksi_pelanggaran_id),
    CONSTRAINT FK_SanksiPelanggaran_TingkatPelanggaran FOREIGN KEY (tingkat)
        REFERENCES Rules.TingkatPelanggaran (tingkatan)
)

CREATE TABLE Rules.Pelaporan
(
    pelaporan_id        INT  NOT NULL IDENTITY,
    mahasiswa_id        INT  NOT NULL,
    dosen_id            INT  NOT NULL,
    tanggal_pelaporan   DATE NOT NULL,
    tanggal_pelanggaran DATE NOT NULL,
    klasifikasi_id      INT  NOT NULL,
    deskripsi           NVARCHAR(255) NOT NULL,
    bukti               NVARCHAR(255),
    verifikasi          BIT  NOT NULL DEFAULT 0,
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
    pelanggaran_id INT NOT NULL IDENTITY,
    pelaporan_id   INT NOT NULL,
    sanksi         NVARCHAR(MAX) NOT NULL,
    status         BIT NOT NULL DEFAULT 0,
    CONSTRAINT PK_Pelanggaran PRIMARY KEY (pelanggaran_id),
    CONSTRAINT FK_Pelanggaran_Pelaporan FOREIGN KEY (pelaporan_id)
        REFERENCES Rules.Pelaporan (pelaporan_id)
);