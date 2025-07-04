document.addEventListener('DOMContentLoaded', function() {
    // Basic DOM Elements
    const browseLink = document.getElementById('browse-link');
    const addLink = document.getElementById('add-link');
    const browseSection = document.getElementById('browse-section');
    const addSection = document.getElementById('add-section');
    const documentForm = document.getElementById('document-form');
    const formTitle = document.getElementById('form-title');
    const documentsList = document.getElementById('documents-list');
    const cancelButton = document.getElementById('cancel-button');

    // Load documents when page loads
    loadDocuments();

    // Navigation
    browseLink.addEventListener('click', function(e) {
        e.preventDefault();
        showSection(browseSection);
        browseLink.classList.add('active');
        addLink.classList.remove('active');
    });

    addLink.addEventListener('click', function(e) {
        e.preventDefault();
        showSection(addSection);
        addLink.classList.add('active');
        browseLink.classList.remove('active');
        resetForm();
    });

    // Form handling
    documentForm.addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        const documentId = document.getElementById('document-id').value;
        
        if (documentId) {
            updateDocument(formData);
        } else {
            addDocument(formData);
        }
    });

    cancelButton.addEventListener('click', function() {
        showSection(browseSection);
        browseLink.classList.add('active');
        addLink.classList.remove('active');
    });

    // Helper functions
    function showSection(section) {
        document.querySelectorAll('.section').forEach(s => s.classList.remove('active'));
        section.classList.add('active');
    }

    function loadDocuments() {
        fetch('api.php?action=getAll')
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    displayDocuments(data.data);
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error loading documents');
            });
    }

    function displayDocuments(documents) {
        documentsList.innerHTML = '';
        
        if (documents.length === 0) {
            documentsList.innerHTML = '<tr><td colspan="6">No documents found</td></tr>';
            return;
        }
        
        documents.forEach(doc => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${doc.title}</td>
                <td>${doc.author}</td>
                <td>${doc.pages}</td>
                <td>${doc.type}</td>
                <td>${doc.format}</td>
                <td>
                    <button class="action-button edit-btn" data-id="${doc.id}">Edit</button>
                    <button class="action-button delete-btn" data-id="${doc.id}">Delete</button>
                </td>
            `;
            documentsList.appendChild(row);
        });

        // Add event listeners to buttons
        document.querySelectorAll('.edit-btn').forEach(button => {
            button.addEventListener('click', function() {
                editDocument(this.getAttribute('data-id'));
            });
        });

        document.querySelectorAll('.delete-btn').forEach(button => {
            button.addEventListener('click', function() {
                if (confirm('Delete this document?')) {
                    deleteDocument(this.getAttribute('data-id'));
                }
            });
        });
    }

    function editDocument(documentId) {
        const row = document.querySelector(`.edit-btn[data-id="${documentId}"]`).closest('tr');
        const cells = row.querySelectorAll('td');
        
        document.getElementById('document-id').value = documentId;
        document.getElementById('title').value = cells[0].textContent;
        document.getElementById('author').value = cells[1].textContent;
        document.getElementById('pages').value = cells[2].textContent;
        document.getElementById('type').value = cells[3].textContent;
        document.getElementById('format').value = cells[4].textContent;
        
        formTitle.textContent = 'Edit Document';
        showSection(addSection);
        addLink.classList.add('active');
        browseLink.classList.remove('active');
    }

    function resetForm() {
        document.getElementById('document-id').value = '';
        documentForm.reset();
        formTitle.textContent = 'Add New Document';
    }

    function addDocument(formData) {
        fetch('api.php?action=add', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                alert('Document added successfully');
                resetForm();
                showSection(browseSection);
                browseLink.classList.add('active');
                addLink.classList.remove('active');
                loadDocuments();
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error adding document');
        });
    }

    function updateDocument(formData) {
        fetch('api.php?action=update', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                alert('Document updated successfully');
                resetForm();
                showSection(browseSection);
                browseLink.classList.add('active');
                addLink.classList.remove('active');
                loadDocuments();
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error updating document');
        });
    }

    function deleteDocument(documentId) {
        fetch(`api.php?action=delete&id=${documentId}`)
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    alert('Document deleted successfully');
                    loadDocuments();
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error deleting document');
            });
    }
}); 