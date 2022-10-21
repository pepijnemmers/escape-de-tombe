<header>
        <div class="container">
            <div class="logo">
                <a href="/">Escape Room</a>
            </div>
            <div>
                <a href="#" class="btn btn--secondary" onclick="return changeReservation();">Reservering bewerken</a>
                <a href="#aanmelden" class="btn btn--primary">Meld je nu aan!</a>
            </div>
        </div>
    </header>
    <div id="changeReservationPopup">
        <div class="box" onclick="event.stopPropagation()">
            <div class="top">
                <h2>Wil jij je reservering bewerken?</h2>
                <span id="closeReservationPopup">&times;</span>
            </div>
            <p>
                Stuur een mailtje naar <a href="mailto:info@escapedetombe.nl">info@escapedetombe.nl</a> met je groepsnaam. 
                Zet hier in wat je wilt veranderen.
            </p>
            <p>
                Zodra dit is veranderd ontvang je wederom een email met de nieuwe gegevens.
            </p>
            <a href="mailto:info@escapedetombe.nl" class="btn btn--primary">Stuur een mail</a>
        </div>
    </div>