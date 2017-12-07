<?php

setcookie("WebmasterSavedLogin", "", time() - 100, "/");
setcookie("WebmasterSavedPassword", "", time() - 100, "/");
header('Location: http://managehospital.ga');
exit;

?>