<?php

namespace WSC\DataAccess;

/**
 * Class Order
 *
 * DataAccess заказа
 *
 * @author Vladimir Lyubar <admin@uclg.ru>
 * @package wp-services-calculator
 * @subpackage DataAccess
 */
class Order
{
    /**
     * Возвращает все заказы
     * @return array
     */
    public static function getAll()
    {
        global $wpdb;

        $sql = "SELECT * FROM {$wpdb->prefix}_WSC_orders ORDER BY id DESC";

        return $wpdb->get_results($sql, ARRAY_A);
    }


    /**
     * Добалвяет заказ в бд
     */
    public static function add($name, $phone, $comment, $description)
    {
        $name = mysql_real_escape_string($name);
        $phone = mysql_real_escape_string($phone);
        $comment = mysql_real_escape_string($comment);
        $description = mysql_real_escape_string($description);

        global $wpdb;

        $sql = "
            INSERT INTO {$wpdb->prefix}_WSC_orders (name, phone, comment, description) VALUES ('{$name}', '{$phone}', '{$comment}', '{$description}')
        ";

        $wpdb->query($sql);
    }
}