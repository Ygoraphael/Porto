<div class="main-agileits">
    <h1>Preenchimento VIP</h1>
    <div class="register-form">
        <form method="post">
            <div class="fields-grid">
                <div class="styled-input">
                    <span class="fa fa-user" aria-hidden="true"></span>
                    <input type="text" placeholder="Nome" name="nome" required="" value="<?= $cliente["nome"]; ?>">
                </div>
                <div class="styled-input">
                    <span class="fa fa-calendar" aria-hidden="true"></span>
                    <input id="datepicker" placeholder="Data Nascimento" name="date" type="text" value="" onfocus="this.value = '';" onblur="if (this.value == '') { this.value = 'dd/mm/yyyy'; }" required="">
                </div>
                <div class="styled-input agile-styled-input-top">
                    <span class="fa fa-venus" aria-hidden="true"></span>
                    <select class="category2" required="">
                        <option value="">Género</option>
                        <option value="">Feminino</option>
                        <option value="">Masculino</option>
                    </select>
                </div>
                <div class="styled-input">
                    <span class="fa fa-envelope-o" aria-hidden="true"></span>
                    <input type="email" placeholder="Email" name="email" required="">
                </div>
                <div class="styled-input">
                    <span class="fa fa-phone" aria-hidden="true"></span>
                    <input type="text" placeholder="Telefone" name="telefone" required="">
                </div>
                <div class="styled-input agile-styled-input-top">
                    <span class="fa fa-book" aria-hidden="true"></span>
                    <select class="category2" required="">
                        <option value="">Tipo de identificação</option>
                        <option value="">Cartão Cidadão</option>
                        <option value="">Passaporte</option>
                        <option value="">Bilhete de Identidade</option>
                    </select>
                </div>
                <div class="styled-input-2">
                    <label class="header">Morada</label>
                    <div class="styled-input">
                        <input type="text" name="morada" placeholder="Morada" title="Preencher a morada" required="">
                    </div>
                    <div class="styled-input">
                        <input type="text" name="local" placeholder="Localidade" title="Preencher a localidade" required="">
                    </div>
                    <div class="styled-input">
                        <input type="text" name="codpost" placeholder="Código Postal" title="Preencher o código postal" required="">
                    </div>
                </div>
                <div class="clear"> </div>
            </div>
            <input type="submit" value="Enviar">
        </form>
    </div>
