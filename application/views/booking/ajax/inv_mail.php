<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width" />
    <title>Booking Invoice and Terms & Conditions for the Ref#<?php echo $booking['bkg_no'] ; ?></title>
    <style>
        body {
            width: 100%;
            background: #e6e6e6;
            margin: 15px 0px;
            font-family: Arial, Helvetica, sans-serif;
        }
        #mainbody{
        	width:55%;
        }
        @media only screen and (max-width:600px) {
        	#mainbody{
	        	width:90%;
	        }
	        #btn{
	        	font-size: 11px !important;
	        }
        }
    </style>
</head>
<body>
	<table cellpadding="0" cellspacing="0" width="100%">
        <tr>
            <td align="center">
                <table cellpadding="0" cellspacing="0" bgcolor="#fff" id="mainbody">
                	<tr><td>&nbsp;</td></tr>
                	<tr>
                		<td align="center">
                			<table cellpadding="0" cellspacing="0" width="95%" bgcolor="#fff">
                				<tr>
                					<td align="center">
                						<img src="https://www.rrtravels.co.uk/assets/image/logo/logo.jpg" alt="logo" width="120px">
                					</td>
                				</tr>
                				<tr><td>&nbsp;</td></tr>
                				<tr>
                					<td bgcolor="#1e4ca1" align="center">
                						<table cellspacing="0" cellpadding="0" width="90%">
                							<tbody>
                								<tr><td height="40">&nbsp;</td></tr>
                								<tr>
                									<td align="center">
                										<img src="<?php echo base_url('assets/images/signlogo.png') ?>" width="90px" alt="sign icon">
                									</td>
                								</tr>
                								<tr><td height="20">&nbsp;</td></tr>
                								<tr>
                									<td align="center">
                										<p style="text-align: center;color: #fff;"><?php echo $from_name ; ?> sent you a document to review and sign.</p>
                									</td>
                								</tr>
                								<tr><td height="10">&nbsp;</td></tr>
                								<tr>
                									<td align="center">
                										<table cellpadding="0" cellspacing="0" width="100%">
                											<tr>
                												<td align="center" valign="middle" height="45">
                													<a id="btn" href="<?php echo $this->link_esign ; ?>/invoice/<?php echo $token ; ?>" target="_blank" style="font-size: 15px;color: #333333;background-color: #ffc423;font-weight: bold;text-align: center;text-decoration: none;border-radius: 2px;background-color: #ffc423;display: inline-block;padding: 15px 20px;">REVIEW DOCUMENT</a>
                												</td>
                											</tr>
                										</table>
                									</td>
                								</tr>
                								<tr><td height="40">&nbsp;</td></tr>
                							</tbody>
                						</table>
                					</td>
                				</tr>
                				<tr><td height="20">&nbsp;</td></tr>
                				<tr>
                					<td>
                						<p style="text-align: justify;">Dear <?php echo $to_name ; ?>,<br><br>Please click on the above link and sign the document. Note that if we DO NOT receive this singed invoice ASAP, we will not be responsible for any flight cancellation or price increase because without this signed document, we cannot issue your booking.<br><br>Regards,</p>
                						<h4 style="margin-bottom: 0px;"><?php echo $from_name ; ?></h4>
                						<a style="margin-bottom: 10px;" href="mailto:<?php echo $from ; ?>"><?php echo $from ; ?></a>
                					</td>
                				</tr>
                			</table>
                		</td>
                	</tr>
                	<tr><td height="40">&nbsp;</td></tr>
                </table>
            </td>
        </tr>
        <tr>
            <td align="center">
                <table cellpadding="0" cellspacing="0" id="mainbody">
                	<tr>
                		<td align="center">
                			<table cellpadding="0" cellspacing="0" width="95%">
                				<tr>
                					<td>
                						<h5 style="color:#666666;">Do Not Share This Email</h5>
                						<p style="font-size: 12px;color:#666666;">This email contains a secure link. Please do not share this email, link, or access code with others.</p>
                						<h5 style="color:#666666;">Questions about the Document?</h5>
                						<p style="font-size: 12px;color:#666666;">If you have any questions or need to modify the document, please contact to the sender.</p>
                						<p style="font-size: 12px;color:#666666;">If you are having trouble signing the document, please contact our Support Center.</p>
                					</td>
                				</tr>
                				<tr><td height="20"></td></tr>
                				<tr><td><p style="font-size: 12px;color:#666666;"><small>This message was sent to you by <?php echo $from_name ; ?>. If you would rather not receive email from this sender you may contact the sender with your request.</small></p></td></tr>
                			</table>
                		</td>
                	</tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>