<?php
// Access to all related functions
require __DIR__ . "/functions.php";
try {
	// Login Info
	$subdomain = "zccbaumgarth";
	// Username and Token are located in the callAPI function for sake of simplicity
	
	// Make sure the API is accessable
	$check = json_decode(callAPI("GET", url($subdomain), false), true)["tickets"];
	if (!is_array($check))
		throw new Exception("Failed to connect to API");
	
	// Make sure there are tickets to be seen
	$check = callAPI("GET", url($subdomain), false);
	if (str_contains($check, '"count":0'))
		throw new Exception("You have no tickets!");
	
	// Variables
	$ticketPages = getTicketPages($subdomain); // Total number of ticket pages from Zendesk
	$allTickets = combineTicketPages($ticketPages, $subdomain); // Array of all tickets
	$ticketCount = count($allTickets); // Total number of tickets
	$myPages = ceil($ticketCount/25); // Number of ticket display pages to be generated
	
	// Create and write the ticket display pages
	for ($i = 1; $i <= $myPages; $i++) {
		$nextFile = fopen("page" . $i . ".php", "w");
		fwrite($nextFile, '	<?php
							require __DIR__ . "/functions.php";
							$tickets = combineTicketPages(' . $ticketPages . ', "' . $subdomain . '");
							echo openHTML();
							echo build_body($tickets, ' . $myPages . ', ' . $i . ');
							echo closeHTML();
							?>');
	}
	
	// Redirect to first page of Tickets if current page is index
	if ((int) filter_var($_SERVER["SCRIPT_NAME"], FILTER_SANITIZE_NUMBER_INT) == 0)
		header("Location: page1.php");
}

catch (exception $e) {
    echo 'Uh oh, there was a problem: ',  $e->getMessage(), "\n";
}
?>