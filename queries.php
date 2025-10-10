<?php

/**
 * @throws Exception
 */
function getCategories($db_con): array
{
    $sql = "SELECT * FROM categories";
    try {
        $res_categories = mysqli_query($db_con, $sql);

        if (!$res_categories) {
            throw new Exception('Ошибка выполнения SQL-запроса: ' . mysqli_error($db_con));
        }

        return mysqli_fetch_all($res_categories, MYSQLI_ASSOC);
    } catch (Exception $e) {
        throw new Exception('Ошибка получения категорий: ' . $e->getMessage());
    }
}

/**
 * @throws Exception
 */
function getLotById($db_con, int $lot_id): ?array
{
    $sql = 'SELECT
               l.date_create,
               l.name,
               l.description,
               l.image,
               l.initial_price,
               l.completion_date,
               l.step_size,
               c.name AS category_name
             FROM lots l
             JOIN categories c ON l.category_id = c.id
             WHERE l.id = ?';

    $stmt = mysqli_prepare($db_con, $sql);

    if (!$stmt) {
        throw new Exception('Ошибка подготовки SQL-запроса: ' . mysqli_error($db_con));
    }
    mysqli_stmt_bind_param($stmt, 'i', $lot_id);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    if (!$result) {
        throw new Exception('Ошибка получения результата: ' . mysqli_error($db_con));
    }

    return mysqli_fetch_assoc($result) ?: null;
}

/**
 * @throws Exception
 */
function getActiveLots($db_con): array
{
// Запрос на получение активных лотов
    $sql = 'SELECT l.id,
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
             ORDER BY l.date_create ASC';

    try {
        $res_lots = mysqli_query($db_con, $sql);

        if (!$res_lots) {
            throw new Exception('Ошибка выполнения SQL-запроса: ' . mysqli_error($db_con));
        }

        return mysqli_fetch_all($res_lots, MYSQLI_ASSOC);
    } catch (Exception $e) {
        throw new Exception('Ошибка получения активных лотов: ' . $e->getMessage());
    }
}
