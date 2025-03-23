CREATE DATABASE Tambo_Market_DB;
USE Tambo_Market_DB;

CREATE TABLE Market_administrators (
    Admin_ID INT AUTO_INCREMENT PRIMARY KEY,
    Name VARCHAR(100) NOT NULL,
    Password VARCHAR(255) NOT NULL,
    Contact_info VARCHAR(100)
);

INSERT INTO Market_administrators (Name, Password, Contact_info) 
VALUES ('admin', MD5('admin123'), 'admin@example.com');

CREATE TABLE Reports (
    Report_ID INT AUTO_INCREMENT PRIMARY KEY,
    Admin_ID INT,
    Vendor_ID INT,
    Report_type VARCHAR(50),
    Date_generated DATE,
    FOREIGN KEY (Admin_ID) REFERENCES Market_administrators (Admin_ID),
    FOREIGN KEY (Vendor_ID) REFERENCES Vendors (Vendor_ID)
);

CREATE TABLE Vendors (
    Vendor_ID INT AUTO_INCREMENT PRIMARY KEY,
    Name VARCHAR(100),
    Contact_info VARCHAR(100),
    Location VARCHAR(100),
    Admin_ID INT,
    FOREIGN KEY (Admin_ID) REFERENCES Market_administrators (Admin_ID)
);

CREATE TABLE Products (
    Product_ID INT PRIMARY KEY AUTO_INCREMENT,
    Name VARCHAR(100),
    Attribute_3 VARCHAR(100),
    Category VARCHAR(100),
    Image_Path VARCHAR(255),
    Vendor_ID INT,
    FOREIGN KEY (Vendor_ID) REFERENCES Vendors (Vendor_ID)
);

CREATE TABLE Inventory (
    Inventory_ID INT PRIMARY KEY AUTO_INCREMENT,
    Product_ID INT,
    Vendor_ID INT,
    Quantity_Available INT,
    FOREIGN KEY (Product_ID) REFERENCES Products (Product_ID),
    FOREIGN KEY (Vendor_ID) REFERENCES Vendors (Vendor_ID)
);

CREATE TABLE Customers (
    Customer_ID INT PRIMARY KEY AUTO_INCREMENT,
    Name VARCHAR(100),
    Email VARCHAR(100),
    Contact_info VARCHAR(100),
    Vendor_ID INT,
    FOREIGN KEY (Vendor_ID) REFERENCES Vendors (Vendor_ID)
);

CREATE TABLE Payment (
    Payment_ID INT PRIMARY KEY AUTO_INCREMENT,
    Payment_Method VARCHAR(50),
    Amount Decimal(10,2),
    Date DATE
);

CREATE TABLE Transactions (
    Transaction_ID INT PRIMARY KEY AUTO_INCREMENT,
    Date DATE,
    Total_Amount Decimal(10,2),
    Vendor_ID INT,
    Customer_ID INT,
    Payment_ID INT,
    FOREIGN KEY (Vendor_ID) REFERENCES Vendors (Vendor_ID),
    FOREIGN KEY (Customer_ID) REFERENCES Customers (Customer_ID),
    FOREIGN KEY (Payment_ID) REFERENCES Payment (Payment_ID)
);