<fieldset>
    <legend>Consulta de Usuários</legend>
<div style="text-align: center">
<form name="formConsulta" id="formConsulta" method="post" action="?c=usuario&m=consultar">
    <p>
        <label for="nome">Nome:</label>
        <input type="text" name="nome" id="nome" size="30" maxlength="40" /></p>
    <p>
        <label for="email">E-mail:</label>
        <input type="text" name="email" id="email" size="30" maxlength="40" />
    </p>    
    
    <input type="submit" name="btnConsulta" id="btnConsulta" value="Buscar" />
</form>
    
<?php
$headerGrid = array (
      'nome',
      'email',      
      'Perfil');
$this->grid->set($headerGrid, $this->listaUsuarios);
echo $this->grid->show();
?>
</div>
</fieldset>