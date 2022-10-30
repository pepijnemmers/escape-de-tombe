<?php

if (!isset($_GET["group"])) {
    header("Location: /");
}

$mail = file_get_contents("../email.php");
$mail = str_replace("Bekijk online versie", "", $mail);
$mail = str_replace("{{Groepsnaam}}", $_GET["group"], $mail);
$mail = str_replace("{{Datum}}", "15-11-2022 " . $_GET["datum"], $mail);
$mail = str_replace("{{Lokaal}}", $_GET["lokaal"], $mail);

$mail = str_replace('<div class="es-wrapper-color" style="', '<div class="es-wrapper-color" style="min-height:100vh;', $mail);

echo $mail;

?>