<!--Contents-->
<div class="container ">
  <h1 class='main-title'>Pokémons iniciales</h1>
  <div class="pokemons-img-container">
    <div class="initial-pokemons">
      <?php

use function Config\get_app_dir;

      $map_path = get_app_dir() . '/../../public/img/regions_map';

      foreach ($pokemons_images as $region_name => $value) {
        echo "<h1 class='region-name text-center mt-3'>$region_name</h1>";
        echo "<div class='col-6 mx-auto m-3'>";
        echo "<img src='../img/regions_map/$region_name.webp' class='img-fluid'>";
        echo "</div>";
        echo "<div class='rounded-3 pokemon_images d-flex justify-content-center'>";

        foreach ($value as $img) {

          echo "<div class='pokemons-name text-center'>";
          echo "<img src='../$img' class='poke-img' title=''>";
          echo "</div>";
        }
        echo "</div>";
      }
      ?>
    </div>
  </div>
</div>
<!-- /dwes/pokemon_php/src/app/../../public/img/regions_map/johto.webp" -->
<!-- img/regions_map/johto.webp -->