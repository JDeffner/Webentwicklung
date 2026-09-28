<?php
// Render the original application views at build time, without a server or database.
namespace CodeIgniter\Config {
    class BaseConfig {}
}

namespace {
    error_reporting(E_ALL);
    set_error_handler(static function ($severity, $message, $file, $line) {
        throw new \ErrorException($message, 0, $severity, $file, $line);
    });
    $root = dirname(__DIR__);
    require $root . '/app/Config/Validation.php';
    require $root . '/app/Cells/Forms.php';
    require $root . '/app/Cells/CrudModals.php';
    $validation = new \Config\Validation();
    $rules = [];
    foreach (['boards', 'spalten', 'tasks', 'personen'] as $table) $rules[$table] = $validation->$table;
    if (($argv[1] ?? '') === '--rules') {
        echo json_encode($rules, JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR);
        exit;
    }

    final class DemoView
    {
        private ?string $layout = null;
        private array $sections = [];
        private string $sectionName = '';
        public function __construct(private array $data) {}
        public function render(string $name): string
        {
            extract($this->data, EXTR_SKIP);
            ob_start();
            include dirname(__DIR__) . '/app/Views/' . $name . '.php';
            $html = ob_get_clean();
            if ($this->layout !== null) {
                $layout = $this->layout;
                $this->layout = null;
                return $this->render($layout);
            }
            return $html;
        }
        public function extend(string $layout): string { $this->layout = $layout; return ''; }
        public function section(string $name): string { $this->sectionName = $name; ob_start(); return ''; }
        public function endSection(): string { $this->sections[$this->sectionName] = ob_get_clean(); return ''; }
        public function renderSection(string $name): string { return $this->sections[$name] ?? ''; }
        public function include(string $name): string { return (new self($this->data))->render(preg_replace('/\.php$/', '', $name)); }
    }
    function base_url(string $route = ''): string
    {
        global $prefix;
        $route = trim($route, '/');
        return $prefix . ($route === '' ? '' : $route . '/');
    }
    function view(string $name, array $data = []): string
    {
        global $pageData;
        return (new DemoView(array_merge($pageData, $data)))->render($name);
    }
    function view_cell(string $call, string $parameters = ''): string
    {
        [$class, $method] = explode('::', $call);
        $class = 'App\\Cells\\' . $class;
        parse_str($parameters, $arguments);
        return (new $class())->$method(...array_values($arguments));
    }

    $routes = [
        '' => ['Tasks', 'pages/Tasks'],
        'anmelden' => ['Login', 'pages/user/BenutzerAnmelden'],
        'benutzer/erstellen' => ['Neuer Benutzer', 'pages/user/BenutzerErstellen'],
        'benutzer/gast' => ['Login', 'pages/user/BenutzerAnmelden'],
        'profil' => ['Profil', 'pages/user/BenutzerProfil'],
        'willkommen' => ['Willkommen', 'pages/user/BenutzerWillkommen'],
        'tasks' => ['Tasks', 'pages/Tasks'],
        'boards' => ['Boards', 'pages/Boards'],
        'spalten' => ['Spalten', 'pages/Spalten'],
        'admin/personen' => ['Personen', 'pages/admin/Personen'],
        'admin/taskarten' => ['Taskarten', 'pages/admin/Taskarten'],
        'admin/tasks' => ['Tasks-Admin', 'pages/admin/Tasks'],
        'denied' => ['Zugriff verweigert', 'errors/AccessDenied'],
    ];
    $output = $argv[1] ?? throw new \RuntimeException('Output directory required.');
    foreach ($routes as $route => [$title, $view]) {
        $prefix = $route === '' ? './' : str_repeat('../', count(explode('/', $route)));
        $pageData = ['title' => $title, 'boards' => [], 'spalten' => [], 'personen' => [], 'taskarten' => [], 'boardID' => '0', 'boardName' => 'Board auswählen'];
        $navbars = [];
        foreach (['0', '1', '2'] as $role) {
            $_COOKIE = ['permissionLevel' => $role];
            if ($role !== '0') $_COOKIE += ['userid' => '1', 'username' => '<span data-demo-user="vorname"></span>', 'userlastname' => '<span data-demo-user="nachname"></span>'];
            $navbars[$role] = view('templates/Navbar');
        }
        $pageData['demoConfig'] = ['route' => $route, 'navbars' => $navbars, 'rules' => $rules];
        $directory = $output . ($route === '' ? '' : '/' . $route);
        if (!is_dir($directory)) mkdir($directory, 0777, true);
        file_put_contents($directory . '/index.html', view($view));
    }
    echo 'Rendered ' . count($routes) . " routes from app/Views.\n";
}
