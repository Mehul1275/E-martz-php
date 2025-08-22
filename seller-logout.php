<?php
session_start();
unset($_SESSION['seller']);
session_write_close();
header('Location: index.php');
exit; 