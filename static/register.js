let select = document.querySelector('select');

select.addEventListener('change', (event) => {

  let form = document.querySelector('section.patient');

  if (event.target["value"] == 5) {

    form.style.display = "flex";

  }else {

    form.style.display = "none";
  }
})
