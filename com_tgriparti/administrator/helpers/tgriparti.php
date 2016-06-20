<?php

/**
 * @version    CVS: 1.0.0
 * @package    Com_Tgriparti
 * @author     Todaro Giovanni <Info@todarogiovanni.eu>
 * @copyright  2016 Todaro Giovanni - Consiglio Nazionale delle Ricerche -  Istituto per le Tecnologie Didattiche
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */
// No direct access
defined('_JEXEC') or die;

/**
 * Tgriparti helper.
 *
 * @since  1.6
 */
class TgripartiHelpersTgriparti
{
	/**
	 * Configure the Linkbar.
	 *
	 * @param   string  $vName  string
	 *
	 * @return void
	 */
	public static function addSubmenu($vName = '')
	{
		JHtmlSidebar::addEntry(
			JText::_('COM_TGRIPARTI_TITLE_CONDOMINI'),
			'index.php?option=com_tgriparti&view=condomini',
			$vName == 'condomini'
		);

JHtmlSidebar::addEntry(
			JText::_('COM_TGRIPARTI_TITLE_NOMINATIVI'),
			'index.php?option=com_tgriparti&view=nominativi',
			$vName == 'nominativi'
		);

JHtmlSidebar::addEntry(
			JText::_('COM_TGRIPARTI_TITLE_RICEVUTE'),
			'index.php?option=com_tgriparti&view=ricevute',
			$vName == 'ricevute'
		);

JHtmlSidebar::addEntry(
			JText::_('COM_TGRIPARTI_TITLE_LETTURE'),
			'index.php?option=com_tgriparti&view=letture',
			$vName == 'letture'
		);

		JHtmlSidebar::addEntry(
			JText::_('COM_TGRIPARTI_TITLE_RIPARTIZIONI'),
			'index.php?option=com_tgriparti&view=ripartizioni',
			$vName == 'ripartizioni'
		);
	}

	/**
	 * Gets the files attached to an item
	 *
	 * @param   int     $pk     The item's id
	 *
	 * @param   string  $table  The table's name
	 *
	 * @param   string  $field  The field's name
	 *
	 * @return  array  The files
	 */
	public static function getFiles($pk, $table, $field)
	{
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);

		$query
			->select($field)
			->from($table)
			->where('id = ' . (int) $pk);

		$db->setQuery($query);

		return explode(',', $db->loadResult());
	}

	/**
	 * Gets a list of the actions that can be performed.
	 *
	 * @return    JObject
	 *
	 * @since    1.6
	 */
	public static function getActions()
	{
		$user   = JFactory::getUser();
		$result = new JObject;

		$assetName = 'com_tgriparti';

		$actions = array(
			'core.admin', 'core.manage', 'core.create', 'core.edit', 'core.edit.own', 'core.edit.state', 'core.delete'
		);

		foreach ($actions as $action)
		{
			$result->set($action, $user->authorise($action, $assetName));
		}

		return $result;
	}
}


class TgripartiHelper extends TgripartiHelpersTgriparti
{

}
