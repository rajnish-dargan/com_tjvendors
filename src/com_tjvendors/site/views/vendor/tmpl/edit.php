<?php
/**
 * @version    CVS: 1.0.0
 * @package    Com_Tjvendors
 * @author     Parth Lawate <contact@techjoomla.com>
 * @copyright  2016 Parth Lawate
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */
// No direct access
defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
JHtml::_('formbehavior.chosen', 'select');
JHtml::_('behavior.keepalive');

// Import CSS
$document = JFactory::getDocument();
$document->addStyleSheet(JUri::root() . 'media/com_tjvendors/css/form.css');
?>
<script type="text/javascript">
	js = jQuery.noConflict();
	js(document).ready(function ()
	{
	});

	Joomla.submitbutton = function (task)
	{
		 if (task == 'vendor.cancel')
		{
			Joomla.submitform(task, document.getElementById('vendor-form'));
		}
		else
		{
			Joomla.submitform(task, document.getElementById('vendor-form'));
		}
	}
			jQuery(document).on("change","#jformvendor_payment_gateway", function () {
			var payment_gateway=document.getElementById('jformvendor_payment_gateway').value;
			var userObject = {};
			userObject["payment_gateway"] = payment_gateway;
			JSON.stringify(userObject) ;
			jQuery.ajax({
				type: "POST",
				dataType: "json",
				data: userObject,
				url: "index.php?option=com_tjvendors&task=vendor.buildForm",
				success:function(data) {
			jQuery('#payment_details').html(data);
				},
		   });
		});
</script>

<?php 
if (JFactory::getUser()->id ){?>

<form action="<?php echo JRoute::_('index.php?option=com_tjvendors&layout=edit&vendor_id=' .$this->input->get('vendor_id', '', 'INTEGER') .'&client=' . $this->input->get('client', '', 'STRING') ); ?>"
	method="post" enctype="multipart/form-data" name="adminForm" id="vendor-form" class="form-validate">
	<div class="form-horizontal">
		<div class="row-fluid">
			<div class="form-horizontal">
				<?php echo JHtml::_('bootstrap.startTabSet', 'myTab', array('active' => 'name')); ?> 
					<?php echo JHtml::_('bootstrap.addTab', 'myTab', 'name', JText::_('COM_TJVENDORS_VENDOR_REGISTRATION_DETAILS')); ?> 
						<fieldset class="adminform">
							<input type="hidden" name="jform[vendor_id]" value="<?php echo $this->vendor_id; ?>" />
							<input type="hidden" name="jform[checked_out_time]" value="<?php echo $this->vendor->checked_out_time; ?>" />
							<input type="hidden" name="jform[checked_out]" value="<?php echo $this->vendor->checked_out; ?>" />
							<input type="hidden" name="jform[ordering]" value="<?php echo $this->vendor->ordering; ?>" />
							<input type="hidden" name="jform[state]" value="<?php echo $this->vendor->state; ?>" />

								<?php
								$input = JFactory::getApplication()->input;
									if($this->vendor_id !=0)
									{
										$client=$this->input->get('client', '', 'STRING');
										echo JText::_('COM_TJVENDORS_DISPLAY_YOU_ARE_ALREADY_A_VENDOR_AS');?>
										<a href="<?php echo JRoute::_('index.php?option=com_tjvendors&view=vendor&layout=profile&vendor_id='.$this->vendor_id);?>">
										<?php
										echo $this->VendorDetail->vendor_title."</a>";
										echo " <br> ".JText::_('COM_TJVENDORS_DISPLAY_DO_YOU_WANT_TO_ADD');
										echo JText::_("COM_TJVENDORS_VENDOR_CLIENT_".strtoupper($client));
										echo JText::_('COM_TJVENDORS_DISPLAY_AS_A_CLIENT');?>
										<input type="hidden" name="jform[vendor_client]" value="<?php echo $this->input->get('client', '', 'STRING'); ?>" />
										<input type="hidden" name="jform[vendor_title]" value="<?php echo $this->VendorDetail->vendor_title; ?>" />
										<input type="hidden" name="jform[vendor_description]" value="<?php echo $this->VendorDetail->vendor_description; ?>" />

										<div>
											<button type="button" class="btn btn-default  btn-primary"  onclick="Joomla.submitbutton('vendor.save')">
												<span><?php echo JText::_('COM_TJVENDORS_CLIENT_APPROVAL'); ?></span>
											</button>
											<button class="btn  btn-default" onclick="Joomla.submitbutton('vendor.cancel')">
												<?php echo JText::_('COM_TJVENDORS_CLIENT_REJECTION'); ?>
											</button>
										</div>
								<?php
									}
									elseif($this->vendor_id==0)
									{?>
										 <input type="hidden" name="jform[vendor_client]" value="<?php echo $this->input->get('client', '', 'STRING'); ?>" />
										<?php echo$this->form->renderField('vendor_title'); ?>
										<?php echo $this->form->renderField('vendor_description'); ?>
										<?php echo $this->form->renderField('vendor_logo'); ?>
										<div class="controls">
											<div class="alert alert-warning">
												<?php echo sprintf(JText::_("COM_TJVENDORS_FILE_UPLOAD_ALLOWED_EXTENSIONS"), 'jpg, jpeg, png'); ?>
											</div>
										</div>
											<input type="hidden" name="jform[vendor_logo]" id="jform_vendor_logo_hidden" value="<?php echo $this->vendor->vendor_logo ?>" />
										<?php if (!empty($this->vendor->vendor_logo))
											{ ?>
												<div class="control-group">
													<div class="controls "><img src="<?php echo JUri::root() . $this->vendor->vendor_logo; ?>"></div>
												</div>
										<?php } 
										if(empty($this->vendor->vendor_logo)):?>
											<input type="hidden" name="jform[vendor_logo]" id="jform_vendor_logo_hidden" value="/administrator/components/com_tjvendors/assets/images/default.png" />
											<div class="control-group">
													<div class="controls "><img src="<?php echo JUri::root() . "/administrator/components/com_tjvendors/assets/images/default.png"; ?>"></div>
												</div>
										<?php endif;
										?>
										<div>
											<button type="button" class="btn btn-default  btn-primary"  onclick="Joomla.submitbutton('vendor.save')">
												<span><?php echo JText::_('JSUBMIT'); ?></span>
											</button>

											<button class="btn  btn-default" onclick="Joomla.submitbutton('vendor.cancel')">
												<?php echo JText::_('JCANCEL'); ?>
											</button>
										</div>
								<?php
									}
								 ?>
						</fieldset>
					<?php echo JHtml::_('bootstrap.endTab'); ?>

					<?php echo JHtml::_('bootstrap.addTab', 'myTab', 'desc', JText::_('COM_TJVENDORS_VENDOR_PAYMENT_GATEWAY_DETAILS')); ?>
						<?php
							if(!empty ($this->input->get('client', '', 'STRING')))
							{
								echo $this->form->renderField('primaryEmail');
							}
							else
							{?>
								<input type="hidden" name="jform[primaryEmail]" id="jform_primaryEmail" value="0" />
							<?php
							}
							?>
						<?php echo $this->form->renderField('paymentgateway');?>

						<div id="payment_details"></div>
					<?php echo JHtml::_('bootstrap.endTab'); ?> 

				<?php echo JHtml::_('bootstrap.endTabSet'); ?> 
			</div>
		</div>
			
		<input type="hidden" name="task" value="vendor.save"/>
		<?php echo JHtml::_('form.token'); ?>
	</div>
</form>
<?php }
else
{
	$link =JRoute::_('index.php?option=com_users');
	$app = JFactory::getApplication();
	$app->redirect($link);
}

