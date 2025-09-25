<?php
require_once 'helpers.php';

$is_auth = rand(0, 1);

$user_name = 'Сергей';

$title = 'YetiCave';

$categories = ['Доски и лыжи', 'Крепления', 'Ботинки', 'Одежда', 'Инструменты', 'Разное'];

$advertisement = [
    [
        'name' => '2014 Rossignol District Snowboard',
        'categories' => $categories[0],
        'cost' => 1099.5,
        'image' => 'img/lot-1.jpg'
    ],
    [
        'name' => 'DC Ply Mens 2016/2017 Snowboard',
        'categories' => $categories[0],
        'cost' => 159999,
        'image' => 'img/lot-2.jpg'
    ],
    [
        'name' => 'Крепления Union Contact Pro 2015 года размер L/XL',
        'categories' => $categories[1],
        'cost' => 8000.67,
        'image' => 'img/lot-3.jpg'
    ],
    [
        'name' => 'Ботинки для сноуборда DC Mutiny Charocal',
        'categories' => $categories[2],
        'cost' => 10999,
        'image' => 'img/lot-4.jpg'
    ],
    [
        'name' => 'Куртка для сноуборда DC Mutiny Charocal',
        'categories' => $categories[3],
        'cost' => 7500.6,
        'image' => 'img/lot-5.jpg'
    ],
    [
        'name' => 'Маска Oakley Canopy',
        'categories' => $categories[5],
        'cost' => 5400,
        'image' => 'img/lot-6.jpg'
    ]
];

function priceFormat(float $price): string
{
    $rounded = ceil($price);
    return number_format($rounded, 0, '', ' ') . ' ₽';
}

$main = include_template('main.php', [
    'advertisement' => $advertisement,
    'categories' => $categories,
]);

$page_content = include_template('layout.php', [
    'main' => $main,
    'categories' => $categories,
    'user_name' => $user_name,
    'is_auth' => $is_auth,
    'title' => $title
]);

print($page_content);
