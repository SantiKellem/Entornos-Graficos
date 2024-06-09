<?php
session_start();
$_SESSION["tipoUsuario"] = "UNR";
?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="../Imagenes-Videos/bolsas-de-compra.png" type="image/png">
  <title>Online Shop</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="../Barra_Navegacion/Bar-style.css">
  <link rel="stylesheet" href="../Pie_De_Pagina/footer.css">
</head>
<body>
  <?php 
    include("../Barra_Navegacion/Nav-bar.php");
  ?>
  <section id="Home" class="section-1">
    <video autoplay loop muted class="video" src="../Imagenes-Videos/Video-principal.mp4"></video>
    <div class="video-opacity">
      <div class="video-title">
        <h1 class="title">Rosario Shopping Center</h1>
        <p class="shopping-description p-delete">Bienvenidos a Rosario Shopping Center.</p>
        <p class="shopping-description">Moda, cine, gastronomía y mucho más! Descubrí el corazón de Rosario.</p>
      </div>
    </div>
  </section>
  <section class="section-2">
    <div class="b1">
      <h2 class="subtitle">Locales</h2>
      <h3 class="locales">NUESTROS LOCALES</h3>
    </div>
    <div id="carouselExample" class="carousel carousel-dark slide d-sm-block contenedor-locales">
      <div class="carousel-inner">
        <div class="carousel-item active">
          <div class="cards-wrapper">
            <div class="card">
              <div class="image-wrapper">
                <img src="../Imagenes-Videos/Nike.jpg" alt="../Imagenes-Videos/Nike.jpg">
              </div>
              <div class="card-body">
                <h5 class="card-title">Card title</h5>
                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the
                  card's content.</p>
                <a href="#" class="btn btn-primary">Go somewhere</a>
              </div>
            </div>
            <div class="card">
              <div class="image-wrapper">
                <img src="../Imagenes-Videos/Nike.jpg" alt="../Imagenes-Videos/Nike.jpg" alt="/Imagenes-Videos/Nike.jpg">
              </div>
              <div class="card-body">
                <h5 class="card-title">Card title</h5>
                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the
                  card's content.</p>
                <a href="#" class="btn btn-primary">Go somewhere</a>
              </div>
            </div>
            <div class="card">
              <div class="image-wrapper">
                <img src="../Imagenes-Videos/Nike.jpg" alt="/Imagenes-Videos/Nike.jpg" alt="/Imagenes-Videos/Nike.jpg">
              </div>
              <div class="card-body">
                <h5 class="card-title">Card title</h5>
                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the
                  card's content.</p>
                <a href="#" class="btn btn-primary">Go somewhere</a>
              </div>
            </div>
          </div>
        </div>
        <div class="carousel-item">
          <div class="cards-wrapper">
            <div class="card">
              <div class="image-wrapper">
                <img src="../Imagenes-Videos/McDonalds.jpg" alt="Sucursal Mc Donald's">
              </div>
              <div class="card-body">
                <h5 class="card-title">Card title</h5>
                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the
                  card's content.</p>
                <a href="#" class="btn btn-primary">Go somewhere</a>
              </div>
            </div>
            <div class="card">
              <div class="image-wrapper">
                <img src="../Imagenes-Videos/Starbucks.jpg" alt="Sucursal Starbucks">
              </div>
              <div class="card-body">
                <h5 class="card-title">Card title</h5>
                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the
                  card's content.</p>
                <a href="#" class="btn btn-primary">Go somewhere</a>
              </div>
            </div>
            <div class="card">
              <div class="image-wrapper">
                <img src="../Imagenes-Videos/Showcase.jpg" alt="/Imagenes-Videos/Showcase.jpg">
              </div>
              <div class="card-body">
                <h5 class="card-title">Card title</h5>
                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the
                  card's content.</p>
                <a href="#" class="btn btn-primary">Go somewhere</a>
              </div>
            </div>
          </div>
        </div>
        <div class="carousel-item">
          <div class="cards-wrapper">
            <div class="card">
              <div class="image-wrapper">
                <img src="../Imagenes-Videos/Starbucks.jpg" alt="/Imagenes-Videos/Starbucks.jpg">
              </div>
              <div class="card-body">
                <h5 class="card-title">Card title</h5>
                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the
                  card's content.</p>
                <a href="#" class="btn btn-primary">Go somewhere</a>
              </div>
            </div>
            <div class="card">
              <div class="image-wrapper">
                <img src="../Imagenes-Videos/Starbucks.jpg" alt="/Imagenes-Videos/Starbucks.jpg">
              </div>
              <div class="card-body">
                <h5 class="card-title">Card title</h5>
                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the
                  card's content.</p>
                <a href="#" class="btn btn-primary">Go somewhere</a>
              </div>
            </div>
            <div class="card">
              <div class="image-wrapper">
                <img src="../Imagenes-Videos/Starbucks.jpg" alt="/Imagenes-Videos/Starbucks.jpg">
              </div>
              <div class="card-body">
                <h5 class="card-title">Card title</h5>
                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the
                  card's content.</p>
                <a href="#" class="btn btn-primary">Go somewhere</a>
              </div>
            </div>
          </div>
        </div>
      </div>
      <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
      </button>
    </div>
  </section>
  <section class="section-3" id="About us">
    <div class="b1">
      <h2 class="subtitle">EL SHOPPING</h2>
      <img class="image-wrapper shopping-image" src="../Imagenes-Videos/Imagen-Shopping.jpg" alt="">
      <p class="informacion">
        Rosario Shopping Center se erige en la vibrante ciudad de Rosario. Nuestro centro comercial, situado cerca del hermoso Parque Scalabrini Ortiz, combina lo mejor de la historia y la modernidad de la ciudad, ofreciendo una experiencia de compras y entretenimiento única.
        Con más de 70 marcas de primera línea, Rosario Shopping Center es tu destino ideal para indumentaria femenina y masculina, accesorios, marroquinería, decoración y mucho más. Nos enorgullece ofrecer una gran variedad de opciones que satisfacen todos los gustos y necesidades, garantizando una experiencia de compra inigualable tanto para los residentes locales como para los visitantes.
        Ven y descubre todo lo que Rosario Shopping Center tiene para ofrecerte. ¡Te esperamos para vivir una experiencia única en compras y entretenimiento!
      </p>
    </div>
  </section>
  
<?php 
  include("../Pie_De_Pagina/footer.php");
?>

</body>

</html>