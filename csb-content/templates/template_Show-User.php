<?php
    $mysqli = mysqli_connect('localhost','csb','1password2ruleALL','csb');

    $query = "SELECT id, x, y, diameter FROM marks WHERE type='crater'";

    $result = mysqli_query($mysqli, $query);

//  get images IDs

//    if($result) {
//        while($row = mysqli_fetch_assoc($result)) {
//            $x_val = $row['x'];
//            echo 'id: ' . $row['id'] . '<br>';
//            echo 'x: ' . $row['x'] . '<br>';
//            echo 'y: ' . $row['y'] . '<br>';
//
//        }
//    }

// from marks get x and y of images of type crater
// get the id
// by id, from images get the images and display circles by x, y and diameter

    if($result) {
        $row = mysqli_fetch_assoc($result);
        $id_val = $row['id']; // id of image of type crater from marks
        $x_val = $row['x'];
        $y_val = $row['y'];
        $diameter_val = $row['diameter'];
    }

    $myArray = array();
    $query2 = "SELECT file_location, image_set_id FROM images WHERE id='41233510' LIMIT 1";

    $result2 = mysqli_query($mysqli, $query2);

    if($result2) {
        $row = mysqli_fetch_assoc($result2);
        $image_set_id_val = $row['image_set_id'];
        $image_set_id_val = (int) $image_set_id_val;

        if($image_set_id_val >= 4195) {
            $img_location = $row['file_location'];
        }
    }

    $image = "$img_location";

//        $image = "http://localhost/CSB7.0/images/small400.jpg";
?>

<script>
    function Draw() {
        var img = document.getElementById('img');
        var cnv = document.getElementById('myCanvas');
        var x = <?php echo $x_val;?>; // value obtained from DB
        var y = <?php echo $y_val;?>; //value obtained from DB
        var diameter = <?php echo $diameter_val;?>;
        var ctx = cnv.getContext("2d");

        cnv.style.position = "absolute";
        cnv.style.top = img.offsetTop + "px";
        cnv.style.left = img.offsetLeft + "px";

        ctx.beginPath();
        ctx.arc(parseFloat(x), parseFloat(y), parseFloat(diameter) / 2, 0, Math.PI * 2, false);
        ctx.lineWidth = 2;
        ctx.strokeStyle = '#00ff00';
        ctx.stroke();
    }
</script>

<body onload="Draw()">
    <img alt="" id='img' src='<?php echo $image;?>' />
    <canvas id='myCanvas' width="450px" height="450px"> </canvas>

    <div style="position: fixed; top: 700px;">
        <?php
            echo "x: $x_val <br>";
            echo "y: $y_val <br>";
            echo "diameter: $diameter_val <br>";
        ?>
    </div>
</body>
