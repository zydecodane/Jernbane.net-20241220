		<div class="wide_heading">
			Registrerings-log
		</div>
		<div class="wide_content" style="overflow: hidden;">
		
			<table cellpadding="3" cellspacing="3" style="border: 2px solid #FFFFFF;">
			   <tr>
			      <td width="150" valign="top" class="admtable">
			         <b>dato/tid</b>
			      </td>
			      <td width="150" valign="top" class="admtable">
			         <b>navn</b>
			      </td>
			      <td width="150" valign="top" class="admtable">
			         <b>e-post</b>
			      </td>
			      <td width="80" valign="top" class="admtable">
			         <b>ip</b>
			      </td>
				</tr>
			<?PHP
			
			$query = "SELECT * FROM log_user_create ORDER BY 1 DESC limit 100";
			$result = $db->query($query);
			
			while ( $row = $result->fetch_object() ) {
			     
			?>
			<tr>
			  <td width="150" class="admtable">
				 <?PHP echo @date("d-m-Y H:i:s",$row->datetime); ?>
				</td>
			    <td width="150" class="admtable">
				 <?PHP echo $row->user_realname; ?>
				</td>
				<td width="150" class="admtable">
				 <?PHP echo $row->user_email; ?>
				</td>
				<td width="80" class="admtable">
				 <a href="adm_ip_loc.php?ip=<?php echo "{$row->user_ip} "; ?>" target="_parent"><?PHP echo "{$row->user_ip} "; ?></a>
				</td>
			</tr>	 
			<?PHP
			}
			?>	
			</table>
	
			<br />
			
					
		</div>

<br />	