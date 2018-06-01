<?php
// Create connection
$db = mysqli_connect("localhost", "root", "", "scrolltoload");
// Check connection
if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
}

if(isset($_POST["limit"], $_POST["start"]))
{
    if ($_POST['search'] != null) {
        $searchq = preg_replace("#[^0-9a-z]#i", "", strtolower($_POST['search']));
        $sql  = "SELECT * FROM Users WHERE LOWER(firstName) LIKE '%".$searchq."%'";
        $sql .= " OR LOWER(lastName) LIKE '%".$searchq."%'";
        $sql .= " ORDER BY LOWER(".$_POST["sort"].") ASC LIMIT ".$_POST["start"].", ".$_POST["limit"];
        unset($_POST['search']);
    }
    else {
        if($_POST["sort"] != null) {
            $sql = "SELECT * FROM users ORDER BY LOWER(".$_POST["sort"].") ASC LIMIT ".$_POST["start"].", ".$_POST["limit"];
        }
    }
    $result = mysqli_query($db, $sql);
    if (mysqli_num_rows($result) > 0) {
        // output data of each row
        while($row = mysqli_fetch_assoc($result)) {
            echo "<div id='whole-card'>";
            echo "<div class=\"section\">";
            echo "<img src=\"{$row["img"]}\" />";
            echo "<p>{$row["firstName"]}, {$row["lastName"]}</p>";
            echo "<p>{$row["phoneNumber"]}</p>";
            echo "</div><hr />";
            echo "</div>";
        }
    } else {
        echo "No results";
    }
}
$db->close();
?>
