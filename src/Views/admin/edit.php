<?php

$this->getTemplateFunctions();

getHeader($data);

$model = $data['model'];
$items = $data['items'];
$urlManager = $data['urlManager'];
$errors = $data['errors'];

if (is_array($items)) {
    $items = removeTopLevelIndex($items);
    $levels = [];
    foreach ($items as $item) {
        $levels[] = $item->level;
    }
    $maxLevel = max($levels);
}

?>
<div class="container">

    <?php if ($flash = flash()): ?>
        <p class="message <?= $flash['type'] ?>"><?= $flash['message'] ?></p>
    <?php endif ?>

    <?php if (!empty($errors)) {
        foreach ($errors as $error) {
            ?>
            <p class="message danger"><?= $error ?></p>
            <?php
        }
    } ?>

    <div class="form-wrapper">
        <?php
        $action = $model->id ? 'admin/edit?id=' . $model->id : 'admin/edit';
        ?>
        <form action="<?= $urlManager->action($action); ?>" method="POST" class="form from_edit">
            <input type="hidden" name="id" value="<?= $model->id ?? 0 ?>">
            <div class="form__row">
                <label for="name"><?= $model->formFields()['name'] ?></label>
                <input type="text" id="name" name="name" value="<?= $model->name ?? "" ?>" />
            </div>
            <div class="form__row">
                <label for="description"><?= $model->formFields()['description'] ?></label>
                <textarea type="text" name="description" name="description" rows="16"><?=
                    $model->description
                ?></textarea>
            </div>
            <div class="form__row">
                <label for="parent_id"><?= $model->formFields()['parent_id'] ?></label>
                <select id="parent_id" name="parent_id" value="<?= $model->parent_id ?>" class="level-<?= $model->level ?>">
                    <?php if ($model->id == 0): ?>
                        <option selected disabled hidden>Выберите родителя</option>
                    <?php endif; ?>
                        <option value="0" class="level-0 text-italic">Начальный уровень</option>
                    <?php if (is_array($items)): ?>
                        <?php foreach ($items as $item): ?>
                            <?php if ($item->id == $model->id) continue; ?>
                            <option
                                value="<?= $item->id ?>" <?php if ($model->parent_id == $item->id) echo "selected"; ?>
                                class="level-<?= $item->level ?>"
                            >
                                <?php for ($i=0; $i < $item->level; $i++): ?>
                                    &emsp;
                                <?php endfor; ?>
                                <?= $item->name ?>
                            </option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </div>
            <button type="submit" name="save" class="form__btn button d-block ml-auto mt-1">Сохранить</button>
            <?php if ($model->id): ?>
                <button type="submit" name="delete" class="form__btn button d-block ml-auto mt-1">Удалить</button>
            <?php endif; ?>
        </form>
    </div>

</div>

<?php

getFooter();
