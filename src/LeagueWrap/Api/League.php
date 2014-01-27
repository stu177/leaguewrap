<?php
namespace LeagueWrap\Api;

use LeagueWrap\ClientInterface;
use LeagueWrap\Response;

class League extends AbstractApi {

	/**
	 * Valid version for this api call.
	 *
	 * @var array
	 */
	protected $versions = [
		'v2.2',
	];

	/**
	 * A list of all permitted regions for the league api call.
	 *
	 * @param array
	 */
	protected $permittedRegions = [
		'eune',
		'br',
		'tr',
		'na',
		'euw',
	];

	/**
	 * The amount of time we intend to remember the response for.
	 *
	 * @var int
	 */
	protected $defaultRemember = 43200;

	public function __construct(ClientInterface $client)
	{
		$this->client = $client;
	}

	/**
	 * Gets the league information by summoner id.
	 *
	 * @param mixed $identity
	 * @return array
	 */
	public function league($identity)
	{
		$id = $this->extractId($identity);

		$array   = $this->request('league/by-summoner/'.$id);
		$leagues = [];
		foreach ($array as $key => $info)
		{
			$info['id']    = $key;
			$league        = new Response\League($info);
			$leagues[$key] = $league;
		}

		$this->attachResponse($identity, $leagues, 'leagues');

		return $leagues;
	}

}
