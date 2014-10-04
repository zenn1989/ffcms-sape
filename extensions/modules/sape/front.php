<?php

use engine\template;
use engine\extension;
use engine\system;
use engine\logger;

class modules_sape_front extends \engine\singleton {
    protected static $instance = null;

    public static function getInstance() {
        if(is_null(self::$instance))
            self::$instance = new self();
        return self::$instance;
    }

    public function make() {
        $params = array();

        $params['config']['sape_user'] = extension::getInstance()->getConfig('sape_user', 'sape', extension::TYPE_MODULE, 'str');
        if(system::getInstance()->length($params['config']['sape_user']) < 32) // its not looks like sape user, but mb in future sape rework model to 128/256 bit hash
            return null;

        if(!defined('_SAPE_USER')){
            define('_SAPE_USER', $params['config']['sape_user']);
        }
        $sape_lib = root . '/' . _SAPE_USER . '/sape.php';
        if(!file_exists($sape_lib)) {
            logger::getInstance()->log(logger::LEVEL_WARN, 'Sape code library not found: ' . $sape_lib);
            return null;
        }
        @require_once($sape_lib);
        if(!class_exists('SAPE_client')) {
            logger::getInstance()->log(logger::LEVEL_WARN, 'Sape class SAPE_client not exist');
            return null;
        }
        //$o['force_show_code'] = true;
        //$sape = new SAPE_client($o);

        $sape = new SAPE_client();
        if(!method_exists($sape, 'return_links')) {
            logger::getInstance()->log(logger::LEVEL_WARN, 'Sape function return_links() not exist in class SAPE_client');
            return null;
        }
        $params['sape']['links'] = $sape->return_links();
        $sape = null;

        if(system::getInstance()->length($params['sape']['links']) < 1) // links is empty, no reason to display empty block
            return null;

        $tpl = template::getInstance()->twigRender('modules/sape/link_block.tpl', $params);
        template::getInstance()->set(template::TYPE_MODULE, 'sape', $tpl);
    }
}