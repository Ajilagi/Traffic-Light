<?php

//load class
spl_autoload_register(function($class){
	require_once 'classes/' .$class. '.php';
});

//make the object for every trafficlight (4 crossroad x 4 trafficlight)
for ($i=0; $i < 4; $i++) { 
	for ($j=0; $j < 4; $j++) { 
		if(isset($_GET['status-'.$i])){
			if($_GET['status-'.$i] == "on"){
				$trafficlight[$i][$j] = new Trafficlight("on");
				if($j%2 == 1){
					$trafficlight[$i][$j]->turnRed();
				}else{
					$trafficlight[$i][$j]->turnGreen();
				}
			}else{
				$trafficlight[$i][$j] = new Trafficlight("off");
				$trafficlight[$i][$j]->turnYellow();
			}
		}else{
				$trafficlight[$i][$j] = new Trafficlight("off");
				$trafficlight[$i][$j]->turnYellow();
		}
	}
}



//print("<pre>".print_r($trafficlight,true)."</pre>");
//var_dump(json_encode($trafficlight));

?><!DOCTYPE html>
<html>
<head>
	<title>OOP Traffic Light</title>
	<link rel="stylesheet" href="assets/css/style.css">
	<script
			  src="https://code.jquery.com/jquery-3.4.1.min.js"
			  integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
			  crossorigin="anonymous"></script>

</head>
<body>
	<form method="get" action="#" id="myForm">
	<?php
	for ($i=0; $i < 4; $i++) { ?>
		
		<div class="column">
			<div class="crossroad">
				<input type="hidden" name="status-<?php echo $i; ?>" id="status-<?php echo $i; ?>" value="<?php if($trafficlight[$i][0]->getStatus()=="off"){ echo "off"; }else{ echo "on"; } ?>">
				<div  class="startTL" id="<?php echo $i; ?>"><button><?php if($trafficlight[$i][0]->getStatus()=="off"){ echo "Start"; }else{ echo "Stop"; } ?></button></div>
				<?php

				for ($j=0; $j < 4; $j++) { ?>
					<div class="trafficlight<?php echo $j+1; ?>" id="<?php echo $i."-".$j; ?>">

					</div>
					<?php
				}

				?>
				<img src="assets/img/crossroad.png">
			</div>
		</div>
		
		<?php
	}
	?>
	</form>
</body>
<script type="text/javascript">
	$(document).ready(function() {
         <?php
            for ($i=0; $i < 4; $i++) { 
            	for ($j=0; $j < 4; $j++) { 
            		$power = $trafficlight[$i][$j]->getPower();
            		if($j%2 == 0){
            			$light = "light";
            		}else{
            			$light = "light2";
            		}

            		for ($k=0; $k < 3; $k++) {?>
						$( "#<?php echo $i."-".$j; ?>" ).append( '<div  id="<?php echo $i.'-'.$j.'-'.$k;?>" class="<?php echo $light; ?>">&nbsp;</div>' );
						<?php
            		}
            	}
            }?>
            $( ".startTL" ).click(function() {
				let id = $(this).attr('id');
				let status = $("#status-"+id).val();
				if(status == "off"){
					$("#status-"+id).val("on");
				}else{
					$("#status-"+id).val("off");
				}
				
				$( "#myForm" ).submit();
			});
            check();
            
    });

    function redBlink(id){
		$('#'+id+"-1").css('background-color', 'black');
		$('#'+id+"-0").css('background-color', '#cc3232');
		window.setTimeout(function(){greenBlink(id);}, 5000);

    }

    function yellowBlink(id, toColor){
    	if(	toColor == "red"){
    		$('#'+id+"-2").css('background-color', 'black');
    		$('#'+id+"-1").css('background-color', '#e7b416');
			window.setTimeout(function(){redBlink(id);}, 750);
    	}else if(toColor == "yellow"){
    		$('#'+id+"-1").css('background-color', 'black');
			window.setTimeout(function(){blackBlink(id);}, 750);
		}	
    }

    function greenBlink(id){
		$('#'+id+"-0").css('background-color', 'black');
		$('#'+id+"-2").css('background-color', '#2dc937');
		window.setTimeout(function(){yellowBlink(id, "red");}, 5000);
    }
    function blackBlink(id){
    	$('#id'+id+"-1").css('background-color', '#e7b416');
		window.setTimeout(function(){yellowBlink(id, "yellow");}, 750);
    }
    function check(){
    	<?php
    	for ($i=0; $i < 4; $i++) { 
    		for ($j=0; $j < 4; $j++) { 
    			if($trafficlight[$i][$j]->getPower() == [true, false, false]){ ?>
    				yellowBlink("<?php echo $i."-".$j; ?>", "red");
    				<?php
    			}else if($trafficlight[$i][$j]->getPower() == [false, true, false]){ ?>
    				yellowBlink("<?php echo $i."-".$j; ?>", "yellow");
    				<?php
    			}else if($trafficlight[$i][$j]->getPower() == [false, false, true]){ ?>
    				window.setTimeout(function(){greenBlink("<?php echo $i."-".$j; ?>")}, 750);
    				<?php
    			}
    		}
    	}
    	?>
    }
</script>
</html>