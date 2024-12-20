		<div class="wide_heading">
			GDPR-log
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
			         <b>userid</b>
			      </td>
			      <td width="80" valign="top" class="admtable">
			         <b>version</b>
			      </td>
				</tr>
			<?PHP
			
			$query = "SELECT * FROM misc_user ORDER BY datetime DESC";
			$result = $db->query($query);
			$na=0;
			while ( $row = $result->fetch_object() ) {
			     
			?>
			<tr>
			  <td width="150" class="admtable">
				 <?PHP echo @date("d-m-Y H:i:s",$row->datetime); ?>
				</td>
			    <td width="150" class="admtable">
				 <?PHP echo $row->username; ?>
				</td>
				<td width="150" class="admtable">
				 <?PHP echo $row->user_id; ?>
				</td>
				<td width="80" class="admtable">
				 <?php echo "{$row->version} "; ?>
				</td>
			</tr>	 
			<?PHP
			$na++;
			}
			?>	
			</table>
			<?php
			echo "&nbsp;&nbsp;"; echo $na;
			?>
			<br />
			<br />
			
					
		</div>

<br />	