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
                            <div class="card-body spaltenBody" id="spalte${value.id}">
                            </div>
                        </div>
                    </div>
                `);
            });
            response.tasks.forEach((value) => {
                $(`#spalte${value.spaltenid}`).append(`
                    <div class="card my-1 task" id="task${value.id}" draggable="true">
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

function Taskartupdate(id, taskartenicon, taskart) {
    $('input[name="taskartenid"]').val(id);

    $("#btnTaskart span").html('<i class="' + taskartenicon + '"></i>' + ' ' + taskart);
}

function Boardupdate(id, board) {
    $('#boardidDropdown').val(id);

    $("#boardidDropdownButton span").html(board);

    reloadTaskBoard(id);
}