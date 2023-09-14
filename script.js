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

  // Funkce pro úpravu textu
function editText(cell) {
    const text = cell.textContent;
    const input = document.createElement('input');
    input.type = 'text';
    input.value = text;
  
    input.style.width = cell.clientWidth + 'px';
  
    // Přidat událost pro zachycení stisku klávesy Enter
    input.addEventListener('keyup', function(event) {
        if (event.key === 'Enter') {
            saveText(cell, input);
        }
    });
  
  // Přidejte posluchač události na dokumentu pro kliknutí myší
  document.addEventListener('click', function(event) {
    // Zkontrolujte, zda kliknutí nastalo mimo buňku a input
    if (event.target !== cell && event.target !== input) {
        saveText(cell, input);
    }
  });
  
    cell.textContent = '';
    cell.appendChild(input);
    input.focus();
  }
  
  // Funkce pro uložení upraveného textu
  function saveText(cell, input) {
    const newText = input.value;
    const taskId = cell.parentElement.querySelector('td:first-child').textContent;
    const column = cell.cellIndex === 1 ? 'task_name' : (cell.cellIndex === 2 ? 'podrobnosti' : 'termin'); // Rozlišení sloupců
  // Odešlete AJAX požadavek na server s novým textem a ID úkolu
    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'update_task.php', true);
  
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            const response = xhr.responseText;
            console.log("response: ");
            console.log(response);
  
            if (response === "Úkol byl úspěšně aktualizován") {
                cell.textContent = newText;
            } else {
                alert("Chyba při aktualizaci úkolu ve funkci save.");
            }
        }
    };
  
    xhr.send(`newText=${newText}&taskId=${taskId}&column=${column}`);
  }

  function editCell(taskId, cell) {
    // Získejte stávající text z buňky
    var currentValue = cell.textContent.trim();
    
    console.log("currentValue: ");
    console.log(currentValue);
    console.log("taskId: ");
    console.log(taskId);
    console.log("cell: ");
    console.log(cell);
    
    // Vytvořte nový element select
    var select = document.createElement('select');
    select.name = "priorita";
    
    // Přidejte možnosti do rozbalovacího seznamu
    var option1 = document.createElement('option');
    option1.value = "Nízká";
    option1.textContent = "Nízká";
    select.appendChild(option1);
    
    var option2 = document.createElement('option');
    option2.value = "Střední";
    option2.textContent = "Střední";
    select.appendChild(option2);
    
    var option3 = document.createElement('option');
    option3.value = "Vysoká";
    option3.textContent = "Vysoká";
    select.appendChild(option3);
    
    // Nastavte stávající hodnotu jako vybranou možnost
    select.value = currentValue;
    
    // Přidejte posluchači události "change" pro okamžité uložení změn
    select.addEventListener('change', function () {
      var newValue = select.value;
      saveChanges(taskId, newValue); // Aktualizace databáze
      cell.textContent = newValue; // Aktualizace obsahu buňky
    });
    
    // Nahraďte text v buňce rozbalovacím seznamem
    cell.innerHTML = '';
    cell.appendChild(select);
    }
    
    function saveChanges(taskId, newValue) {
    // Vytvořte AJAX požadavek
    var xhr1 = new XMLHttpRequest();
    xhr1.open('POST', 'update_prior.php', true);
    xhr1.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    
    // Definujte obslužnou funkci pro úspěšné odeslání požadavku
    xhr1.onload = function() {
      if (xhr1.status === 200) {
        // Zde můžete provést další akce po úspěšném uložení
      }
    };
    
    // Odešlete požadavek
    xhr1.send(`taskId=${taskId}&newValue=${newValue}`);
    }
    