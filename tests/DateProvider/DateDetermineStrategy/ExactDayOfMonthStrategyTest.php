<?php
/**
 * @author: Vova Lando <vova.lando@gmail.com>
 * @package: LoanPaymentsCalculator
 * @subpackage:
 * @created: 05/09/2017 14:54
 */

use cog\LoanPaymentsCalculator\DateProvider\DateDetermineStrategy\ExactDayOfMonthStrategy;
use PHPUnit\Framework\TestCase;

class ExactDayOfMonthStrategyTest extends TestCase
{
    public function testNextDateIsSameDay()
    {
        $dateStrategy = new ExactDayOfMonthStrategy();
        $this->assertEquals(new DateTime('2017-08-05'), $dateStrategy->calculateNextDate(new DateTime('2017-07-05')));
    }
}
