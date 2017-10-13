<?php

class GameView {
    public function generateGameHTML($gameBoard, $userLost) {
        $response = "";
        if($userLost === true) {
            $response .= $this->generateLostMessageHTML();
        }

        $response .= $this->gameHTML($gameBoard);
        $response .= $this->gameButtonsHTML();
		
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
        <form  method="post" >
            <input type="submit" name="' . ConstNames::gameMoveUp . '" value="Up"/>
        </form>
        <form  method="post" >
            <input type="submit" name="' . ConstNames::gameMoveRight . '" value="Right"/>
        </form>
        <form  method="post" >
            <input type="submit" name="' . ConstNames::gameMoveDown . '" value="Down"/>
        </form>
        <form  method="post" >
            <input type="submit" name="' . ConstNames::gameMoveLeft . '" value="Left"/>
        </form>
        ';
    }

    private function generateLostMessageHTML() {
        return '
        <p>You Lost!</p>
        ';
    }
}