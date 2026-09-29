(function () {
    'use strict';

    function mount({ project, homeUrl, roles, help, onRole, onReset }) {
        const listeners = new AbortController();
        const listen = (element, event, callback) => element.addEventListener(event, callback, { signal: listeners.signal });
        const panel = document.createElement('aside');
        panel.className = 'demo-panel';
        panel.lang = 'en';
        panel.setAttribute('aria-label', 'Demo controls');
        panel.innerHTML = `
            <div class="demo-panel-header">
                <div class="demo-panel-identity">
                    <p><span class="demo-panel-project"></span><span class="demo-panel-label"> · Demo</span></p>
                    <div class="demo-panel-help-wrap">
                        <button type="button" class="demo-panel-icon demo-panel-help" aria-label="About this demo" aria-describedby="demo-panel-help-text"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="10"/><path d="M9.1 9a3 3 0 0 1 5.8 1c0 2-3 3-3 3m.1 4h.01"/></svg></button>
                        <div class="demo-panel-tooltip" id="demo-panel-help-text" role="tooltip" hidden></div>
                    </div>
                </div>
                <button type="button" class="demo-panel-icon" data-demo-action="collapse" aria-controls="demo-panel-controls" aria-expanded="true" aria-label="Collapse demo controls"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m6 9 6 6 6-6"/></svg></button>
            </div>
            <div class="demo-panel-controls" id="demo-panel-controls">
                <div class="demo-panel-roles" role="group" aria-label="Try a role"></div>
                <div class="demo-panel-confirm" hidden>
                    <p>Reset demo?</p>
                    <button type="button" data-demo-action="confirm">Reset</button>
                    <button type="button" data-demo-action="cancel">Cancel</button>
                </div>
            </div>
            <div class="demo-panel-footer">
                <a class="demo-panel-home"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m12 19-7-7 7-7m-7 7h14"/></svg><span></span></a>
                <button type="button" class="demo-panel-reset" data-demo-action="reset" aria-label="Reset demo data">Reset</button>
                <button type="button" class="demo-panel-expand" data-demo-action="expand" aria-controls="demo-panel-controls" aria-expanded="false" hidden>Demo<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m18 15-6-6-6 6"/></svg></button>
            </div>
            <nav class="demo-panel-legal" aria-label="Legal information"><a href="https://jdeffner.com/impressum">Impressum</a><a href="https://jdeffner.com/datenschutz#kanban">Datenschutz</a></nav>
            <p class="demo-panel-warning" role="alert" hidden></p>`;
        const header = panel.querySelector('.demo-panel-header');
        const controls = panel.querySelector('.demo-panel-controls');
        const roleGroup = panel.querySelector('.demo-panel-roles');
        const confirmation = panel.querySelector('.demo-panel-confirm');
        const warning = panel.querySelector('.demo-panel-warning');
        const helpButton = panel.querySelector('.demo-panel-help');
        const helpWrap = panel.querySelector('.demo-panel-help-wrap');
        const tooltip = panel.querySelector('.demo-panel-tooltip');
        const action = name => panel.querySelector(`[data-demo-action="${name}"]`);
        let expanded = true;
        let currentRole = null;
        let helpPinned = false;

        panel.querySelector('.demo-panel-project').textContent = project;
        tooltip.textContent = help;
        const home = panel.querySelector('.demo-panel-home');
        home.href = homeUrl;
        home.querySelector('span').textContent = new URL(homeUrl).hostname.replace(/^www\./, '');
        home.setAttribute('aria-label', 'Back to ' + home.querySelector('span').textContent);
        for (const role of roles) {
            const button = document.createElement('button');
            button.type = 'button';
            button.dataset.demoRole = role.id;
            button.textContent = role.label;
            button.setAttribute('aria-pressed', 'false');
            roleGroup.append(button);
        }

        function closeHelp() { helpPinned = false; tooltip.hidden = true; }
        function setConfirmation(visible) {
            confirmation.hidden = !visible;
            roleGroup.hidden = visible;
            action('reset').hidden = visible || !expanded;
        }
        function setExpanded(value) {
            expanded = value;
            closeHelp();
            setConfirmation(false);
            panel.classList.toggle('is-collapsed', !expanded);
            header.hidden = controls.hidden = !expanded;
            action('expand').hidden = expanded;
            action('collapse').setAttribute('aria-expanded', String(expanded));
            action('expand').setAttribute('aria-expanded', String(expanded));
        }
        function setRole(role) {
            currentRole = role;
            roleGroup.querySelectorAll('button').forEach(button => button.setAttribute('aria-pressed', String(button.dataset.demoRole === role)));
            const label = roles.find(item => item.id === role)?.label ?? 'Signed out';
            action('expand').setAttribute('aria-label', `Expand ${project} demo controls. Current role: ${label}`);
        }
        function showWarning(message) {
            setExpanded(true);
            warning.textContent = message;
            warning.hidden = false;
        }
        async function run(callback) {
            closeHelp();
            panel.querySelectorAll('button').forEach(button => { button.disabled = true; });
            try { await callback(); }
            catch (error) { showWarning(error.message ?? 'The demo action failed. Please try again.'); }
            finally { panel.querySelectorAll('button').forEach(button => { button.disabled = false; }); }
        }

        listen(helpWrap, 'pointerenter', event => { if (event.pointerType === 'mouse') tooltip.hidden = false; });
        listen(helpWrap, 'pointerleave', () => { if (!helpPinned && document.activeElement !== helpButton) tooltip.hidden = true; });
        listen(helpButton, 'focus', () => { tooltip.hidden = false; });
        listen(helpButton, 'blur', () => { if (!helpPinned) tooltip.hidden = true; });
        listen(helpButton, 'click', () => { helpPinned = !helpPinned; tooltip.hidden = !helpPinned; });
        listen(document, 'pointerdown', event => { if (!helpWrap.contains(event.target)) closeHelp(); });
        listen(document, 'keydown', event => { if (event.key === 'Escape') closeHelp(); });
        listen(panel, 'keydown', event => {
            if (event.key === 'Escape' && !confirmation.hidden) {
                setConfirmation(false);
                action('reset').focus();
                event.stopPropagation();
            }
        });
        listen(panel, 'click', event => {
            const button = event.target.closest('button');
            if (!button) return;
            if (button.dataset.demoRole !== undefined) {
                if (button.dataset.demoRole !== currentRole) run(() => onRole(button.dataset.demoRole));
                return;
            }
            switch (button.dataset.demoAction) {
                case 'collapse': setExpanded(false); action('expand').focus(); break;
                case 'expand': setExpanded(true); action('collapse').focus(); break;
                case 'reset': closeHelp(); setConfirmation(true); action('cancel').focus(); break;
                case 'cancel': setConfirmation(false); action('reset').focus(); break;
                case 'confirm': run(onReset); break;
            }
        });
        setRole(null);
        document.body.append(panel);
        return { setRole, showWarning, destroy() { listeners.abort(); panel.remove(); } };
    }

    window.DemoPanel = { mount };
})();
