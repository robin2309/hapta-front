<?php

class ContactController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
        $request = $this->getRequest();
        $this->view->headTitle = "Hapta ". Zend_Registry::get('City_Location') ." - Contact";
    	if($request->isPost()){
    		$formData = $request->getPost();
			$namecontact = $formData['name_contact'];
			$mailcontact = $formData['mail_contact'];
			$motifcontact = $formData['motif_contact'];
			$techniquescontact = $formData['techniques_contact'];
			$paternariatcontact = $formData['paternariat_contact'];
			$messagecontact = $formData['message_contact'];

			if($namecontact != "") {	
				if($motifcontact == "Problèmes techniques") {
					$subject  = $mailcontact.' - '.$motifcontact. ' : '.$techniquescontact;
				}
				if($motifcontact == "Demande de partenariat") {
					$subject  = $mailcontact.' - '.$motifcontact. ' : '.$paternariatcontact;
				}
				if($motifcontact == "Demande d'information") {
					$subject  = $mailcontact.' - '.$motifcontact;
				}
				if($motifcontact == "Autre") {
					$subject  = $mailcontact.' - '.$motifcontact;
				}
				if($motifcontact == "Suggestions") {
					$subject  = $mailcontact.' - '.$motifcontact;
				}
				
				$message  = '
								<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
								<html xmlns="http://www.w3.org/1999/xhtml">
								<head>
								  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
								  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
								</head>
								<body style="margin: 0; padding: 0; height:100%;">
								 <table border="0" background="http://www.haptalyon.fr/img/backMail.png" cellpadding="0" cellspacing="0" width="100%" height="100%">
								  <tr>
								   <td>
								     <table align="center" border="0" cellpadding="0" cellspacing="0" width="600" style="border-collapse: collapse;">
								       <tr>
								         <td align="center" style="padding: 40px 0 30px 0;">
								          <img src="http://www.haptalyon.fr/img/logoMail.png" alt="Logo Hapta" />
								         </td>
								       </tr>
								       <tr>
								         <td style="padding: 0 0 20px 0;">
								           <table bgcolor="#ffffff" style="padding: 20px 30px 20px 30px;" border="0" cellpadding="0" cellspacing="0" width="100%">
								            <tr>
								             <td>
								                '.$namecontact.'<br/><br/>'.$messagecontact.'
								             </td>
								            </tr>
								           </table>
								         </td>
								       </tr>
								       <tr>
								        <td style="padding: 0 0 20px 0;">
								          <table bgcolor="#ffffff" style="padding: 20px 30px 20px 30px;" border="0" cellpadding="0" cellspacing="0" width="100%">
								            <tr>
								              <td style="font-size:12px;">
								                En imprimant ce mail vous pourrez le présenter lors de la soirée pour valider votre place gagné à l\'aide de Hapta '. Zend_Registry::get('City_Location') .'. Pour toutes informations supplémentaires n\'hésitez pas à nous contacter sur '. Zend_Registry::get('Contact_Email') .'.<br>
								                Si ce mail est imprimé, merci de ne pas jeter sur la voie publique.
								              </td>
								            </tr>
								          </table>
								        </td>
								       </tr>
								       <tr style="padding: 0 0 30px 0;">
								         <td bgcolor="#4e67a9" style="padding: 30px 30px 30px 30px; font-family: \'UbuntuRegular\', Helvetica, Arial, sans-serif;">
								           <table border="0" cellpadding="0" cellspacing="0" width="100%">
								             <td width="75%" style="color:#FFF;">
								              <a href="http://www.'. Zend_Registry::get('Site_Address') .'" target="_blank" style="text-decoration:none; color:#FFF;" >www.'. Zend_Registry::get('Site_Address') .'</a><br/>
								             </td>
								             <td align="right">
								              <table border="0" cellpadding="0" cellspacing="0">
								               <tr>
								                <td>
								                 <a href="http://www.facebook.com/'. Zend_Registry::get('Fb_Link') .'" target="_blank">
								                  <img src="http://www.iconsdb.com/icons/preview/white/facebook-5-xxl.png" alt="Facebook" width="34" height="34" style="display: block;" border="0" />
								                 </a>
								                </td>
								               </tr>
								              </table>
								             </td>
								           </table>
								         </td>
								       </tr>
								     </table>
								   </td>
								  </tr>
								 </table>
								</body>
								</html>
						    ';

				$to = Zend_Registry::get('Contact_Email');
				$noReply = Zend_Registry::get('No_Reply_Email');
				$pwd = Zend_Registry::get('No_Reply_Pass');
				$hostSmtp = Zend_Registry::get('Smtp_Host');
				
				$mail = new My_PHPMailer;

				$mail->SMTPDebug = 0;
				
				$mail->isSMTP();
				$mail->CharSet = 'UTF-8';
				$mail->Host = $hostSmtp;
				$mail->SMTPAuth = true;
				$mail->Username = $noReply;
				$mail->Password = $pwd;
				$mail->SMTPSecure = 'tls';
				$mail->Port = 587;
				$mail->setFrom($noReply, 'No-Reply');
				$mail->Sender = $noReply;
				$mail->addAddress($to, 'Contact');
				$mail->addReplyTo($mailcontact, $namecontact);
				$mail->isHTML(true);
				
				$mail->Subject = $subject;
				$mail->Body    = $message;
				$mail->AltBody = $namecontact.'\n'.$messagecontact.'\nSi ce mail est imprimé, merci de ne pas le jeter sur la voie publique.';
				
				if(!$mail->send()) {
				    $this->view->success = -1;
				} else {
				    $this->view->success = 1;
				}
				
				//$this->_helper->viewRenderer->setNoRender(true);
				/*if(mail($to, $subject, $message, $headers)){//, "-f".$mailcontact)){ //
					$this->view->success = 1;
				} else {
					$this->view->success = -1;
				}*/
			}
		}
    }

    public function adminAction()
    {
        $request = $this->getRequest();
        $this->view->headTitle = "Hapta ". Zend_Registry::get('City_Location') ." - Demande d'accès";
    	if($request->isPost()){
    		$formData = $request->getPost();
			$namecontact = $formData['name_contact'];
			$mailcontact = $formData['mail_contact'];
			$motifcontact = $formData['motif_contact'];
			$techniquescontact = $formData['techniques_contact'];
			$paternariatcontact = $formData['paternariat_contact'];
			$messagecontact = $formData['message_contact'];

			if($namecontact != "") {	
				$subject = "Demande d'accès à la plateforme d'admin";
				
				$message  = '
								<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
								<html xmlns="http://www.w3.org/1999/xhtml">
								<head>
								  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
								  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
								</head>
								<body style="margin: 0; padding: 0; height:100%;">
								 <table border="0" background="http://www.haptalyon.fr/img/backMail.png" cellpadding="0" cellspacing="0" width="100%" height="100%">
								  <tr>
								   <td>
								     <table align="center" border="0" cellpadding="0" cellspacing="0" width="600" style="border-collapse: collapse;">
								       <tr>
								         <td align="center" style="padding: 40px 0 30px 0;">
								          <img src="http://www.haptalyon.fr/img/logoMail.png" alt="Logo Hapta" />
								         </td>
								       </tr>
								       <tr>
								         <td style="padding: 0 0 20px 0;">
								           <table bgcolor="#ffffff" style="padding: 20px 30px 20px 30px;" border="0" cellpadding="0" cellspacing="0" width="100%">
								            <tr>
								             <td>
								                '.$namecontact.'<br/><br/>'.$messagecontact.'
								             </td>
								            </tr>
								           </table>
								         </td>
								       </tr>
								       <tr style="padding: 0 0 30px 0;">
								         <td bgcolor="#4e67a9" style="padding: 30px 30px 30px 30px; font-family: \'UbuntuRegular\', Helvetica, Arial, sans-serif;">
								           <table border="0" cellpadding="0" cellspacing="0" width="100%">
								             <td width="75%" style="color:#FFF;">
								              <a href="http://www.'. Zend_Registry::get('Site_Address') .'" target="_blank" style="text-decoration:none; color:#FFF;" >www.'. Zend_Registry::get('Site_Address') .'</a><br/>
								             </td>
								             <td align="right">
								              <table border="0" cellpadding="0" cellspacing="0">
								               <tr>
								                <td>
								                 <a href="http://www.facebook.com/'. Zend_Registry::get('Fb_Link') .'" target="_blank">
								                  <img src="http://www.iconsdb.com/icons/preview/white/facebook-5-xxl.png" alt="Facebook" width="34" height="34" style="display: block;" border="0" />
								                 </a>
								                </td>
								               </tr>
								              </table>
								             </td>
								           </table>
								         </td>
								       </tr>
								     </table>
								   </td>
								  </tr>
								 </table>
								</body>
								</html>
						    ';

				$to = Zend_Registry::get('Address_Admin');
				$noReply = Zend_Registry::get('No_Reply_Email');
				$pwd = Zend_Registry::get('No_Reply_Pass');
				$hostSmtp = Zend_Registry::get('Smtp_Host');
				
				$mail = new My_PHPMailer;

				$mail->SMTPDebug = 0;
				
				$mail->isSMTP();
				$mail->CharSet = 'UTF-8';
				$mail->Host = $hostSmtp;
				$mail->SMTPAuth = true;
				$mail->Username = $noReply;
				$mail->Password = $pwd;
				$mail->SMTPSecure = 'tls';
				$mail->Port = 587;
				$mail->setFrom($noReply, 'No-Reply');
				$mail->Sender = $noReply;
				$mail->addAddress($to, 'Contact');
				$mail->addReplyTo($mailcontact, $namecontact);
				$mail->isHTML(true);
				
				$mail->Subject = $subject;
				$mail->Body    = $message;
				$mail->AltBody = $namecontact.'\n'.$messagecontact.'\nSi ce mail est imprimé, merci de ne pas le jeter sur la voie publique.';
				
				if(!$mail->send()) {
				    $this->view->success = -1;
				} else {
				    $this->view->success = 1;
				}
				
				//$this->_helper->viewRenderer->setNoRender(true);
				/*if(mail($to, $subject, $message, $headers)){//, "-f".$mailcontact)){ //
					$this->view->success = 1;
				} else {
					$this->view->success = -1;
				}*/
			}
		}
    }


}



