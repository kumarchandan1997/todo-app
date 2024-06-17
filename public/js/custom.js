$(document).ready(function () {
    // fetch data from todo table
    function fetchTasks() {
        $.ajax({
            url: "/api/tasks-details",
            method: "GET",
            success: function (response) {
                var todoList = $(".todo-list");
                todoList.empty();
                $.each(response.data, function (index, task) {
                    var listItem = $("<li>")
                        .addClass("list-group-item")
                        .text(task.title);
                    var deleteButton = $("<button>")
                        .addClass(
                            "btn btn-danger btn-sm delete-btn delete-icon"
                        )
                        .html("X");
                    deleteButton.attr("data-task-id", task.id);

                    var editButton = $("<button>")
                        .addClass("btn btn-warning btn-sm edit-btn")
                        .html("Edit");
                    editButton.attr("data-task-id", task.id);
                    editButton.attr("data-task-title", task.title);
                    listItem.append(deleteButton);
                    listItem.append(editButton);
                    todoList.append(listItem);
                });
                // Update pending tasks count
                $(".pending-task").text(
                    "You have " + response.count + " pending tasks"
                );
            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText);
            },
        });
    }

    fetchTasks();

    // add task and save data in todo table
    $("#add_task").click(function () {
        var todoText = $(".form-control").val();
        if (todoText.trim() !== "") {
            $.ajax({
                url: "/api/tasks",
                method: "POST",
                data: { title: todoText },
                success: function (response) {
                    console.log(response);
                    fetchTasks();
                    $(".form-control").val("");
                },
                error: function (xhr, status, error) {
                    console.error(xhr.responseText);
                    var errorMessage = xhr.responseJSON.errors.title[0];
                    alert(errorMessage);
                },
            });
        } else {
            Swal.fire({
                title: "Hello!",
                text: "Please enter a task!",
                icon: "success",
                confirmButtonText: "Cool",
            });
        }
    });

    // delete task from id

    $(".todo-list").on("click", ".delete-btn", function () {
        var taskId = $(this).data("task-id");

        // Confirm deletion
        Swal.fire({
            title: "Are you sure?",
            text: "You will not be able to recover this task!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Yes, delete it!",
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "/api/tasks/" + taskId,
                    method: "DELETE",
                    success: function (response) {
                        $('[data-task-id="' + taskId + '"]')
                            .parent()
                            .remove();

                        Swal.fire(
                            "Deleted!",
                            "Your task has been deleted.",
                            "success"
                        );
                        fetchTasks();
                    },
                    error: function (xhr, status, error) {
                        Swal.fire(
                            "Error!",
                            "Failed to delete the task.",
                            "error"
                        );
                    },
                });
            }
        });
    });

    // delete all task from todo table
    $(".clear-all").click(function () {
        if ($(".todo-list").children().length === 0) {
            Swal.fire("No tasks", "There are no tasks to clear.", "info");
            return;
        }

        // Confirm deletion
        Swal.fire({
            title: "Are you sure?",
            text: "You will not be able to recover these tasks!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Yes, clear all!",
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "/api/tasks",
                    method: "DELETE",
                    success: function (response) {
                        $(".todo-list").empty();
                        // Update pending tasks count
                        $(".pending-task").text("You have 0 pending tasks");

                        Swal.fire(
                            "Cleared!",
                            "All tasks have been deleted.",
                            "success"
                        );
                    },
                    error: function (xhr, status, error) {
                        Swal.fire("Error!", "Failed to clear tasks.", "error");
                    },
                });
            }
        });
    });

    $(".todo-list").on("click", ".edit-btn", function () {
        var taskId = $(this).data("task-id");
        var taskTitle = $(this).data("task-title");

        // Show the modal
        $("#editTaskModal").modal("show");

        $("#editTaskModal").data("task-id", taskId);
        $("#editTaskInput").val(taskTitle);
    });

    // code of update task
    $("#editTaskSubmit").click(function () {
        var taskId = $("#editTaskModal").data("task-id");
        var updatedTitle = $("#editTaskInput").val();

        $.ajax({
            url: "/api/tasks/" + taskId,
            method: "PUT",
            data: { title: updatedTitle },
            success: function (response) {
                $("#editTaskModal").modal("hide");
                fetchTasks();
            },
            error: function (xhr, status, error) {
                // Handle error
            },
        });
    });
});
