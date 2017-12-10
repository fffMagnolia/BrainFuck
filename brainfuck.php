<?php

class BrainFuck {
    //init
    private $cmd = '';
    private $array = array(0);
    
    public function __construct($filename) {
        if(preg_match('/.+.bf/', $filename) === 0) {
            exit("This file is not found.");
        }
        else {
            $this->setCmd(fopen($filename, 'r'));
            $this->execute($this->cmd, $this->array);
        }
    }

    public function setCmd($f) {
        $bf_cmd = array(">", "<", "+", "-", "[", "]", ",", ".");
        $cmd = array();
        while(!feof($f)) {
            $c = fgetc($f);
            if(in_array($c, $bf_cmd)) array_push($cmd, $c);
        }
        $this->cmd = $cmd;
    }

    //main
    public function execute($cmd, $array) {
        $ap = 0;
        for($cp = 0; $cp < count($cmd); $cp++) {
            if($cmd[$cp] == "+") {
                if($array[$ap] > PHP_INT_MAX) {
                    $array[$ap] = PHP_INT_MAX;
                }
                else {
                    $array[$ap]++;
                }
            }
            if($cmd[$cp] == "-") {
                if($array[$ap] < PHP_INT_MIN) {
                    $array[$ap] = PHP_INT_MIN;
                }
                else {
                    $array[$ap]--;
                }
            }
            if($cmd[$cp] == ">") {
                $ap++;
                if($ap == count($array)) array_push($array, 0);
            }
            if($cmd[$cp] == "<") {
                if($ap <= 0) $ap = count($array) - 1;
                $ap--;
            }
            if($cmd[$cp] == ".") echo chr($array[$ap]);
            if($cmd[$cp] == ",") echo fgetc(STDIN);
            if($cmd[$cp] == "[" && $array[$ap] == 0) while($cmd[$cp] != "]") $cp++;
            if($cmd[$cp] == "]" && $array[$ap] != 0) while($cmd[$cp] != "[") $cp--;
        }
    }
}
