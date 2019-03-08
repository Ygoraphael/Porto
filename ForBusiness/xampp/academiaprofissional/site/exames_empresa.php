<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width">
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
  <title>Email formando</title>
  <style>
  body{
    font-family: Arial, sans-serif;
  }
  table {
    border-collapse: collapse;
    width: 80%;
}

th{
	border:1px solid #eaeaea;
    text-align: left;
    padding: 8px;
}
.teste{
  color:#828282;
  text-decoration:none;
  font-size: 20px;
  margin-left: 100px;
  padding: 12px;
}
  </style>
</head>
<body>
  <nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header teste">
      <a class="teste" href="#">Academia do Profissional</a>
    </div>

  </div>
</nav>
<div class="container">
  <div class="row">
    <div class="col-sm-1">

    </div>
    <div class="col-sm-10">
<br><br>
<p>Bom dia,</p> <?php $cliente ?> <p> Parabéns, inscreveu-se na simulação de testes online. </p> <br>
<p>Exame Inscrito: </p>
<br>
<p>Deverá efetuar o pagamento de ________ , para o seguinte <strong>IBAN: PT 50 0269 0666 0020 8629788</strong> - Bankinter ( L. Teixeira & Melo, Lda. )</p><br>
<p>Após a transferência deverá enviar o comprovativo via email para: geral@academiadoprofissional.com</p>
<p>Após boa cobrança enviaremos via email os dados de acesso à respetiva plataforma para poder iniciar o seu estudo</p>
<br>
<br>
<br>
<p>Cumprimentos,</p>
<p>Academia do Profissional</p>

</div>
<div class="col-sm-1">

</div>
</div>
</div>

</body>
</html>
