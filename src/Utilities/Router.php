<?php

namespace App\Utilities;

class Router {
    
    private string $view_path;    
    
    /**
     * @var AltoRouter
     */
    private $router;

    function __construct(string $view_path)
    {
        $this->view_path = $view_path;
        $this->router = new \AltoRouter();
    }
    
    /**
     * Map a url with the GET Method
     *
     * @param  string $url url to map
     * @param  string $template the template to return
     * @param  ?string $name the name of this route
     * @return self
     */
    public function get(string $url, string $template, ?string $name = NULL): self
    {
        $this->router->map('GET', $url, $template, $name);
        return $this;
    }
    
    /**
     * Map a url with the POST Method
     *
     * @param  string $url url to map
     * @param  string $template the template to return
     * @param  ?string $name the name of this route
     * @return self
     */
    public function post(string $url, string $template, ?string $name = NULL): self
    {
        $this->router->map('POST', $url, $template, $name);
        return $this;
    }
        
    /**
     * Map a url with a GET or POST Method
     *
     * @param  string $url url to map
     * @param  string $template the template to return
     * @param  ?string $name the name of this route
     * @return self
     */
    public function match(string $url, string $template, ?string $name = NULL): self
    {
        $this->router->map('GET|POST', $url, $template, $name);
        return $this;
    }


    /**
     * Match the route and return the corresponding template
     *
     * @return self
     */
    public function run(): self
    {
        $match = $this->router->match();
        $template = $match['target'];
        $params = $match['params'];

        // Store displays in memory
        ob_start();
        require $this->view_path . DIRECTORY_SEPARATOR . $template . '.php';
        $content = ob_get_clean();
        require $this->view_path . DIRECTORY_SEPARATOR . 'layouts/default.php';
        
        return $this;
    }
}