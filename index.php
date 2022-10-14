<?php
$serverName = "reseveringsysteem.database.windows.net";
$connectionOptions = array(
    "Database" => "Reserveringssysteem",
    "Uid" => "Admin123",
    "PWD" => "R070507038!"
);
    $conn = sqlsrv_connect($serverName, $connectionOptions);
    $tsql= "SELECT *, t.TijdslotId AS TijdId FROM Tijdslot AS t LEFT JOIN GroepTijdslot AS gt ON t.TijdslotId = gt.TijdslotId WHERE gt.TijdslotId IS NULL;";
    $getResults= sqlsrv_query($conn, $tsql);
    if ($getResults == FALSE)
        echo (sqlsrv_errors());
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
                    Heb je vragen? Mail je vraag naar <a href="mailto:#">example@email.com</a>.
                </p>

                <form action="confirm.php" method="post" autocomplete="off">
                    <p class="error-msg"></p>
                    <div class="flex">
                        <div>
                            <label for="groupsname">Wat is jullie groepsnaam?*</label>
                            <input type="text" name="groupsname" id="groupsname" placeholder="Vul je unieke groepsnaam in..." required>
                        </div>
                        <div>
                            <label for="time">Kies een tijdsperiode voor hoelaat jullie komen*</label>
                            <select name="time" id="time" required>
                                <option value="" disabled selected hidden>Kies een tijd</option>
                                
                                <!-- TODO : php loop options hierin die nog vrij zijn -->                                
                                <?php 
                                while ($row = sqlsrv_fetch_array($getResults, SQLSRV_FETCH_ASSOC)) 
                                {
                                    $time = $row["Tijd"]->format("H:i");
                                    $endtime = $row["Tijd"]->add(new DateInterval('PT45M'));
                                    $endtime = $endtime->format("H:i");
                            
                                echo "<option value=" . $row['TijdId'] . ">" . $time . " - " . $endtime . "</option>";
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
                    Stuur een mailtje naar <a href="mailto:#">example@email.com</a> met je groepsnaam. 
                    Zet hier in wat je wilt veranderen.
                </p>
                <p>
                    Zodra dit is veranderd ontvang je wederom een email met de nieuwe gegevens.
                </p>
                <a href="mailto:#" class="btn btn--secondary">Stuur een mail</a>
            </div>
        </div>
    </section>
</body>
</html>