<?php require_once $GLOBALS["PATH_HEADER"] ?>

<?php
$HTML_RENDER = "";

$AButtons = [
    ["./medico", "doctor.png", "MÉDICOS"],
    ["javascript:void(0);", "victima.png", "PACIENTES"],
];

foreach ($AButtons as $item) {
    $HTML_RENDER .= UIMENU::BUTTONS($item[0], $GLOBALS['PATH_IMG'] . $item[1], $item[2]);
}

?>

<div class="container-fluid">
    <div class="row mt-5">
        <div class="col-auto m-auto">
            <?php echo $HTML_RENDER ?>
        </div>
    </div>
</div>

<?php require_once $GLOBALS["PATH_FOOTER"] ?>