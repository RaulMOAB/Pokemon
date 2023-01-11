<h1 class="main-title"> Pokemon Data </h1>

<div class="container">
<form method="POST" class="mt-3 mb-3">
  <h4 class="text-white">Añade un nuevo Pokémon</h4>
  <div class="row">
  <div class="col-lg-2 col-sm-6  mt-sm-3 mb-sm-3">
      <input type="text" class="form-control" placeholder="Num"  name="#">
    </div>
    <div class="col-lg-2 col-sm-6 mt-sm-3 mb-sm-3">
      <input type="text" class="form-control" placeholder="Name"  name="Name">
    </div>
    <div class="col-lg-2 col-sm-6 mt-sm-3 mb-sm-3">
      <input type="text" class="form-control" placeholder="Type 1" name="Type 1">
    </div>
    <div class="col-lg-2 col-sm-6 mt-sm-3 mb-sm-3">
      <input type="text" class="form-control" placeholder="Type 2" name="Type 2">
    </div>
    <div class="col-lg-2 col-sm-6 mt-sm-3 mb-sm-3">
      <input type="text" class="form-control" placeholder="Total" name="Total">
    </div>
  </div>
  <div class="row mt-3">
    <div class="col-lg-2 col-sm-6 mt-sm-3 mb-sm-3">
      <input type="text" class="form-control" placeholder="Health points" name="HP">
    </div>
    <div class="col-lg-2 col-sm-6 mt-sm-3 mb-sm-3">
      <input type="text" class="form-control" placeholder="Attack points" name="Attack">
    </div>
    <div class="col-lg-2 col-sm-6 mt-sm-3 mb-sm-3">
      <input type="text" class="form-control" placeholder="Defense points" name="Defense">
    </div>
    <div class="col-lg-2 col-sm-6 mt-sm-3 mb-sm-3">
      <input type="text" class="form-control" placeholder="Speed attack" name="Sp. Atk">
    </div>
    <div class="col-lg-2 col-sm-6 mt-sm-3 mb-sm-3">
      <input type="text" class="form-control" placeholder="Speed defense" name="Sp. Def">
    </div>
  </div>
  <div class="row mt-3">
    <div class="col-lg-2 col-sm-6 mt-sm-3 mb-sm-3">
      <input type="text" class="form-control" placeholder="Speed" name="Speed">
    </div>
    <div class="col-lg-2 col-sm-6 mt-sm-3 mb-sm-3">
      <input type="text" class="form-control" placeholder="Generation" name="Generation">
    </div>
    <div class="col-lg-2 col-sm-6 mt-sm-3 mb-sm-3">
      <input type="text" class="form-control" placeholder="Legendary" name="Legendary">
    </div>
  </div>
  <div class="row mt-3 mb-3">
    <div class="col">
      <button type="submit" class="btn btn-success">Añadir</button>
    </div>
  </div>
</form>
</div>

<div class="container">

  <table class="mx-auto table table-bordered table-primary table-striped table-sm">
    <?php

    require_once(__DIR__ . '/../../../config.php');
    use function Config\get_view_dir;

    require_once(__DIR__ . '/../../../model/model.php');
    use function Model\get_body;
    use function Model\get_header;

    require_once(get_view_dir() . '/view.php');
    $header = get_header($pokemon_table->header);
    $body = get_body($pokemon_table->body);
    echo $header;
    echo $body;
    ?>

  </table>
</div>