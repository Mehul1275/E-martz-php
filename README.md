📦 E-Martz – PHP E-Commerce Website

E-Martz is a simple yet powerful e-commerce web application built using Core PHP, MySQL, HTML, CSS, and JavaScript. It provides a complete platform for customers, sellers, and admins to interact, manage products, and process orders securely.

✨ Features
👨‍💻 Customer Side

User registration & login

Browse products with categories

Add to cart & checkout

Order tracking

Wishlist & product reviews

Reset password

🛒 Seller Panel

Seller registration & login

Manage products (add, update, delete)

Manage orders and payments

Seller dashboard with statistics

 
🔑 Admin Panel

Manage users (customers & sellers)

Manage categories & products

Manage orders & payments

View reports & analytics


💳 Payment Integration

Razorpay Payment Gateway for online payments

Cash on Delivery (COD) option


🛠️ Tech Stack

Frontend: HTML5, CSS3, JavaScript

Backend: Core PHP

Database: MySQL

Payment: Razorpay API

Email Service: PHPMailer


📂 Project Structure
E-martz-php/

│── admin/              # Admin dashboard

│── seller/             # Seller panel

│── product/            # Product management

│── payment/            # Payment gateway integration

│── DATABASE FILE/      # SQL database file

│── css/                # Stylesheets

│── js/                 # JavaScript files

│── index.php           # Homepage

│── login.php           # User login

│── register.php        # User signup

│── cart.php            # Shopping cart

│── checkout.php        # Checkout process

│── README.md           # Project documentation


⚡ Installation & Setup

Clone the repo

git clone https://github.com/Mehul1275/E-martz-php.git
cd E-martz-php


Setup Database

Import the SQL file from:

DATABASE FILE/ecommerceweb.sql


Update database credentials inside config.php (or wherever your DB connection is defined).

Configure Payment Gateway

Add your Razorpay API keys in the payment integration file.

(Optional) Configure Stripe test keys if required.

Run the project

Place the project inside your web server root (e.g., htdocs for XAMPP).

Start Apache & MySQL from XAMPP.

Visit:

http://localhost/E-martz-php


🚀 Future Enhancements

Add product recommendations

Improve responsive UI/UX

Implement Laravel version for scalability
