<!--/> 
	Arturo Voltattorni 10-10774
	Ramon Marquez	   10-10849
	Esteban Oliveros   10-11252
	
	Archivo que contiene la estructura del submenu
<!-->


<?php 
	$sub_menu = array(
						array("opt"=>"Información", "class"=>"info-opt", "active"=>true), 
						array("opt"=>"Contextos", "class"=>"ctx-opt", "active"=>false) 
					);

	for($i = 0;$i < count($sub_menu);$i++) : ?>
	<li class="<?php if ($sub_menu[$i]['active']) { echo 'active';} ?> ">
		<a href="#"><?php echo $sub_menu[$i]['opt']; ?></a>
	</li>
<?php endfor;?>
