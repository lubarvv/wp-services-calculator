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
     * Редактирование раздела
     */
    public static function sectionEdit()
    {
        if(!isset($_REQUEST['save'])) {
            AdminView::sectionEditForm();
        } else {
            Section::save($_REQUEST['id'], $_REQUEST['name']);
            echo 'Раздел сохранен';
        }
    }


    /**
     * Удаление/восстановление раздела
     */
    public static function sectionDelete()
    {
        if(Section::get($_REQUEST['id'], true)['deleted'] == 0) {
            Section::delete($_REQUEST['id']);
            echo 'Раздел удален';
        } else {
            Section::restore($_REQUEST['id']);
            echo 'Раздел восстановлен';
        }
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
     * Удаление/восстановление категории
     */
    public static function categoryDelete()
    {
        if(Category::get($_REQUEST['id'], true)['deleted'] == 0) {
            Category::delete($_REQUEST['id']);
            echo 'Категория удалена';
        } else {
            Category::restore($_REQUEST['id']);
            echo 'Категория восстановлена';
        }
    }


    /**
     * Редактирование категории
     */
    public static function categoryEdit()
    {
        if(!isset($_REQUEST['save'])) {
            AdminView::categoryEditForm();
        } else {
            Category::save($_REQUEST['id'], $_REQUEST['name'], $_REQUEST['description']);
            echo 'Катгория сохранена';
        }
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
     * Удаление/восстановление услуги
     */
    public static function serviceDelete()
    {
        if(Service::get($_REQUEST['id'], true)['deleted'] == 0) {
            Service::delete($_REQUEST['id']);
            echo 'Услуга удалена';
        } else {
            Service::restore($_REQUEST['id']);
            echo 'Услуга восстановлена';
        }
    }


    /**
     * Редактирование услуги
     */
    public static function serviceEdit()
    {
        if(!isset($_REQUEST['save'])) {
            AdminView::serviceEditForm();
        } else {
            Service::save(
                $_REQUEST['id'],
                $_REQUEST['section_id'],
                $_REQUEST['category_id'],
                $_REQUEST['name'],
                $_REQUEST['description'],
                $_REQUEST['cost'],
                $_REQUEST['many'],
                $_REQUEST['maxCount']
            );
            echo 'Услуга сохранена';
        }
    }


    /**
     * Главная страница администрирования заказов
     */
    public static function ordersMain()
    {
    }

}