<section id="contact-page">
   <div class="container">
      <div class="center">
         <h2>Contacte-nos</h2>
         <p class="lead">Entraremos em contacto logo que nos seja possível. Muito obrigado!</p>
      </div>
      <div class="row contact-wrap">
         <?php if (!empty($error)) : ?>
         <div class="alert alert-danger" ><?= $error; ?></div>
         <div class="status alert alert-success" style="display: none" aria-label="close"></div>
         <?php endif; ?>
         <form class="contact-form" name="contact-form" method="post" action="<?= base_url(); ?>empresa/pedidocontacto">
            <div class="col-sm-5 col-sm-offset-1">
               <div class="form-group">
                  <label>Nome</label>
                  <input type="text" name="name" class="form-control" value="<?= $name ?>" required="required">
               </div>
               <div class="form-group">
                  <label>Email</label>
                  <input type="email" name="email" class="form-control" value="<?= $email ?>" required="required">
               </div>
               <div class="form-group">
                  <label>Contacto Telefónico</label>
                  <input type="text" name="phone" class="form-control" value="<?= $phone ?>" required="required">
               </div>
            </div>
            <div class="col-sm-5">
               <div class="form-group">
                  <label>Assunto</label>
                  <input type="text" name="subject" class="form-control" value="<?= $subject ?>" required="required">
               </div>
               <div class="form-group">
                  <label>Mensagem</label>
                  <textarea name="message" id="message" required="required" class="form-control" rows="8"><?= $message ?></textarea>
               </div>
               <div class="form-group">
                  <button type="submit" name="submit" class="btn btn-primary btn-lg" required="required">Enviar Mensagem</button>
               </div>
            </div>
         </form>
      </div>
      <!--/.row-->
   </div>
   <!--/.container-->
</section>
