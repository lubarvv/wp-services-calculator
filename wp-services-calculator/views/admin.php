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
                    <td colspan="3">Много услуг?</td>
                </tr>
                <?php foreach(Service::getAll(true) as $service): ?>
                    <tr <?php echo $service['deleted'] ? 'style="opacity: 0.6"': ''; ?>>
                        <td><?php echo $service['id']; ?></td>
                        <td><?php echo '#', $service['section_id'], ' ', $service['section_name']; ?></td>
                        <td><?php echo '#', $service['category_id'], ' ', $service['category_name']; ?></td>
                        <td><?php echo $service['name']; ?></td>
                        <td><?php echo $service['description']; ?></td>
                        <td><?php echo $service['cost']; ?></td>
                        <td><?php echo $service['maxCount']; ?></td>
                        <td><?php echo $service['many'] ? 'Да' : 'Нет'; ?></td>
                        <td>
                            <form method="post">
                                <input type="hidden" name="action" value="delete" />
                                <input type="hidden" name="id" value="<?php echo $service['id'] ?>" />
                                <input type="submit" value="<?php echo $service['deleted'] ? 'Восстановить' : 'Удалить'; ?>" onclick="return(confirm('Вы уверены?'))"/>
                            </form>
                        </td>
                        <td>
                            <form method="post">
                                <input type="hidden" name="action" value="edit" />
                                <input type="hidden" name="id" value="<?php echo $service['id'] ?>" />
                                <input type="submit" value="Редактировать"/>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php
    }


    /**
     * Вывод формы добавления услуги
     */
    public static function serviceAddForm()
    {
        ?>
            <form method="post" class="WSC_adminForm">
                <b>Добавить услугу</b><br />
                <input type="hidden" name="action" value="add" />
                Выберите раздел <b>ИЛИ</b> категорию, где должна находиться услуга<br />
                <select name="section_id">
                    <option>--- Раздел ---</option>
                    <?php foreach(Section::getAll() as $section): ?>
                        <option value="<?php echo $section['id']; ?>">
                            <?php echo $section['name']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <select name="category_id">
                    <option>--- Категория ---</option>
                    <?php foreach(Category::getAll() as $category): ?>
                        <option value="<?php echo $category['id']; ?>">
                            <?php echo $category['section_name'], ' &gt;&gt; ', $category['name']; ?>
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
     * Вывод формы редактирования услуги раздела
     */
    public static function serviceEditForm()
    {
        $service = Service::get($_REQUEST['id'], true);
        ?>
            <form method="post" class="WSC_adminForm">
                <b>Добавить услугу</b><br />
                <input type="hidden" name="action" value="edit" />
                <input type="hidden" name="save" value="100500" />
                <input type="hidden" name="id" value="<?php echo $_REQUEST['id']; ?>" />
                Выберите раздел <b>ИЛИ</b> категорию, где должна находиться услуга<br />
                <select name="section_id">
                    <option>--- Раздел ---</option>
                    <?php foreach(Section::getAll() as $section): ?>
                        <option value="<?php echo $section['id']; ?>" <?php echo $service['section_id'] == $section['id'] ? 'selected' : ''?>>
                            <?php echo $section['name']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <select name="category_id">
                    <option>--- Категория ---</option>
                    <?php foreach(Category::getAll() as $category): ?>
                        <option value="<?php echo $category['id']; ?>" <?php echo $service['category_id'] == $category['id'] ? 'selected' : ''?>>
                            <?php echo $category['section_name'], ' &gt;&gt; ', $category['name']; ?>
                        </option>
                    <?php endforeach; ?>
                </select><br />
                Название <br />
                <input type="text" name="name" value="<?php echo $service['name']; ?>" placeholder="Название услуги" size="50"/><br />
                Описание <br />
                <textarea name="description" placeholder="Описание услуги" cols="50" rows="3"><?php echo $service['description']; ?></textarea><br />
                Цена<br />
                <input type="text" name="cost" placeholder="Цена услуги" size="50" value="<?php echo $service['cost']; ?>" /><br />
                <label>
                    <input type="radio" name="many" value="0" <?php echo $service['many'] == 0 ? 'checked="checked"' : ''; ?> /> Одна услуга
                </label>
                <label>
                    <input type="radio" name="many" value="1" <?php echo $service['many'] == 1 ? 'checked="checked"' : ''; ?> /> Много услуг
                </label><br />
                Максимальное количество<br />
                <input type="text" name="maxCount" placeholder="Максимальное количество" size="50" value="<?php echo $service['maxCount']; ?>" /><br />
                <input type="submit" value="Сохранить" />
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
                    <td colspan="3">Описание</td>
                </tr>
                <?php foreach(Category::getAll(true) as $category): ?>
                    <tr <?php echo $category['deleted'] ? 'style="opacity: 0.6"' : ''; ?>>
                        <td><?php echo $category['id']; ?></td>
                        <td><?php echo '#', $category['section_id'], ' ', $category['section_name']; ?></td>
                        <td><?php echo $category['name']; ?></td>
                        <td><?php echo $category['description']; ?></td>
                        <td>
                            <form method="post">
                                <input type="hidden" name="action" value="delete" />
                                <input type="hidden" name="id" value="<?php echo $category['id'] ?>" />
                                <input type="submit" value="<?php echo $category['deleted'] ? 'Восстановить' : 'Удалить'; ?>" onclick="return(confirm('Вы уверены?'))"/>
                            </form>
                        </td>
                        <td>
                            <form method="post">
                                <input type="hidden" name="action" value="edit" />
                                <input type="hidden" name="id" value="<?php echo $category['id'] ?>" />
                                <input type="submit" value="Редактировать"/>
                            </form>
                        </td>
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
     * Вывод формы редактироования категории
     */
    public static function categoryEditForm()
    {
        $category = Category::get($_REQUEST['id'], true);
        ?>
            <form method="post">
                <input type="hidden" name="action" value="edit" />
                <input type="hidden" name="save" value="100500" />
                <input type="hidden" name="id" value="<?php echo $_REQUEST['id']; ?>" />
                <b>Добавить категорию</b><br />
                <select name="section_id">
                    <option>--- Выберите раздел ---</option>
                    <?php foreach(Section::getAll(true) as $section): ?>
                        <option value="<?php echo $section['id']; ?>" <?php echo $category['section_id'] == $section['id'] ? 'selected' : ''; ?>>
                            <?php echo $section['name']; ?>
                        </option>
                    <?php endforeach; ?>
                </select><br />
                <input type="text" name="name" placeholder="Название категории" size="50" value="<?php echo $category['name']; ?>"/><br />
                <textarea name="description" placeholder="Описание категории" cols="50" rows="3"><?php echo $category['description']; ?></textarea><br />
                <input type="submit" value="Сохранить" />
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
                    <td colspan="3">Название</td>
                </tr>
                <?php foreach(Section::getAll(true) as $section): ?>
                    <tr <?php echo $section['deleted'] ? 'style="opacity: 0.6"' : ''; ?>>
                        <td><?php echo $section['id']; ?></td>
                        <td><?php echo $section['name']; ?></td>
                        <td>
                            <form method="post">
                                <input type="hidden" name="action" value="delete" />
                                <input type="hidden" name="id" value="<?php echo $section['id'] ?>" />
                                <input type="submit" value="<?php echo $section['deleted'] ? 'Восстановить' : 'Удалить'; ?>" onclick="return(confirm('Вы уверены?'))"/>
                            </form>
                        </td>
                        <td>
                            <form method="post">
                                <input type="hidden" name="action" value="edit" />
                                <input type="hidden" name="id" value="<?php echo $section['id'] ?>" />
                                <input type="submit" value="Редактировать"/>
                            </form>
                        </td>
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


    /**
     * Редакирование раздела
     */
    public static function sectionEditForm()
    {
        $section = Section::get($_REQUEST['id'], true);
        ?>
            <form method="post">
                <input type="hidden" name="action" value="edit" />
                <input type="hidden" name="save" value="100500" />
                <input type="hidden" name="id" value="<?php echo $section['id']; ?>" />
                <input type="text" name="name" value="<?php echo $section['name']; ?>" placeholder="Название раздела"/>
                <input type="submit" value="Сохранить" />
            </form>
        <?php
    }


    /**
     * Вывод списка заказов
     */
    public static function orders()
    {
        ?>
            <h2>Оформленные заказы</h2>
            <table class="WSC_adminTable">
                <tr class="WSC_adminTableHead">
                    <td>#</td>
                    <td>Контактные данные</td>
                    <td>Комментарий клиента</td>
                    <td>Заказ</td>
                </tr>
                <?php foreach(Order::getAll() as $order): ?>
                    <tr>
                        <td><?php echo $order['id']; ?></td>
                        <td>
                            <?php echo $order['name']; ?><br />
                            <?php echo $order['phone']; ?>
                        </td>
                        <td>
                            <?php echo $order['comment']; ?>
                        </td>
                        <td>
                            <pre><?php echo $order['description']; ?></pre>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php
    }
}