<?php
session_start();

// Si el usuario no está autenticado, redirige a la página de inicio
if (!isset($_SESSION["user"])) {
    header("Location: ./");
    exit();
}

// Lógica para obtener y mostrar los bixos y plantas del usuario
$user_bixos = obtener_bixos_del_usuario($_SESSION["iduser"]);
$user_plantas = obtener_plantas_del_usuario($_SESSION["iduser"]);

// Función para obtener los bixos del usuario
function obtener_bixos_del_usuario($usuario_id)
{

    include("conexion.php"); // Incluye el archivo de conexión a la base de datos

    $sql = "SELECT * FROM bixo WHERE user_iduser = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->execute([$usuario_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Función para obtener las plantas del usuario
function obtener_plantas_del_usuario($usuario_id)
{

    include("conexion.php"); // Incluye el archivo de conexión a la base de datos

    $sql = "SELECT * FROM planta WHERE user_iduser = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->execute([$usuario_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>header</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="assets/css/bixoteca.css" />
</head>

<body>
  <header>
    <div class="container-fluid p-5">
      <div class="row">
        <div class="col-md-6 logo d-flex align-items-center">
        <a href="bixoteca.php">
                        <img src="assets/img/logo.png" class="img-fluid rounded-start" alt="logo">
                    </a>
        </div>
        <div class="col-md-6 titulo d-flex align-items-center">
          <div class="ms-md-auto">
            <h5 class="card-title">EVOLUCIONA!!</h5>
            <p class="card-text">El juego más adictivo que hayas conocido</p>
          </div>
          <button class="star-button">&#9733;<span class="info-text"><a href="userdata.php">INFO</a></span></button>

        </div>
      </div>
    </div>
  </header>


<div class="container text-center mt-5">
<h2>Tus Bixos</h2>
<div class="bixos">
    <?php foreach ($user_bixos as $bixo) : ?>
        <div class="bixo">
            <span><?php echo $bixo['bixoname']; ?></span>
            <a href="perfil_bixo.php?idbixo=<?php echo $bixo['idbixo']; ?>">
                <img src="assets/img/bixo.png" alt="Bixo" width="50px" height="50px">
            </a>
            <span><?php echo $bixo['puntosevo']; ?></span>
        </div>
    <?php endforeach; ?>
</div>

<h2>Tus Plantas</h2>
<div class="plantas">
    <?php foreach ($user_plantas as $planta) : ?>
        <div class="planta">
            <span><?php echo $planta['plantaname']; ?></span>
            <a href="perfil_planta.php?idplanta=<?php echo $planta['idplanta']; ?>">
                <img src="assets/img/planta.png" alt="Planta" width="50px" height="50px">
            </a>
            <span><?php echo $planta['puntosevo']; ?></span>
        </div>
    <?php endforeach; ?>
</div>

<form action="creabixo.php" method="post">
    <button type="submit">Crea nuevo bixo</button>
</form>
</div>




<?php include("./templates/footer.php") ?>