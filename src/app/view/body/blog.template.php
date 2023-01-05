<h1 class="main-title"> Blog de notícias </h1>

<div class="container">
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