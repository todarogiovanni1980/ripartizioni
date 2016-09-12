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

$canEdit = JFactory::getUser()->authorise('core.edit', 'com_tgriparti');
if (!$canEdit && JFactory::getUser()->authorise('core.edit.own', 'com_tgriparti')) {
	$canEdit = JFactory::getUser()->id == $this->item->created_by;
}
?>
<?php if ($this->item) : ?>

	<div class="item_fields">
		<table class="table">
			
		</table>
	</div>
	
	<?php
else:
	echo JText::_('COM_TGRIPARTI_ITEM_NOT_LOADED');
endif;
