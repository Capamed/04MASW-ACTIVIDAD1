<?php
// require_once '';

?>

<!DOCTYPE html>
<html lang="es">

<head>

    <?php
    include_once "./_shared/head.php";
    ?>

    <title>Menú</title>
</head>

<body>
    <div class="container-fluid">
        <div class="row rowMenuPrincipal justify-content-between">
            <div class="col-auto my-auto">
                <div class="btn-group mr-3">
                    <button id="dropdownMenuButton" class="btn btn-outline-light border-2" type="button" data-bs-toggle="dropdown" style="border-radius: 5px;">
                        <i class="fa-solid fa-bars"></i>
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <li>
                            <a class="dropdown-item" href="./menu.php">
                                Menú Principal
                                <i class="fa-solid fa-house"></i>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="javascript:void(0)">
                                Cerrar Sessión
                                <i class="fa-solid fa-right-from-bracket"></i>
                            </a>
                        </li>
                    </ul>
                </div>
                <span class="fw600" style="margin-left: 15px;">
                    Menú Principal
                </span>
            </div>
            <div class="col-auto d-flex my-auto">
                <div class="d-inline-block">
                    <span class="fw600">Recepcionista</span>
                    <br>
                    <i>Edwin Avila</i>
                </div>
                <div class="d-inline-block">
                    <i class="fa-solid fa-user"></i>
                </div>
            </div>
        </div>
    </div>
    <div id="divBackground"><img src="../assets/img/simbolo-de-la-medicina.png"></div>

    <div class="container-fluid">
        <div class="row mt-5">
            <div class="col-auto m-auto">
                <a class="btn btn-light btn-menu-principal fw700">
                    <img src="../assets/img/doctor.png" class="img-fluid d-block" style="max-height: 110px;">
                    MÉDICOS
                </a>
                <a class="btn btn-light btn-menu-principal fw700">
                    <img src="../assets/img/victima.png" class="img-fluid d-block" style="max-height: 110px;">
                    PACIENTES
                </a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>