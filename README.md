# Kanban Board

This is a project for the course "Webentwicklung" at the University of Trier. The goal of this project is to develop a Kanban Board as a web application. A Kanban Board is a project management tool that helps visualize work, limit work-in-progress, and maximize efficiency.

## Table of Contents
- [Description](#description)
- [Important Note](#important-note)
- [Installation](#installation)
- [Usage](#usage)
- [Screenshots](#screenshots)
  - [Main Task View](#main-task-view)
  - [Task Element](#task-element)
  - [Task CRUD Modal](#task-crud-modal)
  - [Spalten Table View](#spalten-table-view)
  - [Login View](#login-view)
  - [User roles](#user-roles)
- [Project Structure](#project-structure)
- [Contributing](#contributing)
- [License](#license)
- [Contact](#contact)

## Description

This project is a web application developed using the CodeIgniter Framework. It includes a CRUD (Create, Read, Update, Delete) system for managing various types of data, such as Boards, Spalten, Tasks, Personen, and Taskarten. The application uses modals for creating, editing, deleting, and copying data. It also includes forms for each data type and a toast notification system for CRUD operations.

## Important Note

Since this project was developed for a german course, all the terms visible to the user will be in german.
As such this README will use those terms as well. The code itself is mostly written in english and so are the commits.
The following is a brief translation of the most important terms:

- **Spalten**: Columns
- **Personen**: People
- **Taskarten**: Task Types
- **Neu**: New
- **Profil**: Profile
- **Meine Aufgaben**: My Tasks
- **Bearbeiten**: edit
- **Löschen**: delete

## Installation

### Prerequisites

- **PHP 8.1 – 8.3** with the following extensions enabled: `intl`, `mbstring`, `json`, `mysqli`
  (the bundled CodeIgniter 4.4 framework is **not** compatible with PHP 8.4 or newer)
- **MySQL** or **MariaDB** server
- No `composer install` is required — the CodeIgniter framework is already bundled in the `system/` directory.

### 1. Clone the repository

```bash
git clone https://github.com/JDeffner/Webentwicklung.git
cd Webentwicklung
```

### 2. Configure the environment

1. Rename the [env](env) file in the project root to `.env`.
2. Open `.env` and uncomment/set the following values:

   ```ini
   CI_ENVIRONMENT = development

   # The address you will use to access the application in your browser:
   app.baseURL = 'http://localhost:8080/'

   # Your database connection:
   database.default.hostname = localhost
   database.default.database = kanban
   database.default.username = root
   database.default.password = your_password
   database.default.DBDriver = MySQLi
   database.default.port = 3306
   ```

   Use `CI_ENVIRONMENT = production` when deploying to a live server.

### 3. Create the database

First create an empty database (the name must match `database.default.database` in your `.env`):

```sql
CREATE DATABASE kanban CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
```

Then set up the tables using **one** of the two following options:

#### Option A: SQL import (quick)

Import the [databaseStructure.sql](databaseStructure.sql) file, e.g. via phpMyAdmin or the command line:

```bash
mysql -u root -p kanban < databaseStructure.sql
```

#### Option B: Migrations (recommended)

Use the CodeIgniter migration system to build the schema and seed it:

```bash
php spark migrate
php spark db:seed DatabaseSeeder
```

The migrations create all tables, and the seeder inserts the required initial data.
Migrations can be rolled back with `php spark migrate:rollback` and their status
checked with `php spark migrate:status`.

> [!IMPORTANT]
> Both options seed data that the application **needs to function**:
> - An **admin account** — the registration form only creates regular users
>   (permission level 1), so without this seeded account (permission level 2)
>   nobody could ever access the admin views (Taskarten and Personen management).
> - Four default **Taskarten** (task types) — every Task requires a Taskart,
>   but Taskarten can only be created by an admin.
> - A starter **Board** with three Kanban Spalten (To Do / In Arbeit / Erledigt).

### 4. First login

Log in with the seeded admin account and **change the password immediately** (via Profil):

| E-Mail              | Passwort   |
| ------------------- | ---------- |
| `admin@example.com` | `admin1234` |

### 5. Run the application

For local development the easiest way is the built-in CodeIgniter server:

```bash
php spark serve
```

The application is then available at `http://localhost:8080`.

For production, point your web server's document root at the `public/` directory
(never at the project root). See the
[CodeIgniter deployment documentation](https://codeigniter4.github.io/userguide/installation/deployment.html)
for more information.

### Optional: SCSS Compilation

Only needed if you want to modify the styles:

1. Install node.js. You can download it from the [Official Website](https://nodejs.org/).
2. Run `npm install` to install JavaScript dependencies.
3. Use `npm run scss` to activate a file watcher that compiles any changes in `main.scss` to `main.css` (using [Dart Sass](https://sass-lang.com/dart-sass/)).


## Usage

After the correct deployment, you can access the application in your web browser at the address you specified in the `.env` file.

The application provides a user-friendly interface for managing Tasks inside a Kanban-styled interface. Here's a brief overview of how to use each feature:

- **Tasks**: Tasks are the main entities in this application. You can create a new task by clicking on the "Neu" button in a Spalte. Each task has a name, notes, assignee, and Spalte. You can update these details by clicking on the Task name in the Board view or using the CRUD functions in the dropdown menu located in the top right corner of each Task. The CRUD actions are done inside modals. Tasks can also be dragged and dropped between Spalten to change their status.

- **Boards**: Each Board represents a project or a set of tasks. You can edit or delete a Board by clicking on the corresponding buttons in the Boards view.

- **Spalten**: Each Board can have multiple Spalten. A Spalte represents a stage or a status of Tasks. CRUD operations for Spalten can be performed by clicking on the corresponding buttons in the Board details view.

- **Personen**: Personen are the users or team members in your project. They are assignable to Tasks and can be used to filter Tasks. Personen also have a role, which can be "Administrator" or "Benutzer". Admins can create, update, and delete all data in the application, while Benutzers can only create, update, and delete the non-admin tables.

- **Taskarten**: Taskarten are the categories or types of Tasks in your project. Admins can add a new task type by clicking on the "Neu" button in the Taskarten view.

- **Task View**: The main view of the application is the Task view. Here you can see all the Tasks in your project. You can filter the Tasks using the search box at the top right, which you put into write focus by pressing any key on your keyboard. You can also seach for people by clicking on their icon when they are assigned to a task. This allows you to see all tasks assigned to that person on the currently viewed board.

## Screenshots

### Main Task View

![Task View](screenshots/task-view.png)

### Task Element

![Task Element](screenshots/task-element.png)

From left to right, top to bottom the content of the task element is as follows:
Icon of the Taskart, name of the task, button to open the CRUD dropdown seen in the image, creation date,
reminder date, notes and assignee.

### Task CRUD Modal

![Task CRUD Modal](screenshots/task-crud-modal.png)

### Spalten Table View

![Spalten Table View](screenshots/spalten-table-view.png)

### Login View

![Login View](screenshots/login-view.png)

### User roles

![User Roles](screenshots/guest-role.png)

Gast is a user that is not logged in.

![User Roles](screenshots/benutzer-role.png)

Benutzer is a user that is logged in.

![User Roles](screenshots/admin-role.png)

Admin is a user that is logged in and has admin rights.


## Project Structure

> [!NOTE]
> Since our project is based on the CodeIgniter framework, please refer to the [CodeIgniter application structure documentation](https://codeigniter4.github.io/userguide/concepts/structure.html) for more information about the general project structure.


`root`: Project root directory<br>
&nbsp;├── `.env`: Environment variables<br>
&nbsp;├── `databaseStructure.sql`: SQL script for setting up the database<br>
&nbsp;├── `package.json`: Defines npm package dependencies for the project<br>
&nbsp;├── `app`: Main application directory<br>
&nbsp;│&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;├── `Cells`: CodeIgniter Cells for view fragments<br>
&nbsp;│&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;├── `Config`: Configuration files<br>
&nbsp;│&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;│&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;├── `Routes.php`: Defines the routes and their filters<br>
&nbsp;│&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;│&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;├── `Filters.php`: Configures the scope of the filters<br>
&nbsp;│&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;│&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;└── `Validation.php`: Defines the validation rules used in the Models<br>
&nbsp;│&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;├── `Controllers`: Connect a route call with the views<br>
&nbsp;│&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;├── `Database`: Migrations and Seeds for setting up the database<br>
&nbsp;│&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;├── `Filters`: Filters for pre and post processing of HTTP requests<br>
&nbsp;│&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;├── `Models`: Models for the database tables<br>
&nbsp;│&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;└── `Views`: Views are the output or what the user sees<br>
&nbsp;│&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;├── `components`: Reusable components for views<br>
&nbsp;│&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;├── `layouts`: Layouts for the application<br>
&nbsp;│&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;├── `pages`: Individual pages<br>
&nbsp;│&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;└── `templates`: Templates used in the layouts<br>
&nbsp;├── `public`: Publicly accessible files<br>
&nbsp;│&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;└── `resources`: Resources like CSS, JavaScript, and images<br>
&nbsp;│&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;├── `css`: CSS files for styling<br>
&nbsp;│&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;├── `scss`: SCSS files for styling<br>
&nbsp;│&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;├── `js`: JavaScript files for interactivity<br>
&nbsp;│&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;└── `images`: Images used (e.g. logo)<br>
&nbsp;├── `system`: CodeIgniter system directory<br>
&nbsp;└── `writable`: CodeIgniter write directory<br>

## Contributing

Contributions are welcome. Please fork the repository and create a pull request with your changes. 
For major changes, please open an issue first to discuss what you would like to change. 
If you find a bug, please report it using the issue tracker.

## License

This project is licensed under the MIT License. See the [LICENSE](LICENSE) file for more details.

## Contact

You can contact any of the contributors to this project through their respective E-Mail addresses:

@JDeffner: [s4jodeff@uni-trier.de](mailto:s4jodeff@uni-trier.de)

@talina2: [s4tadara@uni-trier.de](mailto:s4tadara@uni-trier.de)

@s4kecast: [s4kecast@uni-trier.de](mailto:s4kecast@uni-trier.de)
