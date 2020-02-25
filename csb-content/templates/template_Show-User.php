<?php
GLOBAL $db;

$mysqli = mysqli_connect('localhost','csb','1password2ruleALL','csb');

$results_per_page = 12;  // Number of entries to show in a page.

$query = "SELECT image_id FROM image_users WHERE user_id = 101111";

$rs = mysqli_query($mysqli, $query);

$number_of_results = mysqli_num_rows($rs); // how many rows

// get the number of total pages available
$number_of_pages = ceil($number_of_results / $results_per_page); // round to the nearest int

// get which page number is the user currently on
if (!isset($_GET['page'])) {
    $page = 1;
} else {
    $page = $_GET['page'];
}

$start_from = ($page-1)*$results_per_page;

$query = "SELECT image_id FROM image_users WHERE user_id = 101111 LIMIT $start_from, $results_per_page";

$images = $db->runBaseQuery($query);

//    class img_object {
//        public $id_val, $x_val, $y_val;
//        public function __construct(string $id_val, string $x_val, string $y_val)
//        {
//            $this->id_val = $id_val;
//            $this->x_val = $x_val;
//            $this->y_val = $y_val;
//        }
//    }

// For each image retreived for that user, get their image location and display
foreach ($images as $image) {
    $query = "SELECT name, file_location FROM images WHERE id = ".$image['image_id'];
//    $query = "SELECT images.name, images.file_location, marks.x, marks.y, marks.diameter
//                FROM images, marks WHERE images.id = ".$image['image_id']." AND marks.image_id =".$image['image_id'];

    $file = $db->runBaseQuery($query)[0];

//    $query2 = "SELECT x, y, diameter FROM marks WHERE type='crater', image_id = ".$image['image_id'];

//    $image_data = mysqli_query($mysqli, $query);
//
//    if($image_data) {
//        $row = mysqli_fetch_assoc($image_data);
//        $id_val = $row['id']; // id of image of type crater from marks
//        $x_val = $row['x'];
//        $y_val = $row['y'];
//        $diameter_val = $row['diameter'];
//    }
//    echo "ID: ".$image['image_id']." X: ".$x_val." Y: ".$y_val;

    ?>

    <div class="img-thumbnail user-img-thumbnail">
        <a type="submit" href="view.php?image_name=<?php echo $file['file_location']?>&img_id=<?php echo $image['image_id']?>" target="_blank">
            <img  alt="" id="" src="<?php echo $file['file_location']?>">
            <?php $image_name = explode('_', $file['name'], 2) ; ?> <!-- split location value and name value -->
            <p class="thumbnail-tag"><?php echo $image_name[0]?><br><?php echo $image_name[1] ?></p> <!-- display location value and name value -->
        </a>
    </div>

    <script>
        $('img').on('click',function() {
            var sr=$(this).attr('src');
            $('#user_img').attr('src',sr);
            $('#myModal').modal('show');
        });
    </script>

    <?php
}
?>

<div>
    <?php
        for ($page=1; $page<=$number_of_pages; $page++) {
            echo '<a href="index.php?page='. $page .' ">'. $page . '</a> ';
        }
        ?>
</div>

<style>
    /*#myCanvas {*/
    /*    display: none;*/
    /*}*/

    #app-main {
        display: -webkit-box;
        display: -moz-box;
        display: -ms-flexbox;
        display: -moz-flex;
        display: -webkit-flex;
        display: flex;
        -webkit-align-items: stretch;
        align-items: stretch;
        justify-content: center;
        flex-wrap: wrap;
    }

    .user-img-thumbnail {
        max-width: 125px;
        display: -webkit-box;
        display: -moz-box;
        display: -ms-flexbox;
        display: -moz-flex;
        display: -webkit-flex;
        display: flex;
        webkit-align-items: center;
        align-items: center;
        justify-content: center;
        border: 1px solid #e0e0e0;
        border-radius: 0px;
        padding: 5px;

        flex-direction:column;
    }
    .user-img-thumbnail a {
        text-decoration: none;
        color: #000000;
    }

    .user-img-thumbnail img {
        width: 100%;
    }

    .thumbnail-tag {
        font-size: 9px;
        align-self: baseline;
        padding: 0;
        margin: 5px 0 0;
    }

</style>
