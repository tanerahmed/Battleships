# battleshipsProgramming Test: Battle ships 
The purpose of this test is primarily to examine your problem solving skills.

Please follow this spec carefully!

You must write the game as a simple application with web and console user interfaces using shared game logic in the language requested. In the case of PHP developer should create a index.php file which loads (requires) the appropriate controller and logic.

In addition to working code that follows this spec you are expected to make your code elegant / beautiful and the best you can do, i.e. separation of logic / object oriented abstraction. Comment your code as necessary.
The Problem
Implement a simple game of battleships http://en.wikipedia.org/wiki/Battleship_(game) Please see example here http://www.techhuddle.com/tests/battleships/v4/index.php

You must create a simple application to allow a single human player to play a one-sided game of battleships against the computer.

The program should create a 10x10 grid, and place a number of ships on the grid at random with the following sizes:
•	1 x Battleship (5 squares)
•	2 x Destroyers (4 squares)
Ships can touch but they must not overlap.

The application should accept input from the user in the format “A5” to signify a square to target, and feedback to the user whether the shot was success, miss, and additionally report on the sinking of any vessels.
. = no shot
- = miss
X = hit

Example output

*** Miss ***

  1 2 3 4 5 6 7 8 9 10
A - . . . . . . . . .
B . . . . . . . . . .
C . . . . . . . . . .
D . . . . . . . . . .
E . . . . . . . . . .
F . . . . . . . . . .
G . . . . . . . . . .
H . . . . . . . . . .
I . . . . . . . . . .
J . . . . . . . . . .

Enter coordinates (row, col), e.g. A5 = 
You should implement a show command to aid debugging and backdoor cheat. Example output after entering show

  1 2 3 4 5 6 7 8 9 10
A             X   
B             X   
C     X       X   
D     X       X   
E     X       X   
F     X       
G           
H           
I             X X X X
J           

Enter coordinates (row, col), e.g. A5 =

Please report the number of shots taken once game complete, e.g.

*** Sunk ***

  1 2 3 4 5 6 7 8 9 10
A . . . . . . X . . .
B . . . . . . X . . .
C . . X . . . X . . .
D . . X . . . X . . .
E . . X . . . X . . .
F . . X . . . . . . .
G . . . . . . . . . .
H . . . . . . . . . .
I . . . . . – X X X X
J . . . . . . . . . .

Well done! You completed the game in 14 shots


Please email your finished solution zipped up (without binaries and in .zip format not .rar, .7z, etc.)
