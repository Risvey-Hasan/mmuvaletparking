# Valet Parking Management System

## Introduction
The Valet Parking Management System is a web application designed to manage valet parking operations efficiently for the MMU parking. The system includes functionalities for both admin and students, ensuring smooth operations and enhanced student experience.

## Table of Contents
- [Installation](#installation)
- [Navigation](#navigation)
- [Main Functionalities](#main-functionalities)
- [Technologies Used](#technologies-used)

## Installation
1. Clone the repository:
    ```bash
    git clone https://github.com/Risvey-Hasan/mmuvaletparking.git
    ```
2. Navigate to the project directory:
    ```bash
    cd valet_parking
    ```
3. Set up the database:
    - Import the `market_place.sql` file into your MySQL database.
    - Update the database configuration in `include/connection.php`.

4. Start the server using XAMPP:
    - Place the project folder in the `htdocs` directory of XAMPP.
    - Start Apache and MySQL from the XAMPP control panel.

5. Access the application in your browser:
    ```url
    http://localhost/valet_parking
    ```

## Navigation
### User Navigation
- **Home Page**: Users can find the login and feedback option on this page.
- **Registration**: Allows users to create a new account.
- **Log In**: Existing users can log in to access their dashboard.
- **Dashboard**: Users can view their current bookings, and profile information.
- **Book a Spot**: Users can book a parking spot by selecting the desired location and time.
- **Feedback**: Users can submit feedback regarding their experience.
- **FAQs**: Users can view frequently asked questions for quick assistance and suggest a question as FAQ.
- **Cart**: Users can view their cart items and complete purchase from this page.

### Admin Navigation
- **Admin Dashboard**: Admins can view an overview of the system, including total bookings, active users, and recent feedback.
- **Manage Users**: Admins can view, add, edit, and delete user accounts.
- **Communications**: Admins can communicate to the users from his dashboard.
- **Settings**: Admins can configure system settings, such as pricing and parking spot availability.

## Main Functionalities
### User Functionalities
- **User Registration and Authentication**: Users can sign up and log in to access personalized features.
- **Profile Management**: Users can update their profile information and password.
- **Booking Management**: Users can book parking spots.
- **Feedback Submission**: Users can submit feedback and view responses from admins.

### Admin Functionalities
- **User Management**: Admins can add, edit, and delete user accounts.
- **Booking Management**: Admins can view all bookings, update booking statuses, and manage parking spot availability.
- **System Configuration**: Admins can update system settings, such as pricing, parking spots, and operational hours.

## Technologies Used
- **Frontend**: HTML, CSS, JavaScript
- **Backend**: PHP
- **Database**: MySQL
- **Server**: XAMPP

