<?php

namespace App\Dao;

use Cosmos\System\Dao;

class Monitor extends Dao {

    function __construct($company = null) {
        $this->set_db = 'company';
        $this->name_db = \App\Model\Company::getCompany()->getData_base();
        parent::__construct($this);
    }

    public function listing() {
        return $this->selectAll(['deleted' => ['=', 0]]);
    }

    public function getQuantityMonitor($type) {
        //previsto mes seguinte - survey
        if ($type == 1) {
            $query = $this->getQuantityMonitorNextMonthQuery("survey");
        }
        //previsto mes seguinte - safety walk
        else if ($type == 2) {
            $query = $this->getQuantityMonitorNextMonthQuery("safetywalk");
        }
        //previsto mes seguinte - dialogue
        else if ($type == 3) {
            $query = $this->getQuantityMonitorNextMonthQuery("securitydialogweek");
        }
        //ultimos 30 dias - survey
        else if ($type == 4) {
            $query = $this->getQuantityMonitorLastMonthQuery("Survey", "SurveyAnswer");
        }
        //ultimos 30 dias - safety walk
        else if ($type == 5) {
            $query = $this->getQuantityMonitorLastMonthQuery("SafetyWalk", "SafetyWalkAnswer");
        }
        //ultimos 30 dias - dialogue
        else if ($type == 6) {
            $query = $this->getQuantityMonitorLastMonthQuery("SecurityDialogWeek", "SecurityDialogAnswer");
        }
        //ultimos 3 meses - survey
        else if ($type == 7) {
            $query = $this->getQuantityMonitorLast3MonthQuery("Survey", "SurveyAnswer");
        }
        //ultimos 3 meses - safety walk
        else if ($type == 8) {
            $query = $this->getQuantityMonitorLast3MonthQuery("SafetyWalk", "SafetyWalkAnswer");
        }
        //ultimos 3 meses - dialogue
        else if ($type == 9) {
            $query = $this->getQuantityMonitorLast3MonthQuery("SecurityDialogWeek", "SecurityDialogAnswer");
        }
        //month actual survey
        else if ($type == 10) {
            $query = $this->getQuantityMonitorMonthQuery('Survey', 'Survey');
        }
        //month actual Safety Walk
        else if ($type == 11) {
            $query = $this->getQuantityMonitorMonthQuery('SafetyWalk', 'SafetyWalk');
        }

        //month actual Security Dialogue
        else if ($type == 12) {
            $query = $this->getQuantityMonitorMonthQuerySD();
        }
        $this->result = $this->querybuild($query);
        return $this->result;
    }

    private function getQuantityMonitorMonthQuery($value, $value2) {
        $query = "	
            SELECT id" . $value2 . ", created_at as data ,qtt ,type, profile
            FROM " . $value . "
            WHERE deleted = 0
            AND MONTH(created_at) <= MONTH(CURDATE()) AND YEAR(created_at) <= YEAR(CURDATE())
        ";
        return $query;
    }

    private function getQuantityMonitorMonthQuerySD() {
        $query = "
            SELECT sd.profile, sdw.week
            FROM 
                SecurityDialog sd
                inner join SecurityDialogWeek sdw on sd.idSecurityDialog = sdw.securitydialog
            WHERE
                sdw.week != ''
	";
        return $query;
    }

    private function getQuantityMonitorLast3MonthQuery($value, $value2) {
        $query = "
        select x.monName, ifnull(y.total, 0) total
        from
        (
            SELECT MONTHNAME(DATE_SUB(curdate(), INTERVAL 3 MONTH)) as monName
            UNION ALL
            SELECT MONTHNAME(DATE_SUB(curdate(), INTERVAL 2 MONTH)) as monName
            UNION ALL
            SELECT MONTHNAME(DATE_SUB(curdate(), INTERVAL 1 MONTH)) as monName
        ) x
        left join 
        (
            select COUNT(sa.id" . $value2 . ") total, MONTHNAME(STR_TO_DATE(MONTH(sa.created_at), '%m')) monName
            from
                Notification n
                inner join " . $value2 . " sa on n.value2 = sa.id" . $value2 . "
            where
                table1 = '" . $value . "' and
                table2 = '" . $value2 . "' and
                sa.created_at BETWEEN DATE_FORMAT(DATE_SUB(LAST_DAY(NOW()), INTERVAL 2 MONTH),'%Y-%m-01') AND LAST_DAY(NOW())
            group by
                monName
        ) y on x.monName = y.monName
        ";
        return $query;
    }

    private function getQuantityMonitorLastMonthQuery($value, $value2) {
        $query = "
        select sa.id" . $value2 . ", sa.created_at
        from
            Notification n
            inner join " . $value2 . " sa on n.value2 = sa.id" . $value2 . "
        where
            table1 = '" . $value . "' and
            table2 = '" . $value2 . "' and
            MONTH(sa.created_at)= MONTH(CURDATE())
        ";
        return $query;
    }

    private function getQuantityMonitorNextMonthQuery($value) {
        $query = "
        select value1, date_limit
        from
            Notification n
        where
            table1 = '" . $value . "' and
            isnull(table2) = 1 and
            date_limit BETWEEN NOW() AND DATE_ADD(NOW(), INTERVAL 30 DAY)
        ";
        return $query;
    }

    public function getQualityMonitor($sector, $datei, $datef) {
        if (is_null($sector)) {
            $sector = 0;
        }

        $datei = ( is_null($datei) ? date("Y-m-d 00:00:00", strtotime("-1 months")) : $datei . " 00:00:00" );
        $datef = ( is_null($datef) ? date("Y-m-d 23:59:59", time()) : $datef . " 23:59:59" );

        $query = "
            select x.category_name, y.*, x.total_answers, (y.positive_answers / x.total_answers) * 100 percent
            from
            (
                select 
                    sq.category category,
                    c.name category_name,
                    COUNT(sq.category) total_answers
                from
                    Survey s
                    inner join SurveyQuestion sq on s.idSurvey = sq.survey
                    inner join SurveyAnswer sa on s.idSurvey = sa.survey
                    inner join SurveyAnswerQuestion saq on sa.idSurveyAnswer = saq.survey_answer and sq.idSurveyQuestion = saq.survey_question
                    inner join Category c on sq.category = c.idCategory
                where
                    saq.value in (0,1) and  
                    sq.type = 'matrix' and
                    sa.created_at between '" . $datei . "' and '" . $datef . "' and
        ";

        if ($sector > 0) {
            $query .= "sa.sector = " . $sector . " and ";
        }

        $query .= "sa.deleted = 0
                group by 
                    sq.category
            ) x
            inner join 
            (
                select 
                    sq.category category, 
                    COUNT(saq.value) positive_answers
                from
                    Survey s
                    inner join SurveyQuestion sq on s.idSurvey = sq.survey
                    inner join SurveyAnswer sa on s.idSurvey = sa.survey
                    inner join SurveyAnswerQuestion saq on sa.idSurveyAnswer = saq.survey_answer and sq.idSurveyQuestion = saq.survey_question
                where
                    saq.value = 1 and 
                    sq.type = 'matrix' and
                    sa.created_at between '" . $datei . "' and '" . $datef . "' and
        ";

        if ($sector > 0) {
            $query .= "sa.sector = " . $sector . " and ";
        }

        $query .= "sa.deleted = 0
                group by 
                    sq.category, saq.value
            ) y on x.category = y.category
        ";

        $this->result = $this->querybuild($query);
        return $this->result;
    }
    
    public function getInsecuritiesMonitorAdmin() {
        $query = "
        select *
        from
            Insecurity i
        where
            i.deleted = 0
        order by
            created_at desc
        limit 5
        ";
        $this->result = $this->querybuild($query);
        return $this->result;
    }
    
    public function getInsecuritiesMonitorUser($value) {
        $query = "
        select i.*
        from
            Insecurity i
            inner join Notification n on i.idInsecurity = n.value1 and n.table1 = 'insecurity'
        where
            n.user = " . $value . " and i.deleted = 0
        order by
            i.created_at desc
        limit 5
        ";

        $this->result = $this->querybuild($query);
        return $this->result;
    }
    
    

}
