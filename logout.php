<?php
session_start();
session_unset();
session_destroy();
header("Location: /real_estate_esystem/login.php");

exit;
?>