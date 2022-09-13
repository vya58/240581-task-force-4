<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use app\widgets\Alert;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;

AppAsset::register($this);

$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no']);
$this->registerMetaTag(['name' => 'description', 'content' => $this->params['meta_description'] ?? '']);
$this->registerMetaTag(['name' => 'keywords', 'content' => $this->params['meta_keywords'] ?? '']);
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/x-icon', 'href' => '@web/favicon.ico']);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Taskforce</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<header class="page-header">
    <nav class="main-nav">
        <a href='#' class="header-logo">
            <img class="logo-image" src="img/logotype.png" width=227 height=60 alt="taskforce">
        </a>
        <div class="nav-wrapper">
            <ul class="nav-list">
                <li class="list-item list-item--active">
                    <a class="link link--nav" >Новое</a>
                </li>
                <li class="list-item">
                    <a href="#" class="link link--nav" >Мои задания</a>
                </li>
                <li class="list-item">
                    <a href="#" class="link link--nav" >Создать задание</a>
                </li>
                <li class="list-item">
                    <a href="#" class="link link--nav" >Настройки</a>
                </li>
            </ul>
        </div>
    </nav>
    <div class="user-block">
        <a href="#">
            <img class="user-photo" src="img/man-glasses.png" width="55" height="55" alt="Аватар">
        </a>
        <div class="user-menu">
            <p class="user-name">Василий</p>
            <div class="popup-head">
                <ul class="popup-menu">
                    <li class="menu-item">
                        <a href="#" class="link">Настройки</a>
                    </li>
                    <li class="menu-item">
                        <a href="#" class="link">Связаться с нами</a>
                    </li>
                    <li class="menu-item">
                        <a href="#" class="link">Выход из системы</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</header>
<main class="container container--registration">
        <?php $content ?>
    <div class="center-block">
        <div class="registration-form regular-form">
            <form>
                <h3 class="head-main head-task">Регистрация нового пользователя</h3>
                <div class="form-group">
                    <label class="control-label" for="username">Ваше имя</label>
                    <input id="username" type="text">
                    <span class="help-block">Error description is here</span>
                </div>
                <div class="half-wrapper">
                    <div class="form-group">
                        <label class="control-label" for="email-user">Email</label>
                        <input id="email-user" type="email">
                        <span class="help-block">Error description is here</span>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="town-user">Город</label>
                        <select id="town-user">
                            <option>Москва</option>
                            <option>Санкт-Петербург</option>
                            <option>Владивосток</option>
                        </select>
                        <span class="help-block">Error description is here</span>
                    </div>
                </div>
                <div class="half-wrapper">
                <div class="form-group">
                    <label class="control-label" for="password-user">Пароль</label>
                    <input id="password-user" type="password">
                    <span class="help-block">Error description is here</span>
                </div>
                </div>
                <div class="half-wrapper">

                <div class="form-group">
                    <label class="control-label" for="password-repeat-user">Повтор пароля</label>
                    <input id="password-repeat-user" type="password">
                    <span class="help-block">Error description is here</span>
                </div>
                </div>
                <div class="form-group">
                    <label class="control-label checkbox-label" for="response-user">
                        <input id="response-user" type="checkbox" checked>
                        я собираюсь откликаться на заказы</label>
                </div>
                <input type="submit" class="button button--blue" value="Создать аккаунт">
            </form>
        </div>
    </div>
</main>
</body>
</html>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
