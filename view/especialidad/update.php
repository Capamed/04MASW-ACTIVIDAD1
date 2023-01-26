<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Especialidad</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
  </head>
  <body>
    <h1 class="text-center p-3">Actualizar Especialidad</h1>
    <div class="container-fluid">
        <form method="POST">
            <div class="mb-3">
                <label for="inputId" class="form-label">Id Especialidad</label>
                
                <input type="tex" name="idEspecialidad" required class="form-control" id="inputId" >
            </div>
            <div class="mb-3">
                <label for="inputNombre" class="form-label">Nuevo Nombre Especialidad</label>
                <input type="text" name="nombreEspecialidad" required class="form-control" id="inputNombre">
            </div>
            
            <button type="submit" class="btn btn-primary" name="btnRegistrar" value="ok">Guardar</button>
            <a href="/index.php" class="btn btn-danger">Cancelar</a>
            <?php
                if(!empty($_POST["btnRegistrar"])){
                    require_once("/Users/marcotintinduran/Desktop/prueba1/controller/especialidadController.php");
                    $controller = new especialidadController();
                    echo "pedido";
                    $controller->update($_POST["idEspecialidad"],$_POST["nombreEspecialidad"]);
                }
            ?>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    </body>
</html>