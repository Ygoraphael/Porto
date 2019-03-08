<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * User_model class.
 * 
 * @extends CI_Model
 */
class Nci_model extends CI_Model {

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

    public function getU_ncius($params) {
        $update_values = array();
        $where_array = array();

        $query = "	
            select *
            from u_ncius
            inner join us on u_ncius.usercode = us.usercode
        ";

        if (isset($params["usstamp"])) {
            $where_array[] = " usstamp = '" . $params["usstamp"] . "' ";
        }

        if (sizeof($where_array)) {
            $where = implode("AND", $where_array);

            if (substr($where, -3) == "AND")
                $where = substr($where, 0, strlen($where) - 3);

            $query .= "where " . $where;
        }

        $query .= "
            order by us.usercode
        ";

        $sql_status = $this->mssql->mssql__prepare_sel($query, $update_values);
        return $sql_status;
    }

    public function get_all($table) {
        $query = "	
            select *
            from u_ncius
            inner join us on u_ncius.usercode = us.usercode
        ";

        $sql_status = $this->mssql->mssql__prepare_sel($query, $update_values);
        return $sql_status;
    }

    public function getU_ncidef($params = array()) {
        $update_values = array();

        $query = "	
            select *
            from u_ncidef
        ";

        $sql_status = $this->mssql->mssql__prepare_sel($query, $update_values);
        return $sql_status;
    }

    public function update($params) {
        $query = "
            BEGIN TRANSACTION [Tran1];
            BEGIN TRY ";
        $update_values = array();

        foreach ($params["data"] as $tab => $dad) {
            $values = array();

            $query .= "	
                update {$tab} set 
            ";

            foreach ($params["data"][$tab] as $key => $value) {
                $update_values[] = trim($value);
                $values[] = "{$key} = ?";
            }

            $values = implode(", ", $values);
            $query .= $values;

            $update_values[] = $params["data"][$tab][$tab . "stamp"];
            $query .= " where {$tab}stamp = ? ";
        }

        $query .= "
            COMMIT TRANSACTION [Tran1] 
            END TRY 
            BEGIN CATCH 
            ROLLBACK TRANSACTION [Tran1] 
            PRINT ERROR_MESSAGE() 
            END CATCH
        ";

        $sql_status = $this->mssql->mssql__prepare_exec($query, $update_values);
        return $sql_status;
    }

    public function createNciUsers() {
        $query = "
            BEGIN TRANSACTION [Tran1];
            BEGIN TRY
            
            CREATE TABLE u_ncius(
                [u_nciusstamp] [char](25) NOT NULL,
                [usercode] [char](20) NOT NULL,
                [ponto] [bit] NOT NULL default 0,
                [picking] [bit] NOT NULL default 0,
                [tarefas] [bit] NOT NULL default 0,
                [ousrdata] [datetime] NOT NULL default GETDATE(),
                [ousrhora] [varchar](8) NOT NULL default '',
                [ousrinis] [varchar](30) NOT NULL default '',
                [usrdata] [datetime] NOT NULL default GETDATE(),
                [usrhora] [varchar](8) NOT NULL default '',
                [usrinis] [varchar](30) NOT NULL default '',
                [u_pass] [varchar](55) NOT NULL default '',
                [ativo] [bit] NOT NULL default 0
            ) ON [PRIMARY]

            COMMIT TRANSACTION [Tran1] 
            END TRY 
            BEGIN CATCH 
            ROLLBACK TRANSACTION [Tran1] 
            PRINT ERROR_MESSAGE() 
            END CATCH
        ";

        $sql_status = $this->mssql->mssql__execute($query);
        return $sql_status;
    }

    public function updateNciUsers() {
        $query = "	
            select *
            from us
            where usercode not in (select usercode from u_ncius)
        ";

        $users = $this->mssql->mssql__select($query);
        $sql_status = 1;

        if (count($users)) {
            foreach ($users as $user) {
                $query = "
                    BEGIN TRANSACTION [Tran1];
                    BEGIN TRY

                    INSERT INTO u_ncius (u_nciusstamp, usercode, ousrdata, ousrhora, ousrinis, usrdata, usrhora, usrinis) VALUES 
                    (
                        (select left(suser_sname(),5)+left(newid(),5)+right(newid(),5)+ left(newid(),5)+right(newid(),5)),
                        '" . $user["usercode"] . "',
                        convert(date, getdate()), 
                        left(convert(time, getdate()),8),
                        isnull((select iniciais from us (nolock) where username = suser_sname()), ''),
                        convert(date, getdate()), 
                        left(convert(time, getdate()),8),
                        isnull((select iniciais from us (nolock) where username = suser_sname()), '')
                    )

                    COMMIT TRANSACTION [Tran1] 
                    END TRY 
                    BEGIN CATCH 
                    ROLLBACK TRANSACTION [Tran1] 
                    PRINT ERROR_MESSAGE() 
                    END CATCH
                ";

                $sql_status = $this->mssql->mssql__execute($query);
            }
        }

        $query = "	
            select usercode
            from u_ncius
            where usercode not in (select usercode from us)
        ";

        $users = $this->mssql->mssql__select($query);

        if (count($users)) {
            foreach ($users as $user) {
                $query = "
                    BEGIN TRANSACTION [Tran1];
                    BEGIN TRY

                    DELETE FROM u_ncius
                    WHERE usercode = '" . $user["usercode"] . "',

                    COMMIT TRANSACTION [Tran1] 
                    END TRY 
                    BEGIN CATCH 
                    ROLLBACK TRANSACTION [Tran1] 
                    PRINT ERROR_MESSAGE() 
                    END CATCH
                ";

                $sql_status = $this->mssql->mssql__execute($query);
            }
        }


        return $sql_status;
    }

    public function createNciDef() {
        $query = "
            BEGIN TRANSACTION [Tran1];
            BEGIN TRY
            
            CREATE TABLE u_ncidef (
                [u_ncidefstamp] [char](25) NOT NULL,
                [ponto] bit NOT NULL default 0,
                [picking] bit NOT NULL default 0,
                [tarefas] bit NOT NULL default 0,
                [emailserver] [char](254) NOT NULL default '',
                [emailuser] [char](254) NOT NULL default '',
                [emailpw] [char](254) NOT NULL default '',
                [emailenc] [numeric](3, 0) NOT NULL default 0,
                [emailport] [numeric](3, 0) NOT NULL default 0,
                [emailfrom] [char](254) NOT NULL default '',
                [ndosponto] [numeric](3, 0) NOT NULL default 0,
                [ndostarefas] [numeric](3, 0) NOT NULL default 0,
                [ndostarefasreg] [numeric](3, 0) NOT NULL default 0,
                [ndospicking] [numeric](3, 0) NOT NULL default 0,
                [tarefastipo] [numeric](3, 0) NOT NULL default 1,
                [tarefascampo] [char](254) NOT NULL default '',
                [tarefastabela] [char](254) NOT NULL default '',
                [iniciar_tarefas] bit NOT NULL default 0,
				[pontotipo] [numeric](3, 0) NOT NULL default 0,
				[pontotabela] [char](254) NOT NULL default '',
				[tarefa_registo_stipo] [numeric](3, 0) NOT NULL default 0,
				[registotarefas] [char](254) NOT NULL default '',
				[registotarefaslinhas] [char](254) NOT NULL default '',
                [keypad] bit NOT NULL default 0,
                [ousrdata] [datetime] NOT NULL default '',
                [ousrhora] [varchar](8) NOT NULL default '',
                [ousrinis] [varchar](30) NOT NULL default '',
                [usrdata] [datetime] NOT NULL default '',
                [usrhora] [varchar](8) NOT NULL default '',
                [usrinis] [varchar](30) NOT NULL default ''
                
            )

            INSERT INTO u_ncidef (u_ncidefstamp, ousrdata, ousrhora, ousrinis, usrdata, usrhora, usrinis) VALUES 
            (
                (select left(suser_sname(),5)+left(newid(),5)+right(newid(),5)+ left(newid(),5)+right(newid(),5)),
                convert(date, getdate()), 
                left(convert(time, getdate()),8),
                isnull((select iniciais from us (nolock) where username = suser_sname()), ''),
                convert(date, getdate()), 
                left(convert(time, getdate()),8),
                isnull((select iniciais from us (nolock) where username = suser_sname()), '')
            )

            COMMIT TRANSACTION [Tran1] 
            END TRY 
            BEGIN CATCH 
            ROLLBACK TRANSACTION [Tran1] 
            PRINT ERROR_MESSAGE() 
            END CATCH
        ";

        $sql_status = $this->mssql->mssql__execute($query);
        return $sql_status;
    }

    public function createNciTabelaPonto($params) {
        $query = "
            BEGIN TRANSACTION [Tran1];
            BEGIN TRY
            
            CREATE TABLE " . $params["table"] . " (
                [" . $params["table"] . "stamp] [char](25) NOT NULL,
                [usstamp] [char](25) NOT NULL,
                [codcart] [char](254) NOT NULL default '',
                [nome] [char](55) NOT NULL default '',
                [ativo] [char](1) NOT NULL default '',
                [ousrdata] [datetime] NOT NULL,
                [ousrhora] [varchar](30) NOT NULL,
                [ousrinis] [varchar](30) NOT NULL,
                [usrdata] [datetime] NOT NULL,
                [usrhora] [varchar](30) NOT NULL,
                [usrinis] [varchar](30) NOT NULL
            ) ON [PRIMARY]

            COMMIT TRANSACTION [Tran1] 
            END TRY 
            BEGIN CATCH 
            ROLLBACK TRANSACTION [Tran1] 
            PRINT ERROR_MESSAGE() 
            END CATCH
        ";

        $sql_status = $this->mssql->mssql__execute($query);
        return $sql_status;
    }

    public function createNciTabelaTarefas($params) {
        $query = "
            BEGIN TRANSACTION [Tran1];
            BEGIN TRY
            
            CREATE TABLE " . $params["table"] . " (
                [" . $params["table"] . "stamp] [varchar](25) NOT NULL,
                [ref] [varchar](18) NOT NULL default '',
                [design] [varchar](60) NOT NULL default '',
                [imagem] [varchar](60) NOT NULL default '',
                [inactivo] [char](1) NOT NULL default '',
                [ousrdata] [datetime] NOT NULL,
                [ousrhora] [varchar](30) NOT NULL,
                [ousrinis] [varchar](30) NOT NULL,
                [usrdata] [datetime] NOT NULL,
                [usrhora] [varchar](30) NOT NULL,
                [usrinis] [varchar](30) NOT NULL
            ) ON [PRIMARY]
            
            COMMIT TRANSACTION [Tran1] 
            END TRY 
            BEGIN CATCH 
            ROLLBACK TRANSACTION [Tran1] 
            PRINT ERROR_MESSAGE() 
            END CATCH
        ";

        $sql_status = $this->mssql->mssql__execute($query);
        return $sql_status;
    }

    public function createNciTabelaTarefasRegisto($params) {
        $query = "
            BEGIN TRANSACTION [Tran1];
            BEGIN TRY
            
            CREATE TABLE " . $params["table"] . " (
                [" . $params["table"] . "stamp] [char](25) NOT NULL,
                [codcart] [char](25) NOT NULL default '',
                [usercode] [char](25) NOT NULL default '',
                [ativo] [char](1) NOT NULL default '',
                [ousrdata] [datetime] NOT NULL,
                [ousrhora] [varchar](30) NOT NULL,
                [ousrinis] [varchar](30) NOT NULL,
                [usrdata] [datetime] NOT NULL,
                [usrhora] [varchar](30) NOT NULL,
                [usrinis] [varchar](30) NOT NULL,
                [horaini] [varchar](30) NOT NULL default '',
                [horafechado] [varchar](30) NOT NULL default ''
            ) ON [PRIMARY]

            COMMIT TRANSACTION [Tran1] 
            END TRY 
            BEGIN CATCH 
            ROLLBACK TRANSACTION [Tran1] 
            PRINT ERROR_MESSAGE() 
            END CATCH
        ";

        $sql_status = $this->mssql->mssql__execute($query);
        return $sql_status;
    }
    
    public function createNciTabelaTarefasRegistoLinhas($params) {
        $query = "
            BEGIN TRANSACTION [Tran1];
            BEGIN TRY
            
            CREATE TABLE " . $params["table"] . " (
                    [" . $params["table"] . "stamp] [char](25) NOT NULL DEFAULT (''),
                    [tarefastamp] [char](25) NOT NULL DEFAULT (''),
                    [ststamp] [char](25) NOT NULL DEFAULT (''),
                    [ref] [varchar](125) NOT NULL DEFAULT (''),
                    [qtt] [decimal](16, 2) NOT NULL DEFAULT (''),
                    [ativo] [int] NOT NULL DEFAULT ('0'),
                    [ousrdata] [datetime] NOT NULL DEFAULT (''),
                    [ousrhora] [varchar](30) NOT NULL DEFAULT (''),
                    [ousrinis] [varchar](30) NOT NULL DEFAULT (''),
                    [usrdata] [datetime] NOT NULL DEFAULT (''),
                    [usrhora] [varchar](30) NOT NULL DEFAULT (''),
                    [usrinis] [varchar](30) NOT NULL DEFAULT ('')
            ) ON [PRIMARY]

            COMMIT TRANSACTION [Tran1] 
            END TRY 
            BEGIN CATCH 
            ROLLBACK TRANSACTION [Tran1] 
            PRINT ERROR_MESSAGE() 
            END CATCH
        ";

        $sql_status = $this->mssql->mssql__execute($query);
        return $sql_status;
    }

}
