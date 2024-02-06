# Kanban Board

This is a project for the course "Webentwicklung" at the University of Trier. The goal of this project is to develop a Kanban Board as a web application. A Kanban Board is a project management tool that helps visualize work, limit work-in-progress, and maximize efficiency. 

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
- **bearbeiten**: edit
- **löschen**: delete

## Table of Contents
- [Description](#description)
- [Installation](#installation)
- [Usage](#usage)
- [Screenshots](#screenshots)
    - [Main Task View](#main-task-view)
    - [Task Element](#task-element)
    - [Task CRUD Modal](#task-crud-modal)
    - [Spalten Table View](#spalten-table-view)
    - [Login View](#login-view)
    - [User roles](#user-roles)
- [Contributing](#contributing)
- [License](#license)
- [Contact](#contact)

## Description

This project is a web application developed using the CodeIgniter Framework. It includes a CRUD (Create, Read, Update, Delete) system for managing various types of data, such as Boards, Spalten, Tasks, Personen, and Taskarten. The application uses modals for creating, editing, deleting, and copying data. It also includes forms for each data type and a toast notification system for CRUD operations.

## Installation

1. Clone the repository to your local machine.
2. Run `npm install` to install JavaScript dependencies.
3. Set up your database and update the `.env` file with your database credentials.
4. Update the `app.baseURL` variable in the `.env` file with the address you will use to access the application in your web browser.
5. Use whatever deployment method you prefer to deploy the application. See the [CodeIgniter documentation](https://codeigniter4.github.io/userguide/) for more information.

## Usage

After the correct deployment, you can access the application in your web browser at the address you specified in the `.env` file.

The application provides a user-friendly interface for managing Tasks inside a Kanban-styled interface. Here's a brief overview of how to use each feature:

- **Tasks**: Tasks are the main entities in this application. You can create a new task by clicking on the "Neu" button in a Spalte. Each task has a name, notes, assignee, and Spalte. You can update these details by clicking on the Task name in the Board view or using the CRUD functions in the dropdown menu located in the top right corner of each Task. The CRUD actions are done inside modals. Tasks can also be dragged and dropped between Spalten to change their status.

- **Boards**: Each Board represents a project or a set of tasks. You can edit or delete a Board by clicking on the corresponding buttons in the Boards view.

- **Spalten**: Each Board can have multiple Spalten. A Spalte represents a stage or a status of Tasks. CRUD operations for Spalten can be performed by clicking on the corresponding buttons in the Board details view.

- **Personen**: Personen are the users or team members in your project. They are assignable to Tasks and can be used to filter Tasks. When logged in, you can see your own tasks by clicking on the "Meine Aufgaben" button in the user dropdown menu in the top right corner of the application. You can create a new person by signing up with a new account. You can also update your details by clicking on the "Profil" button in the user dropdown menu. Personen also have a role, which can be "Administrator" or "Benutzer". Admins can create, update, and delete all data in the application, while Benutzers can only create, update, and delete the non-admin tables.

- **Taskarten**: Taskarten are the categories or types of Tasks in your project. You can add a new task type by clicking on the "Neu" button in the main menu.

## Screenshots

Here are some screenshots of the application:

### Main Task View

![Task View](screenshots/task-view.png)

### Task Element

![Task Element](screenshots/task-element.png)

From left to right, top to bottom the content of the task element is as follows:
Icon of the taskart, name of the task, button to open the CRUD dropdown seen in the image, creation date,
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


## Contributing

Contributions are welcome. Please fork the repository and create a pull request with your changes. 
For major changes, please open an issue first to discuss what you would like to change. 
If you find a bug, please report it using the issue tracker.

## License

This project is licensed under the MIT License. See the [LICENSE](LICENSE) file for more details.

## Contact

You can contact any of the contributors to this project through their E-Mail addresses provided on their GitHub profiles.