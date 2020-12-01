let select = document.querySelector('select');

select.addEventListener('change', (event) => {

  let form = document.querySelector('section.patient');

  if (event.target["value"] == 5) {

    form.style.display = "flex";

  }else {

    form.style.display = "none";
  }
})

// For patientOfDoctor preventing refresh
let form = document.getElementById("pre_form");

function handleForm(event) { event.preventDefault(); }
form.addEventListener('submit', handleForm);
