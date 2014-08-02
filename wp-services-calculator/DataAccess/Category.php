<?php

namespace WSC\DataAccess;

/**
 * Class WSC_Category
 *
 * DataAccess категории
 *
 * @author Vladimir Lyubar <admin@uclg.ru>
 * @package wp-services-calculator
 * @subpackage DataAccess
 */
class Category
{
    /**
     * Возвращает катгорию по id
     * @param $id
     * @param $deleted
     * @return array
     */
    public static function get($id, $deleted = false)
    {
        $id = (int)$id;

        global $wpdb;

        $delWhere = 'AND deleted=0';
        if($deleted)
            $delWhere = '';

        $sql = "SELECT * FROM {$wpdb->prefix}_WSC_categories WHERE id={$id} {$delWhere}";
        return $wpdb->get_row($sql, ARRAY_A);
    }


    /**
     * Возвращает категории раздела по его id
     * @param $sectionID
     * @return array
     */
    public static function getBySection($sectionID)
    {
        $sectionID = (int)$sectionID;

        global $wpdb;

        $sql = "SELECT * FROM {$wpdb->prefix}_WSC_categories WHERE section_id = {$sectionID} ORDER BY name";
        return $wpdb->get_results($sql, ARRAY_A);
    }


    /**
     * Возвращает все категории
     * @param $deleted
     * @return array
     */
    public static function getAll($deleted = false)
    {
        global $wpdb;

        $delWhere = 'AND cat.deleted=0';
        if($deleted)
            $delWhere = '';

        $sql = "
            SELECT
                cat.*,
                sec.name AS section_name

            FROM
                {$wpdb->prefix}_WSC_categories AS cat
                JOIN {$wpdb->prefix}_WSC_sections AS sec
                ON sec.id = cat.section_id

            {$delWhere}

            ORDER BY name
        ";

        return $wpdb->get_results($sql, ARRAY_A);
    }


    /**
     * Сохраняет категорию
     */
    public static function save($id, $name, $description)
    {
        $id = (int)$id;
        $name = mysql_real_escape_string($name);
        $description = mysql_real_escape_string($description);

        global $wpdb;

        $sql = "UPDATE {$wpdb->prefix}_WSC_categories SET name='{$name}', description='{$description}' WHERE id={$id}";
        $wpdb->query($sql);
    }


    /**
     * Доавляет категорию с именем $name
     * @param $section_id
     * @param $name
     * @param $description
     */
    public static function add($section_id, $name, $description)
    {
        $section_id = (int)$section_id;
        $name = mysql_real_escape_string($name);
        $description = mysql_real_escape_string($description);

        global $wpdb;

        $sql = "INSERT INTO {$wpdb->prefix}_WSC_categories (section_id, name, description) VALUES ({$section_id}, '{$name}', '{$description}')";
        $wpdb->query($sql);
    }

    /**
     * Удаляет категорию по переданному id
     * @param $id
     */
    public static function delete($id)
    {
        $id = (int)$id;

        global $wpdb;

        $sql = "UPDATE {$wpdb->prefix}_WSC_categories SET deleted=1 WHERE id={$id}";
        $wpdb->query($sql);
    }


    /**
     * Восстанавливает категорию по переданному id
     * @param $id
     */
    public static function restore($id)
    {
        $id = (int)$id;

        global $wpdb;

        $sql = "UPDATE {$wpdb->prefix}_WSC_categories SET deleted=0 WHERE id={$id}";
        $wpdb->query($sql);
    }
}