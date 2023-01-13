<?php

$this->title = 'Home';
$this->breadcrumb = '/ Home';

UIHTML::HEADER($this);

$HTML_RENDER = "";

$AButtons = [
    [$this->path . "medico/listar", "doctor.png", "MÉDICOS"],
    [$this->path . "paciente", "victima.png", "PACIENTES"],
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