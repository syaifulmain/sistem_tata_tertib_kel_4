<?php

function getDatabaseConfig(): array
{
    return [
        "database" => [
            "test" => [
                "url" => "sqlsrv:Server=localhost;Database=sistem_tata_tertib_db_test_new",
                "username" => "sa",
                "password" => "h4mz4hpr09t1"
            ],
            "prod" => [
                "url" => "sqlsrv:Server=localhost;Database=sistem_tata_tertib_db_test",
                "username" => "sa",
                "password" => "1234"
            ],
            "salah" => [
                "url" => "sqlsrv:Server=localhost,1433;Database=salah",
                "username" => "sa",
                "password" => "1234"
            ]
        ]
    ];
}
