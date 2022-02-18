<?php

// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Automatically generated strings for Moodle installer
 *
 * Do not edit this file manually! It contains just a subset of strings
 * needed during the very first steps of installation. This file was
 * generated automatically by export-installer.php (which is part of AMOS
 * {@link http://docs.moodle.org/dev/Languages/AMOS}) using the
 * list of strings defined in /install/stringnames.txt.
 *
 * @package   installer
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$string['cannotcreatedboninstall'] = '<p> Невозможно создать базу данных. </p><p> Указанная база данных не существует, и данный пользователь не имеет разрешения на создание базы данных. </p><p> Администратор сайта  должен проверить конфигурацию базы данных. </p>';
$string['cannotcreatelangdir'] = 'Не удается создать каталог языка';
$string['cannotcreatetempdir'] = 'Не удается создать временный каталог';
$string['cannotdownloadcomponents'] = 'Невозможно загрузить компоненты.';
$string['cannotdownloadzipfile'] = 'Не удалось загрузить ZIP-файл';
$string['cannotfindcomponent'] = 'Не удалось найти компонент';
$string['cannotsavemd5file'] = 'Не удалось сохранить MD5-файл';
$string['cannotsavezipfile'] = 'Не удалось сохранить ZIP-файл';
$string['cannotunzipfile'] = 'Не удалось распаковать файл';
$string['componentisuptodate'] = 'Компонент не нуждается в обновлении';
$string['dmlexceptiononinstall'] = '<p>Произошла ошибка базы данных [{$a->errorcode}].<br />{$a->debuginfo}</p>';
$string['downloadedfilecheckfailed'] = 'Ошибка проверки загруженного файла';
$string['invalidmd5'] = 'Некорректная md5';
$string['missingrequiredfield'] = 'Отсутствуют некоторые обязательные поля';
$string['remotedownloaderror'] = '<p>Не удалось загрузить компонент на сервер. Проверьте настройки прокси-сервера; настоятельно рекомендуется установка расширения  PHP cURL.</p>
<p>Вам следует вручную загрузить файл по ссылке <a href="{$a->url}">{$a->url}</a>, скопировать его в папку «{$a->dest}» на своем сервере и там его распаковать.</p>';
$string['wrongdestpath'] = 'Ошибочный путь назначения';
$string['wrongsourcebase'] = 'Неправильный адрес источника';
$string['wrongzipfilename'] = 'Неверное имя ZIP-файла';
