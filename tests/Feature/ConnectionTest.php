<?php

use LJCGrowup\SimpleORM\Connection;

test('Check if getConnection return a PDO object', function () {
    $sqlConfigDB = require './tests/fixtures/database.php';
    
    $connection = Connection::getConnection($sqlConfigDB['sqlite']);
    
    expect($connection)->toBeInstanceOf(PDO::class);
});
