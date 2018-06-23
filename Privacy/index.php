<?php
require(dirname(__FILE__)."/../init.php");

class Home extends Site{
	
	public function content(){
		$content = '
		<div class="container" id="container">
			<section class="table">
				<div class="right">
					<h1>General</h1>
					<p>
						Your personal data (e.g. title, name, house address, e-mail address, phone number, bank details, credit card number) are processed by us only in accordance with the provisions of German data privacy laws. The following provisions describe the type, scope and purpose of collecting, processing and utilizing personal data. This data privacy policy applies only to our web pages. If links on our pages route you to other pages, please inquire there about how your data are handled in such cases.
					</p>
					<h1>Inventory data</h1>
					<p>
						(1) Your personal data, insofar as these are necessary for this contractual relationship (inventory data) in terms of its establishment, organization of content and modifications, are used exclusively for fulfilling the contract. For goods to be delivered, for instance, your name and address must be relayed to the supplier of the goods.<br />
						(2) Without your explicit consent or a legal basis, your personal data are not passed on to third parties outside the scope of fulfilling this contract. After completion of the contract, your data are blocked against further use. After expiry of deadlines as per tax-related and commercial regulations, these data are deleted unless you have expressly consented to their further use.
					</p>
					<h1>Web analysis with Google Analytics</h1>
					<p>
						This website uses Google Analytics, a web analysis service of Google Inc. (Google). Google Analytics uses cookies, i.e. text files stored on your computer to enable analysis of website usage by you. Information generated by the cookie about your use of this website is usually transmitted to a Google server in the United States and stored there. In case of activated IP anonymization on this website, however, your IP address is previously truncated by Google within member states of the European Union or in other states which are party to the agreement on the European Economic Area. Only in exceptional cases is a full IP address transmitted to a Google server in the United States and truncated there. On behalf this website\'s owner, Google will use this information to evaluate your use of the website, compile reports about website activities, and provide the website\'s operator with further services related to website and Internet usage. The IP address sent from your browser as part of Google Analytics is not merged with other data by Google. You can prevent storage of cookies by appropriately setting your browser software; in this case, however, please note that you might not be able to fully use all functions offered by this website. In addition, you can prevent data generated by the cookie and relating to your use of the website (including your IP address) from being collected and processed by Google, by downloading and installing a browser plug-in from the following link: <a href="http://tools.google.com/dlpage/gaoptout?hl=en">http://tools.google.com/dlpage/gaoptout?hl=en</a>
						<br /><br />
						This website uses Google Analytics with the extension "anonymizeIP()", IP addresses being truncated before further processing in order to rule out direct associations to persons.
					</p>
					<h1>Log Files</h1>
					<p>
						As with most other websites, we collect and use the data contained in log files. The information in the log files include your IP (internet protocol) address, your ISP (internet service provider, such as AOL or Shaw Cable), the browser you used to visit our site (such as Internet Explorer or Firefox), the time you visited our site and which pages you visited throughout our site.
					</p>
					<h1>Cookies and Web Beacons</h1>
					<p>
						We do use cookies to store information, such as your personal preferences when you visit our site. This could include only showing you a popup once in your visit, or the ability to login to some of our features, such as forums.<br /><br />
						We also use third party advertisements on http://legacy-logs.com to support our site. Some of these advertisers may use technology such as cookies and web beacons when they advertise on our site, which will also send these advertisers (such as Google through the Google AdSense program) information including your IP address, your ISP , the browser you used to visit our site, and in some cases, whether you have Flash installed. This is generally used for geotargeting purposes (showing New York real estate ads to someone in New York, for example) or showing certain ads based on specific sites visited (such as showing cooking ads to someone who frequents cooking sites).
					</p>
					<h1>DoubleClick DART cookies</h1>
					<p>
						We also may use DART cookies for ad serving through Google’s DoubleClick, which places a cookie on your computer when you are browsing the web and visit a site using DoubleClick advertising (including some Google AdSense advertisements). This cookie is used to serve ads specific to you and your interests (”interest based targeting”).<br /><br />
						The ads served will be targeted based on your previous browsing history (For example, if you have been viewing sites about visiting Las Vegas, you may see Las Vegas hotel advertisements when viewing a non-related site, such as on a site about hockey). DART uses “non personally identifiable information”. It does NOT track personal information about you, such as your name, email address, physical address, telephone number, social security numbers, bank account numbers or credit card numbers.<br /><br />
						You can opt-out of this ad serving on all sites using this advertising by visiting <a href="http://www.doubleclick.com/privacy/dart_adserving.aspx">http://www.doubleclick.com/privacy/dart_adserving.aspx</a><br /><br />
						You can choose to disable or selectively turn off our cookies or third-party cookies in your browser settings, or by managing preferences in programs such as Norton Internet Security. However, this can affect how you are able to interact with our site as well as other websites. This could include the inability to login to services or programs, such as logging into forums or accounts.<br /><br />
						Deleting cookies does not mean you are permanently opted out of any advertising program. Unless you have settings that disallow cookies, the next time you visit a site running the advertisements, a new cookie will be added.
					</p>
					<h1>Disclosure</h1>
					<p>
						According to the Federal Data Protection Act, you have a right to free-of-charge information about your stored data, and possibly entitlement to correction, blocking or deletion of such data. Inquiries can be directed to the following e-mail addresses: (shino@legacy-logs.com)
					</p>
				</div>
			</section>
		</div>
		';
		pq('#container')->replaceWith($content);
	}
	
	public function __construct($db, $dir){
		parent::__construct($db, $dir);
	}
}

new Home($db, __DIR__);

?>