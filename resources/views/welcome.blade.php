<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todo App</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body>

<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title text-center mb-0">Todo App</h5>
        </div>
        <div class="card-body">
            <div class="input-group add-todo">
                <input type="text" class="form-control" placeholder="Add a new todo">
                <div class="input-group-append">
                    <button class="btn btn-primary" id="add_task" type="button">+</button>
                </div>
            </div>
            <ul class="todo-list">
                
            </ul>
            <span class="pending-task"></span>
            <button class="btn btn-primary clear-all">Clear All</button>
        </div>
    </div>
</div>

<!-- Edit Task Modal -->
    <div class="modal fade" id="editTaskModal" tabindex="-1" role="dialog" aria-labelledby="editTaskModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editTaskModalLabel">Edit Task</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="editTaskInput">Task Title</label>
                        <input type="text" class="form-control" id="editTaskInput" placeholder="Enter new task title">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="editTaskSubmit">Save changes</button>
                </div>
            </div>
        </div>
    </div>


<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<!-- Bootstrap JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<!-- Custom Script -->
<script src="{{ asset('js/custom.js') }}"></script>
</body>
</html>
