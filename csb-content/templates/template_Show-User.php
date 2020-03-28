<?php
/**
 * Created by Grigori Burlea.
 * User: grigorib
 * Date: 2/22/20
 * Time: 99999.9 PM
 */

GLOBAL $db;

    $mysqli = mysqli_connect('localhost','csb','1password2ruleALL','csb');

    $results_per_page = 12;  // Number of entries to show in a page.
    $query = "SELECT image_id FROM image_users WHERE user_id = 101111";
    $rs = mysqli_query($mysqli, $query);
    $number_of_results = mysqli_num_rows($rs); // how many row

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

    // For each image retreived for that user, get their image location and display
    foreach ($images as $image) {
        $query = "SELECT name, file_location FROM images WHERE id = ".$image['image_id'];

        $file = $db->runBaseQuery($query)[0];

        ?>

        <div class="img-thumbnail user-img-thumbnail">
            <a type="submit" href="view.php?image_name=<?php echo $file['file_location']?>&img_id=<?php echo $image['image_id']?>" target="_blank">
                <img  alt="" id="" src="<?php echo $file['file_location']?>">
                <?php $image_name = explode('_', $file['name'], 2) ; ?> <!-- split location value and name value -->
                <p class="thumbnail-tag"><?php echo $image_name[0]?><br><?php echo $image_name[1] ?></p> <!-- display location value and name value -->
            </a>
        </div>

    <?php
}
?>

<div class="pagination-box">
    <?php
        // show pagination
        $pagelimit = 3;
        $current = 1;

        if ($number_of_pages >= $pagelimit) {
            $current = $page;
        }

        // pages before current page (1...4 5 6 )
        if ($current - 1 > $pagelimit && (($current - $pagelimit) >= 1)) {
            $before_number .= "<a href=\"?page=1\">1</a>" ."<div class='page-extra'>...</div> ";
            for ($i = ($current - $pagelimit); $i < $current; $i++) {
                $before_number .= "<a href=\"?page=" .$i. "\">" .$i. " </a>";
            }
        }
        else {
            for ($i = 1; $i <= $page - 1; $i++) {
                $before_number .= "<a href=\"?page=" .$i. "\">" .$i. " </a>";
            }
        }

        // pages after current page (4 5 6 ... 200 )
        if(($number_of_pages - $current) >= $pagelimit) {
            for ($i = ($current + 1); $i <= ($current + $pagelimit); $i++) {
                $after_number .= "<a href=\"?page=" .$i. "\">" .$i. " </a>";
            }
            if ($current <= ($number_of_pages - ($pagelimit + 1))) {
                $after_number .= "<div class='page-extra'>... </div>"."<a href=\"?page=" .$number_of_pages. "\">" .$number_of_pages. "</a>";
            }
        }
        else {
            for ($i = $current + 1; $i <= $number_of_pages; $i++) {
                $after_number .= "<a href=\"?page=" .$i. "\">" .$i. " </a>";
            }
        }

        // append before current and after
        echo $before_number ."<div class='page-active'>" .$current. "</div>". " ".$after_number;
    ?>
</div>

<!-- pagination styles -->
<style>

/* includes flexbox for webkit and ms browser support (keep extra lines intact !!!) */
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
        -webkit-flex-wrap: wrap;
        -ms-flex-wrap: wrap;
        flex-wrap: wrap;
    }

/* includes flexbox for webkit and ms browser support (keep extra lines intact !!!) */
    .user-img-thumbnail {
        max-width: 125px;
        display: -webkit-box;
        display: -moz-box;
        display: -ms-flexbox;
        display: -moz-flex;
        display: -webkit-flex;
        display: flex;
        -webkit-align-items: center;
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

/* includes flexbox for webkit and ms browser support (keep extra lines intact !!!) */
    .pagination-box {
        font-size: .75em;
        margin-top: 20px;
        display: -webkit-box;
        display: -moz-box;
        display: -ms-flexbox;
        display: -moz-flex;
        display: -webkit-flex;
        display: flex;
        flex-basis: 100%;
        -webkit-justify-content: center;
        justify-content: center;
        -webkit-align-items: center;
        align-items: center;
    }

/* includes flexbox for webkit and ms browser support (keep extra lines intact !!!) */
    .pagination-box .page-active, .pagination-box a, .pagination-box .page-extra {
        min-width: 35px;
        min-height: 35px;
        padding: 8px;
        border: 1px solid #e0e0e0;
        color: #5c5c5c;
        display: -webkit-box;
        display: -moz-box;
        display: -ms-flexbox;
        display: -moz-flex;
        display: -webkit-flex;
        display: flex;
        -webkit-justify-content: center;
        justify-content: center;
        -webkit-align-items: center;
        align-items: center;
    }
    .pagination-box .page-extra {
        border: 0px;
    }

    .pagination-box .page-active {
        color: #000000;
        background: #dbdbdb;
        font-weight: 600;
    }

    .pagination-box a, .page-extra, .page-active, .page-active:hover {
        text-decoration: none;
    }

    .pagination-box a, .page-extra, .page-active, .page-active {
        margin-left: -1px;
    }

    .pagination-box a:hover {
        background: #dbdbdb;
    }

</style>
