<h1 class="main-title">Bienvenidos a Pokephp</h1>
<div class="container">
  <h2 class="main-title">Esto es un trabajo de Desarrollo de Aplicaciones Web Entorno Servidor de la uf3 y nosotros somos:</h2>

  <div class="row justify-content-center">
    <div class="col-4">
      <ul class="fs-2">
        <?php
        foreach ($contributors as $contributor) {
          echo "<li class='text-white'>$contributor</li>";
        }
        ?>
      </ul>
    </div>
  </div>
</div>