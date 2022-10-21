<?php

// Import PHPMailer classes into the global namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require "PHPMailer/src/Exception.php";
require "PHPMailer/src/PHPMailer.php";
require "PHPMailer/src/SMTP.php";

// include database functions
include "includes/db-functions.php";

// redirect if form isnt submitted
if (!isset($_POST["groupsname"])) {
    header("Location: /?error#aanmelden");
}

// get current data to confirm
try {
    $conn = openConn();
    
    $sql = "SELECT * FROM `groep`";
    $resultGroep = $conn->query($sql);

    $sql = "SELECT * FROM `student`";
    $resultStudent = $conn->query($sql);

    $sql = "SELECT * FROM `tijdslot`";
    $resultTijdslot = $conn->query($sql);
    
    closeConn($conn);
} catch (Exception $e) {
    header("Location: /?error#aanmelden");
}

// check of groep of student al bestaat
if ($resultGroep->num_rows > 0) {
    while($row = $resultGroep->fetch_assoc()) {
        if ($_POST["groupsname"] == $row["Naam"]) {
            header("Location: /?error=groep_exists#aanmelden");
        }
    }
}
if ($resultStudent->num_rows > 0) {
    while($row = $resultStudent->fetch_assoc()) {
        for($i = 1; $i <= $_POST["nrStudents"]; $i++)
        {
            if ($_POST["student{$i}Nr"] == $row["Studentnummer "]) {
                header("Location: /?error=student_exists#aanmelden");
            }
        }
    }
}

// insert input values
try {
    $conn = openConn();
    
    // groep
    $stmt = $conn->prepare("INSERT INTO `groep` (`Naam`) VALUES (?)");
    $stmt->bind_param("s", $groupsname);

    $groupsname = $_POST["groupsname"];
    $stmt->execute();

    // groepTijdslot
    $sql = "SELECT * FROM `groep` WHERE Naam = $groupsname;";
    $resultGroep = $conn->query($sql);

    $stmt = $conn->prepare("INSERT INTO `groeptijdslot` (`GroepId`, `TijdslotId`) VALUES (?, ?)");
    $stmt->bind_param("ss", $GroepId, $TijdslotId);

    $GroepId = $resultGroep["GroepId"];
    $TijdslotId = $_POST["time"];
    $stmt->execute();

    // student
    $stmt = $conn->prepare("INSERT INTO `student` (`Studentnummer`, `Naam`, `Email`, `GroepId`) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $Studentnummer, $Naam, $Email, $GroepId);

    for($i = 1; $i <= $_POST["nrStudents"]; $i++)
    {
        $Studentnummer = $_POST["student{$i}Nr"];
        $Naam = $_POST["student{$i}Name"];
        $Email = $_POST["student{$i}Email"];
        $GroepId = $resultGroep['GroepId'];
        $stmt->execute();
    }

    $stmt->close();
    closeConn($conn);
} 
catch (Exception $e) {
    header("Location: /?error=insert#aanmelden");
}



/*

TODO : ADD MAIL

// send email 
$mail = new PHPMailer(true);

// Sending email
try {
    //Server settings
    $mail->SMTPDebug = 0;                                       //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = '';                                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = "info@escapedetombe.nl";               //SMTP username
    $mail->Password   = "";                                     //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         //Enable implicit TLS encryption
    $mail->Port       = 587;                                    //TCP port to connect to

    //Recipients
    $mail->setFrom('info@escapedetombe.nl', 'Escaperoom KW1C');      // van wie
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

*/
?>