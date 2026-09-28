import { STORAGE_KEY, seedState, loadState, saveState, upsert, removeItem, moveTask } from './store.mjs';

const $ = selector => document.querySelector(selector);
const escape = value => String(value ?? '').replace(/[&<>"']/g, char => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' })[char]);
let storage;
try { storage = window.localStorage; } catch { /* The storage warning is shown below. */ }
const loaded = loadState(storage);
let state = loaded.state;
let selectedBoard = state.boards[0]?.id ?? '';
let query = '';
let showNotes = true;
let draggedTask = '';
let editing = null;
let confirmationAction = null;
let statusTimer;
const names = { tasks: 'Task', boards: 'Board', columns: 'Spalte', people: 'Person', types: 'Taskart' };
const headings = { tasks: 'Tasks', boards: 'Boards', columns: 'Spalten', people: 'Personen', types: 'Taskarten' };

function currentView() { return Object.hasOwn(names, location.hash.slice(1)) ? location.hash.slice(1) : 'tasks'; }
function lookup(collection, id) { return state[collection].find(item => item.id === id); }
function warning(message) { $('#storage-warning').textContent = message; $('#storage-warning').hidden = !message; }
function announce(message) {
    clearTimeout(statusTimer);
    $('#status').textContent = message;
    statusTimer = setTimeout(() => { $('#status').textContent = ''; }, 4000);
}
function commit(next, message) {
    state = next;
    try { saveState(storage, state); warning(''); }
    catch { warning('Änderungen gelten nur für diese Sitzung. Der Browser konnte sie nicht speichern. Beim Neuladen können sie verloren gehen.'); }
    render();
    announce(message);
}
function button(action, label, collection = '', id = '', style = 'btn btn-sm btn-secondary') {
    return `<button type="button" class="${style}" data-action="${action}" data-collection="${collection}" data-id="${escape(id)}">${label}</button>`;
}
function options(items, selected, emptyLabel = '') {
    return (emptyLabel ? `<option value="">${emptyLabel}</option>` : '') + items.map(item => `<option value="${escape(item.id)}"${item.id === selected ? ' selected' : ''}>${escape(item.name)}</option>`).join('');
}
function date(value, time = false) {
    return new Intl.DateTimeFormat('de-DE', { day: '2-digit', month: '2-digit', ...(time ? { hour: '2-digit', minute: '2-digit' } : { year: '2-digit' }) }).format(new Date(time ? value : value + 'T12:00'));
}
function taskMatches(task) {
    return [task.name, task.notes, lookup('people', task.personId)?.name, lookup('types', task.typeId)?.name].join(' ').toLocaleLowerCase('de').includes(query.toLocaleLowerCase('de'));
}
function taskCard(task) {
    const person = lookup('people', task.personId);
    const initials = person?.name.split(/\s+/).map(part => part[0]).slice(0, 2).join('') ?? '';
    return `<article class="task" draggable="true" data-task-id="${escape(task.id)}" aria-label="${escape(task.name)}">
        <span class="task-type">${escape(lookup('types', task.typeId)?.name ?? 'Ohne Taskart')}</span>
        ${button('edit', escape(task.name), 'tasks', task.id, 'plain-button task-title')}
        <div class="task-dates"><span title="Erstellt am">↑ ${date(task.created)}</span>${task.reminder ? `<span class="${new Date(task.reminder) < new Date() ? 'overdue' : ''}" title="Erinnerung">◷ ${date(task.reminder, true)}</span>` : ''}</div>
        ${showNotes && task.notes ? `<p class="task-notes">${escape(task.notes)}</p>` : ''}
        <div class="task-bottom"><div class="task-actions">${button('copy', 'Kopieren', 'tasks', task.id, 'plain-button')}${button('delete', 'Löschen', 'tasks', task.id, 'plain-button')}</div>
        ${person ? `<button class="avatar" type="button" data-action="filter-person" data-id="${escape(person.id)}" title="${escape(person.name)}" aria-label="Tasks von ${escape(person.name)} anzeigen">${escape(initials)}</button>` : '<span class="task-type">Nicht zugeteilt</span>'}</div>
    </article>`;
}
function renderBoard() {
    const columns = state.columns.filter(column => column.boardId === selectedBoard);
    if (!state.boards.length) return `<p class="empty">Noch kein Board. Erstelle ein Board, um loszulegen.</p>`;
    if (!columns.length) return `<p class="empty">Noch keine Spalten. Füge die erste Spalte hinzu.</p>`;
    return columns.map(column => {
        const tasks = state.tasks.filter(task => task.columnId === column.id && taskMatches(task));
        return `<section class="column" aria-label="${escape(column.name)}"><div class="column-heading"><div><h2>${button('edit', escape(column.name), 'columns', column.id, 'plain-button')} <small>(${tasks.length})</small></h2><p>${escape(column.description)}</p></div>
        <button type="button" class="btn btn-sm btn-secondary" data-action="create-task" data-id="${escape(column.id)}" aria-label="Task in ${escape(column.name)} erstellen">+ Neu</button></div>
        <div class="task-list" data-column-id="${escape(column.id)}">${tasks.map(taskCard).join('')}${tasks.length ? '' : '<p class="empty">' + (query ? 'Keine Treffer.' : 'Platz für die nächste Task.') + '</p>'}</div></section>`;
    }).join('');
}
function renderTable(collection) {
    const rows = state[collection].filter(item => [item.name, item.description ?? '', collection === 'columns' ? lookup('boards', item.boardId)?.name : ''].join(' ').toLocaleLowerCase('de').includes(query.toLocaleLowerCase('de')));
    const extras = collection === 'columns' ? '<th scope="col">Board</th><th scope="col">Beschreibung</th>' : collection === 'boards' ? '<th scope="col">Spalten</th>' : '';
    return `<div class="table-wrap"><table class="table table-hover"><thead><tr><th scope="col">${names[collection]}</th>${extras}<th scope="col">Aktionen</th></tr></thead><tbody>${rows.map(item => `<tr><td>${collection === 'boards' ? button('open-board', escape(item.name), collection, item.id, 'plain-button') : escape(item.name)}</td>
        ${collection === 'columns' ? `<td>${escape(lookup('boards', item.boardId)?.name)}</td><td>${escape(item.description)}</td>` : collection === 'boards' ? `<td>${state.columns.filter(column => column.boardId === item.id).length}</td>` : ''}
        <td><div class="table-actions">${button('edit', 'Bearbeiten', collection, item.id)}${button('delete', 'Löschen', collection, item.id, 'btn btn-sm btn-outline-light')}</div></td></tr>`).join('')}</tbody></table>${rows.length ? '' : '<p class="empty">Keine Einträge gefunden.</p>'}</div>`;
}
function renderContent() {
    const view = currentView();
    $('#content').innerHTML = view === 'tasks' ? renderBoard() : renderTable(view);
}
function render() {
    if (!lookup('boards', selectedBoard)) selectedBoard = state.boards[0]?.id ?? '';
    const view = currentView();
    document.title = `${headings[view]} | MinMax Kanban Demo`;
    document.querySelectorAll('nav a').forEach(link => {
        if (link.hash === '#' + view) link.setAttribute('aria-current', 'page');
        else link.removeAttribute('aria-current');
    });
    $('#main').innerHTML = `<section class="workspace" aria-labelledby="view-heading"><div class="toolbar"><h1 id="view-heading">${headings[view]}</h1>
        ${view === 'tasks' ? `${button('create', '+ Board', 'boards')}${selectedBoard ? button('create', '+ Spalte', 'columns') : ''}<button type="button" class="btn btn-sm btn-secondary" data-action="notes" aria-pressed="${showNotes}">Notizen</button>` : button('create', '+ ' + names[view], view)}
        <label class="visually-hidden" for="search">Suchen</label><input id="search" class="form-control" type="search" placeholder="Suchen" value="${escape(query)}" autocomplete="off">
        ${view === 'tasks' && state.boards.length ? `<label class="visually-hidden" for="board-select">Board auswählen</label><select id="board-select" class="form-select">${options(state.boards, selectedBoard)}</select>` : ''}</div>
        <div id="content"${view === 'tasks' ? ' class="board"' : ''}></div></section>`;
    renderContent();
}
function field(name, label, value, { kind = 'input', type = 'text', max = 100, required = false, items, emptyLabel } = {}) {
    const attributes = `id="field-${name}" name="${name}"${required ? ' required' : ''}`;
    const control = kind === 'select' ? `<select class="form-select" ${attributes}>${options(items, value, emptyLabel)}</select>`
        : kind === 'textarea' ? `<textarea class="form-control" ${attributes} maxlength="${max}">${escape(value)}</textarea>`
            : `<input class="form-control" ${attributes} type="${type}" maxlength="${max}" value="${escape(value)}">`;
    return `<div class="form-field"><label for="field-${name}">${label}</label>${control}</div>`;
}
function openEditor(collection, id = '', copy = false, columnId = '') {
    if (collection === 'columns' && !state.boards.length) { announce('Bitte zuerst ein Board erstellen.'); return; }
    if (collection === 'tasks' && !state.columns.length) { announce('Bitte zuerst eine Spalte erstellen.'); return; }
    const item = id ? lookup(collection, id) : {};
    if (!item) return;
    editing = { collection, id: copy ? '' : id, original: item };
    $('#editor-title').textContent = `${names[collection]} ${copy ? 'kopieren' : id ? 'bearbeiten' : 'erstellen'}`;
    let html = field('name', `Name ${collection === 'boards' ? 'des Boards' : 'der ' + names[collection]}`, copy ? `${item.name} (Kopie)`.slice(0, 100) : item.name ?? '', { required: true });
    if (collection === 'columns') {
        html += field('boardId', 'Board', item.boardId ?? selectedBoard, { kind: 'select', items: state.boards, required: true });
        html += field('description', 'Spaltenbeschreibung', item.description ?? '', { kind: 'textarea', max: 250 });
        html += '<p class="form-help">Beim Wechsel des Boards werden die Tasks dieser Spalte mitgenommen.</p>';
    }
    if (collection === 'tasks') {
        html += field('columnId', 'Board & Spalte', item.columnId ?? columnId ?? state.columns[0]?.id, { kind: 'select', required: true, items: state.columns.map(column => ({ id: column.id, name: `${lookup('boards', column.boardId).name} · ${column.name}` })) });
        html += field('personId', 'Zugeteilt an', item.personId ?? '', { kind: 'select', items: state.people, emptyLabel: 'Nicht zugeteilt' });
        html += field('typeId', 'Taskart', item.typeId ?? state.types[0]?.id ?? '', { kind: 'select', items: state.types, emptyLabel: 'Ohne Taskart' });
        html += field('reminder', 'Erinnerungsdatum (optional)', item.reminder ?? '', { type: 'datetime-local' });
        html += '<p class="form-help">Die Erinnerung wird auf der Task angezeigt. Es werden keine Benachrichtigungen versendet.</p>';
        html += field('notes', 'Notizen', item.notes ?? '', { kind: 'textarea', max: 10000 });
    }
    $('#editor-fields').innerHTML = html;
    $('#form-error').hidden = true;
    $('#editor').showModal();
    $('#field-name').focus();
}
function confirmAction(title, message, action) {
    confirmationAction = action;
    $('#confirmation-title').textContent = title;
    $('#confirmation-message').textContent = message;
    $('#confirmation').returnValue = '';
    $('#confirmation').showModal();
}

$('#editor-form').addEventListener('submit', event => {
    event.preventDefault();
    const values = Object.fromEntries(new FormData(event.currentTarget));
    if (!values.name.trim()) {
        $('#form-error').textContent = 'Bitte einen Namen eingeben.';
        $('#form-error').hidden = false;
        $('#field-name').focus();
        return;
    }
    const { collection, id, original } = editing;
    if (collection === 'tasks') values.created = id ? original.created : new Date().toISOString().slice(0, 10);
    try {
        const next = upsert(state, collection, values, id);
        if (collection === 'boards' && !id) selectedBoard = next.boards.at(-1).id;
        $('#editor').close();
        commit(next, `${names[collection]} ${id ? 'bearbeitet' : 'erstellt'}.`);
    } catch (error) {
        $('#form-error').textContent = error.message;
        $('#form-error').hidden = false;
    }
});
document.querySelectorAll('[data-close]').forEach(element => element.addEventListener('click', () => $('#editor').close()));
$('#confirmation').addEventListener('close', () => {
    const action = confirmationAction;
    confirmationAction = null;
    if ($('#confirmation').returnValue === 'confirm') action?.();
});
$('#reset').addEventListener('click', () => confirmAction('Demo zurücksetzen?', 'Alle Änderungen in dieser Demo werden durch die Beispieldaten ersetzt. Andere Daten in deinem Browser bleiben erhalten.', () => {
    query = '';
    showNotes = true;
    const next = seedState();
    selectedBoard = next.boards[0].id;
    commit(next, 'Demo zurückgesetzt.');
}));
$('#main').addEventListener('click', event => {
    const target = event.target.closest('[data-action]');
    if (!target) return;
    const { action, collection, id } = target.dataset;
    if (action === 'create') openEditor(collection);
    else if (action === 'create-task') openEditor('tasks', '', false, id);
    else if (action === 'edit' || action === 'copy') openEditor(collection, id, action === 'copy');
    else if (action === 'delete') {
        const item = lookup(collection, id);
        const extra = collection === 'boards' ? ' Alle Spalten und Tasks dieses Boards werden ebenfalls gelöscht.' : collection === 'columns' ? ' Alle Tasks dieser Spalte werden ebenfalls gelöscht.' : collection === 'people' || collection === 'types' ? ' Die Tasks bleiben erhalten; die Zuordnung wird entfernt.' : '';
        confirmAction(`${names[collection]} löschen?`, `„${item.name}“ wird gelöscht.${extra}`, () => commit(removeItem(state, collection, id), `${names[collection]} gelöscht.`));
    } else if (action === 'open-board') {
        selectedBoard = id;
        query = '';
        location.hash = 'tasks';
    } else if (action === 'notes') {
        showNotes = !showNotes;
        target.setAttribute('aria-pressed', showNotes);
        renderContent();
    } else if (action === 'filter-person') {
        query = lookup('people', id).name;
        $('#search').value = query;
        renderContent();
        $('#search').focus();
    }
});
$('#main').addEventListener('input', event => {
    if (event.target.id === 'search') { query = event.target.value; renderContent(); }
});
$('#main').addEventListener('change', event => {
    if (event.target.id === 'board-select') { selectedBoard = event.target.value; renderContent(); }
});
$('#main').addEventListener('dragstart', event => {
    const task = event.target.closest('[data-task-id]');
    if (!task || event.target.closest('button')) { event.preventDefault(); return; }
    draggedTask = task.dataset.taskId;
    event.dataTransfer.setData('text/plain', draggedTask);
    event.dataTransfer.effectAllowed = 'move';
    task.classList.add('dragging');
});
$('#main').addEventListener('dragover', event => {
    const list = event.target.closest('[data-column-id]');
    if (!list || !draggedTask) return;
    event.preventDefault();
    event.dataTransfer.dropEffect = 'move';
    document.querySelectorAll('.drop-target').forEach(element => element.classList.remove('drop-target'));
    list.classList.add('drop-target');
});
$('#main').addEventListener('drop', event => {
    const list = event.target.closest('[data-column-id]');
    if (!list || !draggedTask) return;
    event.preventDefault();
    const card = event.target.closest('[data-task-id]');
    let before = card?.dataset.taskId ?? '';
    if (card && event.clientY > card.getBoundingClientRect().top + card.getBoundingClientRect().height / 2) before = card.nextElementSibling?.dataset.taskId ?? '';
    commit(moveTask(state, draggedTask, list.dataset.columnId, before), 'Task verschoben.');
    draggedTask = '';
});
$('#main').addEventListener('dragend', () => {
    draggedTask = '';
    document.querySelectorAll('.dragging, .drop-target').forEach(element => element.classList.remove('dragging', 'drop-target'));
});
document.addEventListener('keydown', event => {
    if (event.key === '/' && !document.querySelector('dialog[open]') && !event.target.closest('input, textarea, select')) {
        event.preventDefault();
        $('#search').focus();
    }
    if (event.key === 'Escape' && event.target.id === 'search') { query = ''; event.target.value = ''; renderContent(); }
});
window.addEventListener('hashchange', () => { query = ''; render(); });
window.addEventListener('storage', event => {
    if (event.key !== STORAGE_KEY) return;
    // Keep an in-progress form intact; apply the latest state before the next save.
    const latest = loadState(storage);
    state = latest.state;
    warning(latest.warning);
    render();
    announce('Demo aus einem anderen Tab aktualisiert.');
});
warning(loaded.warning);
render();
