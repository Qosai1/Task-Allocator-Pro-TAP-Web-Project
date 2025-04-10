# 🗂️ Task Allocator Pro (TAP)
A PHP-based task management web application for managing projects, assigning team roles, and tracking progress — built for the **COMP 334 - Web Application and Technologies** course (First Semester 2024/2025) at Birzeit University.

---

## 📌 Overview
Task Allocator Pro (TAP) allows **Managers**, **Project Leaders**, and **Team Members** to:
- Register & authenticate with role-based access.
- Create and manage projects and tasks.
- Allocate teams dynamically.
- Accept, reject, and update task progress.
- View assignment details, search tasks, and more.

The system is fully styled using pure **CSS** with no external frameworks. Backend operations are handled with **PHP (PDO)** and a structured **MySQL database**.

---

## 💻 Technologies Used
- **PHP** (Pure PHP with PDO for DB access)
- **HTML5 & CSS3**
- **MySQL**
- No external libraries or frameworks used

---

## 📁 Project Structure

| Filename                        | Description                                      |
|---------------------------------|--------------------------------------------------|
| `Add_Project.php`              | Form to add a new project (Managers only)        |
| `allocate_team_leader_action.php` | Allocates a leader to a project                  |
| `assign_team.php`              | Assign team members to a task                    |
| `task_creation.php`            | Form for Project Leaders to create tasks         |
| `Accept_task.php`              | Team member accepts assigned task                |
| `Update.php`                   | Updates task progress via slider                 |
| `process_step1.php`            | Step 1 of user registration                      |
| `process_step2.php`            | Step 2 of user registration                      |
| `confirm_registration.php`     | Step 3: Confirm and submit user registration     |
| `login.php / logout.php`       | User login and logout                           |
| `Search.php`                   | Search for tasks with filters                    |
| `task_list.php`                | List all tasks with actions                      |
| `profile.php`                  | Displays logged-in user profile                  |
| `Team_Leader.php`              | Dashboard for project leaders                    |
| `Dashboard.php`                | Common dashboard page                            |
| `dbconfig.inc.php`             | PDO database configuration file                  |
| `registration_success.php`     | Shows success message after registration         |
| `Contact.html`                 | Contact and About Us page                        |
| `E Account.html`               | E-Account info during registration               |
| `information.html`             | Extra help/info page                             |

---

## 🧪 Test Users (Preloaded)
| Role            | Username   | Password   |
|-----------------|------------|------------|
| Manager         | `manager1` | `pass1234` |
| Project Leader  | `leader1`  | `pass1234` |
| Team Member 1   | `member1`  | `pass1234` |
| Team Member 2   | `member2`  | `pass1234` |
| Team Member 3   | `member3`  | `pass1234` |

---

## 🗃️ Database
- Connection handled in `dbconfig.inc.php`
- Uses **prepared statements** with named bindings only.
- Schema file: `dbschema_1210469.sql`

---

## 🚀 Features by Role

### ✅ All Users
- Register and login
- View profile
- Search tasks
- View task details

### 👔 Manager
- Add projects
- Allocate team leaders

### 🧑‍💼 Project Leader
- Create tasks
- Assign team members

### 🧑‍🔧 Team Member
- Accept/Reject tasks
- Update progress using slider
- Update task status

---

## 🎨 UI Highlights
- **Responsive layout** with CSS Flexbox/Grid
- **Dynamic navigation** with hover and active state styling
- Zebra-styled data tables
- File upload with size/type validation
- Task and user views styled based on role/status

---

## 📦 How to Run
1. Place project folder under `htdocs/` if using XAMPP.
2. Import the SQL file `dbschema_1210469.sql` into MySQL.
3. Edit `dbconfig.inc.php` with your DB credentials.
4. Access via: `http://localhost/webprojects/1210469/`

---

## 📅 Submission Info
- **Deadline**: 13/01/2025 – 22:00
- **Submission**: Uploaded to CSHost and ITC
- Ensure all files work correctly via `index.html`

---

## 🧑‍🎓 Developer
**Name**: Qosai Badaha  
**Student ID**: 1210469  
**University**: Birzeit University  
**Course**: COMP 334 – Web Application & Technologies  

---

## 📄 License
This project is for academic purposes only under the COMP334 course at Birzeit University.

