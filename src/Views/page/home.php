<?php

$this->getTemplateFunctions();

getHeader($data);

$items = $data['items'];
$urlManager = $data['urlManager'];

?>
<div class="container">
    <?php if (count($items) > 0): ?>
        <div class="mt-1 mb-1">
            <input type="checkbox" id="checkbox" name="tree_collapse" unchecked />
            <label for="checkbox">Раскрыть все уровни</label>
        </div>
    <?php endif; ?>
    <?php
        echo treeStructure($data['items'], 0, 0);
    ?>
</div>

<div class="modal" id="modal">
    <div class="modal__backdrop"></div>
    <div class="modal__body">
        <button class="modal__close" id="close">Закрыть</button>
        <h2 class="modal__title modalTitle"></h2>
        <div class="modal__content modalContent"></div>
    </div>
</div>
<?php

getFooter($data);
