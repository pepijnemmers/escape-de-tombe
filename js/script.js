// open reservation popup
function changeReservation() {
    document.getElementById("changeReservationPopup").classList.add("open");
    return false;
}

// close reservation popup
document.getElementById("closeReservationPopup").addEventListener("click", () => {
    document.getElementById("changeReservationPopup").classList.remove("open");
});
document.getElementById("changeReservationPopup").addEventListener("click", () => {
    document.getElementById("changeReservationPopup").classList.remove("open");
});