<?php
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
