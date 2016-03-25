<?php
class ControllerPaymentDusupay extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('payment/dusupay');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('dusupay', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->redirect($this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_all_zones'] = $this->language->get('text_all_zones');
		$this->data['text_yes'] = $this->language->get('text_yes');
		$this->data['text_no'] = $this->language->get('text_no');

		$this->data['entry_merchantId'] = $this->language->get('entry_merchantId');
		$this->data['entry_test'] = $this->language->get('entry_test');
		$this->data['entry_debug'] = $this->language->get('entry_debug');
		$this->data['entry_total'] = $this->language->get('entry_total');

		$this->data['entry_pending_status'] = $this->language->get('entry_pending_status');
		$this->data['entry_complete_status'] = $this->language->get('entry_complete_status');
		$this->data['entry_notverified_status'] = $this->language->get('entry_notverified_status');
		$this->data['entry_refunded_status'] = $this->language->get('entry_refunded_status');
		$this->data['entry_failed_status'] = $this->language->get('entry_failed_status');
		$this->data['entry_cancelled_status'] = $this->language->get('entry_cancelled_status');
		$this->data['entry_invalid_status'] = $this->language->get('entry_invalid_status');

		$this->data['entry_geo_zone'] = $this->language->get('entry_geo_zone');
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');

		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');

		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

		if (isset($this->error['merchantId'])) {
			$this->data['error_merchantId'] = $this->error['merchantId'];
		} else {
			$this->data['error_merchantId'] = '';
		}


		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => false
		);

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_payment'),
			'href'      => $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('payment/pp_standard', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);

		$this->data['action'] = $this->url->link('payment/dusupay', 'token=' . $this->session->data['token'], 'SSL');

		$this->data['cancel'] = $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL');

		if (isset($this->request->post['dusupay_merchantId'])) {
			$this->data['dusupay_merchantId'] = $this->request->post['dusupay_merchantId'];
		} else {
			$this->data['dusupay_merchantId'] = $this->config->get('dusupay_merchantId');
		}

		if (isset($this->request->post['dusupay_test'])) {
			$this->data['dusupay_test'] = $this->request->post['dusupay_test'];
		} else {
			$this->data['dusupay_test'] = $this->config->get('dusupay_test');
		}


		if (isset($this->request->post['dusupay_debug'])) {
			$this->data['dusupay_debug'] = $this->request->post['dusupay_debug'];
		} else {
			$this->data['dusupay_debug'] = $this->config->get('dusupay_debug');
		}

		if (isset($this->request->post['dusupay_total'])) {
			$this->data['dusupay_total'] = $this->request->post['dusupay_total'];
		} else {
			$this->data['dusupay_total'] = $this->config->get('dusupay_total');
		}


		if (isset($this->request->post['dusupay_pending_status_id'])) {
			$this->data['dusupay_pending_status_id'] = $this->request->post['dusupay_pending_status_id'];
		} else {
			$this->data['dusupay_pending_status_id'] = $this->config->get('dusupay_pending_status_id');
		}

		if (isset($this->request->post['dusupay_complete_status_id'])) {
			$this->data['dusupay_complete_status_id'] = $this->request->post['dusupay_complete_status_id'];
		} else {
			$this->data['dusupay_complete_status_id'] = $this->config->get('dusupay_complete_status_id');
		}

		if (isset($this->request->post['dusupay_notverified_status_id'])) {
			$this->data['dusupay_notverified_status_id'] = $this->request->post['dusupay_notverified_status_id'];
		} else {
			$this->data['dusupay_notverified_status_id'] = $this->config->get('dusupay_notverified_status_id');
		}

		if (isset($this->request->post['dusupay_refunded_status_id'])) {
			$this->data['dusupay_refunded_status_id'] = $this->request->post['dusupay_refunded_status_id'];
		} else {
			$this->data['dusupay_refunded_status_id'] = $this->config->get('dusupay_refunded_status_id');
		}

		if (isset($this->request->post['dusupay_failed_status_id'])) {
			$this->data['dusupay_failed_status_id'] = $this->request->post['dusupay_failed_status_id'];
		} else {
			$this->data['dusupay_failed_status_id'] = $this->config->get('dusupay_failed_status_id');
		}

		if (isset($this->request->post['dusupay_cancelled_status_id'])) {
			$this->data['dusupay_cancelled_status_id'] = $this->request->post['dusupay_cancelled_status_id'];
		} else {
			$this->data['dusupay_cancelled_status_id'] = $this->config->get('dusupay_cancelled_status_id');
		}

		if (isset($this->request->post['dusupay_invalid_status_id'])) {
			$this->data['dusupay_invalid_status_id'] = $this->request->post['dusupay_invalid_status_id'];
		} else {
			$this->data['dusupay_invalid_status_id'] = $this->config->get('dusupay_invalid_status_id');
		}


		$this->load->model('localisation/order_status');

		$this->data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

		if (isset($this->request->post['dusupay_geo_zone_id'])) {
			$this->data['dusupay_geo_zone_id'] = $this->request->post['dusupay_geo_zone_id'];
		} else {
			$this->data['dusupay_geo_zone_id'] = $this->config->get('dusupay_geo_zone_id');
		}

		$this->load->model('localisation/geo_zone');

		$this->data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();

		if (isset($this->request->post['dusupay_status'])) {
			$this->data['dusupay_status'] = $this->request->post['dusupay_status'];
		} else {
			$this->data['dusupay_status'] = $this->config->get('dusupay_status');
		}

		if (isset($this->request->post['dusupay_sort_order'])) {
			$this->data['dusupay_sort_order'] = $this->request->post['dusupay_sort_order'];
		} else {
			$this->data['dusupay_sort_order'] = $this->config->get('dusupay_sort_order');
		}

		$this->template = 'payment/dusupay.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	private function validate() {
		if (!$this->user->hasPermission('modify', 'payment/dusupay')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->request->post['dusupay_merchantId']) {
			$this->error['merchantId'] = $this->language->get('error_merchantId');
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}
}
?>
