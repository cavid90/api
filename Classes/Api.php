<?php
/**
 * Created by PhpStorm.
 * User: kcavi
 * Date: 16.09.2018
 * Time: 21:55
 */

namespace Classes;


class Api
{

    /**
     * @param $data
     * @param int $status
     * @return string
     */
    public function response($data,$status=200)
    {
        http_response_code($status);
        return json_encode($data);
    }

    /**
     * @return string
     * Make automatic Limit string for sql query
     */
    public function limitSql()
    {
        $page = (isset($_GET['page']) && (int) $_GET['page'] > 0 ) ? (int)$_GET['page'] : 1;
        $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 10;
        $limitStartIndex = ($page-1)*$limit;
        return "LIMIT $limitStartIndex,$limit";
    }
}