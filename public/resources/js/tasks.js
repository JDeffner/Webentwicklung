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
        reloadTaskBoard('1');
    });
});

function reloadTaskBoard(boardId) {

    $.ajax({
        url: BASE_URL + 'tasks/raw/' + boardId,
        type: "POST",
        dataType: "json",
        success: function (response) {
            // console.log(response);
            // response  spalten and tasks.  Iterate over the spalten and tasks and append them to the dom
            $('#tasksBoard').empty();
            $.each(response.spalten, function (key, value) {
                $('#tasksBoard').append('<div class="me-3">\n' +
                    '                        <div class="card">\n' +
                    '                            <div class="card-header">\n' +
                    '                                <h3>' + value.spalte + '</h3>\n' +
                    '                                <small class="mb-0">' + value.spaltenbeschreibung + '</small>\n' +
                    '                            </div>\n' +
                    '                            <div class="card-body spaltenBody" id="spalte' + value.id + '">\n' +
                    '                            </div>\n' +
                    '                        </div>\n' +
                    '                    </div>');
            });
            $.each(response.tasks, function (key, value) {
                $('#spalte' + value.spaltenid).append('<div class="card my-1 task" id="task' + value.id + '" draggable="true">\n' +
                    '    <div class="card-body">\n' +
                    '        <table>\n' +
                    '            <tbody>\n' +
                    '            <tr>\n' +
                    '                <th scope="row">Name</th>\n' +
                    '                <td class="searchable">' + value.task + '</td>\n' +
                    '            </tr>\n' +
                    '            <tr>\n' +
                    '                <th scope="row">Notiz</th>\n' +
                    '                <td>' + value.notizen + '</td>\n' +
                    '            </tr>\n' +
                    '            <tr>\n' +
                    '                <th scope="row">Erinnerungsdatum</th>\n' +
                    '                <td>' + value.erinnerungsdatum + '</td>\n' +
                    '            </tr>\n' +
                    '            <tr>\n' +
                    '                <th scope="row">Zugeteilte Person</th>\n' +
                    '                <td class="searchable">' + value.vorname + ' ' + value.nachname + '</td>\n' +
                    '            </tbody>\n' +
                    '        </table>\n' +
                    '        <i data-bs-target="#editTaskModal" class="fa-solid fa-pen-to-square editTaskButton" data-bs-toggle="modal"' +
                    '               data-task="' + value.task + '"' +
                    '               data-taskartenid="' + value.taskartenid + '"' +
                    '               data-taskartenicon="' + value.taskartenicon + '"' +
                    '               data-taskart="' + value.taskart + '"' +
                    '               data-spaltenid="' + value.spaltenid + '"' +
                    '               data-personenid="' + value.personenid + '"' +
                    '               data-erinnerungsdatum="' + value.erinnerungsdatum + '"' +
                    '               data-erinnerung="' + value.erinnerung + '"' +
                    '               data-notizen="' + value.notizen + '"' +
                    '               data-id="' + value.id + '">\n' +
                    '            </i>\n' +
                    '            <i class="fa-solid fa-trash deleteTaskButton" data-bs-toggle="modal" data-bs-target="#deleteTaskModal"' +
                    '               data-id="' + value.id + '"' +
                    '               data-boards-id="' + value.boardsid + '"' +
                    '               data-task="' + value.task + '">\n' +
                    '            </i>\n' +
                    '    </div>\n' +
                    '</div>');
            });


        }
    });
}