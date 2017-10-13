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

        

        return $copyOfGameBoard;
    }

    public function moveRight($gameBoard) {
        $copyOfGameBoard = $gameBoard;
        /**
        for($y = 0; $y < 4; $y++) {
            for($x = 2; $x > 0; $x--) {
                $index = $x;
                while($index === 0 || $copyOfGameBoard[$x][$y] !== $copyOfGameBoard[$x + 1][$y]) {
                    if($copyOfGameBoard[$x + 1][$index] === null) {
                        $copyOfGameBoard[$x + 1][$index] = $copyOfGameBoard[$x][$index];
                        $index += 1;
                    } 
                    else if($copyOfGameBoard[$x + 1][$index] === $copyOfGameBoard[$x][$index]) {
                        $copyOfGameBoard[$x + 1][$index] = $copyOfGameBoard[$x + 1][$index] + $copyOfGameBoard[$x][$index];
                        $index += 1;
                    }
                }
            }
        }*/

        return $copyOfGameBoard;
    }

    public function moveDown($gameBoard) {
        $copyOfGameBoard = $gameBoard;

        echo("adsd");

        for($x = 0; $x < 4; $x++) {
            for($y = 0; $y < 4; $y++) {
                $index = $y;
                if($copyOfGameBoard[$y][$x] !== null) {
                    while($index < 4) {
                        if($copyOfGameBoard[$y][$index] !== null && $copyOfGameBoard[$y][$index] !== $copyOfGameBoard[$y][$x]) {
                            break;
                        }
                        else if($copyOfGameBoard[$y][$index] !== null && $copyOfGameBoard[$y][$index] === $copyOfGameBoard[$y][$x] && $index !== $x) {
                            $copyOfGameBoard[$y][$x] = $copyOfGameBoard[$y][$x] + $copyOfGameBoard[$y][$index];
                            $copyOfGameBoard[$y][$index] = null;
                        }
                        $index += 1;
                    }
                }
            }
            for($y = 0; $y < 4; $y++) {
                $index = $y;
                while($index > 0) {
                    if($copyOfGameBoard[$y][$index] !== null && $copyOfGameBoard[$y][$index - 1] === null) {
                        $copyOfGameBoard[$y][$index - 1] = $copyOfGameBoard[$y][$index];
                        $copyOfGameBoard[$y][$index] = null;
                    }
                    $index -= 1;
                }
            }
        }
        
        return $copyOfGameBoard;
    }

    public function moveLeft($gameBoard) {
        $copyOfGameBoard = $gameBoard;
        
        for($y = 0; $y < 4; $y++) {
            for($x = 0; $x < 4; $x++) {
                $index = $x;
                if($copyOfGameBoard[$y][$x] !== null) {
                    while($index < 4) {
                        if($copyOfGameBoard[$y][$index] !== null && $copyOfGameBoard[$y][$index] !== $copyOfGameBoard[$y][$x]) {
                            break;
                        }
                        else if($copyOfGameBoard[$y][$index] !== null && $copyOfGameBoard[$y][$index] === $copyOfGameBoard[$y][$x] && $index !== $x) {
                            $copyOfGameBoard[$y][$x] = $copyOfGameBoard[$y][$x] + $copyOfGameBoard[$y][$index];
                            $copyOfGameBoard[$y][$index] = null;
                        }
                        $index += 1;
                    }
                }
            }
            for($x = 0; $x < 4; $x++) {
                $index = $x;
                while($index > 0) {
                    if($copyOfGameBoard[$y][$index] !== null && $copyOfGameBoard[$y][$index - 1] === null) {
                        $copyOfGameBoard[$y][$index - 1] = $copyOfGameBoard[$y][$index];
                        $copyOfGameBoard[$y][$index] = null;
                    }
                    $index -= 1;
                }
            }
        }

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
        $newNumber = round(rand(0, 8));
        if($newNumber === 7) {
            $newNumber = 4;
        }
        else {
            $newNumber = 2;
        }

        $chosenTile = round(rand(0, count($availableTiles) - 1));
        $x = substr($availableTiles[$chosenTile], 0, 1);
        $y = substr($availableTiles[$chosenTile], 1);

        $copyOfGameBoard[$x][$y] = $newNumber;

        return $copyOfGameBoard;
    }
}