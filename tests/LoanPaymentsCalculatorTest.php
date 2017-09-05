<?php
namespace cog\LoanPaymentsCalculator;

use PHPUnit\Framework\TestCase;

class LoanPaymentsCalculatorTest extends TestCase
{
    /**
     * @var LoanPaymentsCalculator
     */
    protected $skeleton;

    protected function setUp()
    {
        parent::setUp();
        $this->skeleton = new LoanPaymentsCalculator;
    }

    public function testNew()
    {
        $actual = $this->skeleton;
        $this->assertInstanceOf('\cog\LoanPaymentsCalculator\LoanPaymentsCalculator', $actual);
    }
}
