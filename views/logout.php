<?php
session_start();
session_destroy();
header('Location: /tache/index.php?action=login');
exit();
?>
