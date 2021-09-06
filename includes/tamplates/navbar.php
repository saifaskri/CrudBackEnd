<!-- starting navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">Logo</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="index.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="?was=show">Items</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="?was=MangeUser">MangeUsers</a>
        </li>
      </ul>
      <li class="nav-item dropdown mymargin-log_out">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <?= USER_INFO[0]["username"]?>
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="#">Modify Account</a></li>
            <li><a class="dropdown-item" href="?was=log_out">Log Out</a></li>
          </ul>
        </li>
    </div>
  </div>
</nav>
<!--end navbar -->