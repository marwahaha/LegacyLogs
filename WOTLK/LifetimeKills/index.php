<?php
require(dirname(__FILE__)."/../../init.php");

class Home extends Site{
	private $faction = 0;
	private $server = "";
	private $classe = "";
	private $page = 1;
	private $classById = array(
		1 => "warrior",
		2 => "rogue",
		3 => "priest",
		4 => "hunter",
		5 => "druid",
		6 => "mage",
		7 => "warlock",
		8 => "paladin",
		9 => "shaman",
		10 => "deathknight",
	);
	private $gender = array(
		1 => "male",
		2 => "male",
		3 => "female",
	);
	private $race = array(
		1 => "human",
		2 => "dwarf",
		3 => "nightelf",
		4 => "gnome",
		5 => "orc",
		6 => "undead",
		7 => "troll",
		8 => "tauren",
		9 => "draenei",
		10 => "bloodelf"
	);
	
	private function getSeenString($time){
		if ($time==0)
			return "-";
		$days = floor((time()-$time)/86400);
		if ($days==0)
			return "today";
		if ($days==1)
			return "1 day ago";
		if ($days>30 && $days<60)
			return "1 month ago";
		if ($days>=60)
			return floor($days/30)." months ago";
		return $days." days ago";
	}
	
	private function getConditions(){
		$con = " WHERE ";
		if (isset($this->server) && $this->server != "")
			$con .= "b.serverid IN (".$this->server.")";
		if (isset($this->classe) && $this->classe != "")
			$con .= ($r = ($con != " WHERE ") ? " AND " : "")."b.classid IN (".$this->classe.")";
		if ($this->faction != 0)
			$con .= ($r = ($con != " WHERE ") ? " AND " : "")."b.faction = ".$this->faction;
		if ($con != " WHERE ")
			return $con;
		return "";
	}

	public function content(){
		$content = '
		<div class="container cont" id="container">
			<section class="centredNormal formular">
				<select id="srealm" multiple="multiple">
			';
			$serverList = explode(",", $this->server);
			foreach($this->db->query('SELECT * FROM servernames WHERE expansion=2') as $row){
				$content .= '
						<option value="'.$row->id.'"'.($r = (in_array($row->id, $serverList) || !$this->server) ? " selected" : "").'>'.$row->name.'</option>
				';
			}	
			$content .= '
				</select>
				<select id="sfaction" onchange="window.location.replace(\'?server='.$this->server.'&faction=\'+this.value+\'&mode='.$this->mode.'&type='.$this->type.'&id='.$this->id.'&class='.$this->classe.'&page='.$this->page.'\');">
					<option value="0"'.($r = ($this->faction==0) ? " selected" : "").'>Any faction</option>
					<option value="-1"'.($r = ($this->faction==-1) ? " selected" : "").'>Horde</option>
					<option value="1"'.($r = ($this->faction==1) ? " selected" : "").'>Alliance</option>
				</select>
				<select id="sclass" multiple="multiple">
					<option value="1"'.($r = (strpos($this->classe, "1") !== FALSE or !$this->classe) ? " selected" : "").' class="color-warrior">Warrior</option>
					<option value="2"'.($r = (strpos($this->classe, "2") !== FALSE or !$this->classe) ? " selected" : "").' class="color-rogue">Rogue</option>
					<option value="3"'.($r = (strpos($this->classe, "3") !== FALSE or !$this->classe) ? " selected" : "").' class="color-priest">Priest</option>
					<option value="4"'.($r = (strpos($this->classe, "4") !== FALSE or !$this->classe) ? " selected" : "").' class="color-hunter">Hunter</option>
					<option value="5"'.($r = (strpos($this->classe, "5") !== FALSE or !$this->classe) ? " selected" : "").' class="color-druid">Druid</option>
					<option value="6"'.($r = (strpos($this->classe, "6") !== FALSE or !$this->classe) ? " selected" : "").' class="color-mage">Mage</option>
					<option value="7"'.($r = (strpos($this->classe, "7") !== FALSE or !$this->classe) ? " selected" : "").' class="color-warlock">Warlock</option>
					<option value="8"'.($r = (strpos($this->classe, "8") !== FALSE or !$this->classe) ? " selected" : "").' class="color-paladin">Paladin</option>
					<option value="9"'.($r = (strpos($this->classe, "9") !== FALSE or !$this->classe) ? " selected" : "").' class="color-shaman">Shaman</option>
					<option value="10"'.($r = (strpos($this->classe, "10") !== FALSE or !$this->classe) ? " selected" : "").' class="color-deathknight">Death Knight</option>
				</select>
				<a href="{path}WOTLK/LifetimeKills/?server='.$this->server.'&faction='.$this->faction.'&class='.$this->classe.'&page='.($this->page+1).'"><button class="icon-button icon-arrowright" title="Next"></button></a>
				<a href="{path}WOTLK/LifetimeKills/?server='.$this->server.'&faction='.$this->faction.'&class='.$this->classe.'&page='.($r = (($this->page-1)>0) ? ($this->page-1) : 1).'"><button class="icon-button icon-arrowleft" title="Previous"></button></a>
			</section>
			<section class="table">
				<div class="right">
					<table cellspacing="0">
						<tr>
							<th class="rank">#Nr</th>
							<th class="timg char">Character</th>
							<th class="timg">Guild</th>
							<th class="fstring">Server</th>
							<th class="fstring">Total HKs</th>
							<th class="fstring">Seen</th>
						</tr>
		';
		$num = (($this->page-1)*15)+1;
		foreach($this->db->query('SELECT b.name, c.name as gname, d.name as sname, a.lhk, e.seen, b.faction, b.classid, e.gender, e.race FROM `armory-honor-wotlk` a LEFT JOIN `chars` b ON a.charid = b.id LEFT JOIN guilds c ON b.guildid = c.id LEFT JOIN servernames d ON b.serverid = d.id LEFT JOIN `armory` e ON a.charid = e.charid'.$this->getConditions().' ORDER BY a.lhk DESC LIMIT '.(($this->page-1)*15).', 15') as $row){
			$fac = ($row->faction==1) ? "alliance" : "horde";
			$content .= '
						<tr>
							<td class="rank">'.$num.'</td>
							<td class="timg char"><img src="{path}Database/racegender/Ui-charactercreate-races_'.$this->race[$row->race].'-'.$this->gender[$row->gender].'-small.png" /><img src="img/c'.$row->classid.'.png"><a href="{path}WOTLK/Character/'.$row->sname.'/'.$row->name.'/0" class="color-'.$this->classById[$row->classid].'">'.$row->name.'</a></td>
							<td class="timg"><img src="img/'.$fac.'.png"><a class="'.$fac.'" href="{path}WOTLK/Guild/'.$row->sname.'/'.$row->gname.'/0">'.$row->gname.'</a></td>
							<td class="fstring">'.$row->sname.'</td>
							<td class="fstring">'.$row->lhk.'</td>
							<td class="fstring">'.$this->getSeenString($row->seen).'</td>
						</tr>
			';
			$num++;
		}
		$content .= '
					</table>
				</div>
			</section>
		</div>
		<script>
		$(\'#sclass\').multipleSelect({
			onClose: function() {
				window.location.replace(\'?server='.$this->server.'&faction='.$this->faction.'&class=\'+$(\'#sclass\').multipleSelect(\'getSelects\')+\'&page='.$this->page.'\');
			},
			allSelected: \'Any class\'
		});
		$(\'#srealm\').multipleSelect({
			onClose: function() {
				window.location.replace(\'?server=\'+$(\'#srealm\').multipleSelect(\'getSelects\')+\'&faction='.$this->faction.'&class='.$this->classe.'&page='.$this->page.'\');
			},
			allSelected: \'Any realm\'
		});
		</script>
		';
		pq('#container')->replaceWith($content);
	}
	
	public function __construct($db, $dir, $server, $faction, $classe, $page){
		$this->server = $this->antiSQLInjection($server);
		$this->faction = intval($this->antiSQLInjection($faction));
		$this->classe = $this->antiSQLInjection($classe);
		$this->page = intval($this->antiSQLInjection($page));
		if ($this->page==0)
			$this->page=1;
		$this->addCssLink("{path}External/multipleselect/multiple-select.css");
		$this->addJsLink("{path}External/TwinheadTooltip/jquery.min.js", true);
		$this->addJsLink("{path}External/multipleselect/multiple-select.js", true);
		parent::__construct($db, $dir);
	}
}

new Home($db, __DIR__, $_GET["server"], $_GET["faction"], $_GET["class"], $_GET["page"]);

?>