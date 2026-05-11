# HER Web

## Tech Stack

### Backend
- **PHP:** 8.4.16
- **Framework:** Laravel 12.52.0
- **Database:** MySQL 8.2
- **Admin Panel:** Filament 4.0

### Frontend
- **CSS Framework:** Tailwind CSS
- **Build Tool:** Vite
- **Language:** Indonesian Only

### Security & Authorization
- **Spatie Laravel Permission** - Role & permission management
- **Filament Shield** - Permission integration with Filament

---

## Features

- ✅ Equipment Rental Product Management
- ✅ Service Pages Management
- ✅ Gallery Management
- ✅ FAQ System
- ✅ Contact Form with Rate Limiting
- ✅ Decision Support System (DSS)
- ✅ SEO Management
- ✅ Dynamic Settings
- ✅ Role & Permission Management

---

## System Requirements

| Component | Minimum Version |
|-----------|----------------|
| PHP       | 8.2+           |
| Composer  | 2.8+           |
| MySQL     | 8.0+           |
| Node.js   | 18+            |
| NPM       | 9+             |


## Project Structure
her_web/
├── app/
│   ├── Filament/              # Admin panel resources
│   │   ├── Resources/         # CRUD resources
│   │   ├── Pages/             # Custom pages
│   │   └── Widgets/           # Dashboard widgets
│   ├── Http/
│   │   ├── Controllers/       # Frontend controllers
│   │   └── Middleware/        # Custom middleware
│   ├── Models/                # Eloquent models
│   ├── Services/              # Business logic
│   └── Support/               # Helper functions
├── database/
│   ├── migrations/            # Database migrations
│   └── seeders/               # Database seeders
├── resources/
│   ├── views/
│   │   ├── frontend/          # Frontend Blade templates
│   │   └── filament/          # Filament customizations
│   ├── css/                   # Tailwind CSS
│   └── js/                    # JavaScript files
├── routes/
│   └── web.php                # Web routes
├── public/
│   ├── storage/               # Symlinked storage
│   └── build/                 # Compiled assets
├── storage/
│   └── app/public/            # User uploads
└── .env.example               # Environment template
```

## Recent Changes

- ✅ **2026-04-08:** Removed dual language support (English removed)
- ✅ **2026-04-08:** Removed dark mode feature
- ✅ **2026-04-25:** Dropped `_en` columns from database
- ✅ **2026-04-26:** Updated About page UI with improved layout
- ✅ **2026-04-26:** Fixed mission list numbering display

---
