export const STORAGE_KEY = 'minmax-kanban-demo-v1';
const collections = ['boards', 'columns', 'people', 'types', 'tasks'];

export function seedState(now = new Date()) {
    const today = now.toISOString().slice(0, 10);
    const tomorrow = new Date(now.getTime() + 86400000).toISOString().slice(0, 10) + 'T12:00';
    return {
        version: 1,
        boards: [{ id: 'b1', name: 'Website-Relaunch' }, { id: 'b2', name: 'Semesterplanung' }],
        columns: [
            { id: 'c1', boardId: 'b1', name: 'Offen', description: 'Ideen und nächste Schritte' },
            { id: 'c2', boardId: 'b1', name: 'In Arbeit', description: 'Daran arbeiten wir gerade' },
            { id: 'c3', boardId: 'b1', name: 'Erledigt', description: 'Geschafft!' },
            { id: 'c4', boardId: 'b2', name: 'Geplant', description: 'Für das nächste Semester' },
            { id: 'c5', boardId: 'b2', name: 'Erledigt', description: '' },
        ],
        people: [{ id: 'p1', name: 'Alex Winter' }, { id: 'p2', name: 'Sam Keller' }, { id: 'p3', name: 'Mia Sommer' }],
        types: [{ id: 'k1', name: 'Aufgabe' }, { id: 'k2', name: 'Idee' }, { id: 'k3', name: 'Fehler' }],
        tasks: [
            { id: 't1', columnId: 'c1', name: 'Neue Startseite skizzieren', notes: 'Welche Inhalte sollen zuerst sichtbar sein? Zwei Entwürfe vergleichen.', personId: 'p1', typeId: 'k2', created: today, reminder: tomorrow },
            { id: 't2', columnId: 'c1', name: 'Texte für die Projektseiten', notes: 'Ziel, Umsetzung und Ergebnis für jedes Projekt beschreiben.', personId: 'p3', typeId: 'k1', created: today, reminder: '' },
            { id: 't3', columnId: 'c2', name: 'Mobile Navigation testen', notes: 'Menü auf kleinen Bildschirmen prüfen. Tastaturbedienung nicht vergessen.', personId: 'p2', typeId: 'k3', created: today, reminder: '' },
            { id: 't4', columnId: 'c2', name: 'Kanban-Demo ausprobieren', notes: 'Ziehe diese Task in eine andere Spalte. Zum Bearbeiten auf den Titel klicken.', personId: 'p1', typeId: 'k1', created: today, reminder: '' },
            { id: 't5', columnId: 'c3', name: 'Projektstruktur festlegen', notes: 'Boards, Spalten und Taskarten sind eingerichtet.', personId: 'p3', typeId: 'k1', created: today, reminder: '' },
            { id: 't6', columnId: 'c4', name: 'Lerngruppe organisieren', notes: 'Termine sammeln und einen gemeinsamen Lernplan erstellen.', personId: 'p2', typeId: 'k1', created: today, reminder: '' },
        ],
    };
}

export function validateState(state) {
    if (!state || state.version !== 1) throw new Error('Unbekanntes Datenformat.');
    const ids = {};
    for (const key of collections) {
        if (!Array.isArray(state[key])) throw new Error('Unvollständige Daten.');
        ids[key] = new Set();
        for (const item of state[key]) {
            if (!item || typeof item.id !== 'string' || !item.id || ids[key].has(item.id)
                || typeof item.name !== 'string' || !item.name.trim() || item.name.length > 100) {
                throw new Error('Ungültiger Eintrag.');
            }
            ids[key].add(item.id);
        }
    }
    for (const column of state.columns) {
        if (!ids.boards.has(column.boardId) || typeof column.description !== 'string' || column.description.length > 250) throw new Error('Ungültige Spalte.');
    }
    for (const task of state.tasks) {
        if (!ids.columns.has(task.columnId) || (task.personId !== '' && !ids.people.has(task.personId))
            || (task.typeId !== '' && !ids.types.has(task.typeId)) || typeof task.notes !== 'string' || task.notes.length > 10000
            || typeof task.created !== 'string' || !/^\d{4}-\d{2}-\d{2}$/.test(task.created) || !Number.isFinite(Date.parse(task.created))
            || typeof task.reminder !== 'string' || (task.reminder !== '' && (!/^\d{4}-\d{2}-\d{2}T\d{2}:\d{2}$/.test(task.reminder) || !Number.isFinite(Date.parse(task.reminder))))) {
            throw new Error('Ungültige Task.');
        }
    }
    return state;
}

export function loadState(storage) {
    try {
        const value = storage.getItem(STORAGE_KEY);
        return { state: value ? validateState(JSON.parse(value)) : seedState(), warning: '' };
    } catch {
        return { state: seedState(), warning: 'Gespeicherte Daten sind nicht verfügbar. Die Demo startet mit Beispieldaten. Änderungen können nur gespeichert werden, wenn der Browser dies erlaubt.' };
    }
}

export function saveState(storage, state) {
    validateState(state);
    storage.setItem(STORAGE_KEY, JSON.stringify(state));
}

export function upsert(state, collection, values, id = '') {
    if (!collections.includes(collection)) throw new Error('Unbekannter Eintrag.');
    const next = structuredClone(state);
    const existing = id ? next[collection].find(item => item.id === id) : null;
    if (id && !existing) throw new Error('Eintrag nicht gefunden.');
    const item = { ...existing, ...values, id: id || crypto.randomUUID() };
    if (typeof item.name === 'string') item.name = item.name.trim();
    if (existing) next[collection][next[collection].indexOf(existing)] = item;
    else next[collection].push(item);
    return validateState(next);
}

export function removeItem(state, collection, id) {
    if (!collections.includes(collection) || !state[collection].some(item => item.id === id)) throw new Error('Eintrag nicht gefunden.');
    const next = structuredClone(state);
    next[collection] = next[collection].filter(item => item.id !== id);
    if (collection === 'boards') next.columns = next.columns.filter(column => column.boardId !== id);
    if (collection === 'boards' || collection === 'columns') {
        const columnIds = new Set(next.columns.map(column => column.id));
        next.tasks = next.tasks.filter(task => columnIds.has(task.columnId));
    }
    if (collection === 'people' || collection === 'types') {
        const field = collection === 'people' ? 'personId' : 'typeId';
        next.tasks.forEach(task => { if (task[field] === id) task[field] = ''; });
    }
    return validateState(next);
}

export function moveTask(state, taskId, columnId, beforeTaskId = '') {
    const next = structuredClone(state);
    const task = next.tasks.find(item => item.id === taskId);
    if (!task || !next.columns.some(column => column.id === columnId)) throw new Error('Task oder Spalte nicht gefunden.');
    if (taskId === beforeTaskId) return next;
    next.tasks = next.tasks.filter(item => item.id !== taskId);
    task.columnId = columnId;
    const before = next.tasks.findIndex(item => item.id === beforeTaskId && item.columnId === columnId);
    if (before === -1) next.tasks.push(task);
    else next.tasks.splice(before, 0, task);
    return validateState(next);
}
