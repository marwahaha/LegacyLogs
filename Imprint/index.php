<?php
require(dirname(__FILE__)."/../init.php");

class Home extends Site{
	
	public function content(){
		$content = '
		<div class="container" id="container">
			<section class="table">
				<div class="right">
					<h1>Legal Disclosure</h1>
					<p>
						Information in accordance with section 5 TMG <br />
						Tom Dymel <br />
						Kiebitzhagen 5 <br />
						21217 Seevetal
					</p>
					<h1>Contact</h1>
					<p>
						E-Mail: shino@legacy-logs.com
					</p>
					<h1>Disclaimer</h1>
					<p>
						<h2>Accountability for content </h2>
						<p>The contents of our pages have been created with the utmost care. However, we cannot guarantee the contents\' accuracy, completeness or topicality. According to statutory provisions, we are furthermore responsible for our own content on these web pages. In this context, please note that we are accordingly not obliged to monitor merely the transmitted or saved information of third parties, or investigate circumstances pointing to illegal activity. Our obligations to remove or block the use of information under generally applicable laws remain unaffected by this as per §§ 8 to 10 of the Telemedia Act (TMG).</p>
						<h2>Accountability for links </h2>
						<p>Responsibility for the content of external links (to web pages of third parties) lies solely with the operators of the linked pages. No violations were evident to us at the time of linking. Should any legal infringement become known to us, we will remove the respective link immediately.</p>
						<h2>Copyright</h2>
						<p>Our web pages and their contents are subject to German copyright law. Unless expressly permitted by law (§ 44a et seq. of the copyright law), every form of utilizing, reproducing or processing works subject to copyright protection on our web pages requires the prior consent of the respective owner of the rights. Individual reproductions of a work are allowed only for private use, so must not serve either directly or indirectly for earnings. Unauthorized utilization of copyrighted works is punishable (§ 106 of the copyright law).<br /><br />
						This website is in no way related to World of Warcraft, Blizzard Entertainment Inc or any of its associates and partners. World of Warcraft and Blizzard Entertainment ® are all trademarks or registered trademarks of Blizzard Entertainment in the United States and/or other countries.<br /><br />
						Graphics related to World of Warcraft may contain content of Blizzard Entertainment Inc or any of its associates and partners.
						</p>
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