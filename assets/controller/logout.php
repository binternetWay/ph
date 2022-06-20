<?php
  header("Content-Security-Policy: script-src 'self'");
  
  session_name(md5('ph'.$_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT']));
  session_start();
  session_destroy();

  session_name(md5('ph_primario'.$_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT']));
  session_start();

  if (isset($_SESSION['msg'])) {
    $msg = $_SESSION['msg'];
  }

  session_destroy();

  session_name(md5('ph_primario'.$_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT']));
  session_start();

  $_SESSION['msg'] = $msg;

  header('Location: login');

 ?>