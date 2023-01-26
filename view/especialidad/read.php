<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Especialidad</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/c8dc26926f.js" crossorigin="anonymous"></script>
</head>
  <body>
    <h1 class="text-center p-3">Registro Especialidad</h1>
    <?php
        require_once("/Users/marcotintinduran/Desktop/prueba1/controller/especialidadController.php");
        $controller = new especialidadController();
        print_r($controller->read($_GET['id']));
        $datos=$controller->read($_GET['id']);
    ?>

    <div class="container-fluid">
        <a href="/index.php" class="btn btn-primary">Regresar</a>
    </div>

    <table class="table container-fluid">
                <thead class="bg-light">
                    <tr>
                    <th scope="col">Id</th>
                    <th scope="col">Nombre</th>
                    <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php    
                        foreach($datos as list($idEspecialidad,$nombreEspecialidad)) {?>
                        <tr>
                            <th scope="row"><?= $idEspecialidad?></th>
                            <td scope="row"><?= $nombreEspecialidad?></td>
                            <td>
                                <a href="update.php?id=<?= $idEspecialidad ?>" class="btn btn-small btn-secondary"><i class="fa-solid fa-pen-to-square"></i></a>
                                <a class="btn btn-small btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="fa-solid fa-trash-can"></i></a>
                                <!-- Modal -->
                                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Desea eliminar el Registro</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        Una vez eliminado no se podra recuperar el registro <?= $idEspecialidad ?>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-success" data-bs-dismiss="modal">Cerrar</button>
                                        <a href="delete.php?id=<?=$idEspecialidad?>" class="btn btn-danger">Eliminar</a>
                                    </div>
                                    </div>
                                </div> 
                                </div>
                            </td>
                        </tr>
                    <?php } 
                    ?>
                </tbody>
            </table>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    </body>
</html>