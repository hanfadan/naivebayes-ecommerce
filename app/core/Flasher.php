<?php

class Flasher {
	public static function danger($title, $message){
		$_SESSION['flash'] = [
			'title' => $title,
			'status' => 'danger',
			'message' => $message
		];
	}

	public static function info($title, $message){
		$_SESSION['flash'] = [
			'title' => $title,
			'status' => 'info',
			'message' => $message
		];
	}

	public static function output(){
		if ( isset($_SESSION['flash']) ) {
			echo '
                <div class="alert alert-'.$_SESSION['flash']['status'].' alert-dismissible fade show" role="alert">
                    <strong>'.$_SESSION['flash']['title'].'!</strong> '.$_SESSION['flash']['message'].'
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
			';
			unset($_SESSION['flash']);
		}
	}

	public static function success($title, $message){
		$_SESSION['flash'] = [
			'title' => $title,
			'status' => 'success',
			'message' => $message
		];
	}

	public static function warning($title, $message){
		$_SESSION['flash'] = [
			'title' => $title,
			'status' => 'warning',
			'message' => $message
		];
	}
}
