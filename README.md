✅ Database: onlineshop
1️⃣ Table: users
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
2️⃣ Table: products
          CREATE TABLE products (
              id INT(11) NOT NULL AUTO_INCREMENT,
              name VARCHAR(100) NOT NULL,
              description TEXT NOT NULL,
              price DECIMAL(10,2) NOT NULL,
              image VARCHAR(100) NOT NULL,
              PRIMARY KEY (id)
          );
3️⃣ Table: orders
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
4️⃣ Table: order_items
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




