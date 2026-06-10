<?php

session_start();

session_destroy();

header("Location: darling.php");
exit;