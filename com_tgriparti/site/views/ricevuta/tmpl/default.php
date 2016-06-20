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
			<tr>
			<th><?php echo JText::_('COM_TGRIPARTI_FORM_LBL_RICEVUTA_STATE'); ?></th>
			<td>
			<i class="icon-<?php echo ($this->item->state == 1) ? 'publish' : 'unpublish'; ?>"></i></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_TGRIPARTI_FORM_LBL_RICEVUTA_CREATED_BY'); ?></th>
			<td><?php echo $this->item->created_by_name; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_TGRIPARTI_FORM_LBL_RICEVUTA_MODIFIED_BY'); ?></th>
			<td><?php echo $this->item->modified_by_name; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_TGRIPARTI_FORM_LBL_RICEVUTA_NOME'); ?></th>
			<td><?php echo $this->item->nome; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_TGRIPARTI_FORM_LBL_RICEVUTA_DESCRIZIONE'); ?></th>
			<td><?php echo $this->item->descrizione; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_TGRIPARTI_FORM_LBL_RICEVUTA_COSTO'); ?></th>
			<td><?php echo $this->item->costo; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_TGRIPARTI_FORM_LBL_RICEVUTA_DATA'); ?></th>
			<td><?php echo $this->item->data; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_TGRIPARTI_FORM_LBL_RICEVUTA_CONDOMINIO'); ?></th>
			<td><?php echo $this->item->condominio; ?></td>
</tr>

		</table>
	</div>
	<?php if($canEdit && $this->item->checked_out == 0): ?>
		<a class="btn" href="<?php echo JRoute::_('index.php?option=com_tgriparti&task=ricevuta.edit&id='.$this->item->id); ?>"><?php echo JText::_("COM_TGRIPARTI_EDIT_ITEM"); ?></a>
	<?php endif; ?>
								<?php if(JFactory::getUser()->authorise('core.delete','com_tgriparti')):?>
									<a class="btn" href="<?php echo JRoute::_('index.php?option=com_tgriparti&task=ricevuta.remove&id=' . $this->item->id, false, 2); ?>"><?php echo JText::_("COM_TGRIPARTI_DELETE_ITEM"); ?></a>
								<?php endif; ?>
	<?php
else:
	echo JText::_('COM_TGRIPARTI_ITEM_NOT_LOADED');
endif;
