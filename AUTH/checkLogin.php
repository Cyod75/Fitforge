<?php
session_start();

$usuario = $_POST['usuario'];
$password = $_POST['contraseña'];

$mysql = new mysqli('localhost','root','garrapata','fitforge');

$query ="SELECT * FROM usuarios WHERE nombre='$usuario' and clave='$password'";
$usuariosBD = $mysql->query($query);

if($usuariosBD->num_rows == 1){
    $_SESSION['usuario'] = $usuario;
    header('location:../APP/inicio.php');
}else{
    header('location:login.php');
}

?>