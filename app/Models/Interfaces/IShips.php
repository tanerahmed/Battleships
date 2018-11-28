<?php

namespace App\Models\Interfaces;

/**
 * Interface IShips
 * @package App\Models\Interfaces
 * @author Taner
 */
interface IShips
{

    /**
     * Get name of the ship
     * @return string
     */
    public function getName();

    /**
     * Get length of the ship
     * @return int
     */
    public function getLength();
    
}
