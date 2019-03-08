<html>
<head>

<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="css/bootstrap-theme.css">
<link rel="stylesheet" type="text/css" href="css/bootstrap-theme.min.css">

    <!-- Custom CSS -->
    <link href="css/modern-business.css" rel="stylesheet">
    <link href="css/number.css" rel="stylesheet">
    <link href="css/accor.css" rel="stylesheet">
    <link href="css/active2.css" rel="stylesheet">

        <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

    <script src="js/accor.js"></script>

<style>
label{display:inline-block;width:100px;margin-bottom:10px;}
</style>
 
 
<title>Páginda do Curso</title>
</head>
<body>
        <!-- Service Tabs -->
        <div class="row" style="background-color: white; padding-bottom: 25px;">
            <div class="col-lg-12">
                <h1 class="page-header">
<?php
  
  include 'db_config.php';


$teste2=$_POST['name'];   
   $conn = mysql_connect($servername, $username, $password);
   
   if(! $conn ) {
      die('Could not connect: ' . mysql_error());
   }

 $teste2=$_POST['name'];   
   $sql = "SELECT NomeCurso FROM cursos WHERE CC = '$teste2'";
   mysql_select_db('acadprof_inqdemo');
   $retval = mysql_query( $sql, $conn );
   
   if(! $retval ) {
      die('Could not get data: ' . mysql_error());
   }
   
   while($row = mysql_fetch_assoc($retval)) {
      echo nl2br($row['NomeCurso']);
   }
   
   mysql_close($conn);
?>






                </h1>
            </div>
            <div class="col-lg-12">

                <ul id="myTab" class="nav nav-tabs nav-justified">
                    <li class="active"><a href="#service-one" data-toggle="tab"><i class=""></i>Apresentação do Curso</a>
                    </li>
               
                    <li class=""><a href="#service-two" data-toggle="tab"><i class=""></i>Requisitos</a>
                    </li>
        
                    
                    <li class=""><a href="#service-three" data-toggle="tab"><i class=""></i>Cronograma</a>
                    </li>
<!--                    <li class=""><a href="#service-four" data-toggle="tab"><i class="fa fa-database"></i> Software</a>
                    </li>
-->                    
                </ul>

                <div id="myTabContent" class="tab-content" style="">
                    <div class="tab-pane fade active in" id="service-one">
                    <br>


<?php
  include 'db_config.php';
   
   $conn = mysql_connect($servername, $username, $password);
   
   if(! $conn ) {
      die('Could not connect: ' . mysql_error());
   }

$teste2=$_POST['name']; 

   $sql = "SELECT Contexto FROM cursos WHERE CC = '$teste2'";
   mysql_select_db('acadprof_inqdemo');
   $retval = mysql_query( $sql, $conn );
   
   if(! $retval ) {
      die('Could not get data: ' . mysql_error());
   }
   
   while($row = mysql_fetch_assoc($retval)) {
      echo "Contexto <br><br>";
      echo nl2br($row['Contexto']);
   }
   
   mysql_close($conn);
?>

<br>---------<br>

<?php
  include 'db_config.php';
   
   $conn = mysql_connect($servername, $username, $password);
   
   if(! $conn ) {
      die('Could not connect: ' . mysql_error());
   }

   $teste2=$_POST['name']; 
   $sql = "SELECT Objectivos FROM cursos WHERE CC = '$teste2'";
   mysql_select_db('acadprof_inqdemo');
   $retval = mysql_query( $sql, $conn );
   
   if(! $retval ) {
      die('Could not get data: ' . mysql_error());
   }
   
   while($row = mysql_fetch_assoc($retval)) {
     echo "Objectivos : <br> <br> ";
    echo nl2br($row['Objectivos']);
   }
   
   mysql_close($conn);
?>

<br>---------<br>

<?php
  include 'db_config.php';
   
   $conn = mysql_connect($servername, $username, $password);
   
   if(! $conn ) {
      die('Could not connect: ' . mysql_error());
   }

 $teste2=$_POST['name'];  
   $sql = "SELECT PublicoTarget FROM cursos WHERE CC = '$teste2'";
   mysql_select_db('acadprof_inqdemo');
   $retval = mysql_query( $sql, $conn );
   
   if(! $retval ) {
      die('Could not get data: ' . mysql_error());
   }
   
   while($row = mysql_fetch_assoc($retval)) {
    echo "Destinatários : <br> <br> ";
      echo nl2br($row['PublicoTarget']);
   }
   
   mysql_close($conn);
?>

                       
			            <br>
			            <br>


                       


                    </div>

                    <div class="tab-pane fade" id="service-two">
                    <br>
                        
<?php
  include 'db_config.php';
   
   $conn = mysql_connect($servername, $username, $password);
   
   if(! $conn ) {
      die('Could not connect: ' . mysql_error());
   }
$teste2=$_POST['name'];
   
   $sql = "SELECT Info FROM cursos WHERE CC = '$teste2'";
   mysql_select_db('acadprof_inqdemo');
   $retval = mysql_query( $sql, $conn );
   
   if(! $retval ) {
      die('Could not get data: ' . mysql_error());
   }
   
   while($row = mysql_fetch_assoc($retval)) {
    echo "Requisitos: <br>  <br> ";
      echo nl2br($row['Info']);
   }
   
   mysql_close($conn);
?>

                        
                    </div>

                    <div class="tab-pane fade" id="service-three">
                    <br>
                        <h5>Cronograma</h5>
<div class="container even_tab">
    
        <div class="row divider_row ">
  
                     <div>


					<?php

  include 'db_config.php';
					   
					   $conn = mysql_connect($servername, $username, $password);
					   
					   if(! $conn ) {
					      die('Could not connect: ' . mysql_error());
					   }


$teste2=$_POST['name'];
					mysql_select_db('acadprof_inqdemo');

                    $contacts = mysql_query("
                        SELECT * FROM acoes WHERE RefCurso = '$teste2'") or die( mysql_error() );

                    // If results
                    if( mysql_num_rows( $contacts ) > 0 )
                    ?>

                    <table id="contact-list">
                        <thead>
                            <tr>
                                <th>Nome Ação</th>
                                <th>Data Início</th>
                                <th>Data Fim</th>
                                <th>Nº Sessões</th>
                                <th>Info</th>
                                <th>Cronograma</th>
                                <th>Localidade</th>
                                <th>Morada</th>
                                <th>Formato</th>
                                <th>Informações Adicionais</th>


                  				<th>Inscrição</th>
                  				<th>Mais informações</th>
                            </tr>
                        </thead>
                        <tbody>

                        <?php while( $contact = mysql_fetch_array( $contacts ) ) : ?>



                            <tr>
                                <td class="contact-name"><?php echo nl2br($contact['NomeAcao']); ?></td>
                                <td class="contact-email"><?php echo nl2br($contact['DataInicio']); ?></td>
                                <td class="contact-telephone"><?php echo nl2br($contact['DataFim']); ?></td>
                                <td class="contact-address"><?php echo nl2br($contact['Sessoes']); ?></td>
                                <td class="contact-address"><?php echo nl2br($contact['Info']); ?></td>
                                <td class="contact-address"><?php echo nl2br($contact['Horario']); ?></td>
                                <td class="contact-address"><?php echo nl2br($contact['Localidade']); ?></td>
                                <td class="contact-address"><?php echo nl2br($contact['Morada']); ?></td>
                                <td class="contact-address"><?php echo nl2br($contact['Formato']); ?></td>
                                <td class="contact-address"><?php echo nl2br($contact['Info']); ?></td>


                                <td class="inscricao">
								    <form action='inscricao10.php?name="<?php echo $teste2; ?>"' method="post">
								        <input type="hidden" name="name" value="<?php echo $teste2; ?>">
                        <input type="hidden" name="acao" value="<?php echo $contact['NomeAcao']; ?>">
								        <input type="submit" name="submit" value="Inscrever">
								    </form>
								</td>

								<td class="info">
								    <a href="contact.php">Pedir mais informações</a>
								</td>




                            </tr>

                        <?php endwhile; ?>

                        </tbody>
                    </table>








    
    
    

</div>
                        
                        
                    </div>



                </div>

            </div>
        </div>


 
</body>
</html>