<?php

use LJCGrowup\SimpleORM\Connection;

test('Check if open method get connection', function () {
    $connection = Connection::getConnection(__DIR__.'/../fixtures/sqlite.ini');
    
    expect($connection)->toBeInstanceOf(PDO::class);
});
