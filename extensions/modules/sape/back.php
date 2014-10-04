<?php

use engine\template;
use engine\admin;
use engine\extension;
use engine\system;
use engine\language;

class modules_sape_back extends \engine\singleton {
    protected static $instance = null;

    public static function getInstance() {
        if(is_null(self::$instance))
            self::$instance = new self();
        return self::$instance;
    }

    public function _version() {
        return '1.0.1';
    }

    public function _compatable() {
        return '2.0.3';
    }

    public function install() {
        $lang = array(
            'ru' => array(
                'back' => array(
                    'admin_modules_sape.name' => 'Sape биржа',
                    'admin_modules_sape.desc' => 'Отображение на сайте ссылок из сервиса продажи ссылок sape.ru',
                    'admin_modules_sape_settings_title' => 'Настройки',
                    'admin_modules_sape_settings_uesr_desc' => 'Укажите ваш отпечаток SAPE_USER в системе <a href="http://www.sape.ru/r.VeOHWOpgxH.php" target="_blank">sape.ru</a>. Sape user является хеш-представлением вашего логина, пример: 81965c4a752da772e24d8f47fc039c42 - название загружаемой директории с сервера sape при добавлении сайта. Для установки - загрузите скачанный архив с кодом sape в корень сайта и выставите права 777 на директорию.',
                    'admin_modules_sape_settings_save' => 'Сохранить'
                )
            ),
            'en' => array(
                'back' => array(
                    'admin_modules_sape.name' => 'Sape links',
                    'admin_modules_sape.desc' => 'Display on website links selling from sape.ru',
                    'admin_modules_sape_settings_title' => 'Settings',
                    'admin_modules_sape_settings_uesr_desc' => 'Define your SAPE_USER from system <a href="http://www.sape.ru/r.VeOHWOpgxH.php" target="_blank">sape.ru</a>. Sape user its a hash from your login in system, example: 81965c4a752da772e24d8f47fc039c42 - name of downloaded directory for php sites. To install you must download php archive from sape.ru, unpack, upload to host and set 777 chmod to directory.',
                    'admin_modules_sape_settings_save' => 'Save'
                )
            )
        );
        language::getInstance()->add($lang);
    }

    public function make() {
        $params = array();

        if(system::getInstance()->post('submit')) {
            if(admin::getInstance()->saveExtensionConfigs()) {
                $params['notify']['save_success'] = true;
            }
        }
        $params['extension']['title'] = admin::getInstance()->viewCurrentExtensionTitle();

        $params['config']['sape_user'] = extension::getInstance()->getConfig('sape_user', 'sape', extension::TYPE_MODULE, 'str');

        return template::getInstance()->twigRender('modules/sape/settings.tpl', $params);
    }
}