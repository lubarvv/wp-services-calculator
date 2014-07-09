<?php
/*
Plugin Name: wpServicesCalc
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

function services_calculator()
{
    $content = WSC_getContent();

    ?>
    <link rel="stylesheet" href="/wp-content/plugins/services-calculator/style.css" />
    <div class="calcServicesContainer">
        <?php foreach($content as $section): ?>
            <div class="calcSection>">
                <div class="calcSectionName"><?php echo $section['name']; ?></div>
                <div class="calcSectionCategories">
                    <?php foreach($section['categories'] as $category): ?>
                        <div class="calcSectionCategory">
                            <p class="calcSectionCategoryTitle"><?php $category['name']; ?></p>
                            <p class="calcSectionCategoryDescription"><?php $category['description']; ?></p>

                            <div class="calcSectionCateroryServices">
                                <?php foreach($category['services'] as $service): ?>
                                    <div class="calcCategoryService">
                                        <p class="calcCategoryServiceTitle"><?php $service['name']; ?></p>
                                        <p class="calcCategoryServiceDescription"><?php $service['description']; ?></p>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="calcSectionServices">';
                    <?php foreach($section['categories'] as $service): ?>
                        <div class="calcSectionService">
                            <p class="calcSectionServiceTitle"><?php echo $service['name']; ?></p>
                            <p class="calcSectionServiceDescription"><?php echo $service['description']; ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <?php
}

function WSC_getCreateDBSQL()
{
    global $wpdb;

    return "
        CREATE TABLE {$wpdb->prefix}wpServicesCalc_sections (
            id                    INT(1)              PRIMARY KEY NOT NULL AUTO_INCREMENT,
            name                  VARCHAR(250)        NOT NULL
        );

        CREATE TABLE {$wpdb->prefix}wpServicesCalc_categories (
            id                    INT(1)              PRIMARY KEY NOT NULL AUTO_INCREMENT,
            section_id            INT(1)              NOT NULL,
            description           TEXT,
            name                  VARCHAR(250)        NOT NULL
        );

        CREATE TABLE {$wpdb->prefix}wpServicesCalc_services (
            id                    INT(1)              PRIMARY KEY NOT NULL AUTO_INCREMENT,
            section_id            INT(1),
            category_id           INT(1),
            name                  VARCHAR(250)        NOT NULL,
            description           TEXT,
            cost                  INT(1)              NOT NULL,
            maxCount              INT(1),
            many                  INT(1)
        );
    ";
}

function WSC_getContent()
{
    $sections = WSC_getSections();

    for($i=0; $i<count($sections); $i++) {

        $sections[$i]['categories'] = WSC_getSectionCategories($sections[$i]['id']);

        for($j=0; $j<count($sections[$i]['categories']); $j++) {
            $sections[$i]['categories'][$j]['services'] = WSC_getCategoryServices($sections[$i]['categories'][$j]['id']);
        }

        $sections[$i]['services'] = WSC_getSectionServices($sections[$i]['id']);
    }

    return $sections;
}

function WSC_getSections()
{
    global $wpdb;

    $sql = "SELECT * FROM {$wpdb->prefix}wpServicesCalc_sections ORDER BY name";
    return $wpdb->get_results($sql, ARRAY_A);
}

function WSC_getSectionCategories($section_id)
{
    global $wpdb;

    $sql = "SELECT * FROM {$wpdb->prefix}wpServicesCalc_categories WHERE section_id={$section_id} ORDER BY name";
    return $wpdb->get_results($sql, ARRAY_A);
}

function WSC_getSectionServices($section_id)
{
    global $wpdb;

    $sql = "SELECT * FROM {$wpdb->prefix}wpServicesCalc_services WHERE section_id={$section_id} ORDER BY name";
    return $wpdb->get_results($sql, ARRAY_A);
}

function WSC_getCategoryServices($category_id)
{
    global $wpdb;

    $sql = "SELECT * FROM {$wpdb->prefix}wpServicesCalc_services WHERE category_id={$category_id} ORDER BY name";
    return $wpdb->get_results($sql, ARRAY_A);
}