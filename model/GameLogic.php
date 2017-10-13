<?php

class GameLogic {
    public function createNewGame() {

        //creates a two dimensional array representing a 4x4 game board
        $gameBoard = array(array(), array(), array(), array());

        //fill gameBoard of empty tiles
        for($x = 0; $x < 4; $x++){
            for($y = 0; $y < 4; $y++) {
                $gameBoard[$x][$y] = null;
            }
        }

        $newGameBoard = $this->generateNewRandomTile($gameBoard);
        
        return $newGameBoard;
    }

    public function moveUp($gameBoard) {
        return $updatedGameBoard;
    }

    public function moveRight($gameBoard) {
        return $updatedGameBoard;
    }

    public function moveDown($gameBoard) {
        return $updatedGameBoard;
    }

    public function moveLeft($gameBoard) {
        return $updatedGameBoard;
    }

    public function generateNewRandomTile($gameBoard) {
        //control all available tiles
        $availableTiles = array();
        for($x = 0; $x < 4; $x++) {
            for($y = 0; $y < 4; $y++) {
                if($gameBoard[$x][$y] === null) {
                    $availableTiles[] = "" . $x . $y;
                }
            }
        }

        //generates 2 OR 4
        $newNumber = round(rand(0, 1)) * 2;

        $chosenTile = round(rand(0, count($availableTiles)));
        $x = substr($availableTiles[$chosenTile], 0, 1);
        $y = substr($availableTiles[$chosenTile], 1);

        $updatedGameBoard[$x][$y] = $newNumber;

        return $updatedGameBoard;
    }
}