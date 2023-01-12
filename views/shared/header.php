<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" />
    <?php
    $d2 = new DateTime();
    $random = $d2->format('YmdHisu');
    echo "<link rel='stylesheet' href='./assets/css/menu.css?v={$random}' />";
    echo "<link rel='stylesheet' href='./assets/css/core.css?v={$random}' />";
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
                            <a class="dropdown-item" href="./index.php">
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
    <div id="divBackground"><img src="./assets/img/simbolo-de-la-medicina.png"></div>




</body>

</html>