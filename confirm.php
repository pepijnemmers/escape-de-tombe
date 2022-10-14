<?php

// Import PHPMailer classes into the global namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require "PHPMailer/src/Exception.php";
require "PHPMailer/src/PHPMailer.php";
require "PHPMailer/src/SMTP.php";


$serverName = "reseveringsysteem.database.windows.net";
$connectionOptions = array(
    "Database" => "Reserveringssysteem",
    "Uid" => "Admin123",
    "PWD" => "R070507038!"
);

//Establishes the connection
{
    $conn = sqlsrv_connect($serverName, $connectionOptions);
    $tsql= "INSERT INTO Groep(Naam) VALUES (?)";
    $params = array($_POST["groupsname"]);
    $stmt = sqlsrv_query($conn, $tsql, $params);
    if( $stmt === false ) {
        if( ($errors = sqlsrv_errors() ) != null) {
            header("location: index.php");
        }
        die( print_r( sqlsrv_errors(), true));
    }
}
{
    $conn = sqlsrv_connect($serverName, $connectionOptions);
    $tsql= "SELECT * FROM Groep WHERE Naam = ?";
    $params = array($_POST["groupsname"]);
    $getResults= sqlsrv_query($conn, $tsql, $params);
    if( $getResults === false ) {
        if( ($errors = sqlsrv_errors() ) != null) {
            header("location: index.php");
        }
        die( print_r( sqlsrv_errors(), true));
    }

    $row = sqlsrv_fetch_array($getResults, SQLSRV_FETCH_ASSOC);  
    
    $tsql = "INSERT INTO GroepTijdslot(GroepId, TijdslotId) VALUES (?, ?)";
    $params = array($row['GroepId'], $_POST["time"]);
    $stmt = sqlsrv_query($conn, $tsql, $params);
    if( $stmt === false ) {
        if( ($errors = sqlsrv_errors() ) != null) {
            header("location: index.php");
        }
        die( print_r( sqlsrv_errors(), true));
    }
}
{
    $conn = sqlsrv_connect($serverName, $connectionOptions);
    $tsql= "SELECT * FROM Groep WHERE Naam = ?";
    $params = array($_POST["groupsname"]);
    $getResults= sqlsrv_query($conn, $tsql, $params);
    if( $getResults === false ) {
        if( ($errors = sqlsrv_errors() ) != null) {
            header("location: index.php");
        }
        die( print_r( sqlsrv_errors(), true));
    }

    $row = sqlsrv_fetch_array($getResults, SQLSRV_FETCH_ASSOC);  

    for($i = 0; $i < $_POST["nrStudents"]; $i++)
    {
        $tsql = "INSERT INTO Student(Studentnummer, Naam, Email, GroepId) VALUES (?, ?, ?, ?)";
        $params = array($_POST["student" . $i + 1 . "Nr"], $_POST["student" . $i + 1 . "Name"], $_POST["student" . $i + 1 . "Email"], $row['GroepId']);
        $stmt = sqlsrv_query($conn, $tsql, $params);
        if( $stmt === false ) {
            if( ($errors = sqlsrv_errors() ) != null) {
                header("location: index.php");
            }
            die( print_r( sqlsrv_errors(), true));
        }
    }
}


// send email 
$mail = new PHPMailer(true);

// Sending email
try {
    //Server settings
    $mail->SMTPDebug = 0;                                       //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = '';                                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = "info@escaperoomkw1c.nl";               //SMTP username
    $mail->Password   = "";                                     //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         //Enable implicit TLS encryption
    $mail->Port       = 587;                                    //TCP port to connect to

    //Recipients
    $mail->setFrom('info@escaperoomkw1c.nl', 'Escaperoom KW1C');      // van wie
    $mail->addAddress('');                                      // aan wie

    //Content
    $mail->isHTML(true);                                        //Set email format to HTML
    $mail->Subject = 'Uw reservering voor de Escaperoom is geslaagd!';
    $mail->Body    = "Content";
    $mail->AltBody = 'Please use an e-mail provider that supports HTML mail.';

    $mail->send();
} catch (Exception $e) {
    echo "Er is iets mis gegaan.";
}


header("location: bevestiging.php");
?>