<?php

namespace route;
use app\core\App;
class Route
{
    private $GET = [];
    private $POST = [];
    private $PUT = [];
    private $PATCH = [];
    private $DELETE = [];
    private $ROUTER = [];
    private $array = [];

    public function __construct()
    {
        $this->recursion(__DIR__ .'/routes');
//        echo "<pre>";
//        var_dump($this->array);
//        die;
        $routes = glob(__DIR__ . '/routes/*.php');
        foreach ($this->array as $i_routes => $key_routes) {
            if (is_file($key_routes)) {
                $array = require_once @$key_routes;
                if (is_array($array)) {
                    foreach ($array as $index => $item) {
                        $tester = explode('@', $item);
                        if (empty($tester[2])) {
                            $tester[2] = 'GET';
                        }
                        switch ($tester[2]) {
                            case 'POST':
                                $this->POST[$index] = ['controller' => $tester[0], 'method' => $tester[1]];
                                break;
                            case 'PUT':
                                $this->PUT[$index] = ['controller' => $tester[0], 'method' => $tester[1]];
                                break;
                            case 'PATCH':
                                $this->PATCH[$index] = ['controller' => $tester[0], 'method' => $tester[1]];
                                break;
                            case 'DEL':
                                $this->DELETE[$index] = ['controller' => $tester[0], 'method' => $tester[1]];
                                break;
                            default:
                                $this->GET[$index] = ['controller' => $tester[0], 'method' => $tester[1]];
                        }
                    }
                }
            }
        }
//        echo "<pre>";
//        var_dump($this->array);
//        die;
        $this->run();
    }

    public function test(): bool
    {

        $url = trim($_SERVER['REQUEST_URI'], '/');
        $url = filter_var($url, FILTER_SANITIZE_STRING);
        if (preg_match('/[?]/', $url)) {
            $url = explode('?', $url)[0];
        }
        switch ($_SERVER['REQUEST_METHOD']) {
            case 'POST':
                $request = $this->POST;
                break;
            case 'PUT':
                $request = $this->PUT;
                break;
            case 'PATCH':
                $request = $this->PATCH;
                break;
            case 'DEL':
                $request = $this->DELETE;
                break;
            default:
                $request = $this->GET;
        }
        foreach ($request as $index => $route) {
            if (preg_match('/[{}]/', $index)) {
                $explode = preg_split('/[{}]/', $index)[0];
                if (!!strstr($url, $explode)) {
                    $explode = substr($explode, 0, -1);
                    $api = preg_split("/{$explode}\//", $url)[1];
                    if (!strstr($api, '/')) {
                        $_SESSION['api'] = explode($explode . '/', $url)[1];
                        parse_str(file_get_contents('php://input'), $_REQUEST);
                        $this->ROUTER = $route;
                        return true;
                    }
                }
            }
            if ($url === $index) {
                parse_str(file_get_contents('php://input'), $_REQUEST);
                $this->ROUTER = $route;
                return true;
            }
        }
        return false;
    }

    public function run(): void
    {
        if ($this->test()) {
            new App($this->ROUTER['controller'], $this->ROUTER['method']);
        } else {
            new App('UsersController', 'error_page');
        }
    }

    public function recursion( $dir): void
    {
        $recurse = glob($dir . '/*');
        foreach ($recurse as $index => $item) {
            if (is_dir($item)) {
                $this->recursion($item);
            } else {
                if (pathinfo($item, PATHINFO_EXTENSION) === 'php')
                    array_push($this->array, $item);
            }
        }
    }

}