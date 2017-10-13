# Course 1DV610 L3

## Status
The game is not entirely finished, it works fine without buggs and will stop if game is over, however it will not tell you if you have won the game. Which means that you will play until you loose. Also it wont track your score, however you will still know what how far you've progressed due to the highest tile achieved.

## How To Install?
1. download [zipfile](https://github.com/ericbrena/610-assignment2/blob/master/Assignment-2.zip)
2. extract to webbhotel in root folder or run it on local server by typing: php -S localhost:8080 in your extracted folder.
3. due note that the file model/ConstNames.php has the url set to localhost:8080, if you wish it to be on another port or on a webbhotel you must change that url.

## How to test?
The game is called 2048 and you test it by playing it!<br /> 
You need to be logged in and once you are you get the choice of creating a new game. The game will show you 4 buttons to move around the tiles of numbers in the game.<br />
How the game actually works is that the direction you press will force all the tiles to go as far in that direction as they can, if they collide with a tile with equal value they will become one tile with the sum of their value.<br />
The goal is to reach 2048!

this is a link of reference how my game is meant to look like: http://gabrielecirulli.github.io/2048/
