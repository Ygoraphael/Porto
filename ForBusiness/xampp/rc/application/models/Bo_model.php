<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Dashboard_model class.
 * 
 * @extends CI_Model
 */
class Bo_model extends CI_Model {

    /**
     * __construct function.
     * 
     * @access public
     * @return void
     */
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function getFilterWhere($where) {
        try {
            $query = $this->db->query("select * from bo where " . $where);
        } catch (Exception $e) {
            return array();
        }

        if ($query)
            $result = $query->result_array();
        else
            $result = array();
        return $result;
    }

    function saveNewBo($di) {
        //verificar se cliente existe, se nao existir, criar
        $super_query = "
            BEGIN TRY
            BEGIN TRANSACTION;

            DECLARE @clstamp VARCHAR(25);
            DECLARE @stamp VARCHAR(25);
            DECLARE @numero INT;
            DECLARE @obrano INT;
            DECLARE @ndos INT;
            DECLARE @no INT;
            DECLARE @estab INT;
            DECLARE @nmdos VARCHAR(24);
            DECLARE @tpstamp VARCHAR(25);
            DECLARE @tpdesc VARCHAR(55);
            DECLARE @etotal decimal(19,6);
            DECLARE @moeda VARCHAR(11);
            DECLARE @nome VARCHAR(55);
            DECLARE @obs VARCHAR(67);
            DECLARE @obstab2 NVARCHAR(MAX);
            DECLARE @vendedor INT;
            DECLARE @vendnm VARCHAR(20);
            DECLARE @morada VARCHAR(55);
            DECLARE @ncont VARCHAR(20);
            DECLARE @local VARCHAR(43);
            DECLARE @codpost VARCHAR(45);
            DECLARE @email VARCHAR(100);
            DECLARE @telefone VARCHAR(60);
            
            SET @stamp = CONVERT(VARCHAR(25), (select 'WEBAP'+left(newid(),5)+right(newid(),5)+ left(newid(),5)+right(newid(),5)));
            SET @clstamp = CONVERT(VARCHAR(25), (select 'WEBAP'+left(newid(),5)+right(newid(),5)+ left(newid(),5)+right(newid(),5)));
            
            SET @no = " . $di->bo["no"] . ";
            SET @estab = 0;
            SET @numero = isnull((select max(no) + 1 from cl where estab = @estab), 1);
            SET @nome = '" . $di->bo["nome"] . "';
            SET @morada = '" . $di->bo["morada"] . "';
            SET @ncont = '" . $di->bo["ncont"] . "';
            SET @local = '" . $di->bo["local"] . "';
            SET @codpost = '" . $di->bo["codpost"] . "';
            SET @email = '" . $di->bo["email"] . "';
            SET @telefone = '" . $di->bo["telefone"] . "';
            
            IF @no = 0
            BEGIN
                INSERT INTO CL (clstamp, no, estab, nome, morada, ncont, local, codpost, email, telefone, vendedor, vendnm)
                VALUES 
                (
                    @clstamp,
                    @numero,
                    @estab,
                    @nome,
                    @morada,
                    @ncont,
                    @local,
                    @codpost,
                    @email,
                    @telefone,
                    @vendedor,
                    @vendnm
                )
                SET @no = @numero;
            END
            
            SET @ndos = " . $di->bo["ndos"] . ";
            SET @nmdos = isnull((select top 1 nmdos from ts where ndos = @ndos), '');
            SET @obrano = isnull((select max(obrano) + 1 from bo where ndos = @ndos and boano = YEAR(GETDATE())), 1);
            SET @moeda = isnull((select top 1 moeda from cl where no = @no and estab = @estab), 'EURO');
            SET @obs = '" . $di->bo["obs"] . "';
            SET @obstab2 = '" . $di->bo["obstab2"] . "';
            SET @vendedor = '" . $di->bo["vendedor"] . "';
            SET @vendnm = isnull((select top 1 cmdesc from cm3 where cm = @vendedor), '');
            SET @etotal = " . $di->bo["etotal"] . ";
            SET @tpstamp = '" . $di->bo["tpstamp"] . "';
            SET @tpdesc = isnull((select top 1 descricao from tp where tpstamp = @tpstamp), '');
        ";

        //criar dossier
        $super_query .= "

            INSERT INTO bo (bostamp, nmdos, ndos, no, estab, obrano, boano, dataobra, nome, morada, local, codpost, ncont, tpstamp, tpdesc, memissao, moeda, origem, etotal, etotaldeb, obs, obstab2, vendedor, vendnm, ousrinis, ousrdata, ousrhora, usrinis, usrdata, usrhora)
            VALUES
            (
                @stamp,
                @nmdos,
                @ndos,
                @no,
                0,
                @obrano,
                YEAR(GETDATE()),
                CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000',
                @nome,
                isnull((select morada from cl where no = @no and estab = @estab),''),
                isnull((select local from cl where no = @no and estab = @estab),''),
                isnull((select codpost from cl where no = @no and estab = @estab),''),
                isnull((select ncont from cl where no = @no and estab = @estab),''),
                @tpstamp,
                @tpdesc,
                'EURO',
                'EURO',
                'WEBAPP',
                @etotal,
                @etotal,
                @obs,
                @obstab2,
                @vendedor,
                @vendnm,
                UPPER(suser_sname()),
                CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000',
                CONVERT(VARCHAR(5), GETDATE(), 8),
                UPPER(suser_sname()),
                CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000',
                CONVERT(VARCHAR(5), GETDATE(), 8)
            )

            INSERT INTO bo2 (bo2stamp, idserie, tiposaft, email, telefone, ousrinis, ousrdata, ousrhora, usrinis, usrdata, usrhora)
            VALUES
            (
                @stamp,
                'BO',
                ISNULL((select top 1 tiposaft from ts where ndos = @ndos),''),
                @email,
                @telefone,
                UPPER(suser_sname()),
                CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000',
                CONVERT(VARCHAR(5), GETDATE(), 8),
                UPPER(suser_sname()),
                CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000',
                CONVERT(VARCHAR(5), GETDATE(), 8)
            )
            
            INSERT INTO bo3 (bo3stamp, ousrinis, ousrdata, ousrhora, usrinis, usrdata, usrhora)
            VALUES
            (
                @stamp,
                UPPER(suser_sname()),
                CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000',
                CONVERT(VARCHAR(5), GETDATE(), 8),
                UPPER(suser_sname()),
                CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000',
                CONVERT(VARCHAR(5), GETDATE(), 8)
            )
	";

        $ordem = 10000;

        foreach ($di->bi as $bi) {
            $super_query .= "
		INSERT INTO bi (bistamp, bostamp, nmdos, ndos, no, estab, obrano, rdata, ref, design, qtt, desconto, armazem, lordem, unidade, epcusto, epu, edebito, ettdeb, tabiva, iva, stipo, rescli, resfor, resrec, resusr, vendedor, vendnm, ousrinis, ousrdata, ousrhora, usrinis, usrdata, usrhora)
		values
		(
                    CONVERT(VARCHAR(25), (select UPPER(suser_sname())+left(newid(),5)+right(newid(),5)+ left(newid(),5)+right(newid(),5))),
                    @stamp,
                    @nmdos,
                    @ndos,
                    @no,
                    @estab,
                    @obrano,
                    CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000',
                    '" . $bi["ref"] . "',
                    '" . $bi["design"] . "',
                    " . $bi["qtt"] . ",
                    " . $bi["desconto"] . ",
                    1,
                    " . $ordem . ",
                    isnull((select unidade from st where ref = '" . $bi["ref"] . "'),''),
                    isnull((select epcult from st where ref = '" . $bi["ref"] . "'),0),
                    " . $bi["edebito"] . ",
                    " . $bi["edebito"] . ",
                    " . $bi["ettdeb"] . ",
                    isnull((select tabiva from st where ref = '" . $bi["ref"] . "'), 0),
                    isnull((select taxa from taxasiva where codigo = (select tabiva from st where ref = '" . $bi["ref"] . "')), 0),
                    1,
                    isnull((select rescli from ts where ndos =@ndos),0),
                    isnull((select resfor from ts where ndos =@ndos),0),
                    isnull((select resrec from ts where ndos =@ndos),0),
                    isnull((select resusr from ts where ndos =@ndos),0),
                    @vendedor,
                    @vendnm,
                    UPPER(suser_sname()),
                    CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000',
                    CONVERT(VARCHAR(5), GETDATE(), 8),
                    UPPER(suser_sname()),
                    CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000',
                    CONVERT(VARCHAR(5), GETDATE(), 8)
		)
	";
            $ordem += 10000;
        }
        $super_query .= "

            COMMIT;
            END TRY
            BEGIN CATCH
                IF @@TRANCOUNT > 0
                    ROLLBACK
            END CATCH
        ";

        return $this->mssql->mssql__execute($super_query);
    }

}
