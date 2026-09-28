import test from 'node:test';
import assert from 'node:assert/strict';
import { STORAGE_KEY, seedState, validateState, loadState, saveState, upsert, removeItem, moveTask } from '../../demo/store.mjs';

function memoryStorage() {
    const values = new Map();
    return { getItem: key => values.get(key) ?? null, setItem: (key, value) => values.set(key, value) };
}

test('a visitor can create, edit, copy, and delete a task, with changes surviving reload', () => {
    const storage = memoryStorage();
    let state = loadState(storage).state;
    const original = { name: 'Neue Task', columnId: 'c1', personId: 'p1', typeId: 'k1', notes: '<script>plain text</script>', created: '2026-09-28', reminder: '' };
    state = upsert(state, 'tasks', original);
    const id = state.tasks.at(-1).id;
    state = upsert(state, 'tasks', { name: 'Geänderte Task', columnId: 'c2' }, id);
    const edited = state.tasks.find(task => task.id === id);
    state = upsert(state, 'tasks', { ...edited, name: 'Kopie' });
    const copyId = state.tasks.at(-1).id;
    assert.notEqual(copyId, id);
    state = removeItem(state, 'tasks', id);
    saveState(storage, state);
    const reloaded = loadState(storage).state;
    assert.equal(reloaded.tasks.some(task => task.id === id), false);
    assert.deepEqual(reloaded.tasks.find(task => task.id === copyId), { ...original, id: copyId, name: 'Kopie', columnId: 'c2' });
});

test('dragging changes a task column and order without losing any tasks', () => {
    const initial = seedState();
    let state = moveTask(initial, 't1', 'c2', 't4');
    assert.deepEqual(state.tasks.filter(task => task.columnId === 'c2').map(task => task.id), ['t3', 't1', 't4']);
    state = moveTask(state, 't4', 'c2', 't3');
    assert.deepEqual(state.tasks.filter(task => task.columnId === 'c2').map(task => task.id), ['t4', 't3', 't1']);
    state = moveTask(state, 't4', 'c2');
    assert.deepEqual(state.tasks.filter(task => task.columnId === 'c2').map(task => task.id), ['t3', 't1', 't4']);
    assert.equal(state.tasks.length, initial.tasks.length);
    assert.equal(initial.tasks.find(task => task.id === 't1').columnId, 'c1');
});

test('deleting a board removes only its columns and tasks; an empty workspace remains usable', () => {
    let state = removeItem(seedState(), 'boards', 'b1');
    assert.deepEqual(state.boards.map(board => board.id), ['b2']);
    assert.deepEqual(state.tasks.map(task => task.id), ['t6']);
    state = removeItem(state, 'boards', 'b2');
    assert.equal(state.columns.length, 0);
    assert.equal(state.tasks.length, 0);
    state = upsert(state, 'boards', { name: 'Neustart' });
    state = upsert(state, 'columns', { name: 'Offen', boardId: state.boards[0].id, description: '' });
    assert.equal(state.columns[0].name, 'Offen');
});

test('moving a column to another board retains its tasks; deleting it removes them', () => {
    let state = upsert(seedState(), 'columns', { boardId: 'b2' }, 'c1');
    assert.equal(state.tasks.filter(task => task.columnId === 'c1').length, 2);
    state = removeItem(state, 'columns', 'c1');
    assert.equal(state.tasks.some(task => task.columnId === 'c1'), false);
    assert.equal(state.tasks.length, 4);
});

test('deleting a person or task type clears assignments and preserves tasks', () => {
    let state = removeItem(seedState(), 'people', 'p1');
    state = removeItem(state, 'types', 'k1');
    assert.equal(state.tasks.length, 6);
    assert.equal(state.tasks.find(task => task.id === 't4').personId, '');
    assert.equal(state.tasks.find(task => task.id === 't4').typeId, '');
    assert.equal(state.tasks.find(task => task.id === 't3').personId, 'p2');
});

test('invalid changes are rejected without mutating saved state', () => {
    const state = seedState();
    const before = structuredClone(state);
    assert.throws(() => upsert(state, 'tasks', { columnId: 'missing' }, 't1'));
    assert.throws(() => upsert(state, 'boards', { name: '  ' }, 'b1'));
    assert.throws(() => upsert(state, 'columns', { description: 'x'.repeat(251) }, 'c1'));
    assert.throws(() => moveTask(state, 't1', 'missing'));
    assert.throws(() => upsert(state, 'tasks', { reminder: 'not a date' }, 't1'));
    assert.deepEqual(state, before);
});

test('corrupt or unavailable storage gives a usable demo and a visible-warning message', () => {
    for (const value of ['not JSON', '{"version":1}', JSON.stringify({ ...seedState(), tasks: [{ name: 'invalid' }] })]) {
        const storage = memoryStorage();
        storage.setItem(STORAGE_KEY, value);
        const loaded = loadState(storage);
        assert.ok(loaded.warning);
        assert.ok(validateState(loaded.state));
        assert.equal(storage.getItem(STORAGE_KEY), value);
    }
    assert.ok(loadState(undefined).warning);
    assert.throws(() => saveState({ setItem() { throw new Error('Quota exceeded'); } }, seedState()));
});

test('reset restores sample data without changing unrelated browser storage', () => {
    const storage = memoryStorage();
    storage.setItem('another-app', 'keep');
    saveState(storage, removeItem(seedState(), 'boards', 'b1'));
    saveState(storage, seedState());
    assert.equal(loadState(storage).state.boards.length, 2);
    assert.equal(loadState(storage).state.tasks.length, 6);
    assert.equal(storage.getItem('another-app'), 'keep');
});
