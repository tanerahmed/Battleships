<?php

namespace App\Controllers;

use App\Models\Shooter;
use App\Views\View;

class Browser extends Controller
{

    /**
    * Use to send data on view
    * @var array
    */
    protected $data=[];

    /**
    * Instance View class
    * @var View
    */
    protected $view;

    public function __construct($request)
    {
        //fast routing,ugly but quick decision :)
        $this->request_arr = explode("/",$request);
        if(isset($this->request_arr[0])){
             $this->controller = $this->request_arr[0];
             if(method_exists($this,$this->controller)){
                 $method = $this->controller;
                 $this->$method();
             }
        }
    }

    public function index()
    {
        if (isset($_SESSION['gameEnded']) && $_SESSION['gameEnded'] == true) {
            session_destroy();
            $this->index();
        }

        if (!isset($_SESSION['game'])) {
            //call the game from Browser Controller
            $battleShips = $this->gameStart();
            $_SESSION['game'] = serialize($battleShips);
        } else {
            $battleShips = unserialize($_SESSION['game']);
        }                     
        
        $showShips = (isset($_SESSION['show']) && $_SESSION['show'] == 1) ? true : false;       
        //get drawn grid
        $this->data['grid'] = $this->displayGrid($battleShips, $showShips);

        try {	
            //get View singleton instance
            $this->view = View::getInstance();		
			return $this->view->set('browser/home.php', 'data', $this->data);
        } catch (\Exception $e) {
            echo '<pre>'; print_r($e->getMessage()); echo '</pre>'; die();
        }
    }

     public function hit()
    {
        $coord = htmlspecialchars($_POST['coord']);

        if ($coord == 'show') {
            $_SESSION['show'] = 1;
            $_SESSION['message'] = '';
            return  $this->index();
        }
        $battleShips = unserialize($_SESSION['game']);
        //get instance of shooter class
        $shooter = new Shooter($battleShips);
        //get y coordinate
        $y = $shooter->getShootY($coord);
        //get x coordinate
        $x = $shooter->getShootX($coord);
        //make a shoot
        $shoot = $shooter->shoot($y, $x);
       //game over
        if ($shoot === true) {
            $_SESSION['message'] = $battleShips->getShotCount();
            $_SESSION['gameEnded'] = true;
            $this->success();
        } else {
            $_SESSION['message'] = $shoot;
        }
        $_SESSION['show'] = 0;
        $_SESSION['game'] = serialize($battleShips);

        return  $this->index();
    }

    public function success()
    {

        if (!isset($_SESSION['gameEnded'])) {
             $this->index();
        }

        $this->data['shoots'] = $_SESSION['message'];        
        try {
            //get View singleton instance
            $this->view = View::getInstance();      
            return $this->view->set('browser/success.php', 'data', $this->data);
        } catch (\Exception $e) {
            echo '<pre>'; print_r($e->getMessage()); echo '</pre>'; die();
        }
    }
    
}
