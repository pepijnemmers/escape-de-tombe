// count students
const nrStudents = document.getElementById("nrStudents");
const studentsInputs = document.getElementById("studentsInputs");
nrStudents.addEventListener("change", () => {
    switch (nrStudents.value) {
        case "4":
            studentsInputs.classList = "";
            studentsInputs.classList.add("students");
            break;
        case "5":
            studentsInputs.classList = "";
            studentsInputs.classList.add("students", "show5");
            break;
        case "6":
            studentsInputs.classList = "";
            studentsInputs.classList.add("students", "show6");
            break;
        default:
            break;
    }    
});