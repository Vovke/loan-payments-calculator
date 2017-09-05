<?php
/**
 * @author: Vova Lando <vova.lando@gmail.com>
 * @package: LoanPaymentsCalculator
 * @subpackage:
 * @created: 15/06/2017 10:27
 */
namespace cog\LoanPayments\Calculator\tests\Schedule;

use cog\LoanPaymentsCalculator\DateProvider\DateDetermineStrategy\ExactDateStrategy;
use cog\LoanPaymentsCalculator\DateProvider\DateProvider;
use cog\LoanPaymentsCalculator\DateProvider\HolidayProvider\WeekendsProvider;
use cog\LoanPaymentsCalculator\Schedule\Schedule;
use PHPUnit\Framework\TestCase;

class ScheduleTest extends TestCase
{
    public function testCreateSimpleSchedule()
    {
        $now = new \DateTime();
        $dateProvider = new DateProvider(new ExactDateStrategy(), new WeekendsProvider(), true);
        $schedule = new Schedule($now, 12, $dateProvider);
        $periods = $schedule->generatePeriods();
        $this->assertSame(12, count($periods));
    }
}
