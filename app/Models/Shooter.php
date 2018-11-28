<?php

namespace App\Models;


class Shooter
{
    /**
     * @var Grid
     */
    private $grid;

    public function __construct(Grid $grid)
    {
        $this->grid = $grid;
    }

    /**
     * Shoot at a X/Y coordinate
     *
     * @param $y
     * @param $x
     * @return mixed
     */
    public function shoot($y, $x)
    {

        $map = $this->grid->getMatrix();

        if (!isset($map[$y][$x])) {
            return 'Error';
        }

        $state = $map[$y][$x];
        $shipSunk = false;

        switch ($state) {
            case '.':
                $this->grid->fillCoordinate($y, $x, '-');
                $this->grid->shots++;
                $message = 'Miss';
                break;
            case 'S':
                $this->grid->shots++;
                $this->grid->totalTargets--;
                $this->grid->fillCoordinate($y, $x, 'X');
                $shipSunk = $this->sunkShip($y, $x);
                $message = 'Hit';
                break;
            default:
                $message = 'Miss';
        }

        if ($shipSunk === true) {
            $message = 'Sunk';
        }

        //no more targets
        if ($this->grid->totalTargets === 0) {
            return true;
        }
        return $message;
    }

    /**
     * Checks if a ship has sank
     *
     * @param int $y
     * @param int $x
     * @return bool
     */
    public function sunkShip($y, $x)
    {
        foreach ($this->grid->shipPositions as $shipId => $shipPosition) {
            // skip ships that have already sunk
            if (count($shipPosition) === 0) {
                continue;
            }
            foreach ($shipPosition as $positionId => $position) {
                list($shipY, $shipX) = $position;
                if ($shipY == $y && $shipX == $x) {
                    unset($this->grid->shipPositions[$shipId][$positionId]);
                    return count($this->grid->shipPositions[$shipId]) === 0;
                }
            }
        }
        return false;
    }

    /**
     * Get shoot X coordinate
     * @param $x
     * @return int
     */
    public function getShootX($x)
    {
        $x = substr($x, 1, 2);
        return ((int)$x - 1);
    }

    /**
     * Get shoot Y coordinate
     * @param $y
     * @return int
     */
    public function getShootY($y)
    {
        $coordinateLetter = substr($y, 0, 1);
        return (ord(strtolower($coordinateLetter)) - 96) - 1;
    }
    
}
