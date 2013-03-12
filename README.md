Overview
========
phpQIF is a tiny library for outputting financial data in QIF format.

phpQIF's output is intended to be easily imported into GnuCash. Currently, only cash accounts are supported. Support for other types of accounts will be added on an as-needed basis.

Usage
=====

    <?php
    $qif_generator = new QifGenerator(
    	"Assets:Cash in Wallet",
    	array(
    		new CashTransaction(-3.99, "2012-11-22", "Milkshake", "Expenses:Dining"),
    		new CashTransaction(-1.79, "2012-11-24", "Italian bread", "Expenses:Groceries")
    	)
    );
    echo $qif_generator->toString();

outputs:

    !Account
    NAssets:Cash in Wallet
    TCash
    ^
    !Type:Cash
    D11/22/2012
    PMilkshake
    T-3.99
    LExpenses:Dining
    ^
    !Type:Cash
    D11/24/2012
    PItalian bread
    T-1.79
    LExpenses:Groceries
    ^

