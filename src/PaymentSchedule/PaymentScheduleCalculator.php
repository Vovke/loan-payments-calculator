<?php
/**
 * @author: Vova Lando <vova.lando@gmail.com>
 * @package: LoanPaymentsCalculator
 * @subpackage:
 * @created: 05/09/2017 16:55
 */

namespace cog\LoanPaymentsCalculator\PaymentSchedule;


interface PaymentScheduleCalculator
{
    public function calculateSchedule();
}