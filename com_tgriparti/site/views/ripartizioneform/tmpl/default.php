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

JHtml::_('behavior.keepalive');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
JHtml::_('formbehavior.chosen', 'select');

// Load admin language file
$lang = JFactory::getLanguage();
$lang->load('com_tgriparti', JPATH_SITE);
$doc = JFactory::getDocument();
$doc->addScript(JUri::base() . '/media/com_tgriparti/js/form.js');


?>
<script type="text/javascript">
	if (jQuery === 'undefined') {
		document.addEventListener("DOMContentLoaded", function (event) {
			jQuery('#form-ripartizione').submit(function (event) {
				
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
			jQuery('#form-ripartizione').submit(function (event) {
				
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

<div class="ripartizione-edit front-end-edit">
	<?php if (!empty($this->item->id)): ?>
		<h1>Edit <?php echo $this->item->id; ?></h1>
	<?php else: ?>
		<h1>Add</h1>
	<?php endif; ?>

	<form id="form-ripartizione"
		  action="<?php echo JRoute::_('index.php?option=com_tgriparti&task=ripartizione.save'); ?>"
		  method="post" class="form-validate form-horizontal" enctype="multipart/form-data">
		
		<div class="control-group">
			<div class="controls">

				<?php if ($this->canSave): ?>
					<button type="submit" class="validate btn btn-primary">
						<?php echo JText::_('JSUBMIT'); ?>
					</button>
				<?php endif; ?>
				<a class="btn"
				   href="<?php echo JRoute::_('index.php?option=com_tgriparti&task=ripartizioneform.cancel'); ?>"
				   title="<?php echo JText::_('JCANCEL'); ?>">
					<?php echo JText::_('JCANCEL'); ?>
				</a>
			</div>
		</div>

		<input type="hidden" name="option" value="com_tgriparti"/>
		<input type="hidden" name="task"
			   value="ripartizioneform.save"/>
		<?php echo JHtml::_('form.token'); ?>
	</form>
</div>
