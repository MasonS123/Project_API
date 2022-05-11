<?php
    session_start();
    $wordOfDay = "input"; //use other word abide to debug
    $guessWord = $_POST["userGuess"];
    $letterValidator = array(0, 0, 0, 0, 0);

    if (!isset($_SESSION["game"])) {
        $game = new Schmurdle($wordOfDay);
        $_SESSION["game"] = $game;
    } 
    
    $schmurdle = $_SESSION["game"];
    $schmurdle -> evaluateGuess($guessWord, $letterValidator);
    $letterArray = $schmurdle -> letterChecker;
    $arr = array("letterCheckerArray" => $letterArray);
    echo(json_encode($arr));
    class Schmurdle {
        public $wordOfDay;
        public $letterChecker;
        public $counter = 0;
        function __construct($wordOfDay) {
            $this->wordOfDay = $wordOfDay;
        }
        function evaluateGuess($guessWord, $letterValidator){
            $guessArray = array();
            $wordOfDayArray = array();
            $guessWordBoolArray = array(true, true, true, true, true);
            $wordOfDayBoolArray = array(true, true, true, true, true);
            for ($i=0; $i<strlen($this->wordOfDay); $i++){
                $wordOfDayArray[$i] = substr($this->wordOfDay, $i, 1);
            }
            for ($i=0; $i<strlen($this->wordOfDay); $i++){
                $guessArray[$i] = substr($guessWord, $i, 1);
            }
            for ($i=0; $i<strlen($this->wordOfDay); $i++) {
                if (strcmp($guessArray[$i], $wordOfDayArray[$i]) == 0) {
                    $letterValidator[$i] = 2; 
                    $wordOfDayBoolArray[$i] = false;
                    $guessWordBoolArray[$i] = false;
                } 
            }
            for ($i=0; $i<strlen($this->wordOfDay); $i++) {
                for ($j=0; $j<strlen($this->wordOfDay); $j++) {
                    if ($wordOfDayBoolArray[$i] && $guessWordBoolArray[$j]) {
                        if (strcmp($guessArray[$j], $wordOfDayArray[$i]) == 0 && $i != $j) {
                            $letterValidator[$j] = 1;
                            $wordOfDayBoolArray[$i] = false;
                            $guessWordBoolArray[$j] = false;
                        } 
                    } 
            }
            $this->letterChecker = $letterValidator;
        }
    }
    }
?>