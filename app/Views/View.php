<?php

namespace App\Views;

class View 
{
    // Used to transfer data to View
    private $_data = array();

    // Hold the class instance.
    private static $instance = null;

    // The constructor is private
    // to prevent initiation with outer code.
    private function __construct()
    {}

    /**
     * Singelton to get instance for View class
     *
     * @return View
     */
    public static function getInstance()
    {
        if (self::$instance == null)
        {
            self::$instance = new View();
        }
        return self::$instance;
    }

    public function __get($name)
    {
        if (array_key_exists($name, $this->_data)) {
            return $this->_data[$name];
        }
    }

    public function set($file, $key, $value)
    {
        $this->_data[$key] = $value;
        $this->output($file);
    }

    public function output($file)
    {
        if(ob_get_contents()){
            ob_clean();
        }
        ob_start();
        include($file);
        $output = ob_get_contents();
        ob_end_clean();
        echo $output;
    }

}