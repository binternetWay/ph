<?php
  header("Content-Security-Policy: script-src 'self'");
  
  session_name(md5('ph'.$_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT']));
  session_start();
  session_destroy();

  header('Location: /ph/login');

 ?>