<?php

$board = array(
    array(
        '-',
        '-',
        '-'
    ),
    array(
        '-',
        '-',
        '-'
    ),
    array(
        '-',
        '-',
        '-'
    )
);

$current_player = 'X';
$game_over      = false;

function print_board($board)
{
    for ($i = 0; $i < 3; $i++) {
        for ($j = 0; $j < 3; $j++) {
            echo $board[$i][$j] . ' ';
        }
        echo "\n";
    }
}

function get_input($prompt)
{
    echo $prompt;
    $handle = fopen("php://stdin", "r");
    $input  = trim(fgets($handle));
    return $input;
}

function check_win($board)
{
    // Check rows for a win
    for ($i = 0; $i < 3; $i++) {
        if ($board[$i][0] != '-' && $board[$i][0] == $board[$i][1] && $board[$i][1] == $board[$i][2]) {
            return true;
        }
    }
    
    // Check columns for a win
    for ($j = 0; $j < 3; $j++) {
        if ($board[0][$j] != '-' && $board[0][$j] == $board[1][$j] && $board[1][$j] == $board[2][$j]) {
            return true;
        }
    }
    
    // Check diagonals for a win
    if ($board[0][0] != '-' && $board[0][0] == $board[1][1] && $board[1][1] == $board[2][2]) {
        return true;
    }
    
    if ($board[0][2] != '-' && $board[0][2] == $board[1][1] && $board[1][1] == $board[2][0]) {
        return true;
    }
    
    return false;
}

while (!$game_over) {
    echo "It's player $current_player's turn.\n";
    print_board($board);
    
    // Get player's move
    $row = (int) get_input("Enter row (1-3): ");
    $col = (int) get_input("Enter column (1-3): ");
    
    if ($board[$row - 1][$col - 1] != '-') {
        echo "That spot is already taken. Please choose another.\n";
        continue;
    }
    
    // Update board with player's move
    $board[$row - 1][$col - 1] = $current_player;
    
    // Check for win
    if (check_win($board)) {
        echo "Player $current_player wins!\n";
        $game_over = true;
    } else {
        // Switch players
        $current_player = $current_player == 'X' ? 'O' : 'X';
    }
    
    // Check for tie game
    $tie_game = true;
    for ($i = 0; $i < 3; $i++) {
        for ($j = 0; $j < 3; $j++) {
            if ($board[$i][$j] == '-') {
                $tie_game = false;
                break 2;
            }
        }
    }
    if ($tie_game) {
        echo "Tie game!\n";
        $game_over = true;
    }
}
