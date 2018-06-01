<?php
// Create connection
$bd = new mysqli("localhost", "root", "", "ScrollToLoad");
// Check connection
if ($bd->connect_error) {
    die("Connection failed: " . $bd->connect_error);
}
$error = true;
for($i = 0; $i <3; $i++) echo "<br/>";
for ($i = 0; $i < $_POST['times']; $i++)
{
    $json = file_get_contents('https://randomuser.me/api/');
    $user = json_decode($json, true);
    $sql = "INSERT INTO `Users` (`firstName`, `lastName`, `address`, `phoneNumber`, `img`)
    VALUES (
    '{$user['results'][0]['name']['first']}', '{$user['results'][0]['name']['last']}', '{$user['results'][0]['location']['city']}', '{$user['results'][0]['cell']}', '{$user['results'][0]['picture']['large']}')";
    if ($bd->query($sql) === TRUE) {
        $error = false;
    } else {
        $error = true;
        echo "<br>An error accourd with query: " . $i . "<br>" . $bd->error;
    }
}
if(!$error) echo "<br>{$_POST["times"]} new records successfully created";
?>
