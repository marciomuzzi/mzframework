<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

?>
<div style="text-align: center;">
<h3>Bem-vindo à aplicação exemplo da Mz Framework</h3>
<form name="formLogin" id="formLogin" method="post" action="?c=usuario&m=efetuarLogin">
    <p><label for="email">E-mail: </label>
        <input type="text" name="email" id="email" size="30" maxlength="40" required /></p>
    <p><label for="password">Senha: </label>
        <input type="password" name="senha" id="senha" size="30" maxlength="40" required /></p>
    <input type="submit" name="btnLogin" id="btnLogin" value="Enviar" />
    </div>
</form>