<?php

class GetBarcodeByTrackingNumber
{
	public int $trackingNumber;

	public function __construct(int $trackingNumber)
	{
		$this->trackingNumber = $trackingNumber;
	}
}