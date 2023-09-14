function showForm(formId) {
    // Skryjeme všechny formuláře
    var forms = document.getElementsByClassName("form-container");
    for (var i = 0; i < forms.length; i++) {
      forms[i].style.display = "none";
    }
    
    // Zobrazíme vybraný formulář
  document.getElementById(formId).style.display = "block";
}