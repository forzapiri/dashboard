<?php

class Address extends DBRow {
		
	const GOOGLE_API_KEY = 'ABQIAAAA3l8nFImJ5iJ4F4Bwj-CqvRTVhk_FawdprkxQ7rY9h5v2o213HxSi-uaWxHyn8bn9FsaUvqDT2U3lZg';
	
	function createTable() {
		
		$cols = array(
			'id?',
			DBColumn::make('text', 'street_address', 'Street Address'),
			DBColumn::make('text', 'city', 'City'),
			DBColumn::make('text', 'postal_code', 'Postal Code'),
			DBColumn::make('select', 'state', 'Province/State', self::getStates()),
			DBColumn::make('select', 'country', 'Country', self::getCountries()),
			DBColumn::make('//latlon', 'geocode', 'GeoCode'),
			);
		return new DBTable("address", __CLASS__, $cols);
	}
	static function getAll($where = null) {return self::$tables[__CLASS__]->getAllRows($where);}
	function quickformPrefix() {return 'address_';}
	
	public static function getStates() {
		$sql = 'select id, name from states order by country, name';
		$r = Database::singleton()->query_fetch_all($sql);
		$states = array();
		foreach ($r as &$state) {
			$states[$state['id']] =$state['name'];
		}
		return $states;
	}
	
	public function getStateName() {
		$sql = 'select name from states where id=' . $this->get('state');
		$r = Database::singleton()->query_fetch($sql);
		return $r['name'];
	}
	
	public static function getCountries() {
		$sql = 'select id, name from countries order by name';
		$r = Database::singleton()->query_fetch_all($sql);
		$countries = array();
		foreach ($r as &$country) {
			$countries[$country['id']] =$country['name'];
		}
		return $countries;
	}
	
	public function getCountryName() {
		$sql = 'select name from countries where id=' . $this->get('country');
		$r = Database::singleton()->query_fetch($sql);
		return $r['name'];
	}
	
	public function getAddEditForm($target = null) {
		$form = parent::getAddEditForm($target);
		
		if ($form->isProcessed()) {
			$this->doGeocode();
			$this->save();
		}
		return $form;
	}
	
	public function doGeocode() {
		$address = urlencode($this->get('street_address') . ', ' . $this->get('city') . ', ' . $this->getStateName() . ', ' . $this->getCountryName());
		$url = 'http://maps.google.com/maps/geo?q=' . $address . '&output=csv&key=' . self::GOOGLE_API_KEY;
		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HEADER,0); //Change this to a 1 to return headers
		curl_setopt($ch, CURLOPT_USERAGENT, 'KP');
		//curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

		$data = curl_exec($ch);
		curl_close($ch);

		if (strstr($data,'200')) {
			$data = explode(',',$data);
			$precision = $data[1];
			$latitude = $data[2];
			$longitude = $data[3];
			
			$this->setGeocode($latitude . ', ' . $longitude);
		} else {
			$this->setGeocode(null);
		}
	}
}
DBRow::init('Address');

/*
class Address {
	
	private $id = null;
	
	private $streetaddress = null;
	private $city = null;
	private $postalcode = null;
	private $state = null;
	private $country = null;
	private $geocode = null;
	
	private $state_name = null;
	private $state_code = null;
	
	private $country_name = null;
	private $country_code = null;
	
	const GOOGLE_API_KEY = 'ABQIAAAA3l8nFImJ5iJ4F4Bwj-CqvRTVhk_FawdprkxQ7rY9h5v2o213HxSi-uaWxHyn8bn9FsaUvqDT2U3lZg';
	
	public function __construct($id = null) {
		if (!is_null($id)) {
			$sql = 'select a.*, s.code as s_code, s.name as s_name, c.codetwo as c_code, c.name as c_name 
				from address a LEFT JOIN (states s, countries c) ON 
				(a.s_id=s.id AND a.c_id=c.id) where a.id=' . e($id);
			if (!$result = Database::singleton()->query_fetch($sql)) {
				return false;
			}
			
			$this->id = $id;
			$this->streetaddress = $result['adr_streetaddress'];
			$this->city = $result['adr_city'];
			$this->postalcode = $result['adr_postalcode'];
			$this->state = $result['s_id'];
			$this->country = $result['c_id'];
			$this->geocode = $result['adr_geocode'];
			
			$this->state_name = $result['s_name'];
			$this->state_code = $result['s_code'];
			
			$this->country_name = $result['c_name'];
			$this->country_code = $result['c_code'];
		}
	}
	
	public function getGeocode() {
		return $this->geocode;
	}
	
	public function getStreetAddress() {
		return $this->streetaddress;
	}
	
	public function getCity() {
		return $this->city;
	}
	
	public function getState() {
		return $this->state;
	}
	
	public function getPostalCode() {
		return $this->postalcode;
	}
	
	public function getStateName() {
		return $this->state_name;
	}
	
	public function getCountryName() {
		return $this->country_name;
	}
	
	public function getCountry() {
		return $this->country;
	}
	
	public function getId() {
		return $this->id;
	}
	
	public static function getStates() {
		$sql = 'select id, name from states order by country, name';
		$r = Database::singleton()->query_fetch_all($sql);
		$states = array();
		foreach ($r as &$state) {
			$states[$state['id']] =$state['name'];
		}
		return $states;
	}
	
	public static function getCountries() {
		$sql = 'select id, name from countries order by name';
		$r = Database::singleton()->query_fetch_all($sql);
		$countries = array();
		foreach ($r as &$country) {
			$countries[$country['id']] =$country['name'];
		}
		return $countries;
	}
	
	public function setGeocode($geocode) {
		$this->geocode = $geocode;
		$sql = 'update address set adr_geocode="' . e($geocode) . '" where id=' . $this->id;
		Database::singleton()->query($sql);
	}
	
	public function setStreetAddress($address) {
		$this->streetaddress = $address;
	}
	
	public function setCity($city) {
		$this->city = $city;
	}
	
	public function setPostalCode($pcode) {
		$this->postalcode = $pcode;
	}
	
	public function setState($state_id) {
		$this->state = $state_id;
		$sql = 'select s.code as s_code, s.name as s_name from states s where s.id=' . e($state_id);
		$d = Database::singleton()->query_fetch($sql);
		$this->state_name = $d['s_name'];
		$this->state_code = $d['s_code'];
	}
	
	public function setCountry($country_id) {
		$this->country = $country_id;
		$sql = 'select c.codetwo as c_code, c.name as c_name from countries c where c.id=' . e($country_id);
		$d = Database::singleton()->query_fetch($sql);
		$this->country_name = $d['c_name'];
		$this->country_code = $d['c_code'];
	}
	
	public function save() {
		if (!is_null($this->id)) {
			$sql = 'update address set ';
		} else {
			$sql = 'insert into address set ';
		}
		$sql .= 'adr_streetaddress="' . e($this->streetaddress) . '"';
		$sql .= ', adr_city="' . e($this->city) . '"';
		$sql .= ', adr_postalcode="' . e($this->postalcode) . '"';
		$sql .= ', s_id="' . e($this->state) . '"';
		$sql .= ', c_id="' . e($this->country) . '"';
		$sql .= ', adr_geocode="' . e($this->geocode) . '"';
		if (!is_null($this->id)) {
			$sql .= ' where id=' . e($this->id);
		}
		Database::singleton()->query($sql);
		
		if (is_null($this->id)) {
			$this->id = Database::singleton()->lastInsertedID();
		}
	}
	
	public function delete() {
		$result = false;
		
		$sql = "delete from address WHERE id = '". e($this->id) ."'";
		$result = Database::singleton()->query($sql);			
		
		return $result;
	}
	
	public function doGeocode() {
		$address = urlencode($this->streetaddress . ', ' . $this->city . ', ' . $this->state_name . ', ' . $this->country_name);
		$url = 'http://maps.google.com/maps/geo?q=' . $address . '&output=csv&key=' . self::GOOGLE_API_KEY;
		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HEADER,0); //Change this to a 1 to return headers
		curl_setopt($ch, CURLOPT_USERAGENT, 'KP');
		//curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

		$data = curl_exec($ch);
		curl_close($ch);

		if (strstr($data,'200')) {
			$data = explode(',',$data);
			$precision = $data[1];
			$latitude = $data[2];
			$longitude = $data[3];
			
			$this->setGeocode($latitude . ', ' . $longitude);
		} else {
			$this->setGeocode(null);
		}
	}
	
	public function getAddEditForm() {
		$form = new Form('address_addedit', 'post');
		
		if (!is_null($this->id)) {
			//$post = new Address($_REQUEST['address_id']);
			
			$form->setConstants( array ( 'address_id' => $this->getId() ) );
			$form->addElement( 'hidden', 'address_id' );
			
			$defaults['address'] = $this->getStreetAddress();
			$defaults['city'] = $this->getCity();
			$defaults['state'] = $this->getState();
			$defaults['country'] = $this->getCountry();
			$defaults['postalcode'] = $this->getPostalCode();
			
			$form->setDefaults( $defaults );
		}
		
		$form->addElement('text', 'address', 'Address');
		$form->addElement('text', 'city', 'City');
		$form->addElement('text', 'postalcode', 'Postal Code');
		$form->addElement('select', 'state', 'State / Province', Address::getStates());
		$form->addElement('select', 'country', 'Country', Address::getCountries());
		
		if ($form->validate() && isset($_REQUEST['submit'])) {
			//if (isset($_REQUEST['address_id'])) {
			//	$address = new Address($_REQUEST['address_id']);
			//} else {
			//	$address = new Address();
			//}
			$this->setCity($_REQUEST['city']);
			$this->setStreetAddress($_REQUEST['address']);
			$this->setPostalCode($_REQUEST['postalcode']);
			$this->setState($_REQUEST['state']);
			$this->setCountry($_REQUEST['country']);
			$this->doGeocode();
			$this->save();
		}
		return $form;
	}
	
	public function getDistance($geocode) {
		list($lat1, $lon1) = split(', ', $geocode);
		list($lat2, $lon2) = split(', ', $this->geocode);
		$lat1 = deg2rad((double)$lat1); //$lat * M_PI / 180;
		$lon1 = deg2rad((double)$lon1); // * M_PI / 180;

		$lat2 = deg2rad($lat2); // * M_PI / 180;
		$lon2 = deg2rad($lon2); // * M_PI / 180;

		$sinl1 = sin ($lat1);
		$dist = (7926 - 26 * $sinl1) * asin (min (1, 0.707106781186548 * sqrt ((1 - (sin ($lat2) * $sinl1) - cos ($lat1) * cos ($lat2) * cos ($lon2 - $lon1)))));
		return round($dist,2);
	}

	public function __toString() {
		return $this->getStreetAddress() . ', ' . $this->getCity() . ', ' . $this->getStateName() . ', ' . $this->getPostalCode();
	}
	
}
*/
?>