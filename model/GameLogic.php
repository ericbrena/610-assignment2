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

        $newGameBoard = $this->generateNewBoard($gameBoard);

        return $newGameBoard;
    }

    /**
    * @return boolean, true if game over
    */
    public function controlGameOver($gameBoard) {
        $copyOfGameBoard = $gameBoard;

        //make all moves and attempt createnew number tile for each move
        //itis impossible for the game to generate same conditions after any sequence of moves
        //add a new number if there is room
        $copyOfGameBoard = $this->moveUp($copyOfGameBoard);
        if($this->getAmountEmptyTiles($copyOfGameBoard) > 0) {
            $copyOfGameBoard = $this->generateNewBoard($copyOfGameBoard);
        }

        $copyOfGameBoard = $this->moveRight($copyOfGameBoard);
        if($this->getAmountEmptyTiles($copyOfGameBoard) > 0) {
            $copyOfGameBoard = $this->generateNewBoard($copyOfGameBoard);
        }

        $copyOfGameBoard = $this->moveDown($copyOfGameBoard);
        if($this->getAmountEmptyTiles($copyOfGameBoard) > 0) {
            $copyOfGameBoard = $this->generateNewBoard($copyOfGameBoard);
        }

        $copyOfGameBoard = $this->moveLeft($copyOfGameBoard);

        return $this->analyzeBoardChange($gameBoard, $copyOfGameBoard);
    }
    
    public function getAmountEmptyTiles($gameBoard) {
        $availableTiles = 0;
        for($x = 0; $x < 4; $x++) {
            for($y = 0; $y < 4; $y++) {
                if($gameBoard[$x][$y] === null) {
                    $availableTiles += 1;
                }
            }
        }
        return $availableTiles;
    }

    /**
    * compare if x,y tile coordinates contain any different value,
    * if so the new board has made a new move
    * @return boolean, true if a new move has been made
    */
    public function analyzeBoardChange($oldBoard, $newBoard) {
        for($y = 0; $y < 4; $y++) {
            for($x = 0; $x < 4; $x++) {
                if($oldBoard[$y][$x] !== $newBoard[$y][$x]) {
                    return true;
                }
            }
        }
        return false;
    }

    /**
    * It adds another number to a random coordinate not occupied by another number
    * @return array, return old game board containing the new number
    */
    public function generateNewBoard($gameBoard) {
        $copyOfGameBoard = $gameBoard;

        //control all available coordinates
        $availableTiles = array();
        for($x = 0; $x < 4; $x++) {
            for($y = 0; $y < 4; $y++) {
                if($gameBoard[$x][$y] === null) {
                    $availableTiles[] = "" . $x . $y;
                }
            }
        }

        //generates 2 OR 4, 4 has 1/8 chance of trigger
        $newNumber = round(rand(0, 8));
        if($newNumber === 7) {
            $newNumber = 4;
        }
        else {
            $newNumber = 2;
        }

        //choose a random coordinate
        $chosenTile = round(rand(0, count($availableTiles) - 1));
        $x = substr($availableTiles[$chosenTile], 0, 1);
        $y = substr($availableTiles[$chosenTile], 1);

        //add new random number to choosen coordinate
        $copyOfGameBoard[$x][$y] = $newNumber;

        return $copyOfGameBoard;
    }

    //------------------------------------------------------------------------------------------
    //IMPORTANT! below is forced duplicated code due to difficulty of making generic code 
    //that can move and add numbers in a two dimensionall array to go to 4 different directions
    //------------------------------------------------------------------------------------------

    /**
    * Changes the values inside gameboard and move them up
    * @return array, array of modified gameboard
    */
    public function moveUp($gameBoard) {
        $copyOfGameBoard = $gameBoard;

        //goes through the x,y coordinates in the gameboard
        for($x = 0; $x < 4; $x++) {
            for($y = 0; $y < 4; $y++) {
                $index = $y;
                //if a tile contains a number, search for and identical number below of it
                if($copyOfGameBoard[$y][$x] !== null) {
                    while($index < 4) {
                        //if found a number not identical break sequence
                        if($copyOfGameBoard[$index][$x] !== null && $copyOfGameBoard[$index][$x] !== $copyOfGameBoard[$y][$x]) {
                            break;
                        }
                        //if found a number identical and not itself, add it to its own value and coordinate and remove the number
                        else if($copyOfGameBoard[$index][$x] !== null && $copyOfGameBoard[$index][$x] === $copyOfGameBoard[$index][$x] && $index !== $y) {
                            $copyOfGameBoard[$y][$x] = $copyOfGameBoard[$y][$x] + $copyOfGameBoard[$index][$x];
                            $copyOfGameBoard[$index][$x] = null;
                        }
                        $index += 1;
                    }
                }
            }
            //make numbers go to far top until struck wall or another number
            for($y = 0; $y < 4; $y++) {
                $index = $y;
                while($index > 0) {
                    if($copyOfGameBoard[$index][$x] !== null && $copyOfGameBoard[$index - 1][$x] === null) {
                        $copyOfGameBoard[$index - 1][$x] = $copyOfGameBoard[$index][$x];
                        $copyOfGameBoard[$index][$x] = null;
                    }
                    $index -= 1;
                }
            }
        }
        return $copyOfGameBoard;
    }

    /**
    * Changes the values inside gameboard and move them right
    * @return array, array of modified gameboard
    */
    public function moveRight($gameBoard) {
        $copyOfGameBoard = $gameBoard;

        //goes through the x,y coordinates in the gameboard
        for($y = 0; $y < 4; $y++) {
            for($x = 3; $x > -1; $x--) {
                $index = $x;
                //if a tile contains a number, search for and identical number left of it
                if($copyOfGameBoard[$y][$x] !== null) {
                    while($index > -1) {
                        //if found a number not identical break sequence
                        if($copyOfGameBoard[$y][$index] !== null && $copyOfGameBoard[$y][$index] !== $copyOfGameBoard[$y][$x]) {
                            break;
                        }
                        //if found a number identical and not itself, add it to its own value and coordinate and remove the number
                        else if($copyOfGameBoard[$y][$index] !== null && $copyOfGameBoard[$y][$index] === $copyOfGameBoard[$y][$x] && $index !== $x) {
                            $copyOfGameBoard[$y][$x] = $copyOfGameBoard[$y][$x] + $copyOfGameBoard[$y][$index];
                            $copyOfGameBoard[$y][$index] = null;
                        }
                        $index -= 1;
                    }
                }
            }
            //make numbers go to far right until struck wall or another number
            for($x = 3; $x > -1; $x--) {
                $index = $x;
                while($index < 3) {
                    if($copyOfGameBoard[$y][$index] !== null && $copyOfGameBoard[$y][$index + 1] === null) {
                        $copyOfGameBoard[$y][$index + 1] = $copyOfGameBoard[$y][$index];
                        $copyOfGameBoard[$y][$index] = null;
                    }
                    $index += 1;
                }
            }
        }
        return $copyOfGameBoard;
    }

    /**
    * Changes the values inside gameboard and move them down
    * @return array, array of modified gameboard
    */
    public function moveDown($gameBoard) {
        $copyOfGameBoard = $gameBoard;

        //goes through the x,y coordinates in the gameboard
        for($x = 0; $x < 4; $x++) {
            for($y = 3; $y > -1; $y--) {
                $index = $y;
                //if a tile contains a number, search for and identical number above it
                if($copyOfGameBoard[$y][$x] !== null) {
                    while($index > -1) {
                        //if found a number not identical break sequence
                        if($copyOfGameBoard[$index][$x] !== null && $copyOfGameBoard[$index][$x] !== $copyOfGameBoard[$y][$x]) {
                            break;
                        }
                        //if found a number identical and not itself, add it to its own value and coordinate and remove the number
                        else if($copyOfGameBoard[$index][$x] !== null && $copyOfGameBoard[$index][$x] === $copyOfGameBoard[$index][$x] && $index !== $y) {
                            $copyOfGameBoard[$y][$x] = $copyOfGameBoard[$y][$x] + $copyOfGameBoard[$index][$x];
                            $copyOfGameBoard[$index][$x] = null;
                        }
                        $index -= 1;
                    }
                }
            }
            //make numbers go to far bottom until struck wall or another number
            for($y = 3; $y > -1; $y--) {
                $index = $y;
                while($index < 3) {
                    if($copyOfGameBoard[$index][$x] !== null && $copyOfGameBoard[$index + 1][$x] === null) {
                        $copyOfGameBoard[$index + 1][$x] = $copyOfGameBoard[$index][$x];
                        $copyOfGameBoard[$index][$x] = null;
                    }
                    $index += 1;
                }
            }
        }
        return $copyOfGameBoard;
    }

    /**
    * Changes the values inside gameboard and move them them
    * @return array, array of modified gameboard
    */
    public function moveLeft($gameBoard) {
        $copyOfGameBoard = $gameBoard;
        
        //goes through the x,y coordinates in the gameboard
        for($y = 0; $y < 4; $y++) {
            for($x = 0; $x < 4; $x++) {
                $index = $x;
                //if a tile contains a number, search for and identical right of it
                if($copyOfGameBoard[$y][$x] !== null) {
                    while($index < 4) {
                        //if found a number not identical break sequence
                        if($copyOfGameBoard[$y][$index] !== null && $copyOfGameBoard[$y][$index] !== $copyOfGameBoard[$y][$x]) {
                            break;
                        }
                        //if found a number identical and not itself, add it to its own value and coordinate and remove the number
                        else if($copyOfGameBoard[$y][$index] !== null && $copyOfGameBoard[$y][$index] === $copyOfGameBoard[$y][$x] && $index !== $x) {
                            $copyOfGameBoard[$y][$x] = $copyOfGameBoard[$y][$x] + $copyOfGameBoard[$y][$index];
                            $copyOfGameBoard[$y][$index] = null;
                        }
                        $index += 1;
                    }
                }
            }
            //make numbers go to far left until struck wall or another number
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
}
