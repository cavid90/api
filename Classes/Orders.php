<?php
/**
 * Created by PhpStorm.
 * User: kcavi
 * Date: 16.09.2018
 * Time: 21:55
 */

namespace Classes;


class Orders extends Api
{
    private $table = 'orders';
    public function __construct()
    {
        
    }

    /**
     * @return string
     * Get table name of orders
     */
    public function table()
    {
        return $this->table;
    }

    /**
     * @param $data
     * @return string
     * Create an order
     */
    public function create($data)
    {

        $url = "https://maps.googleapis.com/maps/api/distancematrix/json?origins=".$data['origin'][0].",".$data['origin'][1]."&destinations=".$data['destination'][0].",".$data['destination'][1]."&mode=driving&language=pl-PL";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $response = curl_exec($ch);
        curl_close($ch);
        $response_a = json_decode($response, true);
        $distance = $response_a['rows'][0]['elements'][0]['distance']['text'];

        $insert_data_array = [
            'distance' => $distance,
            'status' => 'UNASSIGN'
        ];
        $new_row_id = Db::getInstance()->insert($this->table,$insert_data_array);

        if($new_row_id) {
            $result['id'] = $new_row_id;
            $result = array_merge($result,$insert_data_array);
            $responseStatusCode = 200;
        } else {
            $result = [
                'error'=> 'UNABLE TO CREATE ORDER'
            ];
            $responseStatusCode = 409;
        }

        return $this->response($result,$responseStatusCode);
    }

    /**
     * @param $id
     * @return string
     * Take the order and set status to "taken"
     */
    public function take($id)
    {
        $order_status = 'taken';
        $row = Db::getInstance()->raw("SELECT `status` FROM {$this->table} WHERE `id` = '".$id."' LIMIT 1 ")->fetch();
        if(!$row || $row['status'] == 'taken') {
            $data = [
                "error" => "ORDER_ALREADY_BEEN_TAKEN"
            ];
            $responseStatusCode = 409;
        } else {
            Db::getInstance()->raw("UPDATE {$this->table} SET `status` = '".$order_status."' WHERE `id` = '".$id."' ");
            $data = [
                'status' => $order_status
            ];

            $responseStatusCode = 200;
        }

        return $this->response($data,$responseStatusCode);
    }


    /**
     * @return string
     * Get list of orders (records)
     */
    public function records()
    {
       $results = Db::getInstance()->raw("SELECT `id`, `status`, `distance` FROM {$this->table} ".$this->limitSql())->fetchAll(\PDO::FETCH_ASSOC);
       return $this->response($results,200);
    }
}