<?php

function getDatabaseConfig(): array
{
    return [
        "database" => [
            "test" => [
                "url" => "mysql:host=localhost:32769;dbname=percetakan_db_test",
                "username" => "root",
                "password" => ""
            ],
            "prod" => [
                "url" => "mysql:host=localhost:32769;dbname=percetakan_db",
                "username" => "root",
                "password" => "1234"
            ]
        ]
    ];
}
