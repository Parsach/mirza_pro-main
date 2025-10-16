# 🔌 مستندات کامل API - Mirza Bot Pro

## 📋 فهرست
- [معرفی](#معرفی)
- [احراز هویت](#احراز-هویت)
- [فرمت پاسخ](#فرمت-پاسخ)
- [Endpoints](#endpoints)
  - [Users API](#users-api)
  - [Invoice API](#invoice-api)
  - [Service API](#service-api)
  - [Product API](#product-api)
  - [Payment API](#payment-api)
  - [Panel API](#panel-api)
  - [Settings API](#settings-api)
  - [Statistics API](#statistics-api)
- [کدهای خطا](#کدهای-خطا)
- [نمونه کدها](#نمونه-کدها)

---

## 📖 معرفی

API ربات Mirza Bot Pro امکان دسترسی برنامه‌نویسی به تمام امکانات ربات را فراهم می‌کند. این API به صورت RESTful طراحی شده و از JSON برای تبادل داده استفاده می‌کند.

### Base URL
```
https://yourdomain.com/api/
```

### Headers مورد نیاز
```http
Content-Type: application/json
Token: your-api-token-here
```

---

## 🔐 احراز هویت

تمام درخواست‌ها باید شامل هدر `Token` باشند. این توکن را می‌توانید از پنل ادمین دریافت کنید.

### دریافت توکن
```php
// در پنل ادمین ربات
// منو ادمین > تنظیمات API > تولید توکن
```

### استفاده از توکن
```bash
curl -H "Token: your-api-token-here" \
     -H "Content-Type: application/json" \
     https://yourdomain.com/api/users
```

---

## 📊 فرمت پاسخ

### پاسخ موفق
```json
{
    "status": true,
    "msg": "Successful",
    "obj": {
        // داده‌های درخواستی
    }
}
```

### پاسخ خطا
```json
{
    "status": false,
    "msg": "Error description",
    "obj": []
}
```

---

## 🔗 Endpoints

### Users API

#### 1. دریافت لیست کاربران
```http
GET /api/users
```

**Parameters:**
```json
{
    "actions": "users",
    "limit": 10,
    "page": 1,
    "search": "optional_search_term"
}
```

**Response:**
```json
{
    "status": true,
    "msg": "Successful",
    "obj": [
        {
            "id": "123456789",
            "username": "user123",
            "Balance": 50000,
            "User_Status": "Active",
            "number": "09123456789",
            "register": "1704067200",
            "score": 100
        }
    ]
}
```

#### 2. دریافت اطلاعات یک کاربر
```http
GET /api/users
```

**Parameters:**
```json
{
    "actions": "user",
    "chat_id": "123456789"
}
```

**Response:**
```json
{
    "status": true,
    "msg": "Successful",
    "obj": {
        "id": "123456789",
        "username": "user123",
        "Balance": 50000,
        "User_Status": "Active",
        "number": "09123456789",
        "step": "none",
        "limit_usertest": 1,
        "agent": "f",
        "affiliates": "0",
        "score": 100,
        "register": "1704067200"
    }
}
```

#### 3. افزودن کاربر جدید
```http
POST /api/users
```

**Parameters:**
```json
{
    "actions": "user_add",
    "chat_id": "123456789",
    "username": "optional_username"
}
```

**Response:**
```json
{
    "status": true,
    "msg": "User added successfully"
}
```

#### 4. ویرایش کاربر
```http
PUT /api/users
```

**Parameters:**
```json
{
    "actions": "user_edit",
    "chat_id": "123456789",
    "Balance": 100000,
    "User_Status": "Active"
}
```

#### 5. حذف کاربر
```http
DELETE /api/users
```

**Parameters:**
```json
{
    "actions": "user_delete",
    "chat_id": "123456789"
}
```

---

### Invoice API

#### 1. دریافت لیست فاکتورها
```http
GET /api/invoice
```

**Parameters:**
```json
{
    "actions": "invoices",
    "limit": 10,
    "page": 1,
    "status": "active",
    "user_id": "optional_user_id"
}
```

**Response:**
```json
{
    "status": true,
    "msg": "Successful",
    "obj": [
        {
            "id_invoice": "INV_123456",
            "id_user": "123456789",
            "username": "test_user",
            "Service_location": "Germany",
            "time_sell": "1704067200",
            "name_product": "VIP Package",
            "price_product": "50000",
            "Status": "active",
            "note": "Customer note",
            "inboundid": "inbound_123"
        }
    ]
}
```

#### 2. دریافت فاکتور با username
```http
GET /api/invoice
```

**Parameters:**
```json
{
    "actions": "invoice",
    "username": "test_user"
}
```

#### 3. ایجاد فاکتور جدید
```http
POST /api/invoice
```

**Parameters:**
```json
{
    "actions": "invoice_add",
    "username": "test_user",
    "name_product": "VIP Package",
    "chat_id": "123456789",
    "location": "Germany",
    "status": "active",
    "note": "Optional note"
}
```

#### 4. بروزرسانی فاکتور
```http
PUT /api/invoice
```

**Parameters:**
```json
{
    "actions": "invoice_update",
    "id_invoice": "INV_123456",
    "Status": "expired",
    "note": "Updated note"
}
```

---

### Service API

#### 1. دریافت لیست سرویس‌ها
```http
GET /api/service
```

**Parameters:**
```json
{
    "actions": "services",
    "limit": 10,
    "type": "extend_user"
}
```

**Response:**
```json
{
    "status": true,
    "msg": "Successful",
    "obj": [
        {
            "id": 88,
            "id_user": "123456789",
            "username": "service_username",
            "time": "2024/11/11 14:21:16",
            "price": "120000",
            "type": "extend_user",
            "status": "paid"
        }
    ]
}
```

#### 2. ایجاد سرویس جدید
```http
POST /api/service
```

**Parameters:**
```json
{
    "actions": "service_add",
    "user_id": "123456789",
    "product_id": 5,
    "panel_id": 2,
    "username": "custom_username"
}
```

#### 3. تمدید سرویس
```http
POST /api/service
```

**Parameters:**
```json
{
    "actions": "service_extend",
    "username": "service_username",
    "days": 30,
    "volume": 50
}
```

#### 4. غیرفعال کردن سرویس
```http
POST /api/service
```

**Parameters:**
```json
{
    "actions": "service_disable",
    "username": "service_username"
}
```

---

### Product API

#### 1. دریافت لیست محصولات
```http
GET /api/product
```

**Parameters:**
```json
{
    "actions": "products",
    "status": "active",
    "location": "Germany"
}
```

**Response:**
```json
{
    "status": true,
    "msg": "Successful",
    "obj": [
        {
            "id": 1,
            "name_product": "VIP 1 Month",
            "price_product": "50000",
            "Volume_constraint": "50",
            "Location": "Germany",
            "Service_time": "30",
            "Status": "active",
            "limitusers": "1",
            "desc": "VIP package with premium features"
        }
    ]
}
```

#### 2. افزودن محصول
```http
POST /api/product
```

**Parameters:**
```json
{
    "actions": "product_add",
    "name_product": "New VIP Package",
    "price_product": "75000",
    "Volume_constraint": "100",
    "Location": "Germany",
    "Service_time": "30",
    "limitusers": "1"
}
```

---

### Payment API

#### 1. دریافت لیست پرداخت‌ها
```http
GET /api/payment
```

**Parameters:**
```json
{
    "actions": "payments",
    "limit": 20,
    "status": "paid",
    "user_id": "123456789"
}
```

**Response:**
```json
{
    "status": true,
    "msg": "Successful",
    "obj": [
        {
            "id": 101,
            "id_user": "123456789",
            "id_invoice": "INV_123456",
            "time": "1704067200",
            "price": "50000",
            "payment_Status": "paid",
            "payment_type": "card",
            "transaction_id": "TRX_123456"
        }
    ]
}
```

#### 2. ایجاد پرداخت
```http
POST /api/payment
```

**Parameters:**
```json
{
    "actions": "payment_add",
    "user_id": "123456789",
    "amount": "50000",
    "payment_type": "card",
    "description": "Wallet charge"
}
```

---

### Panel API

#### 1. دریافت لیست پنل‌ها
```http
GET /api/panels
```

**Parameters:**
```json
{
    "actions": "panels",
    "type": "marzban"
}
```

**Response:**
```json
{
    "status": true,
    "msg": "Successful",
    "obj": [
        {
            "id": 1,
            "name_panel": "Main Server",
            "url_panel": "https://panel.domain.com:8000",
            "type": "marzban",
            "status_panel": "active",
            "inbound_count": 5
        }
    ]
}
```

#### 2. تست اتصال پنل
```http
POST /api/panels
```

**Parameters:**
```json
{
    "actions": "panel_test",
    "panel_id": 1
}
```

#### 3. دریافت آمار پنل
```http
GET /api/panels
```

**Parameters:**
```json
{
    "actions": "panel_stats",
    "panel_id": 1
}
```

---

### Settings API

#### 1. دریافت تنظیمات
```http
GET /api/settings
```

**Parameters:**
```json
{
    "actions": "get_settings"
}
```

**Response:**
```json
{
    "status": true,
    "msg": "Successful",
    "obj": {
        "Bot_Status": "on",
        "Channel_Report": "@admin_channel",
        "limit_usertest_all": "1",
        "affiliatesstatus": "on",
        "affiliatespercentage": "20",
        "support_text": "Support: @support_user"
    }
}
```

#### 2. بروزرسانی تنظیمات
```http
PUT /api/settings
```

**Parameters:**
```json
{
    "actions": "update_settings",
    "Bot_Status": "on",
    "affiliatespercentage": "25"
}
```

---

### Statistics API

#### 1. آمار کلی
```http
GET /api/statbot
```

**Parameters:**
```json
{
    "actions": "general_stats"
}
```

**Response:**
```json
{
    "status": true,
    "msg": "Successful",
    "obj": {
        "total_users": 1250,
        "active_users": 980,
        "total_services": 850,
        "active_services": 720,
        "total_revenue": "125000000",
        "today_revenue": "5000000",
        "today_new_users": 25,
        "today_sales": 18
    }
}
```

#### 2. آمار فروش
```http
GET /api/statbot
```

**Parameters:**
```json
{
    "actions": "sales_stats",
    "from_date": "2024-01-01",
    "to_date": "2024-01-31"
}
```

#### 3. آمار کاربران
```http
GET /api/statbot
```

**Parameters:**
```json
{
    "actions": "users_stats",
    "period": "monthly"
}
```

---

## ❌ کدهای خطا

| کد | پیام | توضیحات |
|----|------|---------|
| 400 | Bad Request | پارامترهای نادرست |
| 401 | Unauthorized | توکن نامعتبر |
| 403 | Forbidden | دسترسی غیرمجاز |
| 404 | Not Found | منبع یافت نشد |
| 429 | Too Many Requests | محدودیت درخواست |
| 500 | Internal Server Error | خطای سرور |

### نمونه خطا
```json
{
    "status": false,
    "msg": "Token is invalid or expired",
    "error_code": 401,
    "obj": []
}
```

---

## 💻 نمونه کدها

### PHP
```php
<?php
$url = 'https://yourdomain.com/api/users';
$token = 'your-api-token';

$data = [
    'actions' => 'users',
    'limit' => 10
];

$options = [
    'http' => [
        'header' => [
            "Content-Type: application/json",
            "Token: $token"
        ],
        'method' => 'GET',
        'content' => json_encode($data)
    ]
];

$context = stream_context_create($options);
$result = file_get_contents($url, false, $context);
$response = json_decode($result, true);

if ($response['status']) {
    foreach ($response['obj'] as $user) {
        echo "User: " . $user['username'] . "\n";
    }
}
?>
```

### Python
```python
import requests
import json

url = 'https://yourdomain.com/api/users'
headers = {
    'Content-Type': 'application/json',
    'Token': 'your-api-token'
}

data = {
    'actions': 'users',
    'limit': 10
}

response = requests.get(url, headers=headers, json=data)
result = response.json()

if result['status']:
    for user in result['obj']:
        print(f"User: {user['username']}")
```

### JavaScript (Node.js)
```javascript
const axios = require('axios');

const url = 'https://yourdomain.com/api/users';
const headers = {
    'Content-Type': 'application/json',
    'Token': 'your-api-token'
};

const data = {
    actions: 'users',
    limit: 10
};

axios.get(url, {
    headers: headers,
    data: data
})
.then(response => {
    if (response.data.status) {
        response.data.obj.forEach(user => {
            console.log(`User: ${user.username}`);
        });
    }
})
.catch(error => {
    console.error('Error:', error);
});
```

### cURL
```bash
curl -X GET \
  'https://yourdomain.com/api/users' \
  -H 'Token: your-api-token' \
  -H 'Content-Type: application/json' \
  -d '{
    "actions": "users",
    "limit": 10
}'
```

---

## 🔄 Rate Limiting

API دارای محدودیت درخواست است:
- **100 درخواست در دقیقه** برای هر توکن
- **1000 درخواست در ساعت** برای هر IP

هدرهای پاسخ:
```http
X-RateLimit-Limit: 100
X-RateLimit-Remaining: 95
X-RateLimit-Reset: 1704067260
```

---

## 🔒 Best Practices

1. **همیشه از HTTPS استفاده کنید**
2. **توکن را در متغیرهای محیطی ذخیره کنید**
3. **خطاها را به درستی مدیریت کنید**
4. **از Rate Limiting آگاه باشید**
5. **داده‌های ورودی را validate کنید**

---

## 📞 پشتیبانی API

- **مستندات**: [DOCUMENTATION.md](DOCUMENTATION.md)
- **مشکلات**: [GitHub Issues](https://github.com/yourusername/mirza_pro/issues)
- **پشتیبانی**: support@yourdomain.com

---

**نسخه API: 1.0.0**
