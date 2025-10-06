<?php
require_once 'helpers.php';

// Подключение к базе данных
try {
$con = mysqli_connect('mysql', 'root', 'root', 'yeti_cave_db');
} catch (Exception $e) {
    die('Ошибка подключения: ' . $e->getMessage());
}

// Установка кодировки
mysqli_set_charset($con, 'utf8');

// Запрос на получение активных лотов
$sql_lots = '
    SELECT
        l.date_create,
        l.name AS lot_name,
        l.description,
        l.image,
        l.initial_price,
        l.completion_date,
        c.name AS category_name,
        c.code AS category_code
    FROM lots l
    JOIN categories c ON l.category_id = c.id
    WHERE l.completion_date > NOW()
    ORDER BY l.date_create ASC
';

// Запрос на получение категорий
$sql_categories = 'SELECT * FROM categories';

// Выполнение запросов
try {
    $res_lots = mysqli_query($con, $sql_lots);
} catch (Exception $e) {
    die('Ошибка выполнения запроса на получения лотов: ' . mysqli_error($con));
}

try {
    $res_categories = mysqli_query($con, $sql_categories);
    } catch (Exception $e) {
        die('Ошибка выполнения запроса на получения категорий: ' . mysqli_error($con));
}

// Получение данных
    $lots = mysqli_fetch_all($res_lots, MYSQLI_ASSOC);
    $categories = mysqli_fetch_all($res_categories, MYSQLI_ASSOC);

// Закрытие соединения
    mysqli_close($con);

// Установка часового пояса
    date_default_timezone_set("Europe/Moscow");

    $is_auth = rand(0, 1);
    $user_name = 'Сергей';
    $title = 'YetiCave';

    function priceFormat(float $price): string
    {
        $rounded = ceil($price);
        return number_format($rounded, 0, '', ' ') . ' ₽';
    }

    function get_dt_range(string $date): array
    {
        try {
            $date1 = new DateTime();
            $date2 = new DateTime($date);
        } catch (Exception $e) {
            return ['hours' => 0, 'minutes' => 0];
        }

        // Получаем разницу между датами
        $interval = date_diff($date1, $date2);
        // Общее количество часов
        $hours = $interval->days * 24 + $interval->h;
        // Общее количество минут
        $minutes = $interval->i;

        return [
            'hours' => $hours,
            'minutes' => $minutes
        ];
    }

    $main = include_template('main.php', [
        'advertisement' => $lots,
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
