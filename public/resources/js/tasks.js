/* Available variables:
const BASE_URL     Declared in head.php
let formRequest    Declared in main.js
 */
let update = false;
$(document).ready(function () {
    onSucheChange();
});
function onSucheChange() {
    let timeout = null;

    function handleInputChange() {
        Suche();
    }
    document.getElementById('suchetasks').addEventListener('input', function() {
        clearTimeout(timeout);
        timeout = setTimeout(handleInputChange, 1000);
    });
}

function Suche() {

    const searchParam = $('#suchetasks').val();
    const allTasksOnBoard = document.getElementsByClassName('task');

    update = searchParam === '';

    for (let i = 0; i < allTasksOnBoard.length; i++) {
        allTasksOnBoard[i].style.display = '';
        if (searchParam !== '') {
            let searchableElementsOfTask = allTasksOnBoard[i].querySelectorAll('.searchable');
            let containsSearchParam = false;
            for (let j = 0; j < searchableElementsOfTask.length; j++) {
                if (searchableElementsOfTask[j].textContent.toLowerCase().indexOf(searchParam.toLowerCase()) !== -1)
                    containsSearchParam = true;
            }
            if (!containsSearchParam)
                allTasksOnBoard[i].style.display = 'none';
        }
    }
}

$(document).ready(function () {
    $('#reload').click(function (e) {
        e.preventDefault();
        currentBoardId = $('#boardidDropdown').val();
        reloadTaskBoard(currentBoardId);
    });

    let drake = dragula({
        isContainer: function (el) {
            return el.classList.contains('spaltenBody');
        },
        moves: function (el, source, handle, sibling) {
            return true;
        },
        accepts: function (el, target, source, sibling) {
            return true; // elements are always draggable by default
        },
        invalid: function (el, handle) {
            return false; // don't prevent any drags from initiating by default
        },

        direction: 'vertical',
        copy: false,
        copySortSource: false,
        revertOnSpill: false,
        removeOnSpill: false,
        mirrorContainer: document.body,
        ignoreInputTextSelection: true,
        slideFactorX: 0,
        slideFactorY: 0,
    });

    drake.on('drag', function(el,target,source,sibling) {
        update = false;
    });

    drake.on('drop', function(el,target,source,sibling) {
        update = true;
        updateTaskSpaltenId(el.dataset.id, target.dataset.id);
    })
});

function reloadTaskBoard(boardId) {
    $.ajax({
        url: BASE_URL + 'tasks/raw/' + boardId,
        type: "POST",
        dataType: "json",
        success: function (response) {
            $('#tasksBoard').empty();
            response.spalten.forEach((value) => {
                $('#tasksBoard').append(`
                    <div class="me-3">
                        <div class="card">
                            <div class="card-header">
                                <h3>${value.spalte}</h3>
                                <small class="mb-0">${value.spaltenbeschreibung}</small>
                            </div>
                            <div class="card-body spaltenBody" id="spalte${value.id}" data-id="${value.id}">
                            </div>
                        </div>
                    </div>
                `);
            });
            response.tasks.forEach((value) => {
                $(`#spalte${value.spaltenid}`).append(`
                    <div class="card my-1 task cursor-grab" id="task${value.id}" data-id="${value.id}">
                        <div class="card-body">
                            <table>
                                <tbody>
                                    <tr>
                                        <th scope="row">Name</th>
                                        <td class="searchable">${value.task}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Notiz</th>
                                        <td>${value.notizen}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Erinnerungsdatum</th>
                                        <td>${value.erinnerungsdatum}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Zugeteilte Person</th>
                                        <td class="searchable">${value.vorname} ${value.nachname}</td>
                                    </tr>
                                </tbody>
                            </table>
                            <i data-bs-target="#editTaskModal" class="fa-solid fa-pen-to-square editTaskButton" data-bs-toggle="modal"
                               data-task="${value.task}"
                               data-taskartenid="${value.taskartenid}"
                               data-taskartenicon="${value.taskartenicon}"
                               data-taskart="${value.taskart}"
                               data-spaltenid="${value.spaltenid}"
                               data-personenid="${value.personenid}"
                               data-erinnerungsdatum="${value.erinnerungsdatum}"
                               data-erinnerung="${value.erinnerung}"
                               data-notizen="${value.notizen}"
                               data-id="${value.id}">
                            </i>
                            <i class="fa-solid fa-trash deleteTaskButton" data-bs-toggle="modal" data-bs-target="#deleteTaskModal"
                               data-id="${value.id}"
                               data-boards-id="${value.boardsid}"
                               data-task="${value.task}">
                            </i>
                        </div>
                    </div>
                `);
            });
        }
    });
}


function Boardupdate(id, board) {
    $('#boardidDropdown').val(id);

    $("#boardidDropdownButton span").html(board);

    reloadTaskBoard(id);
}

function updateTaskSpaltenId(taskId, spaltenId) {
    $.ajax({
        url: BASE_URL + 'tasks/bearbeiten/spalte/' + taskId + '/' + spaltenId,
        type: "POST",
        dataType: "json",
        success: function (response) {
            // console.log(response);
        }
    });
}

// Erinnerung Checkbox disable/enable Erinnerungsdatum
$('.form-check-input').on('change', function() {

    if ($(this).prop('checked')) {
        $('.erinnerungsdatum').removeAttr('disabled');
    } else {

        $('.erinnerungsdatum').attr('disabled', '');
    }
});

// Delete Task ajax
$(document).on('submit', '#deleteTaskForm', function (e) {
    e.preventDefault();
    $.ajax({
        type: "POST",
        url: $(this).attr('data-delete-at'),
        dataType: 'json',
        data: $(this).serialize(),
        success: function (response) {
            $('.alert').remove();
            if (response.successfulValidation) {
                $('#deleteTaskModal').modal('hide');
                $(`#task${response.taskid}`).remove();
            } else {
                $('#deleteTaskModal').modal('hide');
                // Create a Bootstrap alert dynamically
                const alertDiv = $('<div class="alert alert-danger alert-dismissible fade show" role="alert"></div>');
                const closeButton = $('<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>');
                const messageDiv = $('<div></div>').text(response.error.deletion);
                alertDiv.append(messageDiv);
                alertDiv.append(closeButton);
                // Append the alert above the buttons
                $('#tasks-table-toolbar').before(alertDiv);
            }
        }
    });
});
