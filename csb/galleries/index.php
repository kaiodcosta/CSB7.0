<?php
/* ----------------------------------------------------------------------
   Get the settings and check if the person is logged in
   ---------------------------------------------------------------------- */

require_once("../csb-loader.php");
require_once($DB_class);
require_once($ACC_DIR . "auth.php");


/* ----------------------------------------------------------------------
Is the person logged in?
    ---------------------------------------------------------------------- */

$db = new DB($db_servername, $db_username, $db_password, $db_name);

global $user;
$user = isLoggedIn($db);

// if $login isn't set, set it to avoid a PHP notice.
if (!isset($login)) {
    $login = FALSE;
}

/* ----------------------------------------------------------------------
Load the view
    ---------------------------------------------------------------------- */
if (isset($login)) {
    $left = $user['name'];
} else {
    $left = "Login to see more options";
}

$middle = "";
$right = "click on an image to open it";

require_once($BASE_DIR . "/csb-content/template_functions.php");

loadHeader();
load3Col($left, $middle, $right, "template_Show-Images.php", $BASE_DIR."galleries/templates/");
loadFooter();
