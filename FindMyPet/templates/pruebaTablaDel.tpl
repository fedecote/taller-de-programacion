{* Smarty *}
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Primer prueba con Smarty</title>
	</head>
	
    <body>
		{if $numero != 0}
			<h1>TABLA DEL : {$numero}</h1>
			
		   {foreach from=$datos item=dato}
				<h3>{$dato.numero} X {$dato.valor} = {$dato.resultado}</h3>
		   {/foreach}
		{else}
			<h1>No se ingresó número, llamar: pruebaTablaDel.php?numero=nnn
		{/if}
    </body>

</html>
