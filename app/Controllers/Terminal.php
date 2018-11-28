<?php

namespace App\Controllers;

use App\Models\Shooter;
use App\Views\View;

class Terminal extends Controller
{

    public function index()
    {
        //play 
        $battleShips = $this->gameStart();
        
        //get instance of shooter class
        $shooter = new Shooter($battleShips);

        $stdin = fopen('php://stdin', 'r');
        $play = true;
        //cheat mode
        $show = false;
        //show or hide enter coordinate message
        $this->data['enterCoordinates'] = true;

        while ($play) {
            //display the grid
            $this->data['grid'] = $this->displayGrid($battleShips, $show);
            try {
                //get View singleton instance
                $this->view = View::getInstance();      
                $this->view->set('terminal/home.php', 'data', $this->data);                       
            } catch (\Exception $e) {
                echo '<pre>'; print_r($e->getMessage()); echo '</pre>'; die();
            }

            $show = false;
            $coord = fgets($stdin);

            if (trim($coord) == 'show') {
                $show = true;
                continue;
            }
            //get y coordinate
            $y = $shooter->getShootY($coord);
            //get x coordinate
            $x = $shooter->getShootX($coord);
            //make a shoot
            $shoot = $shooter->shoot($y, $x);

            //game complate
            if ($shoot === true) {
                $this->data['shoots'] = $battleShips->getShotCount();
                $this->data['enterCoordinates'] = false;
                //refresh the grid for the last hit
                $this->data['grid'] = $this->displayGrid($battleShips, $show);
                try {
                    //get View singleton instance
                    $this->view = View::getInstance();      
                    $this->view->set('terminal/home.php', 'data', $this->data);
                    $this->view->set('terminal/success.php', 'data', $this->data['shoots']); 
                } catch (\Exception $e) {
                    echo '<pre>'; print_r($e->getMessage()); echo '</pre>'; die();
                }
                $play = false;
            } else {
                $this->data['message'] = $shoot;
            }
        }
    }
    
}
