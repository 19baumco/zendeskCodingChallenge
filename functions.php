<?php
// Provides the opening HTML code along with the page header and style sheet reference
function openHTML() {
	return '
	<!DOCTYPE html>
	<html lang="en">
	<meta charset="UTF-8">
	<title>Baumgarth Zendesk CC</title>
	<link rel="stylesheet" href="style.css">
	<body>
		<h1>Online Ticket Viewer</h1>
		<div class="main">
	';
}
// Provides the closing HTML code along with the JavaScript for the dropdown ticket menus
function closeHTML() {
	return '
		</div>
		<script>
		var col = document.getElementsByClassName("ticket");
		var i;
		for (i = 0; i < col.length; i++) {
			col[i].addEventListener("click", function() {
				this.classList.toggle("active");
				var content = this.nextElementSibling;
				if (content.style.maxHeight){
					content.style.maxHeight = null;
				} else {
					content.style.maxHeight = content.scrollHeight + "px";
				} 
			});
		}
		</script>
	</body>
	</html>
	';
}
// Returns the number of tickets on the current page
function currentTicketCount($pages, $page, $count) {
	if ($pages != $page)
		return 25;
	else
		return $count-(25*($pages-1));
}
// Handles the generation of the pagination (page navigation)
// Displays previous and next page arrows, first and last page buttons, and the 5 pages nearest the current page
function pagination($pages, $page) {
	$html = "<div class='pagination'>";
	if ($page != 1)
		$html .= "<a href='page" . $page-1 . ".php'><button class='arrow'>" . "◀" . "</button></a>";
	else
		$html .= "<button class='noclick arrow'>" . "◀" . "</button>";
	
	if ($pages <=	 9)
		for ($i = 1; $i <= $pages; $i++) {
			if ($i != $page)
				$html .= "<a href='page" . $i . ".php'><button>" . $i . "</button></a>";
			else
				$html .= '<button class="cPage">' . $i . "</button>";
		}
	else {
		if ($page <= 5) {
			for ($i = 1; $i <= 7; $i++) {
				if ($i != $page)
					$html .= "<a href='page" . $i . ".php'><button>" . $i . "</button></a>";
				else
					$html .= '<button class="cPage">' . $i . "</button>";
			}
			$html .= "<button class='noclick'>" . "<b>...</b>" . "</button>";
			$html .= "<a href='page" . $pages . ".php'><button>" . $pages . "</button></a>";
		}
		else if ($page >= $pages-4) {
			$html .= "<a href='page" . 1 . ".php'><button>" . 1 . "</button></a>";
			$html .= "<button class='noclick'>" . "<b>...</b>" . "</button>";
			for ($i = $pages-6; $i <= $pages; $i++) {
				if ($i != $page)
					$html .= "<a href='page" . $i . ".php'><button>" . $i . "</button></a>";
				else
					$html .= '<button class="cPage">' . $i . "</button>";
			}
		}
		else {
			$html .= "<a href='page" . 1 . ".php'><button>" . 1 . "</button></a>";
			$html .= "<button class='noclick'>" . "<b>...</b>" . "</button>";
			$html .= "<a href='page" . $page-2 . ".php'><button>" . $page-2 . "</button></a>";
			$html .= "<a href='page" . $page-1 . ".php'><button>" . $page-1 . "</button></a>";
			$html .= '<button class="cPage">' . $page . "</button>";
			$html .= "<a href='page" . $page+1 . ".php'><button>" . $page+1 . "</button></a>";
			$html .= "<a href='page" . $page+2 . ".php'><button>" . $page+2 . "</button></a>";
			$html .= "<button class='noclick'>" . "<b>...</b>" . "</button>";
			$html .= "<a href='page" . $pages . ".php'><button>" . $pages . "</button></a>";
		}
	}
	
	if ($page != $pages)
		$html .= "<a href='page" . $page+1 . ".php'><button class='arrow'>" . "▶" . "</button></a></div>";
	else
		$html .= "<button class='noclick arrow'>" . "▶" . "</button></div>";
	
	return $html;
}
// Handles the generation of ticket display buttons
// Status and Subject, then further information upon click (dropdown information)
function ticketDisplay($tickets, $pages, $page, $count) {
	$html = "";
	if ($pages != $page)
		for ($i = ($page-1)*25; $i < ($page)*25; $i++) {
			$html .= "<button class='ticket'>Status: <span class='upper'>" . $tickets[$i]["status"] . "</span> -- " . $tickets[$i]["subject"] . "</button>";
			$html .= '<div class="ticketInfo"><hr>';
			$html .= '<b>Requester_ID:</b> ' . $tickets[$i]["requester_id"] . "<br>";
			$html .= '<b>Assignee_ID:</b> ' . $tickets[$i]["assignee_id"] . "<br>";
			$html .= '<b>Date Created:</b> ' . substr($tickets[$i]["created_at"], 0, 10) . "<br>";
			$html .= '<b>Subject:</b> ' . $tickets[$i]["subject"] . "<br>";
			$html .= '<b>Description:</b> ' . $tickets[$i]["description"] . "<br>";
			$html .= '<b>Tags:</b> ';
			for ($j = 0; $j < count($tickets[$i]["tags"]); $j++) {
				$html .= $tickets[$i]["tags"][$j];
				if ($j+1 < count($tickets[$i]["tags"]))
					$html .= ", ";
			}
			$html .= '<hr></div>';
		}
	else
		for ($i = ($page-1)*25; $i < $count; $i++) {
			$html .= "<button class='ticket'>Status: <span class='upper'>" . $tickets[$i]["status"] . "</span> -- " . $tickets[$i]["subject"] . "</button>";
			$html .= '<div class="ticketInfo"><hr>';
			$html .= '<b>Requester_ID:</b> ' . $tickets[$i]["requester_id"] . "<br>";
			$html .= '<b>Assignee_ID:</b> ' . $tickets[$i]["assignee_id"] . "<br>";
			$html .= '<b>Subject:</b> ' . $tickets[$i]["subject"] . "<br>";
			$html .= '<b>Description:</b> ' . $tickets[$i]["description"] . "<br>";
			$html .= '<b>Tags:</b> ';
			for ($j = 0; $j < count($tickets[$i]["tags"]); $j++) {
				$html .= $tickets[$i]["tags"][$j];
				if ($j+1 < count($tickets[$i]["tags"]))
					$html .= ", ";
			}
			$html .= '<hr></div>';
		}
	return $html;
}
// Assebles the core of each page of tickets
function build_body($tickets, $pages, $page) {
	$count = count($tickets);
	$html = "<br><p>" . $count . " total tickets, " . currentTicketCount($pages, $page, $count) . " on this page.</p><br>";
	
	$html .= pagination($pages, $page) . "<br>";
	
	$html .= ticketDisplay($tickets, $pages, $page, $count) . "<br>";
		
	$html .= pagination($pages, $page) . "<br>";
	
    return $html;
}
// Method accesses Zendesk API
function callAPI($method, $url, $data = false) {
	$user = "cooperbaumgarth@gmail.com" . "/token"; // Additional "/token" allows for token use instead of a password
	$token = "qrM2dJgVhOeKznomuGFlmy7v8XLrWoaktCFma2DY";
    $curl = curl_init();
    switch ($method)
    {
        case "POST":
            curl_setopt($curl, CURLOPT_POST, 1);

            if ($data)
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            break;
        case "PUT":
            curl_setopt($curl, CURLOPT_PUT, 1);
            break;
        default:
            if ($data)
                $url = sprintf("%s?%s", $url, http_build_query($data));
    }
    curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($curl, CURLOPT_USERPWD, $user . ":" . $token);
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

    $result = curl_exec($curl);
    curl_close($curl);
    return $result;
}
// Return base URL given subdomain
function url($sub) {
	return "https://" . $sub . ".zendesk.com/api/v2/tickets.json";
}
// Get the number of valid ticket pages available from Zendesk (1 page is <= 100 tickets)
function getTicketPages($subdomain) {
	$moreTickets = true;
	$ticketPages = 1;
	while ($moreTickets) {
		$ticketPage = callAPI("GET", url($subdomain) . "?page=" . $ticketPages, false);
		
		if (str_contains($ticketPage, '"next_page":"'))
			$ticketPages++;
		else 	
			$moreTickets = false;
	}
	return $ticketPages;
}
// Pulls every page of tickets from Zendesk (1 page is <= 100 tickets) and combines them into 1 array
function combineTicketPages($ticketPages, $subdomain) {
	$tpSum = json_decode(callAPI("GET", url($subdomain) . "?page=1", false), true)["tickets"];
	if ($ticketPages > 1)
		for ($p = 2; $p <= $ticketPages; $p++) {
			$nextTP = json_decode(callAPI("GET", url($subdomain) . "?page=" . $p, false), true)["tickets"];
			$tpSum = array_merge($tpSum, $nextTP);
		}
	return $tpSum;
}
?>