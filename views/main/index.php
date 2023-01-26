<!DOCTYPE html>
<html lang="en">

<head>
  <link rel="stylesheet" href="assets/css/style-index.css">
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>

<body>
  <video autoplay muted loop id="myVideo">
    <source src="assets/img/videoBackground.mp4" type="video/mp4">
    Your browser does not support HTML5 video.
  </video>
  <img src="assets/img/developer.png" alt="imagen-representacion" width="159px"
    style="position: absolute;left: 95px;border-radius: 50%;" id="imgCambiar">
  <img src="assets/img/developer.png" alt="imagen-representacion" width="159px"
    style="position: absolute;right: 95px;border-radius: 50%;" id="imgCambiarDos">
  <div class="Menu">
    <ul class="Menu-list">
      <li class="Menu-list-item" onmouseover="cambiarImagen('A')" onmouseout="cambiarImagen('D')" onclick="window.location='./home'">
        Actividad
        <span class="Mask"><span>Actividad</span></span>
        <span class="Mask"><span>Actividad</span></span>
      </li>
      <li class="Menu-list-item" onmouseover="cambiarImagen('N')" onmouseout="cambiarImagen('D')" onclick="window.location='./nosotros'">
        Nosotros
        <span class="Mask"><span>Nosotros</span></span>
        <span class="Mask"><span>Nosotros</span></span>
      </li>
      <a href="https://github.com/Capamed/04MASW-ACTIVIDAD1" target="_blank">
        <li class="Menu-list-item" onmouseover="cambiarImagen('R')" onmouseout="cambiarImagen('D')">
          Repositorio
          <span class="Mask"><span>Repositorio</span></span>
          <span class="Mask"><span>Repositorio</span></span>
        </li>
      </a>
      <a href="https://www.universidadviu.com/es/" target="_blank">
        <li class="Menu-list-item" onmouseover="cambiarImagen('V')" onmouseout="cambiarImagen('D')">
          VIU
          <span class="Mask"><span>VIU</span></span>
          <span class="Mask"><span>VIU</span></span>
        </li>
      </a>
    </ul>
  </div>
</body>
<script src="assets/js/actions-index.js"></script>
</html>