<?php

use LJCGrowup\SimpleORM\Connection;

test('check if open method return a PDO object', function () {
    $sqlConfigDB = require './tests/fixtures/database.php';
    
    $connection = Connection::open($sqlConfigDB['sqlite']);
    
    expect($connection)->toBeInstanceOf(PDO::class);
});

test('check if transaction is working', function () {
    $sqlConfigDB = require './tests/fixtures/database.php';
    
    Connection::open($sqlConfigDB['sqlite']);
    $beginResult = Connection::beginTransaction();
    $rollbackResult = Connection::rollback();

    expect($beginResult)->toBeTrue();
    expect($rollbackResult)->toBeTrue();
});


