<?php

$this->title = 'Médico';
$this->breadcrumb = '/ Médico';

UIHTML::HEADER($this);

$HTML_RENDER = "";

$AButtons = [
    ["javascript:void(0);", "add.png", "REGISTRAR"],
    ["javascript:void(0);", "edit.png", "ACTUALIZAR"],
    ["javascript:void(0);", "file.png", "BUSCAR"],
    [$this->path . "medico/listar", "file.png", "LISTAR"],
];

foreach ($AButtons as $item) {
    $HTML_RENDER .= UIMENU::BUTTONS($item[0], $this->path_img . $item[1], $item[2]);
}

?>

<div class="container-fluid">
    <div class="row mt-5">
        <div class="col-auto m-auto">
            <?php echo $HTML_RENDER ?>
        </div>
    </div>
</div>

<?php UIHTML::FOOTER($this); ?>