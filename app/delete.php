<?php 
// Initialize the session
session_start();
$logged_in_user = $_SESSION['username'];
$id=$_GET['item_id'];
// connection
include_once '../configuration/config.php';
// Deleting a specific record from the table
mysqli_query($conn,"delete from `lostItem` where id='$id'");
// Redirect the user to the display page
header('location:post.php');
    
?>