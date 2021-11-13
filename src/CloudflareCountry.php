<?php 

/**
 * This file is part of the CloudflareCountry package.
 * 
 * (c) Marc Witteveen <marc.witteveen@gmail.com>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace MarcWitteveen\CloudflareCountry;

class CloudflareCountry {

	private $countryCode = "";

	private $countryCodeCanada = "CA";

	private $countryCanada = "Canada";

	private $countriesEU = [
		'AT' => 'Austria',
		'BE' => 'Belgium',
		'BG' => 'Bulgaria',
		'HR' => 'Croatia',
		'CY' => 'Cyprus',
		'CZ' => 'Czech Republic',
		'DK' => 'Denmark',
		'EE' => 'Estonia',
		'FI' => 'Finland',
		'FR' => 'France',
		'DE' => 'Germany',
		'GR' => 'Greece',
		'HU' => 'Hungary',
		'IE' => 'Ireland',
		'IT' => 'Italy',
		'LV' => 'Latvia',
		'LT' => 'Lithuania',
		'LU' => 'Luxembourg',
		'MT' => 'Malta',
		'NL' => 'Netherlands',
		'PL' => 'Poland',
		'PT' => 'Portugal',
		'RO' => 'Romania',
		'SK' => 'Slovakia',
		'SI' => 'Slovenia',
		'ES' => 'Spain',
		'SE' => 'Sweden',
		//'GB' => 'United Kingdom',
	];

	private $countryEU = [];

	private $allCountryCodes = [];

	public function __construct() 
	{
		$this->countryCode = (string) $_SERVER["HTTP_CF_IPCOUNTRY"];
		if (empty($this->countryCode)) {
			$this->countryCode = (string) getenv(GEOIP_COUNTRY_CODE);
		}
		
		$this->countryCode = (string) strtoupper($this->countryCode); 
		$this->countryEU = array_keys($this->countriesEU);

		$this->allCountryCodes = array_merge($this->countryEU, $this->countryCodeCanada);
	}

	public function getCountryCode() 
	{
		return $this->countryCode;	
	}

	public function getCountry() 
	{
		return $this->countryEU;
	}

	public function getEUCountries() 
	{
		return $this->countriesEU;
	}

	public function getRegion() 
	{
		if ($this->isEU()==true) {
			return "Europe";
		} elseif($this->isCanada()==true) {
			return "Canada";
		} else {
			return "Other";
		}
	}

	public function isEU()
	{
		return in_array($this->countryCode, $this->countryEU);
	}

	public function isCanada()
	{
		return ($this->countryCode === $this->countryCodeCanada);
	}

	public function isOther() {

		return (in_array($this->countryCode, $this->allCountryCodes))?false:true;
	}
}