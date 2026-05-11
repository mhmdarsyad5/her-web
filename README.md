# HER Web - Laravel Equipment Rental Website

Website rental alat berat berbasis Laravel 12 dengan Filament Admin Panel.

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
- ✅ Decision Support System (DSS) - Hybrid AHP-TOPSIS
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

---

## Installation (Local Development)

### 1. Clone Repository

```bash
git clone <repository-url>
cd her_web
```

### 2. Install Dependencies

```bash
composer install
npm install
```

### 3. Environment Setup

```bash
cp .env.example .env
php artisan key:generate
```

Edit `.env`:
```env
APP_NAME="HER Web"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=her_db
DB_USERNAME=root
DB_PASSWORD=

APP_LOCALE=id
APP_TIMEZONE=Asia/Jakarta
```

### 4. Database Setup

**Option A: Import SQL Dump**
```bash
# Import database dari file SQL (jika ada)
mysql -u root -p her_db < db_sewakontruksi.sql
```

**Option B: Run Migrations**
```bash
php artisan migrate
php artisan db:seed
```

### 5. Storage Link

```bash
php artisan storage:link
```

### 6. Build Assets

```bash
npm run build
# atau untuk development
npm run dev
```

### 7. Run Development Server

```bash
php artisan serve
```

Visit: `http://localhost:8000`

**Admin Panel:** `http://localhost:8000/admin`

---

## Docker Setup

### Prerequisites
- Docker Desktop installed
- Docker Compose installed

### Quick Start with Docker

```bash
# Build and start containers
docker-compose up -d

# Run migrations
docker-compose exec app php artisan migrate

# Create storage link
docker-compose exec app php artisan storage:link
```

**Access:**
- Web: `http://localhost:8000`
- Admin: `http://localhost:8000/admin`
- MySQL: `localhost:3306`

### Docker Commands

```bash
# Stop containers
docker-compose down

# View logs
docker-compose logs -f

# Rebuild containers
docker-compose up -d --build

# Access container shell
docker-compose exec app bash
```

---

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
├── docker-compose.yml         # Docker configuration
├── Dockerfile                 # Docker image definition
└── .env.example               # Environment template
```

---

## Admin Panel

**Access:** `/admin`

**Default Credentials:**
- Email: `admin@mail.com`
- Password: `admin@mail.com`

**Features:**
- Dashboard with statistics
- Product/Equipment management
- Service management
- Gallery management
- FAQ management
- Contact messages
- SEO settings
- User & role management

---

## Deployment to VPS (Production)

### 1. Server Requirements

- Ubuntu 20.04+ / Debian 11+
- PHP 8.2+ with extensions: `mbstring`, `xml`, `bcmath`, `pdo_mysql`, `gd`, `zip`
- MySQL 8.0+
- Nginx or Apache
- Composer
- Node.js & NPM

### 2. Clone & Setup

```bash
cd /var/www
git clone <repository-url> her_web
cd her_web

composer install --no-dev --optimize-autoloader
npm install
npm run build
```

### 3. Environment Configuration

```bash
cp .env.example .env
php artisan key:generate
```

Edit `.env` for production:
```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com

DB_HOST=127.0.0.1
DB_DATABASE=her_db
DB_USERNAME=her_user
DB_PASSWORD=strongere

SESSION_DRIVER=file
CACHE_STORE=file
QUEUE_CONNECTION=sync

MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
```

### 4. Database Migration

```bash
php artisan migrate --force
```

### 5. Storage & Permissions

```bash
php artisan storage:link
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data /var/www/her_web
```

### 6. Optimize for Production

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize
```

### inx Configuration

Create `/etc/nginx/sites-available/her_web`:

```nginx
server {
    listen 80;
    server_name yourdomain.com www.yourdomain.com;
    root /var/www/her_web/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.4-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

Enable site:
```bash
ln -s /etc/nginx/sites-available/her_web /etc/nginx/sites-enabled/
nginx -t
systemctl reload nginx
```

### 8. SSL Certificate (Let's Encrypt)

```bash
sudo apt install certbot python3-certbot-nginx
sudo certbot --nginx -d yourdomain.com -d www.yourdomain.com
```

---

## Recent Changes

- ✅ **2026-04-08:** Removed dual language support (English removed)
- ✅ **2026-04-08:** Removed dark mode feature
- ✅ **2026-04-25:** Dropped `_en` columns from database
- ✅ **2026-04-26:** Updated About page UI with improved layout
- ✅ **2026-04-26:** Fixed mission list numbering display

---

## Troubleshooting

### Migration Error: Column not found

```bash
# Clear cache first
php artisan config:clear
php artisan cache:clear

# Then run migration
php artisan migrate
```

### Storage symlink not working

```bash
# Remove old symlink
rm public/storage

# Recreate
php artisan storage:link
```

### Permission denied errors

```bash
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data /var/www/her_web
```
## Assets not loading

```bash
# Rebuild assets
npm run build

# Clear cache
php artisan optimize:clear
```

---

## Development Notes

### Code Style
- Follow PSR-12 coding standards
- Use Laravel best practices
- Keep controllers thin, use services for business logic

### Database Conventions
- Use migrations for all schema changes
- Never edit database directly in production
- Always backup before running migrations

### Git Workflow
- Create feature branches from `main`
- Use descriptive commit messages
- Test before pushing to production

---

## License

Proprietary - All rights reserved

---

## Credits

**Developed by:** [mulaidigital.com](https://lynk.id/mulaidigital.com)  
*Jasa pembuatan website cepat — tepat — powerful* 🚀

---

## Disclaimer

This application is part of a source code collection provided by mulaidigital.com. Purchasers are permitted to use, modify, and further develop this application as needed. Reselling is allowed as long as the application has been significantly modified (at least 30%) and is not sold in its original form.

---

## Support

For issues or questions:
- Email: info@mulaidigital.com
- WhatsApp: +6282186087887
