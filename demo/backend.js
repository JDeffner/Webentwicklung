(function () {
    'use strict';
    const STORAGE_KEY = 'minmax-local-backend-v2';
    const SESSION_KEY = 'minmax-local-session-v2';
    const tables = ['boards', 'spalten', 'tasks', 'personen', 'taskarten'];
    const fields = {
        boards: ['board'], spalten: ['boardsid', 'sortid', 'spalte', 'spaltenbeschreibung'],
        tasks: ['sortid', 'task', 'erinnerungsdatum', 'erinnerung', 'notizen', 'erledigt', 'geloescht', 'personenid', 'taskartenid', 'spaltenid'],
        personen: ['vorname', 'nachname', 'email', 'permission'], taskarten: ['taskart', 'taskartenicon'],
    };
    const singular = { boards: 'board', spalten: 'spalte', tasks: 'task', personen: 'person', taskarten: 'taskart' };
    const fail = error => ({ successfulValidation: false, error });
    const publicPerson = ({ passwort, ...person }) => person;
    const bySort = (a, b) => Number(a.sortid) - Number(b.sortid) || Number(a.id) - Number(b.id);

    function seedState() {
        const today = new Date().toISOString().slice(0, 10);
        const tomorrow = new Date(Date.now() + 86400000).toISOString().slice(0, 10) + 'T12:00';
        const passwort = { salt: 'minmax-demo', hash: '1829d2d17510dca1e7dacdea4b96ab1292fb6840eaf70d8aef8620289781d1bb' };
        return {
            version: 2, nextIds: { boards: 3, spalten: 6, tasks: 7, personen: 4, taskarten: 4 },
            boards: [{ id: '1', board: 'Website-Relaunch' }, { id: '2', board: 'Semesterplanung' }],
            spalten: [
                { id: '1', boardsid: '1', sortid: '0', spalte: 'Offen', spaltenbeschreibung: 'Ideen und nächste Schritte' },
                { id: '2', boardsid: '1', sortid: '1', spalte: 'In Arbeit', spaltenbeschreibung: 'Daran arbeiten wir gerade' },
                { id: '3', boardsid: '1', sortid: '2', spalte: 'Erledigt', spaltenbeschreibung: 'Geschafft!' },
                { id: '4', boardsid: '2', sortid: '0', spalte: 'Geplant', spaltenbeschreibung: 'Für das nächste Semester' },
                { id: '5', boardsid: '2', sortid: '1', spalte: 'Erledigt', spaltenbeschreibung: '' },
            ],
            personen: [
                { id: '1', vorname: 'Alex', nachname: 'Winter', email: 'admin@example.com', permission: '2', passwort },
                { id: '2', vorname: 'Sam', nachname: 'Keller', email: 'user@example.com', permission: '1', passwort },
                { id: '3', vorname: 'Mia', nachname: 'Sommer', email: 'mia@example.com', permission: '1', passwort },
            ],
            taskarten: [
                { id: '1', taskart: 'Aufgabe', taskartenicon: 'fa-solid fa-list-check' },
                { id: '2', taskart: 'Idee', taskartenicon: 'fa-solid fa-lightbulb' },
                { id: '3', taskart: 'Fehler', taskartenicon: 'fa-solid fa-bug' },
            ],
            tasks: [
                ['1', '1', '1', '2', 'Neue Startseite skizzieren', 'Welche Inhalte sollen zuerst sichtbar sein? Zwei Entwürfe vergleichen.', tomorrow],
                ['2', '1', '3', '1', 'Texte für die Projektseiten', 'Ziel, Umsetzung und Ergebnis für jedes Projekt beschreiben.', ''],
                ['3', '2', '2', '3', 'Mobile Navigation testen', 'Menü auf kleinen Bildschirmen und Tastaturbedienung prüfen.', ''],
                ['4', '2', '1', '1', 'Kanban-Demo ausprobieren', 'Diese Task in eine andere Spalte ziehen. Zum Bearbeiten auf den Titel klicken.', ''],
                ['5', '3', '3', '1', 'Projektstruktur festlegen', 'Boards, Spalten und Taskarten sind eingerichtet.', ''],
                ['6', '4', '2', '1', 'Lerngruppe organisieren', 'Termine sammeln und einen Lernplan erstellen.', ''],
            ].map(([id, spaltenid, personenid, taskartenid, task, notizen, erinnerungsdatum], index) => ({ id, spaltenid, personenid, taskartenid, task, notizen, erinnerungsdatum, erinnerung: erinnerungsdatum ? '1' : '0', sortid: String(index), erstelldatum: today, erledigt: '0', geloescht: '0' })),
        };
    }

    function validateState(state) {
        if (state?.version !== 2 || !state.nextIds) throw new Error('Ungültiges Datenformat.');
        for (const table of tables) {
            if (!Array.isArray(state[table])) throw new Error('Unvollständige Daten.');
            const ids = new Set();
            for (const row of state[table]) {
                if (!row || !/^\d+$/.test(row.id) || ids.has(row.id)) throw new Error('Ungültige ID.');
                ids.add(row.id);
                for (const field of fields[table]) if (typeof row[field] !== 'string') throw new Error('Ungültiges Datenfeld.');
                if (table === 'personen' && (typeof row.passwort?.hash !== 'string' || typeof row.passwort?.salt !== 'string')) throw new Error('Ungültiger Account.');
            }
            if (!Number.isSafeInteger(state.nextIds[table]) || state.nextIds[table] <= Math.max(0, ...state[table].map(row => Number(row.id)))) throw new Error('Ungültiger ID-Zähler.');
        }
        const exists = (table, id) => state[table].some(row => row.id === id);
        for (const column of state.spalten) if (!exists('boards', column.boardsid) || !/^-?\d+$/.test(column.sortid)) throw new Error('Ungültige Spalte.');
        for (const task of state.tasks) {
            if (!exists('spalten', task.spaltenid) || !exists('personen', task.personenid) || !exists('taskarten', task.taskartenid)
                || !/^-?\d+$/.test(task.sortid) || !Number.isFinite(Date.parse(task.erstelldatum))
                || !['0', '1'].includes(task.erinnerung) || (task.erinnerung === '1' && !Number.isFinite(Date.parse(task.erinnerungsdatum)))) throw new Error('Ungültige Task.');
        }
        return state;
    }

    async function hashPassword(password, salt) {
        const encoder = new TextEncoder();
        const key = await crypto.subtle.importKey('raw', encoder.encode(password), 'PBKDF2', false, ['deriveBits']);
        const bytes = await crypto.subtle.deriveBits({ name: 'PBKDF2', salt: encoder.encode(salt), iterations: 100000, hash: 'SHA-256' }, key, 256);
        return Array.from(new Uint8Array(bytes), byte => byte.toString(16).padStart(2, '0')).join('');
    }

    function createBackend({ storage, sessionStorage, rules, onWarning = () => {} }) {
        let state = seedState();
        let saved = null;
        let persistenceFailed = false;
        let session = null;
        try { session = sessionStorage.getItem(SESSION_KEY); } catch { onWarning('Die Anmeldung kann in diesem Browser nicht gespeichert werden.'); }
        function refresh() {
            if (persistenceFailed) return;
            try {
                const value = storage.getItem(STORAGE_KEY);
                if (value && value !== saved) { state = validateState(JSON.parse(value)); saved = value; }
            } catch { onWarning('Gespeicherte Daten sind nicht lesbar. Die Demo verwendet die zuletzt verfügbaren Daten.'); }
        }
        refresh();
        function persist(next) {
            validateState(next);
            state = next;
            try { saved = JSON.stringify(state); storage.setItem(STORAGE_KEY, saved); }
            catch { persistenceFailed = true; onWarning('Änderungen gelten nur für diese Seite. Der Browser konnte sie nicht speichern.'); }
        }
        function setSession(value) {
            session = value;
            try { value === null ? sessionStorage.removeItem(SESSION_KEY) : sessionStorage.setItem(SESSION_KEY, value); }
            catch { onWarning('Die Anmeldung kann in diesem Browser nicht gespeichert werden.'); }
        }
        function currentUser() { return state.personen.find(person => person.id === session) ?? null; }
        function permission() { return currentUser()?.permission ?? (session === 'guest' ? '0' : null); }
        function loginAsDemo(role) {
            refresh();
            if (!['1', '2'].includes(role)) throw new Error('Ungültige Demo-Rolle.');
            const person = state.personen.find(person => person.permission === role);
            if (!person) throw new Error('Für diese Rolle gibt es kein Konto mehr. Bitte die Demo zurücksetzen.');
            setSession(person.id);
        }
        function snapshot() { return structuredClone({ ...state, personen: state.personen.map(publicPerson) }); }
        function validate(table, data, update = false) {
            const errors = {};
            for (const [field, config] of Object.entries(rules[table] ?? {})) {
                if (update && !(field in data)) continue;
                const value = String(data[field] ?? '');
                for (const rule of config.rules.split('|')) {
                    const [, name, parameter] = rule.match(/^(\w+)(?:\[(.*)\])?$/);
                    const invalid = name === 'required' ? !value.trim() : name === 'min_length' ? [...value].length < Number(parameter)
                        : name === 'max_length' ? [...value].length > Number(parameter) : name === 'integer' ? !/^-?\d+$/.test(value)
                            : name === 'valid_email' ? !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value)
                                : name === 'is_unique' ? state.personen.some(person => person.email.toLowerCase() === value.toLowerCase()) : false;
                    if (invalid) { errors[field] = (config.errors[name] ?? 'Ungültiger Wert.').replace('{field}', config.label).replace('{param}', parameter ?? ''); break; }
                }
            }
            const relations = table === 'tasks' ? { personenid: 'personen', spaltenid: 'spalten', taskartenid: 'taskarten' } : table === 'spalten' ? { boardsid: 'boards' } : {};
            for (const [field, target] of Object.entries(relations)) {
                if (field in data && !state[target].some(row => row.id === data[field])) errors[field] = 'Bitte einen vorhandenen Eintrag auswählen.';
            }
            if ('sortid' in data && !/^-?\d+$/.test(data.sortid)) errors.sortid = 'Bitte eine ganze Zahl eingeben.';
            if (table === 'tasks' && data.erinnerung === '1' && !Number.isFinite(Date.parse(data.erinnerungsdatum))) errors.erinnerungsdatum = 'Bitte ein gültiges Erinnerungsdatum eingeben.';
            if (table === 'personen' && 'permission' in data && !['1', '2'].includes(data.permission)) errors.permission = 'Bitte eine gültige Rolle wählen.';
            if (table === 'taskarten') {
                if (!data.taskart?.trim() || data.taskart.length > 50) errors.taskart = 'Bitte einen Namen mit 1 bis 50 Zeichen eingeben.';
                if (!/^[a-zA-Z0-9 -]{1,50}$/.test(data.taskartenicon ?? '')) errors.taskartenicon = 'Bitte gültige Icon-Klassen eingeben, z. B. fa-solid fa-star.';
            }
            return errors;
        }
        function tasksWithNames() {
            return state.tasks.slice().sort(bySort).map(task => {
                const person = state.personen.find(row => row.id === task.personenid);
                const type = state.taskarten.find(row => row.id === task.taskartenid);
                const column = state.spalten.find(row => row.id === task.spaltenid);
                const board = state.boards.find(row => row.id === column.boardsid);
                return { ...task, vorname: person.vorname, nachname: person.nachname, person: person.vorname + ' ' + person.nachname, taskart: type.taskart, taskartenicon: type.taskartenicon, spalte: column.spalte, board: board.board, boardsid: board.id };
            });
        }
        async function request(method, route, input = {}) {
            refresh();
            route = route.replace(/^\/+|\/+$/g, '');
            method = method.toUpperCase();
            const data = typeof input === 'string' ? Object.fromEntries(new URLSearchParams(input)) : input;
            if (route === 'benutzer/anmelden' && method === 'POST') {
                const person = state.personen.find(row => row.email.toLowerCase() === String(data.email ?? '').toLowerCase());
                if (!person) return fail({ email: 'Benutzer nicht gefunden' });
                if (await hashPassword(String(data.passwort ?? ''), person.passwort.salt) !== person.passwort.hash) return fail({ passwort: 'Das Passwort ist falsch' });
                setSession(person.id);
                return { successfulValidation: true, tableName: 'loginPersonen', redirect: 'profil/' };
            }
            if (route === 'benutzer/erstellen' && method === 'POST') {
                const errors = validate('personen', data);
                if (Object.keys(errors).length) return fail(errors);
                const salt = crypto.randomUUID();
                const passwort = { salt, hash: await hashPassword(data.passwort, salt) };
                const next = structuredClone(state);
                const id = String(next.nextIds.personen++);
                next.personen.push({ id, vorname: data.vorname, nachname: data.nachname, email: data.email, permission: '1', passwort });
                persist(next); setSession(id);
                return { successfulValidation: true, tableName: 'loginPersonen', redirect: 'willkommen/' };
            }
            if (permission() === null) return fail({ authorization: 'Bitte zuerst anmelden oder als Gast fortfahren.' });
            const parts = route.split('/');
            if ((parts[0] === 'admin' || ['personen', 'taskarten'].includes(parts[0])) && permission() !== '2') return fail({ authorization: 'Sie haben nicht die Berechtigung für diese Aktion.' });
            if (parts[0] === 'admin') parts.shift();
            const [table, action, id] = parts;
            if (!tables.includes(table)) throw new Error('Unbekannte Demo-Route: ' + route);
            if (action === 'raw' && (method === 'GET' || (table === 'tasks' && method === 'POST' && id))) {
                if (table === 'tasks') return id ? { tasks: tasksWithNames().filter(task => task.boardsid === id), boardSpalten: state.spalten.filter(column => column.boardsid === id).sort(bySort), spalten: state.spalten, boards: state.boards } : { tasks: tasksWithNames() };
                if (table === 'spalten') return { spalten: state.spalten.map(column => ({ ...column, board: state.boards.find(board => board.id === column.boardsid).board })).sort((a, b) => b.board.localeCompare(a.board) || bySort(a, b)) };
                return { [table]: table === 'personen' ? state.personen.map(publicPerson) : structuredClone(state[table]) };
            }
            if (method !== 'POST') throw new Error('Ungültige Methode für ' + route);
            if (table === 'tasks' && action === 'bearbeiten' && id === 'sortids') {
                const entries = typeof input === 'string' ? JSON.parse(input) : input;
                if (!Array.isArray(entries) || entries.some(entry => !state.tasks.some(task => task.id === String(entry.id)) || !Number.isSafeInteger(Number(entry.sortid)))) return fail({ sortid: 'Ungültige Task-Reihenfolge.' });
                const next = structuredClone(state);
                entries.forEach(entry => { next.tasks.find(task => task.id === String(entry.id)).sortid = String(entry.sortid); });
                persist(next); return { successfulValidation: true };
            }
            if (table === 'tasks' && action === 'bearbeiten' && id === 'spalte') {
                const task = state.tasks.find(task => task.id === parts[3]);
                if (!task || !state.spalten.some(column => column.id === parts[4])) return fail({ spaltenid: 'Task oder Spalte nicht gefunden.' });
                const next = structuredClone(state);
                next.tasks.find(row => row.id === task.id).spaltenid = parts[4];
                persist(next); return { successfulValidation: true, taskid: task.id, spaltenid: parts[4] };
            }
            const row = state[table].find(item => item.id === id);
            if (action === singular[table]) {
                if (!row) return fail({ record: 'Eintrag nicht gefunden.' });
                const result = { [singular[table]]: structuredClone(table === 'personen' ? publicPerson(row) : row) };
                if (table === 'tasks') result.taskarten = structuredClone(state.taskarten.find(type => type.id === row.taskartenid));
                return result;
            }
            if (action === 'loeschen') {
                if (!row) return fail({ deletion: 'Eintrag nicht gefunden.' });
                if (table === 'boards' && state.spalten.some(column => column.boardsid === id)) return fail({ deletion: 'Sie können dieses Board nicht löschen, da es noch Spalten enthält' });
                if (table === 'spalten' && state.tasks.some(task => task.spaltenid === id)) return fail({ deletion: 'Spalte konnte nicht gelöscht werden, da sie noch Tasks enthält' });
                const next = structuredClone(state);
                next[table] = next[table].filter(item => item.id !== id);
                // Match the ON DELETE CASCADE constraints in databaseStructure.sql.
                if (table === 'personen') next.tasks = next.tasks.filter(task => task.personenid !== id);
                if (table === 'taskarten') next.tasks = next.tasks.filter(task => task.taskartenid !== id);
                persist(next);
                if (table === 'personen' && session === id) setSession(null);
                return { successfulValidation: true, tableName: table, action: 'gelöscht', taskid: id };
            }
            if (!['erstellen', 'bearbeiten'].includes(action) || (table === 'personen' && action === 'erstellen')) throw new Error('Unbekannte Demo-Route: ' + route);
            const update = action === 'bearbeiten';
            if (update && !row) return fail({ record: 'Eintrag nicht gefunden.' });
            const values = Object.fromEntries(fields[table].filter(field => field in data).map(field => [field, String(data[field])]));
            if (table === 'tasks') values.erinnerung = data.erinnerung === '1' ? '1' : '0';
            const errors = validate(table, values, update);
            if (Object.keys(errors).length) return fail(errors);
            const next = structuredClone(state);
            const recordId = update ? id : String(next.nextIds[table]++);
            const defaults = table === 'tasks' ? { sortid: String(Math.max(-1, ...state.tasks.filter(task => task.spaltenid === values.spaltenid).map(task => Number(task.sortid))) + 1), erstelldatum: new Date().toISOString().slice(0, 10), erinnerung: '0', erinnerungsdatum: '', notizen: '', erledigt: '0', geloescht: '0' } : table === 'spalten' ? { spaltenbeschreibung: '' } : {};
            const record = { ...defaults, ...row, ...values, id: recordId };
            if (update) next[table][next[table].findIndex(item => item.id === id)] = record;
            else next[table].push(record);
            persist(next);
            return { successfulValidation: true, tableName: table, action: update ? 'bearbeitet' : 'erstellt', taskid: recordId, taskartenid: recordId, spaletenid: record.spaltenid };
        }
        return { request, snapshot, currentUser, permission, loginAsDemo, guest: () => setSession('guest'), logout: () => setSession(null), reset: () => { persist(seedState()); setSession(null); } };
    }
    const api = { STORAGE_KEY, SESSION_KEY, seedState, validateState, createBackend };
    if (typeof module !== 'undefined' && module.exports) module.exports = api;
    else window.MinMaxDemo = api;
})();
