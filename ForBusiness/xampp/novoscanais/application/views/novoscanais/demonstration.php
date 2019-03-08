<section id="phccs">
    <div class="container">
        <div class="col-lg-7 col-lg-offset-5">
            <div >
                <h1 style="" class="phccs" ></h1>
            </div>
        </div><!--/.row-->
    </div><!--/.container-->
    <a  id="down" class="btn btn-down">
        <i class="fa fa-angle-down animated infinite "></i>
    </a>
</section><!--/#services-->
<section id="contact-page" style="margin-top: 100px;">
    <div id="test" class="container ">
        <div class="center">
            <h2>Pedido de Demostração Grátis</h2>
            <p class="lead">Entraremos em contato com você o mais breve possível, muito obrigado.</p>
        </div>
        <div class="row contact-wrap">
            <?php if ($error === '') { ?>
                <div class="alert alert-danger" style="display: none"></div>
            <?php } else { ?>
                <div class="alert alert-danger" ><?php echo $error; ?></div>
            <?php } ?>
            <div class="status alert alert-success" style="display: none" aria-label="close"></div>
            <form  class="contact-form" name="contact-form" method="post" action="<?php echo base_url(); ?>Nc/enviar_mail">
                <div class="col-sm-5 col-sm-offset-1">
                    <div class="form-group">
                        <label>Nome *</label>
                        <input type="text" name="name" class="form-control" value="<?php echo $nome; ?>" required="required">
                    </div>
                    <div class="form-group">
                        <label>Email *</label>
                        <input type="email" name="email" class="form-control" value="<?php echo $email; ?>" required="required">
                    </div>
                    <div class="form-group">
                        <label>Telemóvel *</label>
                        <input type="text" name="telemovel" class="form-control" value="<?php echo $telemovel; ?>"required="required">
                    </div>
                    <div class="form-group">
                        <label>Nome Parceiro</label>
                        <input type="text" name="parceiro" class="form-control" value="<?php echo $parceiro; ?>"required="required">
                    </div>
                </div>
                <div class="col-sm-5">
                    <div class="form-group">
                        <label>Sujeito *</label>
                        <input type="text" name="subject" class="form-control" value="<?php echo $subject; ?>"required="required">
                    </div>
                    <div class="form-group">
                        <label>Mensagem *</label>
                        <textarea name="message" id="message" required="required" class="form-control" rows="8"><?php echo $message; ?> </textarea>
                    </div>
                    <div class="form-group">
                        <button type="submit" name="submit" class="btn btn-primary btn-lg" required="required">Enviar Mensagem</button>
                    </div>
                </div>
            </form>
        </div><!--/.row-->
    </div><!--/.container-->
</section>
