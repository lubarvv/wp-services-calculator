<?php

namespace WSC\Logic;

use WSC\Views\Admin as AdminView;
use WSC\DataAccess\Section;
use WSC\DataAccess\Category;
use WSC\DataAccess\Service;
use WSC\DataAccess\Order;

/**
 * Class WSC_admin
 *
 * Класс с методами для администрирования плагина
 *
 * @author Vladimir Lyubar <adin@uclg.ru>
 * @package wp-services-calculator
 * @subpackage Logic
 */
class Admin
{

    /**
     * Главная страница админки
     */
    public static function main()
    {
        echo 'test';
    }


    /**
     * Роутер управления разделами
     */
    function sections()
    {
        switch(@$_REQUEST['action']) {
            case 'add': self::sectionAdd(); break;
            case 'edit': self::sectionEdit(); break;
            case 'delete': self::sectionDelete(); break;
            default: self::sectionsMain();
        }
    }

    /**
     * Роутер управления категориями
     */
    function categories()
    {
        switch(@$_REQUEST['action']) {
            case 'add': self::categoryAdd(); break;
            case 'edit': self::categoryEdit(); break;
            case 'delete': self::categoryDelete(); break;
            default: self::categoriesMain();
        }
    }

    /**
     * Роутер управления услугами
     */
    function services()
    {
        switch(@$_REQUEST['action']) {
            case 'add': self::serviceAdd(); break;
            case 'edit': self::serviceEdit(); break;
            case 'delete': self::serviceDelete(); break;
            default: self::servicesMain();
        }
    }


    /**
     * Главная страница администрирования разделов
     */
    public static function sectionsMain()
    {
        AdminView::sectionAddForm();
        AdminView::sectionsView();
    }


    /**
     * Добавление раздела
     */
    public static function sectionAdd()
    {
        Section::add($_REQUEST['name']);

        echo 'Раздел добавлен';
    }


    /**
     * Галваня страница администрирования категорий
     */
    public static function categoriesMain()
    {
        AdminView::categoryAddForm();
        AdminView::categoriesView();
    }


    /**
     * Добавление категории
     */
    public static function categoryAdd()
    {
        Category::add($_REQUEST['section_id'], $_REQUEST['name'], $_REQUEST['description']);

        echo 'Категория добавлена';
    }


    /**
     * Главная страница администрирования услуг
     */
    public static function servicesMain()
    {
        AdminView::serviceAddForm();
        AdminView::servicesView();
    }


    /**
     * Добавление услуги
     */
    public static function serviceAdd()
    {
        Service::add(
            $_REQUEST['section_id'],
            $_REQUEST['category_id'],
            $_REQUEST['name'],
            $_REQUEST['description'],
            $_REQUEST['cost'],
            $_REQUEST['many'],
            $_REQUEST['maxCount']
        );

        echo 'Услуг добавлена';
    }


    /**
     * Главная страница администрирования заказов
     */
    public static function ordersMain()
    {

    }

}