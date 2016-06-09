<?php 
	// TODO:  include the file that contains your functions
	include_once("loanFunctions.php");
	
    //set default value of variables for initial page load
    if (!isset($loan_amount)) { $loan_amount = ''; } 
    if (!isset($interest_rate)) { $interest_rate = ''; } 
    if (!isset($years)) { $years = ''; } 
	if (!isset($error_message)) { $error_message = ''; }
	if (!isset($payment_f)) { $payment_f = ''; }
	
	// TODO:  you'll need a variable to determine if the user wants to display the schedule
	if (!isset($wants_amortized)) {$wants_amortized = false;}
	if (!isset($schedule)) {$schedule = null;}
	
	
	
	if (count($_POST) > 0) //this checks the count of the post array tp determine if anything is in it
	{
		// get the data from the form
		$loan_amount = filter_input(INPUT_POST, 'loan_amount',
			FILTER_VALIDATE_FLOAT);
		$interest_rate = filter_input(INPUT_POST, 'interest_rate',
			FILTER_VALIDATE_FLOAT);
		$years = filter_input(INPUT_POST, 'years',
			FILTER_VALIDATE_INT);
		

		// validate loan amount
		if ($loan_amount === FALSE ) {
			$error_message = 'Loan amount must be a valid number.'; 
		} else if ( $loan_amount <= 0 ) {
			$error_message = 'Loan amount must be greater than zero.'; 
		// validate interest rate
		} else if ( $interest_rate === FALSE )  {
			$error_message = 'Interest rate must be a valid number.'; 
		} else if ( $interest_rate <= 0 ) {
			$error_message = 'Interest rate must be greater than zero.'; 
		// validate years
		} else if ( $years === FALSE ) {
			$error_message = 'Years must be a valid whole number.';
		} else if ( $years <= 0 ) {
			$error_message = 'Years must be greater than zero.';
		} else if ( $years > 30 ) {
			$error_message = 'Years must be less than 31.';
		// set error message to empty string if no invalid entries
		} else {
			$error_message = ''; 
		}

		// if everything is ok, do the calculations
		if ($error_message == '') 
		{	
			// calculate the payment
			$monthly_interest = ($interest_rate / 100) / 12;
			$number_of_payments = $years * 12;
			$payment = ( $monthly_interest * $loan_amount ) / ( 1 - pow((1 + $monthly_interest), -1 * $number_of_payments)); 

			// apply currency formatting ONLY to the result
			$payment_f = '$'.number_format($payment, 2);
			
			// TODO:  get the value from the display_schedule check_box
			// make sure that it contains either true or false
			$wants_amortized = filter_input(INPUT_POST, 'wants_amortized');
			if ($wants_amortized == 'on')
				$wants_amortized = true;
			else
				$wants_amortized = false;

			
			// TODO: if the user wants the schedule, call the function to fill the schedule array
			if ($wants_amortized)			
				$schedule = calculateSchedule($loan_amount, $interest_rate, $years, $payment);			
		}
	}
	
	// show the form on the page.  It will either display empty strings or the appropriate values
	include("view.php");
?> 
