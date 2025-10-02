USE yeti_cave_db;

-- Отключаем проверку внешних ключей для безопасной очистки таблиц
SET FOREIGN_KEY_CHECKS = 0;

-- Очистка таблиц
TRUNCATE TABLE categories;
TRUNCATE TABLE lots;
TRUNCATE TABLE users;
TRUNCATE TABLE wagers;

-- Включаем обратно проверку внешних ключей
SET FOREIGN_KEY_CHECKS = 1;

-- Вставка категорий
INSERT INTO categories (name, code)
VALUES ('Доски и лыжи', 'boards'),
       ('Крепления', 'attachment'),
       ('Ботинки', 'boots'),
       ('Одежда', 'clothing'),
       ('Инструменты', 'tools'),
       ('Разное', 'other');

-- Вставка пользователей
INSERT INTO users (id, date_create, email, name, password, contact)
VALUES (1, '2025-03-18 18:00:00', 'ignat.v@gmail.com', 'Игнат', SHA2('ignat', 256), '89239423121'),
       (2, '2024-03-18 18:00:00', 'kitty_93@li.ru', 'Леночка', SHA2('kitty', 256), '89239423122'),
       (3, '2025-06-18 18:00:00', 'warrior07@mail.ru', 'Руслан', SHA2('warrior', 256), '89239423123'),
       (4, '2024-10-18 18:00:00', 'alex@yandex.ru', 'Александр', SHA2('start', 256), '89239423124'),
       (5, '2025-09-18 18:00:00', 'evgeny@yandex.ru', 'Евгений', SHA2('finish', 256), '89239423125'),
       (6, '2025-09-10 18:00:00', 'sergey@gmail.com', 'Сергей', SHA2('test', 256), '89239423126');

-- Вставка лотов
INSERT INTO lots (id, date_create, name, description, image, initial_price, completion_date, step_size, user_author_id, category_id)
VALUES (1, '2025-09-19 18:00:00', '2014 Rossignol District Snowboard', 'Сноуборд',
        'img/lot-1.jpg', 10999, '2025-11-14', 100, 1, 1),
       (2, '2025-09-20 13:00:00', 'DC Ply Mens 2016/2017 Snowboard', 'Сноуборд',
        'img/lot-2.jpg', 159999, '2025-11-10', 100, 1, 1),
       (3, '2025-09-18 15:00:00', 'Крепления Union Contact Pro 2015 года размер L/XL', 'Крепления',
        'img/lot-3.jpg', 8000, '2025-11-12', 100, 1, 2),
       (4, '2025-09-18 11:00:00', 'Ботинки для сноуборда DC Mutiny Charocal', 'Ботинки',
        'img/lot-4.jpg', 10999, '2025-12-18', 100, 2, 3),
       (5, '2025-09-10 03:00:00', 'Куртка для сноуборда DC Mutiny Charocal', 'Куртка',
        'img/lot-5.jpg', 7500, '2025-12-28', 100, 2, 4),
       (6, '2025-09-18 17:00:00', 'Маска Oakley Canopy', 'Маска',
        'img/lot-6.jpg', 5400, '2025-11-28', 100, 3, 5);

-- Вставка ставок
INSERT INTO wagers (id, date_create, sum, user_id, lot_id)
VALUES (1, '2025-10-01 18:00:00', 11500, 4, 1),
       (2, '2025-09-26 18:00:00', 160100, 5, 2),
       (3, '2025-09-27 18:00:00', 6000, 6, 6),
       (4, '2025-10-02 13:00:00', 160200, 4, 2);

-- Получить все категории
SELECT * FROM categories;

-- Получить самые новые открытые лоты
SELECT name, initial_price, image
FROM lots
WHERE completion_date > NOW()
ORDER BY date_create DESC
LIMIT 3;

-- Получить лот по его ID с категорией
SELECT l.name, l.description, l.initial_price, c.name
FROM lots l
JOIN categories c ON l.category_id = c.id
WHERE l.id = 6;

-- Обновить название лота по его идентификатору
UPDATE lots
SET name = 'Куртка для сноуборда'
WHERE id = 5;

-- Получить список ставок для лота по его идентификатору
SELECT *
FROM wagers w
JOIN lots l ON w.lot_id = l.id
WHERE l.id = 2
ORDER BY w.date_create DESC;
