<?php

namespace BiboBlog\Http\Controllers;

use Theme;

class BaseController extends Controller {

    public $theme = null;
    public $layout = '';
    public $theme_name = '';
    public $data = array();

    public function __construct()
    {
        $this->middleware = 'auth';
        $this->layout = 'default';
        $this->theme_name = 'biboblog';
    }

    protected function setupLayout()
    {
        $this->theme = Theme::uses($this->theme_name)->layout($this->layout);

    }


    public function callAction($method, $parameters)
    {
        $this->setupLayout();

        return call_user_func_array(array($this, $method), $parameters);
    }


}
