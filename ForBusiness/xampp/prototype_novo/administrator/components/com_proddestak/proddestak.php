<form method="post" name="adminForm" id="adminForm">
    <h4>Produtos em Destaque</h4>
    <table>
        <tbody>
            <tr>
                <td align="left" width="100%">
                    Procurar: <input type="text" />
                    <button onclick="novo_produto(); return false;">+ Novo</button>
                    <button onclick="apaga_produtos(); return false;">Apagar</button>
                </td>
                <td nowrap="nowrap">
                </td>
            </tr>
        </tbody>
    </table>
    <div id="tablecell">
        <table class="adminlist">
            <thead>
                <tr>
                    <th width="2%">
                        <input type="checkbox" id="toggle" value="">
                    </th>
                    <th style="text-align: left;" width="10%">
                        Referência                    
                    </th>
                    <th style="text-align: left;">
                        Designação
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr class="row0">
                    <td>
                        <input type="checkbox" id="cb0" name="cid[]" value="3" title="Checkbox for row 1">                    
                    </td>
                    <td>
                        ABC0001
                    </td>
                    <td>
                        Área Clientes
                    </td>
                </tr>
                <tr class="row1">
                    <td>
                        <input type="checkbox" id="cb1" name="cid[]" value="4" title="Checkbox for row 2">                    
                    </td>
                    <td>
                        ABC0002
                    </td>
                    <td>
                        Menu Topo PT
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <input type="hidden" name="task" value="">
    <input type="hidden" name="option" value="com_jumi">
    <input type="hidden" name="controller" value="application">
    <input type="hidden" name="boxchecked" value="0">
    <input type="hidden" name="filter_order" value="m.id">
    <input type="hidden" name="filter_order_Dir" value="">
</form>
<table class="adminlist" style="width: 100%;margin-top: 12px;">
    <tbody>
        <tr>
            <td align="center" valign="middle" id="jumi_td" style="">
                <a href="http://novoscanais.com" style="font-size: 12px;" target="_blank"><a href="http://novoscanais.com" target="_blank">Novoscanais</a>
            </td>
        </tr>
    </tbody>
</table>
<script>
    function novo_produto() {
        
    }
    
    function apaga_produtos() {
        
    }
    
    jQuery('#toggle').click(function (event) {
        if (this.checked) {
            jQuery(".adminlist tbody :checkbox").each(function () {
                this.checked = true;
            });
        } else {
            jQuery(".adminlist tbody :checkbox").each(function () {
                this.checked = false;
            });
        }
    });
</script>
<div class="clr"></div>