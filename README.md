
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
````

### 2️⃣ `products` Table

```sql
CREATE TABLE products (
    id INT(11) NOT NULL AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    description TEXT NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    image VARCHAR(100) NOT NULL,
    PRIMARY KEY (id)
);
```

### 3️⃣ `orders` Table

```sql
CREATE TABLE orders (
    id INT(11) NOT NULL AUTO_INCREMENT,
    customer_name VARCHAR(100) NOT NULL,
    address TEXT NOT NULL,
    total_price DECIMAL(10,2) NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    user_id INT(11),
    PRIMARY KEY (id),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
);
```

### 4️⃣ `order_items` Table

```sql
CREATE TABLE order_items (
    id INT(11) NOT NULL AUTO_INCREMENT,
    order_id INT(11) NOT NULL,
    product_name VARCHAR(255) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    quantity INT(11) NOT NULL,
    subtotal DECIMAL(10,2) NOT NULL,
    PRIMARY KEY (id),
    KEY order_id (order_id),
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE
);
```

---

## ⚙️ Installation & Setup

### 1️⃣ Requirements

* **XAMPP / WAMP / MAMP**
* **PHP 7.4+**
* **MySQL**

### 2️⃣ Steps to Run Locally

1. **Clone the repository**

   ```bash
   git clone https://github.com/your-username/onlineshop.git
   ```

2. **Move the project to your server folder**

   ```
   C:\xampp\htdocs\onlineshop
   ```

3. **Start Apache & MySQL** from XAMPP Control Panel.

4. **Create Database & Import Tables**

   ```sql
   CREATE DATABASE onlineshop;
   ```

   Then run the above SQL table creation queries in **phpMyAdmin**.

5. **Database Connection File** (`config.php`)

   ```php
   <?php
   $conn = mysqli_connect("localhost", "root", "", "onlineshop");
   if (!$conn) {
       die("Connection failed: " . mysqli_connect_error());
   }
   ?>
   ```

6. **Run the Project**
   Open browser and go to:

   ```
   http://localhost/onlineshop
   ```

---

## 🚀 Usage

* **User:** Register → Login → Browse products → Add to cart → Checkout.
* **Admin:** Login → Manage products → View orders.

---

## 📌 GitHub Upload Commands

```bash
git init
git add .
git commit -m "Initial commit - Online Shopping Project"
git branch -M main
git remote add origin https://github.com/your-username/onlineshop.git
git push -u origin main
```

---

## 📷 Screenshot (Optional)

> Add a screenshot of your project UI here.

---![login](https://github.com/user-attachments/assets/9343d392-7832-4b0e-ac44-2394b84e7af8)


## 📜 License

This project is licensed under the **MIT License**.

```

---

If you want, I can **add an ER Diagram** image of these four tables and their relationships so your README looks more professional on GitHub.  
Do you want me to include that ER diagram?
```
