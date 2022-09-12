CREATE DATABASE task_force
    DEFAULT CHARACTER SET utf8
    DEFAULT COLLATE utf8_general_ci;

CREATE TABLE cities (
    city_id INT PRIMARY KEY AUTO_INCREMENT,
    city_name VARCHAR(50) NOT NULL,
    city_latitude VARCHAR(255),
    city_longitude VARCHAR(255)
);

CREATE TABLE categories (
    category_id INT PRIMARY KEY AUTO_INCREMENT,
    category_name VARCHAR(30) NOT NULL
);

CREATE TABLE customers (
    customer_id INT PRIMARY KEY AUTO_INCREMENT,
    customer_name VARCHAR(50) NOT NULL,
    customer_email VARCHAR(255) NOT NULL UNIQUE,
    customer_password CHAR(255) NOT NULL,
    customer_avatar VARCHAR(255) UNIQUE,
    customer_date_add DATETIME NOT NULL
);

CREATE TABLE executors (
    executor_id INT PRIMARY KEY AUTO_INCREMENT,
    executor_name VARCHAR(50) NOT NULL,
    executor_email VARCHAR(255) NOT NULL UNIQUE,
    executor_password CHAR(255) NOT NULL,
    executor_avatar VARCHAR(255) UNIQUE,
    executor_date_add DATETIME NOT NULL,
    city_id INT,
    executor_phone VARCHAR(11) UNIQUE,
    executor_telegram VARCHAR(64) UNIQUE,
    personal_information VARCHAR(255),
    count_tasks INT UNSIGNED,
    executor_rating FLOAT (2,1) UNSIGNED,
    executor_status TINYINT DEFAULT 0 check (executor_status in (0, 1)),
    executor_birthday DATETIME,
    FOREIGN KEY (city_id) REFERENCES cities (city_id)
);

CREATE TABLE executors_categories (
    id INT PRIMARY KEY AUTO_INCREMENT,
    executor_id INT NOT NULL,
    category_id INT NOT NULL,
    FOREIGN KEY (executor_id) REFERENCES executors (executor_id) ON DELETE CASCADE,
    FOREIGN KEY (category_id) REFERENCES categories (category_id) ON DELETE CASCADE,
    UNIQUE KEY relation_row_unique (category_id, executor_id)
);

CREATE TABLE tasks (
    task_id INT PRIMARY KEY AUTO_INCREMENT,
    customer_id INT NOT NULL,
    executor_id INT,
    category_id INT NOT NULL,
    city_id INT,
    task_name VARCHAR(50) NOT NULL,
    task_essence VARCHAR(80) NOT NULL,
    task_details VARCHAR(255) NOT NULL,
    task_budget INT UNSIGNED,
    task_latitude VARCHAR(255),
    task_longitude VARCHAR(255),
    task_date_create DATETIME NOT NULL,
    task_status TINYINT DEFAULT 0,
    task_deadline DATETIME,
    FOREIGN KEY (customer_id) REFERENCES customers (customer_id),
    FOREIGN KEY (executor_id) REFERENCES executors (executor_id),
    FOREIGN KEY (category_id) REFERENCES categories (category_id),
    FOREIGN KEY (city_id) REFERENCES cities (city_id)
);

CREATE TABLE files (
    file_id INT PRIMARY KEY AUTO_INCREMENT,
    task_id INT,
    task_file_name VARCHAR(255) NOT NULL UNIQUE,
    FOREIGN KEY (task_id) REFERENCES tasks (task_id)
);

CREATE TABLE executors_tasks (
    id INT PRIMARY KEY AUTO_INCREMENT,
    executor_id INT NOT NULL,
    task_id INT NOT NULL,
    FOREIGN KEY (executor_id) REFERENCES executors (executor_id) ON DELETE CASCADE,
    FOREIGN KEY (task_id) REFERENCES tasks (task_id) ON DELETE CASCADE,
    UNIQUE KEY relation_row_unique (task_id, executor_id)
);

CREATE TABLE reviews (
    review_id INT PRIMARY KEY AUTO_INCREMENT,
    customer_id INT NOT NULL,
    executor_id INT NOT NULL,
    grade TINYINT UNSIGNED NOT NULL,
    review VARCHAR(255),
    FOREIGN KEY (customer_id) REFERENCES customers (customer_id),
    FOREIGN KEY (executor_id) REFERENCES executors (executor_id) ON DELETE CASCADE
);
