<?php 
// Initialize the session
session_start();
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
    <link rel="stylesheet" href="/public/css/styleFilter.css">
    <title>Document</title>
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
                <h1 class="welcome">Your Post, <?php echo $_SESSION["username"]?></h1>
            </div>
            <br>
        </div>

        <div class="accordion" id="accordionExample" style="width: 75%; margin: 0 auto; padding: 30px;">
            <?php
            $logged_in_user = $_SESSION['username'];
            // connection
            include_once '../configuration/config.php'; 
            // Retrieve data from the database
            $sql = "select * from lostItem as li left join users as u on li.user_id = u.id where u.username = '$logged_in_user' ORDER BY li.id DESC";
            $result = mysqli_query($conn, $sql);

            if(!$result) {
                die("Query failed: " . mysqli_error($conn));
            };
            $result = $conn->query($sql);
            
            // Output the retrieved data
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "
                    <div class='accordion-item'>
                    <h2 class='accordion-header' id='flush-headingOne'>
                      <button class='accordion-button collapsed' type='button' data-bs-toggle='collapse' data-bs-target='#flush-collapseOne' aria-expanded='false' aria-controls='flush-collapseOne'>
                        ".$row['username']. " 
                      </button>
                    </h2>
                    <div id='flush-collapseOne' class='accordion-collapse collapse' aria-labelledby='flush-headingOne' data-bs-parent='#accordionFlushExample'>
                      <div class='accordion-body'>
                      <p class='card-text'>". $row['item_description'] ." </p>
                      <p>"."<strong>Location</strong>:  &nbsp;" .$row['item_location']. " Building  &nbsp;" . "  &nbsp;<strong>Category</strong>:  &nbsp;" .$row['item_category']. "</p>
                        <a href='#'>
                            <i class='bi bi-suit-heart' style='color: black;'></i>
                            <label style='color: black;'>0</label>
                        </a>
                        <a href='#'>
                            <i class ='bi bi-chat-left-quote' style='color: black;'></i>
                            <label style='color: black;'>1 comment</label>
                        </a>
                        <br>
                        <br>
                    
                        <a class='btn btn-info' data-bs-toggle='modal' data-bs-target='#staticBackdrop''>Update Post</a>
                        <a class='btn btn-outline-danger' href='delete.php?deleteId=".$row['item_id']."'>Delete Post</a>
                      </div>
                    </div>
                  </div>
                    ";
                }
            }
        ?>
        </div>
    </div>
</body>

</html>