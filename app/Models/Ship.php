<?php

namespace App\Models;

use App\Models\Interfaces\IShips;

/**
 * Class Ship
 * @package App\Models
 * @author Taner
 */
class Ship implements IShips
{
    /**
     * Name of the ship
     * @var string
     */
    private $name;

    /**
     * Length of the ship
     * @var int
     */
    private $length;

    public function __construct($name, $length)
    {
        $this->name = $name;
        $this->length = $length;
    }

    /**
     * Get name of the ship
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get length of the ship
     * @return mixed
     */
    public function getLength()
    {
        return $this->length;
    }
    
}