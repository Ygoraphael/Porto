<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Email_template {

    protected $CI;

    public function __construct() {
        $this->CI = & get_instance();
        $this->CI->load->database();
    }

    public function design($body) {
        $html = "
			<html xmlns = 'http://www.w3.org/1999/xhtml'>
			<head>
				<meta http-equiv = 'Content-Type' content = 'text/html; charset=utf-8' />
				<title>INFO NCIndustry</title>
				<style type = 'text/css'>
					body {margin: 0;
					padding: 0;
					min-width: 100%!important;
					}
					img {height: auto;
					}
					.content {width: 100%;
					max-width: 600px;
					}
					.header {padding: 40px 30px 20px 30px;
					}
					.innerpadding {padding: 30px 30px 30px 30px;
					}
					.borderbottom {border-bottom: 1px solid #f2eeed;}
					.subhead {font-size: 15px;
					color: #ffffff; font-family: sans-serif; letter-spacing: 10px;}
					.h1, .h2, .bodycopy {color: #153643; font-family: sans-serif;}
					.h1 {font-size: 33px;
					line-height: 38px;
					font-weight: bold;
					}
					.h2 {padding: 0 0 15px 0;
					font-size: 24px;
					line-height: 28px;
					font-weight: bold;
					}
					.bodycopy {font-size: 16px;
					line-height: 22px;
					}
					.button {text-align: center;
					font-size: 18px;
					font-family: sans-serif;
					font-weight: bold;
					padding: 0 30px 0 30px;
					}
					.button a {color: #ffffff; text-decoration: none;}
					.footer {padding: 20px 30px 15px 30px;
					}
					.footercopy {font-family: sans-serif;
					font-size: 14px;
					color: #ffffff;}
					.footercopy a {color: #ffffff; text-decoration: underline;}
					@media only screen and (max-width: 550px), screen and (max-device-width: 550px) {
					body[yahoo] .hide {display: none!important;
					}
					body[yahoo] .buttonwrapper {background-color: transparent!important;
					}
					body[yahoo] .button {padding: 0px!important;
					}
					body[yahoo] .button a {background-color: #e05443; padding: 15px 15px 13px!important;}
					body[yahoo] .unsubscribe {display: block;
					margin-top: 20px;
					padding: 10px 50px;
					background: #2f3942; border-radius: 5px; text-decoration: none!important; font-weight: bold;}
					}
					/* @media only screen and (min-device-width: 601px) {
					  .content {width: 600px !important;}
					  .col425 {width: 425px!important;}
					  .col380 {width: 380px!important;}
					  } */
				</style>
			</head>

			<body yahoo bgcolor = '#f9f9f9'>
				<table width = '100%' bgcolor = '#f9f9f9' border = '0' cellpadding = '0' cellspacing = '0'>
					<tr>
						<td>
							<table width = '600' align = 'center' cellpadding = '0' cellspacing = '0' border = '0'>
								<tr>
									<td>
										<table bgcolor = '#ffffff' class = 'content' align = 'center' cellpadding = '0' cellspacing = '0' border = '0'>
											<tr>
												<td bgcolor = '#1b2a33' class = 'header'>
													<table width = '425' align = 'left' border = '0' cellpadding = '0' cellspacing = '0'>
														<tr>
															<td height = '70' style = 'padding: 0 20px 20px 0;'>
																<img class = 'fix' src = 'https://www.soft4booking.com/marketplace/img/cropped-europeanworld_logo_cabecalho_21.png' width = '425' border = '0' alt = '' />
															</td>
														</tr>
													</table>
												</td>
											</tr>
											<tr>
												<td class = 'innerpadding borderbottom bodycopy'>
													$body
												</td>
											</tr>
											<tr>
												<td class = 'footer' bgcolor = '#44525f'>
													<table width = '100%' border = '0' cellspacing = '0' cellpadding = '0'>
														<tr>
															<td align = 'center' class = 'footercopy'>
																&reg;
																SOFT4BOOKING<br/>
															</td>
														</tr>
														<tr>
															<td align = 'center' style = 'padding: 20px 0 0 0;'>
																<table border = '0' cellspacing = '0' cellpadding = '0'>
																	<tr>
																		<td width = '37' style = 'text-align: center; padding: 0 10px 0 10px;'>
																			<a href = 'http://www.facebook.com/'>
																				<img src = 'http://tutsplus.github.io/a-simple-responsive-html-email/HTML/images/facebook.png' width = '37' height = '37' alt = 'Facebook' border = '0' />
																			</a>
																		</td>
																		<td width = '37' style = 'text-align: center; padding: 0 10px 0 10px;'>
																			<a href = 'http://www.twitter.com/'>
																				<img src = 'http://tutsplus.github.io/a-simple-responsive-html-email/HTML/images/twitter.png' width = '37' height = '37' alt = 'Twitter' border = '0' />
																			</a>
																		</td>
																	</tr>
																</table>
															</td>
														</tr>
													</table>
												</td>
											</tr>
										</table>
									</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
			</body>
		</html>
		";
        return $html;
    }

}

?>