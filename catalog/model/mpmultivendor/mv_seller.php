<?php
class ModelMpmultivendorMvSeller extends Model {
	public function addReview($data) {
		$this->db->query("INSERT INTO ". DB_PREFIX ."mpseller_review SET mpseller_id = '". (int)$data['mpseller_id'] ."', title = '". $this->db->escape($data['title']) ."', description = '". $this->db->escape($data['description']) ."', author = '". $this->db->escape($data['author']) ."', rating = '". $this->db->escape($data['rating']) ."', date_added = NOW(), date_modified = NOW()");

		$mpseller_review_id = $this->db->getLastId();

		return $mpseller_review_id;
	}

	public function sendEnquiry($data) {
		$this->db->query("INSERT INTO ". DB_PREFIX ."mpseller_enquiry SET mpseller_id = '". (int)$data['mpseller_id'] ."', name = '". $this->db->escape($data['name']) ."', email = '". $this->db->escape($data['email']) ."', message = '". $this->db->escape($data['message']) ."', date_added = NOW()");

		$seller_info = $this->getSellerStoreInfo($data['mpseller_id']);
		
		if($seller_info) {
			if(VERSION >= '3.0.0.0') {
				$mail = new Mail($this->config->get('config_mail_engine'));
				$mail->parameter = $this->config->get('config_mail_parameter');
				$mail->smtp_hostname = $this->config->get('config_mail_smtp_hostname');
				$mail->smtp_username = $this->config->get('config_mail_smtp_username');
				$mail->smtp_password = html_entity_decode($this->config->get('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
				$mail->smtp_port = $this->config->get('config_mail_smtp_port');
				$mail->smtp_timeout = $this->config->get('config_mail_smtp_timeout');
			} else if(VERSION <= '2.0.1.1') {
		     	$mail = new Mail($this->config->get('config_mail'));
		    } else {
				$mail = new Mail();
				$mail->protocol = $this->config->get('config_mail_protocol');
				$mail->parameter = $this->config->get('config_mail_parameter');
				$mail->smtp_hostname = $this->config->get('config_mail_smtp_hostname');
				$mail->smtp_username = $this->config->get('config_mail_smtp_username');
				$mail->smtp_password = html_entity_decode($this->config->get('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
				$mail->smtp_port = $this->config->get('config_mail_smtp_port');
				$mail->smtp_timeout = $this->config->get('config_mail_smtp_timeout');
			}

			$subject = sprintf($this->language->get('text_subject'), $data['name'], $seller_info['store_name']);

			$mail->setTo($seller_info['email']);
			$mail->setFrom($this->config->get('config_email'));
			$mail->setReplyTo($data['email']);
			$mail->setSender(html_entity_decode($data['name'], ENT_QUOTES, 'UTF-8'));
			$mail->setSubject(html_entity_decode($subject, ENT_QUOTES, 'UTF-8'));
			$mail->setHtml(html_entity_decode($data['message'], ENT_QUOTES, 'UTF-8'));
			$mail->send();
		}
	}

	public function getSellerStoreInfo($mpseller_id) {
		$query = $this->db->query("SELECT *, (SELECT AVG(rating) AS total FROM " . DB_PREFIX . "mpseller_review mr WHERE mr.mpseller_id = m.mpseller_id AND mr.status = '1' GROUP BY mr.mpseller_id) AS rating FROM ". DB_PREFIX ."mpseller m WHERE m.mpseller_id = '". (int)$mpseller_id ."' AND m.status = '1'");

		return $query->row;
	}

	public function getSellerStores($data = array()) {
		$sql = "SELECT *, (SELECT AVG(rating) AS total FROM " . DB_PREFIX . "mpseller_review r WHERE r.mpseller_id = s.mpseller_id AND r.status = '1' GROUP BY r.mpseller_id) AS rating FROM " . DB_PREFIX . "mpseller s WHERE s.mpseller_id > 0 AND s.status = '1' AND s.approved = '1'";

		$sort_data = array(
			's.mpseller_id',
			'rating',
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY s.mpseller_id";
		}

		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC";
		} else {
			$sql .= " ASC";
		}

		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}

			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}

		$query = $this->db->query($sql);

		return $query->rows;
	}

	public function getTotalSellerStores($data = array()) {
		$sql = "SELECT COUNT(*) as total FROM " . DB_PREFIX . "mpseller s WHERE s.mpseller_id > 0 AND s.status = '1' AND s.approved = '1'";

		$query = $this->db->query($sql);

		return $query->row['total'];
	}

	public function getReviewInfo($mpseller_review_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "mpseller_review mr WHERE mr.mpseller_review_id = '" . (int)$mpseller_review_id . "'");

		return $query->row;
	}

	public function getReviews($mpseller_id, $start = 0, $limit = 20) {
		if ($start < 0) {
			$start = 0;
		}

		if ($limit < 1) {
			$limit = 20;
		}

		$query = $this->db->query("SELECT mr.mpseller_review_id, mr.author, mr.rating, mr.title, mr.description, mr.mpseller_id, mr.date_added FROM " . DB_PREFIX . "mpseller_review mr WHERE mr.mpseller_id = '" . (int)$mpseller_id . "' AND mr.status = '1' ORDER BY mr.date_added DESC LIMIT " . (int)$start . "," . (int)$limit);

		return $query->rows;
	}

	public function getTotalReviews($mpseller_id) {
		$sql = "SELECT COUNT(*) as total FROM " . DB_PREFIX . "mpseller_review mr WHERE mr.mpseller_id = '". (int)$mpseller_id ."' AND mr.status = '1'";

		$query = $this->db->query($sql);

		return $query->row['total'];
	}

	public function getInformationSections($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "mpseller_information_section WHERE mpseller_id = '". (int)$data['mpseller_id'] ."'";

		if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
			$sql .= " AND status = '" . (int)$data['filter_status'] . "'";
		}

		$sql .= " ORDER BY sort_order ASC";

		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}

			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}

		$query = $this->db->query($sql);

		return $query->rows;
	}

	public function getInformationSection($mpseller_information_section_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "mpseller_information_section WHERE mpseller_information_section_id = '" . (int)$mpseller_information_section_id . "' AND status = '1'");

		return $query->row;
	}
}