<table style="width: 100%" style="font:Tahoma, Arial, Helvetica, sans-serif; font-size:16px;">
	<tr>
		<td colspan="3"><h3>You have received a comment from {<?php echo config_item('tags_trigger') ?>:name}</h3></td>
	</tr>
	<tr>
		<td style="width: 33%"><strong>IP Address: {<?php echo config_item('tags_trigger') ?>:sender_ip}</strong></td>
		<td style="width: 33%"><strong>Operating System: {<?php echo config_item('tags_trigger') ?>:sender_os}</strong></td>
		<td style="width: 33%"><strong>User Agent: {<?php echo config_item('tags_trigger') ?>:sender_agent}</strong></td>
	</tr>
	<tr>
		<td>
			<hr />
			{<?php echo config_item('tags_trigger') ?>:comment}
			<br />
		</td>
  </tr>
	<tr>
		<td>
			View Comment:&nbsp;{<?php echo config_item('tags_trigger') ?>:redirect_url}
		</td>
	</tr>
</table>