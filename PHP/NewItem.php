<?php

require("config.php");

$name = filter_input(INPUT_POST, 'groceryItem');
$quantity = filter_input(INPUT_POST, 'quantity');
$storeName = filter_input(INPUT_POST, 'storeName');

$conn = mysqli_connect($DBHOST, $DBUSERNAME, $DBPASSWORD);

if(!$conn)
{
    die("Not Connect: " . mysql_error());
}

$db_selected = mysqli_select_db($conn, $DBNAME);
if(!$db_selected)
{
    die("Can\'t use db: " .mysql_error());
}

$query = "INSERT INTO list1 (name, quantity, store)
Values ('$name', '$quantity', '$storeName')";

if($conn->query($query))
{
    echo"New Grocery Item Added To List";
    header("Location:http://localhost/projects/Grocery_List/index.html");
}
else
{
    echo"Error: ".$query ."<br>".$conn->error;
}

$conn->close();

?>