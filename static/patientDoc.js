// For patientOfDoctor preventing refresh
let form = document.getElementById("pre_form");

function handleForm(event) { event.preventDefault(); }
form.addEventListener('submit', handleForm);
