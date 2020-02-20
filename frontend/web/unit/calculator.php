<?php

class calculator {
    public function plus($a, $b){
        return $a+$b;
    }
    public function devide($a, $b){
        if($b == 0){
            return null;
        }
        return $a/$b;
    }
}
