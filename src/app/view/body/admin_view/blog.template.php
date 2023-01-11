<h1 class="main-title"> Blog de notícias </h1>

<div class="container">
  <!--Visible para admin(podría ser un modal)-->
<div class="card my-4 w-sm-100 w-75 m-auto">
  <div class="m-2">
    <h3 class="mt-3">Añade una nueva notícia</h3>
    <form method="POST">
      <div class="col-4 col-lg-2 mb-3">
        <label for="date" class="form-label">Fecha</label>
        <input type="date" class="form-control" name="date">
      </div>
      <div class="mb-3">
        <label for="title" class="form-label">Título de la notícia</label>
        <input type="text" class="form-control" name="title">
      </div>
      <div class="mb-3">
        <label for="content" class="form-label">Contenido de la notícia</label>
        <textarea class="form-control" aria-label="announcment content" name="content"></textarea>
      </div>
      <div class="mb-3">
        <button type="submit" class="btn btn-success mt-3">Añadir</button>
      </div>
    </form>
  </div>
</div>

  <!-- Dinamic announcements -->
  <?php
  foreach ($announcements as $announcement) {
    echo "
    <div class='card my-4 w-sm-100 w-75 m-auto'>
        <div class='card-body m-2'>
            <h4 class='card-title'>$announcement[title]</h4>
            <p class='card-subtitle mb-2 text-muted'>$announcement[date] · $announcement[autor]</p>
            <p class='card-text'>$announcement[content]</p>
        </div>
    </div>
    ";
  }
  ?>

</div>