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

    public function controlGameOver($gameBoard) {
        $copyOfGameBoard = $gameBoard;

        $copyOfGameBoard = $this->moveUp($copyOfGameBoard);
        $copyOfGameBoard = $this->moveRight($copyOfGameBoard);
        $copyOfGameBoard = $this->moveDown($copyOfGameBoard);
        $copyOfGameBoard = $this->moveLeft($copyOfGameBoard);

        for($x = 0; $x < 4; $x++) {
            for($y = 0; $y < 4; $y++) {
                if($copyOfGameBoard[$x][$y] !== $gameBoard[$x][$y]) {
                    $userLost = false;
                }
            }
        }
        return true;
    }

    public function moveUp($gameBoard) {
        $copyOfGameBoard = $gameBoard;

        for($x = 0; $x < 4; $x++) {
            for($y = 1; $y < 4; $y++) {
                $index = $y;
                while($index === 0 || $copyOfGameBoard[$x][$index] !== $copyOfGameBoard[$x][$index - 1]) {
                    if($copyOfGameBoard[$x][$index - 1] === null) {
                        $copyOfGameBoard[$x][$index - 1] = $copyOfGameBoard[$x][$index];
                        $index -= 1;
                    } 
                    else if($copyOfGameBoard[$x][$index - 1] === $copyOfGameBoard[$x][$index]) {
                        $copyOfGameBoard[$x][$index - 1] = $copyOfGameBoard[$x][$index - 1] + $copyOfGameBoard[$x][$index];
                        $index -= 1;
                    }
                }
            }
        }

        return $copyOfGameBoard;
    }

    public function moveRight($gameBoard) {
        $copyOfGameBoard = $gameBoard;
        
        return $copyOfGameBoard;
    }

    public function moveDown($gameBoard) {
        $copyOfGameBoard = $gameBoard;
        
        return $copyOfGameBoard;
    }

    public function moveLeft($gameBoard) {
        $copyOfGameBoard = $gameBoard;
        
        return $copyOfGameBoard;
    }

    public function generateNewRandomTile($gameBoard) {
        $copyOfGameBoard = $gameBoard;

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
        $newNumber = round(rand(1, 2)) * 2;

        $chosenTile = round(rand(0, count($availableTiles) - 1));
        $x = substr($availableTiles[$chosenTile], 0, 1);
        $y = substr($availableTiles[$chosenTile], 1);

        $copyOfGameBoard[$x][$y] = $newNumber;

        return $copyOfGameBoard;
    }
}