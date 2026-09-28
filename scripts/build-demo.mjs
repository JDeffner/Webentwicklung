import { mkdir, copyFile, writeFile, readdir } from 'node:fs/promises';
import { fileURLToPath } from 'node:url';
import path from 'node:path';

const root = fileURLToPath(new URL('../', import.meta.url));
const output = path.join(root, '_site');
await mkdir(path.join(output, 'assets'), { recursive: true });

// Publish an explicit allowlist. Never copy the PHP app, SQL, or environment files.
const files = [
    ['demo/index.html', 'index.html'], ['demo/app.mjs', 'app.mjs'],
    ['demo/store.mjs', 'store.mjs'], ['demo/demo.css', 'demo.css'],
    ['public/resources/css/main.css', 'assets/main.css'],
    ['public/resources/images/MinMaxLogo.svg', 'assets/MinMaxLogo.svg'],
    ['public/resources/images/favicon.ico', 'assets/favicon.ico'],
];
const allowed = new Set([...files.map(([, target]) => target), '.nojekyll', 'CNAME']);
async function checkOutput(directory, prefix = '') {
    for (const entry of await readdir(directory, { withFileTypes: true })) {
        const relative = prefix + entry.name;
        if (entry.isDirectory() && relative === 'assets') await checkOutput(path.join(directory, entry.name), relative + '/');
        else if (!entry.isFile() || !allowed.has(relative)) throw new Error(`Unexpected file in _site: ${relative}. Use a clean output directory.`);
    }
}
await checkOutput(output);
for (const [source, target] of files) await copyFile(path.join(root, source), path.join(output, target));
await writeFile(path.join(output, '.nojekyll'), '');
await writeFile(path.join(output, 'CNAME'), 'kanban.jdeffner.com\n');
console.log('Built the static demo in _site/ (9 files, no dependencies or backend).');
