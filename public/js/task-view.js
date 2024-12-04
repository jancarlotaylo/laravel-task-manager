$(document).ready(function () {
    $('#task-form #back').click(function() {
        window.location.href = '/tasks';
    });

    $('#task-form #edit').click(function() {
        window.location.href = '/tasks/' + $('#task_id').val() + '/edit';
    });
});