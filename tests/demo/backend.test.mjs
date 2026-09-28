import test from 'node:test';
import assert from 'node:assert/strict';
import { createRequire } from 'node:module';
import { execFileSync } from 'node:child_process';

const { createBackend, STORAGE_KEY, SESSION_KEY } = createRequire(import.meta.url)('../../demo/backend.js');
const rules = JSON.parse(execFileSync('php', ['scripts/render-demo.php', '--rules'], { encoding: 'utf8' }));
const memory = () => {
    const data = new Map();
    return { getItem: key => data.get(key) ?? null, setItem: (key, value) => data.set(key, String(value)), removeItem: key => data.delete(key) };
};
function setup(options = {}) {
    const storage = memory(), sessionStorage = memory(), warnings = [];
    const settings = { storage, sessionStorage, rules, onWarning: message => warnings.push(message), ...options };
    const backend = createBackend(settings);
    return { backend, storage, sessionStorage, warnings, reload: () => createBackend(settings) };
}
const login = backend => backend.request('POST', 'benutzer/anmelden', { email: 'admin@example.com', passwort: 'demo' });
const task = { task: 'Testaufgabe', taskartenid: '1', spaltenid: '1', personenid: '2', notizen: 'Eine Notiz' };

test('demo role switches persist the session and preserve board changes', async () => {
    const { backend, reload } = setup();
    backend.loginAsDemo('1');
    assert.equal(reload().permission(), '1');
    await backend.request('POST', 'boards/bearbeiten/1', { board: 'Meine Änderungen' });
    backend.loginAsDemo('2');
    assert.equal(reload().permission(), '2');
    assert.equal((await backend.request('GET', 'admin/personen/raw')).personen.length, 3);
    backend.guest();
    assert.equal(reload().permission(), '0');
    assert.ok((await backend.request('GET', 'admin/personen/raw')).error.authorization);
    assert.equal((await reload().request('POST', 'boards/board/1')).board.board, 'Meine Änderungen');
    backend.loginAsDemo('2');
    await backend.request('POST', 'personen/loeschen/1');
    assert.throws(() => backend.loginAsDemo('2'), /zurücksetzen/);
    assert.equal(backend.permission(), null);
    backend.reset();
    backend.loginAsDemo('2');
    assert.equal(reload().permission(), '2');
    assert.throws(() => backend.loginAsDemo('unknown'), /Ungültige/);
});

test('guest, user and admin access follows the original application roles', async () => {
    const { backend } = setup();
    assert.equal((await backend.request('GET', 'boards/raw')).successfulValidation, false);
    backend.guest();
    assert.equal((await backend.request('GET', 'boards/raw')).boards.length, 2);
    assert.equal((await backend.request('GET', 'admin/personen/raw')).successfulValidation, false);
    assert.equal((await backend.request('POST', 'taskarten/erstellen', { taskart: 'Test', taskartenicon: 'fa-star' })).successfulValidation, false);
    assert.equal((await backend.request('POST', 'benutzer/anmelden', { email: 'user@example.com', passwort: 'demo' })).successfulValidation, true);
    assert.equal(backend.permission(), '1');
    assert.equal((await backend.request('GET', 'admin/taskarten/raw')).successfulValidation, false);
    await login(backend);
    assert.equal(backend.permission(), '2');
    const people = (await backend.request('GET', 'admin/personen/raw')).personen;
    assert.equal(people.length, 3);
    assert.ok(people.every(person => !('passwort' in person)));
});

test('registration validates PHP rules, saves a password hash and survives navigation', async () => {
    const context = setup(), { backend } = context;
    const registration = { vorname: 'Robin', nachname: 'Test', email: 'robin@example.com', passwort: 'local-demo' };
    const invalid = await backend.request('POST', 'benutzer/erstellen', { ...registration, vorname: 'R', email: 'invalid', passwort: 'x' });
    assert.deepEqual(Object.keys(invalid.error).sort(), ['email', 'passwort', 'vorname']);
    assert.equal((await backend.request('POST', 'benutzer/erstellen', registration)).redirect, 'willkommen/');
    assert.equal(context.reload().currentUser().email, registration.email);
    assert.ok(!context.storage.getItem(STORAGE_KEY).includes(registration.passwort));
    assert.match((await backend.request('POST', 'benutzer/erstellen', registration)).error.email, /vergeben/);
    backend.logout();
    assert.equal(context.sessionStorage.getItem(SESSION_KEY), null);
    assert.ok((await backend.request('POST', 'benutzer/anmelden', { email: registration.email, passwort: 'wrong' })).error.passwort);
    assert.equal((await backend.request('POST', 'benutzer/anmelden', registration)).redirect, 'profil/');
});

test('boards, columns and tasks use the existing CRUD response contracts and persist', async () => {
    const { backend, reload } = setup();
    backend.guest();
    const board = await backend.request('POST', 'boards/erstellen', 'board=Testboard');
    assert.equal(board.tableName, 'boards');
    const column = await backend.request('POST', 'spalten/erstellen', { boardsid: board.taskid, sortid: '0', spalte: 'Testspalte', spaltenbeschreibung: 'Beschreibung' });
    assert.equal(column.successfulValidation, true);
    const created = await backend.request('POST', 'tasks/erstellen', { ...task, spaltenid: column.taskid, erinnerung: '1', erinnerungsdatum: '2027-01-02T12:00' });
    assert.equal(created.action, 'erstellt');
    const detail = await backend.request('POST', `tasks/task/${created.taskid}`);
    assert.equal(detail.taskarten.taskart, 'Aufgabe');
    assert.equal(detail.task.erinnerung, '1');
    const boardData = await reload().request('POST', `tasks/raw/${board.taskid}`);
    assert.equal(boardData.tasks[0].task, task.task);
    assert.equal(boardData.tasks[0].board, 'Testboard');
    assert.equal(boardData.tasks[0].person, 'Sam Keller');
    assert.equal(boardData.boardSpalten[0].id, column.taskid);
    assert.equal(boardData.spalten.length, 6);
    assert.equal((await backend.request('POST', `tasks/bearbeiten/${created.taskid}`, { ...task, task: 'Geänderte Aufgabe' })).successfulValidation, true);
    const changed = (await backend.request('POST', `tasks/task/${created.taskid}`)).task;
    assert.equal(changed.erinnerung, '0');
    assert.equal(changed.spaltenid, '1');
    assert.equal((await backend.request('POST', `boards/bearbeiten/${board.taskid}`, { board: 'Umbenannt' })).action, 'bearbeitet');
    assert.equal((await backend.request('POST', `spalten/bearbeiten/${column.taskid}`, { spalte: 'Umbenannt', sortid: '4' })).successfulValidation, true);
    assert.equal((await backend.request('POST', `tasks/loeschen/${created.taskid}`)).successfulValidation, true);
    assert.equal((await backend.request('POST', `spalten/loeschen/${column.taskid}`)).successfulValidation, true);
    assert.equal((await backend.request('POST', `boards/loeschen/${board.taskid}`)).successfulValidation, true);
});

test('validation rejects invalid fields and relations without changing saved data', async () => {
    const { backend } = setup();
    backend.guest();
    const before = backend.snapshot();
    for (const [route, data, field] of [
        ['boards/erstellen', { board: 'a' }, 'board'],
        ['boards/erstellen', { board: 'x'.repeat(41) }, 'board'],
        ['spalten/erstellen', { spalte: 'Valid', sortid: '0', boardsid: '999' }, 'boardsid'],
        ['spalten/erstellen', { spalte: 'Valid', sortid: '1.5', boardsid: '1' }, 'sortid'],
        ['tasks/erstellen', { ...task, notizen: 'x'.repeat(256) }, 'notizen'],
        ['tasks/erstellen', { ...task, personenid: '999' }, 'personenid'],
        ['tasks/erstellen', { ...task, erinnerung: '1', erinnerungsdatum: '' }, 'erinnerungsdatum'],
    ]) assert.ok((await backend.request('POST', route, data)).error[field], field);
    assert.deepEqual(backend.snapshot(), before);
});

test('dragging between boards and reordering is retained after reload', async () => {
    const { backend, reload } = setup();
    backend.guest();
    await backend.request('POST', 'tasks/bearbeiten/spalte/1/4');
    await backend.request('POST', 'tasks/bearbeiten/sortids', JSON.stringify([{ id: '1', sortid: 0 }, { id: '6', sortid: 1 }]));
    const board = await reload().request('POST', 'tasks/raw/2');
    assert.deepEqual(board.tasks.map(task => task.id), ['1', '6']);
    assert.equal((await backend.request('POST', 'tasks/raw/1')).tasks.some(task => task.id === '1'), false);
    assert.equal((await backend.request('POST', 'tasks/bearbeiten/spalte/1/999')).successfulValidation, false);
    assert.equal((await backend.request('POST', 'tasks/bearbeiten/sortids', '[{"id":"999","sortid":0}]')).successfulValidation, false);
});

test('deletions match SQL foreign keys: restrict boards/columns, cascade people/types', async () => {
    const { backend } = setup();
    await login(backend);
    assert.ok((await backend.request('POST', 'boards/loeschen/1')).error.deletion);
    assert.ok((await backend.request('POST', 'spalten/loeschen/1')).error.deletion);
    await backend.request('POST', 'personen/bearbeiten/3', { vorname: 'Mia', nachname: 'Sommer', permission: '2' });
    assert.equal((await backend.request('POST', 'personen/person/3')).person.permission, '2');
    await backend.request('POST', 'personen/loeschen/3');
    assert.ok(backend.snapshot().tasks.every(task => task.personenid !== '3'));
    await backend.request('POST', 'taskarten/bearbeiten/3', { taskart: 'Bug', taskartenicon: 'fa-solid fa-bug' });
    assert.equal((await backend.request('POST', 'taskarten/taskart/3')).taskart.taskart, 'Bug');
    await backend.request('POST', 'taskarten/loeschen/3');
    assert.ok(backend.snapshot().tasks.every(task => task.taskartenid !== '3'));
    const created = await backend.request('POST', 'taskarten/erstellen', { taskart: 'Termin', taskartenicon: 'fa-solid fa-calendar' });
    assert.equal(created.taskartenid, '4');
});

test('copy uses detail then create, and text is preserved without interpretation', async () => {
    const { backend } = setup();
    backend.guest();
    const text = "Sam's <board> & notes";
    await backend.request('POST', 'boards/bearbeiten/1', { board: text });
    const detail = (await backend.request('POST', 'boards/board/1')).board;
    const copy = await backend.request('POST', 'boards/erstellen', detail);
    assert.notEqual(copy.taskid, detail.id);
    assert.equal((await backend.request('POST', `boards/board/${copy.taskid}`)).board.board, text);
    const column = (await backend.request('POST', 'spalten/spalte/1')).spalte;
    assert.equal((await backend.request('POST', 'spalten/erstellen', column)).successfulValidation, true);
    const original = (await backend.request('POST', 'tasks/task/1')).task;
    const copied = await backend.request('POST', 'tasks/erstellen', original);
    assert.notEqual(copied.taskid, original.id);
    assert.equal((await backend.request('POST', `tasks/task/${copied.taskid}`)).task.notizen, original.notizen);
});

test('reset clears session; corrupt or unavailable storage produces a visible warning', async () => {
    const { backend, storage, reload } = setup();
    backend.guest();
    await backend.request('POST', 'boards/erstellen', { board: 'Temporary' });
    backend.reset();
    assert.equal(reload().permission(), null);
    assert.equal(reload().snapshot().boards.length, 2);
    storage.setItem(STORAGE_KEY, '{invalid');
    const warnings = [];
    const recovered = createBackend({ storage, sessionStorage: memory(), rules, onWarning: message => warnings.push(message) });
    assert.equal(recovered.snapshot().tasks.length, 6);
    assert.equal(warnings.length, 1);
    backend.reset();
    const oldData = storage.getItem(STORAGE_KEY);
    const unavailable = setup({ storage: { getItem: () => oldData, setItem: () => { throw new Error('quota'); } } });
    unavailable.backend.guest();
    assert.equal((await unavailable.backend.request('POST', 'boards/erstellen', { board: 'In memory' })).successfulValidation, true);
    assert.equal(unavailable.backend.snapshot().boards.length, 3);
    assert.equal((await unavailable.backend.request('GET', 'boards/raw')).boards.length, 3);
    assert.ok(unavailable.warnings.length);
});
