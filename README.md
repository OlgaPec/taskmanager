# taskmanager
User can sign in od log in to the task manager, add new tasks, change existing, delete old tasks or logout. 

DB settings is in file config.php

Use database with two tables
users (id, username, pass, email)
        int, text, text, text
tasks (id, username, task_name, podrobnosti, termin, priorita)
        int, text, text, text, date, text
