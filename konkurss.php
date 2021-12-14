<?php
require_once('conf.php');
global $conn;
if(isset($_REQUEST["like"])){
    $order=$conn->prepare("update konkurss set punktid = punktid + 1 where konkurssID = ?");
    $order->bind_param("i", $_REQUEST["like"]);
    $order->execute();
    header("Location: ".$_SERVER["PHP_SELF"]);
}
if(isset($_REQUEST["comment"])){
    if($_REQUEST["empty"]) $order=$conn->prepare("update konkurss set kommentaar = ? where konkurssID = ?");
    else $order=$conn->prepare("update konkurss set kommentaar = concat(kommentaar, ';', ?) where konkurssID = ?");
    $order->bind_param("si", $_REQUEST["commentText"], $_REQUEST["comment"]);
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
$order=$conn->prepare("select konkurssID, nimi, pilt, kommentaar, punktid, avalik from konkurss where avalik=1");
$order->bind_result($konkurssID, $nimi, $pilt, $kommentaar, $punktid, $avalik);
$order->execute();
echo "<table>";
echo "<tr><th>Nimi</th><th>Pilt</th><th>Kommentaar</th><th>Uus Kommentaar</th><th>Punktrid</th><th></th></tr>";
while($order->fetch()){
    if(!$avalik==1){
        continue;
    }
    $empty = false;
    echo "<tr>";
    echo "<td id='nimi'>$nimi</td>";
    echo "<td><img src='$pilt' alt='img' width='200px' height='200px' style='align: middle'></td>";
    echo "<td style='white-space: pre-line;'>";
    if(!empty($kommentaar)){
        foreach (explode(";", $kommentaar) as &$komment) {
            echo trim($komment, ";").";\n";
        }
    }
    echo "</td>";
    if(empty($kommentaar)) $empty = true;
    echo "<td><form action='?'>
            <input type='hidden' name='comment' value='$konkurssID'>
            <input type='text' name='commentText' placeholder='Kommentaar..'>
            <input type='hidden' name='empty' value='$empty'>
            <input type='submit' value='Lisa'>
        </form></td>";
    echo "<td style='text-align: center'>$punktid</td>";
    echo "<td><a href='?like=$konkurssID'><input type='submit' name='like' value='♥'></a></td>";
    echo "</tr>";
}
?>
</body>
</html>
