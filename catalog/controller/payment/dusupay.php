<?php
class ControllerPaymentDusupay extends Controller {
	protected function index() {
		$this->language->load('payment/dusupay');

		$this->data['text_testmode'] = $this->language->get('text_testmode');		

		$this->data['button_confirm'] = $this->language->get('button_confirm');

		$this->data['testmode'] = $this->config->get('dusupay_test');

		if (!$this->config->get('dusupay_test')) {
			$this->data['action'] = 'https://www.dusupay.com/dusu_payments/dusupay';
		} else {
			$this->data['action'] = 'http://sandbox.dusupay.com/dusu_payments/dusupay';
		}

		$this->load->model('checkout/order');

		$order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);

		if ($order_info) {
			$this->data['merchantId'] = $this->config->get('dusupay_merchantId');
			$this->data['item_id'] = $this->config->get('config_store_id');
			$this->data['item_name'] = html_entity_decode($this->config->get('config_name'), ENT_QUOTES, 'UTF-8');

			$this->data['amt'] = $this->currency->format($order_info['total'], $order_info['currency_code'], $order_info['currency_value'], false);

			$this->data['currency_code'] = $order_info['currency_code'];
			$this->data['lc'] = $this->session->data['language'];
			$this->data['return'] = $this->url->link('payment/dusupay/callback');
			$this->data['notify_url'] = $this->url->link('payment/dusupay/callback', '', 'SSL');
			$this->data['cancel_return'] = $this->url->link('checkout/checkout', '', 'SSL');


			$this->data['custom'] = $this->session->data['order_id'];

			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/payment/dusupay.tpl')) {
				$this->template = $this->config->get('config_template') . '/template/payment/dusupay.tpl';
			} else {
				$this->template = 'default/template/payment/dusupay.tpl';
			}

			$this->render();
		}
	}

	public function callback() {
		if (isset($this->request->get['dusupay_transactionReference'])) {
			$order_id = $this->request->get['dusupay_transactionReference'];
			$dusupay_transactionId = $this->request->get['dusupay_transactionId'];
			$dusupay_timestamp = $this->request->get['dusupay_timestamp'];
			$dusupay_hash = $this->request->get['hash'];
		} else {
			$order_id = 0;
		}		

		$this->load->model('checkout/order');

		$order_info = $this->model_checkout_order->getOrder($order_id);

		
		if ($order_info) {
			if (!$this->config->get('dusupay_test')) {
				$url='https://dusupay.com/transactions/check_status/'.$this->config->get('dusupay_merchantId').'/'.$order_id.'.json';
			} else {
				$url='http://sandbox.dusupay.com/transactions/check_status/'.$this->config->get('dusupay_merchantId').'/'.$order_id.'.json';
			}

			//Setting the timeout properly without messing with ini values:
			$ctx = stream_context_create(array( 
			    'https' => array( 
			        'timeout' => 1 
			        ) 
			    ) 
			);
			$response_json = file_get_contents($url, 0, $ctx);

			$response=json_decode($response_json);

			
			if (!$response) {
				$this->log->write('DUSUPAY :: FILE_GET_CONTENTS failed ' . $url);
			}

			if ($this->config->get('dusupay_debug')) {
				$this->log->write('DUSUPAY :: IPN REQUEST: ' . $url);
				$this->log->write('DUSUPAY :: IPN RESPONSE: ' . $response_json);
			}

			
			if (strcmp($response->Response->status, 'success') == 0) {
				$order_status_id = $this->config->get('config_order_status_id');

				switch($response->Response->dusupay_transactionStatus) {
					case 'PENDING':
						$order_status_id = $this->config->get('dusupay_pending_status_id');
						break;
					case 'COMPLETE':
						$order_status_id = $this->config->get('dusupay_complete_status_id');
						break;
					case 'NOTVERIFIED':
						$order_status_id = $this->config->get('dusupay_notverified_status_id');
						break;
					case 'REFUNDED':
						$order_status_id = $this->config->get('dusupay_refunded_status_id');
						break;
					case 'FAILED':
						$order_status_id = $this->config->get('dusupay_failed_status_id');
						break;
					case 'CANCELLED':
						$order_status_id = $this->config->get('dusupay_cancelled_status_id');
						break;
					case 'INVALID':
						$order_status_id = $this->config->get('dusupay_invalid_status_id');
						break;								
				}

				if (!$order_info['order_status_id']) {
					$this->model_checkout_order->confirm($order_id, $order_status_id);
				} else {
					$this->model_checkout_order->update($order_id, $order_status_id);
				}
			} else {
				$this->model_checkout_order->confirm($order_id, $this->config->get('config_order_status_id'));
			}

			$this->redirect($this->url->link('checkout/success'));
		}	
	}
}
?>