# Champions 11 Cricket League (C11CL)

> A full-stack web platform for discovering, registering, and managing cricket talent across India.

**Live Site:** [c11clchampionscricketleague.infinityfree.net](https://c11clchampionscricketleague.infinityfree.net)  
**Admin Panel:** [/Panel](https://c11clchampionscricketleague.infinityfree.net/Panel/login.php)  
**GitHub:** [AryanSri-235/frontendc11](https://github.com/AryanSri-235/C11CL)

---

## About

Champions 11 Cricket League (C11CL) is a premier grassroots cricket platform dedicated to identifying, nurturing, and promoting emerging cricket talent across India. Through nationwide trials, professional coaching, competitive league matches, and player auctions, C11CL provides aspiring cricketers with an opportunity to showcase their skills and progress toward higher levels of the sport.

This platform handles the complete digital pipeline — from a player discovering C11CL online, registering for trials, making payment, receiving their certificate, all the way to the internal team managing that data through a secure admin panel.

---

## Features

- **Player Registration** — cricketers register with their details and pay a participation fee
- **Fee Payment** — integrated Razorpay payment gateway (UPI, cards, net banking)
- **Registration Certificate** — auto-generated printable certificate after successful payment
- **Admin Dashboard** — real-time stats and charts for registrations, revenue, and leads
- **Blog / News** — cricket articles managed through a full CMS with rich text editor
- **Careers Portal** — job application form with CV upload
- **Contact Inbox** — public enquiry form with admin-side data view
- **Email Subscriptions** — newsletter signup with automated confirmation emails
- **Abandoned Leads Tracker** — captures incomplete registrations for follow-up

---

## Tech Stack

| Layer | Technology |
|---|---|
| Backend | PHP 8.x (no framework) |
| Database | MySQL via custom PDO wrapper |
| Frontend | Bootstrap 5, Boxicons, Chart.js, DataTables, SweetAlert2 |
| Rich Text Editor | CKEditor 5 |
| Payments | Razorpay |
| Emails | SMTP |
| Hosting | InfinityFree (production) |
| Dev Database | Aiven Cloud MySQL |
| Version Control | Git + GitHub |

---

## Project Structure

```
/
├── index.php                  # Homepage
├── registration/              # Player registration form
├── payment/                   # Razorpay payment flow (Phase 1)
├── payment2/                  # Razorpay payment flow (Phase 2)
├── careers/                   # Job application portal
├── contact-us/                # Public contact form
├── blog/                      # Blog listing page
├── [100+ article folders]     # Individual SEO blog pages
├── layout/                    # Shared header & footer
├── submit.php                 # Registration form handler
├── submit_career.php          # Career application handler
├── email_subscribe.php        # Newsletter subscription handler
├── pdf.php                    # Registration certificate generator
├── db.php                     # Database connection + PDO wrapper
├── .env.php                   # Environment config (gitignored)
├── wp-content/                # Static assets (images, CSS, JS)
└── Panel/                     # Admin panel
    ├── login.php              # Admin login
    ├── dashboard.php          # Stats + charts overview
    ├── phase1data.php         # All player registrations (admin view)
    ├── phase1data_user.php    # Sales team view (limited access)
    ├── phase2data.php         # Phase 2 registrations
    ├── register_data.php      # Registration management
    ├── contact_data.php       # Contact form submissions
    ├── job_data.php           # Career applications
    ├── blog_list.php          # Blog management list
    ├── add_blog.php           # Create blog post (CKEditor)
    ├── edit_blog.php          # Edit blog post
    ├── users.php              # Panel user management
    ├── add-user.php           # Create panel users
    └── head.php               # Auth, RBAC, session, security headers
```

---

## Admin Panel — Role Based Access Control

Every page in the admin panel is gated by authentication and role-based authorization. Roles are enforced in `Panel/head.php` on every single request.

| Role | Access Level |
|---|---|
| `superadmin` | Full access to everything |
| `developer` | Full access + role switching for testing |
| `admin` | Most pages |
| `subadmin` | Limited data pages |
| `sale-leader` | Player registrations view only |

Sessions expire automatically after **8 hours** of inactivity.

---

## Security

### Authentication
- Passwords hashed with **bcrypt** — industry-standard, one-way, irreversible
- No plain-text passwords stored in the database
- Session-based login with 8-hour auto-expiry

### Database Protection
- **Parameterized queries** (prepared statements) throughout the admin panel
- Prevents SQL injection — user input can never manipulate database queries

### Output Security
- All user-generated content passed through `htmlspecialchars()` before rendering
- Prevents XSS (Cross-Site Scripting) attacks

### HTTP Security Headers

| Header | Protection |
|---|---|
| `X-Frame-Options: DENY` | Prevents clickjacking via iframes |
| `X-Content-Type-Options: nosniff` | Prevents MIME-type sniffing |
| `X-XSS-Protection: 1; mode=block` | Browser-level XSS filter |
| `Referrer-Policy: strict-origin-when-cross-origin` | Limits URL leakage |

### Payment Security
- Card and UPI data **never touches this server**
- Handled entirely by **Razorpay** (PCI-DSS Level 1 certified)
- Payment authenticity verified server-side using **HMAC-SHA256 signature**

### Credentials & Secrets
- All secrets (DB password, SMTP, Razorpay keys) stored in `.env.php`
- `.env.php` is **excluded from Git** via `.gitignore` — never committed
- Auto-detects environment (local vs production) and switches config accordingly

### Role Switching
- Developer testing feature restricted to `developer` and `superadmin` only
- No lower-privilege user can escalate their own role

---

## Database Tables

| Table | Purpose |
|---|---|
| `user` | Admin panel accounts |
| `register` | Phase 1 player registrations |
| `register-second` | Phase 2 player registrations |
| `abandoned_leads` | Incomplete registration attempts |
| `blog` | Blog posts |
| `careers_applications` | Job applications |
| `email_subscriptions` | Newsletter signups |
| `contact_queries` | Contact form submissions |
| `history` | Admin login session log |

---

## Running Locally

```bash
# Clone the repo
git clone https://github.com/AryanSri-235/frontendc11.git
cd frontendc11

# Create .env.php with your local DB credentials (see .env.php structure)

# Start PHP development server
php -S localhost:8000
```

- Site: http://localhost:8000  
- Panel: http://localhost:8000/Panel/  
- Requires: PHP 8.x, MySQL

---

## Deployment

Production is hosted on **InfinityFree**.

- Upload changed files via FTP or InfinityFree File Manager
- `.env.php` auto-switches DB connection — no manual changes needed
- **Never upload:** `.env.php`, `debug_login.php`, `payment/verify_debug.txt`, `.git/`

---

## Git Workflow

```bash
git add <changed-files>
git commit -m "brief description of change"
git push origin main
```

Every change is tracked with a description — full history visible on GitHub.

---

*Built for Champions 11 Cricket League — empowering cricket talent across India.*
