
  <!--Contents-->
  <div class="container ">
    <span class="logo"><img src="img/img_aux/pokemon-logo.png" alt="logo-image" width="350" height="100"></span>
    <h1 class="main-title">Regiones de Pokémon</h1>
    <div class="pokemons-container">
      <table  class="table table-dark table-hover">
        <tbody>
          <tr>
            <th>Nombre de la región</th>
            <th>Versión del juego</th>
          </tr>
      <?php
      $list = '';

      foreach ($game_version as $region_name => $region_info) {
        echo "<tr><td>$region_name <br><a href='/pokemons'><img src='$region_info[map_path]'></a></td>";

        foreach ($region_info as $key => $version_info) {
         $region_map = "$region_info[map_path]";
         
          foreach ($version_info as $key => $value) {
             $list .= "<li>$value[name]</li>";
          }
        }
        
        echo "<td>$list</td>";
        echo "</tr>";
        $list = "";
      }
     
      ?>
        </tbody>
      </table>

    </div>
  </div>

    