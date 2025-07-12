<?php
/**
 * App Router Class
 * Creates URL & loads controller
 * URL FORMAT: /controller/method/params
 */
class Router {
    protected $currentController = 'Home';
    protected $currentMethod = 'index';
    protected $params = [];
    protected $routes = [];
    
    public function __construct() {
        // Definisikan route-route yang ada
        $this->addRoute('', 'Home@index');
        $this->addRoute('home', 'Home@index');
        
        // Admin routes
        $this->addRoute('admin', 'Admin@index');
        $this->addRoute('admin/pakets', 'Admin@pakets');
        $this->addRoute('admin/portofolio', 'Portofolio@admin');
        $this->addRoute('admin/portofolio/add', 'Portofolio@add');
        $this->addRoute('admin/portofolio/edit/([0-9]+)', 'Portofolio@edit');
        $this->addRoute('admin/portofolio/delete/([0-9]+)', 'Portofolio@delete');
        $this->addRoute('admin/pemesanan', 'Admin@pemesanan');
        $this->addRoute('admin/pembayaran', 'Admin@pembayaran');
        $this->addRoute('admin/laporan', 'Admin@laporan');
        
        // User routes
        $this->addRoute('portofolio', 'Portofolio@index');
    }
    
    public function addRoute($route, $handler) {
        $this->routes[$route] = $handler;
    }
    
    public function run() {
        $url = $this->getUrl();
        $path = isset($url) ? implode('/', $url) : '';
        
        // Cek apakah ada route yang cocok
        $matchedRoute = false;
        
        // Cek route yang tepat sama
        if (isset($this->routes[$path])) {
            $handler = $this->routes[$path];
            list($controller, $method) = explode('@', $handler);
            $this->loadController($controller, $method, []);
            $matchedRoute = true;
        } else {
            // Cek route dengan parameter
            foreach ($this->routes as $route => $handler) {
                // Jika route mengandung parameter
                if (strpos($route, '(') !== false) {
                    $pattern = '#^' . preg_replace('#\([^)]+\)#', '([^/]+)', $route) . '$#';
                    
                    if (preg_match($pattern, $path, $matches)) {
                        array_shift($matches); // Hapus match pertama (full string)
                        list($controller, $method) = explode('@', $handler);
                        $this->loadController($controller, $method, $matches);
                        $matchedRoute = true;
                        break;
                    }
                }
            }
        }
        
        // Jika tidak ada route yang cocok, gunakan metode lama
        if (!$matchedRoute) {
            $this->legacyRouting($url);
        }
    }
    
    protected function loadController($controller, $method, $params = []) {
        // Require the controller
        if (file_exists(__DIR__ . '/../controllers/' . $controller . '.php')) {
            require_once __DIR__ . '/../controllers/' . $controller . '.php';
            
            // Instantiate controller class
            $controllerInstance = new $controller;
            
            // Call the method with parameters
            call_user_func_array([$controllerInstance, $method], $params);
        } else {
            // Controller not found
            die('Controller not found: ' . $controller);
        }
    }
    
    protected function legacyRouting($url) {
        // Look in controllers for first value
        if(isset($url[0]) && file_exists(__DIR__ . '/../controllers/' . ucwords($url[0]) . '.php')) {
            // If exists, set as controller
            $this->currentController = ucwords($url[0]);
            // Unset 0 Index
            unset($url[0]);
        }
        
        // Require the controller
        require_once __DIR__ . '/../controllers/' . $this->currentController . '.php';
        
        // Instantiate controller class
        $this->currentController = new $this->currentController;
        
        // Check for second part of url
        if(isset($url[1])) {
            // Check to see if method exists in controller
            if(method_exists($this->currentController, $url[1])) {
                $this->currentMethod = $url[1];
                // Unset 1 index
                unset($url[1]);
            }
        }
        
        // Get params
        $this->params = $url ? array_values($url) : [];
        
        // Call a callback with array of params
        call_user_func_array([$this->currentController, $this->currentMethod], $this->params);
    }
    
    public function getUrl() {
        if(isset($_GET['url'])) {
            $url = rtrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode('/', $url);
            return $url;
        }
        
        return [];
    }
} 