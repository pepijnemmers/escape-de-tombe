<?php

include "includes/db-functions.php";

try {
    $conn = openConn();

    $sql1 = "SELECT `TijdslotId` FROM `groeptijdslot`";
    $resultGroeptijdslot = $conn->query($sql1);
    
    $sql = "SELECT * FROM `tijdslot`";
    $result = $conn->query($sql);
    
    closeConn($conn);
} catch (Exception $e) {
    echo "Database Error. Probeer later opnieuw of neem contact op met <a href='mailto:info@escapedetombe.nl'>info@escapedetombe.nl</a>";
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reserveren - Escape Room KW1C</title>
    <link rel="stylesheet" href="styles/styles.css">
    <script src="js/script.js" defer></script>
    <script src="js/index.js" defer></script>
</head>
<body>
    <?php include "includes/header.php"; ?>

    <section class="hero">
            <div class="container">
                <div>
                    <h4>Escape Room KW1C</h4>
                    <h1><span>Ontsnap</span> jij binnen de tijd?</h1>
                    <p>
                        Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis.
                    </p>
                    <a href="#aanmelden" class="btn btn--primary">Doe jij mee? Meld je aan!</a>
                </div>
                <img src="images/tomb.webp" alt="hero image">
            </div>
    </section>

    <section class="aanmelden" id="aanmelden">
        <div class="container">
            <div>
                <h2>Meld je aan</h2>
                <p>
                    Wat leuk dat jij mee wilt doen aan de escape room! Vul onderstaand formulier in met jouw groepje om je in te schrijven. Als je klaar bent klik je op de knop en dan ontvang je een bevestiging in je mailbox. <br>
                    Heb je vragen? Mail je vraag naar <a href="mailto:info@escapedetombe.nl">info@escapedetombe.nl</a>.
                </p>

                <form action="confirm.php" method="post" autocomplete="off">
                    <p class="error-msg">
                        <?php 
                            if (isset($_GET["error"])) {
                                switch ($_GET["error"]) {
                                    case "groep_exists":
                                        $msg = "Deze groep bestaat al. Kies een unieke naam!";
                                        break;
                                    case "student_exists":
                                        $msg = "Een van de studenten bestaat al.";
                                        break;
                                    case "insert":
                                        $msg = "Het aanmaken is niet gelukt. Probeer het (later) opnieuw of neem <a href='mailto:info@escapedetombe.nl'>contact</a> op.";
                                        break;
                                    default:
                                        $msg = "Er is iets misgegaan. Probeer het (later) opnieuw of neem <a href='mailto:info@escapedetombe.nl'>contact</a> op.";
                                        break;
                                }
                                echo $msg; 
                            }
                        ?>
                    </p>

                    <div class="flex">
                        <div>
                            <label for="groupsname">Wat is jullie groepsnaam?*</label>
                            <input type="text" name="groupsname" id="groupsname" placeholder="Vul je unieke groepsnaam in..." required>
                        </div>
                        <div>
                            <label for="time">Hoelaat willen jullie komen?*</label>
                            <select name="time" id="time" required>
                                <option value="" disabled selected hidden>Kies een tijd</option>
                                                      
                                <?php
                                    if ($result->num_rows > 0) {
                                        if ($resultGroeptijdslot->num_rows > 0) {
                                            $tijdslotRow = $resultGroeptijdslot->fetch_assoc();
                                        }
                                        while($row = $result->fetch_assoc()) {
                                            if ($resultGroeptijdslot->num_rows > 0) {
                                                if (in_array($row["TijdslotId"], $tijdslotRow)) {
                                                    continue;
                                                }
                                            }
                                            
                                            $time = substr($row['Tijd'], 10);
                                            $time = substr($time, 0, -3);

                                            echo "<option value=" . $row['TijdslotId'] . ">" . $time . "</option>";
                                        }
                                    } else {
                                        echo "<option value='' disabled>Er is iets mis gegaan..</option>";
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div>
                        <label for="nrStudents">Met hoeveel studenten zijn jullie? (4-6 per groep)*</label>
                        <select name="nrStudents" id="nrStudents" required>
                            <option value="4" selected>4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                        </select>
                    </div>
                    <div class="students" id="studentsInputs">
                        <div>
                            <label for="student1Nr">Student 1*</label>
                            <input type="text" name="student1Nr" id="student1Nr" placeholder="Studentnummer" required>
                            <input type="text" name="student1Name" placeholder="Voor- en achternaam" required>
                            <input type="text" name="student1Email" placeholder="Emailadres (@edu-kw1c.nl)" required pattern="[a-z0-9._%+-]+@edu-kw1c.nl$">
                        </div>
                        <div>
                            <label for="student2Nr">Student 2*</label>
                            <input type="text" name="student2Nr" id="student2Nr" placeholder="Studentnummer" required>
                            <input type="text" name="student2Name" placeholder="Voor- en achternaam" required>
                            <input type="text" name="student2Email" placeholder="Emailadres (@edu-kw1c.nl)" required pattern="[a-z0-9._%+-]+@edu-kw1c.nl$">
                        </div>
                        <div>
                            <label for="student3Nr">Student 3*</label>
                            <input type="text" name="student3Nr" id="student3Nr" placeholder="Studentnummer" required>
                            <input type="text" name="student3Name" placeholder="Voor- en achternaam" required>
                            <input type="text" name="student3Email" placeholder="Emailadres (@edu-kw1c.nl)" required pattern="[a-z0-9._%+-]+@edu-kw1c.nl$">
                        </div>
                        <div>
                            <label for="student4Nr">Student 4*</label>
                            <input type="text" name="student4Nr" id="student4Nr" placeholder="Studentnummer" required>
                            <input type="text" name="student4Name" placeholder="Voor- en achternaam" required>
                            <input type="text" name="student4Email" placeholder="Emailadres (@edu-kw1c.nl)" required pattern="[a-z0-9._%+-]+@edu-kw1c.nl$">
                        </div>
                        <div id="student5">
                            <label for="student5Nr">Student 5*</label>
                            <input type="text" name="student5Nr" id="student5Nr" placeholder="Studentnummer">
                            <input type="text" name="student5Name" placeholder="Voor- en achternaam">
                            <input type="text" name="student5Email" placeholder="Emailadres (@edu-kw1c.nl)" pattern="[a-z0-9._%+-]+@edu-kw1c.nl$">
                        </div>
                        <div id="student6">
                            <label for="student6Nr">Student 6*</label>
                            <input type="text" name="student6Nr" id="student6Nr" placeholder="Studentnummer">
                            <input type="text" name="student6Name" placeholder="Voor- en achternaam">
                            <input type="text" name="student6Email" placeholder="Emailadres (@edu-kw1c.nl)" pattern="[a-z0-9._%+-]+@edu-kw1c.nl$">
                        </div>
                    </div>

                        <button type="submit" class="btn btn--primary">Reservering opslaan</button>
                </form>
            </div>
            <div>
                <h3>Reservering wijzigen?</h3>
                <p>
                    Stuur een mailtje naar <a href="mailto:info@escapedetombe.nl">info@escapedetombe.nl</a> met je groepsnaam. 
                    Zet hier in wat je wilt veranderen.
                </p>
                <p>
                    Zodra dit is veranderd ontvang je wederom een email met de nieuwe gegevens.
                </p>
                <a href="mailto:info@escapedetombe.nl" class="btn btn--secondary">Stuur een mail</a>
            </div>
        </div>
    </section>
</body>
</html>