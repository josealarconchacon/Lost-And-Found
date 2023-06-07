<?php
    // Initialize the session
    session_start();
 
    // Check if the user is logged in, if not then redirect him to login page
    if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
        header("location: login.php");
        exit;
    } 

    include_once '../configuration/config.php';
    
    if($_SERVER['REQUEST_METHOD'] == "POST") {
        $description = $_POST['item_description'];
        $location = $_POST['item_location'];
        $category = $_POST['item_category'];
        $userId = get_user_id_from_session();
        $itemId = create_id();
    
        do {
            // Check for empty fields
            if(empty($description) || empty($location) || empty($category)) {
                $error = "All fields are required.";
                break;
            }
            // Insert Data to DB
            $stmt = $conn->prepare("INSERT INTO lostItem (user_id, item_id, item_description, item_location, item_category) VALUES (?,?,?,?,?)");
            $stmt->bind_param("sssss", $userId, $itemId, $description, $location, $category);
            $stmt->execute();
            $stmt->close();
            // Redirect to home page
            header("location: home.php");
        }while(false);
    }

    function get_user_id_from_session() {
        return $_SESSION["id"];
    }
    function create_id() {
        $random_length = rand(4,19);
        $number = "";
        for($i = 1; $i < $random_length; $i += 1) {
            $new_random = rand(0, 9);
            $number = $number . $new_random;
        }
        return $number;
    }
?>
<!DOCTYPE html>
<html lang="en">

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
    <link rel="stylesheet" href="/public/css/style.css">
    <title>Lost And Found</title>
</head>

<body>

    <div class="mainContainer container">
        <!-- header  -->
        <div class="item header">
            <nav class="navbar navbar-light">
                <div id="mySidenav" class="sidenav">
                    <a href="javascript:void(0)" id="toggler-btn-close" class="closebtn"
                        onclick="closeNav()">&times;</a>
                    <a href="about.html">About</a>
                    <a href="post.php">My Posts</a>
                    <a href="feedback.php">Send Us Your Feedback</a>
                    <a href="reset-password.php">Reset Password</a>
                    <a href="logout.php">Log Out</a>
                </div>
                <div id="main">
                    <span style="font-size:30px;cursor:pointer" id="toggler-btn" onclick="openNav()">&#9776;</span>
                </div>
                <h1 class="welcome">Welcome to Lost & Found, <?php echo $_SESSION["username"]?>
                </h1>
                <a class="navbar-brand fs-3">
                    <img src="/public/img/logo.png" width="60px" height="40px" id=logo alt="Logo image" /></a>
            </nav>
        </div>

        <!-- Filter  -->
        <div class="item sidebar">
            <button type="button" class="btn btn-circle" data-bs-toggle="modal"
                data-bs-target="#staticBackdrop">+</button>
            <!-- Modal -->
            <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <form action="home.php" method="post">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="staticBackdropLabel">Share what you have found</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-4">
                                    <label for="item_description" class="form-label">Item Description</label>
                                    <input type="text" class="form-control" id="item_description"
                                        name="item_description" placeholder="Enter Item Description...">
                                </div>
                                <div class="mb-4">
                                    <label for="item_location">Where the Item was found</label>
                                    <select class="form-select" id="item_location" name="item_location" required>
                                        <option selected>Select</option>
                                        <option name="building[]" value="C">C Building</option>
                                        <option name="building[]" value="B">B Building</option>
                                        <option name="building[]" value="E">E Building</option>
                                        <option name="building[]" value="M">M Building</option>
                                    </select>
                                </div>
                                <div class="mb-4">
                                    <label for="item_category">Category</label>
                                    <select class="form-select" id="item_category" name="item_category" required>
                                        <option selected>Select</option>
                                        <option value="Clothing" name="categories[]">Clothing</option>
                                        <option value="Books" name="categories[]">Books</option>
                                        <option value="Electronics" name="categories[]">Electronics</option>
                                        <option value="Others" name="categories[]">Others</option>
                                    </select>
                                </div>

                            </div>
                            <div class="modal-footer">
                                <input type="submit" name="submit" class="btn btn-primary" value="Share Item" />
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <br>
            <br>
            <br>
            <h1>Filter</h1>
            <br>

            <br>
            <h3>Building</h3>
            <nav class="navbar navbar-expand-lg navbar-light">
                <div class="container-fluid">
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false"
                        aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                        <div class="navbar-nav">
                            <br>
                            <form action="filter.php" id="selection" method="get">
                                <div class="radio-toolbar">
                                    <input type="radio" id="radio1" name="filterLocation[]" value="false" checked>
                                    <label for="radio1">C</label>
                                    <input type="radio" id="radio2" name="filterLocation[]" value="false">
                                    <label for="radio2">B</label>
                                    <input type="radio" id="radio3" name="filterLocation[]" value="true">
                                    <label for="radio3">E</label>
                                    <input type="radio" id="radio4" name="filterLocation[]" value="true">
                                    <label for="radio4">M</label>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </nav>

            <br>
            <h3>Category</h3>
            <nav class="navbar navbar-expand-lg navbar-light">
                <div class="container-fluid">
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <div data-check-all-container>
                            <br>
                            <form action="filter.php" class="selection" method="post">
                                <label for="clothing">
                                    <input type="checkbox" id="clothing" name="filterCategory[]" value="Clothing" cla>
                                    Clothing
                                </label><br>
                                <label for="books">
                                    <input type="checkbox" id="books" name="filterCategory[]" value="Books" cla>
                                    Books
                                </label><br>
                                <label for="electronics">
                                    <input type="checkbox" id="electronics" name="filterCategory[]" value="Electronics"
                                        cla>
                                    Electronics
                                </label><br>
                                <label for="keys">
                                    <input type="checkbox" id="keys" name="filterCategory[]" value="Keys" cla>
                                    Keys
                                </label><br>
                                <label for="others">
                                    <input type="checkbox" id="others" name="filterCategory[]" value="Others" cla>
                                    Others
                                </label><br>
                                <br>
                                <input class="btn-submit" type="submit" name="submit" value="Apply Filter">
                            </form>
                        </div>
                    </div>
                </div>
            </nav>
            <br>
        </div>

        <div class="item main h-1 p-1">
            <?php
            // Test
            //  $query = "select * from lostItem as li left join users as u on li.user_id = u.id";
            if(isset($_POST['filterCategory'])) {
                $my_filter = $_POST['filterCategory'];
                $query = "select * from lostItem as li left join users as u on li.user_id = u.id WHERE item_category = '" . $my_filter. "'";
            } else {
                $query = "select * from lostItem as li left join users as u on li.user_id = u.id ORDER BY li.id DESC";
            }
            
             $result = mysqli_query($conn, $query);

             if(!$result) {
                die("Query failed: " . mysqli_error($conn));
            };
            // Test
            // $my_filter = "Books"; // $my_filter = $_POST['filterCategory']
            // $query = "select * from lostItem as li left join users as u on li.user_id = u.id WHERE item_category = '" . $my_filter. "'";

            // Execute the query
            $result = $conn->query($query);
            // Loop through the results and display them in Bootstrap 5 cards
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
            ?>
        </div>
    </div>

    <script src="../public/js/script.js">
    </script>
</body>

</html>