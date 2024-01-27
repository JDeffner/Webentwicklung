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