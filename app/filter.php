<html>

<body>
    <div class="item main h-1 p-1">
        <?php 
        require_once "../configuration/config.php";

        if($_SERVER['REQUEST_METHOD'] == "POST") {
            print("POST METHOD");
            print(isset($_POST['submit']));
            // print($_POST['filterCategory']);
        }
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
</body>

</html>