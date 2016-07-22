<?php
/**
 * @version    CVS: 1.0.4
 * @package    Com_Tgriparti
 * @author     Todaro Giovanni <Info@todarogiovanni.eu>
 * @copyright  2016 Todaro Giovanni - Consiglio Nazionale delle Ricerche -  Istituto per le Tecnologie Didattiche
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */
// No direct access
defined('_JEXEC') or die;

JHtml::_('behavior.keepalive');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
JHtml::_('formbehavior.chosen', 'select');

// Load admin language file
$lang = JFactory::getLanguage();
$lang->load('com_tgriparti', JPATH_SITE);
$doc = JFactory::getDocument();
$doc->addScript(JUri::base() . '/media/com_tgriparti/js/form.js');
$return = JFactory::getApplication()->getUserState('com_tgriparti.edit.letturaform.personalvars.return','');


?>
<script type="text/javascript">
	if (jQuery === 'undefined') {
		document.addEventListener("DOMContentLoaded", function (event) {
			jQuery('#form-lettura').submit(function (event) {

			});


			jQuery('input:hidden.nominativo').each(function(){
				var name = jQuery(this).attr('name');
				if(name.indexOf('nominativohidden')){
					jQuery('#jform_nominativo option[value="' + jQuery(this).val() + '"]').attr('selected',true);
				}
			});
					jQuery("#jform_nominativo").trigger("liszt:updated");
			jQuery('input:hidden.ripartizione').each(function(){
				var name = jQuery(this).attr('name');
				if(name.indexOf('ripartizionehidden')){
					jQuery('#jform_ripartizione option[value="' + jQuery(this).val() + '"]').attr('selected',true);
				}
			});
					jQuery("#jform_ripartizione").trigger("liszt:updated");
		});
	} else {
		jQuery(document).ready(function () {
			jQuery('#form-lettura').submit(function (event) {

			});


			jQuery('input:hidden.nominativo').each(function(){
				var name = jQuery(this).attr('name');
				if(name.indexOf('nominativohidden')){
					jQuery('#jform_nominativo option[value="' + jQuery(this).val() + '"]').attr('selected',true);
				}
			});
					jQuery("#jform_nominativo").trigger("liszt:updated");
			jQuery('input:hidden.ripartizione').each(function(){
				var name = jQuery(this).attr('name');
				if(name.indexOf('ripartizionehidden')){
					jQuery('#jform_ripartizione option[value="' + jQuery(this).val() + '"]').attr('selected',true);
				}
			});
					jQuery("#jform_ripartizione").trigger("liszt:updated");
		});
	}
</script>

<div class="lettura-edit front-end-edit">
	<?php if (!empty($this->item->id)): ?>
		<h1>Modifica lettura contatore <?php echo $this->item->id; ?></h1>
	<?php else: ?>
		<h1>Inserimento lettura contatore</h1>
	<?php endif; ?>

	<form id="form-lettura"
		  action="<?php echo JRoute::_('index.php?option=com_tgriparti&task=lettura.save'); ?>"
		  method="post" class="form-validate form-horizontal" enctype="multipart/form-data">

	<input type="hidden" name="jform[id]" value="<?php echo $this->item->id; ?>" />

	<input type="hidden" name="jform[ordering]" value="<?php echo $this->item->ordering; ?>" />

	<input type="hidden" name="jform[state]" value="<?php echo $this->item->state; ?>" />

	<input type="hidden" name="jform[checked_out]" value="<?php echo $this->item->checked_out; ?>" />

	<input type="hidden" name="jform[checked_out_time]" value="<?php echo $this->item->checked_out_time; ?>" />

	<?php if(empty($this->item->created_by)): ?>
		<input type="hidden" name="jform[created_by]" value="<?php echo JFactory::getUser()->id; ?>" />
	<?php else: ?>
		<input type="hidden" name="jform[created_by]" value="<?php echo $this->item->created_by; ?>" />
	<?php endif; ?>
	<?php if(empty($this->item->modified_by)): ?>
		<input type="hidden" name="jform[modified_by]" value="<?php echo JFactory::getUser()->id; ?>" />
	<?php else: ?>
		<input type="hidden" name="jform[modified_by]" value="<?php echo $this->item->modified_by; ?>" />
	<?php endif; ?>

<?php
if ($this->nominativoId) { ?>
	<input type="hidden" name="jform[nominativo]" value="<?php echo $this->nominativoId; ?>"/>
	<input type="hidden" name="jform[ripartizione]" value="<?php echo $this->ricevutaId; ?>"/>
<?php } else { ?>

	<?php echo $this->form->renderField('nominativo'); ?>

	<?php foreach((array)$this->item->nominativo as $value): ?>
		<?php if(!is_array($value)): ?>
			<input type="hidden" class="nominativo" name="jform[nominativohidden][<?php echo $value; ?>]" value="<?php echo $value; ?>" />
		<?php endif; ?>
	<?php endforeach; ?>


	<?php echo $this->form->renderField('ripartizione'); ?>

	<?php foreach((array)$this->item->ripartizione as $value): ?>
		<?php if(!is_array($value)): ?>
			<input type="hidden" class="ripartizione" name="jform[ripartizionehidden][<?php echo $value; ?>]" value="<?php echo $value; ?>" />
		<?php endif; ?>
	<?php endforeach; ?>
<?php } ?>


<?php echo $this->form->renderField('lettura'); ?>

		<div class="control-group">
			<div class="controls">

				<?php if ($this->canSave): ?>
					<button type="submit" class="validate btn btn-primary">
						<?php echo JText::_('JSUBMIT'); ?>
					</button>
				<?php endif; ?>
				<a class="btn"
				   href="<?php echo JRoute::_('index.php?option=com_tgriparti&task=letturaform.cancel'); ?>"
				   title="<?php echo JText::_('JCANCEL'); ?>">
					<?php echo JText::_('JCANCEL'); ?>
				</a>
			</div>
		</div>
<?php

?>


		<input type="hidden" name="return" value="<?php echo $return; ?>" />
		<input type="hidden" name="option" value="com_tgriparti"/>
		<input type="hidden" name="task"
			   value="letturaform.save"/>
		<?php echo JHtml::_('form.token'); ?>
	</form>
</div>
