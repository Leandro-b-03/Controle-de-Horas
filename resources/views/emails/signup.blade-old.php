<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<!-- NAME: 1:2 COLUMN -->
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>{!! Lang::get('emails.signup-welcome') !!}</title>
		
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
	@tab Page
	@sections background style
	@tip Set the background color and top border for your email. You may want to choose colors that match your company's branding.
	*/
		body,#bodyTable{
			/*@editable*/background-color:#F2F2F2;
		}
	/*
	@tab Page
	@sections background style
	@tip Set the background color and top border for your email. You may want to choose colors that match your company's branding.
	*/
		#bodyCell{
			/*@editable*/border-top:0;
		}
	/*
	@tab Page
	@sections email border
	@tip Set the border for your email.
	*/
		#templateContainer{
			/*@editable*/border:0;
		}
	/*
	@tab Page
	@sections heading 1
	@tip Set the styling for all first-level headings in your emails. These should be the largest of your headings.
	@style heading 1
	*/
		h1{
			/*@editable*/color:#606060 !important;
			display:block;
			/*@editable*/font-family:Helvetica;
			/*@editable*/font-size:40px;
			/*@editable*/font-style:normal;
			/*@editable*/font-weight:bold;
			/*@editable*/line-height:125%;
			/*@editable*/letter-spacing:-1px;
			margin:0;
			/*@editable*/text-align:left;
		}
	/*
	@tab Page
	@sections heading 2
	@tip Set the styling for all second-level headings in your emails.
	@style heading 2
	*/
		h2{
			/*@editable*/color:#404040 !important;
			display:block;
			/*@editable*/font-family:Helvetica;
			/*@editable*/font-size:26px;
			/*@editable*/font-style:normal;
			/*@editable*/font-weight:bold;
			/*@editable*/line-height:125%;
			/*@editable*/letter-spacing:-.75px;
			margin:0;
			/*@editable*/text-align:left;
		}
	/*
	@tab Page
	@sections heading 3
	@tip Set the styling for all third-level headings in your emails.
	@style heading 3
	*/
		h3{
			/*@editable*/color:#606060 !important;
			display:block;
			/*@editable*/font-family:Helvetica;
			/*@editable*/font-size:18px;
			/*@editable*/font-style:normal;
			/*@editable*/font-weight:bold;
			/*@editable*/line-height:125%;
			/*@editable*/letter-spacing:-.5px;
			margin:0;
			/*@editable*/text-align:left;
		}
	/*
	@tab Page
	@sections heading 4
	@tip Set the styling for all fourth-level headings in your emails. These should be the smallest of your headings.
	@style heading 4
	*/
		h4{
			/*@editable*/color:#808080 !important;
			display:block;
			/*@editable*/font-family:Helvetica;
			/*@editable*/font-size:16px;
			/*@editable*/font-style:normal;
			/*@editable*/font-weight:bold;
			/*@editable*/line-height:125%;
			/*@editable*/letter-spacing:normal;
			margin:0;
			/*@editable*/text-align:left;
		}
	/*
	@tab Preheader
	@sections preheader style
	@tip Set the background color and borders for your email's preheader area.
	*/
		#templatePreheader{
			/*@editable*/background-color:#FFFFFF;
			/*@editable*/border-top:0;
			/*@editable*/border-bottom:0;
		}
	/*
	@tab Preheader
	@sections preheader text
	@tip Set the styling for your email's preheader text. Choose a size and color that is easy to read.
	*/
		.preheaderContainer .mcnTextContent,.preheaderContainer .mcnTextContent p{
			/*@editable*/color:#606060;
			/*@editable*/font-family:Helvetica;
			/*@editable*/font-size:11px;
			/*@editable*/line-height:125%;
			/*@editable*/text-align:left;
		}
	/*
	@tab Preheader
	@sections preheader link
	@tip Set the styling for your email's header links. Choose a color that helps them stand out from your text.
	*/
		.preheaderContainer .mcnTextContent a{
			/*@editable*/color:#606060;
			/*@editable*/font-weight:normal;
			/*@editable*/text-decoration:underline;
		}
	/*
	@tab Header
	@sections header style
	@tip Set the background color and borders for your email's header area.
	*/
		#templateHeader{
			/*@editable*/background-color:#FFFFFF;
			/*@editable*/border-top:0;
			/*@editable*/border-bottom:0;
		}
	/*
	@tab Header
	@sections header text
	@tip Set the styling for your email's header text. Choose a size and color that is easy to read.
	*/
		.headerContainer .mcnTextContent,.headerContainer .mcnTextContent p{
			/*@editable*/color:#606060;
			/*@editable*/font-family:Helvetica;
			/*@editable*/font-size:15px;
			/*@editable*/line-height:150%;
			/*@editable*/text-align:left;
		}
	/*
	@tab Header
	@sections header link
	@tip Set the styling for your email's header links. Choose a color that helps them stand out from your text.
	*/
		.headerContainer .mcnTextContent a{
			/*@editable*/color:#6DC6DD;
			/*@editable*/font-weight:normal;
			/*@editable*/text-decoration:underline;
		}
	/*
	@tab Body
	@sections body style
	@tip Set the background color and borders for your email's body area.
	*/
		#templateBody{
			/*@editable*/background-color:#FFFFFF;
			/*@editable*/border-top:0;
			/*@editable*/border-bottom:0;
		}
	/*
	@tab Body
	@sections body text
	@tip Set the styling for your email's body text. Choose a size and color that is easy to read.
	*/
		.bodyContainer .mcnTextContent,.bodyContainer .mcnTextContent p{
			/*@editable*/color:#606060;
			/*@editable*/font-family:Helvetica;
			/*@editable*/font-size:15px;
			/*@editable*/line-height:150%;
			/*@editable*/text-align:left;
		}
	/*
	@tab Body
	@sections body link
	@tip Set the styling for your email's body links. Choose a color that helps them stand out from your text.
	*/
		.bodyContainer .mcnTextContent a{
			/*@editable*/color:#6DC6DD;
			/*@editable*/font-weight:normal;
			/*@editable*/text-decoration:underline;
		}
	/*
	@tab Columns
	@sections column style
	@tip Set the background color and borders for your email's columns area.
	*/
		#templateColumns{
			/*@editable*/background-color:#FFFFFF;
			/*@editable*/border-top:0;
			/*@editable*/border-bottom:0;
		}
	/*
	@tab Columns
	@sections left column text
	@tip Set the styling for your email's left column text. Choose a size and color that is easy to read.
	*/
		.leftColumnContainer .mcnTextContent,.leftColumnContainer .mcnTextContent p{
			/*@editable*/color:#606060;
			/*@editable*/font-family:Helvetica;
			/*@editable*/font-size:15px;
			/*@editable*/line-height:150%;
			/*@editable*/text-align:left;
		}
	/*
	@tab Columns
	@sections left column link
	@tip Set the styling for your email's left column links. Choose a color that helps them stand out from your text.
	*/
		.leftColumnContainer .mcnTextContent a{
			/*@editable*/color:#6DC6DD;
			/*@editable*/font-weight:normal;
			/*@editable*/text-decoration:underline;
		}
	/*
	@tab Columns
	@sections right column text
	@tip Set the styling for your email's right column text. Choose a size and color that is easy to read.
	*/
		.rightColumnContainer .mcnTextContent,.rightColumnContainer .mcnTextContent p{
			/*@editable*/color:#606060;
			/*@editable*/font-family:Helvetica;
			/*@editable*/font-size:15px;
			/*@editable*/line-height:150%;
			/*@editable*/text-align:left;
		}
	/*
	@tab Columns
	@sections right column link
	@tip Set the styling for your email's right column links. Choose a color that helps them stand out from your text.
	*/
		.rightColumnContainer .mcnTextContent a{
			/*@editable*/color:#6DC6DD;
			/*@editable*/font-weight:normal;
			/*@editable*/text-decoration:underline;
		}
	/*
	@tab Footer
	@sections footer style
	@tip Set the background color and borders for your email's footer area.
	*/
		#templateFooter{
			/*@editable*/background-color:#FFFFFF;
			/*@editable*/border-top:0;
			/*@editable*/border-bottom:0;
		}
	/*
	@tab Footer
	@sections footer text
	@tip Set the styling for your email's footer text. Choose a size and color that is easy to read.
	*/
		.footerContainer .mcnTextContent,.footerContainer .mcnTextContent p{
			/*@editable*/color:#606060;
			/*@editable*/font-family:Helvetica;
			/*@editable*/font-size:11px;
			/*@editable*/line-height:125%;
			/*@editable*/text-align:left;
		}
	/*
	@tab Footer
	@sections footer link
	@tip Set the styling for your email's footer links. Choose a color that helps them stand out from your text.
	*/
		.footerContainer .mcnTextContent a{
			/*@editable*/color:#606060;
			/*@editable*/font-weight:normal;
			/*@editable*/text-decoration:underline;
		}
	@media only screen and (max-width: 480px){
		body,table,td,p,a,li,blockquote{
			-webkit-text-size-adjust:none !important;
		}

}	@media only screen and (max-width: 480px){
		body{
			width:100% !important;
			min-width:100% !important;
		}

}	@media only screen and (max-width: 480px){
		td[id=bodyCell]{
			padding:10px !important;
		}

}	@media only screen and (max-width: 480px){
		table[class=mcnTextContentContainer]{
			width:100% !important;
		}

}	@media only screen and (max-width: 480px){
		table[class=mcnBoxedTextContentContainer]{
			width:100% !important;
		}

}	@media only screen and (max-width: 480px){
		table[class=mcpreview-image-uploader]{
			width:100% !important;
			display:none !important;
		}

}	@media only screen and (max-width: 480px){
		img[class=mcnImage]{
			width:100% !important;
		}

}	@media only screen and (max-width: 480px){
		table[class=mcnImageGroupContentContainer]{
			width:100% !important;
		}

}	@media only screen and (max-width: 480px){
		td[class=mcnImageGroupContent]{
			padding:9px !important;
		}

}	@media only screen and (max-width: 480px){
		td[class=mcnImageGroupBlockInner]{
			padding-bottom:0 !important;
			padding-top:0 !important;
		}

}	@media only screen and (max-width: 480px){
		tbody[class=mcnImageGroupBlockOuter]{
			padding-bottom:9px !important;
			padding-top:9px !important;
		}

}	@media only screen and (max-width: 480px){
		table[class=mcnCaptionTopContent],table[class=mcnCaptionBottomContent]{
			width:100% !important;
		}

}	@media only screen and (max-width: 480px){
		table[class=mcnCaptionLeftTextContentContainer],table[class=mcnCaptionRightTextContentContainer],table[class=mcnCaptionLeftImageContentContainer],table[class=mcnCaptionRightImageContentContainer],table[class=mcnImageCardLeftTextContentContainer],table[class=mcnImageCardRightTextContentContainer]{
			width:100% !important;
		}

}	@media only screen and (max-width: 480px){
		td[class=mcnImageCardLeftImageContent],td[class=mcnImageCardRightImageContent]{
			padding-right:18px !important;
			padding-left:18px !important;
			padding-bottom:0 !important;
		}

}	@media only screen and (max-width: 480px){
		td[class=mcnImageCardBottomImageContent]{
			padding-bottom:9px !important;
		}

}	@media only screen and (max-width: 480px){
		td[class=mcnImageCardTopImageContent]{
			padding-top:18px !important;
		}

}	@media only screen and (max-width: 480px){
		table[class=mcnCaptionLeftContentOuter] td[class=mcnTextContent],table[class=mcnCaptionRightContentOuter] td[class=mcnTextContent]{
			padding-top:9px !important;
		}

}	@media only screen and (max-width: 480px){
		td[class=mcnCaptionBlockInner] table[class=mcnCaptionTopContent]:last-child td[class=mcnTextContent]{
			padding-top:18px !important;
		}

}	@media only screen and (max-width: 480px){
		td[class=mcnBoxedTextContentColumn]{
			padding-left:18px !important;
			padding-right:18px !important;
		}

}	@media only screen and (max-width: 480px){
		td[class=columnsContainer]{
			display:block !important;
			max-width:600px !important;
			width:100% !important;
		}

}	@media only screen and (max-width: 480px){
		td[class=mcnTextContent]{
			padding-right:18px !important;
			padding-left:18px !important;
		}

}	@media only screen and (max-width: 480px){
	/*
	@tab Mobile Styles
	@sections template width
	@tip Make the template fluid for portrait or landscape view adaptability. If a fluid layout doesn't work for you, set the width to 300px instead.
	*/
		table[id=templateContainer],table[id=templatePreheader],table[id=templateHeader],table[id=templateColumns],table[class=templateColumn],table[id=templateBody],table[id=templateFooter]{
			/*@tab Mobile Styles
@sections template width
@tip Make the template fluid for portrait or landscape view adaptability. If a fluid layout doesn't work for you, set the width to 300px instead.*/max-width:600px !important;
			/*@editable*/width:100% !important;
		}

}	@media only screen and (max-width: 480px){
	/*
	@tab Mobile Styles
	@sections heading 1
	@tip Make the first-level headings larger in size for better readability on small screens.
	*/
		h1{
			/*@editable*/font-size:24px !important;
			/*@editable*/line-height:125% !important;
		}

}	@media only screen and (max-width: 480px){
	/*
	@tab Mobile Styles
	@sections heading 2
	@tip Make the second-level headings larger in size for better readability on small screens.
	*/
		h2{
			/*@editable*/font-size:20px !important;
			/*@editable*/line-height:125% !important;
		}

}	@media only screen and (max-width: 480px){
	/*
	@tab Mobile Styles
	@sections heading 3
	@tip Make the third-level headings larger in size for better readability on small screens.
	*/
		h3{
			/*@editable*/font-size:18px !important;
			/*@editable*/line-height:125% !important;
		}

}	@media only screen and (max-width: 480px){
	/*
	@tab Mobile Styles
	@sections heading 4
	@tip Make the fourth-level headings larger in size for better readability on small screens.
	*/
		h4{
			/*@editable*/font-size:16px !important;
			/*@editable*/line-height:125% !important;
		}

}	@media only screen and (max-width: 480px){
	/*
	@tab Mobile Styles
	@sections Boxed Text
	@tip Make the boxed text larger in size for better readability on small screens. We recommend a font size of at least 16px.
	*/
		table[class=mcnBoxedTextContentContainer] td[class=mcnTextContent],td[class=mcnBoxedTextContentContainer] td[class=mcnTextContent] p{
			/*@editable*/font-size:18px !important;
			/*@editable*/line-height:125% !important;
		}

}	@media only screen and (max-width: 480px){
	/*
	@tab Mobile Styles
	@sections Preheader Visibility
	@tip Set the visibility of the email's preheader on small screens. You can hide it to save space.
	*/
		table[id=templatePreheader]{
			/*@editable*/display:block !important;
		}

}	@media only screen and (max-width: 480px){
	/*
	@tab Mobile Styles
	@sections Preheader Text
	@tip Make the preheader text larger in size for better readability on small screens.
	*/
		td[class=preheaderContainer] td[class=mcnTextContent],td[class=preheaderContainer] td[class=mcnTextContent] p{
			/*@editable*/font-size:14px !important;
			/*@editable*/line-height:115% !important;
		}

}	@media only screen and (max-width: 480px){
	/*
	@tab Mobile Styles
	@sections Header Text
	@tip Make the header text larger in size for better readability on small screens.
	*/
		td[class=headerContainer] td[class=mcnTextContent],td[class=headerContainer] td[class=mcnTextContent] p{
			/*@editable*/font-size:18px !important;
			/*@editable*/line-height:125% !important;
		}

}	@media only screen and (max-width: 480px){
	/*
	@tab Mobile Styles
	@sections Body Text
	@tip Make the body text larger in size for better readability on small screens. We recommend a font size of at least 16px.
	*/
		td[class=bodyContainer] td[class=mcnTextContent],td[class=bodyContainer] td[class=mcnTextContent] p{
			/*@editable*/font-size:18px !important;
			/*@editable*/line-height:125% !important;
		}

}	@media only screen and (max-width: 480px){
	/*
	@tab Mobile Styles
	@sections Left Column Text
	@tip Make the left column text larger in size for better readability on small screens. We recommend a font size of at least 16px.
	*/
		td[class=leftColumnContainer] td[class=mcnTextContent],td[class=leftColumnContainer] td[class=mcnTextContent] p{
			/*@editable*/font-size:18px !important;
			/*@editable*/line-height:125% !important;
		}

}	@media only screen and (max-width: 480px){
	/*
	@tab Mobile Styles
	@sections Right Column Text
	@tip Make the right column text larger in size for better readability on small screens. We recommend a font size of at least 16px.
	*/
		td[class=rightColumnContainer] td[class=mcnTextContent],td[class=rightColumnContainer] td[class=mcnTextContent] p{
			/*@editable*/font-size:18px !important;
			/*@editable*/line-height:125% !important;
		}

}	@media only screen and (max-width: 480px){
	/*
	@tab Mobile Styles
	@sections footer text
	@tip Make the body content text larger in size for better readability on small screens.
	*/
		td[class=footerContainer] td[class=mcnTextContent],td[class=footerContainer] td[class=mcnTextContent] p{
			/*@editable*/font-size:14px !important;
			/*@editable*/line-height:115% !important;
		}

}	@media only screen and (max-width: 480px){
		td[class=footerContainer] a[class=utilityLink]{
			display:block !important;
		}

}
		</style>
	</head>
	<body leftmargin="0" marginwidth="0" topmargin="0" marginheight="0" offset="0">
		<center>
		<table align="center" border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" id="bodyTable">
			<tr>
				<td align="center" valign="top" id="bodyCell">
					<!-- BEGIN TEMPLATE // -->
					<table border="0" cellpadding="0" cellspacing="0" width="600" id="templateContainer">
						<tr>
							<td align="center" valign="top">
								<!-- BEGIN PREHEADER // -->
								<table border="0" cellpadding="0" cellspacing="0" width="600" id="templatePreheader">
									<tr>
										<td valign="top" class="preheaderContainer" style="padding-top:9px;"><table class="mcnTextBlock" border="0" cellpadding="0" cellspacing="0" width="100%">
											<tbody class="mcnTextBlockOuter">
												<tr>
													<td class="mcnTextBlockInner" valign="top">
														
														<table class="mcnTextContentContainer" align="left" border="0" cellpadding="0" cellspacing="0" width="366">
															<tbody><tr>
																
																<td class="mcnTextContent" style="padding-top:9px; padding-left:18px; padding-bottom:9px; padding-right:0;" valign="top">
																	
																	Desenvolvido por Some Ideias.
																</td>
															</tr>
														</tbody></table>
														
														<table class="mcnTextContentContainer" align="right" border="0" cellpadding="0" cellspacing="0" width="197">
															<tbody><tr>
																
																<td class="mcnTextContent" style="padding-top:9px; padding-right:18px; padding-bottom:9px; padding-left:0;" valign="top">
																	<a href="www.someideias.com" target="_blank">www.someideias.com</a>
																</td>
															</tr>
														</tbody></table>
														
													</td>
												</tr>
											</tbody>
										</table></td>
									</tr>
								</table>
								<!-- // END PREHEADER -->
							</td>
						</tr>
						<tr>
							<td align="center" valign="top">
								<!-- BEGIN HEADER // -->
								<table border="0" cellpadding="0" cellspacing="0" width="600" id="templateHeader">
									<tr>
										<td valign="top" class="headerContainer"><table class="mcnImageBlock" border="0" cellpadding="0" cellspacing="0" width="100%">
											<tbody class="mcnImageBlockOuter">
												<tr>
													<td style="padding:9px" class="mcnImageBlockInner" valign="top">
														<table class="mcnImageContentContainer" border="0" cellpadding="0" cellspacing="0" align="left" width="100%">
															<tbody><tr>
																<td class="mcnImageContent" style="padding-right: 9px; padding-left: 9px; padding-top: 0; padding-bottom: 0; text-align:center;" valign="top">
																	
																	
																	<img alt="" src="https://gallery.mailchimp.com/c18139164ef33dfeff4ee36e6/images/953d3368-4b11-4257-ac51-330a12193cd2.png" style="max-width:170px; padding-bottom: 0; display: inline !important; vertical-align: bottom;" class="mcnImage" align="middle" width="170">
																	
																	
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
							<td align="center" valign="top">
								<!-- BEGIN BODY // -->
								<table border="0" cellpadding="0" cellspacing="0" width="600" id="templateBody">
									<tr>
										<td valign="top" class="bodyContainer"><table class="mcnTextBlock" border="0" cellpadding="0" cellspacing="0" width="100%">
											<tbody class="mcnTextBlockOuter">
												<tr>
													<td class="mcnTextBlockInner" valign="top">
														
														<table class="mcnTextContentContainer" border="0" cellpadding="0" cellspacing="0" align="left" width="600">
															<tbody><tr>
																
																<td class="mcnTextContent" style="padding-top:9px; padding-right: 18px; padding-bottom: 9px; padding-left: 18px;" valign="top">
																	
																	<h1>{!! Lang::get('emails.signup-h1') !!}</h1>
																	<h3>{!! Lang::get('emails.signup-welcome') !!}</h3>
																	<p>{!! Lang::get('emails.signup-message', ['year' => $data['year'], 'company' => $data['company']]) !!}</p>
																	<p>{!! Lang::get('emails.signup-url', ['url' => $data['url']]); !!}</p>
																</td>
															</tr>
														</tbody></table>
														
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
							<td align="center" valign="top">
								<!-- BEGIN COLUMNS // -->
								<table border="0" cellpadding="0" cellspacing="0" width="600" id="templateColumns">
									<tr>
										<td align="left" valign="top" class="columnsContainer" width="50%">
											<table border="0" cellpadding="0" cellspacing="0" width="100%" class="templateColumn">
												<tr>
													<td valign="top" class="leftColumnContainer"><table class="mcnCaptionBlock" border="0" cellpadding="0" cellspacing="0" width="100%">
														<tbody class="mcnCaptionBlockOuter">
															<tr>
																<td class="mcnCaptionBlockInner" style="padding:9px;" valign="top">
																	
																	<table class="mcnCaptionBottomContent" border="0" cellpadding="0" cellspacing="0" align="left" width="false">
																		<tbody><tr>
																			<td class="mcnCaptionBottomImageContent" style="padding:0 9px 9px 9px;" align="left" valign="top">
																				
																				
																				<img alt="" src="https://gallery.mailchimp.com/c18139164ef33dfeff4ee36e6/images/9b9bb5ca-e0b9-4eb9-95b7-0ac7fec4768a.png" style="max-width:300px;" class="mcnImage" width="264">
																				
																				
																			</td>
																		</tr>
																		<tr>
																			<td class="mcnTextContent" style="padding:0 9px 0 9px;" valign="top" width="264">
																				{!! Lang::get('emails.signup-image_1') !!}
																			</td>
																		</tr>
																	</tbody></table>
																</td>
															</tr>
														</tbody>
													</table></td>
												</tr>
											</table>
										</td>
										<td align="left" valign="top" class="columnsContainer" width="50%">
											<table border="0" cellpadding="0" cellspacing="0" width="100%" class="templateColumn">
												<tr>
													<td valign="top" class="rightColumnContainer"><table class="mcnCaptionBlock" border="0" cellpadding="0" cellspacing="0" width="100%">
														<tbody class="mcnCaptionBlockOuter">
															<tr>
																<td class="mcnCaptionBlockInner" style="padding:9px;" valign="top">
																	
																	<table class="mcnCaptionBottomContent" border="0" cellpadding="0" cellspacing="0" align="left" width="false">
																		<tbody><tr>
																			<td class="mcnCaptionBottomImageContent" style="padding:0 9px 9px 9px;" align="left" valign="top">
																				
																				
																				<img alt="" src="https://gallery.mailchimp.com/c18139164ef33dfeff4ee36e6/images/4a1fcd83-2d42-4f34-ab34-fcf4547eaae1.png" style="max-width:300px;" class="mcnImage" width="264">
																				
																				
																			</td>
																		</tr>
																		<tr>
																			<td class="mcnTextContent" style="padding:0 9px 0 9px;" valign="top" width="264">
																				{!! Lang::get('emails.signup-image_2') !!}
																			</td>
																		</tr>
																	</tbody></table>
																</td>
															</tr>
														</tbody>
													</table></td>
												</tr>
											</table>
										</td>
									</tr>
								</table>
								<!-- // END COLUMNS -->
							</td>
						</tr>
						<tr>
							<td align="center" valign="top">
								<!-- BEGIN FOOTER // -->
								<table border="0" cellpadding="0" cellspacing="0" width="600" id="templateFooter">
									<tr>
										<td valign="top" class="footerContainer" style="padding-bottom:9px;"><table class="mcnTextBlock" border="0" cellpadding="0" cellspacing="0" width="100%">
											<tbody class="mcnTextBlockOuter">
												<tr>
													<td class="mcnTextBlockInner" valign="top">
														
														<table class="mcnTextContentContainer" border="0" cellpadding="0" cellspacing="0" align="left" width="600">
															<tbody><tr>
																
																<td class="mcnTextContent" style="padding-top:9px; padding-right: 18px; padding-bottom: 9px; padding-left: 18px;" valign="top">
																	
																	{!! Lang::get('emails.signup-footer', ['year' => $data['year'], 'company' => $data['company']]) !!}
																</td>
															</tr>
														</tbody></table>
														
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