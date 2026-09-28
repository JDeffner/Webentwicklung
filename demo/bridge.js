(function () {
    'use strict';
    const { route, navbars, rules } = window.MINMAX_DEMO;
    const root = new URL(BASE_URL, location.href);
    const warnings = [];
    let storage, sessionStorage;
    try { storage = window.localStorage; sessionStorage = window.sessionStorage; } catch { /* Report through the backend warning callback. */ }
    const backend = MinMaxDemo.createBackend({ storage, sessionStorage, rules, onWarning: message => {
        warnings.push(message);
        const notice = document.getElementById('demo-warning');
        if (notice) { notice.textContent = message; notice.hidden = false; }
    } });
    const go = path => location.replace(new URL(path, root));
    if (route === '' || route === 'anmelden') backend.logout();
    if (route === 'benutzer/gast') { backend.guest(); go('tasks/'); return; }
    const publicPage = ['', 'anmelden', 'benutzer/erstellen'].includes(route);
    if (!publicPage && backend.permission() === null) { go('anmelden/'); return; }
    if (route.startsWith('admin/') && backend.permission() !== '2') { go('denied/'); return; }

    const banner = document.createElement('aside');
    banner.className = 'demo-notice mx-4 mb-3';
    banner.setAttribute('aria-label', 'Lokale Demo');
    banner.innerHTML = '<div><strong>Lokale Demo</strong> · Alle Änderungen und Demo-Accounts bleiben in diesem Browser. Bitte keine echten Passwörter verwenden.<div id="demo-warning" role="alert" hidden></div></div><button type="button" class="btn btn-sm btn-secondary" id="demo-reset">Demo zurücksetzen</button>';
    document.querySelector('main').before(banner);
    if (warnings.length) { document.getElementById('demo-warning').textContent = warnings.at(-1); document.getElementById('demo-warning').hidden = false; }
    document.getElementById('demo-reset').addEventListener('click', () => {
        if (window.confirm('Alle lokalen Demo-Daten durch die Beispieldaten ersetzen?')) { backend.reset(); go('anmelden/'); }
    });
    if (route === '' || route === 'anmelden') {
        const help = document.createElement('p');
        help.className = 'small mt-3 mb-0';
        help.textContent = 'Demo-Admin: admin@example.com · Demo-Benutzer: user@example.com · Passwort jeweils: demo';
        document.querySelector('.minMaxForm').after(help);
    }
    function syncNavbar() {
        if (!publicPage) {
            const navbar = document.querySelector('nav.navbar');
            const wrapper = document.createElement('div');
            wrapper.innerHTML = navbars[backend.permission() ?? '0'];
            navbar.replaceWith(wrapper.firstElementChild);
        }
        const user = backend.currentUser();
        document.querySelectorAll('[data-demo-user]').forEach(element => { element.textContent = user?.[element.dataset.demoUser] ?? ''; });
    }
    function fillSelect(select, rows, label, placeholder) {
        const previous = select.value;
        select.replaceChildren(new Option(placeholder, ''), ...rows.map(row => new Option(label(row), row.id)));
        if (rows.some(row => row.id === previous)) select.value = previous;
    }
    function setTaskart(form, type) {
        form.querySelector('[name=taskartenid]').value = type?.id ?? '';
        const span = form.querySelector('#btnTaskart span');
        const icon = document.createElement('i');
        icon.className = type?.taskartenicon ?? '';
        span.replaceChildren(icon, document.createTextNode(' ' + (type?.taskart ?? 'Taskart wählen')));
    }
    function hydrateForms() {
        const data = backend.snapshot();
        document.querySelectorAll('.boardSelect').forEach(select => fillSelect(select, data.boards, board => board.board, 'Board auswählen'));
        document.querySelectorAll('.spaltenSelect').forEach(select => fillSelect(select, data.spalten, column => data.boards.find(board => board.id === column.boardsid).board + ' - ' + column.spalte, 'Board und Spalte auswählen'));
        document.querySelectorAll('select[name=personenid]').forEach(select => fillSelect(select, data.personen, person => person.vorname + ' ' + person.nachname, 'Person auswählen'));
        document.querySelectorAll('.minMaxForm').forEach(form => {
            const button = form.querySelector('#btnTaskart');
            if (!button) return;
            const menu = button.nextElementSibling;
            menu.replaceChildren(...data.taskarten.map(type => {
                const li = document.createElement('li');
                const link = document.createElement('a');
                link.className = 'dropdown-item';
                link.href = '#';
                const icon = document.createElement('i');
                icon.className = type.taskartenicon;
                link.append(icon, document.createTextNode(' ' + type.taskart));
                link.addEventListener('click', event => { event.preventDefault(); setTaskart(form, type); });
                li.append(link); return li;
            }));
            setTaskart(form, data.taskarten.find(type => type.id === form.querySelector('[name=taskartenid]').value) ?? data.taskarten[0]);
        });
    }
    function selectBoard(id) {
        const data = backend.snapshot();
        const board = data.boards.find(board => board.id === id) ?? data.boards[0];
        const input = document.getElementById('boardidDropdown');
        if (input) {
            input.value = board?.id ?? '0';
            document.querySelector('#boardidDropdownButton span').textContent = board?.board ?? 'Board auswählen';
        }
        return board?.id ?? '0';
    }
    syncNavbar();
    hydrateForms();
    selectBoard('');

    // Original list renderers use HTML strings. Encode raw-list text at this
    // presentation boundary; detail endpoints keep raw values for form .val().
    const escape = value => value.replace(/[&<>"']/g, char => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' })[char]);
    function encodeRows(value) {
        if (typeof value === 'string') return escape(value);
        if (Array.isArray(value)) return value.map(encodeRows);
        if (value && typeof value === 'object') return Object.fromEntries(Object.entries(value).map(([key, child]) => [key, encodeRows(child)]));
        return value;
    }
    let queue = Promise.resolve();
    $.ajaxTransport('+*', options => {
        const url = new URL(options.url, location.href);
        if (url.origin !== root.origin || !url.pathname.startsWith(root.pathname)) return;
        let path = url.pathname.slice(root.pathname.length).replace(/\/$/, '');
        if (!/^(?:admin\/)?(?:tasks|boards|spalten|personen|taskarten|benutzer)\//.test(path)) return;
        let aborted = false;
        return {
            send(_headers, complete) {
                queue = queue.then(async () => {
                    if (aborted) return;
                    if (/^tasks\/raw\//.test(path)) path = 'tasks/raw/' + selectBoard(path.split('/').at(-1));
                    const response = await backend.request(options.type, path, options.data ?? {});
                    if (response.redirect) response.redirect = new URL(response.redirect, root).href;
                    if (response.successfulValidation && options.type.toUpperCase() === 'POST') { hydrateForms(); syncNavbar(); }
                    if (response.error?.authorization || response.error?.record) {
                        const message = document.getElementById('demo-warning');
                        message.textContent = response.error.authorization ?? response.error.record; message.hidden = false;
                    }
                    const rendered = /(?:^|\/)raw(?:\/|$)/.test(path) ? encodeRows(response) : response;
                    if (!aborted) complete(200, 'OK', { text: JSON.stringify(rendered) }, 'Content-Type: text/plain; charset=utf-8');
                }).catch(error => {
                    const notice = document.getElementById('demo-warning');
                    notice.textContent = 'Die Aktion konnte nicht ausgeführt werden: ' + error.message; notice.hidden = false;
                    if (!aborted) complete(500, 'Demo backend error', { text: JSON.stringify({ error: error.message }) });
                });
            },
            abort() { aborted = true; },
        };
    });
})();
