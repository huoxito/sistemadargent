<?php
class AllModelTest extends CakeTestSuite {
    public static function suite(){
        $suite = new CakeTestSuite('All Model Tests');
        $suite->addTestDirectory(TESTS . 'Case' . DS . 'models');
        return $suite;
    }
}
