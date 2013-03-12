<?php

class CashTransaction {
	
	private $amount;	
	private $date;
	private $payee;
	private $category;
	
	public function __construct($amount, $date, $payee = '', $category = '') {
		$this->setDate($date);
		$this->setAmount($amount);
		$this->payee = $payee;
		$this->category = $category;
	}
	
	private function setDate($date) {
		$timestamp = strtotime($date);
		if ($timestamp) {
			/*
			 * The only reason why the m/d/y format is used is that whenever GnuCash cannot
			 * determine the date format automatically it suggests m/d/y first.
			 */
			$this->date = date('m/d/Y', strtotime($date));
		} else {
			throw new InvalidArgumentException("Invalid date.");
		}
	}
	
	public function getDate() {
		return $this->date;
	}
	
	private function setAmount($amount) {
		if (!is_numeric($amount)) {
			throw new InvalidArgumentException("Amount must be numeric.");
		}
		$this->amount = number_format($amount, 2);
	}
	
	public function getAmount() {
		return $this->amount;
	}
	
	public function toString() {
		$output = "!Type:Cash\r\n";
		$output .= "D{$this->date}\r\n";
		$output .= "P{$this->payee}\r\n";
		$output .= "T{$this->amount}\r\n";
		$output .= "L{$this->category}\r\n";
		$output .= "^\r\n";
		return $output;
	}
}
