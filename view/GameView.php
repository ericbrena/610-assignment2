<?php

class GameView {
    public function generateGameHTML($gameBoard, $userLost) {
        $response = "";
        if($userLost) {
            $response .= $this->generateLostMessage();
        }

        $response .= $this->gameHTML($gameBoard);
        $response .= $this->gameButtons();
		
		return $response;
    }
    
    private function gameHTML($gameBoard) {
        return '
        <tr>
            <td>'. $gameInfo[0][0] .'</td>
            <td>'. $gameInfo[0][1] .'</td>
            <td>'. $gameInfo[0][2] .'</td>
            <td>'. $gameInfo[0][3] .'</td>
        </tr>
        <tr>
            <td>'. $gameInfo[1][0] .'</td>
            <td>'. $gameInfo[1][1] .'</td>
            <td>'. $gameInfo[1][2] .'</td>
            <td>'. $gameInfo[1][3] .'</td>
        </tr>
        <tr>
            <td>'. $gameInfo[2][0] .'</td>
            <td>'. $gameInfo[2][1] .'</td>
            <td>'. $gameInfo[2][2] .'</td>
            <td>'. $gameInfo[2][3] .'</td>
        </tr>
        <tr>
            <td>'. $gameInfo[3][0] .'</td>
            <td>'. $gameInfo[3][1] .'</td>
            <td>'. $gameInfo[3][2] .'</td>
            <td>'. $gameInfo[3][3] .'</td>
        </tr>
        ';
    }
}