<?php

$this->title = 'Home';
$this->breadcrumb = '/ Home';

UIHTML::HEADER($this);

$HTML_RENDER = "";

$AButtons = [
    [$this->path . "especialidad/listar", "especialidad.png", "ESPECIALIDAD"],
    [$this->path . "medico/listar", "doctor.png", "MÉDICOS"],
    [$this->path . "paciente/listar", "victima.png", "PACIENTES"],
    // [$this->path . "color/listar", "blank.png", "COLORES"],
    [$this->path . "enfermero/listar", "enfermera.png", "ENFERMEROS"],
    [$this->path . "cita/listar", "agenda.png", "AGENDAR"],
    [$this->path . "historial/listar", "history.png", "HISTORIAL"],
    [$this->path . "reporte/index", "blank.png", "REPORTES"],
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