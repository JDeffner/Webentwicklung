import { mkdir, copyFile, writeFile, rm, lstat } from 'node:fs/promises';
import { execFileSync } from 'node:child_process';
import { fileURLToPath } from 'node:url';
import path from 'node:path';

const root = fileURLToPath(new URL('../', import.meta.url)).replace(/[\\/]$/, '');
const output = path.resolve(root, '_site');
if (path.dirname(output) !== root || path.basename(output) !== '_site') throw new Error('Invalid generated output path.');
const existing = await lstat(output).catch(error => { if (error.code !== 'ENOENT') throw error; });
if (existing?.isSymbolicLink()) throw new Error('_site must not be a symbolic link.');
await rm(output, { recursive: true, force: true });
await mkdir(output, { recursive: true });

// PHP runs only during the build. Only rendered HTML and frontend assets ship.
execFileSync('php', [path.join(root, 'scripts/render-demo.php'), output], { stdio: 'inherit' });
const files = [
    ...['main', 'tasks', 'tasks-admin', 'boards', 'spalten', 'personen', 'taskarten'].map(name => [`public/resources/js/${name}.js`, `resources/js/${name}.js`]),
    ...['main', 'custom'].map(name => [`public/resources/css/${name}.css`, `resources/css/${name}.css`]),
    ...['MinMaxLogo.svg', 'favicon.ico'].map(name => [`public/resources/images/${name}`, `resources/images/${name}`]),
    ...['backend.js', 'overlay.js', 'bridge.js', 'demo.css'].map(name => [`demo/${name}`, `resources/demo/${name}`]),
];
for (const [source, target] of files) {
    await mkdir(path.dirname(path.join(output, target)), { recursive: true });
    await copyFile(path.join(root, source), path.join(output, target));
}
await writeFile(path.join(output, '.nojekyll'), '');
await writeFile(path.join(output, 'CNAME'), 'kanban.jdeffner.com\n');
console.log('Built original application views and scripts with the local demo backend in _site/.');
