<?php

$this->title = 'Nosotros';
$this->breadcrumb = '/ Nosotros';

UIHTML::HEADER($this);

$HTML_RENDER = "";
?>

<div class="container-fluid">
    <div class="row mt-5" style="text-align: center">
        <!-- <div class="col-auto m-auto">
            <?php echo $HTML_RENDER ?>
        </div> -->
        <div class="col-4" style="text-align: -webkit-center;">
            <div class="card border-warning mb-3" style="max-width: 18rem;">
                <img class="card-img-top" src="assets/img/nosotrosSergio.png" alt="Card image cap">
                <div class="card-header">EDWIN AVILA</div>
                <div class="card-body text-warning">
                    <h5 class="card-title">Sobre Edwin..</h5>
                    <p class="card-text">Estudiante de la UNIVERSIDAD INTERNACIONAL DE VALENCIA, cursando la maestria Desarrollo de aplicaciones y servicios web, materia Lado del servidor (back-end).</p>
                </div>
            </div>
        </div>
        <div class="col-4" style="text-align: -webkit-center;">
            <div class="card border-danger mb-3" style="max-width: 18rem;">
                <img class="card-img-top" src="assets/img/nosotrosMarco.png" alt="Card image cap">
                <div class="card-header">MARCO TINTIN</div>
                <div class="card-body text-danger">
                    <h5 class="card-title">Sobre Marco..</h5>
                    <p class="card-text">Estudiante de la UNIVERSIDAD INTERNACIONAL DE VALENCIA, cursando la maestria Desarrollo de aplicaciones y servicios web, materia Lado del servidor (back-end).</p>
                </div>
            </div>
        </div>
        <div class="col-4" style="text-align: -webkit-center;">
        <div class="card border-success mb-3" style="max-width: 18rem;">
                <img class="card-img-top" src="assets/img/nosotrosEdwin.png" alt="Card image cap">
                <div class="card-header">SERGIO PAZ</div>
                <div class="card-body text-success">
                    <h5 class="card-title">Sobre Sergio..</h5>
                    <p class="card-text">Estudiante de la UNIVERSIDAD INTERNACIONAL DE VALENCIA, cursando la maestria Desarrollo de aplicaciones y servicios web, materia Lado del servidor (back-end).</p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php UIHTML::FOOTER($this); ?>