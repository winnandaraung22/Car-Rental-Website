Overview

The Car Rental Website is an academic project developed to practise web application development and database management. The system provides an online platform where customers can browse available cars, check rental prices, and make rental bookings, while administrators manage car information and rental records.

The system has two main user roles: Admin and Customer.

Both user roles must log in to their respective accounts to access the functions available to them.

User Roles

1. Admin

- Manage car information and rental prices.
- Add, update, and remove car listings.
- Manage customer rental bookings and records.
- Monitor car availability and rental status.

2. Customer

- Browse available cars and view car details.
- Check the rental price per day.
- Select the rental period and view the calculated rental fee.
- Submit car rental bookings.
- Check car availability before making a booking.

Key Features

Car Availability Status

The system displays the availability status of each car. When a car has already been rented for the relevant period, the system displays an "Unavailable" status to help customers identify cars that cannot be rented.

Automatic Rental Price Calculation

The system calculates the rental fee based on the selected rental duration and the car's daily rental rate.

Calculation:

Total Rental Fee = Price Per Day × Number of Rental Days

For example, if a car costs $50 per day and the customer rents it for 3 days:

$50 × 3 days = $150

This feature helps customers estimate their rental expenses before booking.

Technologies Used

HTML — Structures the web pages.

CSS — Styles the website interface.

JavaScript — Supports client-side interactions and calculations, where implemented.

PHP — Handles server-side processing.

MySQL — Stores car, customer, and rental information.

Sublime Text — Used as the code editor.

XAMPP — Provides the local Apache and MySQL development environment.

System Purpose

The main purpose of this project is to develop a convenient car rental platform that allows customers to check vehicle availability and estimate rental fees while providing administrators with tools to manage car listings and rental information.

Installation and Setup

- Install XAMPP on your computer.
- Place the project folder inside the htdocs directory.
- Start Apache and MySQL from the XAMPP Control Panel.
- Configure the database connection settings.
- Open the website in your browser.

Notes

This project was developed for academic purposes.

The website is intended to run in a local development environment unless deployed to a web server.

Some features may depend on the database configuration and the local XAMPP environment.

Developer

Win Nandar Aung

GitHub: https://github.com/winnandaraung22

Email: winnandaraung.angel@gmail.com
