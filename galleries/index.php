<?php

/**
 * Created by PhpStorm.
 * User: grigorib
 * Date: 2/22/20
 * Time: 99999.9 PM
 */


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

$left = "left";
$middle = "";
$right = "right";

require_once($BASE_DIR . "/csb-content/template_functions.php");

loadHeader();
load3Col($left, $middle, $right, "template_Show-User.php");
loadFooter();
