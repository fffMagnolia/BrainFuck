<?php
function execute($filename) {
    try {
        $f = fopen($filename, "r");
        $cmd = prepare_cmd($f);
        $array = array(0);
        brainfuck($cmd, $array);
    }
    catch(Exception $e) { echo "ERROR: ".$e; }
}

//main
function brainfuck($cmd, $array) {
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
function prepare_cmd($f) {
    $bf_cmd = array(">", "<", "+", "-", "[", "]", ",", ".");
    $cmd = array();
    while(!feof($f)) {
        $c = fgetc($f);
        if(in_array($c, $bf_cmd)) array_push($cmd, $c);
    }
    return $cmd;
}

if(preg_match("/bf/", $argv[1]) == 1) {
    $filename = $argv[1];
    execute($filename);
}
else { echo "Please input bf file name. try again.\n"; }
