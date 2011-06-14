<?php
if(!defined('__nexus')){
    header("HTTP/1.0 404 not found");
    header('Location: ../index.php/error/404/');
    exit();
}
class reroute{
    protected $url;
    public function __construct(){}
    public function route($module = '', $method = '', $submethod = ''){
        /* This function should be used instead of a header call for redirecting
         * the user
        */
        $url = $this->get_route($module, $method, $submethod);
        header("Location: $url");
        exit();
    }
    public function load_route($module = '', $method = ''){
        /*
         * load_route should be used as an alternative to a complete redirect
         * when you are curtain that no out put has been sent to the browser
         * it works by loading the controler/module and running it in a way very
         * similar to the index file with the provided module and method
         * if the module doesn't exist it will run a header redirect
         *
        */
        if(!class_exists($module)){
            @include_once "modules/$module/$module.class.php";
            if(!class_exists($module)){
                $this->route($module, $method);
            }
            $page = new $module();
            $page->$method();
        }
    }
    public function get_url(){
        /* This function builds the current base url for the redirect */
        $url = 'http://'.$_SERVER['SERVER_NAME'] //build the base url exp. http://www.example.com
                .(strpos($_SERVER['REQUEST_URI'],'.php')===false? // check id the request url has a file in it
                    '/'.basename($_SERVER['REQUEST_URI']) // if there is no file get the request url with out the ending /
                :
                    substr($_SERVER['REQUEST_URI'],0, // there is a file get everthing before index.php
                            strrpos($_SERVER['REQUEST_URI'],'/', // get the last / before the .php extension
                                   strpos($_SERVER['REQUEST_URI'],'.php')-strlen($_SERVER['REQUEST_URI'])
                            )
                    )
                ).'/index.php';
        return $url;
    }
    public function get_route($module, $method, $extra = ''){
        /*
         *  This is what is responcable for building the route/url to any particular module method
         */
        $url = $this->get_url();
        if(!empty($module)){
            $url .= "/$module/";
        }
        if(!empty($method)){
            $url .= "$method/";
        }
        if(!empty($extra)){
            foreach($extra as $param){
                $url .= "$param/";
            }
        }
        return $url;
    }
}
?>