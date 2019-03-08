<section id="intro" class="intro" style="background-image: url(<?= base_url() ?>images/contactos.png)">
    <div class="slogan">
        <h2>Contacte-nos</h2>
        <h4>Procuraremos esclarecer todas as suas dúvidas<span style="color:red;"></h4>
    </div>
    <div class="page-scroll">
        <a id="gotocont" id="" class="btn btn-circle">
            <i class="fa fa-angle-double-down animated hvr-float"></i>
        </a>
    </div>
</section>
<section id="contact-page">
<div class="container tc" style="text-align:center; color:black;">
  <h1 style="text-align:center; color:black;">Selecione o motivo pelo qual nos está a contactar</h1>
    <br><br>
<div class="row">
  <div class="col-md-4 wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="1000ms" >
      <div class="feature-wrap">
          <div class="row" style="text-align: center;">
              <div class="col-sm-12">
                  <a href="<?php echo base_url(); ?>contactos/pedido_demo">
                    <i class="fa fa-desktop" aria-hidden="true"></i>
                  </a>
              </div>
              <div class="col-sm-12 reset-contact">
                  <h3><b>Pedido de Demonstração</b></h3>
                  <h4>Requisite a demonstração do seu produto</h4>
                  <div class="form-group">
                    <form class="" action="<?php echo base_url(); ?>contactos/pedido_demo" method="post">
                      <br>
                        <center><button type="submit" name="submit" class="btn btn-primary btn-lg">Enviar Mensagem</button></center>
                    </form>
                  </div>
              </div>
          </div>
      </div>
  </div>
  <div class="col-md-4 wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="1000ms" >
      <div class="feature-wrap">
          <div class="row">
              <div class="col-sm-12">
              <a  href="<?php echo base_url(); ?>contactos/pedido_demo">
              <i class="fa fa-info" aria-hidden="true"></i>
              </a>
              </div>
              <div class="col-sm-12 reset-contact">
                  <h3><b>Informações</b></h3>
                  <h4>Requisite a demonstração do seu produto</h4>
                  <div class="form-group">
                    <form class="" action="<?php echo base_url(); ?>contactos/pedido_demo" method="post">
                      <br>
                        <center><button type="submit" name="submit" class="btn btn-primary btn-lg">Enviar Mensagem</button></center>
                    </form>
                  </div>
              </div>
          </div>
      </div>
  </div>
  <div class="col-md-4 wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="1000ms" >
      <div class="feature-wrap">
          <div class="row">
              <div class="col-sm-12">
                  <a href="<?php echo base_url(); ?>contacto">
                    <i class="fa fa-wrench"></i>
                  </a>
              </div>
              <div class="col-sm-12 reset-contact">
                  <h3><b>Suporte Técnico</b></h3>
                  <h4>Ajudamos em todas as dificuldades técnicas</span>
                    <div class="form-group">
                      <form class="" action="<?php echo base_url(); ?>contactos/pedido_demo" method="post">
                            <br><br>
                            <center><button type="submit" name="submit" class="btn btn-primary btn-lg">Enviar Mensagem</button></center>
                      </form>
                    </div>
              </div>
          </div>
      </div>
  </div>
</div>
</div>
</section>
<style>
.reset-contact h3, h4{
text-align: center;
}
.reset-contact h4{
font-size: 16px;
font-weight: lighter;
}
</style>
