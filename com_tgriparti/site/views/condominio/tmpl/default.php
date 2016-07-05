<?php
/**
 * @version    CVS: 1.0.7
 * @package    Com_Tgriparti
 * @author     Todaro Giovanni <Info@todarogiovanni.eu>
 * @copyright  2016 Todaro Giovanni - Consiglio Nazionale delle Ricerche -  Istituto per le Tecnologie Didattiche
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */
// No direct access
defined('_JEXEC') or die;
JHTML::_('behavior.modal');

$user       = JFactory::getUser();
$userId     = $user->get('id');
$listOrder  = $this->state->get('list.ordering');
$listDirn   = $this->state->get('list.direction');
$canCreate  = $user->authorise('core.create', 'com_tgriparti');
$canEdit    = $user->authorise('core.edit', 'com_tgriparti');
$canCheckin = $user->authorise('core.manage', 'com_tgriparti');
$canChange  = $user->authorise('core.edit.state', 'com_tgriparti');
$canDelete  = $user->authorise('core.delete', 'com_tgriparti');

$canEdit = JFactory::getUser()->authorise('core.edit', 'com_tgriparti');
if (!$canEdit && JFactory::getUser()->authorise('core.edit.own', 'com_tgriparti')) {
	$canEdit = JFactory::getUser()->id == $this->item->created_by;
}
?>
<?php if ($this->item) : ?>

	<?php if ( $this->params->get('show_page_heading')!=0) : ?>
	    <h1>Condomino</h1>
	<?php endif; ?>
	<h2><?php echo $this->item->via; ?></h2>

	<div class="item_fields">
		<table class="table">
			<tr>
			<th><?php echo JText::_('COM_TGRIPARTI_FORM_LBL_CONDOMINIO_STATE'); ?></th>
			<td>
			<i class="icon-<?php echo ($this->item->state == 1) ? 'publish' : 'unpublish'; ?>"></i></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_TGRIPARTI_FORM_LBL_CONDOMINIO_CREATED_BY'); ?></th>
			<td><?php echo $this->item->created_by_name; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_TGRIPARTI_FORM_LBL_CONDOMINIO_MODIFIED_BY'); ?></th>
			<td><?php echo $this->item->modified_by_name; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_TGRIPARTI_FORM_LBL_CONDOMINIO_VIA'); ?></th>
			<td><?php echo $this->item->via; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_TGRIPARTI_FORM_LBL_CONDOMINIO_CAP'); ?></th>
			<td><?php echo $this->item->cap; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_TGRIPARTI_FORM_LBL_CONDOMINIO_CITTA'); ?></th>
			<td><?php echo $this->item->citta; ?></td>
</tr>

		</table>
	</div>
	<?php if($canEdit && $this->item->checked_out == 0): ?>
		<a class="btn" href="<?php echo JRoute::_('index.php?option=com_tgriparti&task=condominio.edit&id='.$this->item->id); ?>"><?php echo JText::_("COM_TGRIPARTI_EDIT_ITEM"); ?></a>
	<?php endif; ?>

	<?php if(JFactory::getUser()->authorise('core.delete','com_tgriparti')):?>
		<a class="btn" href="<?php echo JRoute::_('index.php?option=com_tgriparti&task=condominio.remove&id=' . $this->item->id, false, 2); ?>"><?php echo JText::_("COM_TGRIPARTI_DELETE_ITEM"); ?></a>
	<?php endif; ?>


	<h2>Ricevute</h2>

									<form action="<?php echo JRoute::_('index.php?option=com_tgriparti&view=ricevute'); ?>" method="post"
									      name="adminForm" id="adminForm">


	<?php if (count($this->ricevute)) : ?>
										<?php echo JLayoutHelper::render('default_filter', array('view' => $this), dirname(__FILE__)); ?>
										<table class="table table-striped" id="ricevutaList">
											<thead>
											<tr>
												<?php if (isset($this->ricevute[0]->state)): ?>
													<th width="5%">
										<?php echo JHtml::_('grid.sort', 'JPUBLISHED', 'a.state', $listDirn, $listOrder); ?>
									</th>
												<?php endif; ?>


													<th class=''>
													<?php echo JHtml::_('grid.sort',  'COM_TGRIPARTI_RICEVUTE_NOME', 'a.nome', $listDirn, $listOrder); ?>
													</th>
													<th class=''>
													<?php echo JHtml::_('grid.sort',  'COM_TGRIPARTI_RICEVUTE_DATA', 'a.data', $listDirn, $listOrder); ?>
													</th>
													<th class=''>
													<?php echo JHtml::_('grid.sort',  'COM_TGRIPARTI_RICEVUTE_CONDOMINIO', 'a.condominio', $listDirn, $listOrder); ?>
													</th>


																<?php if ($canEdit || $canDelete): ?>
														<th class="center">
													<?php echo JText::_('COM_TGRIPARTI_RICEVUTE_ACTIONS'); ?>
													</th>
													<?php endif; ?>

											</tr>
											</thead>

											<tbody>
											<?php foreach ($this->ricevute as $i => $item) : ?>
												<?php $canEdit = JFactory::getUser()->authorise('core.edit', 'com_tgriparti'); ?>

																<?php if (!$canEdit && JFactory::getUser()->authorise('core.edit.own', 'com_tgriparti')): ?>
														<?php $canEdit = JFactory::getUser()->id == $item->created_by; ?>
													<?php endif; ?>

												<tr class="row<?php echo $i % 2; ?>">

													<?php if (isset($this->ricevute[0]->state)) : ?>
														<?php $class = ($canChange) ? 'active' : 'disabled'; ?>
														<td class="center">
										<a class="btn btn-micro <?php echo $class; ?>" href="<?php echo ($canChange) ? JRoute::_('index.php?option=com_tgriparti&task=ricevuta.publish&id=' . $item->id . '&state=' . (($item->state + 1) % 2), false, 2) : '#'; ?>">
										<?php if ($item->state == 1): ?>
											<i class="icon-publish"></i>
										<?php else: ?>
											<i class="icon-unpublish"></i>
										<?php endif; ?>
										</a>
									</td>
													<?php endif; ?>


													<td>
													<?php if (isset($item->checked_out) && $item->checked_out) : ?>
														<?php echo JHtml::_('jgrid.checkedout', $i, $item->editor, $item->checked_out_time, 'ricevute.', $canCheckin); ?>
													<?php endif; ?>
													<a href="<?php echo JRoute::_('index.php?option=com_tgriparti&view=ricevuta&id='.(int) $item->id.'&condominioId='. $this->item->id); ?>">
													<?php echo $this->escape($item->nome); ?></a>
													</td>
													<td>

														<?php echo $item->data; ?>
													</td>
													<td>

														<?php echo $item->condominio; ?>
													</td>


																	<?php if ($canEdit || $canDelete): ?>
														<td class="center">
															<?php if ($canEdit): ?>
																<a href="<?php echo JRoute::_('index.php?option=com_tgriparti&task=ricevutaform.edit&id=' . $item->id.'&return='. urlencode(base64_encode(JURI::getInstance()->toString(array('path','query')))), false, 2); ?>" class="btn btn-mini" type="button"><i class="icon-edit" ></i></a>
															<?php endif; ?>
															<?php if ($canDelete): ?>
																<a href="<?php echo JRoute::_('index.php?option=com_tgriparti&task=ricevutaform.remove&id=' . $item->id.'&return='. urlencode(base64_encode(JURI::getInstance()->toString(array('path','query')))), false, 2); ?>" class="btn btn-mini delete-button" type="button"><i class="icon-trash" ></i></a>
															<?php endif; ?>
														</td>
													<?php endif; ?>

												</tr>
											<?php endforeach; ?>
											</tbody>
										</table>
	<?php else: ?>
		<blockquote id="blkmessaggioFornituraElettrica">Non ci sono Ricevute...</blockquote>
	<?php endif; ?>
										<?php if ($canCreate) : ?>
											<a href="<?php echo JRoute::_('index.php?option=com_tgriparti&task=ricevutaform.edit&id=0&tmpl=component&condomino='.$this->item->id .'&amp;return='. urlencode(base64_encode(JURI::getInstance()->toString(array('path','query')))), false, 2); ?>"
											   class="btn btn-success btn-small modal" rel="{handler:'iframe'}"><i
													class="icon-plus"></i>
												<?php echo JText::_('COM_TGRIPARTI_ADD_ITEM'); ?></a>
										<?php endif; ?>

										<input type="hidden" name="task" value=""/>
										<input type="hidden" name="boxchecked" value="0"/>
										<input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>"/>
										<input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>"/>
										<?php echo JHtml::_('form.token'); ?>
									</form>

									<?php if($canDelete) : ?>
									<script type="text/javascript">

										jQuery(document).ready(function () {
											jQuery('.delete-button').click(deleteItem);
										});

										function deleteItem() {

											if (!confirm("<?php echo JText::_('COM_TGRIPARTI_DELETE_MESSAGE'); ?>")) {
												return false;
											}
										}
									</script>
									<?php endif; ?>
		<?php
	else:
		echo JText::_('COM_TGRIPARTI_ITEM_NOT_LOADED');
	endif;
