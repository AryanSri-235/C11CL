# C11CL — Champions 11 Cricket League

## Project Overview
PHP website for Champions 11 Cricket League (C11CL). Includes a public-facing frontend and a private admin panel (`/Panel`).

- **Live site (InfinityFree):** production PHP + MySQL on InfinityFree hosting
- **Reference design site:** c11cl.com (used as UI reference)
- **Git remote:** https://github.com/AryanSri-235/frontendc11.git (branch: `main`)
- **Local working directory:** `C:\Users\aryan\Downloads\Public\Public`

---

## Stack
- **Backend:** PHP 8.5.7 (built-in server: `php -S localhost:8000`)
- **Database:** MySQL via PDO (custom wrapper classes in `db.php`)
- **Frontend:** Bootstrap 5, Boxicons, SweetAlert2, DataTables, Chart.js
- **No framework** — pure PHP, no Composer

---

## Running Locally
```
cd C:\Users\aryan\Downloads\Public\Public
php -S localhost:8000
```
Site: http://localhost:8000  
Panel: http://localhost:8000/Panel/

---

## Database Configuration (`/.env.php`)
Smart switcher — auto-detects environment:
- **Local dev** → Aiven Cloud MySQL (credentials in `.env.php`)
- **Production** → InfinityFree MySQL (`sql105.infinityfree.com`)

`db.php` (root) loads `.env.php` and creates a PDO connection wrapped in `C11CLDatabase` / `C11CLStatement` / `C11CLResult` custom classes.  
`Panel/db.php` just does `include_once '../db.php'`.

---

## Project Structure
```
Public/
├── .env.php              # DB credentials (gitignored) — DO NOT COMMIT
├── db.php                # DB connection + custom PDO wrapper classes
├── index.php             # Homepage
├── layout/               # Shared header/footer for frontend
├── components/           # Reusable PHP components
├── Panel/                # Admin dashboard (all admin pages here)
│   ├── head.php          # Session auth, role check, sidebar nav HTML
│   ├── foot.php          # Closing HTML, scripts
│   ├── db.php            # Just includes ../db.php
│   ├── login.php         # Admin login
│   ├── dashboard.php     # Main admin dashboard with charts
│   ├── phase1data.php    # Data Metrics Matrix — all player registrations (admin view)
│   ├── phase1data_user.php # Player Registrations (sales team view, limited)
│   ├── abandoned_leads_view.php # Digital Footprints Log Grid
│   ├── add-user.php      # Create admin panel users ← MODIFIED THIS SESSION
│   ├── check_username.php # AJAX username availability check ← NEW THIS SESSION
│   ├── users.php         # List all panel users
│   ├── blog_list.php     # Blog management list
│   ├── add_blog.php      # Add blog post
│   ├── edit_blog.php     # Edit blog post
│   ├── process_blog.php  # Blog create/update backend handler
│   ├── contact_data.php  # Contact form submissions
│   ├── register_data.php # Registration data
│   ├── phase2data.php    # Phase 2 registration data
│   ├── dashboard.php     # Dashboard with stats + charts
│   ├── report.php        # Reports
│   ├── debug_login.php   # TEMP DEBUG FILE — DELETE AFTER LOGIN IS FIXED
│   └── uploads/          # Profile image uploads
├── [100+ blog/page folders] # Each SEO page is a folder with index.php
└── wp-content/           # Static assets (images, videos, CSS, JS)
```

---

## Auth & Session (`Panel/head.php`)
- Session key: `$_SESSION['uname']`, `$_SESSION['password']`, `$_SESSION['status']`
- Session timeout: 8 hours
- Role-based access control via `$rolePermissions[]` map in `head.php`

**Roles (status field):**
| Value | Access Level |
|---|---|
| `superadmin` | Full access |
| `admin` | Most pages |
| `developer` | Full access |
| `subadmin` | Limited |
| `sale-leader` | Only phase1data_user.php |

---

## Files Changed This Session
Upload ALL of these to InfinityFree to sync with local changes:

| # | File | Change |
|---|---|---|
| 1 | `Panel/add-user.php` | Full rewrite: bcrypt password hashing, parameterized INSERT, secure file upload, confirm password validation, SweetAlert feedback, form repopulates on error |
| 2 | `Panel/check_username.php` | **NEW FILE** — AJAX endpoint for live username availability check (session-gated, parameterized query) |
| 3 | `Panel/login.php` | bcrypt login + remove hardcoded fallback creds (admin/admin123) + session stores `'Y'` not the hash |
| 4 | `Panel/phase1data.php` | MARK SUCCESS button → green style matching live site; modal title → "Player Profile Details" |
| 5 | `Panel/phase1data_user.php` | Modal title → "Player Profile Details" |
| 6 | `Panel/debug_login.php` | TEMP file — diagnoses login issues. **Delete this after login is fixed.** |
| 7 | `Panel/email_submit.php` | SMTP password moved to `.env.php` constants (SMTP_HOST, SMTP_USER, SMTP_PASS, SMTP_PORT) |
| 8 | `.env.php` | Added SMTP_HOST, SMTP_USER, SMTP_PASS, SMTP_PORT constants |
| 9 | `Panel/profile.php` | Fixed SQL injection in SELECT/DELETE/UPDATE; removed password from update form |
| 10 | `Panel/forgot-password.php` | Fixed SQL injection (parameterized SELECT) |
| 11 | `Panel/password-change.php` | Fixed SQL injection; uses password_verify() + bcrypt on save |
| 12 | `Panel/register_data.php` | Fixed SQL injection in UPDATE (edit modal); validate date inputs |
| 13 | `Panel/users.php` | Fixed XSS: all output in card HTML now htmlspecialchars()-escaped |
| 14 | `Panel/head.php` | Added HTTP security headers (X-Frame-Options, X-Content-Type-Options, X-XSS-Protection, Referrer-Policy) |
| 15 | `Panel/create_blog.php` | Removed GD dependency (compressImage); now uses move_uploaded_file + getimagesize validation |
| 16 | `Panel/edit_blog.php` | Parameterized SELECT queries; htmlspecialchars() on all form output to prevent XSS |

---

## Known Issues / In Progress

### Login not working for new bcrypt users (InfinityFree only)
- **Symptom:** "Wrong username and password" even though `debug_login.php` shows `password_verify: PASS`
- **Debug page:** `http://localhost:8000/Panel/debug_login.php?u=USERNAME&p=PASSWORD`
- **Most likely cause:** InfinityFree DB `user.password` column is too short (needs VARCHAR(255))
- **Fix:** Run in phpMyAdmin → `ALTER TABLE user MODIFY password VARCHAR(255);` then re-create the user via add-user.php
- **Status:** Under investigation

### Security issues still to fix (lower priority)
- None remaining — all known SQL injection and XSS issues have been fixed

---

## Deployment — InfinityFree
- Upload changed files via FTP or InfinityFree file manager
- Production DB is separate from local (InfinityFree MySQL vs Aiven Cloud)
- `.env.php` auto-switches based on `$_SERVER['HTTP_HOST']` — no manual change needed
- **Do NOT upload:** `debug_login.php`, `.git/`, `.DS_Store`

---

## DB Tables (known)
| Table | Used in |
|---|---|
| `user` | Admin panel users (login, add-user.php) |
| `register` | Player registrations (phase1data.php, phase1data_user.php) |
| `abandoned_leads` | Incomplete registrations (abandoned_leads_view.php) |
| `blog` | Blog posts (blog_list, add_blog, edit_blog) |
| `history` | Login session tracking (login.php) |
| `email_subscriptions` | Email signups (email_submit.php) |

---

## Git Commits This Session
```
914a0ca Panel UI: match live site design + MARK SUCCESS button + login debug
7ac47ee Secure add-user: bcrypt hashing, parameterized queries, safe uploads
```
