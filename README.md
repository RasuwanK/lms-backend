# Learning Management System Backend
This is the repository of the backend used by the Learning management system.
Corresponding frontend can be found in this [repo](https://github.com/sunhesh12/GroupProjectFrontend).

## API Documentation

## Table of Contents
- [How to start development](#how-to-start-development)
  - [Install Laravel](#install-laravel)
  - [Installing dependencies](#installing-dependencies)
  - [Add the environment variables (.env)](#add-the-environment-variables-env)
  - [Generate the App Key](#generate-the-app-key-app_key-environment-variable)
  - [Run all the database migrations](#run-all-the-database-migrations)
  - [Start the development server](#start-the-development-server)
  - [Important considerations](#important-considerations)
- [Authentication](#authentication)
- [Modules API](#modules-api)
- [Announcements API](#announcements-api)
- [Activities API](#activities-api)
- [Topics API](#topics-api)
- [Quiz API](#quiz-api)
- [Events API](#events-api)
- [Courses API](#courses-api)
- [User API](#user-api)
- [Authentication API](#authentication-api)
- [API Endpoints Summary](#api-endpoints-summary)



## How to start development

### Install Laravel

You can find how to install using this [link](https://laravel.com/docs/11.x/#installing-php)

### Installing dependencies

Go inside the folder containing the repository

```
cd lms-backend
```

Install the dependencies using composer
```
composer install
```
### Add the environment variables (.env)

Get the .env file from this [link](https://drive.google.com/file/d/1X9JV6HfIh2zB7vqHNunKx_R48Qquz6fx/view?usp=sharing)

Copy it into the folder containing the repository.

Change the following variables as given:

```
DB_CONNECTION=mysql
DB_DATABASE=lms_backend
DB_USERNAME=root
DB_PASSWORD=root
```
If this doesn't work, check the username and password of your MySQL database and set `DB_USERNAME` and `DB_PASSWORD` accordingly.

### Generate the App Key (APP_KEY environment variable)

Execute the following command:

```
php artisan generate:key
```
### Run all the database migrations

Need to create the table structures in the MySQL database `lms_backend`

```
php artisan migrate
```
### Start the development server

Need to start in order to check and run API routes

```
php artisan serve
```

## Important considerations

- NEVER change database schema with MySQL. Only change it through Laravel database migrations. Refer to this [link](https://laravel.com/docs/11.x/migrations#generating-migrations)

### **Quiz API**

#### **17. Add a Question to a Quiz**
```http
POST /v1/quiz/{id}/questions
```
**Description:** Adds a new question to a quiz.

#### **18. Get Questions for a Quiz**
```http
GET /v1/quiz/{id}/questions
```
**Description:** Retrieves all questions for a quiz.

#### **19. Update a Question**
```http
PATCH /v1/quiz/{id}/questions/{queid}
```
**Description:** Updates a specific question in a quiz.

#### **20. Delete a Specific Question**
```http
DELETE /v1/quiz/{id}/questions/{queid}
```
**Description:** Deletes a specific question from a quiz.

#### **21. Delete All Questions from a Quiz**
```http
DELETE /v1/quiz/{id}/questions
```
**Description:** Deletes all questions from a quiz.

---

### **Events API**

#### **22. Get Specific Event Details**
```http
GET /v1/events/{eventid}
```
**Description:** Fetches details of a specific event.

#### **23. Create an Event**
```http
POST /v1/events
```
**Description:** Creates an event for users.

#### **24. Update an Event**
```http
PATCH /v1/events/{eventid}
```
**Description:** Updates an existing event.

#### **25. Delete an Event**
```http
DELETE /v1/events/{eventid}
```
**Description:** Deletes an event.

---

### **Courses API**

#### **26. List Modules in a Course**
```http
GET /v1/courses/{id}/modules
```
**Description:** Lists all modules within a course.

#### **27. Attach Modules to a Course**
```http
POST /v1/courses/{id}/modules
```
**Description:** Attaches modules to a course.

#### **28. Detach Modules from a Course**
```http
DELETE /v1/courses/{id}/modules
```
**Description:** Removes modules from a course.

#### **29. Create a Course**
```http
POST /v1/courses
```
**Description:** Creates a new course.

---

### **User API**

#### **30. Get All Users**
```http
GET /v1/users/all
```
**Description:** Retrieves a list of all users.

#### **31. Create a User**
```http
POST /v1/users
```
**Description:** Creates a new user.

#### **32. Update User Details**
```http
PATCH /v1/users/{id}
```
**Description:** Updates user details.

#### **33. Delete a User**
```http
DELETE /v1/users/{id}
```
**Description:** Deletes a user by ID.

#### **34. Get User by ID**
```http
GET /v1/users/{id}
```
**Description:** Retrieves details of a specific user.

---

