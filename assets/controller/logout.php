<?php
  header("Content-Security-Policy: script-src 'self'");
  
  session_destroy();

  header('Location: index.php?msg=erro');

 ?>