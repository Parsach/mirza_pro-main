# 📖 راهنمای نصب و راه‌اندازی کامل Mirza Bot Pro

## 📋 فهرست
1. [پیش‌نیازها](#1-پیش-نیازها)
2. [آماده‌سازی سرور](#2-آماده-سازی-سرور)
3. [نصب پروژه](#3-نصب-پروژه)
4. [پیکربندی دیتابیس](#4-پیکربندی-دیتابیس)
5. [تنظیمات ربات تلگرام](#5-تنظیمات-ربات-تلگرام)
6. [پیکربندی فایل config.php](#6-پیکربندی-فایل-configphp)
7. [راه‌اندازی جداول دیتابیس](#7-راه-اندازی-جداول-دیتابیس)
8. [تنظیم Webhook](#8-تنظیم-webhook)
9. [اتصال پنل‌های VPN](#9-اتصال-پنل-های-vpn)
10. [تست و عیب‌یابی](#10-تست-و-عیب-یابی)

---

## 1. پیش‌نیازها

### سرور مورد نیاز:
- **سیستم عامل**: Ubuntu 20.04+ یا CentOS 8+
- **RAM**: حداقل 2GB (پیشنهادی 4GB)
- **CPU**: حداقل 2 Core
- **فضای دیسک**: حداقل 10GB
- **پهنای باند**: نامحدود

### نرم‌افزارهای مورد نیاز:
```bash
# بررسی نسخه PHP
php -v  # باید 7.4 یا بالاتر باشد

# بررسی MySQL
mysql --version  # باید 5.7 یا بالاتر باشد

# بررسی Composer
composer --version
```

### PHP Extensions:
```bash
# نصب extension های مورد نیاز
sudo apt-get install php-mysqli php-pdo php-json php-curl php-mbstring php-xml php-zip
```

---

## 2. آماده‌سازی سرور

### نصب Apache/Nginx:

**Apache:**
```bash
sudo apt update
sudo apt install apache2
sudo systemctl enable apache2
sudo systemctl start apache2
```

**Nginx:**
```bash
sudo apt update
sudo apt install nginx
sudo systemctl enable nginx
sudo systemctl start nginx
```

### نصب PHP:
```bash
sudo apt install software-properties-common
sudo add-apt-repository ppa:ondrej/php
sudo apt update
sudo apt install php7.4 php7.4-fpm php7.4-mysql php7.4-curl php7.4-json php7.4-mbstring php7.4-xml php7.4-zip
```

### نصب MySQL:
```bash
sudo apt install mysql-server
sudo mysql_secure_installation
```

### نصب Composer:
```bash
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer
```

### نصب SSL Certificate:
```bash
# با استفاده از Certbot
sudo apt install certbot python3-certbot-apache  # برای Apache
# یا
sudo apt install certbot python3-certbot-nginx   # برای Nginx

# دریافت certificate
sudo certbot --apache -d yourdomain.com  # برای Apache
# یا
sudo certbot --nginx -d yourdomain.com   # برای Nginx
```

---

## 3. نصب پروژه

### کلون کردن از GitHub:
```bash
cd /var/www/html
sudo git clone https://github.com/yourusername/mirza_pro.git
cd mirza_pro
```

### تنظیم دسترسی‌ها:
```bash
sudo chown -R www-data:www-data /var/www/html/mirza_pro
sudo chmod -R 755 /var/www/html/mirza_pro
sudo chmod -R 777 /var/www/html/mirza_pro/storage  # اگر وجود دارد
```

### نصب وابستگی‌های Composer:
```bash
composer install --no-dev --optimize-autoloader
```

---

## 4. پیکربندی دیتابیس

### ایجاد دیتابیس و کاربر:
```sql
# ورود به MySQL
sudo mysql -u root -p

# ایجاد دیتابیس
CREATE DATABASE mirza_bot CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

# ایجاد کاربر
CREATE USER 'mirza_user'@'localhost' IDENTIFIED BY 'strong_password_here';

# اعطای دسترسی
GRANT ALL PRIVILEGES ON mirza_bot.* TO 'mirza_user'@'localhost';

# اعمال تغییرات
FLUSH PRIVILEGES;

# خروج
EXIT;
```

---

## 5. تنظیمات ربات تلگرام

### ایجاد ربات جدید:
1. به [@BotFather](https://t.me/BotFather) در تلگرام پیام دهید
2. دستور `/newbot` را ارسال کنید
3. نام ربات را وارد کنید (مثال: Mirza VPN Bot)
4. یوزرنیم ربات را وارد کنید (باید به bot ختم شود، مثال: mirzavpn_bot)
5. توکن ربات را کپی کنید

### تنظیمات اضافی ربات:
```
/setdescription - توضیحات ربات
/setabouttext - درباره ربات
/setuserpic - تصویر پروفایل ربات
/setcommands - دستورات ربات
```

### دستورات پیشنهادی:
```
start - شروع ربات
help - راهنما
account - حساب کاربری
services - سرویس‌های من
support - پشتیبانی
```

---

## 6. پیکربندی فایل config.php

### کپی فایل نمونه:
```bash
cp config.sample.php config.php
# یا اگر فایل نمونه وجود ندارد:
nano config.php
```

### ویرایش تنظیمات:
```php
<?php
// تنظیمات دیتابیس
$dbname = 'mirza_bot';           // نام دیتابیس که ایجاد کردید
$usernamedb = 'mirza_user';      // نام کاربری دیتابیس
$passworddb = 'strong_password'; // رمز عبور دیتابیس

// اتصال به دیتابیس
$connect = mysqli_connect("localhost", $usernamedb, $passworddb, $dbname);
if ($connect->connect_error) { 
    die("Database connection error: " . $connect->connect_error); 
}
mysqli_set_charset($connect, "utf8mb4");

// PDO Connection
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];
$dsn = "mysql:host=localhost;dbname=$dbname;charset=utf8mb4";
try {
    $pdo = new PDO($dsn, $usernamedb, $passworddb, $options);
} catch (\PDOException $e) {
    error_log("Database connection failed: " . $e->getMessage());
}

// تنظیمات ربات
$APIKEY = 'YOUR_BOT_TOKEN_HERE';        // توکن ربات از BotFather
$adminnumber = 'YOUR_TELEGRAM_ID';      // آیدی عددی ادمین اصلی
$domainhosts = 'https://yourdomain.com'; // دامنه سایت با https
$usernamebot = 'mirzavpn_bot';          // یوزرنیم ربات بدون @

// تنظیمات پنل (اختیاری)
$new_marzban = true;  // برای نسخه جدید Marzban
?>
```

### یافتن آیدی عددی تلگرام:
1. به [@userinfobot](https://t.me/userinfobot) پیام دهید
2. آیدی عددی خود را کپی کنید

---

## 7. راه‌اندازی جداول دیتابیس

### اجرای فایل table.php:
```bash
cd /var/www/html/mirza_pro
php table.php
```

### بررسی ایجاد جداول:
```sql
# ورود به MySQL
mysql -u mirza_user -p mirza_bot

# نمایش جداول
SHOW TABLES;

# باید جداول زیر را ببینید:
# - user
# - invoice
# - product
# - payment
# - marzban_panel
# - setting
# - help
# و سایر جداول...
```

---

## 8. تنظیم Webhook

### روش 1: از طریق مرورگر
در مرورگر آدرس زیر را وارد کنید:
```
https://api.telegram.org/botYOUR_BOT_TOKEN/setWebhook?url=https://yourdomain.com/index.php
```

### روش 2: از طریق CURL
```bash
curl -F "url=https://yourdomain.com/index.php" \
     https://api.telegram.org/botYOUR_BOT_TOKEN/setWebhook
```

### بررسی وضعیت Webhook:
```bash
curl https://api.telegram.org/botYOUR_BOT_TOKEN/getWebhookInfo
```

پاسخ موفق:
```json
{
  "ok": true,
  "result": {
    "url": "https://yourdomain.com/index.php",
    "has_custom_certificate": false,
    "pending_update_count": 0,
    "max_connections": 40
  }
}
```

---

## 9. اتصال پنل‌های VPN

### اتصال به Marzban:
1. وارد ربات شوید و `/start` بزنید
2. به پنل ادمین بروید
3. بخش "مدیریت پنل‌ها" را انتخاب کنید
4. "افزودن پنل Marzban" را انتخاب کنید
5. اطلاعات زیر را وارد کنید:
   - نام پنل
   - آدرس پنل (مثال: https://panel.domain.com:8000)
   - نام کاربری ادمین
   - رمز عبور ادمین

### اتصال به X-UI:
مشابه Marzban، اطلاعات پنل X-UI را وارد کنید

### تست اتصال:
در پنل ادمین، گزینه "تست اتصال" را برای هر پنل انتخاب کنید

---

## 10. تست و عیب‌یابی

### تست اولیه:
1. به ربات در تلگرام پیام `/start` بدهید
2. باید منوی اصلی را ببینید
3. دکمه‌های مختلف را تست کنید

### بررسی لاگ‌ها:

**لاگ PHP:**
```bash
tail -f /var/log/apache2/error.log  # Apache
tail -f /var/log/nginx/error.log     # Nginx
```

**لاگ پروژه:**
```bash
tail -f /var/www/html/mirza_pro/error_log
```

### مشکلات رایج:

#### 1. ربات پاسخ نمی‌دهد:
- بررسی کنید Webhook درست تنظیم شده باشد
- SSL certificate معتبر باشد
- فایروال پورت 443 را باز کرده باشد

#### 2. خطای دیتابیس:
- اطلاعات config.php را بررسی کنید
- دسترسی‌های دیتابیس را چک کنید
- charset دیتابیس utf8mb4 باشد

#### 3. خطای 500:
- لاگ‌های PHP را بررسی کنید
- دسترسی‌های فایل‌ها را چک کنید
- PHP extensions نصب شده باشند

### دستورات مفید Debug:

**تست اتصال دیتابیس:**
```php
<?php
require_once 'config.php';
if ($connect) {
    echo "Database connected successfully!";
} else {
    echo "Database connection failed!";
}
?>
```

**تست Webhook:**
```php
<?php
$input = file_get_contents("php://input");
file_put_contents("webhook_log.txt", $input . "\n", FILE_APPEND);
echo "Logged!";
?>
```

---

## 🎉 تبریک!

ربات شما آماده استفاده است. برای تنظیمات بیشتر:

1. **تنظیم درگاه پرداخت**: در پنل ادمین، بخش پرداخت
2. **افزودن محصولات**: در پنل ادمین، بخش محصولات
3. **تنظیم پیام‌ها**: ویرایش فایل `text.json`
4. **فعالسازی کرون جاب‌ها**: برای بررسی خودکار سرویس‌ها

### کرون جاب‌های پیشنهادی:
```bash
# بررسی سرویس‌های منقضی شده (هر ساعت)
0 * * * * php /var/www/html/mirza_pro/cronbot/expire_check.php

# بررسی حجم مصرفی (هر 6 ساعت)
0 */6 * * * php /var/www/html/mirza_pro/cronbot/volume_check.php

# بکاپ دیتابیس (روزانه)
0 3 * * * mysqldump -u mirza_user -p'password' mirza_bot > /backup/mirza_bot_$(date +\%Y\%m\%d).sql
```

---

## 📞 نیاز به کمک؟

- 📚 [مستندات کامل](DOCUMENTATION.md)
- 🐛 [گزارش مشکل](https://github.com/yourusername/mirza_pro/issues)
- 💬 [گروه پشتیبانی](https://t.me/your_support_group)

---

**موفق باشید! 🚀**
