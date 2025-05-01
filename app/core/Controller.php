<?php

class Controller {
	protected function admin($view, $data = [])
    {
        if (!empty($data)) {
            extract($data);
        }

		require_once 'app/views/admin/header.php';
		require_once 'app/views/admin/'.$view.'.php';
		require_once 'app/views/admin/footer.php';
	}

	protected function model($model)
    {
		require_once 'app/models/'.ucfirst($model).'Model.php';
        $class = $model.'Model';
        
		return new $class();
	}

	protected function page($view, $data = [])
    {
        if (!empty($data)) {
            extract($data);
        }

		require_once 'app/views/header.php';
		require_once 'app/views/'.$view.'.php';
		require_once 'app/views/footer.php';
	}

	protected function toJson($output)
    {
        header('Access-Control-Allow-Origin:*');
        header('Content-Type:application/json');
		echo json_encode($output);
	}

	protected function view($view, $data = [])
    {
        if (!empty($data)) {
            extract($data);
        }

		require_once 'app/views/'.$view.'.php';
	}
}