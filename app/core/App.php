<?php

class App {
	protected $path = '';
	protected $method = 'index';
	protected $params = [];
    protected $controller = 'Home';

	public function __construct()
    {
        $url = $this->parseURL();
        $dir = $url[0];

        if (is_dir('app/controllers/'.$dir))
        {
            $filename = 'app/controllers/'.$url[0].'/'.ucfirst($url[1]).'.php';

            if (file_exists($filename))
            {
                $this->controller = ucfirst($url[1]);
                unset($url[0]);
                unset($url[1]);
            }

            require_once $filename;
            $this->controller = new $this->controller;

            if (isset($url[2]))
            {
                if (method_exists($this->controller, $url[2]))
                {
                    $this->method =  $url[2];
                    unset($url[2]);
                }
            }
        }
        else
        {
            $filename = 'app/controllers/'.ucfirst($url[0]).'.php';
            if (file_exists($filename)) {
                $this->controller = ucfirst($url[0]);
                unset($url[0]);

        require_once $filename;
        $this->controller = new $this->controller;

        if (isset($url[1]) && method_exists($this->controller, $url[1])) {
            $this->method =  $url[1];
            unset($url[1]);
        }
    } else {
        // Tidak ditemukan controller, fallback ke 404 atau Home
        require_once 'app/controllers/Home.php';
        $this->controller = new Home;
        $this->method = 'notfound'; // Bisa ganti ke index atau bikin method error
        $this->params = [];
    }
}


		if (!empty($url))
        {
			$this->params = array_values( $url );
		}

		call_user_func_array([$this->controller, $this->method], $this->params);
    }

    public function parseURL()
    {
        if(isset($_GET['url']))
        {
			$get = rtrim($_GET['url'], '/');
			$var = filter_var($get, FILTER_SANITIZE_URL);
			$url = explode('/', $var);
			return $url;
		}
        else
        {
			$url[0] = $this->controller;
			return $url;
		}
    }
}