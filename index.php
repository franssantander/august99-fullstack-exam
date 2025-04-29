<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <title>August99 Technical Exam</title>
</head>

<body>
    <div class="container mt-5">
        <!-- Button Modal -->
        <button type="button" class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#exampleModal">
            Add Book
        </button>

        <!-- ADD & EDIT MODAL -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="modalTitle">Add Book</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="book-id">
                        <div class="mb-3">
                            <label class="form-label">Book Title</label>
                            <input type="text" class="form-control" id="book" placeholder="Enter book title">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">ISBN</label>
                            <input type="text" class="form-control" id="isbn" placeholder="Enter ISBN">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Author</label>
                            <input type="text" class="form-control" id="author" placeholder="Enter author">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Publisher</label>
                            <input type="text" class="form-control" id="publisher" placeholder="Enter publisher">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Year Published</label>
                            <input type="number" class="form-control" id="year-published"
                                placeholder="Enter year published">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Category</label>
                            <input type="text" class="form-control" id="category" placeholder="Enter category">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="save-book">Save</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- DELETE MODAL -->
        <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to delete the book: <strong id="delete-book-title"></strong>?
                        <input type="hidden" id="delete-book-id">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" id="confirm-delete" class="btn btn-danger">Delete</button>
                    </div>
                </div>
            </div>
        </div>


        <!-- Table -->
        <div>
            <table class="table border">
                <thead>
                    <tr>
                        <th scope="col">Title</th>
                        <th scope="col">ISBN</th>
                        <th scope="col">Author</th>
                        <th scope="col">Publisher</th>
                        <th scope="col">Year Published</th>
                        <th scope="col">Category</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody class="table-data">

                </tbody>
            </table>
        </div>
    </div>

</body>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

<script>
function loadBooks() {
    $.ajax({
        url: '/controllers/get_books.php',
        method: 'GET',
        success: function(response) {

            const res = JSON.parse(response)
            let rows = '';
            res.forEach(function(book) {
                rows += `
                <tr>
                    <td>${book.title}</td>
                    <td>${book.isbn}</td>
                    <td>${book.author}</td>
                    <td>${book.publisher}</td>
                    <td>${book.year_published}</td>
                    <td>${book.category}</td>
                    <td>
                        <button 
                            class="btn btn-sm btn-primary edit-btn" 
                            data-id="${book.id}"
                            data-title="${book.title}"
                            data-isbn="${book.isbn}"
                            data-author="${book.author}"
                            data-publisher="${book.publisher}"
                            data-year="${book.year_published}"
                            data-category="${book.category}"
                            data-bs-toggle="modal" data-bs-target="#exampleModal">
                            Edit
                        </button>
                        <button 
                            class="btn btn-sm btn-danger delete-btn" 
                            data-id="${book.id}">
                            Delete
                        </button>
                    </td>
                </tr>
            `;
            });

            $('table tbody').html(rows);
        },
        error: function() {
            alert('Failed to fetch books');
        }
    });
}



$(document).ready(function() {
    loadBooks();

    $(document).ready(function() {
        loadBooks();

        $('#exampleModal').on('show.bs.modal', function(event) {
            const button = $(event.relatedTarget);
            const modal = $(this);

            if (button.hasClass('edit-btn')) {
                modal.find('#modalTitle').text('Edit Book');
                modal.find('#book-id').val(button.data('id'));
                modal.find('#book').val(button.data('title'));
                modal.find('#isbn').val(button.data('isbn'));
                modal.find('#author').val(button.data('author'));
                modal.find('#publisher').val(button.data('publisher'));
                modal.find('#year-published').val(button.data('year'));
                modal.find('#category').val(button.data('category'));
            } else {
                modal.find('#modalTitle').text('Add Book');
                modal.find('#book-id').val('');
                modal.find('input').val('');
            }
        });

        $('#save-book').on('click', function() {
            const id = $('#book-id').val();
            const title = $('#book').val();
            const isbn = $('#isbn').val();
            const author = $('#author').val();
            const publisher = $('#publisher').val();
            const year_published = $('#year-published').val();
            const category = $('#category').val();

            const url = id ? '/controllers/update_book.php' : '/controllers/add_book.php';

            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    id,
                    title,
                    isbn,
                    author,
                    publisher,
                    year_published,
                    category
                },
                success: function(response) {
                    const result = JSON.parse(response);
                    if (result.status === 'success') {
                        $('#exampleModal').modal('hide');
                        loadBooks();
                    } else {
                        alert(result.message);
                    }
                },
                error: function() {
                    alert('An error occurred.');
                }
            });
        });
    });
});


//* DELETE SHOW MODAL
$(document).on('click', '.delete-btn', function() {
    const id = $(this).data('id');
    const title = $(this).data('title');

    $('#delete-book-title').text(title);
    $('#delete-book-id').val(id);

    $('#deleteModal').modal('show');
});

//* CONFIRM DELETE
$('#confirm-delete').on('click', function() {
    const id = $('#delete-book-id').val();

    $.ajax({
        url: '/controllers/delete_book.php',
        type: 'POST',
        data: {
            id: id
        },
        success: function(response) {
            const result = JSON.parse(response);
            if (result.status === 'success') {
                $('#deleteModal').modal('hide');
                loadBooks();
                alert('Book deleted successfully!');
            } else {
                alert('Failed to delete the book.');
            }
        },
        error: function() {
            alert('An error occurred during deletion.');
        }
    });
});
</script>

</html>