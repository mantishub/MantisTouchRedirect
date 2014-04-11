<?php
# Copyright (c) 2014 Victor Boctor @ MantisHub.com
# Licensed under the MIT license

auth_reauthenticate();
access_ensure_global_level( config_get( 'manage_plugin_threshold' ) );
html_page_top1( plugin_lang_get( 'title' ) );
html_page_top2();
print_manage_menu();

$t_mantistouch_url = plugin_config_get( 'mantistouch_url' );
?>
<br/>
<form action="<?php echo plugin_page( 'config_edit' ) ?>" method="post">
<table align="center" class="width50" cellspacing="1">
<tr>
	<td class="form-title" colspan="3">
		<?php echo plugin_lang_get( 'title' ) . ': ' . plugin_lang_get( 'config' ) ?>
	</td>
</tr>
<tr <?php echo helper_alternate_class() ?>>
	<td class="category">
		<?php echo plugin_lang_get( 'mantistouch_url' ) ?>
	</td>
	<td>
		<input name="mantistouch_url" type="text" size="80" value="<?php echo $t_mantistouch_url; ?>" />
	</td>
</tr> 
<tr>
	<td class="center" colspan="3">
		<input type="submit" class="button" value="<?php echo plugin_lang_get( 'update_config' ) ?>" />
	</td>
</tr>
</table>
</form>

<?php
html_page_bottom1( __FILE__ );
