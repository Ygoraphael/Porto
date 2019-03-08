<!-- Service Tabs -->
<style>
    .dataTables_length{float: right}
</style>
<div class="span12">
    <h4 class="page-header">
        <?php
        include_once 'db_config.php';
        if (isset($_SESSION['acao'])) {
            unset($_SESSION['acao']);
        }
        $request = $_SERVER['REQUEST_URI'];
        $curso = explode('/', $request);
        $_POST['name'] = end($curso);
        $teste2 = $_POST['name'];
        $conn = mysql_connect($servername, $username, $password);
        if (!$conn) {
            die('Could not connect: ' . mysql_error());
        }
        $teste2 = $_POST['name'];
        $sql = "SELECT NomeCurso FROM cursos WHERE CC = '$teste2'";
        mysql_select_db('acadprof_inqdemo');
        $retval = mysql_query($sql, $conn);

        if (!$retval) {
            die('Could not get data: ' . mysql_error());
        }

        while ($row = mysql_fetch_assoc($retval)) {
            echo nl2br($row['NomeCurso']);
            $title = nl2br($row['NomeCurso']);
        }

        mysql_close($conn);
        ?>

    </h4>
</div>
<div class="span12">

    <ul id="myTab" class="nav nav-tabs nav-justified">
        <li class="active"><a href="#service-three" data-toggle="tab"><i class=""></i>Cronograma e inscrições</a>
        </li>
        <li class=""><a href="#service-one" data-toggle="tab"><i class=""></i>Apresentação do Curso</a>
        </li>
        <li class=""><a href="#service-four" data-toggle="tab"><i class=""></i>Preços e Descontos</a>
        </li>
        <li class=""><a href="#service-five" data-toggle="tab"><i class=""></i>Acreditação e requisitos</a>
        </li>
        <li class=""><a href="#service-six" data-toggle="tab"><i class=""></i>Esclarecimentos da Inscrição Online</a>
        </li>

    </ul>
</div>
<div class="span12">
    <div id="myTabContent" class="tab-content" style="">

        <div class="tab-pane active fade in" id="service-three">

            <div class="even_tab">
                <div class="span12">
                    <?php
                    include 'db_config.php';

                    $conn = mysql_connect($servername, $username, $password);

                    if (!$conn) {
                        die('Could not connect: ' . mysql_error());
                    }

                    $teste2 = $_POST['name'];
                    mysql_select_db('acadprof_inqdemo');

                    $local = mysql_real_escape_string($_REQUEST['input1']);
                    $data = mysql_real_escape_string($_REQUEST['input2']);
                    $acao = mysql_real_escape_string($_REQUEST['input3']);

                    $where1 = "";
                    $where2 = "";
                    $where3 = "";

                    if( strlen(trim($local)) )
                        $where1 = " AND Localidade = '" . $local . "' ";
                    
                    if( strlen(trim($data)) )
                        $where2 = " AND DataInicio = '" . $data . "' ";
                    
                    if( strlen(trim($acao)) )
                        $where3 = " AND NomeAcao = '" . $acao . "' ";
                        
                    $main_str_query = "SELECT * FROM acoes WHERE RefCurso = '$teste2' " . $where1 . $where2 . $where3;

                    $contacts = mysql_query($main_str_query) or die(mysql_error());

// If results
                    if (mysql_num_rows($contacts) > 0)
                    ?>
                    
                    <form action="" method="POST" class="form-inline">
                    <div class="form-group" style="display: inline-block;">
                        <label for="input3">Curso</label>
                        <select class="form-control" id="input3" name="input3">
                            <option value=""></option>
                            <?php 
                                $sql = mysql_query("SELECT distinct NomeAcao FROM acoes WHERE RefCurso = '$teste2'");
                                while ($row = mysql_fetch_array($sql)){
                                    $selected = "";
                                    if( $acao == trim($row['NomeAcao']) && $acao != "")
                                        $selected = "selected";
                                    
                                    if( strlen(trim($row['NomeAcao'])) > 0 )
                                        echo "<option " . $selected . " value='".$row['NomeAcao']."'>" . $row['NomeAcao'] ."</option>";
                                }
                            ?>
                        </select>
                      </div>

                      <div class="form-group" style="display: inline-block;">
                        <label for="input1">Localidade</label>
                        <select class="form-control" id="input1" name="input1">
                            <option value=""></option>
                            <?php 
                                $sql = mysql_query("SELECT distinct Localidade FROM acoes WHERE RefCurso = '$teste2'");
                                while ($row = mysql_fetch_array($sql)){
                                    $selected = "";
                                    if( $local == trim($row['Localidade']) && $local != "")
                                        $selected = "selected";
                                    
                                    if( strlen(trim($row['Localidade'])) > 0 )
                                        echo "<option " . $selected . " value='".$row['Localidade']."'>" . $row['Localidade'] ."</option>";
                                }
                            ?>
                        </select>
                      </div>

                      <div class="form-group" style="display: inline-block;">
                        <label for="input2">Data de Início</label>
                        <select class="form-control" id="input2" name="input2">
                            <option value=""></option>
                            <?php 
                                $sql = mysql_query("SELECT distinct DataInicio FROM acoes WHERE RefCurso = '$teste2'");
                                while ($row = mysql_fetch_array($sql)){
                                    $selected = "";
                                    if( $data == trim($row['DataInicio']) && $data != "" )
                                        $selected = "selected";
                                    
                                    if( strlen(trim($row['DataInicio'])) > 0 )
                                        echo "<option " . $selected . " value='".$row['DataInicio']."'>" . $row['DataInicio'] ."</option>";
                                }
                            ?>
                        </select>
                      </div>
                      
                      <button type="submit" class="btn btn-default">Procurar</button>
                    </form>
                    
                    <div class="row">
                        <table id="contact-list" style="width: 100%">
                            <thead>
                                <tr>
                                    <th class="" style="vertical-align: baseline; text-align: left;">Curso</th>
                                    <th class="" style="vertical-align: baseline; text-align: center;">Localidade</th>
                                    <th class="hidden-phone" style="vertical-align: baseline; text-align: center;">Data de Início</th>
                                    <th class="hidden-phone" style="vertical-align: baseline; text-align: center;">Nº Sessões</th>
                                
                                <!--    <th class="hidden-phone" style="vertical-align: baseline; ">Cronograma</th>
                                
                                    <th class="hidden-phone"style="vertical-align: baseline; text-align: center">Morada</th>
                                    <th class="hidden-phone"style="vertical-align: baseline; text-align: center">Formato</th>		-->
                                    <th class="hidden-desktop"></th>
                                    <th class="md-xs" style=" text-align: center">Detalhes</th>
                                    <th class="md-xs" style=" text-align: center">Inscrição</th>

                                </tr>
                            </thead>
                            <tbody>

                                <?php while ($contact = mysql_fetch_array($contacts)) : ?>
                                    <tr style="vertical-align: baseline;" class="text-center">
                                        <td class="contact-address" name="edesta" style="text-align: left;"><?php echo nl2br($contact['NomeAcao']); ?></td>
                                        <td class="contact-address"><?php echo nl2br($contact['Localidade']); ?></td>
                                        <td class="contact-email"><?php echo nl2br((new \DateTime($contact['DataInicio']))->format('d/m/Y')); ?></td>
                                        <td class="hidden-phone contact-address"><?php echo nl2br($contact['Sessoes']); ?></td>
                                  <!--      <td class="hidden-phone contact-address"><?php echo nl2br($contact['Horario']); ?></td>
                                        <td class="hidden-phone contact-address"><?php echo nl2br($contact['Morada']); ?></td>
                                        <td class="hidden-phone contact-address"><?php echo nl2br($contact['Formato']); ?></td>		-->

                                        <td class="">
                                            <a href="#<?php
                                            $modal = (new \DateTime($contact['DataInicio']))->format('dmY');
                                            echo "{$modal}";
                                            ?>" role="button" class="btn btn-primary" data-toggle="modal">detalhes</a>
                                        </td>

                                       
                                        <td class="hidden-desktop">
                                            <a href="#<?php
                                            $modal = (new \DateTime($contact['DataInicio']))->format('dmY');
                                            echo "{$modal}";
                                            ?>" role="button" class="btn btn-primary" data-toggle="modal">detalhes</a>
                                        </td>
                                        <td class="inscricao ">
                                            <form action='index.php?option=com_jumi&view=application&fileid=5' method="post">
                                                <input type="hidden" name="edesta" value="<?php echo nl2br($contact['NomeAcao']); ?>">
                                                
                                                <input type="hidden" name="name" value="<?php echo $teste2; ?>">
                                                <input type="hidden" name="title" value="<?php echo $title; ?>">
                                                <input type="hidden" name="acao" value="<?php echo $contact['ID']; ?>">
                                                <input type="submit" name="submit" class="btn btn-success" value="Inscrever">
                                            </form>
                                        </td>

                                    </tr>

                                    <!-- Modal -->
                                <div id="<?php echo $modal; ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="z-index: 9999; padding-left: 5px;">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                        <h3 id="myModalLabel">Informações</h3>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <br>
                                            <div class="span12">
                                                <p>Início:<b><?php echo nl2br((new \DateTime($contact['DataInicio']))->format('d/m/Y')); ?>    </b></p> 
                                            </div>
                                        </div>
                                        <div class="row">
                                            <br>
                                            <div class="span12">
                                                <p >Termino:<b><?php echo nl2br((new \DateTime($contact['DataFim']))->format('d/m/Y')); ?></b></p> 
                                            </div>
                                        </div>
                                        <div class="row">
                                            <br>
                                            <div class="span12">
                                                <p>Sessões:<b><?php echo nl2br($contact['Sessoes']); ?></b></p> 
                                            </div>
                                        </div>
                                        <div class="row">
                                            <br>
                                            <div class="span12">
                                                <p>Cronograma:<b><?php echo nl2br($contact['Horario']); ?></b></p> 
                                            </div>
                                        </div>
                                        <div class="row">
                                            <br>
                                            <div class="span12">
                                                <p>Formato:<b><?php echo nl2br($contact['Formato']); ?></b></p> 
                                            </div>
                                        </div>
                                        <div class="row">
                                            <br>
                                            <div class="span12">
                                                <p>Detalhes:<b><?php echo nl2br($contact['Info']); ?></b></p> 
                                            </div>
                                        </div>
                                        <div class="row">
                                            <br>
                                            <div class="span12">
                                                <p>Localidade:<b><?php echo nl2br($contact['Localidade']); ?></b></p> 
                                            </div>
                                        </div>
                                        <div class="row">
                                            <br>
                                            <div class="span12">
                                                <p>Morada:<b><?php echo nl2br($contact['Morada']); ?></b></p> 
                                            </div>
                                        </div>
                                    </div> 
                                    <div class="modal-footer">
                                        <form action='index.php?option=com_jumi&view=application&fileid=5' method="post">
                                            <input type="hidden" name="name" value="<?php echo $teste2; ?>">
                                            <input type="hidden" name="title" value="<?php echo $title; ?>">
                                            <input type="hidden" name="acao" value="<?php echo $contact['NomeAcao']; ?>">
                                            <input type="submit" name="submit" class="btn btn-success" value="Inscrever">
                                        </form>
                                    </div>
                                </div>
                            <?php endwhile; ?>

                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>


        <div class="tab-pane fade in" id="service-one">
            <br>

            <?php
            include 'db_config.php';

            $conn = mysql_connect($servername, $username, $password);

            if (!$conn) {
                die('Could not connect: ' . mysql_error());
            }

            $teste2 = $_POST['name'];

            $sql = "SELECT Contexto FROM cursos WHERE CC = '$teste2'";
            mysql_select_db('acadprof_inqdemo');
            $retval = mysql_query($sql, $conn);

            if (!$retval) {
                die('Could not get data: ' . mysql_error());
            }

            while ($row = mysql_fetch_assoc($retval)) {
                
                echo nl2br($row['Contexto']);
            }

            mysql_close($conn);
            ?>

            <Hr style="border-top: 1px solid #ccc;">

            <?php
            include 'db_config.php';

            $conn = mysql_connect($servername, $username, $password);

            if (!$conn) {
                die('Could not connect: ' . mysql_error());
            }

            $teste2 = $_POST['name'];
            $sql = "SELECT Objectivos FROM cursos WHERE CC = '$teste2'";
            mysql_select_db('acadprof_inqdemo');
            $retval = mysql_query($sql, $conn);

            if (!$retval) {
                die('Could not get data: ' . mysql_error());
            }

            while ($row = mysql_fetch_assoc($retval)) {
                echo "<b>Objectivos:</b> <br> <br> ";
                echo nl2br($row['Objectivos']);
            }

            mysql_close($conn);
            ?>

            <br><Hr style="border-top: 1px solid #ccc;"><br>

            <?php
            include 'db_config.php';

            $conn = mysql_connect($servername, $username, $password);

            if (!$conn) {
                die('Could not connect: ' . mysql_error());
            }

            $teste2 = $_POST['name'];
            $sql = "SELECT PublicoTarget FROM cursos WHERE CC = '$teste2'";
            mysql_select_db('acadprof_inqdemo');
            $retval = mysql_query($sql, $conn);

            if (!$retval) {
                die('Could not get data: ' . mysql_error());
            }

            while ($row = mysql_fetch_assoc($retval)) {
                echo "<b>Destinatários:</b> <br> <br> ";
                echo nl2br($row['PublicoTarget']);
            }

            mysql_close($conn);
            ?>
            <br><Hr style="border-top: 1px solid #ccc;"><br>

            <?php
            include 'db_config.php';

            $conn = mysql_connect($servername, $username, $password);

            if (!$conn) {
                die('Could not connect: ' . mysql_error());
            }

            $teste2 = $_POST['name'];
            $sql = "SELECT Conteudos FROM cursos WHERE CC = '$teste2'";
            mysql_select_db('acadprof_inqdemo');
            $retval = mysql_query($sql, $conn);

            if (!$retval) {
                die('Could not get data: ' . mysql_error());
            }

            while ($row = mysql_fetch_assoc($retval)) {
                echo "<b>Conteúdo:</b> <br> <br> ";
                echo nl2br($row['Conteudos']);
            }

            mysql_close($conn);
            ?>

            <br>

        </div>
        <div class="tab-pane fade" id="service-four">
<!--            <br>
            <h4>
                Preços e Descontos
            </h4>
            
            <br>
-->
            <?php
            include 'db_config.php';

            $conn = mysql_connect($servername, $username, $password);

            if (!$conn) {
                die('Could not connect: ' . mysql_error());
            }

            $teste2 = $_POST['name'];

            $sql = "SELECT preco FROM cursos WHERE CC = '$teste2'";
            mysql_select_db('acadprof_inqdemo');
            $retval = mysql_query($sql, $conn);

            if (!$retval) {
                die('Could not get data: ' . mysql_error());
            }

            while ($row = mysql_fetch_assoc($retval)) {
                echo nl2br("Valor: {$row['preco']}€ + IVA à taxa legal em vigor");
            }

            mysql_close($conn);
            ?>
        </div>
        <div class="tab-pane fade" id="service-five">
<!--            <br>
                <h1>Acreditação</h1>
-->                
			<div class="even_tab">
                <div class="span12">
                    <?php
                    include 'db_config.php';
                    $conn = mysql_connect($servername, $username, $password);
                    if (!$conn) {
                        die('Could not connect: ' . mysql_error());
                    }
                    mysql_select_db('acadprof_inqdemo');
                    $acreditacoes = mysql_query("SELECT * FROM cursos WHERE CC = '$teste2'") or die(mysql_error());
// If results
                    if (mysql_num_rows($acreditacoes) > 0)
                        ?>
                   <div class="row">
						
                               <?php while ($acreditacoe = mysql_fetch_array($acreditacoes)) : ?>
        					<table id="contact-list"  style="margin-left:20px; margin-top:15px; width: 20%;">   
        					<?php if(!empty($acreditacoe['acreditacoes']) ){ ?>           
    								<tr ><b ><?php echo ($acreditacoe['NomeCurso']); ?></b></tr>
    								<tr style="vertical-align: baseline;" class="text-center">
    	                               <td class="acreditacoes" ><?php echo ($acreditacoe['acreditacoes']); ?></td>
    								</tr>

    								<Hr style="border-top: 1px solid #ccc;">
    								<tr  class="text-left">
    								<td class="requisitos" >
    								   <ul>
    								   <b>
    									Requisitos:
    								</b>
    								   <li><?php echo ($acreditacoe['Info']); ?>
    								   </li>
    								   </ul>
    								   </td>
    								</tr>
    						<?php } ?>	
    						</table>
                 <?php endwhile; ?>

                          
        </div>
    </div>
</div>
</Hr></ul></td></tr></Hr></tr></table></div>
    <div class="tab-pane fade in" id="service-six">
<!--            <br>
            <h1>Esclarecimentos da Inscrição</h1>

            <br>
-->            
            <?php
            include 'db_config.php';

            $conn = mysql_connect($servername, $username, $password);

            if (!$conn) {
                die('Could not connect: ' . mysql_error());
            }

            $teste2 = $_POST['name'];

            $sql = "SELECT Info FROM cursos WHERE CC = '$teste2'";
            mysql_select_db('acadprof_inqdemo');
            $retval = mysql_query($sql, $conn);

            if (!$retval) {
                die('Could not get data: ' . mysql_error());
            }

            while ($row = mysql_fetch_assoc($retval)) {
                echo nl2br("{$row['Info']}");
            }

            mysql_close($conn);
            ?>
        </div>


    </div>