
<!--Contents-->
<div class="container ">
  <h1 class='main-title'>Pokémons iniciales</h1>
  <div class="pokemons-img-container">
    <div class="initial-pokemons">
      <?php

use function Config\get_app_dir;

      foreach ($pokemons_images as $region_name => $value) {
        echo "<h1 class='region-name text-center mt-3'>$region_name</h1>";
        echo "<div class='rounded-3 pokemon_images d-flex'>";

        foreach ($value as $img) {
          //$name = getPokemonName($img);
          echo "<div class='pokemons-name text-center'>";
          echo "<img src='../$img' class='poke-img' title=''>";
          //echo "<p>$name</p>";
          echo "</div>";
        }
        echo "</div>";
      }


      ?>
    </div>
  </div>
</div>