<?php

use Repository\TreeItemsRepository;

$this->checkAccess();

$treeItems = new TreeItemsRepository($this->db);

$items = $treeItems->findAll();

$this->view('admin/index', [
    'title' => 'Дашборд',
    'items' => $items
]);
