<?php
$session = new Session(APP_SIGLA);
?>
<div id='cssmenu'>
<ul>
   <li><a href='#'>Início</a></li>
   <?php if ($session->getAttribute('autenticado')) { ?>
   <li class='active'><a href='#'>Administração</a>
      <ul>          
         <li><a href='#'>Usuário</a>
            <ul>
               <li><a href='?c=usuario&m=consultar'>Consultar</a></li>
               <li><a href='?c=usuario&m=cadastrar'>Cadastrar</a></li>
            </ul>
         </li>         
         <li><a href='#'>Aplicação</a>
            <ul>
               <li><a href='#'>Configurações gerais</a></li>               
            </ul>
         </li>
         
      </ul>
   </li>
   <?php } ?>
   <li><a href='#'>Documentação</a></li>
   <li><a href='#'>Sobre</a></li>
   <?php if ($session->getAttribute('autenticado')) { ?>
   <li><a href='?usuario&m=sair&layoutClear=1'>Sair</a></li>
   <?php } ?>
   
</ul>
</div>