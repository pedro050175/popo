<?php
namespace lib;

class Router {

    private static $routes = [];
    public static function add(string $method, string $action, callable $controller): void {
        $action = trim($action, '/');
        self::$routes[$method][$action] = $controller;
    }

    public static function dispatch ():void{
        $method = $_SERVER['REQUEST_METHOD'];
        
        /* echo "_SERVER['REQUEST_METHOD']: ". $_SERVER['REQUEST_METHOD']. "<br/>";
        echo "_SERVER['REQUEST_URI']: ".  $_SERVER['REQUEST_URI']. "<br/>"; 
        var_dump(self::$routes);
        sleep(2); */
        $action = preg_replace(DIRECTORIO,'',$_SERVER['REQUEST_URI']);
        
        $action = trim($action, '/'); //elimina todos las / del principio y del final, si hay dos al principio quita las dos
        
        $param = null;
        preg_match('/[0-9]+$/', $action, $match);//busca la expresion regular (numeros unas o mas veces que se repiten hasta el final) en action y lo que en coincida con la empresion lo guarda en match
        if (!empty($match)) { //si hay parametros. esto no se para que es. si le añada a action el txto id, en la tabla routes no encontrara la funcion que guardo en add que usaba el indice [GET][action]
            $param = $match[0];
            $action = preg_replace('/'.$match[0].'/',':id',$action);
        }
        $callback = self::$routes[$method][$action];
        if (null != ($callback)) {
            echo call_user_func($callback, $param);
         } else { echo "Funcion nula";}    
    } 
}
