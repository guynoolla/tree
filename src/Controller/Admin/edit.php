<?php

use Repository\TreeItemsRepository;
use Models\TreeItem;

$this->checkAccess();

$treeItemsRepo = new TreeItemsRepository($this->db);

$items = $treeItemsRepo->findAll();
$items = TreeItem::setLevelForEvery($items);
$model = new TreeItem();

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    if (isset($_GET['id'])) {
        $model = $treeItemsRepo->find($_GET['id']);
        if (!$model->id) {
            $this->redirect('/');
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $model->fill($_POST);

    if (isset($_POST['save'])) {
        if (!($errors = $model->errors())) {
            $scenario = (!$model->id) ? 'create' : 'update';
            if ($r = $treeItemsRepo->save($model)) {
                if ($scenario == 'create') {
                    $model->id = $r;
                }
                $message = $scenario == 'update' ? 'Запись обновлена' : 'Запись добавлена';
                flash('success', $message);
                $action = $model->id ? 'admin/edit?id=' . $model->id : 'admin/edit';
                $this->redirect($action);
            }
        }
    } elseif (isset($_POST['delete'])) {
        if ($treeItemsRepo->delete($model)) {
            flash('success', 'Удалено!');
            $this->redirect('admin/index');
        }
    }
}

$this->view('admin/edit', [
    'errors' => $errors ?? false,
    'title' => 'Редактировать',
    'items' => $items,
    'model' => $model
]);
