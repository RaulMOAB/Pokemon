<div class="container ">
      <span class="logo"><img src="../img/img_aux/pokemon-logo.png" alt="logo-image" width="350" height="100"></span>
      <h1 class="main-title">Bienvenidos a Pokephp</h1>
      <h2 class="main-title">Esto es un trabajo de Desarrollo de Aplicaciones Web Entorno Servidor de la uf3 y nosotros somos:</h2>
      <ul class="names">
      <?php   
            foreach ($contributors as $contributor) {       
              echo "<li class='text-white'>$contributor</li>";
            }
        ?>
      </ul>
</div>