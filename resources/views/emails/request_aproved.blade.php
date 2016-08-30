<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
    	<!-- NAME: 1 COLUMN -->
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>{{ $data['subject'] }}</title>
        
    <style type="text/css">
		body,#bodyTable,#bodyCell{
			height:100% !important;
			margin:0;
			padding:0;
			width:100% !important;
		}
		table{
			border-collapse:collapse;
		}
		img,a img{
			border:0;
			outline:none;
			text-decoration:none;
		}
		h1,h2,h3,h4,h5,h6{
			margin:0;
			padding:0;
		}
		p{
			margin:1em 0;
			padding:0;
		}
		a{
			word-wrap:break-word;
		}
		.ReadMsgBody{
			width:100%;
		}
		.ExternalClass{
			width:100%;
		}
		.ExternalClass,.ExternalClass p,.ExternalClass span,.ExternalClass font,.ExternalClass td,.ExternalClass div{
			line-height:100%;
		}
		table,td{
			mso-table-lspace:0pt;
			mso-table-rspace:0pt;
		}
		#outlook a{
			padding:0;
		}
		img{
			-ms-interpolation-mode:bicubic;
		}
		body,table,td,p,a,li,blockquote{
			-ms-text-size-adjust:100%;
			-webkit-text-size-adjust:100%;
		}
		#templatePreheader,#templateHeader,#templateBody,#templateFooter{
			min-width:100%;
		}
		#bodyCell{
			padding:20px;
		}
		.mcnImage{
			vertical-align:bottom;
		}
		.mcnTextContent img{
			height:auto !important;
		}
	/*
	#tab Page
	#section background style
	#tip Set the background color and top border for your email. You may want to choose colors that match your company's branding.
	*/
		body,#bodyTable{
			/*#editable*/background-color:#F2F2F2;
		}
	/*
	#tab Page
	#section background style
	#tip Set the background color and top border for your email. You may want to choose colors that match your company's branding.
	*/
		#bodyCell{
			/*#editable*/border-top:0;
		}
	/*
	#tab Page
	#section email border
	#tip Set the border for your email.
	*/
		#templateContainer{
			/*#editable*/border:0;
		}
	/*
	#tab Page
	#section heading 1
	#tip Set the styling for all first-level headings in your emails. These should be the largest of your headings.
	#style heading 1
	*/
		h1{
			/*#editable*/color:#606060 !important;
			display:block;
			/*#editable*/font-family:Helvetica;
			/*#editable*/font-size:40px;
			/*#editable*/font-style:normal;
			/*#editable*/font-weight:bold;
			/*#editable*/line-height:125%;
			/*#editable*/letter-spacing:-1px;
			margin:0;
			/*#editable*/text-align:left;
		}
	/*
	#tab Page
	#section heading 2
	#tip Set the styling for all second-level headings in your emails.
	#style heading 2
	*/
		h2{
			/*#editable*/color:#404040 !important;
			display:block;
			/*#editable*/font-family:Helvetica;
			/*#editable*/font-size:26px;
			/*#editable*/font-style:normal;
			/*#editable*/font-weight:bold;
			/*#editable*/line-height:125%;
			/*#editable*/letter-spacing:-.75px;
			margin:0;
			/*#editable*/text-align:left;
		}
	/*
	#tab Page
	#section heading 3
	#tip Set the styling for all third-level headings in your emails.
	#style heading 3
	*/
		h3{
			/*#editable*/color:#606060 !important;
			display:block;
			/*#editable*/font-family:Helvetica;
			/*#editable*/font-size:18px;
			/*#editable*/font-style:normal;
			/*#editable*/font-weight:bold;
			/*#editable*/line-height:125%;
			/*#editable*/letter-spacing:-.5px;
			margin:0;
			/*#editable*/text-align:left;
		}
	/*
	#tab Page
	#section heading 4
	#tip Set the styling for all fourth-level headings in your emails. These should be the smallest of your headings.
	#style heading 4
	*/
		h4{
			/*#editable*/color:#808080 !important;
			display:block;
			/*#editable*/font-family:Helvetica;
			/*#editable*/font-size:16px;
			/*#editable*/font-style:normal;
			/*#editable*/font-weight:bold;
			/*#editable*/line-height:125%;
			/*#editable*/letter-spacing:normal;
			margin:0;
			/*#editable*/text-align:left;
		}
	/*
	#tab Preheader
	#section preheader style
	#tip Set the background color and borders for your email's preheader area.
	*/
		#templatePreheader{
			/*#editable*/background-color:#FFFFFF;
			/*#editable*/border-top:0;
			/*#editable*/border-bottom:0;
		}
	/*
	#tab Preheader
	#section preheader text
	#tip Set the styling for your email's preheader text. Choose a size and color that is easy to read.
	*/
		.preheaderContainer .mcnTextContent,.preheaderContainer .mcnTextContent p{
			/*#editable*/color:#606060;
			/*#editable*/font-family:Helvetica;
			/*#editable*/font-size:11px;
			/*#editable*/line-height:125%;
			/*#editable*/text-align:left;
		}
	/*
	#tab Preheader
	#section preheader link
	#tip Set the styling for your email's header links. Choose a color that helps them stand out from your text.
	*/
		.preheaderContainer .mcnTextContent a{
			/*#editable*/color:#606060;
			/*#editable*/font-weight:normal;
			/*#editable*/text-decoration:underline;
		}
	/*
	#tab Header
	#section header style
	#tip Set the background color and borders for your email's header area.
	*/
		#templateHeader{
			/*#editable*/background-color:#FFFFFF;
			/*#editable*/border-top:0;
			/*#editable*/border-bottom:0;
		}
	/*
	#tab Header
	#section header text
	#tip Set the styling for your email's header text. Choose a size and color that is easy to read.
	*/
		.headerContainer .mcnTextContent,.headerContainer .mcnTextContent p{
			/*#editable*/color:#606060;
			/*#editable*/font-family:Helvetica;
			/*#editable*/font-size:15px;
			/*#editable*/line-height:150%;
			/*#editable*/text-align:left;
		}
	/*
	#tab Header
	#section header link
	#tip Set the styling for your email's header links. Choose a color that helps them stand out from your text.
	*/
		.headerContainer .mcnTextContent a{
			/*#editable*/color:#6DC6DD;
			/*#editable*/font-weight:normal;
			/*#editable*/text-decoration:underline;
		}
	/*
	#tab Body
	#section body style
	#tip Set the background color and borders for your email's body area.
	*/
		#templateBody{
			/*#editable*/background-color:#FFFFFF;
			/*#editable*/border-top:0;
			/*#editable*/border-bottom:0;
		}
	/*
	#tab Body
	#section body text
	#tip Set the styling for your email's body text. Choose a size and color that is easy to read.
	*/
		.bodyContainer .mcnTextContent,.bodyContainer .mcnTextContent p{
			/*#editable*/color:#606060;
			/*#editable*/font-family:Helvetica;
			/*#editable*/font-size:15px;
			/*#editable*/line-height:150%;
			/*#editable*/text-align:left;
		}
	/*
	#tab Body
	#section body link
	#tip Set the styling for your email's body links. Choose a color that helps them stand out from your text.
	*/
		.bodyContainer .mcnTextContent a{
			/*#editable*/color:#6DC6DD;
			/*#editable*/font-weight:normal;
			/*#editable*/text-decoration:underline;
		}
	/*
	#tab Footer
	#section footer style
	#tip Set the background color and borders for your email's footer area.
	*/
		#templateFooter{
			/*#editable*/background-color:#FFFFFF;
			/*#editable*/border-top:0;
			/*#editable*/border-bottom:0;
		}
	/*
	#tab Footer
	#section footer text
	#tip Set the styling for your email's footer text. Choose a size and color that is easy to read.
	*/
		.footerContainer .mcnTextContent,.footerContainer .mcnTextContent p{
			/*#editable*/color:#606060;
			/*#editable*/font-family:Helvetica;
			/*#editable*/font-size:11px;
			/*#editable*/line-height:125%;
			/*#editable*/text-align:left;
		}
	/*
	#tab Footer
	#section footer link
	#tip Set the styling for your email's footer links. Choose a color that helps them stand out from your text.
	*/
		.footerContainer .mcnTextContent a{
			/*#editable*/color:#606060;
			/*#editable*/font-weight:normal;
			/*#editable*/text-decoration:underline;
		}
	#media only screen and (max-width: 480px){
		body,table,td,p,a,li,blockquote{
			-webkit-text-size-adjust:none !important;
		}

}	#media only screen and (max-width: 480px){
		body{
			width:100% !important;
			min-width:100% !important;
		}

}	#media only screen and (max-width: 480px){
		td[id=bodyCell]{
			padding:10px !important;
		}

}	#media only screen and (max-width: 480px){
		table[class=mcnTextContentContainer]{
			width:100% !important;
		}

}	#media only screen and (max-width: 480px){
		.mcnBoxedTextContentContainer{
			max-width:100% !important;
			min-width:100% !important;
			width:100% !important;
		}

}	#media only screen and (max-width: 480px){
		table[class=mcpreview-image-uploader]{
			width:100% !important;
			display:none !important;
		}

}	#media only screen and (max-width: 480px){
		img[class=mcnImage]{
			width:100% !important;
		}

}	#media only screen and (max-width: 480px){
		table[class=mcnImageGroupContentContainer]{
			width:100% !important;
		}

}	#media only screen and (max-width: 480px){
		td[class=mcnImageGroupContent]{
			padding:9px !important;
		}

}	#media only screen and (max-width: 480px){
		td[class=mcnImageGroupBlockInner]{
			padding-bottom:0 !important;
			padding-top:0 !important;
		}

}	#media only screen and (max-width: 480px){
		tbody[class=mcnImageGroupBlockOuter]{
			padding-bottom:9px !important;
			padding-top:9px !important;
		}

}	#media only screen and (max-width: 480px){
		table[class=mcnCaptionTopContent],table[class=mcnCaptionBottomContent]{
			width:100% !important;
		}

}	#media only screen and (max-width: 480px){
		table[class=mcnCaptionLeftTextContentContainer],table[class=mcnCaptionRightTextContentContainer],table[class=mcnCaptionLeftImageContentContainer],table[class=mcnCaptionRightImageContentContainer],table[class=mcnImageCardLeftTextContentContainer],table[class=mcnImageCardRightTextContentContainer]{
			width:100% !important;
		}

}	#media only screen and (max-width: 480px){
		td[class=mcnImageCardLeftImageContent],td[class=mcnImageCardRightImageContent]{
			padding-right:18px !important;
			padding-left:18px !important;
			padding-bottom:0 !important;
		}

}	#media only screen and (max-width: 480px){
		td[class=mcnImageCardBottomImageContent]{
			padding-bottom:9px !important;
		}

}	#media only screen and (max-width: 480px){
		td[class=mcnImageCardTopImageContent]{
			padding-top:18px !important;
		}

}	#media only screen and (max-width: 480px){
		td[class=mcnImageCardLeftImageContent],td[class=mcnImageCardRightImageContent]{
			padding-right:18px !important;
			padding-left:18px !important;
			padding-bottom:0 !important;
		}

}	#media only screen and (max-width: 480px){
		td[class=mcnImageCardBottomImageContent]{
			padding-bottom:9px !important;
		}

}	#media only screen and (max-width: 480px){
		td[class=mcnImageCardTopImageContent]{
			padding-top:18px !important;
		}

}	#media only screen and (max-width: 480px){
		table[class=mcnCaptionLeftContentOuter] td[class=mcnTextContent],table[class=mcnCaptionRightContentOuter] td[class=mcnTextContent]{
			padding-top:9px !important;
		}

}	#media only screen and (max-width: 480px){
		td[class=mcnCaptionBlockInner] table[class=mcnCaptionTopContent]:last-child td[class=mcnTextContent]{
			padding-top:18px !important;
		}

}	#media only screen and (max-width: 480px){
		td[class=mcnBoxedTextContentColumn]{
			padding-left:18px !important;
			padding-right:18px !important;
		}

}	#media only screen and (max-width: 480px){
		td[class=mcnTextContent]{
			padding-right:18px !important;
			padding-left:18px !important;
		}

}	#media only screen and (max-width: 480px){
	/*
	#tab Mobile Styles
	#section template width
	#tip Make the template fluid for portrait or landscape view adaptability. If a fluid layout doesn't work for you, set the width to 300px instead.
	*/
		table[id=templateContainer],table[id=templatePreheader],table[id=templateHeader],table[id=templateBody],table[id=templateFooter]{
			/*#tab Mobile Styles
#section template width
#tip Make the template fluid for portrait or landscape view adaptability. If a fluid layout doesn't work for you, set the width to 300px instead.*/max-width:600px !important;
			/*#editable*/width:100% !important;
		}

}	#media only screen and (max-width: 480px){
	/*
	#tab Mobile Styles
	#section heading 1
	#tip Make the first-level headings larger in size for better readability on small screens.
	*/
		h1{
			/*#editable*/font-size:24px !important;
			/*#editable*/line-height:125% !important;
		}

}	#media only screen and (max-width: 480px){
	/*
	#tab Mobile Styles
	#section heading 2
	#tip Make the second-level headings larger in size for better readability on small screens.
	*/
		h2{
			/*#editable*/font-size:20px !important;
			/*#editable*/line-height:125% !important;
		}

}	#media only screen and (max-width: 480px){
	/*
	#tab Mobile Styles
	#section heading 3
	#tip Make the third-level headings larger in size for better readability on small screens.
	*/
		h3{
			/*#editable*/font-size:18px !important;
			/*#editable*/line-height:125% !important;
		}

}	#media only screen and (max-width: 480px){
	/*
	#tab Mobile Styles
	#section heading 4
	#tip Make the fourth-level headings larger in size for better readability on small screens.
	*/
		h4{
			/*#editable*/font-size:16px !important;
			/*#editable*/line-height:125% !important;
		}

}	#media only screen and (max-width: 480px){
	/*
	#tab Mobile Styles
	#section Boxed Text
	#tip Make the boxed text larger in size for better readability on small screens. We recommend a font size of at least 16px.
	*/
		table[class=mcnBoxedTextContentContainer] td[class=mcnTextContent],td[class=mcnBoxedTextContentContainer] td[class=mcnTextContent] p{
			/*#editable*/font-size:18px !important;
			/*#editable*/line-height:125% !important;
		}

}	#media only screen and (max-width: 480px){
	/*
	#tab Mobile Styles
	#section Preheader Visibility
	#tip Set the visibility of the email's preheader on small screens. You can hide it to save space.
	*/
		table[id=templatePreheader]{
			/*#editable*/display:block !important;
		}

}	#media only screen and (max-width: 480px){
	/*
	#tab Mobile Styles
	#section Preheader Text
	#tip Make the preheader text larger in size for better readability on small screens.
	*/
		td[class=preheaderContainer] td[class=mcnTextContent],td[class=preheaderContainer] td[class=mcnTextContent] p{
			/*#editable*/font-size:14px !important;
			/*#editable*/line-height:115% !important;
		}

}	#media only screen and (max-width: 480px){
	/*
	#tab Mobile Styles
	#section Header Text
	#tip Make the header text larger in size for better readability on small screens.
	*/
		td[class=headerContainer] td[class=mcnTextContent],td[class=headerContainer] td[class=mcnTextContent] p{
			/*#editable*/font-size:18px !important;
			/*#editable*/line-height:125% !important;
		}

}	#media only screen and (max-width: 480px){
	/*
	#tab Mobile Styles
	#section Body Text
	#tip Make the body text larger in size for better readability on small screens. We recommend a font size of at least 16px.
	*/
		td[class=bodyContainer] td[class=mcnTextContent],td[class=bodyContainer] td[class=mcnTextContent] p{
			/*#editable*/font-size:18px !important;
			/*#editable*/line-height:125% !important;
		}

}	#media only screen and (max-width: 480px){
	/*
	#tab Mobile Styles
	#section footer text
	#tip Make the body content text larger in size for better readability on small screens.
	*/
		td[class=footerContainer] td[class=mcnTextContent],td[class=footerContainer] td[class=mcnTextContent] p{
			/*#editable*/font-size:14px !important;
			/*#editable*/line-height:115% !important;
		}

}	#media only screen and (max-width: 480px){
		td[class=footerContainer] a[class=utilityLink]{
			display:block !important;
		}

}</style></head>
    <body leftmargin="0" marginwidth="0" topmargin="0" marginheight="0" offset="0" style="margin: 0;padding: 0;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;background-color: #F2F2F2;height: 100% !important;width: 100% !important;">
        <center>
            <table align="center" border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" id="bodyTable" style="border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;margin: 0;padding: 0;background-color: #F2F2F2;height: 100% !important;width: 100% !important;">
                <tr>
                    <td align="center" valign="top" id="bodyCell" style="mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;margin: 0;padding: 20px;border-top: 0;height: 100% !important;width: 100% !important;">
                        <!-- BEGIN TEMPLATE // -->
                        <table border="0" cellpadding="0" cellspacing="0" width="600" id="templateContainer" style="border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;border: 0;">
                            <tr>
                                <td align="center" valign="top" style="mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
                                    <!-- BEGIN PREHEADER // -->
                                </td>
                            </tr>
                            <tr>
                                <td align="center" valign="top" style="mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
                                    <!-- BEGIN HEADER // -->
                                    <table border="0" cellpadding="0" cellspacing="0" width="600" id="templateHeader" style="border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;min-width: 100%;background-color: #FFFFFF;border-top: 0;border-bottom: 0;">
                                        <tr>
                                            <td valign="top" class="headerContainer" style="mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;"><table class="mcnImageBlock" style="min-width: 100%;border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;" border="0" width="100%" cellspacing="0" cellpadding="0">
    <tbody class="mcnImageBlockOuter">
            <tr>
                <td style="padding: 9px;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;" class="mcnImageBlockInner" valign="top">
                    <table class="mcnImageContentContainer" style="min-width: 100%;border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;" border="0" align="left" width="100%" cellspacing="0" cellpadding="0">
                        <tbody><tr>
                            <td class="mcnImageContent" style="padding-right: 9px;padding-left: 9px;padding-top: 0;padding-bottom: 0;text-align: center;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;" valign="top">
                                
                                    
                                        <img alt="" src="https://gallery.mailchimp.com/c18139164ef33dfeff4ee36e6/images/953d3368-4b11-4257-ac51-330a12193cd2.png" style="max-width: 170px;padding-bottom: 0;display: inline !important;vertical-align: bottom;border: 0;outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;" class="mcnImage" align="middle" width="170">
                                    
                                
                            </td>
                        </tr>
                    </tbody></table>
                </td>
            </tr>
    </tbody>
</table></td>
                                        </tr>
                                    </table>
                                    <!-- // END HEADER -->
                                </td>
                            </tr>
                            <tr>
                                <td align="center" valign="top" style="mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
                                    <!-- BEGIN BODY // -->
                                    <table border="0" cellpadding="0" cellspacing="0" width="600" id="templateBody" style="border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;min-width: 100%;background-color: #FFFFFF;border-top: 0;border-bottom: 0;">
                                        <tr>
                                            <td valign="top" class="bodyContainer" style="mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;"><table class="mcnTextBlock" style="min-width: 100%;border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;" border="0" width="100%" cellspacing="0" cellpadding="0">
    <tbody class="mcnTextBlockOuter">
        <tr>
            <td class="mcnTextBlockInner" style="padding-top: 9px;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;" valign="top">
              	<!--[if mso]>
				<table align="left" border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100%;">
				<tr>
				<![endif]-->
			    
				<!--[if mso]>
				<td valign="top" width="600" style="width:600px;">
				<![endif]-->
                <table style="max-width: 100%;min-width: 100%;border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;" class="mcnTextContentContainer" border="0" align="left" width="100%" cellspacing="0" cellpadding="0">
                    <tbody><tr>
                        
                        <td class="mcnTextContent" style="padding-top: 0;padding-right: 18px;padding-bottom: 9px;padding-left: 18px;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;color: #606060;font-family: Helvetica;font-size: 15px;line-height: 150%;text-align: left;" valign="top">
                        
                            <h1 style="margin: 0;padding: 0;display: block;font-family: Helvetica;font-size: 40px;font-style: normal;font-weight: bold;line-height: 125%;letter-spacing: -1px;text-align: left;color: #606060 !important;">Pedido de ajuste de hora</h1>

<h3 style="margin: 0;padding: 0;display: block;font-family: Helvetica;font-size: 18px;font-style: normal;font-weight: bold;line-height: 125%;letter-spacing: -.5px;text-align: left;color: #606060 !important;">Sua requisição foi efetuada</h3>

<p style="margin: 1em 0;padding: 0;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;color: #606060;font-family: Helvetica;font-size: 15px;line-height: 150%;text-align: left;">Voce requisitou mudança de horário em sua timesheet no dia <strong>{{ $data['day'] }}</strong>, os ajustes foram efetuados por {{ $data['name'] }}:</p>

                        </td>
                    </tr>
                </tbody></table>
				<!--[if mso]>
				</td>
				<![endif]-->
                
				<!--[if mso]>
				</tr>
				</table>
				<![endif]-->
            </td>
        </tr>
    </tbody>
</table><table class="mcnCodeBlock" border="0" width="100%" cellspacing="0" cellpadding="0" style="border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
    <tbody class="mcnTextBlockOuter">
        <tr>
            <td class="mcnTextBlockInner" valign="top" style="mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
                <div class="mcnTextContent" style="color: #606060;font-family: Helvetica;font-size: 15px;line-height: 150%;text-align: left;">
	<table style="width: 100%;text-align: center;border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
    	<thead>
        	<tr style="border:solid thin #ccc">
            	<td style="width: 25%;border: solid thin #ccc;padding: 3px;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">Entrada</td>
            	<td style="width: 25%;border: solid thin #ccc;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">Almoço ida</td>
            	<td style="width: 25%;border: solid thin #ccc;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">Almoço volta</td>
            	<td style="width: 25%;border: solid thin #ccc;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">Saída</td>
        	</tr>
        </thead>
    	<tbody>
        	<tr>
            	<td style="mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">{{ $data['start'] }}</td>
            	<td style="mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">{{ $data['lunch_start'] }}</td>
            	<td style="mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">{{ $data['lunch_end'] }}</td>
            	<td style="mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">{{ $data['end'] }}</td>
        	</tr>
        </tbody>
    </table>
</div>
            </td>
        </tr>
    </tbody>
</table><table class="mcnTextBlock" style="min-width: 100%;border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;" border="0" width="100%" cellspacing="0" cellpadding="0">
    <tbody class="mcnTextBlockOuter">
        <tr>
            <td class="mcnTextBlockInner" style="padding-top: 9px;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;" valign="top">
              	<!--[if mso]>
				<table align="left" border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100%;">
				<tr>
				<![endif]-->
			    
				<!--[if mso]>
				<td valign="top" width="600" style="width:600px;">
				<![endif]-->
                <table style="max-width: 100%;min-width: 100%;border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;" class="mcnTextContentContainer" border="0" align="left" width="100%" cellspacing="0" cellpadding="0">
                    <tbody><tr>
                        
                        <td class="mcnTextContent" style="padding-top: 0;padding-right: 18px;padding-bottom: 9px;padding-left: 18px;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;color: #606060;font-family: Helvetica;font-size: 15px;line-height: 150%;text-align: left;" valign="top">
                        
                            Acesse <a href="{{ url() }}/timesheet" target="_blank" style="word-wrap: break-word;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;color: #6DC6DD;font-weight: normal;text-decoration: underline;">{{ url() }}/timesheet</a> para ver a alteração.
                        </td>
                    </tr>
                </tbody></table>
				<!--[if mso]>
				</td>
				<![endif]-->
                
				<!--[if mso]>
				</tr>
				</table>
				<![endif]-->
            </td>
        </tr>
    </tbody>
</table></td>
                                        </tr>
                                    </table>
                                    <!-- // END BODY -->
                                </td>
                            </tr>
                            <tr>
                                <td align="center" valign="top" style="mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
                                    <!-- BEGIN FOOTER // -->
                                    <table border="0" cellpadding="0" cellspacing="0" width="600" id="templateFooter" style="border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;min-width: 100%;background-color: #FFFFFF;border-top: 0;border-bottom: 0;">
                                        <tr>
                                            <td valign="top" class="footerContainer" style="padding-bottom: 9px;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;"><table class="mcnTextBlock" style="min-width: 100%;border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;" border="0" width="100%" cellspacing="0" cellpadding="0">
    <tbody class="mcnTextBlockOuter">
        <tr>
            <td class="mcnTextBlockInner" style="padding-top: 9px;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;" valign="top">
              	<!--[if mso]>
				<table align="left" border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100%;">
				<tr>
				<![endif]-->
			    
				<!--[if mso]>
				<td valign="top" width="600" style="width:600px;">
				<![endif]-->
                <table style="max-width: 100%;min-width: 100%;border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;" class="mcnTextContentContainer" border="0" align="left" width="100%" cellspacing="0" cellpadding="0">
                    <tbody><tr>
                        
                        <td class="mcnTextContent" style="padding-top: 0;padding-right: 18px;padding-bottom: 9px;padding-left: 18px;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;color: #606060;font-family: Helvetica;font-size: 11px;line-height: 125%;text-align: left;" valign="top">
                        
                            <em>Copyright © {{ $data['year'] }} {{ $data['company'] }}, Todos os direitos reservados.</em>
                        </td>
                    </tr>
                </tbody></table>
				<!--[if mso]>
				</td>
				<![endif]-->
                
				<!--[if mso]>
				</tr>
				</table>
				<![endif]-->
            </td>
        </tr>
    </tbody>
</table></td>
                                        </tr>
                                    </table>
                                    <!-- // END FOOTER -->
                                </td>
                            </tr>
                        </table>
                        <!-- // END TEMPLATE -->
                    </td>
                </tr>
            </table>
        </center>
    </body>
</html>