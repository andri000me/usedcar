<?php
class ControllerMpmultivendorEnquiries extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('mpmultivendor/enquiries');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('mpmultivendor/enquiries');

		$this->getList();
	}

	public function delete() {
		$this->load->language('mpmultivendor/enquiries');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('mpmultivendor/enquiries');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $mpseller_enquiry_id) {
				$this->model_mpmultivendor_enquiries->deleteEnquiry($mpseller_enquiry_id);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['filter_mpseller_id'])) {
				$url .= '&filter_mpseller_id=' . $this->request->get['filter_mpseller_id'];
			}

			if (isset($this->request->get['filter_store_owner'])) {
				$url .= '&filter_store_owner=' . $this->request->get['filter_store_owner'];
			}

			if (isset($this->request->get['filter_customer'])) {
				$url .= '&filter_customer=' . $this->request->get['filter_customer'];
			}

			if (isset($this->request->get['filter_customer_email'])) {
				$url .= '&filter_customer_email=' . $this->request->get['filter_customer_email'];
			}

			if (isset($this->request->get['filter_date_added'])) {
				$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('mpmultivendor/enquiries', 'user_token=' . $this->session->data['user_token'] . $url, true));
		}

		$this->getList();
	}

	protected function getList() {

		$this->document->addStyle('view/stylesheet/mpmultivendor/mpmultivendor.css');
		
		if (isset($this->request->get['filter_mpseller_id'])) {
			$filter_mpseller_id = $this->request->get['filter_mpseller_id'];
		} else {
			$filter_mpseller_id = null;
		}

		if (isset($this->request->get['filter_store_owner'])) {
			$filter_store_owner = $this->request->get['filter_store_owner'];
		} else {
			$filter_store_owner = null;
		}

		if (isset($this->request->get['filter_customer'])) {
			$filter_customer = $this->request->get['filter_customer'];
		} else {
			$filter_customer = null;
		}

		if (isset($this->request->get['filter_customer_email'])) {
			$filter_customer_email = $this->request->get['filter_customer_email'];
		} else {
			$filter_customer_email = null;
		}

		if (isset($this->request->get['filter_date_added'])) {
			$filter_date_added = $this->request->get['filter_date_added'];
		} else {
			$filter_date_added = null;
		}

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'e.date_added';
		}

		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'DESC';
		}

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$url = '';

		if (isset($this->request->get['filter_mpseller_id'])) {
			$url .= '&filter_mpseller_id=' . $this->request->get['filter_mpseller_id'];
		}

		if (isset($this->request->get['filter_store_owner'])) {
			$url .= '&filter_store_owner=' . $this->request->get['filter_store_owner'];
		}

		if (isset($this->request->get['filter_customer'])) {
			$url .= '&filter_customer=' . $this->request->get['filter_customer'];
		}

		if (isset($this->request->get['filter_customer_email'])) {
			$url .= '&filter_customer_email=' . $this->request->get['filter_customer_email'];
		}

		if (isset($this->request->get['filter_date_added'])) {
			$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('mpmultivendor/enquiries', 'user_token=' . $this->session->data['user_token'] . $url, true)
		);

		$data['add'] = $this->url->link('mpmultivendor/enquiries/add', 'user_token=' . $this->session->data['user_token'] . $url, true);
		$data['delete'] = $this->url->link('mpmultivendor/enquiries/delete', 'user_token=' . $this->session->data['user_token'] . $url, true);

		$data['enquiries'] = array();

		$filter_data = array(
			'filter_mpseller_id'  		=> $filter_mpseller_id,
			'filter_store_owner'  		=> $filter_store_owner,
			'filter_customer'  			=> $filter_customer,
			'filter_customer_email'  	=> $filter_customer_email,
			'filter_date_added'  		=> $filter_date_added,
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit' => $this->config->get('config_limit_admin')
		);

		$enquiry_total = $this->model_mpmultivendor_enquiries->getTotalEnquiries($filter_data);

		$results = $this->model_mpmultivendor_enquiries->getEnquiries($filter_data);

		foreach ($results as $result) {
			$data['enquiries'][] = array(
				'mpseller_enquiry_id' 	=> $result['mpseller_enquiry_id'],
				'store_owner' 		  	=> $result['store_owner'],
				'name' 				  	=> $result['name'],
				'email' 				=> $result['email'],
				'message' 				=> $result['message'],
				'date_added'    		=> date($this->language->get('date_format_short'), strtotime($result['date_added'])),
				'view'           		=> $this->url->link('mpmultivendor/enquiries/view', 'user_token=' . $this->session->data['user_token'] . '&mpseller_enquiry_id=' . $result['mpseller_enquiry_id'] . $url, true)
			);
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_list'] = $this->language->get('text_list');
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_confirm'] = $this->language->get('text_confirm');

		$data['entry_store_owner'] = $this->language->get('entry_store_owner');
		$data['entry_customer_name'] = $this->language->get('entry_customer_name');
		$data['entry_customer_email'] = $this->language->get('entry_customer_email');
		$data['entry_date_added'] = $this->language->get('entry_date_added');

		$data['button_filter'] = $this->language->get('button_filter');

		$data['column_store_owner'] = $this->language->get('column_store_owner');
		$data['column_customer_name'] = $this->language->get('column_customer_name');
		$data['column_customer_email'] = $this->language->get('column_customer_email');
		$data['column_date_added'] = $this->language->get('column_date_added');
		$data['column_action'] = $this->language->get('column_action');

		$data['button_view'] = $this->language->get('button_view');
		$data['button_delete'] = $this->language->get('button_delete');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		if (isset($this->request->post['selected'])) {
			$data['selected'] = (array)$this->request->post['selected'];
		} else {
			$data['selected'] = array();
		}

		$url = '';

		if (isset($this->request->get['filter_mpseller_id'])) {
			$url .= '&filter_mpseller_id=' . $this->request->get['filter_mpseller_id'];
		}

		if (isset($this->request->get['filter_store_owner'])) {
			$url .= '&filter_store_owner=' . $this->request->get['filter_store_owner'];
		}

		if (isset($this->request->get['filter_customer'])) {
			$url .= '&filter_customer=' . $this->request->get['filter_customer'];
		}

		if (isset($this->request->get['filter_customer_email'])) {
			$url .= '&filter_customer_email=' . $this->request->get['filter_customer_email'];
		}

		if (isset($this->request->get['filter_date_added'])) {
			$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
		}

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['sort_store_owner'] = $this->url->link('mpmultivendor/enquiries', 'user_token=' . $this->session->data['user_token'] . '&sort=store_owner' . $url, true);
		$data['sort_name'] = $this->url->link('mpmultivendor/enquiries', 'user_token=' . $this->session->data['user_token'] . '&sort=e.name' . $url, true);
		$data['sort_email'] = $this->url->link('mpmultivendor/enquiries', 'user_token=' . $this->session->data['user_token'] . '&sort=e.email' . $url, true);
		$data['sort_date_added'] = $this->url->link('mpmultivendor/enquiries', 'user_token=' . $this->session->data['user_token'] . '&sort=e.date_added' . $url, true);

		$url = '';

		if (isset($this->request->get['filter_mpseller_id'])) {
			$url .= '&filter_mpseller_id=' . $this->request->get['filter_mpseller_id'];
		}
		
		if (isset($this->request->get['filter_store_owner'])) {
			$url .= '&filter_store_owner=' . $this->request->get['filter_store_owner'];
		}

		if (isset($this->request->get['filter_customer'])) {
			$url .= '&filter_customer=' . $this->request->get['filter_customer'];
		}

		if (isset($this->request->get['filter_customer_email'])) {
			$url .= '&filter_customer_email=' . $this->request->get['filter_customer_email'];
		}
		
		if (isset($this->request->get['filter_date_added'])) {
			$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $enquiry_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('mpmultivendor/enquiries', 'user_token=' . $this->session->data['user_token'] . $url . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($enquiry_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($enquiry_total - $this->config->get('config_limit_admin'))) ? $enquiry_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $enquiry_total, ceil($enquiry_total / $this->config->get('config_limit_admin')));

		$data['filter_mpseller_id'] = $filter_mpseller_id;
		$data['filter_store_owner'] = $filter_store_owner;
		$data['filter_customer'] = $filter_customer;
		$data['filter_customer_email'] = $filter_customer_email;
		$data['filter_date_added'] = $filter_date_added;
		$data['sort'] = $sort;
		$data['order'] = $order;

		$data['user_token'] = $this->session->data['user_token'];

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->config->set('template_engine', 'template');
		$this->response->setOutput($this->load->view('mpmultivendor/enquiries_list', $data));
	}

	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'mpmultivendor/enquiries')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}

	public function view() {
		$this->load->language('mpmultivendor/enquiries');

		$this->load->model('mpmultivendor/enquiries');


		if(isset($this->request->get['mpseller_enquiry_id'])) {
			$mpseller_enquiry_id = $this->request->get['mpseller_enquiry_id'];
		} else {
			$mpseller_enquiry_id = 0;
		}

		$enquiry_info = $this->model_mpmultivendor_enquiries->getEnquiry($mpseller_enquiry_id);

		if($enquiry_info) {
			$data['text_list_info'] = $this->language->get('text_list_info');

			$data['entry_store_owner'] = $this->language->get('entry_store_owner');
			$data['entry_customer_name'] = $this->language->get('entry_customer_name');
			$data['entry_customer_email'] = $this->language->get('entry_customer_email');
			$data['entry_message'] = $this->language->get('entry_message');
			$data['entry_date_added'] = $this->language->get('entry_date_added');

			$data['store_owner'] = $enquiry_info['store_owner'];
			$data['name'] = $enquiry_info['name'];
			$data['email'] = $enquiry_info['email'];
			$data['message'] = $enquiry_info['message'];
			$data['date_added'] = date($this->language->get('date_format_short'), strtotime($enquiry_info['date_added']));
			
			$this->config->set('template_engine', 'template');
			$this->response->setOutput($this->load->view('mpmultivendor/enquiries_view', $data));
		}
	}
}