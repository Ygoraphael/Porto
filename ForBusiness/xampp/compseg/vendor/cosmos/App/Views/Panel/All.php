<?php

if (isset($_POST["params"]))
    $params = $_POST["params"];
else
    $params = array();

use Cosmos\System\Template;

$tpl = new Template(APP_PATH_TPL . 'panel/all.html');

$m1_sd = date("Y-m-d", strtotime("-1 months"));
$m1_ed = date("Y-m-d", time());
$m1_s = 0;

if ($params) {
    $params = json_decode(rawurldecode($params), true);

    if ($params["m1_sd"]) {
        $m1_sd = $params["m1_sd"] . " 00:00:00";
    }
    if ($params["m1_ed"]) {
        $m1_ed = $params["m1_ed"] . " 23:59:59";
    }
    if ($params["m1_s"]) {
        $m1_s = $params["m1_s"];
    }
}

$tpl->mon1_sd = substr($m1_sd, 0, 10);
$tpl->mon1_ed = substr($m1_ed, 0, 10);

$parameters = [
    'deleted' => ['=', 0]
];
$sectors = (new \App\Model\Sector())->listingRegisters($parameters);
if (!empty($sectors)) {
    foreach ($sectors as $sector) {
        if ($sector->getId() == $m1_s) {
            $tpl->select_sector = 'SELECTED';
        } else {
            $tpl->clear('select_sector');
        }
        $tpl->SECTOR = $sector;
        $tpl->block('BLOCK_SECTOR');
    }
}

$user = App\Model\User::getUserLoged();
$parameters = [
    'deleted' => ['=', 0, 'AND'],
    'profile' => ['=', $user->getProfile(), 'AND'],
    'status' => ['=', 1]
];
$pms = (new \App\Model\ProfileMonitor())->listingRegisters($parameters);
if (!empty($pms)) {
    foreach ($pms as $pm) {
        switch ($pm->getMonitor()) {
            case 1:
                $data = (new \App\Model\Monitor())->getQualityMonitor($m1_s, $m1_sd, $m1_ed);
                if (!empty($data)) {
                    $cur = 0;
                    foreach ($data as $monqual) {
                        $icon = \Cosmos\System\Helper::getMonitorQualidadeStatus($monqual->percent);
                        $monqual->icon = $icon->icon;
                        $monqual->color = $icon->color;

                        $tpl->MONQUAL = $monqual;
                        $tpl->block('BLOCK_MONITORQUALIDADE');
                    }
                } else {
                    $tpl->block('BLOCK_NORESULTS_MONITORQUALIDADES');
                }
                $tpl->block('BLOCK_MONITORQUALIDADES');
                break;
            case 2:
                $qm_sw = (new \App\Model\Monitor())->getQuantityMonitor(5);
                $qm_sd = (new \App\Model\Monitor())->getQuantityMonitor(6);
                $qm_su = (new \App\Model\Monitor())->getQuantityMonitor(4);

                if (!empty($qm_sw)) {
                    $tpl->lastmonthsw = count($qm_sw);
                } else {
                    $tpl->lastmonthsw = 0;
                }

                if (!empty($qm_sd)) {
                    $tpl->lastmonthsd = count($qm_sd);
                } else {
                    $tpl->lastmonthsd = 0;
                }

                if (!empty($qm_su)) {
                    $tpl->lastmonthsu = count($qm_su);
                } else {
                    $tpl->lastmonthsu = 0;
                }

                $qm_sw = (new \App\Model\Monitor())->getQuantityMonitor(2);
                $qm_sd = (new \App\Model\Monitor())->getQuantityMonitor(3);
                $qm_su = (new \App\Model\Monitor())->getQuantityMonitor(1);

                $qm_sw = (new \App\Model\Monitor())->getQuantityMonitor(8);
                $qm_sd = (new \App\Model\Monitor())->getQuantityMonitor(9);
                $qm_su = (new \App\Model\Monitor())->getQuantityMonitor(7);

                if (!empty($qm_sw)) {
                    $tpl->last3monthsw = $qm_sw[0]->total;
                    $tpl->last2monthsw = $qm_sw[1]->total;
                    $tpl->last1monthsw = $qm_sw[2]->total;

                    $tpl->last3month = substr((new \App\Model\Translate())->translater($qm_sw[2]->monName), 0, 3);
                    $tpl->last2month = substr((new \App\Model\Translate())->translater($qm_sw[1]->monName), 0, 3);
                    $tpl->last1month = substr((new \App\Model\Translate())->translater($qm_sw[0]->monName), 0, 3);
                } else {
                    $tpl->last3monthsw = 0;
                    $tpl->last2monthsw = 0;
                    $tpl->last1monthsw = 0;
                }

                if (!empty($qm_sd)) {
                    $tpl->last3monthsd = $qm_sd[0]->total;
                    $tpl->last2monthsd = $qm_sd[1]->total;
                    $tpl->last1monthsd = $qm_sd[2]->total;
                } else {
                    $tpl->last3monthsd = 0;
                    $tpl->last2monthsd = 0;
                    $tpl->last1monthsd = 0;
                }

                if (!empty($qm_su)) {
                    $tpl->last3monthsu = $qm_su[0]->total;
                    $tpl->last2monthsu = $qm_su[1]->total;
                    $tpl->last1monthsu = $qm_su[2]->total;
                } else {
                    $tpl->last3monthsu = 0;
                    $tpl->last2monthsu = 0;
                    $tpl->last1monthsu = 0;
                }

                $tpl->block('BLOCK_MONITORQUANTIDADES');
                break;
            case 3:
                //$user->getProfile()
                $data = (new \App\Model\Monitor())->getInsecuritiesMonitorAdmin();

                if (!empty($data)) {
                    foreach ($data as $monins) {
                        $status = \Cosmos\System\Helper::getStatus($monins->status);
                        $monins->status = $status->status;
                        $monins->urlimg = '/assets/images/upload/';
                        $monins->status_class = $status->alert;
                        $monins->IMG = $monins->img;
                        $monins->RESUMO = $monins->resumo;

                        $ID = (int) $monins->idInsecurity;
                        $parameters = [
                            'value1' => ['=', $ID, 'AND'],
                            'table1' => ['=', 'insecurity']
                        ];
                        $notifications = (new \App\Model\Notification())->listingRegisters($parameters);
                        if (!empty($notifications)) {
                            foreach ($notifications as $notification) {
                                $user_id = $notification->getUser();
                                $user = (New App\Model\User())->fetch($user_id);
                                $monins->USER3 = $user->getName();
                                $monins->USER4 = $user->getlast_name();
                            }
                        } else {
                            $monins->USER3 = "";
                            $monins->USER4 = "";
                        }

                        $tpl->MONINS = $monins;
                        $tpl->block('BLOCK_MONITORINSEGURANCA');
                    }
                } else {
                    $tpl->block('BLOCK_NORESULTS_MONITORINSEGURANCAS');
                }
                $tpl->block('BLOCK_MONITORINSEGURANCAS');
                break;
            case 4:
                $user = App\Model\User::getUserLoged();
                $data = (new \App\Model\Monitor())->getInsecuritiesMonitorUser($user->getId());

                if (!empty($data)) {
                    foreach ($data as $monins) {
                        $status = \Cosmos\System\Helper::getStatus($monins->status);
                        $monins->status = $status->status;
                        $monins->urlimg = '/assets/images/upload/';
                        $monins->status_class = $status->alert;
                        $monins->IMG = $monins->img;
                        $monins->RESUMO = $monins->resumo;

                        $ID = (int) $monins->idInsecurity;
                        $parameters = [
                            'value1' => ['=', $ID, 'AND'],
                            'table1' => ['=', 'insecurity']
                        ];
                        $notifications = (new \App\Model\Notification())->listingRegisters($parameters);
                        if (!empty($notifications)) {
                            foreach ($notifications as $notification) {
                                $user_id = $notification->getUser();
                                $user = (New App\Model\User())->fetch($user_id);
                                $monins->USER3 = $user->getName();
                                $monins->USER4 = $user->getlast_name();
                            }
                        } else {
                            $monins->USER3 = "";
                            $monins->USER4 = "";
                        }

                        $tpl->MONINSUSER = $monins;
                        $tpl->block('BLOCK_MONITORINSEGURANCAUSER');
                    }
                } else {
                    $tpl->block('BLOCK_NORESULTS_MONITORINSEGURANCASUSER');
                }
                $tpl->block('BLOCK_MONITORINSEGURANCASUSER');
                break;
        }
    }
}

//** Final do mes	
$valorf_sv = 0;
$valorf_sd = 0;
$valorf_sw = 0;
$month = date('m');
$year = date('Y');
$day = date("d", mktime(0, 0, 0, $month + 1, 0, $year));
$dayEnd = date('d', mktime(0, 0, 0, $month, $day, $year));

$firtsWeek = date("W", mktime(0, 0, 0, $month, 1, $year));
$LastWeek = date("W", mktime(0, 0, 0, $month, $dayEnd, $year));

$months = array();
$months['impar'] = array(1, 3, 5, 7, 9, 11);
$months['par'] = array(2, 4, 6, 8, 10, 12);

//** survey the month 
$mact_sv = (new \App\Model\Monitor())->getQuantityMonitor(10);
if ($mact_sv) {
    $valor1 = 0;
    $valor2 = 0;
    $valor3 = 0;
    $valor4 = 0;
    foreach ($mact_sv as $ma_sv) {
        $type = $ma_sv->type;
        $qtt = $ma_sv->qtt;
        $profile = $ma_sv->profile;
        $created_at = $ma_sv->data;
        $dayCreated = substr($created_at, 8, 2);
        $mesCreated = substr($created_at, 5, 2);
        $anoCreated = substr($created_at, 0, 4);
        $week = date('W', mktime(0, 0, 0, $mesCreated, $dayCreated, $anoCreated));
        $users = \App\Model\User::getCompanyUsers(\App\Model\Company::getCompany());
        if ($users) {
            $qttProfile = 0;
            foreach ($users as $user) {
                $user_s = (new \App\Model\User())->fetch($user->user);
                if ($user_s->getProfile() == $profile) {
                    $qttProfile++;
                }
            }
        }
        switch ($type) {
            case 1:
                $week_sv = $week;
                $d = $dayCreated;
                $QttType = 0;
                while ($week_sv <= $LastWeek) {
                    $week_sv = $week_sv + 1;
                    $QttType = $QttType + 1;
                }

                $valor = $qtt * $QttType * $qttProfile;
                $valor1 = $valor1 + $valor;
                break;
            case 2:
                $valor = $qtt * $qttProfile;
                $valor2 = $valor2 + $valor;
                break;
            case 3:
                if (in_array($mesCreated, $months['par'])) {
                    $valor = $qtt * $qttProfile;
                    $valor3 = $valor3 + $valor;
                } else {
                    $valor3 = $valor3;
                }
                break;
            case 4:
                if (in_array($mesCreated, $months['impar'])) {
                    $valor = $qtt * $qttProfile;
                    $valor4 = $valor4 + $valor;
                } else {
                    $valor4 = $valor4;
                }
                break;
        }
    }$valorf_sv = $valor1 + $valor2 + $valor3 + $valor4;
}

//** Safety Walk the month 
$mact_sv = (new \App\Model\Monitor())->getQuantityMonitor(11);
if ($mact_sv) {
    $valor1 = 0;
    $valor2 = 0;
    $valor3 = 0;
    $valor4 = 0;

    foreach ($mact_sv as $ma_sv) {
        $type = $ma_sv->type;
        $qtt = $ma_sv->qtt;
        $profile = $ma_sv->profile;
        $created_at = $ma_sv->data;
        $dayCreated = substr($created_at, 8, 2);
        $mesCreated = substr($created_at, 5, 2);
        $users = \App\Model\User::getCompanyUsers(\App\Model\Company::getCompany());
        if ($users) {
            $qttProfile = 0;
            foreach ($users as $user) {
                $user_s = (new \App\Model\User())->fetch($user->user);
                if ($user_s->getProfile() == $profile) {
                    $qttProfile++;
                }
            }
        }
        switch ($type) {
            case 1:
                $d = $dayCreated;
                $QttType = 0;
                while ($d < $dayEnd) {
                    $d = $d + 7;
                    $QttType = $QttType + 1;
                }

                $valor = $qtt * $QttType * $qttProfile;
                $valor1 = $valor1 + $valor;
                break;
            case 2:
                $valor = $qtt * $qttProfile;
                $valor2 = $valor2 + $valor;
                break;
            case 3:
                if (in_array($mesCreated, $months['par'])) {
                    $valor = $qtt * $qttProfile;
                    $valor3 = $valor3 + $valor;
                } else {
                    $valor3 = $valor3;
                }
                break;
            case 4:
                if (in_array($mesCreated, $months['impar'])) {
                    $valor = $qtt * $qttProfile;
                    $valor4 = $valor4 + $valor;
                } else {
                    $valor4 = $valor4;
                }
                break;
        }
    }$valorf_sw = $valor1 + $valor2 + $valor3 + $valor4;
}
//** Sacurity Dialogue the month 
$mact_sd = (new \App\Model\Monitor())->getQuantityMonitor(12);
if ($mact_sd) {
    $valor1 = 0;
    foreach ($mact_sd as $ma_sd) {
        $week = $ma_sd->week;
        $profile = $ma_sd->profile;
        $users = \App\Model\User::getCompanyUsers(\App\Model\Company::getCompany());
        if ($users) {
            $qttProfile = 0;
            foreach ($users as $user) {
                $user_s = (new \App\Model\User())->fetch($user->user);
                if ($user_s->getProfile() == $profile) {
                    $qttProfile++;
                }
            }
        }
        if ($week >= $firtsWeek && $week <= $LastWeek) {
            $valor = $qttProfile;
            $valor1 = $valor1 + $valor;
        }
    }$valorf_sd = $valor1;
}


$MONTH = date("F");
$tpl->MONTH = "%%" . $MONTH . "%%";
$tpl->nextmonthsu = $valorf_sv;
$tpl->nextmonthsw = $valorf_sw;
$tpl->nextmonthsd = $valorf_sd;
$tpl->show();

