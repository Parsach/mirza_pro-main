# 📚 مستندات کامل پروژه Mirza Bot Pro

## 📋 فهرست مطالب
- [معرفی پروژه](#معرفی-پروژه)
- [معماری و ساختار](#معماری-و-ساختار)
- [پیش‌نیازها](#پیش-نیازها)
- [نصب و راه‌اندازی](#نصب-و-راه-اندازی)
- [ساختار دیتابیس](#ساختار-دیتابیس)
- [فایل‌های اصلی](#فایل-های-اصلی)
- [API Documentation](#api-documentation)
- [پنل‌های پشتیبانی شده](#پنل-های-پشتیبانی-شده)
- [ویژگی‌های کلیدی](#ویژگی-های-کلیدی)
- [پیکربندی](#پیکربندی)
- [امنیت](#امنیت)
- [عیب‌یابی](#عیب-یابی)

---

## 🎯 معرفی پروژه

**Mirza Bot Pro** یک ربات تلگرامی حرفه‌ای برای مدیریت و فروش سرویس‌های VPN است که با زبان PHP نوشته شده است. این پروژه که اکنون به صورت اوپن‌سورس منتشر شده، امکانات گسترده‌ای برای مدیریت کاربران، فروش سرویس‌ها، و اتصال به پنل‌های مختلف VPN را فراهم می‌کند.

### 🌟 ویژگی‌های برجسته:
- ✅ پشتیبانی از چندین پنل VPN محبوب
- ✅ سیستم پرداخت یکپارچه
- ✅ مدیریت کاربران پیشرفته
- ✅ سیستم زیرمجموعه‌گیری (Affiliate)
- ✅ پنل ادمین کامل
- ✅ Mini App برای تلگرام
- ✅ API جامع برای توسعه‌دهندگان
- ✅ پشتیبانی چندزبانه (فارسی/انگلیسی)

---

## 🏗️ معماری و ساختار

### ساختار دایرکتوری:

```
mirza_pro-main/
│
├── 📁 api/                    # API endpoints
│   ├── category.php           # مدیریت دسته‌بندی‌ها
│   ├── discount.php           # سیستم تخفیف
│   ├── documents.txt          # مستندات API
│   ├── invoice.php            # مدیریت فاکتورها
│   ├── keyboard.php           # کیبوردهای ربات
│   ├── log.php               # لاگ‌های سیستم
│   ├── miniapp.php           # Mini App API
│   ├── panels.php            # مدیریت پنل‌ها
│   ├── payment.php           # سیستم پرداخت
│   ├── product.php           # مدیریت محصولات
│   ├── service.php           # مدیریت سرویس‌ها
│   ├── settings.php          # تنظیمات
│   ├── statbot.php           # آمار ربات
│   ├── users.php             # مدیریت کاربران
│   └── verify.php            # احراز هویت
│
├── 📁 app/                    # Mini App (React)
│   ├── assets/               # فایل‌های استاتیک
│   ├── fonts/                # فونت‌ها
│   └── index.html            # صفحه اصلی Mini App
│
├── 📁 cronbot/                # کرون جاب‌ها
├── 📁 ibsng/                  # اتصال به IBSng
├── 📁 panel/                  # پنل مدیریت
├── 📁 payment/                # درگاه‌های پرداخت
├── 📁 sub/                    # Subscription links
├── 📁 vendor/                 # Composer dependencies
├── 📁 vpnbot/                 # VPN bot modules
│
├── 📄 Core Files:
│   ├── index.php             # فایل اصلی ربات
│   ├── admin.php             # پنل ادمین
│   ├── config.php            # پیکربندی اصلی
│   ├── function.php          # توابع عمومی
│   ├── keyboard.php          # کیبوردهای ربات
│   ├── table.php             # ساختار دیتابیس
│   ├── botapi.php            # Telegram Bot API
│   ├── webhooks.php          # Webhook handler
│   └── text.json             # فایل زبان
│
├── 📄 Panel Connectors:
│   ├── Marzban.php           # اتصال به Marzban
│   ├── marzneshin.php        # اتصال به Marzneshin
│   ├── alireza.php           # اتصال به Alireza Panel
│   ├── hiddify.php           # اتصال به Hiddify
│   ├── s_ui.php              # اتصال به S-UI
│   ├── x-ui_single.php       # اتصال به X-UI
│   ├── WGDashboard.php       # اتصال به WireGuard
│   ├── mikrotik.php          # اتصال به MikroTik
│   └── ibsng.php             # اتصال به IBSng
│
└── 📄 Other Files:
    ├── .htaccess             # Apache configuration
    ├── LICENSE               # مجوز پروژه
    ├── README.md             # فایل راهنما
    └── version               # نسخه پروژه
```

---

## 📦 پیش‌نیازها

### نیازمندی‌های سیستم:
- **PHP**: نسخه 7.4 یا بالاتر
- **MySQL/MariaDB**: نسخه 5.7 یا بالاتر
- **وب سرور**: Apache/Nginx با پشتیبانی از SSL
- **Composer**: برای مدیریت وابستگی‌ها
- **دامنه**: با SSL certificate معتبر

### Extensions مورد نیاز PHP:
- `mysqli`
- `PDO`
- `json`
- `curl`
- `mbstring`
- `openssl`

---

## 🚀 نصب و راه‌اندازی

### مرحله 1: کلون کردن پروژه
```bash
git clone https://github.com/yourusername/mirza_pro.git
cd mirza_pro
```

### مرحله 2: نصب وابستگی‌ها
```bash
composer install
```

### مرحله 3: پیکربندی دیتابیس
1. ایجاد دیتابیس جدید در MySQL:
```sql
CREATE DATABASE mirza_bot CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

2. ویرایش فایل `config.php`:
```php
$dbname = 'mirza_bot';           // نام دیتابیس
$usernamedb = 'your_db_user';    // نام کاربری دیتابیس
$passworddb = 'your_db_pass';    // رمز عبور دیتابیس
$APIKEY = 'YOUR_BOT_TOKEN';      // توکن ربات تلگرام
$adminnumber = 'YOUR_ADMIN_ID';  // آیدی عددی ادمین
$domainhosts = 'https://yourdomain.com'; // دامنه سایت
$usernamebot = 'your_bot_username';      // یوزرنیم ربات
```

### مرحله 4: اجرای جداول دیتابیس
```bash
php table.php
```

### مرحله 5: تنظیم Webhook
```bash
https://api.telegram.org/bot{YOUR_BOT_TOKEN}/setWebhook?url=https://yourdomain.com/index.php
```

---

## 🗄️ ساختار دیتابیس

### جداول اصلی:

#### 1. جدول `user` - اطلاعات کاربران
```sql
- id (VARCHAR 500) - آیدی تلگرام کاربر
- username (VARCHAR 500) - یوزرنیم تلگرام
- Balance (INT) - موجودی کیف پول
- User_Status (VARCHAR) - وضعیت کاربر (Active/Blocked)
- number (VARCHAR) - شماره موبایل
- step (VARCHAR) - مرحله فعلی کاربر در ربات
- limit_usertest (INT) - محدودیت تست رایگان
- agent (VARCHAR) - وضعیت نمایندگی
- affiliates (VARCHAR) - زیرمجموعه
- score (INT) - امتیاز کاربر
- token (VARCHAR) - توکن احراز هویت
```

#### 2. جدول `invoice` - فاکتورها
```sql
- id_invoice (VARCHAR) - شناسه فاکتور
- id_user (VARCHAR) - آیدی کاربر
- username (VARCHAR) - نام کاربری سرویس
- Service_location (VARCHAR) - لوکیشن سرور
- time_sell (VARCHAR) - زمان فروش
- name_product (VARCHAR) - نام محصول
- price_product (VARCHAR) - قیمت محصول
- Status (VARCHAR) - وضعیت سرویس
- note (TEXT) - یادداشت
```

#### 3. جدول `product` - محصولات
```sql
- id (INT) - شناسه محصول
- name_product (VARCHAR) - نام محصول
- price_product (VARCHAR) - قیمت
- Volume_constraint (VARCHAR) - محدودیت حجم
- Location (VARCHAR) - لوکیشن سرور
- Service_time (VARCHAR) - مدت زمان سرویس
- Status (VARCHAR) - وضعیت محصول
```

#### 4. جدول `marzban_panel` - پنل‌های Marzban
```sql
- id (INT) - شناسه پنل
- name_panel (VARCHAR) - نام پنل
- url_panel (VARCHAR) - آدرس پنل
- username_panel (VARCHAR) - نام کاربری
- password_panel (VARCHAR) - رمز عبور
- status_panel (VARCHAR) - وضعیت پنل
```

#### 5. جدول `payment` - پرداخت‌ها
```sql
- id (INT) - شناسه پرداخت
- id_user (VARCHAR) - آیدی کاربر
- id_invoice (VARCHAR) - شناسه فاکتور
- time (VARCHAR) - زمان پرداخت
- price (VARCHAR) - مبلغ
- payment_Status (VARCHAR) - وضعیت پرداخت
- payment_type (VARCHAR) - نوع پرداخت
```

#### 6. جدول `setting` - تنظیمات ربات
```sql
- Bot_Status (VARCHAR) - وضعیت ربات
- Channel_Report (VARCHAR) - کانال گزارش
- limit_usertest_all (VARCHAR) - محدودیت تست
- affiliatesstatus (VARCHAR) - وضعیت زیرمجموعه
- keyboardmain (TEXT) - کیبورد اصلی
- helpbot (TEXT) - راهنمای ربات
```

---

## 📁 فایل‌های اصلی

### 1. `index.php` - هسته اصلی ربات
- دریافت و پردازش آپدیت‌های تلگرام
- مدیریت دستورات کاربران
- کنترل دسترسی و احراز هویت
- مسیریابی به بخش‌های مختلف

### 2. `admin.php` - پنل مدیریت
- مدیریت کاربران
- مدیریت محصولات و سرویس‌ها
- آمار و گزارشات
- تنظیمات سیستم
- مدیریت پنل‌های VPN

### 3. `function.php` - توابع عمومی
- توابع دیتابیس (select, update, insert, delete)
- توابع ارسال پیام تلگرام
- توابع تولید کانفیگ
- توابع محاسباتی
- توابع امنیتی

### 4. `keyboard.php` - کیبوردهای ربات
- کیبورد اصلی کاربران
- کیبورد ادمین
- کیبوردهای inline
- کیبوردهای دینامیک

### 5. `panels.php` - مدیریت پنل‌ها
- کلاس ManagePanel
- متدهای اتصال به پنل‌ها
- ایجاد و مدیریت کاربران در پنل‌ها
- دریافت اطلاعات سرویس‌ها

---

## 🔌 API Documentation

### احراز هویت
تمام درخواست‌ها باید شامل هدر `Token` باشند:
```
Token: your-api-token-here
```

### Endpoints اصلی:

#### 1. مدیریت کاربران

**دریافت لیست کاربران:**
```http
GET /api/users
{
    "actions": "users",
    "limit": 10
}
```

**دریافت اطلاعات یک کاربر:**
```http
GET /api/users
{
    "actions": "user",
    "chat_id": "123456789"
}
```

**افزودن کاربر جدید:**
```http
POST /api/users
{
    "actions": "user_add",
    "chat_id": "123456789"
}
```

#### 2. مدیریت فاکتورها

**دریافت لیست فاکتورها:**
```http
GET /api/invoice
{
    "actions": "invoices",
    "limit": 10,
    "page": 1
}
```

**دریافت فاکتور خاص:**
```http
GET /api/invoice
{
    "actions": "invoice",
    "username": "testuser"
}
```

**ایجاد فاکتور جدید:**
```http
POST /api/invoice
{
    "actions": "invoice_add",
    "username": "testuser",
    "name_product": "product1",
    "chat_id": "123456789",
    "location": "Tehran",
    "status": "active"
}
```

#### 3. مدیریت سرویس‌ها

**دریافت لیست سرویس‌ها:**
```http
GET /api/service
{
    "actions": "services",
    "limit": 10
}
```

### Response Format:
```json
{
    "status": true/false,
    "msg": "پیام",
    "obj": {} // داده‌ها
}
```

---

## 🎛️ پنل‌های پشتیبانی شده

### 1. **Marzban Panel**
- نسخه‌های پشتیبانی شده: v0.4.0+
- ویژگی‌ها: مدیریت کامل کاربران، آمار مصرف، QR Code

### 2. **Marzneshin Panel**
- پشتیبانی کامل از API
- مدیریت Inbound ها

### 3. **Alireza Panel (X-UI)**
- نسخه‌های مختلف X-UI
- پشتیبانی از تمام پروتکل‌ها

### 4. **Hiddify Panel**
- اتصال ساده
- مدیریت خودکار

### 5. **S-UI Panel**
- رابط کاربری ساده
- پشتیبانی از Sing-Box

### 6. **WireGuard Dashboard**
- مدیریت WireGuard peers
- تولید کانفیگ خودکار

### 7. **MikroTik**
- مدیریت PPPoE
- کنترل bandwidth

### 8. **IBSng**
- سیستم billing
- مدیریت حساب کاربری

---

## ⚙️ پیکربندی

### تنظیمات اصلی (`config.php`):

```php
// اطلاعات دیتابیس
$dbname = 'database_name';
$usernamedb = 'username';
$passworddb = 'password';

// تنظیمات ربات
$APIKEY = 'bot_token';
$adminnumber = 'admin_id';
$domainhosts = 'https://domain.com';
$usernamebot = 'bot_username';

// تنظیمات پنل
$new_marzban = true; // برای نسخه جدید Marzban
```

### تنظیمات زبان (`text.json`):
فایل JSON شامل تمام متن‌های ربات به دو زبان فارسی و انگلیسی

### تنظیمات کیبورد:
قابل تنظیم از طریق پنل ادمین یا مستقیماً در دیتابیس

---

## 🔐 امنیت

### اقدامات امنیتی پیاده‌سازی شده:

1. **بررسی IP تلگرام**: فقط IP های معتبر تلگرام پذیرفته می‌شوند
2. **Sanitization**: پاکسازی تمام ورودی‌های کاربر
3. **Prepared Statements**: استفاده از PDO برای جلوگیری از SQL Injection
4. **Token Authentication**: برای API endpoints
5. **Rate Limiting**: محدودیت در ارسال پیام (Anti-Spam)
6. **HTTPS Required**: اجباری بودن SSL

### توصیه‌های امنیتی:

1. ✅ همیشه از HTTPS استفاده کنید
2. ✅ رمزهای قوی برای دیتابیس و پنل‌ها
3. ✅ بکاپ منظم از دیتابیس
4. ✅ آپدیت منظم وابستگی‌ها
5. ✅ محدود کردن دسترسی به فایل‌های حساس
6. ✅ استفاده از فایروال

---

## 🛠️ عیب‌یابی

### مشکلات رایج و راه‌حل‌ها:

#### 1. Webhook کار نمی‌کند
- بررسی SSL certificate
- بررسی آدرس webhook
- بررسی لاگ‌های سرور

#### 2. خطای اتصال به دیتابیس
- بررسی اطلاعات config.php
- بررسی دسترسی‌های دیتابیس
- بررسی charset دیتابیس

#### 3. پنل‌ها متصل نمی‌شوند
- بررسی URL و اطلاعات ورود
- بررسی فایروال سرور پنل
- بررسی نسخه پنل

#### 4. پیام‌ها ارسال نمی‌شوند
- بررسی توکن ربات
- بررسی محدودیت‌های تلگرام
- بررسی لاگ‌های خطا

### فایل‌های لاگ:
- `error_log` - خطاهای PHP
- `error_log user` - خطاهای مربوط به کاربران
- لاگ‌های API در جدول `log`

---

## 🔄 بروزرسانی

### نحوه بروزرسانی:

1. **بکاپ گیری**:
```bash
mysqldump -u username -p database_name > backup.sql
cp -r mirza_pro mirza_pro_backup
```

2. **دریافت آخرین نسخه**:
```bash
git pull origin main
```

3. **بروزرسانی وابستگی‌ها**:
```bash
composer update
```

4. **اجرای migration ها**:
```bash
php table.php
```

---

## 🤝 مشارکت

از مشارکت شما در توسعه این پروژه استقبال می‌کنیم!

### نحوه مشارکت:
1. Fork کردن پروژه
2. ایجاد branch جدید
3. اعمال تغییرات
4. ارسال Pull Request

### قوانین مشارکت:
- رعایت استانداردهای کدنویسی
- نوشتن توضیحات کامل برای تغییرات
- تست کامل قبل از PR

---

## 📞 پشتیبانی

- **GitHub Issues**: برای گزارش باگ و درخواست ویژگی
- **Telegram Channel**: @your_channel
- **Email**: support@yourdomain.com

---

## 📜 مجوز

این پروژه تحت مجوز MIT منتشر شده است. برای اطلاعات بیشتر فایل [LICENSE](LICENSE) را مطالعه کنید.

---

## 🙏 تشکر ویژه

از تمام توسعه‌دهندگان و کاربرانی که در بهبود این پروژه مشارکت داشته‌اند، تشکر می‌کنیم.

---

## 📊 وضعیت پروژه

- **نسخه فعلی**: بر اساس فایل `version`
- **وضعیت**: فعال و در حال توسعه
- **آخرین بروزرسانی**: 2024

---

## 🔗 لینک‌های مفید

- [Telegram Bot API](https://core.telegram.org/bots/api)
- [Marzban Documentation](https://github.com/Gozargah/Marzban)
- [PHP Documentation](https://www.php.net/docs.php)
- [MySQL Documentation](https://dev.mysql.com/doc/)

---

**توسعه داده شده با ❤️ برای جامعه ایرانی**
