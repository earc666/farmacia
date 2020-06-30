<?php 
session_start();
unset($_SESSION['autenticado'] );
unset($_SESSION['id'] );
unset($_SESSION['nombre'] );
unset($_SESSION['email'] );
unset($_SESSION['rol'] );
session_destroy(); //destruye la inormacion cargada en una session.

header('Location: login.php ');