<?php
/**
 * @author: Vova Lando <vova.lando@gmail.com>
 * @package: LoanPaymentsCalculator
 * @subpackage:
 * @created: 31/08/2017 16:55
 */

namespace cog\LoanPayments\Calculator\tests\PaymentSchedule;

use cog\LoanPaymentsCalculator\DateProvider\DateDetermineStrategy\ExactDayOfMonthStrategy;
use cog\LoanPaymentsCalculator\DateProvider\DateProvider;
use cog\LoanPaymentsCalculator\DateProvider\HolidayProvider\WeekendsProvider;
use cog\LoanPaymentsCalculator\PaymentSchedule\FixedPrincipalPaymentScheduleCalculator;
use cog\LoanPaymentsCalculator\Schedule\Schedule;
use PHPUnit\Framework\TestCase;

class FixedPrincipalPaymentScheduleCalculatorTest extends TestCase
{
    public function testCreateFixedPrincipalPaymentSchedule()
    {
        $startDate = new \DateTime('2016-08-08');
        $principalAmount = 500;
        $numberOfPeriods = 5;
        $dateProvider = new DateProvider(new ExactDayOfMonthStrategy(), new WeekendsProvider(), true);
        $schedule = new Schedule($startDate, $numberOfPeriods, $dateProvider);
        $schedulePeriods = $schedule->generatePeriods();

        $paymentSchedule = new FixedPrincipalPaymentScheduleCalculator($schedulePeriods, $principalAmount, 0.000383);
        $payments = $paymentSchedule->calculateSchedule();
        $paymentPrincipal = $principalAmount/$numberOfPeriods;

        $this->assertSame($numberOfPeriods, count($payments));
        $this->assertSame(18.039300000000001 , $paymentSchedule->getTotalInterest());
        for($i=0; $i<$numberOfPeriods; $i++) {
            $this->assertSame($paymentPrincipal, $payments[$i]->getPrincipal());
        }
    }

    public function testOneMonthFixedPrincipalPaymentSchedule()
    {
        $startDate = new \DateTime('2016-08-08');
        $dateProvider = new DateProvider(new ExactDayOfMonthStrategy(), new WeekendsProvider(), true);
        $schedule = new Schedule($startDate, 1, $dateProvider);
        $schedulePeriods = $schedule->generatePeriods();

        $paymentSchedule = new FixedPrincipalPaymentScheduleCalculator($schedulePeriods, 500, 0.000383);
        $payments = $paymentSchedule->calculateSchedule();
        $this->assertSame(1, count($payments));
        $this->assertSame($startDate, $payments[0]->getPeriod()->startDate);
        $this->assertSame(5.9365000000000006, $paymentSchedule->getTotalInterest());
    }
}
