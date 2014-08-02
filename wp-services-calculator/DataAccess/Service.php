<?php

namespace WSC\DataAccess;

/**
 * Class Service
 *
 * DataAccess услуги
 *
 * @author Vladimir Lyubar <admin@uclg.ru>
 * @package wp-services-calculator
 * @subpackage DataAccess
 */
class Service
{
    /**
     * Возвращает услугу по id
     * @param $id
     * @return array
     */
    public static function get($id, $deleted = false)
    {
        $id = (int)$id;

        global $wpdb;

        $delWhere = 'AND deleted=0';
        if($deleted)
            $delWhere = '';

        $sql = "SELECT * FROM {$wpdb->prefix}_WSC_services WHERE id={$id} {$delWhere}";
        return $wpdb->get_row($sql, ARRAY_A);
    }


    /**
     * Возвращает услуги по id категории
     * @param $categoryID
     */
    public static function getByCategory($categoryID)
    {
        $categoryID = (int)$categoryID;

        global $wpdb;

        $sql = "SELECT * FROM {$wpdb->prefix}_WSC_services WHERE category_id={$categoryID} ORDER BY name";
        return $wpdb->get_results($sql, ARRAY_A);
    }


    /**
     * Возвращает все услуги
     * @param $deleted
     * @return array
     */
    public static function getAll($deleted = false)
    {
        global $wpdb;

        $delWhere = 'WHERE services.deleted=0';
        if($deleted)
            $delWhere = '';

        $sql = "
            SELECT
                services.*,
                sections.name AS section_name,
                categories.name AS category_name
            FROM
                {$wpdb->prefix}_WSC_services AS services
                LEFT JOIN {$wpdb->prefix}_WSC_sections AS sections
                ON sections.id = services.section_id
                LEFT JOIN {$wpdb->prefix}_WSC_categories AS categories
                ON categories.id = services.category_id

            {$delWhere}

            ORDER BY
                section_name,
                category_name,
                services.name
        ";

        return $wpdb->get_results($sql, ARRAY_A);
    }


    /**
     * Сохраняет услугу
     */
    public static function save($id, $section_id, $category_id, $name, $description, $cost, $many, $maxCount)
    {
        $id = (int)$id;
        $section_id = (int)$section_id;
        $category_id = (int)$category_id;
        $name = mysql_real_escape_string($name);
        $description = mysql_real_escape_string($description);
        $cost = (int)$cost;
        $many = (int)$many;
        $maxCount = (int)$maxCount;

        global $wpdb;

        $sql = "
            UPDATE {$wpdb->prefix}_WSC_services
            SET
                section_id = {$section_id},
                category_id = {$category_id},
                name = '{$name}',
                description = '{$description}',
                cost = {$cost},
                many = {$many},
                maxCount = {$maxCount}

            WHERE
                id={$id}
        ";
        $wpdb->query($sql);
    }


    /**
     * Добавляет услугу
     */
    public static function add($section_id, $category_id, $name, $description, $cost, $many, $maxCount)
    {
        $section_id = (int)$section_id;
        $category_id = (int)$category_id;
        $name = mysql_real_escape_string($name);
        $description = mysql_real_escape_string($description);
        $cost = (int)$cost;
        $many = (int)$many;
        $maxCount = (int)$maxCount;

        global $wpdb;

        $sql = "
            INSERT INTO {$wpdb->prefix}_WSC_services (section_id, category_id, name, description, cost, many, maxCount)
            VALUES ({$section_id}, {$category_id}, '{$name}', '{$description}', {$cost}, {$many}, {$maxCount})
        ";

        $wpdb->query($sql);
    }

    /**
     * Удаляет услугу по переданному id
     * @param $id
     */
    public static function delete($id)
    {
        $id = (int)$id;

        global $wpdb;

        $sql = "UPDATE {$wpdb->prefix}_WSC_services SET deleted=1 WHERE id={$id}";
        $wpdb->query($sql);
    }


    /**
     * Восстанавливает услугу по переданному id
     * @param $id
     */
    public static function restore($id)
    {
        $id = (int)$id;

        global $wpdb;

        $sql = "UPDATE {$wpdb->prefix}_WSC_services SET deleted=0 WHERE id={$id}";
        $wpdb->query($sql);
    }
}