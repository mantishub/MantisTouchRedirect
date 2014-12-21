<?php
# Copyright (c) 2014 Victor Boctor @ MantisHub.com
# Licensed under the MIT license

auth_reauthenticate();
access_ensure_global_level( config_get( 'manage_plugin_threshold' ) );

layout_page_header( plugin_lang_get( 'title' ) );
layout_page_begin( __FILE__ );

print_manage_menu();

$t_mantistouch_url = plugin_config_get( 'mantistouch_url' );
?>

<div class="col-xs-12 col-md-10 col-md-offset-1">
	<div class="space-10"></div>

<div id="edit-user-div" class="form-container">
	<form id="edit-user-form" method="post" action="<?php echo plugin_page( 'config_edit' ) ?>">
		<div class="widget-box widget-color-blue2">
			<div class="widget-header widget-header-small">
				<h4 class="widget-title lighter">
					<i class="ace-icon fa fa-user"></i>
					<?php echo plugin_lang_get( 'title' ) . ': ' . plugin_lang_get( 'config' ) ?>
				</h4>
			</div>
		<div class="widget-body">
		<div class="widget-main no-padding">
		<div class="form-container">
		<div class="table-responsive">
		<table class="table table-bordered table-condensed table-striped">
		<fieldset>
			<!-- mantistouch_url -->
			<tr>
				<td class="category">
					<?php echo plugin_lang_get( 'mantistouch_url' ) ?>
				</td>
				<td>
					<input id="mantistouch_url" type="text" class="input-sm" size="50" name="mantistouch_url" value="<?php echo string_attribute( $t_mantistouch_url ) ?>" />
				</td>
			</tr>
		</fieldset>
		</table>
		</div>
		</div>
		</div>

		<div class="widget-toolbox padding-8 clearfix">
			<input type="submit" class="btn btn-primary btn-white btn-round" value="<?php echo plugin_lang_get( 'update_config' ) ?>" />
		</div>
		</div>
		</div>
	</form>
</div>
<div class="space-10"></div>

<?php
layout_page_end();
