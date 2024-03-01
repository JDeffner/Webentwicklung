/* Available variables:
const BASE_URL     Declared in head.php
let formRequest    Declared in main.js
 */

function taskartenAjaxRequest(params) {
    $.ajax({
        url: BASE_URL + 'admin/taskarten/raw',
        type: 'get',
        dataType: 'json',
        success: function (response) {
            response.taskarten.forEach(function(taskart) {
                taskart.bearbeiten = `<i class="fa-solid fa-pen-to-square iconClickable editTaskartButton" data-bs-toggle="modal" data-bs-target="#editTaskartModal" 
                                data-id="${taskart.id}" data-taskart="${taskart.taskart}"></i>
                                <i class="fa-solid fa-trash iconClickable deleteTaskartButton" data-bs-toggle="modal" data-bs-target="#deleteTaskartModal" 
                                data-id="${taskart.id}" data-taskart="${taskart.taskart}"></i>`;
            });
            params.success({
                total: response.taskarten.length,
                rows:  response.taskarten
            })
        }
    })
}

// Delete Taskart ajax

$(document).on('submit', '#deleteTaskartForm', function (e) {
    e.preventDefault();
    $.ajax({
        type: "POST",
        url: $(this).attr('data-delete-at'),
        dataType: 'json',
        data: $(this).serialize(),
        success: function (response) {
            $('.alert').remove();
            if (response.successfulValidation) {
                showToast(response.tableName, response.action);
                $('#deleteTaskartModal').modal('hide');
                $('#taskartenTable').bootstrapTable('refresh');
            }
        }
    });
});