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
use cog\LoanPaymentsCalculator\Payment\Payment;
use cog\LoanPaymentsCalculator\PaymentSchedule\EqualPrincipalPaymentScheduleCalculator;
use cog\LoanPaymentsCalculator\Schedule\Schedule;
use PHPUnit\Framework\TestCase;

class EqualPrincipalPaymentScheduleCalculatorTest extends TestCase
{
    public function testCreateFixedPrincipalPaymentSchedule()
    {
        $startDate = new \DateTime('2016-08-08');
        $principalAmount = 500;
        $numberOfPeriods = 5;
        $dateProvider = new DateProvider(new ExactDayOfMonthStrategy(), new WeekendsProvider(), true);
        $schedule = new Schedule($startDate, $numberOfPeriods, $dateProvider);
        $schedulePeriods = $schedule->generatePeriods();

        $paymentSchedule = new EqualPrincipalPaymentScheduleCalculator($schedulePeriods, $principalAmount, 0.000383);
        $payments = $paymentSchedule->calculateSchedule();
        $paymentPrincipal = $principalAmount/$numberOfPeriods;

        $this->assertSame($numberOfPeriods, count($payments));
        $this->assertSame(18.039300000000001 , $paymentSchedule->getTotalInterest());
        for($i=0; $i<$numberOfPeriods; $i++) {
            $this->assertSame($paymentPrincipal, $payments[$i]->getPrincipal());
        }

        $this->printSchedule($payments);
    }

    public function testOneMonthFixedPrincipalPaymentSchedule()
    {
        $startDate = new \DateTime('2016-08-08');
        $dateProvider = new DateProvider(new ExactDayOfMonthStrategy(), new WeekendsProvider(), true);
        $schedule = new Schedule($startDate, 1, $dateProvider);
        $schedulePeriods = $schedule->generatePeriods();

        $paymentSchedule = new EqualPrincipalPaymentScheduleCalculator($schedulePeriods, 500, 0.000383);
        $payments = $paymentSchedule->calculateSchedule();
        $this->assertSame(1, count($payments));
        $this->assertSame($startDate, $payments[0]->getPeriod()->startDate);
        $this->assertSame(5.9365000000000006, $paymentSchedule->getTotalInterest());

        $this->printSchedule($payments);
    }

    /**
     * @param Payment[] $payments
     */
    private function printSchedule($payments)
    {
        print(PHP_EOL);
        for($i=0; $i<count($payments); $i++) {
            print("------------------------- Payment #" . $i . " -------------------------".  PHP_EOL);
            print("DueDate: " . $payments[$i]->getPeriod()->endDate->format('Y-m-d').  PHP_EOL);
            print("Period in days: " . $payments[$i]->getPeriod()->daysLength.  PHP_EOL);
            print("Payment Principal: ". $payments[$i]->getPrincipal().  PHP_EOL);
            print("Payment Interest: " . $payments[$i]->getInterest().  PHP_EOL);
            print("Principal left: " . $payments[$i]->getPrincipalBalanceLeft().  PHP_EOL);
        }
        print(PHP_EOL);
    }
}
