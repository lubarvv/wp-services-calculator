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

        ?>
        <script src="/wp-content/plugins/wp-services-calculator/static/calc.js"></script>

        <div id="WSC_resultInfo">
            Итого: <span id="WSC_sum">0</span> р.
            <a href="#">Оформить заказ</a>
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
                    <div id="WSC_sectionContent_<?php echo $section['id']; ?>" class="WSC_sectionContent hidden">

                        <?php foreach (Category::getBySection($section['id']) as $category): ?>
                            <div class="WSC_sectionCategory">

                                <div class="WSC_sectionCategoryTitle">
                                    <span><?php echo $category['name']; ?></span>

                                    <p><?php echo $category['description']; ?></p>
                                </div>

                                <div class="WSC_sectionCategoryServices">
                                    <?php foreach (Service::getByCategory($category['id']) as $service): ?>
                                        <div class="WSC_service">
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
}
