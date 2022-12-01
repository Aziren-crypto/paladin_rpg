<html>
	<head>
		<title>Голем</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	</head> 
	<body>
	<script src="jquery-3.3.1.min.js"></script>
<?

echo '<div class="ajax"></div>';

if(!empty($_REQUEST['restart'])){?>
	<script>
		$(document).ready(function() {
			$('.loading').show();
			ajax_processing = true;
			$.ajax({
				url: 'gol_ajax_0.php?restart=Y',
				type: 'post',
				success: function(data){
					$('.ajax').html(data);
					$('.loading').hide();
					ajax_processing = false;
				}	
			});
		});
	</script>
<?}else{?>
	<script>
		$(document).ready(function() {
			$('.loading').show();
			ajax_processing = true;
			$.ajax({
				url: 'gol_ajax_0.php',
				type: 'post',
				success: function(data){
					$('.ajax').html(data);
					$('.loading').hide();
					ajax_processing = false;
				}	
			});
		});
	</script>
<?}?>

<script>
	document.onkeydown = checkKey;
	i = 2;
	
	// < Подгрузка сразу же при открытии страницы
	//$('.ajax').html('Загрузка ...');

	// > Подгрузка сразу же при открытии страницы
	
	function checkKey(e) {
		if(!ajax_processing){
			e = e || window.event;
			if (e.keyCode == '38'){
				e.preventDefault();
				//alert('up');
				//$('.ajax').html('Загрузка ...');
				$('.loading').show();
				ajax_processing = true;
				$.ajax({
					url: 'gol_ajax_0.php?i='+i+'&m=up',
					type: 'post',
					success: function(data){
						$('.ajax').html(data);
						$('.loading').hide();
						ajax_processing = false;
					}	
				});
			}
			else if (e.keyCode == '40'){
				e.preventDefault();
				//alert('down');
				//$('.ajax').html('Загрузка ...');
				$('.loading').show();
				ajax_processing = true;
				$.ajax({
					url: 'gol_ajax_0.php?i='+i+'&m=down',
					type: 'post',
					success: function(data){
						$('.ajax').html(data);
						$('.loading').hide();
						ajax_processing = false;
					}	
				});
			}
			else if (e.keyCode == '37'){
				e.preventDefault();
				//alert('left');
				//$('.ajax').html('Загрузка ...');
				$('.loading').show();
				ajax_processing = true;
				$.ajax({
					url: 'gol_ajax_0.php?i='+i+'&m=left',
					type: 'post',
					success: function(data){
						$('.ajax').html(data);
						$('.loading').hide();
						ajax_processing = false;
					}	
				});
			}
			else if (e.keyCode == '39'){
				e.preventDefault();
				//alert('right');
				//$('.ajax').html('Загрузка ...');
				$('.loading').show();
				ajax_processing = true;
				$.ajax({
					url: 'gol_ajax_0.php?i='+i+'&m=right',
					type: 'post',
					success: function(data){
						$('.ajax').html(data);
						$('.loading').hide();
						ajax_processing = false;
					}	
				});
			}
			else if(e.keyCode == '32'){
				e.preventDefault();
				//alert('пробел');
				//$('.ajax').html('Загрузка ...');
				$('.loading').show();
				ajax_processing = true;
				$.ajax({
					url: 'gol_ajax_0.php?wait=Y',
					type: 'post',
					success: function(data){
						$('.ajax').html(data);
						$('.loading').hide();
						ajax_processing = false;
					}	
				});
			}
			else if(e.keyCode == '27'){
				e.preventDefault();
				//alert('escape');
				//$('.ajax').html('Загрузка ...');
				$('.loading').show();
				ajax_processing = true;
				$.ajax({
					url: 'gol_ajax_0.php?restart=Y',
					type: 'post',
					success: function(data){
						$('.ajax').html(data);
						$('.loading').hide();
						ajax_processing = false;
					}	
				});
			}
		}
	}
</script>
<style>
	.gol td{
		border: 1px solid black;
		width: 20px;
		height: 20px;
	}
	
	span.unit{
		z-index: 99999;
		display: block;
	}
	span.unit:hover::after {
		content:
		<?$arAttr = ['Hlt', 'HltMax', 'Dmg', 'Am', 'As', 'Dm', 'Ds'];
		foreach($arAttr as $attr){
			echo '"'.$attr.':" attr('.$attr.') " | "';
		}?>;
		background-color: #c2c2c2;
		z-index: 99999;

		position: absolute;
	}
	.loading{
		display: none;
	}
</style>
</body>
</html>