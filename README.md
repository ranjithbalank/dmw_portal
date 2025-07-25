<!-- <p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[WebReinvent](https://webreinvent.com/)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Jump24](https://jump24.co.uk)**
- **[Redberry](https://redberry.international/laravel/)**
- **[Active Logic](https://activelogic.com)**
- **[byte5](https://byte5.de)**
- **[OP.GG](https://op.gg)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT). -->
# 🚀 MyDMW Portal – Release Notes

**Version:** v1.0  
**Release Date:** July 2025  
**Prepared By:** Ranjithbalan K  
**Environment:** Production  
**Modules Included:** Leave Management, Internal Job Postings, Circulars, Asset Tracking, Maintenance Calendar

---

## 📝 Summary

This first version of the **MyDMW Portal** delivers the key modules for managing employee leave, internal job postings, asset tracking, and maintenance calendar.  
With user-friendly interfaces and role-based workflows, this release sets the foundation for digital transformation of internal HR and admin processes.

---

## 📦 General Release Highlights

### 🔧 Core Modules Introduced

- **Leave Management** – Submit, approve, and track employee leaves.
- **Internal Job Postings (IJP)** – HR can post job openings and manage internal applicants.
- **Circulars** – HR can post announcements; employees can only view.
- **Asset Tracking** – Asset management with QR code scanning.
- **Maintenance Calendar** – View and manage scheduled maintenance events.

### ⚙️ Key Features

- 🔐 Role-Based Access Control using `spatie/laravel-permission`
- 📊 Excel Import/Export using `maatwebsite/excel`
- 📄 PDF generation using `dompdf`
- 📆 Calendar UI using `FullCalendar.js`
- 📑 Filter/Search/Pagination via `DataTables`

### 🚀 Performance & Security

- Optimized dashboard load time for large data sets.
- Secure file uploads with validations and error handling.

### 📘 Documentation

- Admin and user guides included for Leave and IJP modules.

---

## 🔍 Module-Wise Release Details

### 📌 Leave Management

- Employees can apply for leave.
- Manager and HR approval flow.
- Leave calendar view integrated.

### 📌 Internal Job Postings (IJP)

- HR can post internal job opportunities with IJP ID and details.
- Employees can apply through the portal.
- Excel upload for final status sync with DB.
- Status badges (e.g., ✅ Selected, ❌ Rejected).
- Advanced filters and search using DataTables.

---

## ⚙️ Technical Overview

| Item              | Details                                         |
|-------------------|--------------------------------------------------|
| **Framework**     | Laravel 11.x                                     |
| **Packages**      | spatie/laravel-permission, maatwebsite/excel, dompdf, fullcalendar.js, pdf.js |
| **Database**      | Schema updates for assets, job postings, leave   |
| **Migrations**    | Tables created: `assets`, `internal_job_postings`, `leave_requests` |
| **Testing**       | Excel upload tested with mock data               |

---

## ✅ Deployment Checklist

- [x] Ran all pending migrations
- [x] Verified all role permissions
- [x] Uploaded and tested sample Excel files
- [x] Confirmed leave approval workflow
- [x] Asset QR scanner tested on mobile

---

## 🚧 Roadmap / Next Steps

- 🗓 Interview scheduling module under IJP  
- 📱 REST API for mobile portal integration  
- 📥 Bulk job posting import/export  
- 📈 Role-based reporting and analytics  

---

## 🙌 Thank You

Thank you for using **MyDMW Portal**! We look forward to your feedback and continuous improvements.
