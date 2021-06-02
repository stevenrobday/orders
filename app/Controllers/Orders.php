<?php namespace App\Controllers;

use App\Models\OrdersModel;
use CodeIgniter\Controller;
use DateTime;
use DateTimeZone;

class Orders extends Controller
{
    public function index($orderClass = null, $reset = false, $fromDate = null, $toDate = null, $storefront = null)
    {
        $model = new OrdersModel();
        $session = \Config\Services::session();

        if (!isset($orderClass))
        {
            $orderClass = 0;
            $reset = true;
        }

        if (!$session->has('fromDate') || $reset == "true")
        {
            $fromDate = new DateTime();
            $fromDate->setTimezone(new DateTimeZone('America/Phoenix'));
            $session->set('fromDate', $fromDate->format('m/d/Y'));
        }
        elseif (!isset($fromDate))
        {
            $fromDate = new DateTime($session->fromDate);
        }
        else
        {
            $fromDate = DateTime::createFromFormat('m-d-Y', $fromDate);
            $session->set('fromDate', $fromDate->format('m/d/Y'));
        }

        if (!$session->has('toDate') || $reset == "true")
        {
            $toDate = new DateTime();
            $toDate->setTimezone(new DateTimeZone('America/Phoenix'));
            $session->set('toDate', $toDate->format('m/d/Y'));
        }
        elseif (!isset($toDate))
        {
            $toDate = new DateTime($session->toDate);
        }
        else
        {
            $toDate = DateTime::createFromFormat('m-d-Y', $toDate);
            $session->set('toDate', $toDate->format('m/d/Y'));
        }

        $fromDate = $fromDate->format('Y-m-d');
        $toDate = $toDate->format('Y-m-d');

        if (isset($storefront)) $session->set('storefront', $storefront);
        elseif (!$session->has('storefront') || $reset == "true")
        {
            $session->set('storefront', 'all');
        }

        $storefront = $session->storefront;

        $data['orders'] = $model->getOrders($orderClass, $fromDate, $toDate, $storefront);
        $data['orderClass'] = $orderClass;
        $data['fromDate'] = $session->fromDate;
        $data['toDate'] = $session->toDate;
        $data['storefront'] = $storefront;

        echo view('templates/header', $data);
        echo view('orders/home', $data);
        echo view('templates/footer', $data);
    }

    public function changeOrderStatus()
    {
        $post = service('request')->getPost();

        $model = new OrdersModel();
        $model->changeOrderStatus($post['orderClass'], $post['selectedOrders']);

        return json_encode(['success'=> 'success']);
    }

    public function selectFields()
    {
        $post = service('request')->getPost();
        $fieldArray = strlen($post['fields']) ? $post['fields'] : NULL;

        $model = new OrdersModel();
        $model->selectFields($post['orderNum'], $fieldArray);
    }

    public function search($orderClass, $params)
    {
        $session = \Config\Services::session();
        $model = new OrdersModel();

        $data['params'] = $params;
        $params = explode(" ", $params);

        $data['orders'] = $model->search($orderClass, $params);
        $data['orderClass'] = $orderClass;
        $data['fromDate'] = $session->fromDate;
        $data['toDate'] = $session->toDate;
        $data['storefront'] = "all";

        echo view('templates/header', $data);
        echo view('orders/home', $data);
        echo view('templates/footer', $data);
    }
}