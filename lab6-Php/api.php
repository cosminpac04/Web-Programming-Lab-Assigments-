<?php
header('Content-Type: application/json');
require_once 'config.php';

$action = isset($_GET['action']) ? $_GET['action'] : '';

switch ($action) {
    case 'getAll':
        getAllDocuments();
        break;
    case 'getByFilter':
        getDocumentsByFilter();
        break;
    case 'add':
        addDocument();
        break;
    case 'update':
        updateDocument();
        break;
    case 'delete':
        deleteDocument();
        break;
    default:
        echo json_encode(['status' => 'error', 'message' => 'Invalid action']);
        break;
}


function getAllDocuments() {
    global $conn;
    
    $sql = "SELECT * FROM documents ORDER BY id DESC";
    $result = $conn->query($sql);
    
    $documents = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $documents[] = $row;
        }
    }
    
    echo json_encode(['status' => 'success', 'data' => $documents]);
}


function getDocumentsByFilter() {
    global $conn;
    
    $type = isset($_GET['type']) ? $_GET['type'] : '';
    $format = isset($_GET['format']) ? $_GET['format'] : '';
    
    
    $whereClause = [];
    $filterInfo = [];
    
    if (!empty($type)) {
        $type = $conn->real_escape_string($type);
        $whereClause[] = "type = '$type'";
        $filterInfo['type'] = $type;
    }
    
    if (!empty($format)) {
        $format = $conn->real_escape_string($format);
        $whereClause[] = "format = '$format'";
        $filterInfo['format'] = $format;
    }
    
    
    if (empty($whereClause)) {
        getAllDocuments();
        return;
    }
    
   
    $whereSQL = implode(' AND ', $whereClause);
    
    $sql = "SELECT * FROM documents WHERE $whereSQL ORDER BY id DESC";
    $result = $conn->query($sql);
    
    $documents = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $documents[] = $row;
        }
    }
    
    echo json_encode([
        'status' => 'success', 
        'data' => $documents, 
        'filter' => $filterInfo
    ]);
}


function addDocument() {
    global $conn;
    
    
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
        return;
    }
    
    
    $title = isset($_POST['title']) ? $conn->real_escape_string($_POST['title']) : '';
    $author = isset($_POST['author']) ? $conn->real_escape_string($_POST['author']) : '';
    $pages = isset($_POST['pages']) ? intval($_POST['pages']) : 0;
    $type = isset($_POST['type']) ? $conn->real_escape_string($_POST['type']) : '';
    $format = isset($_POST['format']) ? $conn->real_escape_string($_POST['format']) : '';
    
    
    if (empty($title) || empty($author) || $pages <= 0 || empty($type) || empty($format)) {
        echo json_encode(['status' => 'error', 'message' => 'All fields are required']);
        return;
    }
    
    
    $sql = "INSERT INTO documents (title, author, pages, type, format) VALUES ('$title', '$author', $pages, '$type', '$format')";
    
    if ($conn->query($sql) === TRUE) {
        echo json_encode(['status' => 'success', 'message' => 'Document added successfully', 'id' => $conn->insert_id]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error adding document: ' . $conn->error]);
    }
}


function updateDocument() {
    global $conn;

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
        return;
    }
    
    $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
    $title = isset($_POST['title']) ? $conn->real_escape_string($_POST['title']) : '';
    $author = isset($_POST['author']) ? $conn->real_escape_string($_POST['author']) : '';
    $pages = isset($_POST['pages']) ? intval($_POST['pages']) : 0;
    $type = isset($_POST['type']) ? $conn->real_escape_string($_POST['type']) : '';
    $format = isset($_POST['format']) ? $conn->real_escape_string($_POST['format']) : '';
    

    if ($id <= 0 || empty($title) || empty($author) || $pages <= 0 || empty($type) || empty($format)) {
        echo json_encode(['status' => 'error', 'message' => 'All fields are required']);
        return;
    }
    
    $sql = "UPDATE documents SET title = '$title', author = '$author', pages = $pages, type = '$type', format = '$format' WHERE id = $id";
    
    if ($conn->query($sql) === TRUE) {
        echo json_encode(['status' => 'success', 'message' => 'Document updated successfully']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error updating document: ' . $conn->error]);
    }
}


function deleteDocument() {
    global $conn;
    
    $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
    
    if ($id <= 0) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid document ID']);
        return;
    }
    
    $sql = "DELETE FROM documents WHERE id = $id";
    
    if ($conn->query($sql) === TRUE) {
        echo json_encode(['status' => 'success', 'message' => 'Document deleted successfully']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error deleting document: ' . $conn->error]);
    }
}
?> 