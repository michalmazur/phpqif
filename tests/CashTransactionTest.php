<?php

require_once __DIR__ . '/../CashTransaction.php';

class CashTransactionTest extends PHPUnit_Framework_TestCase {
	
	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testPreventSettingInvalidDate() {
		$t = new CashTransaction(-300.00, "2012-30-30", "Lufthansa", "Expenses:Travel");
		$t->setDate("foo");
	}

	public function testDateShouldBeConvertedToUnitedStatesDateFormat() {
		$t = new CashTransaction(-300.00, "2012-02-14", "Lufthansa", "Expenses:Travel");
		$this->assertEquals("02/14/2012", $t->getDate());
	}

	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testAmountMustBeNumeric() {
		$t = new CashTransaction("invalid_amount", "2012-02-14", "Lufthansa", "Expenses:Travel");
	}
 	
	public function testAmountGetterReturnsAmountFormattedToTwoDecimalPlaces() {
		$t = new CashTransaction(300.00, "2012-02-14", "Lufthansa", "Expenses:Travel");
		$this->assertTrue("300.00" === $t->getAmount());
	}
	
	public function testToString() {
		$t = new CashTransaction(-300.00, "2012-02-14", "Lufthansa", "Expenses:Travel");
		$expected = "!Type:Cash\r\n";
		$expected .= "D02/14/2012\r\n";
		$expected .= "PLufthansa\r\n"; 
		$expected .= "T-300.00\r\n";
		$expected .= "LExpenses:Travel\r\n";
		$expected .= "^\r\n";
		$this->assertEquals($expected, $t->toString());
	}
	
}
