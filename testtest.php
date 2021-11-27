<?php
class testtest extends \PHPUnit\Framework\TestCase
{
public function test()
	{
		require __DIR__ . "/functions.php";
		$this->assertEquals(25, currentTicketCount(4, 5, 5));
		$this->assertNotEquals(25, currentTicketCount(5, 5, 5));
		$this->assertEquals(url("test"), "https://test.zendesk.com/api/v2/tickets.json");
		$subdomain = "zccbaumgarth";
		$this->assertEquals(combineTicketPages(1, $subdomain), json_decode(callAPI("GET", url($subdomain) . "?page=1", false), true)["tickets"]);
		$this->assertTrue(str_contains(openHTML() . closeHTML(), "<html") && str_contains(openHTML() . closeHTML(), "</html>"));
	}
}