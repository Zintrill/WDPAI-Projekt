SNMP Configuration and User Management Web Application
Table of Contents
Project Description
Technologies
Setup
Features
To Do
Database Schema
Screenshots
Project Description
A web application for managing SNMP devices and users. The application allows users to view, add, update, and delete device information, as well as manage user accounts with different roles and permissions. It includes real-time updates for device statuses and a secure admin panel for administrators.

Technologies
HTML 5
CSS 3
JavaScript (ES6)
PHP 7
PostgreSQL
Docker
Chart.js
FontAwesome
Setup
To run this project on your local machine using Docker:

Features
Responsive Web Design (RWD): The application is fully responsive and works on various devices.
User Authentication: Secure login and registration functionality.
User Role Management: Different roles (Admin, Technician, Operator) with specific permissions.
Device Management: Add, update, delete, and view SNMP devices.
Real-Time Updates: Real-time data updates for device statuses.
Search and Filter: Search and filter functionality for devices.
Admin Panel: Admin panel for managing users and devices.
To Do
Password Recovery: Implement password recovery functionality with email verification.
Enhanced Security: Improve security measures, including encryption and validation.
Additional Metrics: Display additional device metrics and details.
Logging and Monitoring: Implement comprehensive logging and monitoring for user activities and device statuses.
Database Schema
The database schema includes the following tables and relationships:

users: Stores user information.

Fields: user_id, fullname, username, password, permission_id, email
Relationships:
permission_id references permissions(permission_id)
permissions: Stores user roles and permissions.

Fields: permission_id, role
device: Stores SNMP device information.

Fields: id, device_name, type_id, address_ip, snmp_version_id, username, password, description
Relationships:
type_id references types(type_id)
snmp_version_id references snmp_version(snmp_version_id)
device_status: Stores the status of each device.

Fields: id, device_id, mac_address, status
Relationships:
device_id references device(id)
types: Stores device types.

Fields: type_id, type
snmp_version: Stores SNMP versions.

Fields: snmp_version_id, snmp
user_details: Stores additional details for each user.

Fields: id, user_id, address
Relationships:
user_id references users(user_id)
user_device: Manages the many-to-many relationship between users and devices.

Fields: user_id, device_id
Relationships:
user_id references users(user_id)
device_id references device(id)

Screenshots
![image](https://github.com/Zintrill/WDPAI-Projekt/assets/162897913/ab24398a-2be4-44a5-9666-0664520184fc)
![image](https://github.com/Zintrill/WDPAI-Projekt/assets/162897913/317ec1f6-7f82-4ade-94bf-68ed4281a4e6)
![image](https://github.com/Zintrill/WDPAI-Projekt/assets/162897913/c60989af-d589-4e6c-bf28-c15e6e0d1e17)
![image](https://github.com/Zintrill/WDPAI-Projekt/assets/162897913/159aa032-66b6-4fca-b5a2-1981dc777c4d)
![image](https://github.com/Zintrill/WDPAI-Projekt/assets/162897913/62456bdd-b55b-4233-94c8-6623ad66a306)

![image](https://github.com/Zintrill/WDPAI-Projekt/assets/162897913/967ca5c0-733e-4469-92f0-522b067da517)
![image](https://github.com/Zintrill/WDPAI-Projekt/assets/162897913/990f62f2-740f-435e-ab1b-d86346c32fc2)
![image](https://github.com/Zintrill/WDPAI-Projekt/assets/162897913/90532a06-df69-4b63-94e6-738fa9eb2237)
![image](https://github.com/Zintrill/WDPAI-Projekt/assets/162897913/008554cb-ef63-4a89-bf92-545e4f6f8615)
![image](https://github.com/Zintrill/WDPAI-Projekt/assets/162897913/bc2f7ea0-8da3-4b1a-981e-c9cb1b77cba9)




