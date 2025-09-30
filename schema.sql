# создаем базу данных
CREATE DATABASE yeti_cave_db
  DEFAULT CHARACTER SET utf8mb4
  DEFAULT COLLATE utf8mb4_unicode_ci;

# переключаемся на созданную базу
USE yeti_cave_db;

# таблица категорий
CREATE TABLE categories
(
  id   INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255) NOT NULL UNIQUE,
  code VARCHAR(50)  NOT NULL UNIQUE
);

# таблица пользователей
CREATE TABLE users
(
  id          INT AUTO_INCREMENT PRIMARY KEY,
  date_create TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  email       VARCHAR(255) NOT NULL UNIQUE,
  name        VARCHAR(255) NOT NULL,
  password    VARCHAR(255) NOT NULL,
  contact     VARCHAR(255),
  lot_id      INT          NULL,
  wager_id    INT          NULL
);

# таблица лотов
CREATE TABLE lots
(
  id              INT AUTO_INCREMENT PRIMARY KEY,
  date_create     TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  name            VARCHAR(255)   NOT NULL,
  description     TEXT           NOT NULL,
  image           VARCHAR(255)   NOT NULL,
  initial_price   DECIMAL(10, 2) NOT NULL,
  completion_date DATE           NOT NULL,
  step_size       DECIMAL(10, 2) NOT NULL,
  user_author_id  INT            NOT NULL,
  user_victory_id INT            NULL,
  category_id     INT            NOT NULL,

  FOREIGN KEY (user_author_id) REFERENCES users (id),
  FOREIGN KEY (category_id) REFERENCES categories (id),
  FOREIGN KEY (user_victory_id) REFERENCES users (id)
);

# таблица ставок
CREATE TABLE wagers
(
  id          INT AUTO_INCREMENT PRIMARY KEY,
  date_create TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  sum         DECIMAL(10, 2) NOT NULL,
  user_id     INT            NOT NULL,
  lot_id      INT            NOT NULL,

  FOREIGN KEY (user_id) REFERENCES users (id),
  FOREIGN KEY (lot_id) REFERENCES lots (id)
);

# индексы
CREATE INDEX idx_lots_name ON lots (name);
CREATE INDEX idx_lots_completion_date ON lots (completion_date);
CREATE UNIQUE INDEX idx_users_email ON users (email);
CREATE INDEX idx_wagers_lot_id ON wagers (lot_id);
CREATE INDEX idx_wagers_user_id ON wagers (user_id);
CREATE INDEX idx_wagers_date_create ON wagers (date_create);


