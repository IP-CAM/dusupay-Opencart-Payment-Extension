<?php 
class ModelPaymentDusupay extends Model {
	public function getMethod($address, $total) {
		$this->load->language('payment/dusupay');

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zone_to_geo_zone WHERE geo_zone_id = '" . (int)$this->config->get('dusupay_geo_zone_id') . "' AND country_id = '" . (int)$address['country_id'] . "' AND (zone_id = '" . (int)$address['zone_id'] . "' OR zone_id = '0')");

		if ($this->config->get('dusupay_total') > $total) {
			$status = false;
		} elseif (!$this->config->get('dusupay_geo_zone_id')) {
			$status = true;
		} elseif ($query->num_rows) {
			$status = true;
		} else {
			$status = false;
		}	

		$currencies = array(
			'KES',
			'UGX',
			'TZS',
			'EUR',
			'GBP',
			'USD',
			'RWF'
		);

		if (!in_array(strtoupper($this->currency->getCode()), $currencies)) {
			$status = false;
		}			

		$method_data = array();

		if ($status) {  
			$method_data = array(
				'code'       => 'dusupay',
				'title'      => $this->language->get('text_title'),
				'sort_order' => $this->config->get('dusupay_sort_order')
			);
		}

		return $method_data;
	}
}
?>