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

$safe_htmltags = array(
	'a', 'address', 'em', 'strong', 'b', 'i',
	'big', 'small', 'sub', 'sup', 'cite', 'code',
	'img', 'ul', 'ol', 'li', 'dl', 'lh', 'dt', 'dd',
	'br', 'p', 'table', 'th', 'td', 'tr', 'pre',
	'blockquote', 'nowiki', 'h1', 'h2', 'h3',
	'h4', 'h5', 'h6', 'hr');

/* @var $params Joomla\Registry\Registry */
$filter = JFilterInput::getInstance($safe_htmltags);
echo $filter->clean($params->get('html_content'));
