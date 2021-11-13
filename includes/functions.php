<?php
include_once "config.php";

// page нужен для того чтобы был а не одна страница а также допы к котрой мы юудеи приклеивать
function get_url($page = '')
{
  // в двойные кавычик можно поставить переменные
  return HOST . "/$page";
}

// лучше всего чтоб было одно подключение к БД
function db()
{
  try {
    return new PDO(
      "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8",
      DB_USER,
      DB_PASS,
      [
        PDO::ATTR_EMULATE_PREPARES => false,
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
      ]
    );
  } catch (PDOException $e) {
    die($e->getMessage());
  }
}

function db_query($sql, $exec = false)
{
  if (empty($sql)) return false;

  if ($exec) return db()->exec($sql);

  return db()->query($sql);
}

function get_posts($user_id = 0)
{
  if ($user_id > 0) return db_query("SELECT posts.*,users.name,users.login,users.avatar FROM `posts` JOIN `users` ON users.id = posts.user_id WHERE posts.user_id = $user_id");

  return db_query("SELECT posts.*,users.name,users.login,users.avatar FROM `posts` JOIN `users` ON users.id = posts.user_id");
}
