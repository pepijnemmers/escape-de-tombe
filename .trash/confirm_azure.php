<?php



    header("location: bevestiging.php");

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
