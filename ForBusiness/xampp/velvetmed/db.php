<?php

$connection = null;

function mssql__connect() {
    //SQL Servers
    global $connection;
    $server = "novoscanais.ddns.net, 24116";
    $database = "Velvet_Med";
    $user = "sa";
    $password = "sa2016++.";

    $connection = odbc_connect("Driver={SQL Server Native Client 11.0};Server=$server;Database=$database;", $user, $password);

    if (!$connection) {
        die(print_r(sqlsrv_errors(), true));
    }
}

function utf8ize($d) {
    if (is_array($d)) {
        foreach ($d as $k => $v) {
            $d[$k] = utf8ize($v);
        }
    } else if (is_string($d)) {
        return utf8_encode($d);
    }
    return $d;
}

function mssql__select($query) {
    mssql__connect();
    global $connection;
    $query = iconv("UTF-8", "CP1252", $query);
    $results = odbc_exec($connection, $query);

    if (odbc_num_rows($results)) {
        $data = [];
        while ($dados_tmp = odbc_fetch_array($results)) {
            $data[] = $dados_tmp;
        }

        return utf8ize($data);
    } else {
        $data = [];
        return utf8ize($data);
    }
}

function mssql__execute($query) {
    mssql__connect();
    global $connection;
    odbc_exec($connection, $query) or die(odbc_errormsg());
}

?>