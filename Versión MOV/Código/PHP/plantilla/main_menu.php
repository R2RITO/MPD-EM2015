<!--/> 
	Arturo Voltattorni 10-10774
	Ramon Marquez	   10-10849
	Esteban Oliveros   10-11252
	
	Archivo que contiene el menú lateral (principal) de la página
<!-->

<div class="col-xs-2 col-xs-height col-top main-menu" >
	<ul class="list-unstyled main-menu">
		<?php for($i = 0;$i < count($main_menu);$i++) : ?>
			<li class="<?php if ($main_menu[$i]['active']) { echo 'active';} ?>">
				<a href="<?php echo $main_menu[$i]['link']; ?>"><?php echo $main_menu[$i]['opt']; ?></a>
			</li>
		<?php endfor;?>
	</ul>
</div>
