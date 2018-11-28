<?php

namespace App\Models;

use App\Models\Interfaces\IShips;

/**
 * Class Grid
 * @package App\\Models
 * @author Taner
 */
class Grid
{
    /**
     * Width of the grid
     * @var int
     */
    protected $width;

    /**
     * Height of the grid
     * @var int
     */
    protected $height;

    /**
     * @var array
     */
    protected $ships = [];

    /**
     * @var array
     */
    protected $map = [];

    /**
     * @var int
     */
    public $totalTargets;

    /**
     * @var int
     */
    public $shots;

    /**
     * @var array
     */
    public $shipPositions = [];

    /**
     * Grid constructor.
     * @param int $width
     * @param int $height
     */
    public function __construct($width, $height)
    {
        $this->width = $width;
        $this->height = $height;
    }

    /**
     * @param IShips $ship
     * @return $this
     */
    public function setShip(IShips $ship)
    {
        $this->ships[] = $ship;
        return $this;
    }

    /**
     * Grid::map accessor
     * @return array The map matrix
     */
    public function getMatrix()
    {
        return $this->map;
    }

    /**
     * Amount of remaining targets on the map
     *
     * @return int
     */
    public function getTargetCount()
    {
        return $this->totalTargets;
    }

    /**
     * Calculate the amount of targets on the map, based on the Grid::$ships entries
     *
     * @return $this
     */
    public function calculateMaxTargets()
    {
        foreach ($this->ships as $ship) {
            $this->totalTargets += $ship->getLength();
        }
        return $this;
    }

    /**
     * Generate an empty map matrix with 0 values in each node
     *
     * @return $this
     */
    public function generateGrid()
    {
        for ($row = 0; $row < $this->width; $row++) {
            for ($col = 0; $col < $this->height; $col++) {
                $this->map[$row][$col] = '.';
            }
        }
        return $this;
    }

    /**
     * Populate the map matrix by setting 1 for each node contain a target
     *
     * @return $this
     */
    public function populateGrid()
    {
        foreach ($this->ships as $ship) {
            $this->addToGrid($ship);
        }
        return $this;
    }

    /**
     * Add ship to the grid
     * @param Ships $ship
     * @return bool
     */
    public function addToGrid(IShips $ship)
    {
        while (true) {
            //get direction
            $direction = $this->getRandomDirection();
            //get random horizontal position
            $x = rand(0, ($direction == 'horizontal' ? $this->width : $this->width - $ship->getLength()) - 1);
            //get random vertical position
            $y = rand(0, ($direction == 'vertical' ? $this->height : $this->height - $ship->getLength()) - 1);

            if ($this->canPositionShipAt($x, $y, $ship, $direction)) {
                $this->positionShipAt($x, $y, $ship, $direction);
                return true;
            }
        }
        return false;
    }

    /**
     * Returns a random direction
     *
     * @return mixed
     */
    public function getRandomDirection()
    {
        return (rand(1, 2) == 1 ? 'horizontal' : 'vertical');
    }

    /**
     * Check if ship can be placed on the grid
     * @param $x - coordinate
     * @param $y - coordinate
     * @param Ships $ship
     * @param $direction
     * @return bool
     */
    public function canPositionShipAt($x, $y, IShips $ship, $direction)
    {
        for ($i = 0; $i < $ship->getLength(); $i++) {
            //set x and y coordinates to temporary variables
            $currentX = $x;
            $currentY = $y;

            if ($direction == 'horizontal') {
                $currentY += $i;
            } else {
                $currentX += $i;
            }
            //check for other ship
            if ($this->map[$currentY][$currentX] == 'S') {
                return false;
            }
        }

        return true;
    }

    /**
     * Fills an array of positions based on ship size, starting coordinate
     * @param $x - coordinate
     * @param $y - coordinate
     * @param Ships $ship
     * @param $direction
     * @return bool
     */
    public function positionShipAt($x, $y, IShips $ship, $direction)
    {
        for ($i = 0; $i < $ship->getLength(); $i++) {
            //assign coordinates to temp variables
            $currentX = $x;
            $currentY = $y;

            if ($direction == 'horizontal') {
                $currentY += $i;
            } else {
                $currentX += $i;
            }

            $this->fillCoordinate($currentY, $currentX, 'S');
            //save ship positions
            $this->shipPositions[$ship->getName()][] = [$currentY, $currentX];
        }

        return true;
    }

    /**
     * Change the value of certain coordinate to 1
     *
     * @param int $y
     * @param int $x
     * @param string $sign
     * @return int
     */
    public function fillCoordinate($y, $x, $sign)
    {
        return $this->map[$y][$x] = $sign;
    }

    /**
     * Amount of shots spent in the game
     *
     * @return int
     */
    public function getShotCount()
    {
        return $this->shots;
    }
    
}
