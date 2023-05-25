<?php

function treeStructure($treeItems, $parentId, $level)
{
    if (isset($treeItems[$parentId])) {
        if ($parentId > 0) {
            $output = '<ul class="tree-items-list hide">';
        } else {
            $output = '<ul class="tree-items-list root">';
        }

        foreach ($treeItems[$parentId] as $item) {
            $output .= '<li class="list-item">';
            $output .= "<a href=\"#\" class=\"title open-modal\">{$item->name}</a>";
            if (isset($treeItems[$item->id])) {
                $output .= '<span class="list-btn expand"></span>';
            }
            $output .= "<div class=\"description d-none\">{$item->description}</div>";
            $level++;
            $output .= treeStructure($treeItems, $item->id, $level);
            $level--;
            $output .= '</li>';
        }
        $output .= "</ul>";

        return $output;
    }
}

function getHeader(array $data=[])
{
    $urlManager = $data['urlManager'];
    $user = $data['user'];
    $path = $data['path'];

    ?>
    <!DOCTYPE html>
    <html>
        <head>
            <meta charset="utf-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <title><?= $data['title'] ?? "" ?></title>
            <meta name="description" content="">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <link rel="stylesheet" href="<?= $urlManager->css('main') ?>">
            <link rel="stylesheet" href="<?= $urlManager->css('admin') ?>">
        </head>
        <body>
            <header>
                <div class="container">
                    <nav class="nav">
                        <a href="<?= $urlManager->action('/') ?>" class="mr-auto <?= ($path == '' ? 'active' : ""); ?>">Главная</a>
                        <?php if ($user): ?>
                            <a href="<?= $urlManager->action('admin/index') ?>" class="<?= ($path == 'admin/index' ? 'active' : "") ?>">Дашборд</a>
                            <a href="<?= $urlManager->action('process/logout') ?>">Выйти</a>
                        <?php endif; ?>
                    </nav>
                    <?php if ($user): ?>
                        <div>
                            <p class="user"><strong><?= $user->username ?></strong></p>
                        </div>
                    <?php endif; ?>
                    <p class="message message_right danger d-none" id="loginErrorMsg"></p>
                    <?php if ($flash = flash()): ?>
                        <p class="message message_right <?= $flash['type'] ?>"><?= $flash['message'] ?></p>
                    <?php endif; ?>
                    <?php if (!$user): ?>
                        <form id="loginForm" action="<?= $urlManager->action('process/login') ?>" method="POST" class="form form_auth">
                            <div class="form__col">
                                <label for="name">Логин</label>
                                <input id="name" type="text" name="username" value="" />
                            </div>
                            <div class="form__col">
                                <label for="password">Пароль</label>
                                <input id="password" type="password" name="password" value="" />
                            </div>
                            <button type="submit" name="submit" class="form__btn">Войти</button>
                        </form>
                    <?php endif; ?>
                    <h1>Интерактивное дерево с неограниченной вложенностью элементов</h1>
                </div>
            </header>
            <main class="content">
    <?php
}

function getFooter(array $data=[])
{
    ?>
        </main>
        <footer>
            <div class="container">
                <p>&copy; Guynoolla, 2023</p>
            </div>
        </footer>

        <script src="<?= $data['urlManager']->js('main') ?>" async defer></script>
    </body>
    </html>
    <?php
}
