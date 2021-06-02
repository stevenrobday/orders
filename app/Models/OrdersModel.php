<?php namespace App\Models;

use CodeIgniter\Model;
use DateTime;

class OrdersModel extends Model
{
    protected $table = 'order_detail';

    protected $allowedFields = ['order_id', 'sku', 'title', 'quantity', 'vendor', 'weight', 'price', 'total_discount'];

    public function getOrders($orderClass, $fromDate, $toDate, $storefront)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('order_meta');
        $builder->select('uid, created_at, order_num, gateway, total_qty, total_price_usd, 
                                subtotal_price, total_tax, total_discounts, total_ship_price, ship_method, track_num,
                                ship_addr, bill_addr, tags, storefront, status');
        $builder->where('status', $orderClass);
        $builder->where("created_at >=", $fromDate . ' 00:00:00');
        $builder->where("created_at <=", $toDate . ' 23:59:59');
        if ($storefront !== "all") $builder->where('storefront', $storefront);
        $builder->orderBy('created_at', 'DESC');
        $query = $builder->get();

        $rows = $query->getResultArray();
        return $this->getAdditionalFields($rows);
    }

    private function getAdditionalFields($rows)
    {
        foreach ($rows as &$row)
        {
            $datetime = new DateTime($row['created_at']);
            $row['created_at'] = $datetime->format('m/d/Y h:i A');
            $row['ship_addr'] = json_decode($row['ship_addr'], true);
            $row['bill_addr'] = json_decode($row['bill_addr'], true);
            $row['line_items'] = $this->asArray()
                ->where(['order_id' => $row['order_num']])
                ->findAll();

            $db = \Config\Database::connect();
            $builder = $db->table('selected_fields');
            $builder->select('fields');
            $builder->where('order_id', $row['order_num']);
            $query = $builder->get();
            $fieldArray = $query->getResultArray();
            $row['fields'] = $fieldArray[0]['fields'] ?? '';
        }

        return $rows;
    }

    public function changeOrderStatus($orderClass, $selectedOrders)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('order_meta');
        foreach ($selectedOrders as $uid)
        {
            $builder->set('status', $orderClass);
            $builder->where('uid', $uid);
            $builder->update();
        }
    }

    public function search($orderClass, $params)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('order_meta');

        $builder->select('uid, created_at, order_num, gateway, total_qty, total_price_usd, 
                                subtotal_price, total_tax, total_discounts, total_ship_price, ship_method, track_num,
                                ship_addr, bill_addr, tags, storefront, status');
        $builder->where('status', $orderClass);
        $builder->groupStart();

        $length = count($params);
        for ($i = 0; $i < $length; $i++)
        {
            if ($i === 0) $builder->like('order_num', $params[0]);
            else $builder->orLike('order_num', $params[$i]);
            $builder->orLike('email', $params[$i]);
            $builder->orLike('ship_addr', $params[$i]);
            $builder->orLike('bill_addr', $params[$i]);
            $builder->orLike('tags', $params[$i]);
        }
        $builder->groupEnd();

        $builder->orderBy('created_at', 'DESC');
        $query = $builder->get();
        $rows = $query->getResultArray();
        return $this->getAdditionalFields($rows);
    }

    public function selectFields($orderNum, $fieldsArray)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('selected_fields');

        $builder->select('order_id');
        $builder->where('order_id', $orderNum);
        $query = $builder->get();
        $rows = $query->getResultArray();

        if (count($rows))
        {
            $builder->set('fields', $fieldsArray);
            $builder->where('order_id', $orderNum);
            $builder->update();
        }
        else
        {
            $builder->set('order_id', $orderNum);
            $builder->set('fields', $fieldsArray);
            $builder->insert();
        }
    }
}