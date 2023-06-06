<?php 
// Initialize the session
session_start();
// connection
include_once '../configuration/config.php';
$logged_in_user = $_SESSION['username'];

if(isset($_GET['deleteId'])) {
    $id = $_GET['deleteId'];
    // Deleting a specific record from the table
    $sql = "delete from `lostItem` where item_id=$id";
    $result = mysqli_query($conn, $sql);
    if($result) {
        header('location: post.php');
        } else {
            echo "Error deleting record: " . mysqli_error($conn);
        }
    
    // Redirect the user to the display page
}   
?>