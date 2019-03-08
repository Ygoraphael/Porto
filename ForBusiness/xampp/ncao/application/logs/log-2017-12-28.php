ERROR - 2017-12-28 16:33:20 --> Severity: Notice --> Undefined property: Dashboard::$cl_model D:\dev\rc\application\controllers\Dashboard.php 17
ERROR - 2017-12-28 16:33:20 --> Severity: error --> Exception: Call to a member function get_ranking_clientes_divida() on null D:\dev\rc\application\controllers\Dashboard.php 17
ERROR - 2017-12-28 16:34:41 --> Severity: Notice --> Undefined property: Dashboard::$cl_model D:\dev\rc\application\controllers\Dashboard.php 17
ERROR - 2017-12-28 16:34:41 --> Severity: error --> Exception: Call to a member function get_ranking_clientes_divida() on null D:\dev\rc\application\controllers\Dashboard.php 17
ERROR - 2017-12-28 16:34:54 --> Severity: Notice --> Undefined property: Dashboard::$dashboard_model D:\dev\rc\application\controllers\Dashboard.php 17
ERROR - 2017-12-28 16:34:54 --> Severity: error --> Exception: Call to a member function get_ranking_clientes_divida() on null D:\dev\rc\application\controllers\Dashboard.php 17
ERROR - 2017-12-28 16:35:03 --> Severity: Notice --> Undefined variable: stamp D:\dev\rc\application\controllers\Dashboard.php 17
ERROR - 2017-12-28 16:35:03 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '50
                cc.moeda, 
                cc.nome, cc.no, 
                s' at line 1 - Invalid query: 
            select top 50
                cc.moeda, 
                cc.nome, cc.no, 
                sum(cc.edeb) as edeb, sum(cc.ecred) as ecred,
                sum(cc.edebf) as edebf, sum(cc.ecredf) as ecredf,
                sum((cc.edeb-cc.edebf-(cc.ecred-cc.ecredf))) esaldo
            from cc 
            where (cc.edeb-cc.edebf-(cc.ecred-cc.ecredf))<>0 
            group by cc.nome,cc.moeda,cc.no
            order by esaldo desc
        
ERROR - 2017-12-28 16:35:03 --> Language file contains no data: language/portuguese/db_lang.php
ERROR - 2017-12-28 16:35:03 --> Could not find the language line "db_error_heading"
ERROR - 2017-12-28 16:35:09 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '50
                cc.moeda, 
                cc.nome, cc.no, 
                s' at line 1 - Invalid query: 
            select top 50
                cc.moeda, 
                cc.nome, cc.no, 
                sum(cc.edeb) as edeb, sum(cc.ecred) as ecred,
                sum(cc.edebf) as edebf, sum(cc.ecredf) as ecredf,
                sum((cc.edeb-cc.edebf-(cc.ecred-cc.ecredf))) esaldo
            from cc 
            where (cc.edeb-cc.edebf-(cc.ecred-cc.ecredf))<>0 
            group by cc.nome,cc.moeda,cc.no
            order by esaldo desc
        
ERROR - 2017-12-28 16:35:09 --> Language file contains no data: language/portuguese/db_lang.php
ERROR - 2017-12-28 16:35:09 --> Could not find the language line "db_error_heading"
