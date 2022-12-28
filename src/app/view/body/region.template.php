
<h1 class="main-title">Regiones de Pokémon</h1>
<!--Contents-->
<div class="container ">

  <?php

  foreach ($regions_info as $region_name => $region_info) {
    echo "
      <div class='card w-75 mx-auto my-5 p-1'>
        <div class='row g-0'>
          <div class='col-md-4'>
            <a class='h-100 d-flex' href='/regions/pokemons'>
              <img src='$region_info[map_path]' class='card-img-top align-self-center' alt='Map of $region_name'>
            </a>
          </div>
          <div class='col-md-8'>
            <div class='card-body'>
              <h3 class='card-title'>".ucfirst($region_name)."</h3>
              <ul class='list-group'>";
                foreach($region_info['game_version'] as $version){
                  echo "<li class='list-group-item'>$version[name]</li>";
                }
    echo "    </ul>
            </div>
          </div>
        </div>
      </div>";

  }

  ?>


</div>