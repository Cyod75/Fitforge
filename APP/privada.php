<?php 

session_start();
if(!isset($_SESSION['usuario'])){
    header('location:login.php');
    die();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../CSS/bootstrap.css" rel="stylesheet">
    <title>Document</title>
</head>
<body>
    <h1>holaa <?php echo $_SESSION['usuario']; ?></h1> 
    <a class="btn btn-danger" href = '../AUTH/logout.php'>Cerrar Sesión</a>
</body>
</html>