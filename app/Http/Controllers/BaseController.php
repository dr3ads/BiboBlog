<?php

namespace BiboBlog\Http\Controllers;

use Theme;

/**
 * Note: this class can be utilized to create controller generic methods.
 */

class BaseController extends Controller {

    public $theme = null;
    public $layout = 'default';
    public $theme_name = '';
    public $data = array();

}
