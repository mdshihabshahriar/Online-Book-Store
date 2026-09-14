# Online Book Store

A web-based **Online Book Store** application that allows customers to browse, search, and purchase books online. The system provides separate functionalities for **Admin** and **Customer** users, including book management, shopping cart, checkout, payment method selection, order processing, and purchase history.

The project is developed using **PHP MVC architecture**, MySQL, HTML, CSS, JavaScript, and AJAX.

---

## Project Overview

The Online Book Store provides a convenient platform where customers can explore different categories of books, search for specific books, add books to their cart, and place orders.

The system has two primary user roles:

* **Admin** – Manages books, users, inventory, and customer orders.
* **Customer** – Browses books, searches and filters books, manages the shopping cart, places orders, and views purchase history.

A guest visitor can also browse and search available books before registering or logging in.

---

## Objectives

The main objectives of this project are:

* Provide an easy-to-use online platform for purchasing books.
* Allow customers to search and filter books efficiently.
* Provide a dynamic shopping cart using AJAX.
* Allow administrators to manage books and customers.
* Provide secure user authentication and role-based access.
* Maintain customer order and purchase history.
* Provide an organized and responsive user interface.
* Apply basic web security and data validation practices.

---

## User Roles

### Admin

The Admin has control over the management side of the system.

**Main Features:**

* Admin login and authentication
* Admin dashboard
* Add new books
* View books
* Edit book information
* Delete books
* Manage book inventory and stock
* Manage book categories
* View all registered users
* Remove customers
* View all customer orders
* Filter purchase history by status/date
* Process customer orders
* Update order status
* View total books, customers, orders, and revenue

### Customer

Customers can use the system for browsing and purchasing books.

**Main Features:**

* Customer registration and login
* Profile management
* Change password
* Browse books by category
* Search books by title or author
* Filter books by category
* View book details
* Add books to cart
* Update cart quantity
* Remove books from cart
* View cart total
* Checkout
* Select payment method
* Place orders
* View purchase history
* View order status

### Guest User

Guests can access basic book browsing functionality without logging in.

**Main Features:**

* Browse available books
* Browse book categories
* Search books
* View book details
* Register as a customer

---

## 🛠️ Technologies Used

| Technology       | Purpose                                |
| ---------------- | -------------------------------------- |
| PHP              | Backend development                    |
| MVC Architecture | Application structure                  |
| MySQL            | Database management                    |
| HTML5            | Page structure                         |
| CSS3             | Styling and responsive UI              |
| JavaScript       | Client-side interaction and validation |
| AJAX             | Dynamic requests without page reload   |
| JSON             | AJAX API responses                     |
| PDO / MySQLi     | Database connectivity                  |
| Git & GitHub     | Version control                        |

---

## Architecture

The project follows the **MVC (Model-View-Controller)** architecture.

```text
User Request
     ↓
 Controller
     ↓
   Model
     ↓
  Database
     ↓
 Controller
     ↓
    View
     ↓
   User
```

### Model

Handles:

* Database operations
* Queries
* Data retrieval
* Data insertion/update/deletion
* Business logic

### View

Handles:

* HTML
* CSS
* Forms
* Book listings
* Cart interface
* Admin interface
* Customer interface

### Controller

Handles:

* User requests
* Form submissions
* Authentication
* Validation
* Calling models
* Returning views or JSON responses

---

## 🗄️ Database Schema

The application uses the shared database schema provided for the project.

### Users

Stores Admin and Customer information.

```text
users
├── id
├── name
├── email
├── password_hash
├── role
├── profile_picture
├── address
├── phone
└── created_at
```

### Categories

Stores different book categories.

```text
categories
├── id
├── name
└── created_at
```

### Books

Stores book information.

```text
books
├── id
├── title
├── author
├── description
├── price
├── category_id
├── image_path
├── stock
└── created_at
```

### Cart

Stores customer shopping cart items.

```text
cart
├── id
├── user_id
├── book_id
├── quantity
└── added_at
```

### Orders

Stores customer order information.

```text
orders
├── id
├── user_id
├── total_amount
├── status
├── payment_method
└── order_date
```

### Order Items

Stores individual books belonging to an order.

```text
order_items
├── id
├── order_id
├── book_id
├── quantity
└── unit_price
```

### Payments

Stores payment information.

```text
payments
├── id
├── order_id
├── amount
├── payment_method
├── transaction_id
└── payment_date
```

---

## Security Features

Security is an important part of the application.

The project implements:

* Password hashing using `password_hash()`
* Password verification using `password_verify()`
* Prepared statements for database queries
* SQL injection prevention
* Server-side input validation
* Client-side JavaScript validation
* Session-based authentication
* Role-based authorization
* Authentication checks on protected pages
* Secure file upload validation
* File size restrictions
* Stock validation before adding items to cart or placing orders

---

## Search & Filtering

Customers can search for books dynamically.

Available filters include:

* Book title
* Author
* Genre / Category

AJAX is used to update the book listing without refreshing the entire page.

---

## Shopping Cart

Customers can manage their shopping cart dynamically.

Available operations:

```text
Add Book
   ↓
Update Quantity
   ↓
Remove Book
   ↓
Calculate Subtotal
   ↓
Calculate Total
```
---

## Checkout & Payment

Customers can proceed to checkout from their cart.

The checkout process includes:

1. Confirm delivery address
2. Review order summary
3. Select payment method
4. Validate checkout information
5. Create order
6. Create order items
7. Store payment information
8. Clear the cart
9. Show order confirmation

Orders initially use:

```text
pending
```

The Admin can then process the order.

---

## Order Processing

Admin can update order status.

Available statuses:

```text
Pending
   ↓
Confirmed
   ↓
Shipped
   ↓
Delivered
```

Customers can view the current order status from their purchase history.

---

## Profile Management

Both Admin and Customer users can manage their profile.

Users can:

* View profile
* Edit name
* Edit email
* Update address
* Update phone number
* Upload profile picture
* Change password
* Reset password

The system validates profile information before updating the database.

---

## Admin Dashboard

The Admin Dashboard provides a quick overview of the store.

Example statistics:

```text
Total Books
Total Customers
Total Orders
Total Revenue
```

The Admin can also access:

* Book Management
* User Management
* Order Management
* Purchase History

---

## Validation

### Client-Side Validation

JavaScript validation is used for:

* Registration
* Login
* Profile update
* Book creation/editing
* Search input
* Cart quantity
* Checkout

### Server-Side Validation

PHP validation is performed before every database write.

Examples:

* Required field validation
* Email validation
* Password length validation
* Positive book price
* Valid stock quantity
* Valid image type
* Maximum image size
* Existing book validation
* Stock availability validation
* Valid payment method

---

## AJAX & JSON

AJAX is used to provide a smoother user experience.

Main AJAX features:

* Book search
* Book filtering
* Add to cart
* Update cart quantity
* Remove cart item
* Cart count update
* Order placement
* Admin order status update

AJAX endpoints return:

```text
Content-Type: application/json
```

Errors are handled on the client side and displayed to the user.

---

## Academic Project

This project is developed as an academic **Web Technologies / Web Programming** project.

The main purpose is to demonstrate practical implementation of:

* PHP
* MySQL
* MVC architecture
* CRUD operations
* Authentication
* Sessions
* AJAX
* JSON
* JavaScript validation
* Database relationships
* Web security
* Git collaboration