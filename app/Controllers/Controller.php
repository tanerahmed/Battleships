<?php

namespace App\Controllers;

use App\Models\Grid;
use App\Models\Ship;
use App\Views\View;


class Controller
{
    /**
     * Play the game
     * @return Grid
     */
    public function gameStart()
    {
        //TODO write in config file or constants!
        $width = 10;
        $height = 10;
        $shipSize = 5;
        $boatSize = 4;

        $grid = new Grid($width, $height);
        $grid
                ->setShip(new Ship('Destroyer', $boatSize))
                ->setShip(new Ship('Destroyer2', $boatSize))
                ->setShip(new Ship('BattleShip', $shipSize));
        $grid
                ->calculateMaxTargets()
                ->generateGrid()
                ->populateGrid();

        return $grid;
    }

	/**
     * Display the game grid
     * @param Grid $grid
     * @param $show
     * @return string
     */
    public function displayGrid(Grid $grid, $show)
    {
        $matrix = $grid->getMatrix();
        $alphabet = range('A', 'Z');
        $display = "\n\n";

        if (!empty($matrix)) {
            foreach ($matrix as $rowKey => $row) {
                if ($rowKey == 0) {
                    $display .= '  ';
                    for ($counter = 1; $counter <= 10; $counter++) {
                        $display .= $counter . '  ';
                    }
                }
                $display .= "\n";
                foreach ($row as $colKey => $col) {
                    if ($colKey == 0) {
                        $display .= $alphabet[$rowKey] . ' ';
                    }
                    $this->drawElements($display, $col, $show);
                }
            }
        }
        $display .= "\n\n";

        return $display;
    }

    /**
     * Draw ships and game elements for cheat and normal mode
     * @param string $display
     * @param string $element
     * @param bool $show
     */
    public function drawElements(&$display, $element, $show)
    {
        if ($element == 'S') {
            if ($show) {
                $display .= 'X' . '  ';
            } else {
                $display .= '.' . '  ';
            }
        } else {
            if ($show) {
                $display .= '   ';
            } else {
                $display .= $element . '  ';
            }
        }
    }

}
