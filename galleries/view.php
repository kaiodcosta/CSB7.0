<?php
/**
 * Created by Grigori Burlea.
 * User: grigorib
 * Date: 2/22/20
 * Time: 99999.9 PM
 */

GLOBAL $db;

    $image_name = $_GET['image_name'];
    $img_id = $_GET['img_id'];

    $mysqli = mysqli_connect('localhost','csb','1password2ruleALL','csb');

    $query = "SELECT x, y, diameter, image_id FROM marks WHERE type='crater' AND image_id = ".$img_id;

    $image_data = mysqli_query($mysqli, $query);

    $x_values = array();
    $y_values = array();
    $diameter_values = array();

    // get image data
    foreach ($image_data as $imagedata) {
        // store x, y values into arrays
        $x_values[] = $imagedata['x'];
        $y_values[] = $imagedata['y'];
        $diameter_values[] = $imagedata['diameter'];
    }

    $query = "SELECT details FROM marks WHERE type='boulder' AND image_id = ".$img_id;

    $image_data = mysqli_query($mysqli, $query);

    $x1_values = array();
    $y1_values = array();
    $x2_values = array();
    $y2_values = array();

    // get image data
    foreach ($image_data as $imagedata) {
        $details = json_decode($imagedata['details'], TRUE);
        // store x, y tuples into arrays
        $x1_values[] = $details['points'][0]['x'];
        $y1_values[] = $details['points'][0]['y'];
        $x2_values[] = $details['points'][1]['x'];
        $y2_values[] = $details['points'][1]['y'];
    }

    // get users' names and display them
    $query = "SELECT user_id FROM marks WHERE image_id = ".$img_id;
    $user_data = mysqli_query($mysqli, $query);
    $user_ids = array();

    foreach ($user_data as $userdata) {

//      echo $userdata['user_id']
        $user_id = $userdata['user_id'];
        $user_ids[] = $user_id;

//        $query = "SELECT name FROM `csb`.`users` WHERE id =".$userdata['user_id'];
//        $credentials = mysqli_query($mysqli, $query);
//        $user_info = mysqli_query($mysqli, $query);
    }

    foreach ($user_ids as $userid) {
        ?>
            <p><?php echo $userid?></p>
        <?php
    }

//    foreach ($credentials as $credential) {
//        ?>
<!--            <p>--><?php //echo $credential['name']?><!--</p>-->
<!--        --><?php
//    }

//    $query = "SELECT * FROM `csb`.`users`";
//    $users = mysqli_query($mysqli, $query);
//    foreach ($user as $users) {
//    }
?>

<script>
    function Main() {
        DrawCraters(0);
        DrawBoulders(0);
    }

    // Draw boulders recursive function
    function DrawBoulders(items_no) {
        // get arrays
        var x1_arr = <?php echo json_encode($x1_values); ?>;
        var y1_arr = <?php echo json_encode($y1_values); ?>;
        var x2_arr = <?php echo json_encode($x2_values); ?>;
        var y2_arr = <?php echo json_encode($y2_values); ?>;

        let flag = false;

        // base case
        if(items_no === (x1_arr.length - 1)) {
            flag = true;
        }

        var img = document.getElementById('user_img');
        var c = document.getElementById("myCanvas");
        var ctx = c.getContext("2d");

        // canvas for drawing. uses coordinates, sets the styles and draws
        ctx.beginPath();
        ctx.moveTo(x1_arr[items_no], y1_arr[items_no]);
        ctx.lineTo(x2_arr[items_no], y2_arr[items_no]);
        ctx.lineWidth = 2;
        ctx.strokeStyle = '#90FF20';
        ctx.stroke();

        items_no++;

        if(flag === false) {
            DrawBoulders(items_no);
        }
    }

    // Draw craters recursive function
    function DrawCraters(items_no) {
        // get arrays
        var x_arr = <?php echo json_encode($x_values); ?>;
        var y_arr = <?php echo json_encode($y_values); ?>;
        var diameter_arr = <?php echo json_encode($diameter_values); ?>;

        let flag = false;

        // base case
        if(items_no === (x_arr.length - 1)) {
            flag = true;
        }

        var img = document.getElementById('user_img');
        var cnv = document.getElementById('myCanvas');
        var ctx = cnv.getContext("2d");

        // canvas for drawing. uses coordinates, sets the styles and draws
        cnv.style.position = "absolute";
        cnv.style.top = img.offsetTop + "px";
        cnv.style.left = img.offsetLeft + "px";

        ctx.beginPath();
        ctx.arc(x_arr[items_no], y_arr[items_no], diameter_arr[items_no] / 2, 0, Math.PI * 2, false);
        ctx.lineWidth = 2;
        ctx.strokeStyle = '#FF20EF';
        ctx.stroke();

        items_no++;

        if(flag === false) {
            DrawCraters(items_no);
        }
    }
</script>


<body onload="Main()">
    <div >
        <img alt="" id="user_img" src = "<?php echo $image_name?>"  />
        <canvas id="myCanvas" width="450px" height="450px"></canvas>
    </div>
</body>


