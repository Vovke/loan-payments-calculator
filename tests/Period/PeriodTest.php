<?php
/**
 * @author: Vova Lando <vova.lando@gmail.com>
 * @package: LoanPaymentsCalculator
 * @subpackage:
 * @created: 05/09/2017 15:10
 */

use cog\LoanPaymentsCalculator\Period\Period;
use PHPUnit\Framework\TestCase;

class PeriodTest extends TestCase
{
    public function testPeriodDiffDates()
    {
        $period = new Period(new DateTime('2017-01-05'), new DateTime('2017-02-05'));
        $this->assertEquals(31, $period->daysLength);
    }
}
