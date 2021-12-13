<?php
require_once('conf.php');
global $conn;
if(isset($_REQUEST["like"])){
    $order=$conn->prepare("update konkurss set punktid = punktid + 1 where konkurssID = ?");
    $order->bind_param("i", $_REQUEST["like"]);
    $order->execute();
    header("Location: ".$_SERVER["PHP_SELF"]);
}

?>
<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <title>Fotokonkurss</title>
    <link rel="stylesheet" href="dbKonk.css">
</head>
<body>
<nav>
    <a href="haldus.php">Admin</a>
    <a href="konkurss.php">Kasutaja</a>
</nav>
<h1>Fotokonkurss "whats"</h1>
<?php
$order=$conn->prepare("select konkurssID, nimi, pilt, lisamisaeg, punktid from konkurss where avalik=1");
$order->bind_result($konkurssID, $nimi, $pilt, $aeg, $punktid);
$order->execute();
echo "<table>";
echo "<tr><th>Nimi</th><th>Pilt</th><th>Lisamisaeg</th><th>Punktrid</th><th></th></tr>";
while($order->fetch()){
    echo "<tr>";
    echo "<td id='nimi'>$nimi</td>";
    echo "<td><img src='$pilt' alt='img' width='200px' height='200px' style='align: middle'></td>";
    echo "<td>$aeg</td>";
    echo "<td style='text-align: center'>$punktid</td>";
    echo "<td><a href='?like=$konkurssID'><input type='submit' name='like' value='♥'></a></td>";
    echo "</tr>";
}
?>
</body>
</html>
