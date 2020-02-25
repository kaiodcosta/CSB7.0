<?php
GLOBAL $db;

    $image_name = $_GET['image_name'];
    $img_id = $_GET['img_id'];

    $mysqli = mysqli_connect('localhost','csb','1password2ruleALL','csb');

    $query = "SELECT x, y, diameter, image_id FROM marks WHERE type='crater' AND image_id = ".$img_id;
    // SELECT x, y, diameter, image_id,  created_at type FROM marks WHERE type='crater' AND image_id=41229174

    $image_data = mysqli_query($mysqli, $query);

    $x_values = array();
    $y_values = array();
    $diameter_values = array();

    foreach ($image_data as $imagedata) {
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

    foreach ($image_data as $imagedata) {
        $details = json_decode($imagedata['details'], TRUE);

        $x1_values[] = $details['points'][0]['x'];
        $y1_values[] = $details['points'][0]['y'];
        $x2_values[] = $details['points'][1]['x'];
        $y2_values[] = $details['points'][1]['y'];
    }
?>

<script>
    function Main() {
        DrawCraters(0);
        DrawBoulders(0);
    }

    function DrawBoulders(items_no) {
        var x1_arr = <?php echo json_encode($x1_values); ?>;
        var y1_arr = <?php echo json_encode($y1_values); ?>;
        var x2_arr = <?php echo json_encode($x2_values); ?>;
        var y2_arr = <?php echo json_encode($y2_values); ?>;

        let flag = false;

        if(items_no === (x1_arr.length - 1)) {
            flag = true;
        }

        var img = document.getElementById('user_img');
        var c = document.getElementById("myCanvas");
        var ctx = c.getContext("2d");

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

    function DrawCraters(items_no) {
        var x_arr = <?php echo json_encode($x_values); ?>;
        var y_arr = <?php echo json_encode($y_values); ?>;
        var diameter_arr = <?php echo json_encode($diameter_values); ?>;

        let flag = false;

        if(items_no === (x_arr.length - 1)) {
            flag = true;
        }

        var img = document.getElementById('user_img');
        var cnv = document.getElementById('myCanvas');
        var ctx = cnv.getContext("2d");

        // cnv.style.display = "block";
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
