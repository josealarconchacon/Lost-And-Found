<?php 
  // Initialize the session
  session_start();
?>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap  -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- Bootstrap Font Icon CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <link rel="stylesheet" href="/public/css/styleFilter.css">
</head>

<body>
    <div class="mainContainer container">
        <div class="content">
            <div class="back-home">
                <a href="home.php" class="back-btn">
                    <i class="bi bi-arrow-left"></i>
                </a>
                <br>
                <br>
                <h1 class="welcome">Base on your filter, <?php echo $_SESSION["username"]?></h1>
            </div>
            <div class="item main h-1 p-1">
                <?php 
                require_once "../configuration/config.php";

                if(isset($_POST['submit'])) {
                    if(isset($_POST['filterCategory'])) {
                        $my_filters = get_where_clause($_POST['filterCategory']);
                        $query = "select * from lostItem as li left join users as u on li.user_id = u.id WHERE ". $my_filters;
                        // print($query);
                    } else {
                        $query = "select * from lostItem as li left join users as u on li.user_id = u.id ORDER BY li.id DESC";
                        // print($query);
                    }
                    // connection init
                    $result = mysqli_query($conn, $query);
                    // run query
                    $result = $conn->query($query);

                    while($row = $result->fetch_assoc()) {
                        echo "
                        <div class='card shadow p-2 mb-3 bg-body rounded'> 
                        <h5 class='card-header'>".$row['username']."</h5>
                        <div class='card-body'>
                            <p class='card-text'>". $row['item_description'] ."</p>
                            <p>"."<strong>Location</strong>:  &nbsp;" .$row['item_location']. " Building  &nbsp;" . "  &nbsp;<strong>Category</strong>:  &nbsp;" .$row['item_category']. "</p>
                            <a href='#'>
                                <i class='bi bi-suit-heart' style='color: black;'></i>
                                <label style='color: black;'>0</label>
                            </a>
                            <a href='#'>
                                <i class ='bi bi-chat-left-quote' style='color: black;'></i>
                                <label style='color: black;'>1 comment</label>
                            </a>
                        </div>
                    </div>
                        ";   
                    }  
                }


                function get_where_clause($filter_categories) {
                    $where_clause = "";
                    $is_first = true;
                    foreach($filter_categories as $category) {
                        // echo "Echo result: " . $category;
                        if ($is_first) {
                            $where_clause = $where_clause . " item_category = '" . $category . "'";
                            $is_first = false;          
                        } else {
                            $where_clause = $where_clause. " OR item_category = '" . $category . "'";
                        }
                    }
                    return $where_clause;
                }
                ?>
            </div>
        </div>
    </div>
</body>

</html>