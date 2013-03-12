<?php

require_once __DIR__ . '/../QifGenerator.php';
require_once __DIR__ . '/../CashTransaction.php';

class QifGeneratorTest extends PHPUnit_Framework_TestCase {

	public function testAccountNameIsSetInConstructor() {
		$account_name = "Assets:Citibank Checking";
		$g = new QifGenerator($account_name);
		$this->assertEquals($account_name, $g->getAccountName());
	}
	
	public function testOutputIsValidEvenWhenThereAreNoTransactions() {
		$account_name = "Assets:Citibank Checking";
		$q = new QifGenerator($account_name);
		$expected = "!Account\r\n";
		$expected .= "NAssets:Citibank Checking\r\n";
		$expected .= "TCash\r\n";
		$expected .= "^\r\n";
		$this->assertEquals($expected, $q->toString());
	}

	public function testOutputIsValidWhenThereIsOneTransaction() {
		$t = new CashTransaction(-300.00, "2012-02-14", "Lufthansa", "Expenses:Travel");

		$account_name = "Assets:Citibank Checking";
		$q = new QifGenerator($account_name, array($t));

		$expected = "!Account\r\n";
		$expected .= "NAssets:Citibank Checking\r\n";
		$expected .= "TCash\r\n";
		$expected .= "^\r\n";
		$expected .= "!Type:Cash\r\n";
		$expected .= "D02/14/2012\r\n";
		$expected .= "PLufthansa\r\n";
		$expected .= "T-300.00\r\n";
		$expected .= "LExpenses:Travel\r\n";
		$expected .= "^\r\n";

		$this->assertEquals($expected, $q->toString());
	}

	public function testOutputIsValidWhenThereAreMultipleTransactions() {
		$t1 = new CashTransaction(-300.00, "2012-02-14", "Lufthansa", "Expenses:Travel");
		$t2 = new CashTransaction(-80.00, "2012-02-20", "Royal Highland Hotel", "Expenses:Travel");
		$account_name = "Assets:Citibank Checking";
		$q = new QifGenerator($account_name, array($t1, $t2));

		$expected = "!Account\r\n";
		$expected .= "NAssets:Citibank Checking\r\n";
		$expected .= "TCash\r\n";
		$expected .= "^\r\n";
		$expected .= "!Type:Cash\r\n";
		$expected .= "D02/14/2012\r\n";
		$expected .= "PLufthansa\r\n";
		$expected .= "T-300.00\r\n";
		$expected .= "LExpenses:Travel\r\n";
		$expected .= "^\r\n";
		$expected .= "!Type:Cash\r\n";
		$expected .= "D02/20/2012\r\n";
		$expected .= "PRoyal Highland Hotel\r\n";
		$expected .= "T-80.00\r\n";
		$expected .= "LExpenses:Travel\r\n";
		$expected .= "^\r\n";

		$this->assertEquals($expected, $q->toString());
	}

}
