/* Available variables:
const BASE_URL     Declared in head.php
let formRequest    Declared in main.js
 */
let update = false;
$(document).ready(function () {
    onSucheChange();
    reloadTaskBoard($('#boardidDropdown').val());

    // Draggable taskBoard
    let isDown = false;
    let startX;
    let scrollLeft;

    const slider = document.querySelector('#tasksBoard');

    slider.addEventListener('mousedown', (e) => {
        isDown = true;
        slider.classList.add('active');
        startX = e.pageX - slider.offsetLeft;
        scrollLeft = slider.scrollLeft;
    });

    slider.addEventListener('mouseleave', () => {
        isDown = false;
        slider.classList.remove('active');
    });

    slider.addEventListener('mouseup', () => {
        isDown = false;
        slider.classList.remove('active');
    });

    slider.addEventListener('mousemove', (e) => {
        if(!isDown) return;
        e.preventDefault();
        const x = e.pageX - slider.offsetLeft;
        const walk = (x - startX) * 3; //scroll-fast
        slider.scrollLeft = scrollLeft - walk;
    });
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
        let currentBoardId = $('#boardidDropdown').val();
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
        el.style.cursor = 'grabbing';
    });

    drake.on('drop', function(el,target,source,sibling) {
        update = true;
        // console.log(source.dataset.id, target.dataset.id);
        if(source.dataset.id !== target.dataset.id)
            updateTaskSpaltenId(el.dataset.id, target.dataset.id);

        let previousElement = el.previousElementSibling;
        let draggedTaskSortid = previousElement !== null ? Number(previousElement.dataset.sortid) + 1 : 0;

        let tasksAfterEl = [];
        for (let taskToEdit = sibling; taskToEdit !== null; taskToEdit = taskToEdit.nextElementSibling) {
            tasksAfterEl.push(taskToEdit.dataset.id);
        }

        let sortidToEdit = draggedTaskSortid + 1;
        let tasksToUpdate = [];
        for(let taskId of tasksAfterEl) {
            tasksToUpdate.push({id: taskId, sortid: sortidToEdit++});
        }
        tasksToUpdate.push({id: el.dataset.id, sortid: draggedTaskSortid});

        updateTaskSortIds(tasksToUpdate);
    })

    drake.on('dragend', function(el, container, source) {
        el.style.cursor = 'grab';
    });
});

function reloadTaskBoard(boardId) {
    $.ajax({
        url: BASE_URL + 'tasks/raw/' + boardId,
        type: "POST",
        dataType: "json",
        success: function (response) {
            // Spalten laden
            $('#tasksBoard').empty();
            response.boardSpalten.forEach((spalteOfBoard) => {
                $('#tasksBoard').append(`
                    <div class="card col-auto mx-2">
                        <div class="card-header d-flex align-items-center justify-content-between" data-id="${spalteOfBoard.id}">
                            <div class="me-3">
                                <a class="editSpalteButton editSpalteText" data-bs-target="#editSpalteModal" data-bs-toggle="modal" data-id="${spalteOfBoard.id}" data-spalte="${spalteOfBoard.spalte}" title="Taskname, drücken zum Bearbeiten">
                                    <h3 class="text-nowrap">${spalteOfBoard.spalte}</h3>
                                </a>
                                <small class="mb-0">${spalteOfBoard.spaltenbeschreibung}</small>
                            </div> 
                            <a role="button" class="btn btn-secondary createTaskButton my-auto" data-bs-toggle="modal" data-bs-target="#createTaskModal" title="Task erstellen">
                                <i class="fa-solid fa-plus"></i>
                            </a>
                        </div>
                        <div class="card-body spaltenBody" id="spalte${spalteOfBoard.id}" data-id="${spalteOfBoard.id}">
<!--                            Tasks werden hier eingefügt-->
                        </div>
                    </div>
                `);
            });
            // Tasks laden
            response.tasks.forEach((oneTask) => {
                let formattedErinnerungsdatum = '';
                let erinnerungsGlocke = '';
                let options = {
                    day: '2-digit',
                    month: '2-digit',
                    year: '2-digit',
                    hour: '2-digit',
                    minute: '2-digit'
                };
                if (oneTask.erinnerung === '1') {
                    let erinnerungsdatum = new Date(oneTask.erinnerungsdatum);

                    formattedErinnerungsdatum = erinnerungsdatum.toLocaleDateString('de-DE', options);


                    let timeDiff = erinnerungsdatum - new Date();
                    let daysDiff = timeDiff / (1000 * 60 * 60 * 24);

                    if (daysDiff > 2) {
                        erinnerungsGlocke = 'fa-regular fa-bell fa-fw';
                    } else if (daysDiff > 0) {
                        erinnerungsGlocke = 'fa-regular fa-bell fa-fw text-warning';
                    } else {
                        erinnerungsGlocke = 'fa-regular fa-bell fa-fw text-danger';
                    }
                } else {
                    erinnerungsGlocke = 'fa-regular fa-bell-slash fa-fw text-secondary';
                }
                $(`#spalte${oneTask.spaltenid}`).append(`         
                    <div id="task${oneTask.id}"  class="card my-2 task cursor-grab mx-auto" data-id="${oneTask.id}" data-sortid="${oneTask.sortid}">
                        <div class="card-body">
                        <!-- Titel -->
                            <div class="d-flex justify-content-between mb-1">
                                <a class="editTaskButton searchable" data-bs-toggle="modal" data-bs-target="#editTaskModal" 
                                        data-id="${oneTask.id}" data-task="${oneTask.task}" title="Name der Task">
                                    <i class="${oneTask.taskartenicon} fa-fw" title="Icon der Task"></i> ${oneTask.task}                                                       
                                </a>
                                <span class="dropdown position-static">
                                    <a class="btn btn-link ps-0 pt-0 pb-0 pe-0" role="button" data-bs-toggle="dropdown" data-boundary="viewport" 
                                    aria-haspopup="true" aria-expanded="false" title="Aktionen">
                                        <i class="fas fa-caret-square-down text-primary"></i>
                                    </a>
                                   
                                    <div class="dropdown-menu"> 
                                        <li>
                                            <a class="dropdown-item copyTaskButton" data-bs-toggle="modal" data-bs-target="#copyTaskModal"
                                                data-id="${oneTask.id}" data-task="${oneTask.task}">
                                                <span title="Task bearbeiten" class="icon-menu text-primary"><i class="fas fa-solid fa-copy"></i></span>
                                                Task kopieren
                                            </a>
                                        </li>
                            
                                        <li>
                                            <a class="dropdown-item editTaskButton" data-bs-toggle="modal" data-bs-target="#editTaskModal" 
                                                data-id="${oneTask.id}" data-task="${oneTask.task}">
                                                <span title="Task bearbeiten" class="icon-menu text-primary"><i class="fas fa-solid fa-pen-to-square"></i></span>
                                                Task bearbeiten
                                            </a>
                                        </li>
                            
                                        <li>
                                            <a class="dropdown-item deleteTaskButton" data-bs-toggle="modal" data-bs-target="#deleteTaskModal" 
                                                data-id="${oneTask.id}" data-boards-id="${oneTask.boardsid}" data-task="${oneTask.task}">
                                                <span title="Task bearbeiten" class="icon-menu text-primary"><i class="fas fa-solid fa-trash"></i></span>
                                                Task löschen
                                            </a>
                                        </li>
                                    </div>
                                </span>
                            </div>
                    
                            <!-- Erstell- und Erinnerungsdatum -->
                            <div class="mb-1 d-flex justify-content-between">
                                <div class="text-primary" title="Erstelldatum">
                                    <i class="fa-solid fa-circle-up fa-fw"></i> ${new Date(oneTask.erstelldatum).toLocaleDateString('de-DE', {day: '2-digit', month: '2-digit', year: '2-digit'})}                                                       
                                </div>
                                <div class="text-primary" title="Erinnerungsdatum">
                                    <i class="${erinnerungsGlocke}"></i> ${formattedErinnerungsdatum}                                                    
                                </div>
                            </div>
                            <div class="d-flex pt-1 justify-content-between">
                                 <div class="text-primary taskNotizen" title="Notizen">
                                    ${oneTask.notizen}
                                 </div>
                            </div>
                            <!-- Zugeteilte Person -->
                            <div class="searchable" hidden>${oneTask.vorname} ${oneTask.nachname}</div>
                            <div class="d-flex pt-1 justify-content-between">
                                <div></div>
                                <span class="rounded-circle text-xs personenkuerzel" title="${oneTask.vorname} ${oneTask.nachname}"
                                      style="color: #FFFFFF; background: #6f58a1;">
                                    ${oneTask.vorname.substring(0, 1)}${oneTask.nachname.substring(0, 1)}                                                       
                                </span>
                            </div>
                        </div>
                    </div>
                `);
            });
            // Boards laden
            let boardDropdownMenu = $('#boardidDropdownMenu');
            boardDropdownMenu.empty();

            let boardSelectInModals = $('.boardSelect');
            boardSelectInModals.empty();
            boardSelectInModals.append(`
                <option>Board auswählen</option>
            `);
            response.boards.forEach((oneBoard) => {
                // Dropdown aktualisieren
                boardDropdownMenu.append(`
                    <li><a class="dropdown-item" onclick="Boardupdate('${oneBoard.id}', '${oneBoard.board}')">${oneBoard.board}</a></li>
                `);

                // Board Select aktualisieren
                boardSelectInModals.append(`
                    <option value="${oneBoard.id}">${oneBoard.board}</option>
                `);
            });
            boardDropdownMenu.append(`
                    <li><a class="dropdown-item d-flex justify-content-center align-items-center py-2 createBoardButton" data-bs-toggle="modal" data-bs-target="#createBoardModal"><i class="fa-solid fa-plus"></i></a></li>
            `);
            // Spalte & Board Select aktualisieren
            $('.spaltenSelect').empty();
            let spaltenSelectElement = $('.spaltenSelect');
            spaltenSelectElement.append(`
                <option selected>Spalte auswählen</option>
            `);
            response.boards.forEach((oneBoard) => {
                response.boardSpalten.forEach((oneSpalte) => {
                    if (oneSpalte.boardsid === oneBoard.id) {
                        spaltenSelectElement.append(`
                            <option value="${oneSpalte.id}">${oneBoard.board} - ${oneSpalte.spalte}</option>
                        `);
                    }
                });
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
                showToast(response.tableName, response.action);
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

function updateTaskSortIds(tasks) {
    $.ajax({
        url: BASE_URL + 'tasks/bearbeiten/sortids',
        type: "POST",
        dataType: "json",
        data: JSON.stringify(tasks),
        contentType: "application/json",
        success: function (response) {
            // console.log(response);
        }
    });
}


$(document).on('click', '.personenkuerzel', function (e) {
    e.preventDefault();
    let name = $(this).attr('title');


    let searchParam = name;
    $('#suchetasks').val(searchParam);
    Suche();
});

document.addEventListener('keydown', function(event) {
    if (document.activeElement.tagName === 'INPUT' || document.activeElement.tagName === 'TEXTAREA')
        return;
    if (event.key === 'Escape') {
        document.getElementById('suchetasks').value = '';
    } else if (!event.key.startsWith('F')) {
        // Set focus to the #suchetasks search field
        document.getElementById('suchetasks').focus();
    }
});

$(document).on('click', '.createTaskButton', function (e) {
    e.preventDefault();
    let spaltenId = $(this).parent().data('id');
    $('#createTaskModal').find('#spaltenid').val(spaltenId);
});

$(document).on('click', '.createSpalteButton', function (e) {
    e.preventDefault();
    let boardId = $('#boardidDropdown').val();
    $('#createSpalteModal').find('#boardsid').val(boardId);
});

$(document).on('click', '.notizenButton', function (e) {
    e.preventDefault();
    $('.taskNotizen').toggle();
});
