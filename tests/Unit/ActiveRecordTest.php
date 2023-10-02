<?php

use Tests\Model\Product;

test('Check if table name is correct', function () {
    $sql = (new Product)->find(1);

    expect($sql)
        ->toBe('select * from my_products where id = :id');
});
