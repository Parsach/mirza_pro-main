# 🤖 Mirza Bot Pro - ربات حرفه‌ای مدیریت VPN

<div align="center">

![Version](https://img.shields.io/badge/version-Pro-blue)
![PHP](https://img.shields.io/badge/PHP-7.4%2B-purple)
![MySQL](https://img.shields.io/badge/MySQL-5.7%2B-orange)
![License](https://img.shields.io/badge/license-MIT-green)
![Stars](https://img.shields.io/github/stars/yourusername/mirza_pro?style=social)

**ربات تلگرامی قدرتمند برای مدیریت و فروش سرویس‌های VPN**

[📚 مستندات کامل](DOCUMENTATION.md) | [🚀 نصب سریع](#نصب-سریع) | [✨ ویژگی‌ها](#ویژگی-ها) | [📞 پشتیبانی](#پشتیبانی)

</div>

---

## 🎉 پروژه نسخه پرو، اوپن‌سورس شد!

نسخه‌ی **Pro** این پروژه اکنون به‌صورت **اوپن‌سورس** در دسترس است. از مشارکت، پیشنهادها و همکاری شما برای توسعه‌ی بهتر پروژه استقبال می‌کنیم 🤝

---

## ✨ ویژگی‌ها

### 🎯 ویژگی‌های اصلی
- ✅ **پشتیبانی از پنل‌های محبوب**: Marzban, Marzneshin, X-UI, Hiddify, S-UI, WireGuard
- ✅ **سیستم پرداخت یکپارچه**: درگاه‌های ایرانی و ارزی
- ✅ **Mini App تلگرام**: رابط کاربری مدرن با React
- ✅ **API جامع**: برای توسعه و یکپارچه‌سازی
- ✅ **سیستم زیرمجموعه‌گیری**: Affiliate marketing
- ✅ **پنل ادمین قدرتمند**: مدیریت کامل از تلگرام

### 🛡️ امنیت
- 🔐 احراز هویت دو مرحله‌ای
- 🔐 Anti-Spam و Rate Limiting
- 🔐 IP Validation برای Webhook
- 🔐 Prepared Statements (PDO)

### 📊 گزارشات و آمار
- 📈 آمار فروش و درآمد
- 📈 گزارش مصرف کاربران
- 📈 نمودارهای تحلیلی
- 📈 لاگ‌های کامل سیستم

---

## 🚀 نصب سریع

### پیش‌نیازها
- PHP 7.4+
- MySQL 5.7+
- SSL Certificate
- Composer

### دستورات نصب

```bash
# 1. کلون کردن پروژه
git clone https://github.com/yourusername/mirza_pro.git
cd mirza_pro

# 2. نصب وابستگی‌ها
composer install

# 3. ایجاد دیتابیس
mysql -u root -p -e "CREATE DATABASE mirza_bot CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"

# 4. پیکربندی
cp config.sample.php config.php
nano config.php

# 5. اجرای جداول
php table.php

# 6. تنظیم Webhook
curl "https://api.telegram.org/bot{TOKEN}/setWebhook?url=https://yourdomain.com/index.php"
```

---

## 📁 ساختار پروژه

```
mirza_pro/
├── 📁 api/          # RESTful API endpoints
├── 📁 app/          # Mini App (React)
├── 📁 panel/        # Admin panel
├── 📁 payment/      # Payment gateways
├── 📄 index.php     # Main bot file
├── 📄 admin.php     # Admin panel
├── 📄 config.php    # Configuration
└── 📄 table.php     # Database structure
```

---

## 🔧 پیکربندی

ویرایش فایل `config.php`:

```php
$dbname = 'mirza_bot';                    // نام دیتابیس
$usernamedb = 'your_db_user';            // کاربر دیتابیس
$passworddb = 'your_db_pass';            // رمز دیتابیس
$APIKEY = 'YOUR_BOT_TOKEN';              // توکن ربات
$adminnumber = 'YOUR_ADMIN_ID';          // آیدی ادمین
$domainhosts = 'https://yourdomain.com'; // دامنه
$usernamebot = 'your_bot_username';      // یوزرنیم ربات
```

---

## 🎛️ پنل‌های پشتیبانی شده

| پنل | نسخه | وضعیت |
|------|------|--------|
| Marzban | v0.4.0+ | ✅ کامل |
| Marzneshin | All | ✅ کامل |
| X-UI Alireza | All | ✅ کامل |
| Hiddify | Latest | ✅ کامل |
| S-UI | All | ✅ کامل |
| WireGuard | Dashboard | ✅ کامل |
| MikroTik | RouterOS | ✅ کامل |
| IBSng | All | ✅ کامل |

---

## 📱 Mini App

ربات دارای Mini App با رابط کاربری مدرن است:

- **Framework**: React + Vite
- **UI Library**: Tailwind CSS
- **Icons**: Lucide React
- **Features**: 
  - خرید آنلاین
  - مدیریت سرویس‌ها
  - کیف پول
  - پروفایل کاربری

---

## 🔌 API Documentation

### Authentication
```http
Header: Token: your-api-token
```

### Endpoints
- `GET /api/users` - لیست کاربران
- `GET /api/invoice` - لیست فاکتورها
- `POST /api/service` - ایجاد سرویس
- [مستندات کامل API](DOCUMENTATION.md#api-documentation)

---

## 🛠️ توسعه

### ساختار کد
```php
// مثال استفاده از توابع
$user = select("user", "*", "id", $user_id);
sendmessage($chat_id, "پیام", $keyboard);
$panel = new ManagePanel();
$result = $panel->createUser($username, $password);
```

### افزودن پنل جدید
1. ایجاد فایل در root directory
2. پیاده‌سازی interface مورد نیاز
3. ثبت در `panels.php`

---

## 📊 دیتابیس

### جداول اصلی
- `user` - اطلاعات کاربران
- `invoice` - فاکتورها
- `product` - محصولات
- `payment` - پرداخت‌ها
- `marzban_panel` - پنل‌های Marzban
- `setting` - تنظیمات

---

## 🔐 امنیت

- ✅ HTTPS اجباری
- ✅ IP Validation
- ✅ SQL Injection Protection
- ✅ XSS Protection
- ✅ Rate Limiting
- ✅ Token Authentication

---

## 🤝 مشارکت

مشارکت شما باعث بهبود پروژه می‌شود:

1. Fork کنید
2. Branch بسازید (`git checkout -b feature/AmazingFeature`)
3. Commit کنید (`git commit -m 'Add AmazingFeature'`)
4. Push کنید (`git push origin feature/AmazingFeature`)
5. Pull Request بفرستید

---

## 📞 پشتیبانی

- 📧 **Email**: support@yourdomain.com
- 💬 **Telegram**: [@your_support_bot](https://t.me/your_support_bot)
- 📢 **Channel**: [@your_channel](https://t.me/your_channel)
- 🐛 **Issues**: [GitHub Issues](https://github.com/yourusername/mirza_pro/issues)

---

## 💖 حمایت از پروژه

اگر این پروژه برای شما مفید بوده، می‌توانید از طریق روش‌های زیر حمایت کنید:

- ⭐ **Star** دادن به پروژه
- 🔄 **Fork** و مشارکت در توسعه
- 💰 **حمایت مالی**: [NowPayments](https://nowpayments.io/donation/permiumbotmirza)
- 📢 **معرفی** به دوستان

---

## 📜 مجوز

این پروژه تحت مجوز [MIT License](LICENSE) منتشر شده است.

---

## 🙏 تشکر ویژه

از تمام توسعه‌دهندگان و کاربرانی که در بهبود این پروژه نقش داشته‌اند، تشکر می‌کنیم.

---

<div align="center">

**ساخته شده با ❤️ برای جامعه ایرانی**

[بالا](#-mirza-bot-pro---ربات-حرفه‌ای-مدیریت-vpn)

</div>
