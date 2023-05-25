<?php

function treeStructureAdmin($treeItems, $parentId, $level, $urlManager)
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
            $output .= '<a href="' . $urlManager->action('admin/edit?id=' . $item->id ) . '" class="list-btn pencil"></a>';
            if (isset($treeItems[$item->id])) {
                $output .= '<span class="list-btn expand"></span>';
            }
            $output .= "<div class=\"description d-none\">{$item->description}</div>";
            $level++;
            $output .= treeStructureAdmin($treeItems, $item->id, $level, $urlManager);
            $level--;
            $output .= '</li>';
        }

        $output .= "</ul>";

        return $output;
    }
}

function createOptionsOfItemsTree($treeItems, $parentId, $level, $model)
{
    if (isset($treeItems[$parentId])) {
        foreach ($treeItems[$parentId] as $item):
            if ($item->id == $model->id): ?>
                <option <?= "disabled"; ?> class="level-<?= $item->level ?>">
                    <?php
                    for ($i = 0; $i < $item->level; $i++) {
                        echo ($i > 0 ? '&ndash;&nbsp;' : "");
                    } ?>
                    <?= $item->name ?>
                </option>
                <?php
                continue;
            endif; ?>
            <option
                value="<?= $item->id ?>" <?php if ($model->parent_id == $item->id) echo "selected"; ?>
                class="level-<?= $item->level ?>"
            >
                <?php
                for ($i = 0; $i < $item->level; $i++) {
                    echo ($i > 0 ? '&ndash;&nbsp;' : "");
                } ?>
                <?= $item->name ?>
            </option>
            <?php
            createOptionsOfItemsTree($treeItems, $item->id, $level, $model);
        endforeach;
    }
}

function removeTopLevelIndex(array $items)
{
    return array_reduce($items, function ($new, $item) {
        if (is_array($item)) {
            foreach($item as $k => $v) {
                $new[] = $v;
            }
        }
        return $new;
    }, []);
}

