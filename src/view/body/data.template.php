<div class="container ">
  <span class="logo"><img src="../img/img_aux/pokemon-logo.png" alt="logo-image" width="350" height="100"></span>
  <h1 class="main-title">Aquí están todos los datos de los Pokémons</h1>
  <div class="table-responsive-lg">

    <table id="data-table" class="table table-dark table-hover">
      
        <?php
        echo $pokemon_table["header"];
        echo $pokemon_table["body"];
        ?>
      
    </table>
  </div>
</div>