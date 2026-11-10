let anzahlZeichen = 0;
// const area = document.getElementById("description");
// area.addEventListener("input", () => {
//     anzahlZeichen = area.value.length;

//     document.getElementById("zeichenanzahl").textContent =
//         anzahlZeichen + "/" + 200;
// });

let checked;
checked = document.querySelectorAll(".checked");
checked.forEach((dog) => {
    dog.addEventListener("change", () => {
        let selectedDog = {
            id: dog.dataset.id,
            name: dog.dataset.name,
            date: dog.dataset.birth_date,
            weight: dog.dataset.weight_kg,
            size: dog.dataset.size_cm,
            vaccated: dog.dataset.tollwut_impfung,
            breed: dog.dataset.breed,
            description: dog.dataset.description,
        };
        document.getElementById("id").value = selectedDog.id;
        document.getElementById("name").value = selectedDog.name;
        document.getElementById("birth_date").value = selectedDog.date;
        document.getElementById("weight_kg").value = selectedDog.weight;
        document.getElementById("size_cm").value = selectedDog.size;
        document.querySelector(
            'input[name="tollwut_impfung"][value="0"]',
        ).checked = selectedDog.vaccated === "0";
        document.querySelector(
            'input[name="tollwut_impfung"][value="1"]',
        ).checked = selectedDog.vaccated === "1";
        document.getElementById("breed").value = selectedDog.breed;
        document.getElementById("description").value = selectedDog.description;

        if (selectedDog != " ") {
            const deleteButton = document.getElementById("buttonDel");
            document.getElementById("dogform").action = "/dogs/update";
            deleteButton.classList.remove("deleteButton");
        } else {
            document.getElementById("dogform").action = "/dogs";
        }

        const deleting = document.getElementById("buttonDel");
        deleting.addEventListener("click", () => {
            let sicher= confirm("Do yout really want to delete " + selectedDog.name);
            if(sicher){
            document.getElementById("dogform").action = "/dogs/delete";
            document.getElementById("dogform").requestSubmit();
        }
    });
})});
console.log(cycleDay);
console.log(daten);