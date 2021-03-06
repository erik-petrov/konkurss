<?php
require_once('conf.php');
global $conn;
if(isset($_REQUEST["zeroLike"])){
    $order=$conn->prepare("update konkurss set punktid = 0 where konkurssID = ?");
    $order->bind_param("i", $_REQUEST["zeroLike"]);
    $order->execute();
    header("Location: ".$_SERVER["PHP_SELF"]);
}
if(isset($_REQUEST["zeroComments"])){
    $order=$conn->prepare("update konkurss set kommentaar = '' where konkurssID = ?");
    $order->bind_param("i", $_REQUEST["zeroComments"]);
    $order->execute();
    header("Location: ".$_SERVER["PHP_SELF"]);
}
if(!empty($_REQUEST["nimi"])){
    $order=$conn->prepare("insert into konkurss(nimi, pilt, lisamisaeg) values(?, ?, CURRENT_TIMESTAMP)");
    $order->bind_param("ss", $_REQUEST["nimi"], $_REQUEST["pilt"]);
    $order->execute();
    header("Location: ".$_SERVER["PHP_SELF"]);
}
if(isset($_REQUEST["delete"])){
    $order=$conn->prepare("delete from konkurss where konkurssID = ?");
    $order->bind_param("i", $_REQUEST["delete"]);
    $order->execute();
    header("Location: ".$_SERVER["PHP_SELF"]);
}
if(isset($_REQUEST["avalik"])){
    $order=$conn->prepare("update konkurss set avalik = 1 where konkurssID = ?");
    $order->bind_param("i", $_REQUEST["avalik"]);
    $order->execute();
    header("Location: ".$_SERVER["PHP_SELF"]);
}
if(isset($_REQUEST["peida"])){
    $order=$conn->prepare("update konkurss set avalik = 0 where konkurssID = ?");
    $order->bind_param("i", $_REQUEST["peida"]);
    $order->execute();
    header("Location: ".$_SERVER["PHP_SELF"]);
}
?>
<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <title>Fotokonkurss halduseleht</title>
    <link rel="stylesheet" href="dbKonk.css">
</head>
<body>
<nav>
    <a href="haldus.php">Admin</a>
    <a href="konkurss.php">Kasutaja</a>
</nav>
<h1>Fotokonkurss "whats" halduseleht</h1>
<?php
$order=$conn->prepare("select konkurssID, nimi, pilt, lisamisaeg, punktid, avalik, kommentaar from konkurss");
$order->bind_result($konkurssID, $nimi, $pilt, $aeg, $punktid, $avalik, $kommentaar);
$order->execute();
echo "<table>";
echo "<tr><th></th><th></th><th></th><th>Nimi</th><th>Pilt</th><th>Lisamisaeg</th><th style='text-align: center'>Punktid</th><th>Kommentaarid</th></tr>";

$ask = '"Are you sure?"';
while($order->fetch()){
    echo "<tr>";
    $avatekst = "Ava";
    $param = "avalik";
    $seisund = "Peidetud";
    if($avalik == 1){
        $avatekst = "Peida";
        $param = "peida";
        $seisund = "Avatud";
    }
    echo "<td style='text-align: center'>$seisund</td>";
    echo "<td><a href='?$param=$konkurssID'><input type='submit' name='toggle' value='$avatekst'></a></td>";
    echo "<td><a href='?delete=$konkurssID' onclick='return confirm($ask);'><input type='submit' name='delete' value='Kustuta'></a></td>";
    echo "<td id='nimi'>$nimi</td>";
    echo "<td><img src='$pilt' alt='img' width='100px' height='100px' style='align: middle'></td>";
    echo "<td>$aeg</td>";
    echo "<td style='text-align: center'>$punktid</td>";
    echo "<td style='white-space: pre-line;'>";
    if(!empty($kommentaar)){
        foreach (explode(";", $kommentaar) as &$komment) {
            echo trim($komment, ";").";\n";
        }
    }
    echo "</td>";
    echo "<td><a href='?zeroLike=$konkurssID'><input type='submit' name='like' value='Null punktid'></a><br>";
    echo "<a href='?zeroComments=$konkurssID'><input type='submit' name='comments' value='Null kommentaarid'></a></td>";

    echo "</tr>";
}
echo "</table>";
?>

<h2>Uue pilte lisamine konkurssi</h2>
<form action="?">
    <input type="text" name="nimi" placeholder="nimi.."><br>
    <textarea name="pilt" placeholder="link.."></textarea><br>
    <input type="submit" value="Loo">
</form>
</body>
</html>
