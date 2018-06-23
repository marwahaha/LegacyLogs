<?php
	header('Content-Type: application/json');
	header("Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0");
	header("Expires: Thu, 19 Nov 1981 08:52:00 GMT");
	header('Access-Control-Allow-Origin: *');  
	$notFound = "Not found :(";
	
	function antiSQLInjection($str){
		return str_replace(array(';', '"', '\'', '<', '>', '=', '@', '*', 'DELETE FROM', '`', 'RESET', 'ALL'), "", $str);
	}
	
	if (isset($_GET["type"])){
		if ($_GET["type"]=="item"){
			$itemid = intval(antiSQLInjection($_GET["id"]));
			if ($itemid>0){
				require "../Database/Mysql.php";
				$keyData = new KeyData();
				$db = new Mysql($keyData->host, $keyData->user, $keyData->pass, $keyData->db, 3306, false, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
				$q = $db->query('SELECT * FROM `item_template` a LEFT JOIN `v-itemsets` b ON a.itemset = b.id WHERE entry = "'.$itemid.'";')->fetch();
				
				$bondingTypes = array(
					1 => "Binds when picked up",
					2 => "Binds when equipped",
					3 => "Binds when used"
				);
				$flagTypes = array(
					16 => "Totem",
					524288 => "Unique equipped",
					4194304 => "Throwable",
				);
				$sheathTypes = array( // NOT USED
					0 => "",
					1 => "Two Handed Weapon",
					2 => "Staff",
					3 => "One Handed",
					4 => "Off hand",
					5 => "Enchanter’s Rod",
					6 => "Off hand",
				);
				$inventoryTypes = array(
					0 => "Non equipable",
					1 => "Head",
					2 => "Neck",
					3 => "Shoulder",
					4 => "Shirt",
					5 => "Chest",
					6 => "Waist",
					7 => "Legs",
					8 => "Feet",
					9 => "Wrists",
					10 => "Hands",
					11 => "Finger",
					12 => "Trinket",
					13 => "Weapon",
					14 => "Shield",
					15 => "Ranged",
					16 => "Back",
					17 => "Two-Hand",
					18 => "Bag",
					19 => "Tabard",
					20 => "Robe",
					21 => "Main hand",
					22 => "Off hand",
					23 => "Off hand",
					24 => "Ammo",
					25 => "Thrown",
					26 => "Ranged",
					27 => "Quiver",
					28 => "Relic",
				);
				$subClass = array(
					2 => array(
						0 => "Axe",
						1 => "Axe",
						2 => "Bow",
						3 => "Gun",
						4 => "Mace",
						5 => "Mace",
						6 => "Polearm",
						7 => "Sword",
						8 => "Sword",
						9 => "Obsolete",
						10 => "Staff",
						11 => "Exotic",
						12 => "Exotic",
						13 => "Fist Weapon",
						14 => "Miscellaneous",
						15 => "Dagger",
						16 => "Thrown",
						17 => "Spear",
						18 => "Crossbow",
						19 => "Wand",
						20 => "Fishing Pole",
					),
					4 => array(
						0 => "Miscellaneous",
						1 => "Cloth",
						2 => "Leather",
						3 => "Mail",
						4 => "Plate",
						5 => "Buckler(OBSOLETE)",
						6 => "Shield",
						7 => "Libram",
						8 => "Idol",
						9 => "Totem",
					),
					7 => array(
						0 => "Trade Goods",
						1 => "Parts",
						2 => "Explosives",
						3 => "Devices",
						4 => "Jewelcrafting",
						5 => "Cloth",
						6 => "Leather",
						7 => "Metal & Stone",
						8 => "Meat",
						9 => "Herb",
						10 => "Elemental",
						11 => "Other",
						12 => "Enchanting",
					),
				);
				$dmgTypes = array(
					0 => "",
					1 => "Holy",
					2 => "Fire",
					3 => "Nature",
					4 => "Frost",
					5 => "Shadow",
					6 => "Arcane",
				);
				
				$SCType = (isset($subClass[$q->class][$q->subclass])) ? $subClass[$q->class][$q->subclass] : "";
				
				$data = '<table>';
				$data .= '<tr><td><b class="q'.$q->quality.'">'.$q->name.'</b><br />';
				if (isset($bondingTypes[$q->bonding]))
					$data .= $bondingTypes[$q->bonding].'<br />';
				if (isset($flagTypes[$q->Flags]))
					$data .= $flagTypes[$q->Flags];
				$data .= '<table width="100%"><tr><td>'.($r = ($q->inventorytype==13 or $q->inventorytype==14) ? $sheathTypes[$q->sheath] : $inventoryTypes[$q->inventorytype]).'</td><th>'.$SCType.'</th></tr></table>';
				
				if ($q->class==2){
					$data .= '<table width="100%"><tr><td>'.$q->dmg_min1.' - '.$q->dmg_max1.' '.$dmgTypes[$q->dmg_type1].' Damage</td><th>Speed '.round($q->delay/1000, 2).'</th></tr></table>';
					if ($q->dmg_min2>0)
						$data .= '+'.$q->dmg_min2.' - '.$q->dmg_max2.' '.$dmgTypes[$q->dmg_type2].' Damage <br />';
					if ($q->dmg_min3>0)
						$data .= '+'.$q->dmg_min3.' - '.$q->dmg_max3.' '.$dmgTypes[$q->dmg_type3].' Damage <br />';
					$data .= '('.round(((($q->dmg_min1+$q->dmg_max1)/2)+(($q->dmg_min2+$q->dmg_max2)/2)+(($q->dmg_min3+$q->dmg_max3)/2))/round($q->delay/1000, 2), 1).' damage per second)<br />';
				}
				
				// Stats
				if ($q->armor>0)
					$data .= $q->armor.' Armor <br />';
				if ($q->strength>0)
					$data .= '+'.$q->strength.' Strength <br />';
				if ($q->agility>0)
					$data .= '+'.$q->agility.' Agility <br />';
				if ($q->stamina>0)
					$data .= '+'.$q->stamina.' Stamina <br />';
				if ($q->intellect>0)
					$data .= '+'.$q->intellect.' Intellect <br />';
				if ($q->spirit>0)
					$data .= '+'.$q->spirit.' Spirit <br />';
				if ($q->holy_res>0)
					$data .= '+'.$q->holy_res.' Holy Resistance <br />';
				if ($q->fire_res>0)
					$data .= '+'.$q->fire_res.' Fire Resistance <br />';
				if ($q->frost_res>0)
					$data .= '+'.$q->frost_res.' Frost Resistance <br />';
				if ($q->nature_res>0)
					$data .= '+'.$q->nature_res.' Nature Resistance <br />';
				if ($q->shadow_res>0)
					$data .= '+'.$q->shadow_res.' Shadow Resistance <br />';
				if ($q->arcane_res>0)
					$data .= '+'.$q->arcane_res.' Arcane Resistance <br />';
				
				// Misc stats
				if ($q->MaxDurability>0)
					$data .= 'Durability '.$q->MaxDurability.' / '.$q->MaxDurability.'<br />';
				if ($q->ItemLevel>0)
					$data .= 'Item level '.$q->ItemLevel.'<br />';
				if ($q->RequiredLevel>0)
					$data .= 'Requires Level '.$q->RequiredLevel.'<br />';
				$data .= '</td></tr></table>';
				
				// Effects
				$data .= '<table><tr><td>';
				if ($q->hit>0)
					$data .= '<span class="q2">On Equip: Improves your chance to hit by '.$q->hit.'%.</span> <br />';
				if ($q->crit>0)
					$data .= '<span class="q2">On Equip: Improves your chance to get a critical strike by '.$q->crit.'%.</span> <br />';
				if ($q->apower>0)
					$data .= '<span class="q2">On Equip: +'.$q->apower.' Attack Power.</span> <br />';
				if ($q->dodge>0)
					$data .= '<span class="q2">On Equip: Increases your chance to dodge an attack by '.$q->dodge.'%.</span> <br />';
				if ($q->parry>0)
					$data .= '<span class="q2">On Equip: Increases your chance to parry an attack by '.$q->parry.'%.</span> <br />';
				if ($q->block>0)
					$data .= '<span class="q2">On Equip: Increases the block value of your shield by '.$q->block.'.</span> <br />';
				if ($q->blockchance>0)
					$data .= '<span class="q2">On Equip: Increases your chance to block attacks with a shield by '.$q->blockchance.'%.</span> <br />';
				if ($q->defense>0)
					$data .= '<span class="q2">On Equip: Increased Defense +'.$q->defense.'.</span> <br />';
				if ($q->spellpower>0 && $q->spellpower==$q->healpower){
					$data .= '<span class="q2">On Equip: Increases damage and healing done by magical spells and effects by up to '.$q->spellpower.'.</span> <br />';
				}else{
					if ($q->spellpower>0)
						$data .= '<span class="q2">On Equip: Increases damage done by magical spells and effects by up to '.$q->spellpower.'.</span> <br />';
					if ($q->healpower>0)
						$data .= '<span class="q2">On Equip: Increases healing done by magical spells and effects by up to '.$q->healpower.'.</span> <br />';
				}
				if ($q->spellholy)
					$data .= '<span class="q2">On Equip: Increases damage done by Holy spells and effects by up to '.$q->spellholy.'.</span> <br />';
				if ($q->spellfire)
					$data .= '<span class="q2">On Equip: Increases damage done by Fire spells and effects by up to '.$q->spellfire.'.</span> <br />';
				if ($q->spellfrost)
					$data .= '<span class="q2">On Equip: Increases damage done by Frost spells and effects by up to '.$q->spellfrost.'.</span> <br />';
				if ($q->spellnature)
					$data .= '<span class="q2">On Equip: Increases damage done by Nature spells and effects by up to '.$q->spellnature.'.</span> <br />';
				if ($q->spellshadow)
					$data .= '<span class="q2">On Equip: Increases damage done by Shadow spells and effects by up to '.$q->spellshadow.'.</span> <br />';
				if ($q->spellarcane)
					$data .= '<span class="q2">On Equip: Increases damage done by Arcane spells and effects by up to '.$q->spellarcane.'.</span> <br />';
				if ($q->manaregen)
					$data .= '<span class="q2">On Equip: Restores '.$q->manaregen.' mana per 5 sec.</span> <br />';
				// health regen missing
				// sword/mace/axe/dagger skill missing
				if ($q->spellhit>0)
					$data .= '<span class="q2">On Equip: Improves your chance to hit with spells by '.$q->spellhit.'%.</span> <br />';
				if ($q->spellcrit>0)
					$data .= '<span class="q2">On Equip: Improves your chance to get a critical strike with spells by '.$q->spellcrit.'%.</span> <br />';
				
				// Extra effects
				$extraEffects = explode(".,", $q->extraTooltip);
				foreach($extraEffects as $var){
					if ($var!="" && $var!="0" && $var)
						$data .= '<span class="q2">'.$var.'</span> <br />';
				}
				$data .= '</td></tr></table>';
				
				// Set data
				if ($q->itemset>0){
					$setnames = explode(",", $q->setnames);
					$setids = explode(",",$q->setids);
					$seteffectname = explode(".,", $q->seteffectnames);
					
					$setMax = 0;
					$setNums = array();
					foreach($seteffectname as $key => $var){
						$num = intval(substr($var, 1, 1));
						if ($num>$setMax)
							$setMax = $num;
						$setNums[$key] = $num;
					}
					
					$data .= '<br />';
					$data .= '<table><tr><td>';
					$data .= '<span class="q">'.$q->setname.'</span> <br />';
					foreach($setnames as $key => $var){
						$data .= '<span class="q0" id="item'.$setids[$key].'">'.$var.'</span><br />';
					}
					foreach($seteffectname as $key => $var){
						$data .= '<br /><span class="q0';
						for ($i=$setNums[$key]; $i<=$setMax; $i++){
							$data .= ' set'.$q->itemset.$i;
						}
						$data .= '">'.$var.'</span>';
					}
					$data .= '</td></tr></table>';
				}else{
					if (substr($data, -24)=="<br /></td></tr></table>")
						$data = substr($data, 0, -24).'</td></tr></table>';
				}
				
				$itemTooltip = array(
					"type" => "item",
					"entry" => "".$itemid,
					"datadisc" => "vanilla",
					"data" => array(
						"name" => $q->name,
						"quality" => $q->quality,
						"icon" => $q->icon,
						"tooltip" => $data,
					)
				);
				print json_encode($itemTooltip);
			}else{
				print $notFound;
			}
		}elseif($_GET["type"]=="spell"){
			$spellid = intval(antiSQLInjection($_GET["id"]));
			if ($spellid>0){
				require "../Database/Mysql.php";
				$keyData = new KeyData();
				$db = new Mysql($keyData->host, $keyData->user, $keyData->pass, $keyData->db, 3306, false, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
				$q = $db->query('SELECT name, icon, tooltip FROM spells WHERE realspellid = "'.$spellid.'";')->fetch();
				$spellTooltip = array(
					"type" => "spell",
					"entry" => "".$spellid,
					"datadisc" => "vanilla",
					"data" => array(
						"name" => $q->name,
						"icon" => $q->icon,
						"tooltip" => $q->tooltip,
					)
				);
				print json_encode($spellTooltip);
			}else{
				print $notFound;
			}
		}else{
			print $notFound;
		}
	}else{
		print $notFound;
	}
?>