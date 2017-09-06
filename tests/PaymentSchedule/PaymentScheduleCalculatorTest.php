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
use cog\LoanPaymentsCalculator\PaymentSchedule\SimplePaymentScheduleCalculator;
use cog\LoanPaymentsCalculator\Schedule\Schedule;
use PHPUnit\Framework\TestCase;

class PaymentScheduleCalculatorTest extends TestCase
{
    public function testCreateSimplePaymentSchedule()
    {
        $startDate = new \DateTime('2016-08-08');
        $dateProvider = new DateProvider(new ExactDayOfMonthStrategy(), new WeekendsProvider(), true);
        $schedule = new Schedule($startDate, 5, $dateProvider);
        $schedulePeriods = $schedule->generatePeriods();

        $paymentSchedule = new SimplePaymentScheduleCalculator($schedulePeriods, 500, 0.000383);
        $payments = $paymentSchedule->calculateSchedule();
        $this->assertSame(5, count($payments));
        $this->assertSame(18.039300000000001 , $paymentSchedule->getTotalInterest());
    }

    public function testOneMonthPaymentSchedule()
    {
        $startDate = new \DateTime('2016-08-08');
        $dateProvider = new DateProvider(new ExactDayOfMonthStrategy(), new WeekendsProvider(), true);
        $schedule = new Schedule($startDate, 1, $dateProvider);
        $schedulePeriods = $schedule->generatePeriods();

        $paymentSchedule = new SimplePaymentScheduleCalculator($schedulePeriods, 500, 0.000383);
        $payments = $paymentSchedule->calculateSchedule();
        $this->assertSame(1, count($payments));
        $this->assertSame(5.9365000000000006, $paymentSchedule->getTotalInterest());
    }
}
