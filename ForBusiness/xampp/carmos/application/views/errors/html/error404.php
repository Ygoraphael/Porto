<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="pt">
    <head>
        <meta charset="utf-8">
        <link href="<?= base_url() ?>css/bootstrap3/bootstrap.min.css" rel="stylesheet">
        <link href="<?= base_url() ?>css/bootstrap3/bootstrap-glyphicons.css" rel="stylesheet">
        <style type="text/css">
            body, html {
                height: 100%;
            }

            .bg { 
                /* The image used */
                background-image: url("<?= base_url() ?>images/sleep404.jpg");
                height: 100%; 
                background-position: center;
                background-repeat: no-repeat;
                background-size: cover;
            }
            .error-template {padding: 40px 15px;text-align: center;}
            .error-actions {margin-top:15px;margin-bottom:15px;}
            .error-actions .btn { margin-right:10px; }
            .caption {
                position: absolute;
                left: 0;
                top: 25%;
                width: 100%;
                text-align: center;
                color: white;
                text-shadow: 1px 1px 4px #000;
            }
        </style>
        <title>Oops! Erro 404</title>
    </head>
    <body>
        <div class="bg"></div>
        <div class="container">
            <div class="row caption">
                <div class="col-xs-12">
                    <div class="error-template">
                        <h1>Oh não, encontrou a página do nosso programador júnior!</h1>
                        <h2>
                            Apesar de dormir no sofá a maior parte do dia, o nosso programador júnior ainda encontra tempo para fazer alguma programação…
                        </h2>
                        <div class="error-actions">
                            <a href="<?= base_url() ?>" class="btn btn-primary btn-lg"><span class="glyphicon glyphicon-chevron-right"></span> 
                                VOLTAR À PÁGINA INICIAL
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>