# 🩸 Blood Bank Management System

A web-based system for managing blood donations, appointments, donors, nurses, hospitals, and blood inventory.<br>

Developed by<br>
Bereket Asfaw<br>

Technologies<br>

| Layer Technology<br>

| Frontend: HTML5, CSS3, JavaScript<br>
| Backend: PHP 8.0<br>
| Database: MySQL<br>
| Server: Apache (XAMPP)<br>

User Roles<br>

| Role | Responsibilities<br>

| Donor : Register, book appointments, check eligibility<br>
| Nurse : Verify donors, update donation status<br>
| Hospital Admin : Manage nurses, view donation records<br>
| System Admin : Full system control, manage all users<br>

 Login Credentials

| Role | Email | Password
| System Admin : admin.bloodbank@gmail.com | admin123 |
| Donor : johndoe@gmail.com | donor123 |
| Nurse : sarah.nurse@gmail.com | nurse123 |
| Hospital Admin : wolkite.hospital@gmail.com | hospital123 |

Installation

1. Install :XAMPP
2. Copy folder to `C:\xampp\htdocs\`
3. Import `blood_bank.sql` to phpMyAdmin
4. Update `config/db_connect.php` with your DB credentials
5. Run: `http://localhost/Blood-Bank-system`

---

Security Features

- ✅ Prepared Statements (SQL Injection prevention)
- ✅ MD5 Password Hashing
- ✅ Session Management
- ✅ Role-Based Access Control<br>

Project Structure<br>

Blood-Bank-system/<br>
|<br>
├── admin/ # Admin module<br>
├── donor/ # Donor module<br>
├── nurse/ # Nurse module<br>
├── hospital/ # Hospital module<br>
├── config/ # Database config<br>
├── css/ # Stylesheets<br>
├── database/ # SQL file<br>
└── index.php # Landing page<br>
