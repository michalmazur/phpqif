<?php

class QifGenerator {
		
	private $account_name = '';
	private $transactions = array();
	
	public function __construct($account_name, array $transactions = array()) {
		$this->account_name = $account_name;
		$this->transactions = $transactions;
	}

	public function getAccountName() {
		return $this->account_name;
	}
	
	public function toString() {
		$output = "!Account\r\n";
		$output .= "N{$this->account_name}\r\n";
		$output .= "TCash\r\n";
		$output .= "^\r\n";
		foreach ($this->transactions as $transaction) {
			$output .= $transaction->toString();
		}
		return $output;
	}
}
