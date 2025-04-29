//* GET ALL BOOKS
function loadBooks() {
    $.ajax({
        url: '/controllers/get_books.php',
        method: 'GET',
        success: function(response) {
            const res = JSON.parse(response);
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

    //* ADD & UPDATE MODAL
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

    //* HANDLE CLICK SAVE BOOK
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

    //* HANDLE DELETE BOOK
    $(document).on('click', '.delete-btn', function() {
        const id = $(this).data('id');
        const title = $(this).data('title');

        $('#delete-book-title').text(title);
        $('#delete-book-id').val(id);

        $('#deleteModal').modal('show');
    });

    //* HANDLE CLICK DELETE BOOK
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
});