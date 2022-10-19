<?php

// Import PHPMailer classes into the global namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require "PHPMailer/src/Exception.php";
require "PHPMailer/src/PHPMailer.php";
require "PHPMailer/src/SMTP.php";


// Een "leeg" $pdo variabele aanmaken
$pdo = null;

// Starten van een DB connectie
function startConnection()
{
    global $pdo;
    // Open de database connectie en ODBC driver
    try
    {
        $pdo = new PDO("mysql:host=127.0.0.1;dbname=Reserveringssysteem", 'root', "");
    }
    catch (PDOException $e)
    {
        header("location: index.php");
    }
}

// Start de database verbinding
startConnection();

// // DB data
// $user = 'root';
// $password = "";
// $name = "Reserveringssysteem";
// $host = "127.0.0.1";

{
    $stmt = $pdo->prepare("INSERT INTO Groep(Naam) VALUES (?)");   

    try
    {
        $stmt->execute([$_POST["groupsname"]]);
    }
    catch(Exception)
    {
        header("location: index.php");
    }
}
{
    try
    {
        $result = $pdo->query("SELECT * FROM Groep WHERE Naam = '" . $_POST["groupsname"] . "'");
    }
    catch(Exception)
    {
        header("location: index.php");
    }
    
    $stmt = $pdo->prepare("INSERT INTO GroepTijdslot(GroepId, TijdslotId) VALUES (?, ?)");
    try
    {
        $row = $result->fetch();
        $result = $stmt->execute([$row['GroepId'], $_POST["time"]]);
    }
    catch(Exception)
    {
        header("location: index.php");
    }
}
{
    try
    {
        $result1 = $pdo->query("SELECT * FROM Groep WHERE Naam = '" . $_POST["groupsname"] . "'");
    }
    catch(Exception)
    {
        header("location: index.php");
    }

    for($i = 0; $i < $_POST["nrStudents"]; $i++)
    {
        $stmt = $pdo->prepare("INSERT INTO Student(Studentnummer, Naam, Email, GroepId) VALUES (?, ?, ?, ?)");
        try
        {
            $row = $result1->fetch();
            $result = $stmt->execute([$_POST["student" . $i + 1 . "Nr"], $_POST["student" . $i + 1 . "Name"], $_POST["student" . $i + 1 . "Email"], $row['GroepId']]);
        }
        catch(Exception)
        {
            header("location: index.php");
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