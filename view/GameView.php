<?php

class GameView {
    public function generateGameHTML($gameBoard, $gameNotOver) {
        $response = "";
        $response .= $this->gameHTML($gameBoard);

        if($gameNotOver === false) {
            $response .= $this->generateLostMessageHTML();
        } else {
            $response .= $this->gameButtonsHTML();
        }
		
		return $response;
    }
    
    private function gameHTML($gameBoard) {
        return '
        <table>
        <tr>
            <td>'. $gameBoard[0][0] .'</td>
            <td>'. $gameBoard[0][1] .'</td>
            <td>'. $gameBoard[0][2] .'</td>
            <td>'. $gameBoard[0][3] .'</td>
        </tr>
        <tr>
            <td>'. $gameBoard[1][0] .'</td>
            <td>'. $gameBoard[1][1] .'</td>
            <td>'. $gameBoard[1][2] .'</td>
            <td>'. $gameBoard[1][3] .'</td>
        </tr>
        <tr>
            <td>'. $gameBoard[2][0] .'</td>
            <td>'. $gameBoard[2][1] .'</td>
            <td>'. $gameBoard[2][2] .'</td>
            <td>'. $gameBoard[2][3] .'</td>
        </tr>
        <tr>
            <td>'. $gameBoard[3][0] .'</td>
            <td>'. $gameBoard[3][1] .'</td>
            <td>'. $gameBoard[3][2] .'</td>
            <td>'. $gameBoard[3][3] .'</td>
        </tr>
        </table>
        ';
    }

    private function gameButtonsHTML() {
        return '
        <div id="'. ConstNames::buttonWrapper .'">
            <form  method="post" id="'. ConstNames::upperButton .'">
                <input type="submit" name="' . ConstNames::gameMoveUp . '" value="Up"/>
            </form>
            <div>
            <form  method="post" class="'. ConstNames::lowerButtons .'">
                <input type="submit" name="' . ConstNames::gameMoveLeft . '" value="Left"/>
            </form>
            <form  method="post" class="'. ConstNames::lowerButtons .'">
                <input type="submit" name="' . ConstNames::gameMoveDown . '" value="Down"/>
            </form>
            <form  method="post" class="'. ConstNames::lowerButtons .'">
                <input type="submit" name="' . ConstNames::gameMoveRight . '" value="Right"/>
            </form>
            </div>
        </div>
        ';
    }

    private function generateLostMessageHTML() {
        return '
        <p>You Lost!</p>
        ';
    }
}