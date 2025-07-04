<?php
require_once 'config.php';


$typesQuery = "SELECT DISTINCT type FROM documents ORDER BY type";
$formatsQuery = "SELECT DISTINCT format FROM documents ORDER BY format";

$typesResult = $conn->query($typesQuery);
$formatsResult = $conn->query($formatsQuery);

$types = [];
$formats = [];

if ($typesResult->num_rows > 0) {
    while ($row = $typesResult->fetch_assoc()) {
        $types[] = $row['type'];
    }
}

if ($formatsResult->num_rows > 0) {
    while ($row = $formatsResult->fetch_assoc()) {
        $formats[] = $row['format'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document Manager</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Document Manager</h1>
            <nav>
                <ul>
                    <li><a href="#" class="active" id="browse-link">Browse Documents</a></li>
                    <li><a href="#" id="add-link">Add Document</a></li>
                </ul>
            </nav>
        </header>

        <main>

            <section id="browse-section" class="section active">
                <h2>Browse Documents</h2>
                
                <div class="filter-container">
                    <div class="filter-group">
                        <label for="filter-type">Filter by:</label>
                        <select id="filter-by">
                            <option value="type">Type</option>
                            <option value="format">Format</option>
                        </select>
                    </div>
                    
                    <div class="filter-group" id="type-filter-group">
                        <label for="type-filter">Type:</label>
                        <select id="type-filter">
                            <option value="">All Types</option>
                            <?php foreach ($types as $type): ?>
                                <option value="<?php echo htmlspecialchars($type); ?>"><?php echo htmlspecialchars($type); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="filter-group hidden" id="format-filter-group">
                        <label for="format-filter">Format:</label>
                        <select id="format-filter">
                            <option value="">All Formats</option>
                            <?php foreach ($formats as $format): ?>
                                <option value="<?php echo htmlspecialchars($format); ?>"><?php echo htmlspecialchars($format); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <button id="apply-filter">Apply Filter</button>
                    <button id="clear-filter">Clear Filter</button>ss
                </div>
                
                <div id="active-filter-display" class="hidden">
                    <p>Active Filter: <span id="filter-info"></span></p>
                </div>
                
                <div class="documents-container">
                    <table id="documents-table">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Author</th>
                                <th>Pages</th>
                                <th>Type</th>
                                <th>Format</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="documents-list">

                        </tbody>
                    </table>
                </div>
            </section>

            <!-- Add Document Section -->
            <section id="add-section" class="section">
                <h2 id="form-title">Add New Document</h2>
                
                <form id="document-form">
                    <input type="hidden" id="document-id" name="id">
                    
                    <div class="form-group">
                        <label for="title">Title:</label>
                        <input type="text" id="title" name="title" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="author">Author:</label>
                        <input type="text" id="author" name="author" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="pages">Number of Pages:</label>
                        <input type="number" id="pages" name="pages" min="1" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="type">Type:</label>
                        <input type="text" id="type" name="type" required placeholder="e.g., Book, Article, Report">
                    </div>
                    
                    <div class="form-group">
                        <label for="format">Format:</label>
                        <input type="text" id="format" name="format" required placeholder="e.g., PDF, DOCX, TXT">
                    </div>
                    
                    <div class="form-actions">
                        <button type="submit" id="save-button">Save Document</button>
                        <button type="button" id="cancel-button">Cancel</button>
                    </div>
                </form>
            </section>
        </main>
    </div>

    <script src="script.js"></script>
</body>
</html> 