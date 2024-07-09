# News Management System

## Overview

This project is a test assignment for the company CRGD. It is a news management system that allows an admin user to log in and manage news articles. The system includes functionalities for creating, reading, updating, and deleting (CRUD) news entries.

## Features

- **Admin Login**: Only authorized users can access the admin area.
- **CRUD Operations**: Admins can create, read, update, and delete news articles.
- **Controller System**: URL routing is based on the controller's name and method names in camelCase format prefixed with `action`.
- **Templating**: Uses Twig for rendering templates.
- **Database**: Utilizes PostgreSQL for storing news entries.

## URL Routing

The URL routing system is designed as follows:
- The first part of the URL is the controller name.
- Subsequent parts are combined in camelCase to form the controller method name, prefixed with `action`.

### Available URLs

- `auth/login`: Login page
- `news/dashboard`: Dashboard showing all news articles
- `news/create`: Create a new news article
- `news/update`: Update an existing news article
- `news/delete`: Delete a news article

## Prerequisites

- PHP 8.3
- Composer
- A web server (e.g., Apache, Nginx)
- PostgreSQL database