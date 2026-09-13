# Bangla Model School Management System

![Laravel](https://img.shields.io/badge/Laravel-11.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?style=for-the-badge&logo=php&logoColor=white)
![TailwindCSS](https://img.shields.io/badge/Tailwind_CSS-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)

A professional, lavender-themed School ERP system built with Laravel.

## 🚀 Live Demo
**URL:** [https://school-erp-system-wa63.onrender.com/](https://school-erp-system-wa63.onrender.com/)

---

## 🛠 Features
- **Student Management:** Admission, ID cards, and profiles.
- **Academic Management:** Classes, subjects, and results.
- **Human Resources:** Teacher profiles and management.
- **Financial System:** Fee tracking and staff salaries.
- **Public Website:** Gallery, events, and contact form.
- **Admin Dashboard:** Overview of all school activities.

## 🎨 Design Theme
- **Primary Color:** Lavender Purple (#7C3AED)
- **Secondary Color:** Nature Green (#15803d)
- **Aesthetic:** Modern, Glassmorphism, and Clean Typography.

## 💻 Tech Stack
- **Backend:** Laravel 11 (PHP 8.2)
- **Frontend:** HTML5, CSS3, JavaScript (Vite)
- **Database:** MySQL (Local) / SQLite (Production)
- **Deployment:** Render (Docker)
---

## ⚙️ Local Setup Instructions

1. Clone the repository:
   ```bash
   git clone https://github.com/Nabid-Ahmad/school_erp_system.git
   ```
2. Install PHP dependencies:
   ```bash
   composer install
   ```
3. Install Node dependencies:
   ```bash
   npm install && npm run build
   ```
4. Copy the environment file and generate the app key:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
5. Run database migrations:
   ```bash
   php artisan migrate --seed
   ```
6. Start the local server:
   ```bash
   php artisan serve
   ```
