<?php
/**
 * Created by PhpStorm.
 * User: starstryder
 * Date: 6/9/19
 * Time: 1:49 PM
 */

/* ----------------------------------------------------------------------
   Get the settings and check if the person is logged in
   ---------------------------------------------------------------------- */

require_once("../csb-loader.php");
require_once($DB_class);
require_once($ACC_DIR . "auth.php");

$page_title = "science";


/* ----------------------------------------------------------------------
   Is the person logged in?
   ---------------------------------------------------------------------- */

$db = new DB($db_servername, $db_username, $db_password, $db_name);

global $user;
$user = isLoggedIn($db);

if ($user === FALSE) { // NOT LOGGED IN
    $left = "menus";
    $main = "This page requires you to be logged in.";
    $right = "no right yet";


} /* ----------------------------------------------------------------------
   Do they have the correct role?
   ---------------------------------------------------------------------- */

elseif (!($_SESSION['roles'] >= $CQ_ROLES['SITE_SCIENTIST'] &&
        $CQ_ROLES['SITE_SUPERADMIN'] >= $_SESSION['roles'])) {
    // TODO be a bit politer when rejecting nosy users
    $left = "menus";
    $main = "We're sorry, you don't have permissions to be on this page";
    $right = "no right yet";

} /* ----------------------------------------------------------------------
   Load the view
   ---------------------------------------------------------------------- */

else { // they clearly have permissions
    global $page_title;

    $dir = $BASE_DIR . "/science/tasks";
    $listings = array_diff(scandir($dir), array('..', '.'));


    $left = "<h3>Options</h3>\n";
    $left .= "<ul>";
    foreach ($listings as $item) {
        $left .= "<li><a href='" . $_SERVER['SCRIPT_NAME'] . "?task=$item'>".str_replace('-', ' ', $item)."</a></li>";
    }
    $left .= "</ul>";

    // Is a value set?  Check if task exists. If yes, execute. Else, instructions!
    $task = basename(filter_input(INPUT_GET, 'task', FILTER_SANITIZE_FULL_SPECIAL_CHARS, 0));
    if ($task !== NULL && file_exists($BASE_DIR . "science/tasks/" . $task . "/" . $task . ".php")) {
        require_once($BASE_DIR . "science/tasks/" . $task . "/" . $task . ".php");
    } else {
        error_log("Somebody tried to call the science task {$task}");
        $main =  "Select a task to do from the lefthand menu";
    }

}

require_once($BASE_DIR . "/csb-content/template_functions.php");

loadHeader();
load3Col($left, $main, "More Stuff", $template_name, $template_path);
loadFooter();
