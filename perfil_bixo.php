<?php
session_start();

// Si el usuario no está autenticado, redirige a la página de inicio
if (!isset($_SESSION["user"])) {
    header("Location: ./");
    exit();
}
if(!isset($_GET["idbixo"])){
    header("Location: ./");
    exit();
}

include("conexion.php"); // Incluye el archivo de conexión a la base de datos

$iduser = $_SESSION["iduser"];
$idbixo = $_GET["idbixo"];
$sql = "SELECT b.*,h.* FROM bixo as b 
left join bixo_habs as bh on b.idbixo=bh.idbixo
left join habilidad as h on h.idhab=bh.idhab
WHERE b.idbixo = ? and b.user_iduser= ?";

$stmt = $conexion->prepare($sql);
$stmt->bindParam(1, $idbixo);
$stmt->bindParam(2, $iduser);
$stmt->execute();
$habilidades = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<span><?php echo $habilidades[0]["bixoname"]; ?></span>

<span><?php echo $habilidades[0]["ataque"] + $habilidades[0]["habataque"]; ?></span>

<span><?php echo $habilidades[0]["defensa"]; ?></span>

<span><?php echo $habilidades[0]["instinto"]; ?></span>

<span><?php echo $habilidades[0]["poblacion"]; ?></span>

<span><?php echo $habilidades[0]["puntosevo"]; ?></span>

<div>
    <?php foreach ($habilidades as $habilidad) : ?>
        <div class="bixo_habilidad">
            <span><?php echo $habilidad['habname']; ?></span>
            
            <img src="assets/img/<?php echo $habilidad['habimg']; ?>.png" alt="<?php echo $habilidad['habname']; ?>" width="50px" height="50px">
            
            <span><?php echo $habilidad['habdescrip']; ?></span>
        </div>
    <?php endforeach; ?>
</div>




