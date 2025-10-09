<?php
$base_dir = __DIR__;
require_once realpath($base_dir . '/helpers.php') ?: die('Файл helpers.php не найден');
require_once realpath($base_dir . '/db.php') ?: die('Файл db.php не найден');
require_once realpath($base_dir . '/functions.php') ?: die('Файл functions.php не найден');
require_once realpath($base_dir . '/queries.php') ?: die('Файл queries.php не найден');

$db_con = connect();

// Установка часового пояса
date_default_timezone_set("Europe/Moscow");

$is_auth = rand(0, 1);
$user_name = 'Сергей';
$title = 'YetiCave';

$source = $_GET['source'] ?? null;
switch ($source) {
    case 'lot':
        // Получение id лота из GET запроса и проверка на корректность типа и значения id
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        if (!$id) {
            http_response_code(404);
            $page_content = include_template('404.php');
            print($page_content);
            exit;
        }

        $categories = getCategories($db_con);
        $lot = getLotById($db_con, $id);
        if(!$lot){
            http_response_code(404);
            $page_content = include_template('404.php');
            print($page_content);
            exit;
        }

        $pageLot = include_template('lot.php', [
            'lot' => $lot
        ]);

        break;

    default:
        $lots = getActiveLots($db_con);
        $categories = getCategories($db_con);
        $main = include_template('main.php', [
            'advertisement' => $lots,
            'categories' => $categories,
        ]);
}

$page_content = include_template('layout.php', [
    'main' => $main ?? '',
    'pageLot' => $pageLot ?? '',
    'categories' => $categories ?? [],
    'user_name' => $user_name,
    'is_auth' => $is_auth,
    'title' => $title
]);

print($page_content);
