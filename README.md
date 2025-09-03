# E-Commerce API

一個基於 Laravel 5.8 的電商 API 專案，提供產品管理和評論系統的 RESTful API 服務。

## 專案概述

這是一個完整的電商後端 API 系統，支援產品 CRUD 操作、評論系統以及用戶身份驗證。專案使用 Laravel Passport 進行 API 身份驗證，提供安全且標準化的 API 介面。

## 主要功能

### 🛍️ 產品管理 (Product Management)
- **產品 CRUD 操作**：創建、讀取、更新、刪除產品
- **產品資訊**：名稱、詳情描述、價格、庫存數量、折扣
- **分頁顯示**：支援分頁瀏覽，每頁顯示 20 筆產品
- **權限控制**：只有產品擁有者可以修改或刪除自己的產品

### ⭐ 評論系統 (Review System)
- **產品評論**：為產品添加評論和評分
- **評論資訊**：客戶名稱、評論內容、星級評分 (1-5 星)
- **巢狀結構**：評論屬於特定產品，支援一對多關係

### 🔐 身份驗證 (Authentication)
- **Laravel Passport**：使用 OAuth2 進行 API 身份驗證
- **用戶註冊/登入**：完整的用戶註冊和登入流程
- **密碼重設**：支援忘記密碼和重設密碼功能
- **API Token**：安全的 API 存取權杖管理

## 技術規格

- **框架**：Laravel 5.8
- **PHP 版本**：^7.1.3
- **身份驗證**：Laravel Passport 7.2
- **資料庫**：支援 MySQL/PostgreSQL/SQLite
- **API 格式**：RESTful JSON API

## 專案結構

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── ProductController.php    # 產品管理控制器
│   │   ├── ReviewController.php     # 評論管理控制器
│   │   └── Auth/                    # 身份驗證控制器
│   ├── Resources/
│   │   ├── Product/                 # 產品 API 資源
│   │   └── ReviewResource.php       # 評論 API 資源
│   └── Requests/
│       ├── ProductRequest.php       # 產品表單驗證
│       └── ReviewRequest.php        # 評論表單驗證
├── Model/
│   ├── Product.php                  # 產品模型
│   └── Review.php                   # 評論模型
└── Exceptions/
    └── ProductNotBelongsToUser.php  # 自定義例外
```

## API 端點

### 產品相關
```
GET    /api/product              # 取得產品列表 (分頁)
POST   /api/product              # 創建新產品 (需認證)
GET    /api/product/{id}         # 取得單一產品詳情
PUT    /api/product/{id}         # 更新產品 (需認證，僅限擁有者)
DELETE /api/product/{id}         # 刪除產品 (需認證，僅限擁有者)
```

### 評論相關
```
GET    /api/prodect/{product}/review     # 取得產品評論列表
POST   /api/prodect/{product}/review     # 為產品添加評論
PUT    /api/prodect/{product}/review/{id} # 更新評論
DELETE /api/prodect/{product}/review/{id} # 刪除評論
```

### 身份驗證
```
POST   /api/register             # 用戶註冊
POST   /api/login                # 用戶登入
POST   /api/logout               # 用戶登出
GET    /api/user                 # 取得當前用戶資訊 (需認證)
```

## 資料庫結構

### Products 表
- `id` - 主鍵
- `name` - 產品名稱
- `detail` - 產品詳情
- `price` - 價格
- `stock` - 庫存數量
- `discount` - 折扣
- `user_id` - 產品擁有者 ID
- `created_at`, `updated_at` - 時間戳記

### Reviews 表
- `id` - 主鍵
- `product_id` - 產品 ID (外鍵)
- `customer` - 客戶名稱
- `review` - 評論內容
- `star` - 星級評分
- `created_at`, `updated_at` - 時間戳記

## 安裝與設定

### 1. 環境需求
- PHP >= 7.1.3
- Composer
- MySQL/PostgreSQL/SQLite

### 2. 安裝步驟
```bash
# 複製專案
git clone https://github.com/victorbuild/test-ecommerce-api.git
cd test-ecommerce-api

# 安裝依賴
composer install

# 複製環境設定檔
cp .env.example .env

# 生成應用程式金鑰
php artisan key:generate

# 設定資料庫連線 (編輯 .env 檔案)
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ecommerce_api
DB_USERNAME=your_username
DB_PASSWORD=your_password

# 執行資料庫遷移
php artisan migrate

# 安裝 Passport
php artisan passport:install

# 啟動開發伺服器
php artisan serve
```

### 3. API 測試
```bash
# 註冊用戶
curl -X POST http://localhost:8000/api/register \
  -H "Content-Type: application/json" \
  -d '{"name":"John Doe","email":"john@example.com","password":"password","password_confirmation":"password"}'

# 登入取得 Token
curl -X POST http://localhost:8000/api/login \
  -H "Content-Type: application/json" \
  -d '{"email":"john@example.com","password":"password"}'

# 使用 Token 創建產品
curl -X POST http://localhost:8000/api/product \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -d '{"name":"測試產品","description":"產品描述","price":1000,"stock":50,"discount":10}'
```

## 專案特色

- **RESTful 設計**：遵循 REST API 設計原則
- **資源巢狀**：評論資源巢狀在產品資源下
- **權限控制**：細緻的權限管理，確保資料安全
- **資料驗證**：使用 Form Request 進行嚴格的資料驗證
- **API 資源**：統一的 JSON 回應格式
- **例外處理**：自定義例外處理機制

## 學習重點

這個專案展示了以下 Laravel 核心概念：

1. **Eloquent ORM**：模型關聯和資料庫操作
2. **API 資源**：資料格式化和序列化
3. **表單驗證**：Form Request 驗證機制
4. **身份驗證**：Laravel Passport OAuth2 實作
5. **中間件**：API 身份驗證中間件
6. **例外處理**：自定義例外和錯誤處理
7. **資料庫遷移**：資料庫結構管理
8. **RESTful 路由**：API 路由設計

## 開發者

這個專案是 Laravel 學習和練習的成果，展示了完整的 API 開發流程和最佳實踐。

