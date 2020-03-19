<?php

require("config.php");

$listNumber = $_GET["listNumber"];

//starts new XML file and creates parent node
$dom = new DOMDocument("1.0");
$node = $dom->createElement("items");
$parnode = $dom->appendChild($node);

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
$query = sprintf("SELECT * From list$listNumber");

$result = mysqli_query($conn, $query); //potential error fix = multiply by 2

if(!$result)
{
    die("Invalid query : " . mysqli_error($conn));
}

header("Content-type: text/xml");

if(mysqli_num_rows($result) > 0)
{
    while($row = @mysqli_fetch_assoc($result))
    {
        $node = $dom->createElement("item");
        $newnode = $parnode->appendChild($node);
        $newnode->setAttribute("id", $row['id']);
        $newnode->setAttribute("name", $row['name']);
        $newnode->setAttribute("quantity", $row['quantity']);
        $newnode->setAttribute("store", $row['store']);
    }
}
else
{
    echo"0 Results Found.";
}

echo $dom->saveXML();

?>