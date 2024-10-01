<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
?>
<!DOCTYPE html>
<html lang="pt_br">

<head>
    <meta charset="utf-8" />
    <link rel="icon" href="img/icon.png" type="image/x-icon">
    <title>NaOng</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta content="" name="keywords" />
    <meta content="" name="description" />

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500;600&family=Playfair+Display:wght@400;500;600&display=swap"
        rel="stylesheet" />

    <!-- Icon Font Stylesheet -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet" />

    <!-- Libraries Stylesheet -->
    <link href="lib/animate/animate.min.css" rel="stylesheet" />
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet" />

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet" />
</head>

<body>
    <!-- Spinner Start -->
    <!-- <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
    <div class="spinner-border text-primary" style="width: 3rem; height: 3rem" role="status">
      <span class="sr-only">Loading...</span>
    </div>
  </div> -->
    <!-- Spinner End -->

    <!-- Topbar Start -->
    <!-- <div class="container-fluid bg-dark px-5 d-none d-lg-block">
    <div class="row gx-0 align-items-center" style="height: 45px">
      <div class="col-lg-8 text-center text-lg-start mb-lg-0">
        <div class="d-flex flex-wrap">
          <a href="#" class="text-light me-4"><i class="fas fa-map-marker-alt text-primary me-2"></i>Find A
            Location</a>
          <a href="#" class="text-light me-4"><i class="fas fa-phone-alt text-primary me-2"></i>+01234567890</a>
          <a href="#" class="text-light me-0"><i class="fas fa-envelope text-primary me-2"></i>Example@gmail.com</a>
        </div>
      </div>
      <div class="col-lg-4 text-center text-lg-end">
        <div class="d-flex align-items-center justify-content-end">
          <a href="#" class="btn btn-light btn-square border rounded-circle nav-fill me-3"><i class="fab fa-facebook-f"></i></a>
          <a href="#" class="btn btn-light btn-square border rounded-circle nav-fill me-3"><i class="fab fa-twitter"></i></a>
          <a href="#" class="btn btn-light btn-square border rounded-circle nav-fill me-3"><i class="fab fa-instagram"></i></a>
          <a href="#" class="btn btn-light btn-square border rounded-circle nav-fill me-0"><i class="fab fa-linkedin-in"></i></a>
        </div>
      </div>
    </div>
  </div> -->
    <!-- Topbar End -->

    <!-- Navbar & Hero Start -->
    <div class="container-fluid position-relative p-0">
        <nav class="navbar navbar-expand-lg navbar-light bg-white px-4 px-lg-5 py-3 py-lg-0">
            <a href="index.php" class="navbar-brand p-0">
                <h1 class="text-primary m-0"><i class="fa fa-star-of-life me-3"></i>NaOng</h1>
                <!-- <img src="img/logo.png" alt="Logo"> -->
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                <span class="fa fa-bars"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <div class="navbar-nav ms-auto py-0">

                    <a href="index.php" class="nav-item nav-link">Home</a>
                    <a href="pesquisa_mapa.php" class="nav-item nav-link">Pesquisar Ongs</a>
                    <a href="como_doar.php" class="nav-item nav-link">Como doar</a>

                    <?php if (isset($_SESSION['user_id']) && isset($_SESSION['user_role'])) { ?>
                    <a href="cadastro_publicacao.php" class="nav-item nav-link">Publicação</a>

                    <?php if ($_SESSION['user_role'] == 'ong') { ?>
                    <a href="consulta_coleta.php" class="nav-item nav-link">Consulta Pontos de Coleta</a>
                    <?php } ?>

                    <?php if ($_SESSION['user_role'] == 'doador') { ?>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Doações</a>
                        <div class="dropdown-menu m-0">
                            <a href="cadastro_registro_doacao.php" class="dropdown-item">Registrar</a>
                            <a href="lista_registro_doacao.php" class="dropdown-item">Listar</a>
                        </div>
                    </div>
                    <?php } ?>

                    <?php if ($_SESSION['user_role'] == 'adm') { ?>
                    <a href="departamento.php" class="nav-item nav-link">Departamento</a>
                    <a href="consulta_coleta.php" class="nav-item nav-link">Consulta Pontos de Coleta</a>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Doações</a>
                        <div class="dropdown-menu m-0">
                            <a href="cadastro_registro_doacao.php" class="dropdown-item">Registrar</a>
                            <a href="lista_registro_doacao.php" class="dropdown-item">Listar</a>
                        </div>
                    </div>
                    <a href="cadastro_banner.php" class="nav-item nav-link">Cadastrar Banner</a>
                    <?php } ?>
                    <?php } ?>


                    <?php if (isset($_SESSION['user_id']) && isset($_SESSION['user_role'])) { ?>
                    <a href="logout.php" class="nav-item nav-link">Logout</a>
                    <?php } else { ?>
                    <a href="cadastro.php" class="nav-item nav-link">Cadastro</a>
                    <?php } ?>
                    <!-- <a href="about.html" class="nav-item nav-link">About</a>
                <a href="service.html" class="nav-item nav-link">Services</a>
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Pages</a>
                    <div class="dropdown-menu m-0">
                        <a href="appointment.html" class="dropdown-item">Appointment</a>
                        <a href="feature.html" class="dropdown-item">Features</a>
                        <a href="blog.html" class="dropdown-item">Our Blog</a>
                        <a href="team.html" class="dropdown-item">Our Team</a>
                        <a href="testimonial.html" class="dropdown-item">Testimonial</a>
                        <a href="404.html" class="dropdown-item">404 Page</a>
                    </div>
                </div>
                <a href="contact.html" class="nav-item nav-link">Contact Us</a> -->
                </div>
                <?php 
                if (isset($_SESSION['user_id']) && isset($_SESSION['user_role'])) {
                    if ($_SESSION['user_role'] !== 'adm') { ?>
                      <a href="perfil_<?php echo $_SESSION['user_role']; ?>.php"
                          class="btn btn-primary rounded-pill text-white py-2 px-4 flex-wrap flex-sm-shrink-0">Perfil</a>
                      <?php }
                } else { ?>
                <a href="login.php"
                    class="btn btn-primary rounded-pill text-white py-2 px-4 flex-wrap flex-sm-shrink-0">LOGIN</a>
                <?php } ?>
            </div>
        </nav>
    </div>

    <!-- Navbar End -->