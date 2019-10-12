<?php
include('calculator.php');

class CalculatorTest{
    public function __construct(){
        SELF::testPlusCorrect();
        SELF::testDevideCorrect();
        SELF::testDevideZero();
    }
    public static function testPlusCorrect(){
        echo 'running '.__METHOD__.'<br>';
        $calc = new Calculator();
        $result = $calc->plus(10, 5);
        if($result==15){
            echo'passed'.'<hr>';
        }else{
            echo 'Failed expect int(15) result: '.gettype($result).'  '.$result.'<hr>';
        }
    }
    public static function testDevideCorrect(){
        echo 'running '.__METHOD__.'<br>';
        $calc = new Calculator();
        $result = $calc->devide(10, 5);
        if($result==2){
            echo'passed'.'<hr>';
        }else{
            echo 'Failed expect int(2) result: '.gettype($result).'  '.$result.'<hr>';
        }
    }
    public static function testDevideZero(){
        echo 'running '.__METHOD__.'<br>';
        $calc = new Calculator();
        $result = $calc->devide(10, 0);
        if($result==null){
            echo'passed'.'<hr>';
        }else{
            echo 'Failed expect int(15) result: '.gettype($result).'  '.$result.'<hr>';
        }
    }
}