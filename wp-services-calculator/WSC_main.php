<?php

/**
 * Главная хрень wp-плагина
 *
 * @author Vladimir Lyubar <admin@uclg.ru>
 * @package wp-services-calculator
 */

/*
Plugin Name: wp-services-calculator
Plugin URI: http://lubar.ru/projects/wpServicesCalc
Description: Плагин для рассчета стоимости услуг
Version: 1.0
Author: Vladimir Lyubar
Author URI: http://lubar.ru
License: GPL2
 */

/*  Copyright 2014  Vladimir Lyubar  (email : admin@uclg.ru)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

/**
 * Подключение DataAccess
 */
require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'DataAccess' . DIRECTORY_SEPARATOR . 'Section.php';
require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'DataAccess' . DIRECTORY_SEPARATOR . 'Category.php';
require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'DataAccess' . DIRECTORY_SEPARATOR . 'Service.php';
require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'DataAccess' . DIRECTORY_SEPARATOR . 'Order.php';

/**
 * Подключение отображений
 */
require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'admin.php';

/**
 * Подключение логики
 */
require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'logic' . DIRECTORY_SEPARATOR . 'admin.php';

/**
 * Подключение класса плагина
 */
require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'plugin.php';

wp_enqueue_style('style', '/wp-content/plugins/wp-services-calculator/static/style.css', false, '0.1');

/**
 * Добавляем страницы администрирования плагина
 */
add_action('admin_menu', 'WSC_add_admin_pages');

/**
 * Функция добавляет ссылки для администрирования плагина в админское меню вордпресса
 */
function WSC_add_admin_pages()
{
    wp_enqueue_style('admin-style', '/wp-content/plugins/wp-services-calculator/static/admin-style.css', false, '0.1');

    add_menu_page('Калькулятор', 'Калькулятор', 8, __FILE__, '\WSC\Logic\Admin::main');
    add_submenu_page(__FILE__, 'Разделы', 'Разделы', 8, 'sections', '\WSC\Logic\Admin::sections');
    add_submenu_page(__FILE__, 'Категории', 'Категории', 8, 'categories', '\WSC\Logic\Admin::categories');
    add_submenu_page(__FILE__, 'Услуги', 'Услуги', 8, 'services', '\WSC\Logic\Admin::services');
}