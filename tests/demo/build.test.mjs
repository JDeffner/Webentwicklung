import test from 'node:test';
import assert from 'node:assert/strict';
import { execFileSync } from 'node:child_process';
import { readFile, readdir, stat } from 'node:fs/promises';
import path from 'node:path';

test('static build renders all application routes and ships the original assets', async () => {
    execFileSync(process.execPath, ['scripts/build-demo.mjs']);
    const output = path.resolve('_site');
    const routes = ['', 'anmelden', 'benutzer/erstellen', 'benutzer/gast', 'profil', 'willkommen', 'tasks', 'boards', 'spalten', 'admin/personen', 'admin/taskarten', 'admin/tasks', 'denied'];
    for (const route of routes) {
        const directory = path.join(output, route);
        const html = await readFile(path.join(directory, 'index.html'), 'utf8');
        assert.match(html, /window\.MINMAX_DEMO/);
        assert.ok(!html.includes('<?php'), route);
        for (const match of html.matchAll(/(?:src|href)="([^"#]+)"/g)) {
            const target = match[1];
            if (/^https?:/.test(target)) continue;
            const resolved = path.resolve(directory, target.split('?')[0]);
            assert.ok(resolved.startsWith(output), target);
            assert.ok(await stat(resolved), `${route}: ${target}`);
        }
    }
    for (const directory of ['css', 'js', 'images']) {
        for (const file of await readdir(path.join(output, 'resources', directory))) {
            assert.deepEqual(await readFile(path.join(output, 'resources', directory, file)), await readFile(path.join('public/resources', directory, file)));
        }
    }
    assert.match(await readFile('_site/tasks/index.html', 'utf8'), /id="copyTaskModal"/);
    assert.match(await readFile('_site/index.html', 'utf8'), /id="tasksBoard"/);
    assert.match(await readFile('_site/index.html', 'utf8'), /resources\/demo\/bridge\.js\?v=[a-f0-9]{12}/);
    assert.match(await readFile('_site/spalten/index.html', 'utf8'), /id="copySpalteModal"/);
    assert.match(await readFile('_site/admin/tasks/index.html', 'utf8'), /id="tasksTable"/);
    assert.equal((await readFile('_site/CNAME', 'utf8')).trim(), 'kanban.jdeffner.com');
});
