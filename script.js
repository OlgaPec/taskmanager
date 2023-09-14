function showForm(formId) {
    // Skryjeme všechny formuláře
    var forms = document.getElementsByClassName("form-container");
    for (var i = 0; i < forms.length; i++) {
      forms[i].style.display = "none";
    }
    
    // Zobrazíme vybraný formulář
  document.getElementById(formId).style.display = "block";
}

function deleteTask(taskId) {
    if (confirm("Opravdu chcete smazat tento úkol?")) {
      var xhttp = new XMLHttpRequest();
      xhttp.onreadystatechange = function() {
        if (this.readyState === 4 && this.status === 200) {
          var response = JSON.parse(this.responseText);
          if (response.success) {
            // Odstranění řádku zobrazeného úkolu ze stránky
            
            var taskButton = document.querySelector("button[data-task-id='" + taskId + "']");
            var taskRow = taskButton.closest("tr");
            if (taskRow) {
              taskRow.remove();
            }
          } else {
            alert(response.message);
          }
        }
      };
      xhttp.open("POST", "delete_task.php", true);
      xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      xhttp.send("delete-task=" + taskId);
    }
  }