<?php

/**
 * @version     CVS: 1.0.0
 * @package     com_tgriparti
 * @subpackage  mod_tgriparti
 * @author      Todaro Giovanni <Info@todarogiovanni.eu>
 * @copyright   2016 Todaro Giovanni - Consiglio Nazionale delle Ricerche -  Istituto per le Tecnologie Didattiche
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;

// Include the syndicate functions only once
JLoader::register('ModTgripartiHelper', dirname(__FILE__) . '/helper.php');

$doc = JFactory::getDocument();

/* */
$doc->addStyleSheet(JURI::base() . '/media/mod_tgriparti/css/style.css');

/* */
$doc->addScript(JURI::base() . '/media/mod_tgriparti/js/script.js');

require JModuleHelper::getLayoutPath('mod_tgriparti', $params->get('content_type', 'blank'));
