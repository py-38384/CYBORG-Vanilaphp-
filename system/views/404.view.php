<?php
  ob_start();
?>

<div class="container">
  <div class="row">
    <div class="col-lg-12">
      <div class="page-content">
        <h1>404 Not Found</h1>
      </div>
    </div>
  </div>
</div>

<?php
  $slot = ob_get_clean();
  require_once BASE_PATH."/views/layouts/base.view.php";
?>