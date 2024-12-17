<?php

function getDatabaseConfig(): array
{
    return [
        "database" => [
            "test" => [
                "url" => "sqlsrv:Server=localhost;Database=sistem_tata_tertib",
                "username" => "sa",
                "password" => "1234"
            ],
            "prod" => [
                "url" => "sqlsrv:Server=localhost;Database=sistem_tata_tertib",
                "username" => "sa",
                "password" => "1234"
            ]
        ]
    ];
}
