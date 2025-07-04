# Document Management System

A web application for managing documents, built with PHP, MySQL, HTML, CSS, and JavaScript.

## Features

- Browse documents with AJAX filtering by type or format
- Add new documents
- Edit existing documents
- Delete documents
- Persistent filter display (saves your last filter)

## Requirements

- PHP 7.0 or higher
- MySQL 5.6 or higher
- Web server (Apache, Nginx, etc.)

## Setup Instructions

1. Clone or download this repository to your web server's document root
2. Make sure your web server and MySQL server are running
3. Access the application through your web browser (e.g., http://localhost/document-manager)
4. The application will automatically create the required database and table on first run

## Database Configuration

The default database configuration is:

- Host: localhost
- Username: root
- Password: (empty)
- Database name: document_manager

If you need to change these settings, update them in the `config.php` file.

## Using the Application

### Browsing Documents
- All documents are displayed in a table on the main page
- Filter documents by type or format using the filter options
- The application remembers your last used filter
- Click "Clear Filter" to reset and view all documents

### Adding Documents
- Click "Add Document" in the navigation menu
- Fill in all the required fields
- Click "Save Document" to add the document to the database

### Editing Documents
- Click the "Edit" button next to a document in the browse view
- Update the document details in the form
- Click "Save Document" to update the document

### Deleting Documents
- Click the "Delete" button next to a document in the browse view
- Confirm the deletion when prompted

## Document Information

The application stores the following information for each document:

- Title
- Author
- Number of Pages
- Type (e.g., Book, Article, Report)
- Format (e.g., PDF, DOCX, TXT)

You can access the application by navigating to:
```
http://localhost/lab6-Php/
``` 