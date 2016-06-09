<?php

	// TODO:  write the function that are empty
	function calculateMonthlyPayment($loan_amount, $interest_rate, $years)
	{
		$monthly_interest = ($interest_rate / 100) / 12;
		$number_of_payments = $years * 12;
		$payment = ( $monthly_interest * $loan_amount ) / ( 1 - pow((1 + $monthly_interest), -1 * $number_of_payments));
		
		return $payment;
	}
	
	function calculateMonthlyInterest($loan_amount, $interest_rate)
	{
		$monthly_interest = $loan_amount * $interest_rate / 1200;
		return $monthly_interest;
	}
	
	function calculateMonthlyScheduleLine($month_number, $payment, $interest_rate, &$balance, &$total_interest  )
	{
		// you'll have to uncomment this once you've written that method
		$monthly_interest = calculateMonthlyInterest($balance, $interest_rate);
		$total_interest += $monthly_interest;
		$principal = $payment - $monthly_interest;
		$balance = $balance - $principal;
		$line = array();
		$line["Month"] = $month_number;
		$line["Payment"] = $payment;
		$line["Principal"] = $principal;
		$line["Interest"] = $monthly_interest;
		$line["Total Interest"] = $total_interest;
		$line["Balance"] = $balance;
		
		return $line;
	}
	
	function calculateSchedule($loan_amount, $interest_rate, $years, $payment = null)
	{
		$sched = array();
		
		if ($payment == null)
			$payment = calculateMonthlyPayment($loan_amount, $interest_rate, $years);
		for ($i = 1; $i <= $years * 12; $i++)
		{
			$line = calculateMonthlyScheduleLine($i, $payment, $interest_rate, $loan_amount, $total_interest);
			$sched[$i-1] = $line;
		}
		return $sched;
		
	}
	
	function printSchedule($schedule)
	{
		echo "<table>";
		echo "<tr><th>Month</th><th>Monthly Payment</th><th>Principal Paid</th><th>Interest Paid</th><th>Total Interest</th><th>Remaining Balance</th></tr>";
		foreach ($schedule as $line)
		{
			echo "<tr>";
			echo "<td style='text-align: right'>" . $line["Month"] . "</td>";
			echo "<td style='text-align: right'>$" . number_format($line["Payment"], 2, ".", ",") . "</td>";
			echo "<td style='text-align: right'>$" . number_format($line["Principal"], 2, ".", ",") . "</td>";
			echo "<td style='text-align: right'>$" . number_format($line["Interest"], 2, ".", ",") . "</td>";
			echo "<td style='text-align: right'>$" . number_format($line["Total Interest"], 2, ".", ",") . "</td>";
			echo "<td style='text-align: right'>$" . number_format($line["Balance"], 2, ".", ",") . "</td>";
			echo "</tr>";
		}
		echo "</table>";
	}

	
	/*echo ("payment is: " . calculateMonthlyPayment(165000, 4, 30));
	
	$balance = 165000;
	$total_interest = 0;
	$line = calculateMonthlyScheduleLine(1, 787.735, 4, $balance, $total_interest);
	echo ("month 1 is: ");
	print_r($line);
	
	$schedule = calculateSchedule(165000, 4, 30);
	printSchedule($schedule);*/

?>
