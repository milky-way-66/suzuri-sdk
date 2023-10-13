<?php

namespace MilkyWay\SuruziSdk;

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;

class Suzuri
{

	private string $accessToken;
	private Client $client;

	const BASE_URI = "https://suzuri.jp";

	public function __construct(string $accessToken)
	{
		$this->accessToken = $accessToken;
	}

	public function client()
	{
		if (!isset($this->client)) {
			$this->client = new Client();
		}

		return $this->client;
	}

	public function headers()
	{
		return [
			"Authorization" => "Bearer " . $this->accessToken
		];
	}

	public function items()
	{
		$response = $this->client()->get(
			self::BASE_URI . "/api/v1/items",
			[
				RequestOptions::HEADERS => $this->headers()
			]
		);

		return json_decode($response->getBody()->getContents());
	}

	public function materials()
	{

		$response = $this->client()->get(
			self::BASE_URI . "/api/v1/materials",
			[
				RequestOptions::HEADERS => $this->headers()
			]
		);

		return json_decode($response->getBody()->getContents());
	}

	public function createProduct(string $texture, string $title, array $optional = [])
	{
		$data = [
			"texture" => $texture,
			"title" => $title,
		];

		foreach($optional as $key => $params){
			$data[$key] = $params;
		}

		$response = $this->client()->post(
			self::BASE_URI . "api/v1/materials",
			[
				RequestOptions::HEADERS => $this->headers(),
				RequestOptions::BODY => $data
			]
		);

		return json_decode($response->getBody()->getContents());
	}
}