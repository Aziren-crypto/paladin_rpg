<?
/*ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);*/

?>
<style>
.box {
  position: relative;
  width: 60px;
  height: 60px;
  border: 1px solid red;
}
.raz{
  border: 1px solid red;
  position: absolute;
}
.raz.rt {
  right: 0;
}
.raz.rd {
  right: 0;
  bottom: 0;
}
.raz.lt {
  left: 0;
}
.raz.ld {
  left: 0;
  bottom: 0;
}

.td{
	display: inline-block;
	height: 30px;
	width: 30px;
	border: 1px solid gray;
	vertical-align: middle;
}

.td span{
	display: inline-block;
}

.colordiv img{
	height: 100%;
	width: 100%;
}
</style>
<div class="box">
	<div class="raz rt">1</div>
	<div class="raz rd">2</div>
	<div class="raz lt">3</div>
	<div class="raz ld">4</div>
</div>
<style>
.damp div{
	display: inline-block;
}

table td .colordiv{
	height: 100%;
	width: 100%;
	
}
</style>
<?
$arMonTypes = ['war']; //, 'lair', 'tem'

$arDirs = [
	'u' => ['axis' => 'y', 'num' => -1],
	'd' => ['axis' => 'y', 'num' => 1],
	'l' => ['axis' => 'x', 'num' => -1],
	'r' => ['axis' => 'x', 'num' => 1],
];

$arClans = [
	'71c79e', 'f79494', '94b5f7', 'ede48e'
];


function searchForProp($propName, $findValue, $array) {	// искать в 2-мерном массиве по значению элемента 2 уровня
	foreach ($array as $key => $val) {
		if (isset($val[$propName]) && $val[$propName] === $findValue) {
			return $key;
		}
	}
	return null;
}

function searchForPropArr($propName, $findValue, $array) {
	$arrRes = [];
	foreach ($array as $key => $val) {
		if (isset($val[$propName]) && $val[$propName] === $findValue) {
			$arrRes[] = $key;
		}
	}
	return $arrRes;
}

function coord($m=2, $faces=5){
	$result = '';
	for($i = $m; $i > 0; $i--){
		$result .= rand (0, $faces);
	}
	return $result;
}

function genMon($y = false, $x = false, $name = false, $clan = false){
	global $arMonTypes;
	global $web;
	global $arObj;
	global $objWeb;
	global $x_max;
	global $y_max;
	global $clan_color;

	if($y === false){
		$y = coord(1, $y_max);
	}
	if($x === false){
		$x = coord(1, $x_max);
	}
	
	$arCoords = [$y, $x];
	/*echo '<br>y: '.$y;
	echo '<br>x: '.$x;
	echo '<br>clan: '.$clan;
	echo '<br>$name: '.$name;
	echo '<br>';*/
	if($arCoords[0] >= 0 && $arCoords[0] <= $y_max && $arCoords[1] >= 0 && $arCoords[1] <= $x_max){
		if($web[$arCoords[0]][$arCoords[1]] == ''){
			if(!$name){
				$monTypeNum = array_rand($arMonTypes);
				$name = $arMonTypes[$monTypeNum];
			}

			if(!$clan){
				$clan = $clan_color;
			}else{
				$clan_color = $clan;
			}
			
			$objId = count($arObj);
			$arr = ['u', 'd', 'l', 'r'];
			$dir = $arr[array_rand($arr)];
			$objNew = [
				'rest' => 1,
				'wounded' => 0,
				'id' => $objId,
				'name' => $name,
				'type' => 'mon',
				'clan' => $clan,
				'status' => 'ок',
				'direction' => $dir,
				'lastTurn' => 'stay',
				//'img' =>  '<div style="background-color: #'.$clan_color.';" class="colordiv">🐜</div>',//&nbsp;'.$arMonTypes[$monTypeNum].'
				'y' => $arCoords[0],
				'x' => $arCoords[1],
				'Am' => 1,
				'As' => 1,
				'Dm' => 1,
				'Ds' => 1,
				'Hlt' => 1,
				'HltMax' => 1,
				'Dmg' => 1
			];
			
			if($name == 'lair'){
				$objNew['img'] = '<div style="background-color: #'.$clan_color.';" class="colordiv"><img src="sprite/free-icon-necromancer-2877465.png"></div>';
			}elseif($name == 'war'){
				$objNew['img'] = '<div style="background-color: #'.$clan_color.';" class="colordiv"><img src="sprite/skull_png.png"></div>';
			}
			$web[$arCoords[0]][$arCoords[1]] = $objNew['img'];
			$arObj[$objId] = $objNew;
			$objWeb[$arCoords[0]][$arCoords[1]] = $objId;
		}
	}else{
		//echo '<br>за пределами';
		//echo '<br>';
	}
}

function genBon(){
	$arBon = ['Am', 'As', 'Dm', 'Ds'];
	global $web;
	global $objWeb;
	global $arObj;
	global $x_max;
	global $y_max;
	$arCoords = [coord(1, $y_max), coord(1, $x_max)];
	$value = rand(1, 5);
	$bonTypeNum = array_rand($arBon);
	if($web[$arCoords[0]][$arCoords[1]] == ''){
		$BonName = $arBon[$bonTypeNum];
		$objId = count($arObj);
		$objNew = [
			'id' => $objId,
			'name' => $BonName,
			'type' => 'bonus',
			'status' => 'ок',
			'character' => $BonName,
			'value' => $value,
			'img' => '<div style="background-color: #d4ce2c;" class="colordiv">'.$arBon[$bonTypeNum].$value.'</div>',
			'y' => $arCoords[0], 
			'x' => $arCoords[1], 
		];
		$web[$arCoords[0]][$arCoords[1]] = $objNew['img'];
		$arObj[$objId] = $objNew;
		$objWeb[$arCoords[0]][$arCoords[1]] = $objId;
	}
}

function TryMoveRand($objId){
	$arr = ['u', 'd', 'l', 'r', 'stay', 'cont'];
	$selected = $arr[array_rand($arr)];
	TryMove($objId, $selected);
}

function collision($agr, $def){
	global $message;
	global $web;
	global $objWeb;
	global $arObj;

	$agr = &$arObj[$agr['id']];
	$def = &$arObj[$def['id']];
	
	$agr['rest'] = 0;
	$def['rest'] = 0;
	
	if(($def['type'] == 'mon' && $agr['type'] == 'player') || ($def['type'] == 'player' && $agr['type'] == 'mon') || (($def['type'] == 'mon' && $agr['type'] == 'mon') && ($def['clan'] != $agr['clan']))){
		
		if($agr['type'] == 'player' || $def['type'] == 'player'){
			$message .= '<div style="border: 1px solid red; margin:3px; padding: 3px;">';
			$message .= '<div>'.$agr['name'].' напал на : '.$def['name'].'</div>';
		}
		
		$Am_ = rand(0, 5);
		
		if($agr['type'] == 'player' || $def['type'] == 'player')
			$message .= '<div>атака: '.$agr['Am'].' на '.$Am_.'</div>';
		
		if($agr['Am'] > $Am_)
		{
			if($agr['type'] == 'player' || $def['type'] == 'player')
				$message .= '<div>WIN</div>';
			
			$Ds_ = rand(0, 5);
			
			if($agr['type'] == 'player' || $def['type'] == 'player')
				$message .= '<div>защита: '.$def['Ds'].' на '.$Ds_.'</div>';
			
			if($def['Ds'] > $Ds_)
			{
				
				if($agr['type'] == 'player' || $def['type'] == 'player')
					$message .= '<div>WIN</div>';
				
				$a_ = 0;
			}
			else
			{
				if($agr['type'] == 'player' || $def['type'] == 'player')
					$message .= '<div>FAIL</div>';
				
				$a_ = 1;
			}
		}
		else
		{
			if($agr['type'] == 'player' || $def['type'] == 'player')
				$message .= '<div>FAIL</div>';
			
			$a_ = 0;
		}
		
		$As_ = rand(0, 5);
		
		if($agr['type'] == 'player' || $def['type'] == 'player')
			$message .= '<div>контратака: '.$def['As'].' на '.$As_.'</div>';
		
		if($def['As'] > $As_)
		{
			if($agr['type'] == 'player' || $def['type'] == 'player')
				$message .= '<div>WIN</div>';
			
			$Dm_ = rand(0, 5);
			
			if($agr['type'] == 'player' || $def['type'] == 'player')
				$message .= '<div>отступление: '.$agr['Dm'].' на '.$Dm_.'</div>';
			
			if($agr['Dm'] > $Dm_)
			{
				
				if($agr['type'] == 'player' || $def['type'] == 'player')
					$message .= '<div>WIN</div>';
				
				$d_ = 0;
			}
			else
			{
				if($agr['type'] == 'player' || $def['type'] == 'player')
					$message .= '<div>FAIL</div>';
				
				$d_ = 1;
			}
		}
		else
		{
			if($agr['type'] == 'player' || $def['type'] == 'player')
				$message .= '<div>FAIL</div>';
			
			$d_ = 0;
		}
		
		if($a_ == 1){
			$def['Hlt'] = $def['Hlt'] - $agr['Dmg'];
			if($def['Hlt'] > 0){
				
				if($agr['type'] == 'player' || $def['type'] == 'player'){
					$message .= '<div>$def[Hlt] > 0</div>';
					$message .= '<div>'.$def['name'].' wounded by '.$agr['Dmg'].' ('.$def['Hlt'].' / '.$def['HltMax'].')</div>';
				}
				
				$def['wounded'] = 1;
				//$arObj[$def['id']] = $def;
				$a = 0;
			}else{
				if($agr['type'] == 'player' || $def['type'] == 'player'){
					$message .= '<div>$def[Hlt] <= 0</div>';
					$message .= '<div>'.$def['name'].' defeated</div>';
				}
				//$arObj[$def['id']] = $def;
				rip($def['id']);
				$ch = rand (1, 5);
				if($ch == 1){
					$agr['Dmg'] ++;
					
					if($agr['type'] == 'player' || $def['type'] == 'player')
						$message .= '<div>'.$agr['name'].' Dmg++</div>';
					
				}else{
					$agr['HltMax'] ++;
					
					if($agr['type'] == 'player' || $def['type'] == 'player')
						$message .= '<div>'.$agr['name'].' HltMax++</div>';
					
				}
				//$arObj[$agr['id']] = $agr;
				$a = 1;
			}
		}else{
			$a = 0;
		}
		if($d_ == 1){			
			$agr['Hlt'] = $agr['Hlt'] - $def['Dmg'];
			if($agr['Hlt'] > 0){
				
				if($agr['type'] == 'player' || $def['type'] == 'player')
					$message .= '<div>'.$agr['name'].' wounded by '.$def['Dmg'].' ('.$agr['Hlt'].' / '.$agr['HltMax'].')</div>';
				
				$agr['wounded'] = 1;
				//$arObj[$agr['id']] = $agr;
				$d = 0;
			}else{
				
				if($agr['type'] == 'player' || $def['type'] == 'player')
					$message .= '<div>'.$agr['name'].' defeated</div>';
			
				//$arObj[$agr['id']] = $agr;
				rip($agr['id']);
				$ch = rand (1, 5);
				if($ch == 1){
					$def['Dmg'] ++;
					if($agr['type'] == 'player' || $def['type'] == 'player')
						$message .= '<div>'.$def['name'].' Dmg++</div>';
				}else{
					$def['HltMax'] ++;
					if($agr['type'] == 'player' || $def['type'] == 'player')
						$message .= '<div>'.$def['name'].' HltMax++</div>';
				}
				//$arObj[$def['id']] = $def;
				$d = 1;
			}
			// награду пебедителю в отдельную функцию
		}else{
			$d = 0;
		}
		if($agr['type'] == 'player' || $def['type'] == 'player')
			$message .= '</div>';
	}
	elseif($def['type'] == 'mon' && $agr['type'] == 'mon')
	{
		$a = 0; $d = 0;
	}
	elseif($def['type'] == 'bonus')
	{
		/*echo '<pre>$agr: '; print_r($agr); echo '</pre>';
		echo '<pre>def: '; print_r($def); echo '</pre>';
		echo '<div>$agr[type]: '.$agr['type'].'</div>';
		echo '<div>$def[character]: '.$def['character'].'</div>';
		echo '<div>$def[value]: '.$def['value'].'</div>';
		echo '<div>$agr[$def[character]]: '.$agr[$def['character']].'</div>';*/
		if($agr['type'] == 'mon' || ($agr['type'] == 'player' && $agr[$def['character']] == $def['value'] - 1))
		{
			if($agr['type'] == 'player' || $def['type'] == 'player')
				$message .= '<div style="border: 1px solid green; margin:3px; padding: 3px;">';
			$arObj[$agr['id']][$def['character']] = $def['value'];
			if($agr['type'] == 'player' || $def['type'] == 'player'){
				$message .= '<div>'.$agr['name'].' gain '.$def['character'].': '.$def['value'].'</div>';
				$message .= '</div>';
			}
		}
		
		$a = 1; $d = 0;
	}
	else
	{
		$message .= '<div>collision exception<div>';
	}

	return(['a' => $a, 'd' => $d]);
}

function Move($objId, $direction){
	global $web;
	global $objWeb;
	global $arObj;
	global $arDirs;
	
	$axis = $arDirs[$direction]['axis'];
	$num = $arDirs[$direction]['num'];
	
	$web[$arObj[$objId]['y']][$arObj[$objId]['x']] = '';
	$objWeb[$arObj[$objId]['y']][$arObj[$objId]['x']] = '';
	$arObj[$objId][$axis] = $arObj[$objId][$axis] + $num;
	$web[$arObj[$objId]['y']][$arObj[$objId]['x']] = $arObj[$objId]['img'];
	$objWeb[$arObj[$objId]['y']][$arObj[$objId]['x']] = $arObj[$objId]['id'];
}

function TryMove($objId, $direction){
	global $web;
	global $objWeb;
	global $x_max;
	global $y_max;
	global $arObj;
	global $arDirs;
	global $message;
	
	if($arObj[$objId]['status'] != 'de' && $direction != 'stay' && $direction != 'cont'){
		$arObj[$objId]['rest'] = 0;
		$arObj[$objId]['direct'] = $direction;
		$axis = $arDirs[$direction]['axis'];
		$num = $arDirs[$direction]['num'];
		
		$limit = false;
		if($num > 0)
		{
			if($arObj[$objId][$axis] < ${$axis.'_max'}){
				$limit = false;
			}else{
				$limit = true;
				//echo '<br>уперся<br>';
			}
		}
		elseif($num < 0)
		{
			if($arObj[$objId][$axis] > 0){
				$limit = false;
			}else{
				$limit = true;
				//echo '<br>уперся<br>';
			}
		}
		
		if($limit == false)
		{
			if($axis == 'x'){
				$y_current = $arObj[$objId]['y'];
				$x_current = $arObj[$objId]['x'] + $num;
			}elseif($axis == 'y'){
				$y_current = $arObj[$objId]['y'] + $num;
				$x_current = $arObj[$objId]['x'];
			}
			
			if($web[$y_current][$x_current] == ''){
				Move($objId, $direction);
			}else{
				$coll = collision($arObj[$objId], $arObj[$objWeb[$y_current][$x_current]]);
				if($coll['a'])
				{
					//$arObj[$objWeb[$y_current][$x_current]]['status'] = 'de';
					//rip($objWeb[$y_current][$x_current]);
					Move($objId, $direction);
				}
				
				// перестраховка от появления трупа, если оба противника погибли
				if($coll['d']){
					rip($objId);
				}
				
				/*if($coll['d'])
				{
					//$web[$y_current][$x_current] = '';
					//$objWeb[$y_current][$x_current] = '';
					//$message .= '<div>накололся удаление '.$arObj[$objId]['y'].' '.$arObj[$objId]['x'].'</div>';
					//$arObj[$objId]['y'] = '';
					//$arObj[$objId]['x'] = '';

					rip($objId);
				}*/
			}
		}
		$arObj[$objId]['direction'] = $direction;
		$arObj[$objId]['lastTurn'] = $direction;

	}elseif($direction == 'cont'){
		if(!empty($arObj[$objId]['lastTurn'])){
			TryMove($objId, $arObj[$objId]['lastTurn']);
		}else{
			$arObj[$objId]['lastTurn'] = 'stay';
		}
	}elseif($direction == 'stay'){
		$arObj[$objId]['lastTurn'] = 'stay';
	}
}

function rip($id){
	global $web;
	global $objWeb;
	global $x_max;
	global $y_max;
	global $arObj;
	global $arDirs;
	global $message;
	$arObj[$id]['status'] = 'de';
	$objWeb[$arObj[$id]['y']][$arObj[$id]['x']] = '';
	$web[$arObj[$id]['y']][$arObj[$id]['x']] = '';	
	$message .= '<div>RIP '.$arObj[$id]['name'].'</div>';
}

function monTurn(){
	global $arMonTypes;
	global $arObj;
	global $message;
	$arMon = searchForPropArr('type', 'mon', $arObj);
	foreach($arMon as $k => $v){
		if($arObj[$v]['status'] != 'de'){
			if($arObj[$v]['name'] == 'lair'){
				$message .= '<div>try gen '.$arObj[$v]['clan'].'</div>';
				$axis = rand(0, 1);
				$num = rand(0, 1);
				if($axis == 0 && $num == 0){
					$y_ = $arObj[$v]['y'] - 1;
					$x_ = $arObj[$v]['x'];
				}elseif($axis == 0 && $num == 1){
					$y_ = $arObj[$v]['y'] + 1;
					$x_ = $arObj[$v]['x'];
				}elseif($axis == 1 && $num == 0){
					$y_ = $arObj[$v]['y'];
					$x_ = $arObj[$v]['x'] - 1;
				}elseif($axis == 1 && $num == 1){
					$y_ = $arObj[$v]['y'];
					$x_ = $arObj[$v]['x'] + 1;
				}
				genMon($y_, $x_, 'war', $arObj[$v]['clan']);
			}//else{
				TryMoveRand($arObj[$v]['id']);
			//}
		}
	}
};

function regeneration(){
	global $arObj;
	
	$arMon = searchForPropArr('type', 'mon', $arObj);
	$p = searchForPropArr('type', 'player', $arObj);
	$arr = array_merge($arMon, $p);
	foreach($arr as $k => $v){
		
	if($arObj[$v]['status'] != 'de' && $arObj[$v]['rest'] == 1){
			if($arObj[$v]['wounded'] == 1){
				$arObj[$v]['wounded'] = 0;
			}else{
				if($arObj[$v]['Hlt'] < $arObj[$v]['HltMax']){
					$arObj[$v]['Hlt'] ++;
				}
			}
		}
	}
}

function rest(){
	global $arObj;
	
	$arMon = searchForPropArr('type', 'mon', $arObj);
	$p = searchForPropArr('type', 'player', $arObj);
	$arr = array_merge($arMon, $p);
	foreach($arr as $k => $v){
		if($arObj[$v]['status'] != 'de'){
			if($arObj[$v]['rest'] == 0){
				$arObj[$v]['rest'] = 1;
			}
		}
	}
}

function turn(){
	global $web;
	global $objWeb;
	global $x_max;
	global $y_max;
	global $arObj;

	foreach($arObj as $k => $v){
		if($v['status'] == 'ok'){
			$web[$v['y']][$v['x']] = $v['img'];
		}
	}
	
	regeneration();
	rest();
	
	if(!empty($_REQUEST['m'])){
		$playerId = searchForProp('name', 'player', $arObj);
		if($_REQUEST['m'] == 'up'){
			TryMove($playerId, 'u');
		}elseif($_REQUEST['m'] == 'down'){
			TryMove($playerId, 'd');
		}elseif($_REQUEST['m'] == 'left'){
			TryMove($playerId, 'l');
		}elseif($_REQUEST['m'] == 'right'){
			TryMove($playerId, 'r');
		}
	}

	monTurn();
	
	//genMon();
	genBon();
}

$message = '';
$x_max = 19;
$y_max = 19;
$gol = unserialize(file_get_contents('store.php'));
if(!empty($gol) && empty($_REQUEST['restart'])){
	$web = $gol['web'];
	$arObj = $gol['arObj'];
	$objWeb = $gol['objWeb'];
	$globals = $gol['globals'];
	$globals['clan']++;
	if($globals['clan'] == count($arClans)){
		$globals['clan'] = 0;
	}
	$globals['turn']++;
	$clan_color = $arClans[$globals['clan']];
	turn();
}else{
	$globals = ['clan' => 0, 'turn' => 0];
	$web = [];
	for ($y=0; $y<=$y_max; $y++){
		$row = [];
		for ($x=0; $x<=$x_max; $x++){
			$row[$x] = '';
		}
		$web[$y] = $row;
	}
	$arObj = [];
	$objWeb = [];
	$py = coord(1, $y_max);
	if($py == 0 || $py == $y_max){
		$px = coord(1, ($x_max-2));
		$px = $px + 1;
	}else{
		$px = coord(1, $x_max);
	}

	$arCoords = [$py, $px];


	if($web[$arCoords[0]][$arCoords[1]] == ''){
		$arr = ['u', 'd', 'l', 'r'];
		$dir = $arr[array_rand($arr)];
		$arObj[0] = [
			'rest' => 1,
			'wounded' => 0,
			'id' => 0,
			'direction' => $dir,
			'lastTurn' => 'stay',
			'name' => 'player',
			'type' => 'player',
			'img' => '<div style="background-color: #2cd43d;" class="colordiv"><img src="sprite/hero_png.png"></div>',
			'status' => 'ок',
			'y' => $arCoords[0], 
			'x' => $arCoords[1], 
			'Hlt' => 1,
			'HltMax' => 1,
			'Dmg' => 1,
			'Am' => 0,
			'As' => 0,
			'Dm' => 0,
			'Ds' => 0,
			'm' => 4,
			'Ha' => [],
			'inv' => [
				0 => [0 => '', 1 => '', 2 => '', 3 => '', 4 => '', 5 => ''],
				1 => [0 => '', 1 => '', 2 => '', 3 => '', 4 => '', 5 => ''],
				2 => [0 => '', 1 => '', 2 => '', 3 => '', 4 => '', 5 => ''],
				3 => [0 => '', 1 => '', 2 => '', 3 => '', 4 => '', 5 => ''],
				4 => [0 => '', 1 => '', 2 => '', 3 => '', 4 => '', 5 => ''],
				5 => [0 => '', 1 => '', 2 => '', 3 => '', 4 => '', 5 => '']
			]
		];
		$playerId = searchForProp('name', 'player', $arObj);
		$web[$arCoords[0]][$arCoords[1]] = $arObj[$playerId]['img'];
		$objWeb[$arCoords[0]][$arCoords[1]] = $playerId;
	}
	
	genMon('0', '0', 'lair', $arClans[0]);
	genMon('0', $x_max, 'lair', $arClans[1]);
	genMon($y_max, '0', 'lair', $arClans[2]);
	genMon($y_max, $x_max, 'lair', $arClans[3]);
}
$gol = ['web' => $web, 'objWeb' => $objWeb, 'arObj' => $arObj, 'globals' => $globals];	//	, 'arMon' => $arMon
file_put_contents('store.php', serialize($gol));
echo '<dev class="status" style="display: inline-block">';
echo '<div class="gol">';
$arAttr = ['Hlt', 'HltMax', 'Dmg', 'Am', 'As', 'Dm', 'Ds'];
foreach($web as $k => $v){
	echo '<div class="tr">';
	foreach($v as $k2 => $v2){
		echo '<div class="td">';
		echo '<span class="unit"';
		
		foreach($arAttr as $attr){
			if(isset($arObj[$objWeb[$k][$k2]][$attr])){
				echo ' '.$attr.'="'.$arObj[$objWeb[$k][$k2]][$attr].'"';
			}
		}
		echo '>'.$v2.'</span>';
		echo '</div>';
	}
	echo '</div>';
}
echo '</div>';

/*foreach($web as $k => $v){
	echo '<div class="damp" style="display: block">'.$k.': ';
	foreach($v as $k2 => $v2){
		echo '<span>';
		echo $k2.': '.$v2.'; ';
		echo '</span>';
	}
	echo '</div>';
}*/

if(!empty($message)){
	echo '<dev class="message">';
	echo $message;
	echo '</dev>';
}
echo '</dev>';
echo '<dev class="status" style="display: inline-block; vertical-align: top">';
$playerId = searchForProp('name', 'player', $arObj);
echo '	<dev class="status" style="vertical-align: top">
	<div>Ход: '.$globals['turn'].'</div>
	<div>⚔️♘'.$arObj[$playerId]['Am'].'</div>
	<div>🛡️♘'.$arObj[$playerId]['Dm'].'</div>
	<div>⚔️♖'.$arObj[$playerId]['As'].'</div> 
	<div>🛡️♖'.$arObj[$playerId]['Ds'].'</div>
	<div>DMG '.$arObj[$playerId]['Dmg'].'</div> 
	<div>HLT '.$arObj[$playerId]['Hlt'].' / '.$arObj[$playerId]['HltMax'].'</div>
</dev>
<div class="loading"><img src="loader.gif"></div>';?>

<?/*echo '<div>$objWeb: '; print_r($objWeb[$arObj[$playerId]['y']][$arObj[$playerId]['x']]); echo '</div>';
echo '<div>$web: '.$web[$arObj[$playerId]['y']][$arObj[$playerId]['x']].'</div>';*/
//echo '<pre>'; print_r($arObj[$playerId]); echo '</pre>';
//echo '</dev>';
/*
⚔️♘ ⚔️♖
🛡️♘ 🛡️♖

⚔️♖
🛡️♖

⚔️♘ 🛡️♘
⚔️♖ 🛡️♖

🏰

если пользователь накололся, он остаётся на карте, но не двигается
на него всё ещё нападают, вылезает лишняя клетка внизу
*/
?>
