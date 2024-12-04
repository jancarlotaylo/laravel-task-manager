$(document).ready(function () {
    $('#task-form').on('submit', function (e) {
        e.preventDefault(); // Prevent normal form submission

        $.ajax({
            url: '/tasks/' + $('#task_id').val(),
            method: 'PUT',
            data: {
                title: $('#title').val(),
                content: $('#content').val(),
                status: $('#status').val(),
                user_id: $('#user_id').val(),
                published_at: $('#published_at').val(),
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                $('#task-form button[type=submit]').attr('readonly', 'readonly');
                $('#task-form button[type=submit]').attr('disabled', 'disabled');
                $('#task-form button[type=submit]').css('background-color', 'gray');

                // Display success message
                $('#task-message')
                    .text(response.message + ` Redirecting...`)
                    .removeClass('bg-red-500') // Ensure no error class remains
                    .addClass('bg-green-500')
                    .fadeIn()
                    .delay(3000)
                    .fadeOut(function () {
                        // Redirect after fade out
                        window.location.href = '/tasks';
                    });
            },
            error: function (xhr) {
                // Display error message
                $('#task-message')
                    .text(xhr.responseJSON.message || 'Error occurred while adding the task.')
                    .removeClass('bg-green-500') // Ensure no success class remains
                    .addClass('bg-red-500')
                    .fadeIn()
                    .delay(3000)
                    .fadeOut();
            }
        });
    });

    $('#task-form #cancel').click(function() {
        window.location.href = '/tasks';
    });

    // Handle the toggle logic for setting published_at to null if unchecked
    $('#published-toggle').on('change', function() {
        console.log($(this).prop('checked'));
        if ($(this).prop('checked')) {
            // Set published_at to current timestamp (when toggle is ON)
            $('#published_at').val(formatDateToYMDHIS(new Date()));
            $('#publication_label').text('Published');
            $('#bg').addClass('bg-green-500');
            $('#bg').removeClass('bg-gray-300');
            $('#dot').removeClass('left-1');
            $('#dot').css('right', '0.25rem');
        } else {
            // Set published_at to null (when toggle is OFF)
            $('#published_at').val('');
            $('#publication_label').text('Draft');
            $('#bg').removeClass('bg-green-500');
            $('#bg').addClass('bg-gray-300');
            $('#dot').addClass('left-1');
        }
    });

    // Function to format the date to Y-m-d H:i:s
    function formatDateToYMDHIS(date) {
        let year = date.getFullYear();
        let month = String(date.getMonth() + 1).padStart(2, '0'); // Months are zero-indexed, so add 1
        let day = String(date.getDate()).padStart(2, '0');
        let hours = String(date.getHours()).padStart(2, '0');
        let minutes = String(date.getMinutes()).padStart(2, '0');
        let seconds = String(date.getSeconds()).padStart(2, '0');

        return `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;
    }
});