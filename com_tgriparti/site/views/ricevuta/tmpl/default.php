<?php
/**
 * @version    CVS: 1.0.9
 * @package    Com_Tgriparti
 * @author     Todaro Giovanni <Info@todarogiovanni.eu>
 * @copyright  2016 Todaro Giovanni - Consiglio Nazionale delle Ricerche -  Istituto per le Tecnologie Didattiche
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */
// No direct access
defined('_JEXEC') or die;
JHTML::_('behavior.modal');

$canEdit = JFactory::getUser()->authorise('core.edit', 'com_tgriparti');
if (!$canEdit && JFactory::getUser()->authorise('core.edit.own', 'com_tgriparti')) {
	$canEdit = JFactory::getUser()->id == $this->item->created_by;
}
?>
<?php if ($this->item) : ?>

	<h1>Ripartizione</h1>
	<h2><?php echo $this->item->nome; ?></h2>
	<h3>Condominio di <?php echo $this->item->condominio; ?></h3>

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

	<?php $user       = JFactory::getUser();?>

	<?php if(JFactory::getUser()->authorise('core.delete','com_tgriparti')):?>
		<a class="btn" href="<?php echo JRoute::_('index.php?option=com_tgriparti&task=ricevuta.remove&id=' . $this->item->id, false, 2); ?>"><?php echo JText::_("COM_TGRIPARTI_DELETE_ITEM"); ?></a>
	<?php endif; ?>

	<a href="" class="btn modal" rel="{handler:'iframe'}">
		<i class="icon-print"></i>
		<?php echo JText::_('Stampa Ripartizione'); ?>
	</a>



								<form action="<?php echo JRoute::_('index.php?option=com_tgriparti&view=nominativi'); ?>" method="post"
								      name="adminForm" id="adminForm">

									<?php echo JLayoutHelper::render('default_filter', array('view' => $this), dirname(__FILE__)); ?>
									<table class="table table-striped table-hover" id="nominativoList">
										<thead>
										<tr>

												<th class=''>
												<?php echo JHtml::_('grid.sort',  'COM_TGRIPARTI_NOMINATIVI_NOME', 'a.nome', $listDirn, $listOrder); ?>
												</th>
												<th class='' style="text-align:center">
												 Lettura Attuale
												</th>
												<th class='' style="text-align:center">
												 Lettura Precedente
												</th>
												<th class='' style="text-align:center">
												 Consumo m<sup>3</sup>
												</th>
												<th class='' style="text-align:center">
												 Totale Consumi
												</th>
												<th class='' style="text-align:center">
												 Tariffa agevolata<br/><=15<br/>€1,240477
												</th>

												<th class='' style="text-align:center">
												 Tariffa base<br/>16<=23 <br/>€1,905744
												</th>

												<th class='' style="text-align:center">
												 1° supero<br/>24<=33<br/>€2,471495
												</th>

												<th class='' style="text-align:center">
												 2° supero<br/>33<=43<br/>€3,03105
												</th>

												<th class='' style="text-align:center">
												 3° supero<br/>>43<br/>€3,590603
												</th>






															<?php if ($canEdit || $canDelete): ?>
													<th class="center">
												<?php echo JText::_('COM_TGRIPARTI_NOMINATIVI_ACTIONS'); ?>
												</th>
												<?php endif; ?>

										</tr>
										</thead>

										<tbody>
										<?php foreach ($this->nominativi as $i => $item) : ?>
											<?php $canEdit = $user->authorise('core.edit', 'com_tgriparti'); ?>

															<?php if (!$canEdit && $user->authorise('core.edit.own', 'com_tgriparti')): ?>
													<?php $canEdit = JFactory::getUser()->id == $item->created_by; ?>
												<?php endif; ?>

											<tr class="row<?php echo $i % 2; ?>">




												<td>
												<?php if (isset($item->checked_out) && $item->checked_out) : ?>
													<?php echo JHtml::_('jgrid.checkedout', $i, $item->editor, $item->checked_out_time, 'nominativi.', $canCheckin); ?>
												<?php endif; ?>
												<a href="<?php echo JRoute::_('index.php?option=com_tgriparti&view=nominativo&id='.(int) $item->id); ?>">
												<?php echo $this->escape($item->nome); ?></a>
												</td>
												<td name="Lettura Attuale" style="text-align:center">
													<a href="index.php?option=com_tgriparti&task=letturaform.edit&tmpl=component&id=<?php echo $item->letturaAttualeID ? $item->letturaAttualeID : 0 ;?>&ricevuta=<?php echo $this->item->id; ?>&nominativo=<?php echo $item->id; ?>&return=<?php echo urlencode(base64_encode(JURI::getInstance()->toString(array('path','query'))));?>" class="btn btn-mini btn-primary modal" type="button" rel="{handler: 'iframe'}"><?php echo $item->letturaAttuale ? $item->letturaAttuale : "N.D." ;?> </a>
												</td>
												<td name="Lettura Precedente" style="text-align:center"> <?php echo $item->letturaPrecedente ? $item->letturaPrecedente	 : "N.D." ;?> </td>
												<td name="Consumo" style="text-align:center"><?php echo $item->consumo>0 ? $item->consumo	 : "N.D." ;?> </td>
												<td name="Totale dei Consumi"style="text-align:center"><?php echo $item->consumoTotale>0 ? $item->consumoTotale	 : "N.D." ;?></td>
												<td name="Tariffa Agevolata" style="text-align:center"><?php echo $item->tariffaAgevolata>0 ? $item->tariffaAgevolata	 : "N.D." ;?></td>
												<td name="Tariffa Base" style="text-align:center"><?php echo $item->tariffaBase>0 ? $item->tariffaBase	 : "N.D." ;?></td>
												<td name="Prima Soglia" style="text-align:center"><?php echo $item->primasoglia>0 ? $item->primoscaglione	 : "N.D." ;?> </td>
												<td name="Seconda Soglia" style="text-align:center">N.D.</td>
												<td name="Terza Soglia" style="text-align:center">N.D.</td>



												<?php if ($canEdit || $canDelete): ?>
													<td class="center">
														<?php if ($canEdit): ?>
															<a href="<?php echo JRoute::_('index.php?option=com_tgriparti&task=nominativoform.edit&id=' . $item->id, false, 2); ?>" class="btn btn-mini" type="button"><i class="icon-edit" ></i></a>
														<?php endif; ?>
														<?php if ($canDelete): ?>
															<a href="<?php echo JRoute::_('index.php?option=com_tgriparti&task=nominativoform.remove&id=' . $item->id, false, 2); ?>" class="btn btn-mini delete-button" type="button"><i class="icon-trash" ></i></a>
														<?php endif; ?>
														<a href="" class="btn modal btn-mini" > <i class="icon-print"></i> </a>
													</td>
												<?php endif; ?>

											</tr>
										<?php endforeach; ?>
										</tbody>
									</table>

									<?php if ($canCreate) : ?>
										<a href="<?php echo JRoute::_('index.php?option=com_tgriparti&task=nominativoform.edit&id=0', false, 2); ?>"
										   class="btn btn-success btn-small"><i
												class="icon-plus"></i>
											<?php echo JText::_('COM_TGRIPARTI_ADD_ITEM'); ?></a>
									<?php endif; ?>

									<input type="hidden" name="task" value=""/>
									<input type="hidden" name="boxchecked" value="0"/>
									<input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>"/>
									<input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>"/>
									<?php echo JHtml::_('form.token'); ?>
								</form>
	<?php

else:
	echo JText::_('COM_TGRIPARTI_ITEM_NOT_LOADED');
endif;
