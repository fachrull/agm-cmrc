<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Snap extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
		$this->load->helper('url');
        $this->load->model('Mhome', 'mhome');
        // TODO: get server-key
        $serverKey = $this->mhome->getProducts(NULL, NULL, 'midtrans_config', TRUE);
        $params = array('server_key' => $serverKey['server_key'], 'production' => false);
        $this->load->library('midtrans');
        $this->midtrans->config($params);
    }

    public function token()
    {
        $carts = $this->cart->contents();
        $address = $this->mhome->customer_detail($carts[key($carts)]['id_address']);

        $discount = 0;

				$item_details = array();
				foreach ($carts as $item) {
		    // special package item
            if($item['type'] == "special") {
                $item_detail = array(
                    'id' => $item['id'],
                    'price' => $item['price'],
                    'quantity' => $item['qty'],
                    'name' => $item['name']
                );
                array_push($item_details, $item_detail);

                foreach ($item['option'] as $option) {
                    $item_option = array(
                        'id' => $option['id_prod'],
                        'price' => 0,
                        'quantity' => $option['quantity'],
                        'name' => $option['name'].' - '.$option['nameSize']
                    );
                    array_push($item_details, $item_option);
                }
            } else {
                $item_detail = array(
                    'id' => $item['id'],
                    'price' => $item['price'],
                    'quantity' => $item['qty'],
                    'name' => $item['name'] . ' - ' . $item['sizeName']
                );
                array_push($item_details, $item_detail);
            }
        }

		// Voucher item
        $keys = array_keys($carts);
        $voucher = $carts[$keys[0]]["voucher"];

        if ($voucher != "") {
            $result = $this->mhome->getProducts(array('kode_voucher' => $voucher), array('discount', 'discount'), 'tm_voucher', TRUE);
            $discount = floatval($this->cart->total() * $result['discount']);

            $voucher_details = array(
                'id' => $voucher,
                'price' => (-1 * $discount),
                'quantity' => 1,
                'name' => "Voucher: " . $voucher
            );

            array_push($item_details, $voucher_details);
        }

        // Required
        $transaction_details = array(
            'order_id' => 'AGM'.date("dmy").rand(1, 999),
            'gross_amount' => ($this->cart->total() - $discount) // no decimal allowed for creditcard
        );

		// Optional
		$billing_address = array(
		  'first_name'    => $address['first_name'],
		  'last_name'     => $address['last_name'],
		  'address'       => $address['address'],
		  'city'          => $address['kabupaten'],
		  'postal_code'   => $address['postcode'],
		  'phone'         => $address['phone'],
		  'country_code'  => 'IDN'
		);

		// Optional
		$customer_details = array(
		  'first_name'    => $address['first_name'],
		  'last_name'     => $address['last_name'],
		  'email'         => $address['email'],
		  'phone'         => $address['phone'],
		  'billing_address'  => $billing_address,
		  'shipping_address' => $billing_address
		);

		// Data yang akan dikirim untuk request redirect_url.
        $credit_card['secure'] = true;
        //ser save_card true to enable oneclick or 2click
        //$credit_card['save_card'] = true;

        $time = time();
        $custom_expiry = array(
            'start_time' => date("Y-m-d H:i:s O",$time),
            'unit' => 'day',
            'duration'  => 1
        );

        $transaction_data = array(
            'transaction_details'=> $transaction_details,
            'item_details'       => $item_details,
            'customer_details'   => $customer_details,
            'credit_card'        => $credit_card,
            'expiry'             => $custom_expiry
        );

		error_log(json_encode($transaction_data));
		$snapToken = $this->midtrans->getSnapToken($transaction_data);
		error_log($snapToken);
		echo $snapToken;
    }

    public function finish()
    {
        /*
         * TODO:
         * 1. Check status code, fraud status, transaction status
         * Status code must be 2xx, fraud status must be ACCEPT
         * If status code and fraud staus none of the above, throw an error
         *
         * 2. Handle status code:
         * Please refer to https://api-docs.midtrans.com/#status-code for further description
         *
         * 3. Handle transaction status:
         * Please refer to https://api-docs.midtrans.com/#transaction-status for further description
         * These statues will trigger purchasing: pending, settlement and capture
         * These statues will trigger cancellation: cancel, expire and failure
         */
        $successStatusCode = array('200', '201', '202');
    	$result = json_decode($this->input->post('result_data'));
    	if (in_array($result->status_code, $successStatusCode)) {
    	    redirect('home/purchase/'.$result->order_id.'/'.$result->status_code);
        }
    	echo 'RESULT <br><pre>';
    	print_r($result);
    	echo '</pre>' ;

    }

    public function changeTransactionStatus($orderId, $transactionStatus) {
        $status = array('status_order' => $transactionStatus);
        $condition = array('order_number'=> $orderId);
        $this->mhome->updateData($condition, $status, 'tm_order');
        if($transactionStatus == 3) {
            $data['detailOrder'] = $this->mhome->getDetailOrder($orderId);

            foreach ($data['detailOrder'] as $item) {
                $id_tr_prod_size = $item->id_tr_product;
								$id_prod = $item->prod_id;
								$id_store = $item->id_store;
                $qty = $item->quantity;
                $qtyStore = $this->mhome->getProducts(
									array('id_store' => $id_store, 'id_product' => $id_prod, 'id_product_size' => $id_tr_prod_size),
									array('ppone' => 'postpone', 'sakhir' => 'stock_akhir'), 'tr_product', TRUE);
								$postpone = $qtyStore['postpone'] - $qty;
	              $stock_akhir = $qtyStore['stock_akhir'] + $qty;
	              $update_stock = array(
	                  'stock_akhir' => $stock_akhir,
	                  'postpone'    => $postpone
	              );
	              $this->mhome->updateData(array('id_product_size' => $id), $update_stock, 'tr_product');
						}
        } else if ($transactionStatus == 4) {
            $data['detailOrder'] = $this->mhome->getDetailOrder($orderId);
            foreach ($data['detailOrder'] as $item) {
							$id_tr_prod_size = $item->id_tr_product;
							$id_prod = $item->prod_id;
							$id_store = $item->id_store;
							$qty = $item->quantity;
                $qtyStore = $this->mhome->getProducts(
									array('id_store' => $id_store, 'id_product' => $id_prod, 'id_product_size' => $id_tr_prod_size),
									array('postpone' => 'postpone', 'outbound' => 'outbound', 'id_store' => 'id_store',
									 'id_product_size' => 'id_product_size'), 'tr_product', TRUE);
                $postpone = $qtyStore['postpone'] - $qty;
                $outbound = $qtyStore['outbound'] + $qty;
                $update_stock = array(
                    'outbound' => $outbound,
                    'postpone'    => $postpone
                );
                $history_inbound = array(
                    'id_prod_size'  => $qtyStore['id_product_size'],
                    'id_store'      => $qtyStore['id_store'],
										'invoice'				=> $orderId,
                    'quantity'      => $outbound * -1
                );
                $this->mhome->inputData('tr_stock', $history_inbound);
                $this->mhome->updateData(
									array('id_store' => $id_store, 'id_product' => $id_prod, 'id_product_size' => $id_tr_prod_size),
								 $update_stock, 'tr_product');
                print_r($qtyStore);
            }
        }
    }

    public function cancel($orderId) {
	    $this->midtrans->cancel($orderId);
        redirect('home/transactionPage');
    }

    public function notification()
    {
        echo 'test notification handler\n';
        $json_result = file_get_contents('php://input');
        $result = json_decode($json_result);
        if($result){
            $notif = $this->midtrans->status($result->order_id);
        }
        error_log(print_r($result,TRUE));
        //notification handler sample
        $transaction = $notif->transaction_status;
        $type = $notif->payment_type;
        $order_id = $notif->order_id;
        $fraud = $notif->fraud_status;
        if ($transaction == 'capture') {
            // For credit card transaction, we need to check whether transaction is challenge by FDS or not
            if ($type == 'credit_card'){
                if($fraud == 'challenge'){
                    // TODO set payment status in merchant's database to 'Challenge by FDS'
                    // TODO merchant should decide whether this transaction is authorized or not in MAP
                    echo "Transaction order_id: " . $order_id ." is challenged by FDS";
                }
                else {
                    // TODO set payment status in merchant's database to 'Success'
                    $this->changeTransactionStatus($order_id, 4);
                    echo "Transaction order_id: " . $order_id ." successfully captured using " . $type;
                }
            }
        }
        else if ($transaction == 'settlement'){
            if ($type != 'credit_card') {
                // TODO set payment status in merchant's database to 'Settlement'
                $this->changeTransactionStatus($order_id, 4);
                echo "Transaction order_id: " . $order_id ." successfully transfered using " . $type;
            }
        }
        else if($transaction == 'pending'){
            // TODO set payment status in merchant's database to 'Pending'
            echo "Waiting customer to finish transaction order_id: " . $order_id . " using " . $type;
        }
        else if ($transaction == 'deny') {
            // TODO set payment status in merchant's database to 'Denied'
            $this->changeTransactionStatus($order_id, 3);
            echo "Payment using " . $type . " for transaction order_id: " . $order_id . " is denied.";
        } else if ($transaction == 'expire') {
            // TODO set payment status in merchant's database to 'Denied'
            $this->changeTransactionStatus($order_id, 3);
            echo "Payment using " . $type . " for transaction order_id: " . $order_id . " is expire.";
        } else if ($transaction == 'cancel') {
            // TODO set payment status in merchant's database to 'Denied'
            $this->changeTransactionStatus($order_id, 3);
            echo "Payment using " . $type . " for transaction order_id: " . $order_id . " is cancel.";
        }
    }
}
