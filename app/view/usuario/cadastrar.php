<h3>Cadastrar Usuário</h3>
<div style="text-align: center">
<form name="formCadastro" id="formCadastro" method="post" action="?c=usuario&m=enviarCadastro&layoutClear=1">
<?php echo $this->form->getInputToken(); ?>
    <p>
        <label for="nome">Nome:</label>
        <input type="text" name="nome" id="nome" size="30" maxlength="40" required /></p>
    <p>
        <label for="email">E-mail:</label>
        <input type="text" name="email" id="email" size="30" maxlength="40" placeholder="john_doe@example.com" required />
    </p>
    <p>
        <label for="perfil">Perfil:</label>
            <select name="perfil" id="perfil" required>
                <option value="">Selecione:</option>
                <?php
                foreach ($this->listaPerfis as $perfil) {
                    echo '<option value="',$perfil['id'],'">',$perfil['nome'],'</option>', "\n";
                }                
                ?>
            </select>
        
    </p>
    
    <input type="submit" name="btnLogin" id="btnLogin" value="Enviar" />
</form>
    </div>