<?php

namespace WSC\Views;

use \WSC\DataAccess\Section;
use \WSC\DataAccess\Category;
use \WSC\DataAccess\Service;
use \WSC\DataAccess\Order;

/**
 * Class WSC_adminViews
 *
 * Отображения админки
 *
 * @author Vladimir Lyubar <admin@uclg.ru>
 * @package wp-services-calculator
 * @subpakage Views
 */
class Admin
{
    /**
     * Вывод таблицы со списком раздклов
     */
    public static function servicesView()
    {
        ?>
            <table class="WSC_adminTable">
                <tr class="WSC_adminTableHead">
                    <td>#</td>
                    <td>Раздел</td>
                    <td>Категория</td>
                    <td>Название</td>
                    <td>Описание</td>
                    <td>Цена</td>
                    <td>Максимальное количество</td>
                    <td>Много услуг?</td>
                </tr>
                <?php foreach(Service::getAll() as $service): ?>
                    <tr>
                        <td><?php echo $service['id']; ?></td>
                        <td><?php echo '#', $service['section_id'], ' ', $service['section_name']; ?></td>
                        <td><?php echo '#', $service['category_id'], ' ', $service['category_name']; ?></td>
                        <td><?php echo $service['name']; ?></td>
                        <td><?php echo $service['description']; ?></td>
                        <td><?php echo $service['cost']; ?></td>
                        <td><?php echo $service['maxCount']; ?></td>
                        <td><?php echo $service['many'] ? 'Да' : 'Нет'; ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php
    }


    /**
     * Вывод формы добавления раздела
     */
    public static function serviceAddForm()
    {
        ?>
            <form method="post" class="WSC_adminForm">
                <b>Добавить услугу</b><br />
                <input type="hidden" name="action" value="add" />
                <select name="section_id">
                    <option>--- Выберите раздел ---</option>
                    <?php foreach(Section::getAll() as $section): ?>
                        <option value="<?php echo $section['id']; ?>">
                            <?php echo $section['name']; ?>
                        </option>
                    <?php endforeach; ?>
                </select><br />
                <select name="category_id">
                    <option>--- Выберите категорию ---</option>
                    <?php foreach(Category::getAll() as $category): ?>
                        <option value="<?php echo $category['id']; ?>">
                            <?php echo $category['name']; ?>
                        </option>
                    <?php endforeach; ?>
                </select><br />
                <input type="text" name="name" placeholder="Название услуги" size="50"/><br />
                <textarea name="description" placeholder="Описание услуги" cols="50" rows="3"></textarea><br />
                <input type="text" name="cost" placeholder="Цена услуги" size="50" /><br />
                <label>
                    <input type="radio" name="many" value="0" checked="checked" /> Одна услуга
                </label>
                <label>
                    <input type="radio" name="many" value="1" /> Много услуг
                </label><br />
                <input type="text" name="maxCount" placeholder="Максимальное количество" size="50" /><br />
                <input type="submit" value="Добавить" />
            </form>
        <?php
    }




    /**
     * Вывод таблицы со списком категорий
     */
    public static function categoriesView()
    {
        ?>
            <table class="WSC_adminTable">
                <tr class="WSC_adminTableHead">
                    <td>#</td>
                    <td>Раздел</td>
                    <td>Название</td>
                    <td>Описание</td>
                </tr>
                <?php foreach(Category::getAll() as $category): ?>
                    <tr>
                        <td><?php echo $category['id']; ?></td>
                        <td><?php echo '#', $category['section_id'], ' ', $category['section_name']; ?></td>
                        <td><?php echo $category['name']; ?></td>
                        <td><?php echo $category['description']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php
    }


    /**
     * Вывод формы добавления категории
     */
    public static function categoryAddForm()
    {
        ?>
            <form method="post">
                <input type="hidden" name="action" value="add" />
                <b>Добавить категорию</b><br />
                <select name="section_id">
                    <option>--- Выберите раздел ---</option>
                    <?php foreach(Section::getAll() as $section): ?>
                        <option value="<?php echo $section['id']; ?>">
                            <?php echo $section['name']; ?>
                        </option>
                    <?php endforeach; ?>
                </select><br />
                <input type="text" name="name" placeholder="Название категории" size="50"/><br />
                <textarea name="description" placeholder="Описание категории" cols="50" rows="3"></textarea><br />
                <input type="submit" value="Добавить" />
            </form>
        <?php
    }


    /**
     * Вывод таблицы со списком разделов
     */
    public static function sectionsView()
    {
        ?>
            <table class="WSC_adminTable">
                <tr class="WSC_adminTableHead">
                    <td>#</td>
                    <td>Название</td>
                </tr>
                <?php foreach(Section::getAll() as $section): ?>
                    <tr>
                        <td><?php echo $section['id']; ?></td>
                        <td><?php echo $section['name']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php
    }


    /**
     * Вывод формы добавления раздела
     */
    public static function sectionAddForm()
    {
        ?>
            <form method="post">
                <input type="hidden" name="action" value="add" />
                Добавить раздел: <input type="text" name="name" />
                <input type="submit" value="Добавить" />
            </form>
        <?php
    }
}