(function () {
    'use strict';
    const { route, navbars, rules } = window.MINMAX_DEMO;
    const root = new URL(BASE_URL, location.href);
    const warnings = [];
    let storage, sessionStorage, demoPanel;
    try { storage = window.localStorage; sessionStorage = window.sessionStorage; } catch { /* Report through the backend warning callback. */ }
    const backend = MinMaxDemo.createBackend({ storage, sessionStorage, rules, onWarning: message => {
        warnings.push(message);
        demoPanel?.showWarning(message);
    } });
    const go = path => location.replace(new URL(path, root));
    if (route === 'anmelden') backend.logout();
    if (route === 'benutzer/gast') { backend.guest(); go('tasks/'); return; }
    const publicPage = ['anmelden', 'benutzer/erstellen'].includes(route);
    if (!publicPage && backend.permission() === null) {
        try { backend.loginAsDemo('1'); }
        catch { backend.guest(); }
    }
    if (route.startsWith('admin/') && backend.permission() !== '2') { go('denied/'); return; }

    demoPanel = DemoPanel.mount({
        project: 'Kanban',
        homeUrl: 'https://jdeffner.com',
        roles: [{ id: '0', label: 'Guest' }, { id: '1', label: 'User' }, { id: '2', label: 'Admin' }],
        help: route === 'anmelden'
            ? 'Choose a role for instant access, or sign in with user@example.com or admin@example.com and password demo. Changes stay in this browser. Reset restores the sample data.'
            : 'Switch roles to try different permissions. Changes stay in this browser. Reset restores the sample data.',
        onRole(role) {
            role === '0' ? backend.guest() : backend.loginAsDemo(role);
            if (publicPage || route === 'denied' || (route.startsWith('admin/') && backend.permission() !== '2')) go('tasks/');
            else location.reload();
        },
        onReset() { backend.reset(); go('tasks/'); },
    });
    if (warnings.length) demoPanel.showWarning(warnings.at(-1));
    function syncNavbar() {
        if (!publicPage) {
            const navbar = document.querySelector('nav.navbar');
            const wrapper = document.createElement('div');
            wrapper.innerHTML = navbars[backend.permission() ?? '0'];
            navbar.replaceWith(wrapper.firstElementChild);
        }
        const user = backend.currentUser();
        document.querySelectorAll('[data-demo-user]').forEach(element => { element.textContent = user?.[element.dataset.demoUser] ?? ''; });
        demoPanel.setRole(backend.permission());
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
                        demoPanel.showWarning(response.error.authorization ?? response.error.record);
                    }
                    const rendered = /(?:^|\/)raw(?:\/|$)/.test(path) ? encodeRows(response) : response;
                    if (!aborted) complete(200, 'OK', { text: JSON.stringify(rendered) }, 'Content-Type: text/plain; charset=utf-8');
                }).catch(error => {
                    demoPanel.showWarning('Die Aktion konnte nicht ausgeführt werden: ' + error.message);
                    if (!aborted) complete(500, 'Demo backend error', { text: JSON.stringify({ error: error.message }) });
                });
            },
            abort() { aborted = true; },
        };
    });
})();
