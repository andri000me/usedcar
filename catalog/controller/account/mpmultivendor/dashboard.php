<?php
class ControllerAccountMpmultivendorDashboard extends Controller {
	public function index() {
		if (!$this->customer->isLogged()) {
			$this->session->data['redirect'] = $this->url->link('account/account', '', true);

			$this->response->redirect($this->url->link('account/login', '', true));
		}

		if(!$this->config->get('mpmultivendor_status')) {
			$this->response->redirect($this->url->link('account/account', '', true));
		}
		
		$this->load->language('account/mpmultivendor/dashboard');
		
		$this->load->model('account/mpmultivendor/dashboard');
		
		$this->load->model('account/mpmultivendor/seller');

		$this->load->model('account/mpmultivendor/orders');

		$this->document->addStyle('catalog/view/theme/default/stylesheet/mpmultivendor.css');

		if(strpos($this->config->get('config_template'), 'journal2') === 0){
			$this->document->addStyle('catalog/view/theme/default/stylesheet/mpmultivendor-journal.css');			
		}
		
		$this->document->setTitle($this->language->get('heading_title'));

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_account'),
			'href' => $this->url->link('account/account', '', true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_dashboard'),
			'href' => $this->url->link('account/mpmultivendor/dashboard', '', true)
		);

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_product'] = $this->language->get('text_product');
		$data['text_sales'] = $this->language->get('text_sales');
		$data['text_orders'] = $this->language->get('text_orders');
		$data['text_commission'] = $this->language->get('text_commission');
		$data['text_recevied_payment'] = $this->language->get('text_recevied_payment');
		$data['text_available_balance'] = $this->language->get('text_available_balance');
		$data['text_reviews'] = $this->language->get('text_reviews');
		$data['text_products'] = $this->language->get('text_products');
		$data['text_viewmore'] = $this->language->get('text_viewmore');
		$data['text_all'] = $this->language->get('text_all');
		$data['text_total'] = $this->language->get('text_total');

		$data['button_new_product'] = $this->language->get('button_new_product');
		$data['button_viewmore'] = $this->language->get('button_viewmore');

		$data['new_product'] = $this->url->link('account/mpmultivendor/product/add', '', true);

		$data['all_reviews'] = $this->url->link('account/mpmultivendor/reviews', '', true);

		$data['all_orders'] = $this->url->link('account/mpmultivendor/orders', '', true);

		$seller_info = $this->model_account_mpmultivendor_seller->getSellerStoreInfo($this->customer->isLogged());

		if(!$seller_info) {
			$this->response->redirect($this->url->link('account/account', '', true));
		}

		if(!empty($seller_info)) {
			$mpseller_id = $seller_info['mpseller_id'];
		} else {
			$mpseller_id = 0;
		}

		$filter_data = array(
			'filter_mpseller_id'	=> $mpseller_id,
		);

		$total_commission = $this->model_account_mpmultivendor_dashboard->getCommissionTotal($filter_data);
		$data['total_commission'] = $this->currency->format($total_commission, $this->config->get('config_currency'));
		
		$recevied_payment = $this->model_account_mpmultivendor_dashboard->getPaymentTotal($filter_data);
		$data['recevied_payment'] = $this->currency->format($recevied_payment, $this->config->get('config_currency'));
		
		$available_balance = $this->model_account_mpmultivendor_dashboard->getAvailableBalance($filter_data);
		$data['available_balance'] = $this->currency->format($available_balance, $this->config->get('config_currency'));
		
		$data['total_orders'] = $this->model_account_mpmultivendor_dashboard->getTotalOrders($filter_data);

		$total_sales = $this->model_account_mpmultivendor_dashboard->getTotalSales($filter_data);
		$data['total_sales'] = $this->currency->format($total_sales, $this->config->get('config_currency'));

		$data['total_products'] = $this->model_account_mpmultivendor_dashboard->getTotalProucts($filter_data);

		$order_statuses = $this->model_account_mpmultivendor_orders->getOrderStatuses();
		$data['order_statuses'] = array();
		foreach($order_statuses as $order_status) {
			$filter_status_data = array(
				'filter_mpseller_id'	=> $mpseller_id,
				'filter_order_status_id'	=> $order_status['order_status_id'],
			);

			$total_orders = $this->model_account_mpmultivendor_dashboard->getTotalOrders($filter_status_data);
			
			if($total_orders) {
				$data['order_statuses'][] = array(
					'name'				=> $order_status['name'],
					'total_orders'		=> $total_orders,
					'href'				=> $this->url->link('account/mpmultivendor/orders', '&filter_order_status_id='. $order_status['order_status_id'], true),
				);
			}
		}
		
		$data['total_reviews'] = $this->model_account_mpmultivendor_dashboard->getTotalReviews($filter_data);

		$data['mpseller_links'] = $this->load->controller('account/mpmultivendor/mpseller_links');
		
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		
		/* Theme Work Starts */
		if($this->config->get('config_theme')) {			
     		$custom_themename = $this->config->get('config_theme');
    	} if($this->config->get('theme_default_directory')) {    		
			$custom_themename = $this->config->get('theme_default_directory');
		} if($this->config->get('config_template')) {			
			$custom_themename = $this->config->get('config_template');
		} 
		// else{
		// 	$custom_themename = 'default';
		// }

		if(empty($custom_themename)) {
			$custom_themename = 'default';
		}

		$data['custom_themename'] = $custom_themename;
		/* Theme Work Ends */

		if(VERSION < '2.2.0.0') {
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/mpmultivendor/dashboard.tpl')) {
		    	$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/account/mpmultivendor/dashboard.tpl', $data));
		   } else {
		   		$this->response->setOutput($this->load->view('default/template/account/mpmultivendor/dashboard.tpl', $data));
		   }
	  	} else {
		   $this->response->setOutput($this->load->view('account/mpmultivendor/dashboard', $data));
		}		
	}
}