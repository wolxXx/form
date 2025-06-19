<?php

use AdamWathan\Form\Elements\Time;

class TimeTest extends PHPUnit_Framework_TestCase
{
    use InputContractTest;

    protected function newTestSubjectInstance($name)
    {
        return new Time($name);
    }

    protected function getTestSubjectType()
    {
        return 'time';
    }

    public function testDateTimeValuesAreBoundAsFormattedStrings()
    {
        $dateTimeLocal = new Time('dob');
        $dateTimeLocal->value(new DateTime('12-04-1988 10:33'));

        $expected = '<input type="time" name="dob" value="10:33">';
        $this->assertSame($expected, $dateTimeLocal->render());
    }

    public function testDateTimeDefaultValuesAreBoundAsFormattedStrings()
    {
        $dateTimeLocal = new Time('dob');
        $dateTimeLocal->defaultValue(new \DateTime('10:33'));

        $expected = '<input type="time" name="dob" value="10:33">';
        $this->assertSame($expected, $dateTimeLocal->render());
    }
}
