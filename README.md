# 🛒 Online Shopping System

A complete **Online Shopping** web application built with **HTML, CSS, JavaScript, PHP**, and **MySQL**.  
Users can browse products, add them to the cart, and place orders. Admin can manage products and view orders.

---

## ✨ Features
- 🔑 User Registration & Login (with role-based access: User/Admin)
- 🛍️ Product Listing with Images
- 🛒 Shopping Cart & Checkout
- 📦 Order Management
- 🛠️ Admin Panel for Product Management
- 🗄️ MySQL Database Integration

---

## 🗄️ Database Schema

**Database Name:** `onlineshop`

### 1️⃣ `users` Table
```sql
CREATE TABLE users (
    id INT(11) NOT NULL AUTO_INCREMENT,
    username VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('user', 'admin') DEFAULT 'user',
    PRIMARY KEY (id),
    UNIQUE KEY username (username),
    UNIQUE KEY email (email)
);
