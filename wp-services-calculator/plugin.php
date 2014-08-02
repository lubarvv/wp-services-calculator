<?php

namespace WSC;

use \WSC\DataAccess\Section;
use \WSC\DataAccess\Category;
use \WSC\DataAccess\Service;

/**
 * Class Plugin
 *
 * Класс плагина
 *
 * @author Vladimir Lyubar <admin@uclg.ru>
 * @package wp-services-calculator
 */
class Plugin
{
    /**
     * Отображение калькулятора
     */
    public static function show()
    {
        $sections = Section::getAll();

        wp_enqueue_script("jquery-ui-dialog", array('jquery','jquery-ui-core'));
        wp_enqueue_style("wp-jquery-ui-dialog");

        ?>
        <script src="/wp-content/plugins/wp-services-calculator/static/calc.js"></script>

        <div id="WSC_resultInfo">
            Итого: <span id="WSC_sum">0</span> р.
            <a href="#" onclick="WSC_calc.showOrderForm(); return false;">Оформить заказ</a>
        </div>

        <div id="WSC_order" class="hidden">
            <input type="text" id="WSC_orderName" placeholder="ФИО"/>
            <input type="text" id="WSC_orderPhone" placeholder="Номер телефона"/>
            <textarea id="WSC_orderComment" placeholder="Комментарий к заказу"></textarea>
            <pre id="WSC_orderDescription"></pre>
            <input type="button" value="Оформить" onclick="WSC_calc.sendOrderForm(); return false;"/>
        </div>

        <div id="WSC_container">

            <div id="WSC_sections">
                <?php foreach ($sections as $section): ?>
                    <div class="WSC_section" data-id="<?php echo $section['id'] ?>">
                        <?php echo $section['name']; ?>
                    </div>
                <?php endforeach; ?>
            </div>

            <div id="WSC_sectionsContent">

                <div id="WSC_sectionsContentPlaceholder" class="WSC_sectionContent">
                    Выберите категорию услуг слева.
                </div>

                <?php foreach ($sections as $section): ?>
                    <div id="WSC_sectionContent_<?php echo $section['id']; ?>" class="WSC_sectionContent hidden" data-id="<?php echo $section['id']; ?>" data-name="<?php echo $section['name']; ?>">

                        <?php foreach (Category::getBySection($section['id']) as $category): ?>
                            <div class="WSC_sectionCategory" data-id="<?php echo $category['id']; ?>" data-name="<?php echo $category['name']; ?>">

                                <div class="WSC_sectionCategoryTitle">
                                    <span><?php echo $category['name']; ?></span>
                                    <p><?php echo $category['description']; ?></p>
                                </div>

                                <div class="WSC_sectionCategoryServices">
                                    <?php foreach (Service::getByCategory($category['id']) as $service): ?>
                                        <div class="WSC_service" data-name="<?php echo $service['name']; ?>" data-cost="<?php echo $service['cost']; ?>">
                                            <div class="wrap_name pull-left"><?php echo $service['name']; ?></div>
                                            <div class="wrap_available pull-left">
                                                <?php if ($service['many']): ?>
                                                    Доступно: <?php echo $service['maxCount']; ?>
                                                <?php endif; ?>
                                            </div>
                                            <div class="WSC_serviceCostContainer wrap_cost pull-right">
                                                <?php echo $service['cost']; ?><i class="fa fa-rub"></i>
                                            </div>

                                            <div class="wrap_checkbox pull-right">
                                                <input type="checkbox" class="WSC_serviceCheck"/>
                                                <input type="hidden" class="WSC_serviceCostValue" value="<?php echo $service['cost']; ?>"/>
                                                <input type="hidden" class="WSC_serviceManyValue" value="<?php echo $service['many']; ?>"/>
                                            </div>

                                            <div class="wrap_many pull-right">
                                                <?php if ($service['many']): ?>
                                                    <input type="text" class="WSC_serviceCount" size="3" value="1"/>
                                                <?php endif; ?>
                                            </div>

                                            <div class="wrap_desc">
                                                <?php echo $service['description']; ?>
                                            </div>

                                        </div>
                                    <?php endforeach; ?>
                                </div>

                            </div>
                        <?php endforeach; ?>

                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php
    }


    /**
     * Создание таблиц при активации плагина
     */
    public static function activate()
    {
        global $wpdb;

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta("
            CREATE TABLE IF NOT EXISTS {$wpdb->prefix}_WSC_services (
                  id int(1) NOT NULL AUTO_INCREMENT,
                  section_id int(1) DEFAULT NULL,
                  category_id int(1) DEFAULT NULL,
                  name varchar(250) NOT NULL,
                  description text,
                  cost int(1) NOT NULL,
                  maxCount int(1) DEFAULT NULL,
                  many int(1) DEFAULT NULL,
                  deleted tinyint(1) NOT NULL DEFAULT '0',
                  PRIMARY KEY (id)
            ) ENGINE=InnoDB  DEFAULT CHARSET=utf8;
        ");

        dbDelta("
            CREATE TABLE IF NOT EXISTS {$wpdb->prefix}_WSC_sections (
                  id int(1) NOT NULL AUTO_INCREMENT,
                  name varchar(250) NOT NULL,
                  deleted tinyint(1) NOT NULL DEFAULT '0',
                  PRIMARY KEY (id)
            ) ENGINE=InnoDB  DEFAULT CHARSET=utf8;
        ");

        dbDelta("
            CREATE TABLE IF NOT EXISTS {$wpdb->prefix}_WSC_categories (
                  id int(1) NOT NULL AUTO_INCREMENT,
                  section_id int(1) NOT NULL,
                  description text,
                  name varchar(250) NOT NULL,
                  deleted tinyint(1) NOT NULL DEFAULT '0',
                  PRIMARY KEY (id)
            ) ENGINE=InnoDB  DEFAULT CHARSET=utf8;
        ");


        dbDelta("
            CREATE TABLE IF NOT EXISTS {$wpdb->prefix}_WSC_orders (
                  id int(1) NOT NULL AUTO_INCREMENT,
                  name varchar(200) NOT NULL,
                  phone varchar(100) NOT NULL,
                  comment TEXT,
                  description TEXT,
                  PRIMARY KEY (id)
            ) ENGINE=InnoDB  DEFAULT CHARSET=utf8;
        ");
    }
}
