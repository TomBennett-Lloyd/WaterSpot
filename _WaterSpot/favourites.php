<?php

  session_start();

  if (!$_SESSION['email']){
    header('Location: index.php');
    die();
  }else{
    echo $_SESSION['email'];
  }


?>
