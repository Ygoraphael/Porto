<?php

namespace App\Dao;

use Cosmos\System\Dao;

class Company extends Dao {

    private $company;
    private $config;
    private $user;
    private $result;

    function __construct() {
        $this->user = \App\Model\User::getUserLoged();
        parent::__construct($this);
    }

    public function createDatabaseCompany($company, $user, $config) {
        $this->company = $company;
        $this->config = $config;
        $this->user = $user;
        $this->createDBCompany();
    }

    public function getCompany() {
        $this->queryCompany();
        return $this->result;
    }

    public function getDataCompany() {
        $this->getData();
    }

    private function queryCompany() {
        $this->result = $this->querybuild("SELECT c.idCompany as id, c.data_base, c.language FROM Company as c
        INNER JOIN UserLicense as ul ON c.idCompany=ul.company
        WHERE ul.user={$this->user->getId()}")[0];
    }

    private function getData() {
        $this->result = $this->querybuild("SELECT c.data_base, l.code FROM Company as c
        INNER JOIN License as l ON c.license=l.idLicense
        INNER JOIN UserLicense as ul ON c.idCompany=ul.company
        INNER JOIN User as u ON ul.user=u.idUser
        WHERE u.idUser={$this->user->getId()}");
    }

    private function createDBCompany() {
        $this->create_database = "/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
        /*!40101 SET NAMES utf8 */;
        /*!50503 SET NAMES utf8mb4 */;
        /*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
        /*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

        CREATE DATABASE IF NOT EXISTS `{$this->company->getData_base()}` /*!40100 DEFAULT CHARACTER SET utf8 */;
        USE `{$this->company->getData_base()}`;";
        if (parent::createDatabase()) {
            $this->createConfig();
        }
    }

    private function createConfig() {
        $this->create_database = "CREATE TABLE IF NOT EXISTS `Config` (
          `idConfig` int(11) NOT NULL AUTO_INCREMENT,
          `name` varchar(50) NOT NULL,
		  `created_at` datetime DEFAULT NULL,
		  `deleted_at` datetime DEFAULT NULL,
		  `deleted` int(11) DEFAULT '0',
          PRIMARY KEY (`idConfig`)
        ) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
		
        DELETE FROM `Config`;
		 
        /*!40000 ALTER TABLE `Config` DISABLE KEYS */;
        INSERT INTO `Config` (`idConfig`, `name`) VALUES (1, '{$this->config->getName()}');
        /*!40000 ALTER TABLE `Config` ENABLE KEYS */;";
        if (parent::createDatabase()) {
            $this->createFactory();
        }
    }

    private function createFactory() {
        $this->create_database = "CREATE TABLE IF NOT EXISTS `Factory` (
          `idFactory` int(11) NOT NULL AUTO_INCREMENT,
          `name` varchar(50) NOT NULL,
          `status` int(11) NOT NULL,
		  `created_at` datetime DEFAULT NULL,
		  `deleted_at` datetime DEFAULT NULL,
		  `deleted` int(11) DEFAULT NULL,
          PRIMARY KEY (`idFactory`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

        DELETE FROM `Factory`;
		
        /*!40000 ALTER TABLE `Factory` DISABLE KEYS */;
        /*!40000 ALTER TABLE `Factory` ENABLE KEYS */;";
        if (parent::createDatabase()) {
            $this->createFactoryUser();
        }
    }

    private function createFactoryUser() {
        $this->create_database = "CREATE TABLE IF NOT EXISTS `FactoryUser` (
        `idFactoryUser` int(11) NOT NULL AUTO_INCREMENT,
        `user` int(11) NOT NULL,
        `factory` int(11) NOT NULL,
        `created_at` datetime DEFAULT NULL,
        `deleted_at` datetime DEFAULT NULL,
        `deleted` int(11) DEFAULT NULL,
        PRIMARY KEY (`idFactoryUser`),
        KEY `FK_FactoryUser_User` (`user`),
        KEY `FK_FactoryUser_Factory` (`factory`),
        CONSTRAINT `FK_FactoryUser_Factory` FOREIGN KEY (`factory`) REFERENCES `Factory` (`idFactory`) ON DELETE CASCADE ON UPDATE CASCADE,
        CONSTRAINT `FK_FactoryUser_User` FOREIGN KEY (`User`) REFERENCES `UserCompany` (`idUserCompany`) ON DELETE CASCADE ON UPDATE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
		
        DELETE FROM `FactoryUser`;
		
        /*!40000 ALTER TABLE `FactoryUser` DISABLE KEYS */;
        /*!40000 ALTER TABLE `FactoryUser` ENABLE KEYS */;";
        if (parent::createDatabase()) {
            $this->createSector();
        }
    }

    private function createSector() {
        $this->create_database = "CREATE TABLE IF NOT EXISTS `Sector` (
        `idSector` int(11) NOT NULL AUTO_INCREMENT,
        `name` varchar(50) NOT NULL,
        `status` int(11) NOT NULL,
        `factory` int(11) NOT NULL,
        `created_at` datetime DEFAULT NULL,
        `deleted_at` datetime DEFAULT NULL,
        `deleted` int(11) DEFAULT NULL,
        PRIMARY KEY (`idSector`),
        KEY `FK_Sector_Factory` (`factory`),
        CONSTRAINT `FK_Sector_Factory` FOREIGN KEY (`factory`) REFERENCES `Factory` (`idFactory`) ON DELETE CASCADE ON UPDATE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
		
        DELETE FROM `Sector`;
		
        /*!40000 ALTER TABLE `Sector` DISABLE KEYS */;
        /*!40000 ALTER TABLE `Sector` ENABLE KEYS */;";
        if (parent::createDatabase()) {
            $this->createSectorUser();
        }
    }

    private function createSectorUser() {
        $this->create_database = "CREATE TABLE IF NOT EXISTS `SectorUser` (
        `idSectorUser` int(11) NOT NULL AUTO_INCREMENT,
        `user` int(11) NOT NULL,
        `sector` int(11) NOT NULL,
        `created_at` datetime DEFAULT NULL,
        `deleted_at` datetime DEFAULT NULL,
        `deleted` int(11) DEFAULT NULL,
        PRIMARY KEY (`idSectorUser`),
        KEY `FK__User` (`user`),
        KEY `FK_SectorUser_Sector` (`sector`),
        CONSTRAINT `FK_SectorUser_Sector` FOREIGN KEY (`sector`) REFERENCES `Sector` (`idSector`) ON DELETE CASCADE ON UPDATE CASCADE,
        CONSTRAINT `FK__User` FOREIGN KEY (`user`) REFERENCES `UserCompany` (`idUserCompany`) ON DELETE CASCADE ON UPDATE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

        DELETE FROM `SectorUser`;
		
        /*!40000 ALTER TABLE `SectorUser` DISABLE KEYS */;
        /*!40000 ALTER TABLE `SectorUser` ENABLE KEYS */;";
        if (parent::createDatabase()) {
            $this->createUser();
        }
    }

    private function createUser() {
        $this->create_database = "CREATE TABLE IF NOT EXISTS `UserCompany` (
        `idUserCompany` int(11) NOT NULL AUTO_INCREMENT,
        `code` int(11) NOT NULL,
        `created_at` datetime DEFAULT NULL,
        `deleted_at` datetime DEFAULT NULL,
        `deleted` int(11) DEFAULT NULL,
        PRIMARY KEY (`idUserCompany`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

        DELETE FROM `UserCompany`;
		
        /*!40000 ALTER TABLE `UserCompany` DISABLE KEYS */;
        /*!40000 ALTER TABLE `UserCompany` ENABLE KEYS */;";
        if (parent::createDatabase()) {
            $this->createSurveyTables();
        }
    }

    private function createSurveyTables() {
        $this->create_database = "CREATE TABLE IF NOT EXISTS `Survey` (
		  `idSurvey` int(11) NOT NULL AUTO_INCREMENT,
		  `code` int(11) DEFAULT NULL,
                  `started_at` datetime NOT NULL,
		  `status` int(11) DEFAULT NULL,
		  `validate` datetime DEFAULT NULL,
		  `type` int(11) NOT NULL,
		  `qtt` int(11) NOT NULL,
                  `last_notification` datetime NOT NULL,
                  `profile` int(11) NOT NULL,
                  `created_at` datetime NOT NULL,
                  `deleted_at` datetime DEFAULT NULL,
		  `deleted` int(11) DEFAULT '0',
		  PRIMARY KEY (`idSurvey`),
		  UNIQUE KEY `code` (`code`)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8;
		
		DELETE FROM `Survey`;
		
		/*!40000 ALTER TABLE `Survey` DISABLE KEYS */;
		/*!40000 ALTER TABLE `Survey` ENABLE KEYS */;

		CREATE TABLE `Category` (
                    `idCategory` int(11) NOT NULL AUTO_INCREMENT,
                    `name` varchar(50) NOT NULL,
                    `status` int(11) NOT NULL,
                    `created_at` datetime DEFAULT NULL,
                    `deleted_at` datetime DEFAULT NULL,
                    `deleted` int(11) DEFAULT NULL,
                    PRIMARY KEY (`idCategory`)
                  ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

                DELETE FROM `Category`;

                /*!40000 ALTER TABLE `Category` DISABLE KEYS */;
                INSERT INTO `Category` (`idCategory`, `name`, `status`, created_at, deleted) VALUES (1, 'NA', 1, NOW(), 0);
                INSERT INTO `Category` (`idCategory`, `name`, `status`, created_at, deleted) VALUES (2, 'Condições', 1, NOW(), 0);
                INSERT INTO `Category` (`idCategory`, `name`, `status`, created_at, deleted) VALUES (3, 'Equipamento e Proteção Individual (EPI)', 1, NOW(), 0);
                INSERT INTO `Category` (`idCategory`, `name`, `status`, created_at, deleted) VALUES (4, 'Práticas e Comportamentos', 1, NOW(), 0);
                INSERT INTO `Category` (`idCategory`, `name`, `status`, created_at, deleted) VALUES (5, 'Práticas Específicas', 1, NOW(), 0);
                /*!40000 ALTER TABLE `Category` ENABLE KEYS */;
		
		CREATE TABLE IF NOT EXISTS `SurveyQuestion` (
		  `idSurveyQuestion` int(11) NOT NULL AUTO_INCREMENT,
		  `survey` int(11) NOT NULL,
		  `type` varchar(50) NOT NULL,
		  `created_at` datetime DEFAULT NULL,
		  `deleted_at` datetime DEFAULT NULL,
		  `deleted` int(11) DEFAULT '0',
		  `category` int(11) DEFAULT NULL,
		  `context` longtext,
		  `ord` int(11) DEFAULT NULL,
		  `code` VARCHAR(50) DEFAULT NULL,
		  `text` LONGTEXT DEFAULT NULL,
		  PRIMARY KEY (`idSurveyQuestion`),
		  KEY `FK_SurveyQuestion_Survey` (`survey`),
		  KEY `FK_SurveyQuestion_SurveyGroup` (`category`),
		  CONSTRAINT `FK_SurveyQuestion_Survey` FOREIGN KEY (`survey`) REFERENCES `Survey` (`idSurvey`) ON DELETE CASCADE ON UPDATE CASCADE,
		  CONSTRAINT `FK_SurveyQuestion_Category` FOREIGN KEY (`category`) REFERENCES `Category` (`idCategory`) ON DELETE CASCADE ON UPDATE CASCADE
		) ENGINE=InnoDB DEFAULT CHARSET=utf8;
		
		DELETE FROM `SurveyQuestion`;
		
		/*!40000 ALTER TABLE `SurveyQuestion` DISABLE KEYS */;
		/*!40000 ALTER TABLE `SurveyQuestion` ENABLE KEYS */;

		CREATE TABLE IF NOT EXISTS `SurveyAnswer` (
		  `idSurveyAnswer` int(11) NOT NULL AUTO_INCREMENT,
		  `user` int(11) DEFAULT NULL,
                  `survey` int(11) DEFAULT NULL,
                  `sector` INT(11) NOT NULL,
                  `content` LONGTEXT NOT NULL,
		  `created_at` datetime DEFAULT NULL,
		  `deleted_at` datetime DEFAULT NULL,
		  `deleted` int(11) DEFAULT '0',
		  PRIMARY KEY (`idSurveyAnswer`)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8;
		
		DELETE FROM `SurveyAnswer`;
		
		/*!40000 ALTER TABLE `SurveyAnswer` DISABLE KEYS */;
		/*!40000 ALTER TABLE `SurveyAnswer` ENABLE KEYS */;
                
                CREATE TABLE IF NOT EXISTS `SurveyAnswerQuestion` (
		  `idSurveyAnswerQuestion` int(11) NOT NULL AUTO_INCREMENT,
                  `survey_answer` int(11) DEFAULT NULL,
		  `survey_question` int(11) DEFAULT NULL,
		  `value` LONGTEXT NOT NULL,
		  `created_at` datetime DEFAULT NULL,
		  `deleted_at` datetime DEFAULT NULL,
		  `deleted` int(11) DEFAULT '0',
		  PRIMARY KEY (`idSurveyAnswerQuestion`),
		  KEY `FK_SurveyAnswerQuestion_SurveyQuestion` (`survey_question`),
		  CONSTRAINT `FK_SurveyAnswerQuestion_SurveyQuestion` FOREIGN KEY (`survey_question`) REFERENCES `SurveyQuestion` (`idSurveyQuestion`) ON DELETE CASCADE ON UPDATE CASCADE
		) ENGINE=InnoDB DEFAULT CHARSET=utf8;
		
		DELETE FROM `SurveyAnswerQuestion`;
		
		/*!40000 ALTER TABLE `SurveyAnswerQuestion` DISABLE KEYS */;
		/*!40000 ALTER TABLE `SurveyAnswerQuestion` ENABLE KEYS */;
		
		CREATE TABLE IF NOT EXISTS `Notification` (
		  `idNotification` int(11) NOT NULL AUTO_INCREMENT,
		  `user` int(11) NOT NULL,
		  `table1` varchar(50) DEFAULT NULL,
		  `value1` int(11) DEFAULT NULL,
		  `table2` varchar(50) DEFAULT NULL,
		  `value2` int(11) DEFAULT NULL,
		  `date_limit` datetime NOT NULL,
		  `title` longtext NOT NULL,
		  `description` longtext NOT NULL,
		  `created_at` datetime NOT NULL,
		  `deleted_at` datetime NOT NULL,
		  `deleted` int(11) NOT NULL,
		  `type` int(11) NOT NULL,
		  PRIMARY KEY (`idNotification`)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8;
		
		DELETE FROM `Notification`;
		
		/*!40000 ALTER TABLE `Notification` DISABLE KEYS */;
		/*!40000 ALTER TABLE `Notification` ENABLE KEYS */;";
        if (parent::createDatabase()) {
            $this->createInsecurity();
        }
    }

    private function createInsecurity() {
        $this->create_database = "CREATE TABLE IF NOT EXISTS `Insecurity` (
            `idInsecurity` int(11) NOT NULL AUTO_INCREMENT,
            `resumo` varchar(150) NOT NULL,
            `description` text NOT NULL,
            `created_at` datetime NOT NULL,
            `company` int(11) NOT NULL,
            `factory` int(11) NOT NULL,
            `sector` int(11) NOT NULL,
            `user` int(11) NOT NULL,
            `deleted_at` datetime DEFAULT NULL,
            `deleted` int(11) NOT NULL,
            `img` text NOT NULL,
            `status` INT(11) NOT NULL,
            `resolved_at` DATETIME NULL,
            `comment` LONGTEXT NULL,
            PRIMARY KEY (`idInsecurity`)
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

        DELETE FROM `Insecurity`;
		
        /*!40000 ALTER TABLE `Insecurity` DISABLE KEYS */;
        /*!40000 ALTER TABLE `Insecurity` ENABLE KEYS */;";
        if (parent::createDatabase()) {
            $this->createSecurityDialog();
        }
    }

    private function createSecurityDialog() {
        $this->create_database = "CREATE TABLE IF NOT EXISTS `SecurityDialog` (
        `idSecurityDialog` int(11) NOT NULL AUTO_INCREMENT,
        `code` varchar(55) DEFAULT NULL,
        `thema` longtext DEFAULT NULL,
        `first_text` longtext,
        `second_text` longtext,
        `image` longtext,
        `profile` INT(11) NOT NULL,
        `created_at` datetime DEFAULT NULL,
        `deleted_at` mediumtext,
        `deleted` int(11) DEFAULT 0 NULL,
        PRIMARY KEY (`idSecurityDialog`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

        DELETE FROM `SecurityDialog`;
		
        /*!40000 ALTER TABLE `SecurityDialog` DISABLE KEYS */;
        INSERT INTO `SecurityDialog` (`code`, `thema`, `first_text`, `second_text`,`image`, `profile`, `created_at`) VALUES (LEFT(UUID(), 8), 'Meios de combate a Incêndios', 'Um incêndio pode destruir tudo. Fábrica, Produção, Postos de Trabalho. Vidas. Em 2012, uma fábrica de papel nos Estados Unidos teve um incêndio. Morreu 1 pessoa. 4 ficaram gravemente feridas. 260, perderam os seus postos de trabalho. A fábrica não reabriu.#', 'A rápida intervenção pode fazer a diferença entre um pequeno incêndio e uma catástrofe. Verifique se os meios de combate a incêndios junto aos postos de trabalho, estão acessíveis e conformes: Extintores, Carreteis, Outros disponíveis. Quem, no grupo, sabe utilizar estes equipamentos?', 'Imagem1.png', 3, NOW());
        INSERT INTO `SecurityDialog` (`code`, `thema`, `first_text`, `second_text`,`image`, `profile`, `created_at`) VALUES (LEFT(UUID(), 8), 'Movimentação Manual de Cargas', 'Perto de 24% dos trabalhadores da UE-25 dizem sofrer de lombalgias e 22% queixam-se de dores musculares (fonte: Agência Europeia para a Segurança e Saúde no Trabalho). De entre os fatores de risco identificados pela Direção Geral de Saúde, inclui-se  o levantamento de cargas. O incorreto ou excessivo levantamento de cargas implica risco de lesão ou doença da coluna vertebral.#', 'Realize um rápido exercício de movimentação manual de cargas. Assegurar que todas as pessoas do grupo o realizam. Garantir o cumprimento das regras básicas: i) Para apanhar cargas do chão, os joelhos devem ser dobrados. Não as costas.; ii) Quando é necessária rotação, devem ser movidos os pés. Não a anca. iii) Quanto mais perto do corpo estiver a carga, menos força será necessária. | Como segunda parte do dialogo propomos que sejam identificados momentos do dia em que as pessoas antecipem a necessidade de pedir ajuda de um colega na movimentação manual de cargas (por excesso de peso da carga).', 'Imagem2.jpg', 3, NOW());
        INSERT INTO `SecurityDialog` (`code`, `thema`, `first_text`, `second_text`,`image`, `profile`, `created_at`) VALUES (LEFT(UUID(), 8), 'Conformidade dos EPI`s', 'Os equipamentos de proteção individual são a ultima barreira entre cada colaborador e um acidente. Vários acidentes da empresa, teriam sido evitados se o colaborador acidentado estivesse a utilizar o EPI.#', 'Os EPI`s devem estar conformes. Solicite a cada colaborador para inspecionar os seus EPI`s. Caso alguns EPI`s não estejam conformes, proceda à sua substituição ou contacte o departamento da segurança. | Valide se cada colaborador tem os EPI`s corretos para as tarefas que irão realizar durante a jornada de trabalho.', 'Imagem3.jpg', 3, NOW());
        INSERT INTO `SecurityDialog` (`code`, `thema`, `first_text`, `second_text`,`image`, `profile`, `created_at`) VALUES (LEFT(UUID(), 8), 'Hidratação', 'Um nível de desidratação entre 5% e 10%, implica: aumento do ritmo cardíaco; cãibras; fadiga extrema; dores de cabeça. Um nível de desidratação superior a 10% pode levar a perda de consciência. A falta de hidratação aumenta a probabilidade de ter um acidente de trabalho.#', 'Converse com o grupo sobre os sintomas, perguntando se os colegas já alguma vez associaram estes sintomas à possível falta de água no corpo. | Antecipe o dia de cada um, prevendo locais ou tarefas onde o risco de desidratação é superior (maior calor) | Conclua a conversa, distribuindo um copo de água (com brinde) por todos.', 'Imagem4.jpg', 3, NOW());
        INSERT INTO `SecurityDialog` (`code`, `thema`, `first_text`, `second_text`,`image`, `profile`, `created_at`) VALUES (LEFT(UUID(), 8), 'Produtos Químicos', '`Calcula-se que 10% de todos os cancros da pele se devem à exposição a substâncias perigosas no local de trabalho` (IDICT-OIT). Todo o cuidado é pouco quando se lida com produtos e/ou substâncias perigosas, independentemente da quantidade e dos fins a que se destinam, uma vez que a exposição do trabalhador a uma pequena dose de uma determinada substância pode pôr em risco a sua integridade física ou até dar origem à morte.#', 'Converse com o grupo sobre as medidas de prevenção e de proteção a adotar aquando do manuseio de produtos químicos (não se esqueça dos mais correntes - óleos em oficinas por exemplo). | Os colegas usam os EPI´s adequados aquando do manuseio?', 'Imagem5.jpg', 3, NOW());
        INSERT INTO `SecurityDialog` (`code`, `thema`, `first_text`, `second_text`,`image`, `profile`, `created_at`) VALUES (LEFT(UUID(), 8), 'Proteção dos Olhos', 'Os olhos são um órgão sensorial tão importante como sensível. Os óculos de proteção oferecem uma proteção considerável contra vários riscos: poeiras, choque, partículas sólidas, líquidos quentes, salpicos de material fundido, chama, salpicos de ácidos, salpicos de dissolventes, salpicos de alcalinos, radiação ultravioleta (UV), radiação infravermelha (IV), laser, etc.#', 'Peça a cada elemento da equipa para identificar se durante o dia de trabalho irá desempenhar alguma tarefa que inclua os riscos identificados nesta ficha (poeiras, choque...). Tente que as pessoas sejam o mais concretas possíveis nessa identificação. | Solicite a cada colaborador para inspecionar os seus óculos de proteção. No caso de não estarem conformes (haste danificada, lentes riscadas, etc.), proceda à sua substituição ou contacte o departamento da segurança. ', 'Imagem6.png', 3, NOW());
        INSERT INTO `SecurityDialog` (`code`, `thema`, `first_text`, `second_text`,`image`, `profile`, `created_at`) VALUES (LEFT(UUID(), 8), 'Rotulagem - Pictogramas', 'O rótulo de um produto químico é um documento de extrema importância para o seu usuário. Todas os trabalhadores que utilizam, manipulam, transportam, armazenam ou descartam produtos químicos devem ler as informações colocadas nos rótulos. Os rótulos incluem frases e pictogramas normalizados que alertam para os perigos dos produtos químicos. #', 'Os pictogramas para a rotulagem de produtos químicos mudaram. Quem, no grupo, conhece os novos pictogramas que alertam para os perigos dos produtos químicos? Imprima alguns sinais (peça ao departamento de segurança se necessário) e pergunte às pessoas o seu significado| Mostre ao grupo o rotulo de um produto químico (leve o `frasco` para a conversa, mas não se esqueça de estar devidamente protegido).', 'Imagem7.jpg', 3, NOW());
        INSERT INTO `SecurityDialog` (`code`, `thema`, `first_text`, `second_text`,`image`, `profile`, `created_at`) VALUES (LEFT(UUID(), 8), 'Cuidados com Pequenos Ferimentos', 'A pele constitui uma barreira natural do corpo humano à penetração de bactérias no organismo. Quando se verifica um ferimento da pele, essa barreira é comprometida, sendo assim possível a entrada de micróbios na circulação a partir dos tecidos expostos e infetados. Tratar corretamente pequenos ferimentos é importante para não gerar infeções, não contaminar a pele com fungos, bactérias ou vírus que podem causar doenças graves.#', 'Peça a todos que mostrem por favor as mãos. Tentem identificar cortes recentes em cada pessoa, ou cortes antigos que tenham deixado marcas| Converse com todos sobre a forma de tratamento adequada.', 'Imagem8.png', 3, NOW());
        INSERT INTO `SecurityDialog` (`code`, `thema`, `first_text`, `second_text`,`image`, `profile`, `created_at`) VALUES (LEFT(UUID(), 8), 'Ruído Ocupacional', 'A consequência mais evidente dos efeitos do ruído sobre o sistema auditivo do no homem, é a SURDEZ. A surdez profissional é a 2ª causa de doença profissional em Portugal. A exposição a níveis de ruídos que ultrapassem os 87 dB(A) causa a perda permanente de audição, decorrente de um processo continuado de exposição, que ultrapassam os limites a que o organismo é capaz de resistir sem danos significativos.#', 'Antes de começar o diálogo peça a um elemento do grupo que tape os ouvidos durante a conversa. O objetivo é demonstrar o impacto da surdez na exclusão social de qualquer grupo. No final, peça a essa pessoa para partilhar o sentimento de ver uma conversa de grupo, sem a ouvir. É importante que todos percebam que a longo prazo, essa pessoa ficará excluída de qualquer grupo. | Entretanto, converse com o grupo sobre a consequências nefastas da exposição ao ruído, identificando zonas da fábrica onde claramente o nível de ruido ultrapassa 80 dB(A).', 'Imagem9.jpg', 3, NOW());
        INSERT INTO `SecurityDialog` (`code`, `thema`, `first_text`, `second_text`,`image`, `profile`, `created_at`) VALUES (LEFT(UUID(), 8), 'Riscos Elétricos', 'A utilização da eletricidade exige vários cuidados. Quando são negligenciados os procedimentos de segurança esta fonte de energia pode provocar: danos patrimoniais; lesões físicas irrecuperáveis, MORTE.  A origem da maioria dos acidentes elétricos está relacionada com a falta de informação, ou imprudência, de quem trabalha e utiliza recursos elétricos.#', 'Começar pelo básico: verifique em grupo, olhando à volta e circulando no espaço onde estão, se existem quadros elétricos abertos, ou cabos elétricos não protegidos. | Peça para que as pessoas do grupo façam o mesmo durante o dia de trabalho | Como reagir caso um colega esteja a sofrer uma eletrocussão? Discuta em grupo o que deve ser feito, salientando que é importante pensar nisso antes que aconteça. Ninguém deve ajudar um colega de uma forma direta (por exemplo, colocando as mãos desprotegidas no colega), sob pena também sofrer eletrocussão | No caso de os trabalhos terem de ser realizados quando as instalações estão sob tensão, estes devem ser realizados seguindo os procedimentos de segurança estabelecidos e usando os equipamentos de proteção adequados.', 'Imagem10.jpg', 3, NOW());
        INSERT INTO `SecurityDialog` (`code`, `thema`, `first_text`, `second_text`,`image`, `profile`, `created_at`) VALUES (LEFT(UUID(), 8), 'Equipamentos de Proteção Coletiva (EPC)', 'Os EPC beneficiam todos os trabalhadores potencialmente sujeitos ao risco profissional. Os EPC são todos os dispositivos, sistemas, meios fixos ou móveis, sinais, imagens ou sons de abrangência coletiva, destinado a preservar a integridade física e a saúde dos trabalhadores e de terceiros.#', 'Questionar o grupo: Quais são os equipamentos de proteção coletiva mais comuns? |Exemplos de EPC: Equipamentos e sistemas de extinção de incêndios (extintores, carreteis,…); Detetores de incêndio; Centrais automáticas de deteção de incêndios; Sirenes de alarme; sistemas de exaustão de gases, vapores ou poeiras; Comandos bimanuais; Disjuntores diferenciais; Protetores de componentes de máquinas (resguardos); Corrimão; pavimento antiderrapante; linhas de vida; guardas de proteção; sinalização; etc. | Identifique alguma oportunidade de melhoria que possa ser concretizada pelo grupo reunido, relativamente a EPC.', 'Imagem11.jpg', 3, NOW());
        INSERT INTO `SecurityDialog` (`code`, `thema`, `first_text`, `second_text`,`image`, `profile`, `created_at`) VALUES (LEFT(UUID(), 8), 'Trabalhos em Altura - Andaimes', '1 em cada 3 dos acidentes mortais são provocados por quedas em altura. Entre as principais causas de acidentes estão os andaimes ou plataformas mal montados, sem guardas de segurança, e/ou ausência de um arnês de segurança.#', 'Os andaimes devem estar equipados com proteções laterais, pranchas metálicas e barra guarda-costas. | Peça ao grupo para darem exemplos de situações que tenham visto, onde as regras essenciais de proteção em andaimes não tenham sido cumpridas. Se não existirem exemplo, o líder do grupo deve dar esse exemplo (previamente deve dar uma volta pela fábrica para identificar situações não corretas) | Conversar sobre o que deve um colaborador fazer quando vê uma situação de risco associada a andaimes - recordando que acidentes em andaimes são muitas vezes mortais (ou seja, `eu` quando vejo um erro e não faço nada, neste caso, posso estar a compactuar com uma morte.', 'Imagem12.jpg', 3, NOW());
        INSERT INTO `SecurityDialog` (`code`, `thema`, `first_text`, `second_text`,`image`, `profile`, `created_at`) VALUES (LEFT(UUID(), 8), 'ATEX - Atmosferas Explosivas', 'Em 11.07.2009 ocorreu uma explosão numa celulose. O fogo durou 36 horas. Foi decretado recolher obrigatório para a população circundante, num raio de 3 kms. Por “Atmosferas Explosivas” entendem-se as atmosferas constituídas por misturas de ar com substâncias inflamáveis (gases, vapores, névoas ou poeiras), nas quais, após a ignição, a combustão se propague a toda a mistura não queimada. Nos últimos tempos temos assistido, em Portugal, a um aumento significativo de explosões e incêndios em industrias dos mais diversos sectores (tintas, solventes, biogás, silos, baterias UPS, madeiras, celulose, enxofre, alumínio, carvão, magnésio, etc.).#', 'Questionar o grupo: É necessário efetuar trabalhos em zonas ATEX. Que medidas de prevenção e proteção devem adotar/implementar? (Medidas: Garantir a existência de uma `instrução de trabalho` relacionada com a atividade. Garantir a existência de uma  “autorização de trabalho” que contemple todos os intervenientes e que esteja perfeitamente avaliada em termos de riscos e de medidas de controlo e com medidas de supervisão. Garantir a existência de um `sistema de consignação`) | Caso alguém do grupo vá fazer uma qualquer intervenção num ambiente ATEX, validar se todos estes aspetos vão ser cumpridos e de que forma.', 'Imagem13.jpg', 3, NOW());
        INSERT INTO `SecurityDialog` (`code`, `thema`, `first_text`, `second_text`,`image`, `profile`, `created_at`) VALUES (LEFT(UUID(), 8), 'Fichas de Dados de Segurança (FDS)', 'As fichas de dados de segurança constituem o principal instrumento para assegurar uma utilização segura de substâncias e misturas potencialmente perigosas. As fichas de dados de segurança incluem informações sobre as propriedades da substância e os seus perigos, instruções de manuseamento, eliminação e transporte e medidas relativas aos primeiros socorros, ao combate a incêndios e ao controlo da exposição. Perante uma situação de emergência, ninguém vai ter tempo de ler com calma o que quer que seja! Em Agosto de 2015, um colaborador de uma celulose chinesa ingeriu um produto químico (após ter caído num contentor com esse produto). 6 colegas tentaram ajuda-lo sem conhecer os riscos. Morreram todos.#', 'Lançar uma pergunta ao grupo que demonstre a utilidade de lerem as fichas de segurança. Por exemplo, um colega ingere cal viva. Deve ou não provocar o vómito? | Mostrar ao grupo um exemplo de FDS (levar cópias para partilhar com todos). | Pedir aos colaboradores para lerem a FDS e identificarem: perigos; 1ºs socorros; medidas de combate a incêndios; proteção individual (EPI´s); forma de manuseamento; forma de eliminação. | Questione os colaboradores sobre a localização das FDS dos produtos que normalmente manipulam.  ', 'Imagem14.png', 3, NOW());
        INSERT INTO `SecurityDialog` (`code`, `thema`, `first_text`, `second_text`,`image`, `profile`, `created_at`) VALUES (LEFT(UUID(), 8), 'Capacete de Proteção', 'No dia 31 de Outubro de 2011 Leandro Moreira, operário da construção civil, foi atingido por um balde metálico, de peso aproximado de 20kg, que transportava cimento, que estima-se que tenha atingido o trabalhador com peso equivalente de 100kg motivado pela queda. Na sequencia do acidente, o capacete ficou destruído e o trabalhador necessitou de levar 30 pontos na cabeça. Não morreu!#', 'Converse com o grupo sobre as boas práticas de utilização e conservação. Inspecione os capacetes do grupo. Identifique se existem fissuras, rasgos, etc. que exijam a substituição do capacete | Caso identifique algum capacete manifestamente obsoleto, tente perceber o porquê da pessoa não ter solicitado a sua substituição, conversando com o grupo sobre isso | Peça aos elementos do grupo que assegurem a higiene do seu capacete durante esta semana (depois, controle por favor).', 'Imagem15.png', 3, NOW());
        INSERT INTO `SecurityDialog` (`code`, `thema`, `first_text`, `second_text`,`image`, `profile`, `created_at`) VALUES (LEFT(UUID(), 8), 'Segurança na Utilização de Escadas Portáteis', 'Em Portugal, no ano 2014, pelo menos 37 trabalhadores morreram vitimas de quedas em altura. A utilização incorreta de escadas portáteis é uma das causas. A sua utilização deve revestir-se de alguns cuidados prévios que têm a ver, nomeadamente, com a escolha do tipo de escada mais adequado ao tipo de trabalho, com o estado de conservação da mesma e com a resistência da superfície de apoio.#', 'Transmitir aos colaboradores algumas regras de segurança a observar aquando da utilização de escadas portáteis: A escada deve ser colocada de forma a que a base fique apoiada em pontos solidamente fixos, que a impeçam de deslizar; O topo da escada deve ser seguro preferencialmente a pontos existentes, solidamente fixos; No caso de colocar uma escada apoiada numa fachada ou estrutura, para subida a um terraço ou plataforma, aquela deve ficar com cerca de 1 metro acima da referida estrutura; Em alturas superiores a 3 metros, utilizar o sistema anti-quedas e fixa-lo num ponto solido e procurar a melhor posição para a execução do trabalho. | Após transmitir estas regras, perguntar quantas vezes viram alguém a utilizar uma escada com todo este cuidado? | Perguntar se alguém do grupo vai utilizar escadas na próxima semana e antecipar tudo o que deve ser feito em termos de segurança (nesse ou nesses casos concretos)| Terminar por salientar que uma escada não é uma plataforma de trabalho, mas sim apenas um meio de acesso.', 'Imagem16.png', 3, NOW());
        INSERT INTO `SecurityDialog` (`code`, `thema`, `first_text`, `second_text`,`image`, `profile`, `created_at`) VALUES (LEFT(UUID(), 8), 'Acidentes de Trabalho e Causas Humanas', 'Todos sabemos que o dia a dia de uma empresa não é isento de riscos. O acidente não é fruto do azar ou do acaso. Tem normalmente várias causas que participam simultaneamente desencadeando os acidentes. As causas dos acidentes podem ser de origem humana ou material. Quantos acidentes poderíamos evitar na empresa, com maior prevenção e alerta por parte das pessoas?#', 'Quais as causas humanas mais comuns nos acidentes de trabalho? (Principais causas humanas: Excesso de confiança; Falta de atenção; Não cumprimento das regras de segurança; Falta de experiencia; Stress; Cansaço; etc.) | Converse sobre 2 ou 3 acidentes que o grupo conheça, onde uma intervenção mais cuidadosa poderia ter evitado os mesmos.', 'Imagem17.png', 3, NOW());
        INSERT INTO `SecurityDialog` (`code`, `thema`, `first_text`, `second_text`,`image`, `profile`, `created_at`) VALUES (LEFT(UUID(), 8), 'Segurança em Espaços Confinados', 'Nos espaços confinados podem existir diversas condições perigosas com riscos de acidentes que poderão ter consequências mortais ou particularmente graves para os trabalhadores. Exemplos de espaços confinados: reatores, galerias subterrâneas, fossas, túneis, chaminés, caldeiras, silos, tanques, porões e cisternas. A empresa tem vários espaços confinados.#', 'Pedir ao grupo para identificar alguns espaços confinados concretos existentes na fabrica. |Leve para este diálogo uma Autorização de Trabalho para um espaço confinado (peça ao departamento de segurança se necessário). Analise com o grupo os principais aspetos, escritos nessa autorização, que tem impacto na segurança. Por exemplo, porque nunca deve um trabalho em espaço confinado ser realizado sem um colega no exterior? (porque em caso de perda de consciência das pessoas no interior, nada será feito em tempo útil).', 'Imagem18.png', 3, NOW());
        INSERT INTO `SecurityDialog` (`code`, `thema`, `first_text`, `second_text`,`image`, `profile`, `created_at`) VALUES (LEFT(UUID(), 8), 'Quase - acidente', 'Um quase-acidente é um incidente relacionado com o trabalho no qual não ocorreu, dano físico ou de saúde para as pessoas ou para o ambiente. Ou seja, por sorte, ninguém se magoou.#', 'Após expor o que é um quase acidente, pedir às pessoas exemplos de quase acidentes que presenciaram | O registo de um quase-acidente é importante para que a empresa possa melhorar e evitar que a situação volte a ocorrer. Vamos supor que um colega vê um quase acidente grave. Não regista. Passado algum tempo, ocorre a mesma situação e `eu` sofro o acidente. Qual o meu sentimento para com o meu colega que não registou o quase acidente?| Perguntar se os quase acidentes que foram descritos no inicio, foram registados? | Solicitar aos colaboradores o registo futuro de quase acidente.', 'Imagem19.jpg', 3, NOW());
        INSERT INTO `SecurityDialog` (`code`, `thema`, `first_text`, `second_text`,`image`, `profile`, `created_at`) VALUES (LEFT(UUID(), 8), 'Proteção das Mãos', 'As luvas de proteção protegem as mãos dos trabalhadores de diversos perigos, nomeadamente: cortes e escoriações; temperaturas extremas; irritações da pele e dermatites; e contacto com substâncias tóxicas ou corrosivas.#', 'Pedir ao grupo para identificar atividades onde é obrigatório o uso de luvas de proteção | Inspecione as luvas do grupo (rasgões, cortes etc.) | Informe os trabalhadores: Se durante a utilização das luvas detetar algum defeito deve proceder-se à sua imediata substituição| Questionar o grupo : conhecem todos os tipos de luvas disponibilizadas pela empresa? Na empresa existem luvas: contra agressões mecânicas (perfurações, cortes, vibrações, etc.); contra agressões químicas; para eletricistas e antitérmicas. Se tiver duvidas contacte o departamento da segurança. ', 'Imagem20.gif', 3, NOW());
        INSERT INTO `SecurityDialog` (`code`, `thema`, `first_text`, `second_text`,`image`, `profile`, `created_at`) VALUES (LEFT(UUID(), 8), 'Comunicação', 'A comunicação, habitualmente, está na origem dos acidentes mais graves. Os 2 piores acidentes da história da aviação resultaram de problemas de comunicação básicos. Morreram mais de 600 pessoas.#', 'Pedir ao grupo para identificar nas suas tarefas diárias os momentos em que falhas de comunicação com colegas podem originar acidentes | Nota: as falhas de comunicação estão normalmente na origem dos acidentes mais graves. Seja muito rigoroso neste minuto de segurança.', 'Imagem21.png', 3, NOW());
        INSERT INTO `SecurityDialog` (`code`, `thema`, `first_text`, `second_text`,`image`, `profile`, `created_at`) VALUES (LEFT(UUID(), 8), 'Proteção das Vias Respiratórias', 'As máscaras de proteção protegem os trabalhadores contra efeitos adversos causados por poeiras contaminadas, névoas, fumos, vapores ou líquidos pulverizados. A não utilização destes EPI pode levar a doenças profissionais tais como asma, cancro e uma variedade de outros efeitos negativos na saúde e bem-estar dos trabalhadores.#', 'Peça a cada elemento da equipa para identificar se durante o dia de trabalho irá desempenhar alguma tarefa que inclua os riscos identificados nesta ficha (poeiras, fumos...) | Questionar o grupo: Quantos tipos de máscaras existem na empresa? Para que utilização serve cada uma?|Transmitir aos colaboradores que muitas substancias nocivas entram no organismo pelos olhos e pela pele, pelo que, para além das máscaras de proteção, poderá ser necessário outros equipamentos de proteção complementares (máscaras panorâmicas que incluem proteção ocular, luvas e fatos de proteção).', 'Imagem22.png', 3, NOW());
        INSERT INTO `SecurityDialog` (`code`, `thema`, `first_text`, `second_text`,`image`, `profile`, `created_at`) VALUES (LEFT(UUID(), 8), 'Ferramentas Elétricas', 'Muitos acidentes com equipamentos elétricos são provocados por cabos flexíveis, extensões, fichas e tomadas avariadas. Um em cada cinco acidentes com eletricidade envolve ferramentas elétricas. Cerca de metade das amputações de dedos realizadas anualmente resultam de acidentes com ferramentas elétricas. (fonte: Agência Europeia para a Segurança e Saúde no Trabalho). #', 'Transmitir aos colaboradores algumas regras de segurança a observar aquando da utilização de ferramentas elétricas. Se possível, leve para a reunião um equipamento para inspecionar:  verifique se há cabos descarnados à vista; se o revestimento dos cabos está intacto, sem cortes ou golpes; se a ficha está em boas condições – por exemplo, o invólucro não está rachado e os pernos não estão inclinados; se o cabo tem juntas amarradas com fita ou não-normalizadas; se a caixa de revestimento da ferramenta está danificada; se existem fissuras nos discos e nas lâminas; confirme a presença e fixação das proteções| Perguntar se alguém do grupo vai utilizar ferramentas elétricas na próxima semana e antecipar tudo o que deve ser feito em termos de segurança | Terminar por salientar que as ferramentas elétricas que estão danificadas devem ser retiradas de uso e ter uma etiqueta com indicação de “Não utilizar”. ', 'Imagem23.jpg', 3, NOW());
        INSERT INTO `SecurityDialog` (`code`, `thema`, `first_text`, `second_text`,`image`, `profile`, `created_at`) VALUES (LEFT(UUID(), 8), 'Cabos e Extensões', 'Os cabos e as extensões em mau estado apresentam riscos significativos para a saúde e a segurança dos trabalhadores. Principais perigos e riscos: Risco de eletrocussão, choque ou queimaduras devido ao mau funcionamento dos componentes elétricos, cabos partidos e isolamento ou ligação à terra inadequados.#', 'Pedir ao grupo para partilhar histórias de `apanhar choques`. Como ocorreram? | Identificar trabalhos com corrente elétrica feitos em locais com humidade na empresa. Informar que a humidade aumenta o risco de choque elétrico, pelo que os cuidados de verificação de cabelagens, tomadas, etc. deve ser redobrado. | Salientar a importância da boa arrumação do equipamento, para que este não se estrague.', 'Imagem24.png', 3, NOW());
        INSERT INTO `SecurityDialog` (`code`, `thema`, `first_text`, `second_text`,`image`, `profile`, `created_at`) VALUES (LEFT(UUID(), 8), 'Trabalho em altura - Risco de Queda', 'A queda em altura constitui uma das causas mais frequentes da ocorrência de acidentes de trabalho, originando um número significativo de mortes e de lesões graves  (fonte: Autoridade para as Condições do Trabalho). Todos os anos morrem pessoas por quedas em altura.#', 'Pedir ao grupo para identificar algumas atividades na fabrica onde se realizam trabalhos em altura (TA) (exemplos: com recurso a escadas portáteis e escadotes; em andaimes e outras plataformas, em postes ou torres metálicas; por posicionamento de cordas) | Transmitir aos colaboradores algumas regras de segurança: Tomar todas as medidas necessárias e adequadas para minimizar os riscos existentes; utilizar, sempre que necessário, equipamentos de proteção individual (arnês); aplicar medidas de proteção coletiva (por exemplo através da colocação de guardas, linhas de vida, sinalização, etc.). | Se for possível, observar com o grupo alguém a trabalhar em altura.', 'Imagem25.png', 3, NOW());
        INSERT INTO `SecurityDialog` (`code`, `thema`, `first_text`, `second_text`,`image`, `profile`, `created_at`) VALUES (LEFT(UUID(), 8), 'Sinalização de Segurança', ' A sinalização de segurança tem por objetivo chamar a atenção de forma rápida e inequívoca para as situações que comportem riscos para a segurança e saúde dos trabalhadores, assim como presta informações relacionadas com a segurança (salvamento ou de emergência e material de combate a incêndios)#', 'Faça uma auditoria, em grupo e em 5 minutos, a todos os sinais existentes neste espaço de trabalho. Identifique qual o objetivo de cada sinal (ou seja, que riscos tentam proteger?). Por exemplo, um sinal de `saída` serve para em caso de emergência assegurar que as pessoas vêm as portas de saída. Se a lâmpada estiver fundida e a fábrica com fumo, o sinal vai conseguir ver-se? E se estiver completamente sujo e opaco? | Por ultimo, identifique em grupo alguém que não esteja a cumprir a sinalética e fale com essa pessoa (em grupo).', 'Imagem26.jpg', 3, NOW());
        INSERT INTO `SecurityDialog` (`code`, `thema`, `first_text`, `second_text`,`image`, `profile`, `created_at`) VALUES (LEFT(UUID(), 8), 'Segurança de Máquinas e Equipamentos', 'Em 2015, 43% do total dos acidentes de trabalho mortais tiveram como origem a utilização de maquinas e equipamentos de trabalho. Cerca de 50 mortes. (fonte: ACT). Muitos dos processos produtivos da empresa dependem da utilização de máquinas e equipamentos, pelo que é importante o cumprimento dos requisitos de segurança de modo a garantir a segurança dos trabalhadores.#', 'Pedir ao grupo para identificar algumas regras de segurança a verificar antes de iniciar qualquer trabalho dentro ou sobre os equipamentos. | Verificar nas proximidades da presente reunião, se as zonas das máquinas ou dos equipamentos, onde existam riscos mecânicos, possuem proteções eficazes (ex.: proteções fixas); | Perguntar aos colaboradores se conhecem as regras de bloqueio dos equipamentos (consignação) antes de intervir nos mesmos.', 'Imagem27.png', 3, NOW());
        INSERT INTO `SecurityDialog` (`code`, `thema`, `first_text`, `second_text`,`image`, `profile`, `created_at`) VALUES (LEFT(UUID(), 8), 'Alarme de Emergência', 'O alarme de emergência industrial da empresa é dado através da sirene principal da fábrica, quando ocorrem nas instalações fabris situações de emergência suscetíveis de afetar a saúde dos trabalhadores e população, condições ambientais dentro e fora do perímetro fabril, etc.#', 'Questionar quem no grupo conhece os diferentes sinais sonoros emitidos pela sirene da fábrica, e quais as respetivas situações de emergência | Faça de conta que a sirene começa a tocar agora. O que fazer? Falar com o grupo sobre a forma como deve ocorrer a evacuação e que cuidados a ter nesta área (por exemplo, é preciso desligar algum equipamento antes de sair?)', 'Imagem28.png', 3, NOW());
        INSERT INTO `SecurityDialog` (`code`, `thema`, `first_text`, `second_text`,`image`, `profile`, `created_at`) VALUES (LEFT(UUID(), 8), 'Caixa de Primeiros Socorros', 'Os primeiros socorros são a primeira ajuda ou assistência dada a uma vítima de acidente ou doença súbita antes da chegada de uma ambulância ou médico. A finalidade dos primeiros socorros é: Preservar a Vida; Evitar o agravamento do estado da vítima; Promover o seu restabelecimento. Na empresa existem caixas de primeiros socorros na generalidade dos locais de trabalho.#', 'Se possível, leve uma caixa de primeiros socorros consigo para este diálogo. | Começar a conversa por fazer uma pergunta simples - para que serve o álcool numa caixa de primeiros socorros (resposta: apenas e só para desinfetar as mãos do socorrista). O objetivo desta pergunta é demonstrar às pessoas que nem sempre se sabe aquilo que se acha fácil | Abra a caixa de primeiros socorros que tem consigo e pergunte o que pode acontecer se faltar cada elemento que está lá dentro (exemplo, se eu não tiver esta ligadura e um colega estiver a sangrar abundantemente?). O objetivo é explicar porque é importante a substituição dos equipamentos |Questione os colaboradores sobre a localização da caixa de 1ºs socorros mais próxima do seu posto de trabalho. | Peça ao grupo que, durante o dia de trabalho, tente localizar o maior numero de caixas de 1ºs socorros.', 'Imagem29.png', 3, NOW());
        INSERT INTO `SecurityDialog` (`code`, `thema`, `first_text`, `second_text`,`image`, `profile`, `created_at`) VALUES (LEFT(UUID(), 8), 'Falar sobre segurança', 'É fácil dizermos `Eu sou uma pessoa cuidadosa com o meu trabalho`; `Eu sou um bom profissional`; `A segurança para mim é importante`.#', 'Perguntar ao grupo: no ultimo mês, quantas vezes falou com alguém sobre desporto? Ou telenovelas? Ou preços de supermercado? E quantas vezes falou com alguém sobre segurança no trabalho? (Tentar demonstrar que não basta dizer que nos importamos com segurança. Temos que fazer mais pela segurança). | Caso alguns elementos do grupo digam que tiveram conversas sobre segurança, pergunte sobre quê.', 'Imagem30.jpg', 3, NOW());
        INSERT INTO `SecurityDialog` (`code`, `thema`, `first_text`, `second_text`,`image`, `profile`, `created_at`) VALUES (LEFT(UUID(), 8), 'Inspeção de Extintores', 'Trata-se de uma operação rápida e simples que pode ser efetuada por qualquer trabalhador e que visa garantir a operacionalidade do extintor. Se um extintor de incêndio não estiver convenientemente instalado, se não estiver operacional, pode não cumprir com a sua função.#', 'Veja se existe algum extintor nas proximidades, se sim, realize em grupo uma rápida inspeção: verifique se está no local adequado; se está bem visível e sinalizado; se as instruções de manuseamento estão legíveis; se não apresenta danos; se a válvula, a mangueira e a agulheta se encontram em bom estado de conservação; se o selo não está violado | Solicite a cada colaborador para inspecionar os extintores existentes no seu local de trabalho. No caso de não estarem conforme deverá ser contactado o departamento da segurança. ', 'Imagem31.jpg', 3, NOW());
        INSERT INTO `SecurityDialog` (`code`, `thema`, `first_text`, `second_text`,`image`, `profile`, `created_at`) VALUES (LEFT(UUID(), 8), 'Extintores de Incêndio - Como Usar', 'Os extintores são o meio mais adequado para combater um incêndio na sua fase inicial e controlar ou conter o seu desenvolvimento.#', 'Questione o grupo: quem no grupo já utilizou um extintor? | sabem utilizar um extintor? | Verifique se existe algum extintor nas proximidades, se sim, simule os procedimentos básicos de utilização: Retirar a cavilha de segurança do extintor→ Apontar o jacto à base do fogo → Premir o manípulo de descarga | Peça aos elementos do grupo para efetuarem o mesmo procedimento.', 'Imagem32.jpg', 3, NOW());
        INSERT INTO `SecurityDialog` (`code`, `thema`, `first_text`, `second_text`,`image`, `profile`, `created_at`) VALUES (LEFT(UUID(), 8), 'Álcool e Drogas', 'Entre 15 a 30% dos acidentes mortais ocorridos no local de trabalho são causados pelo consumo de álcool ou drogas. (Fonte: Organização Internacional do Trabalho). #', 'O uso de álcool e drogas no local de trabalho comporta riscos de segurança para o utilizador e colegas de trabalho. | Proponha ao grupo o seguinte exercício hipotético: pense no trabalho que faz. Diga o que pode acontecer se uma das pessoas que trabalha diretamente consigo estiver alcoolizado ou sob efeito de drogas.', 'Imagem33.jpg', 3, NOW());
        INSERT INTO `SecurityDialog` (`code`, `thema`, `first_text`, `second_text`,`image`, `profile`, `created_at`) VALUES (LEFT(UUID(), 8), 'Movimentação Mecânica de Cargas', 'Em Maio de 2015, um homem morreu depois de um acidente de trabalho numa empresa do ramo de papel e celulose no Brasil. O trabalhador operava uma máquina por controlo remoto e retirava uma bobina de papel de 4 toneladas de uma pilha, quando ela se soltou e caiu sobre a vitima. #', 'A movimentação mecânica de cargas compreende as operações de elevação, transporte e descarga de objetos, que é efetuada com recurso a sistemas mecânicos (empilhadores, plataformas elevatórias, etc.) | Pedir ao grupo para identificar algumas regras de segurança a verificar antes e durante a MMC| Dê alguns exemplos: Inspecionar o equipamento; Respeitar a carga máxima indicada no equipamento (diagrama de cargas); Proibir a permanência e circulação de pessoal sob as cargas suspensas; Utilizar cabos/cintas em boas condições; Utilizar cinto de segurança na utilização de empilhadores, etc. | Agora tente encontrar com o grupo um operador de empilhador e verifique se estas regras estão todas cumpridas.', 'Imagem34.jpg', 3, NOW());
        INSERT INTO `SecurityDialog` (`code`, `thema`, `first_text`, `second_text`,`image`, `profile`, `created_at`) VALUES (LEFT(UUID(), 8), 'Plano de Emergência Interno (PEI)', 'O Plano de Emergência tem por objetivo fundamental a proteção de pessoas, bens e ambiente, em caso de ocorrência inesperada de situações perigosas e imprevistas como, por exemplo, incêndio, fuga de gás, derrame, etc. A empresa dispõe de um PEI que contempla diversos cenários de Acidentes Industriais. #', 'Mostrar ao grupo um folheto informativo do PEI (levar cópias para partilhar com todos). Se não tiver peça ao Departamento de Segurança| Questione os colaboradores sobre a localização dos pontos de encontro. | Pedir aos colaboradores para lerem o folheto e identificarem: Procedimentos em caso de evacuação; Procedimentos de alarme de emergência; Localização do seu posto de trabalho na planta.', 'Imagem35.jpg', 3, NOW());
        INSERT INTO `SecurityDialog` (`code`, `thema`, `first_text`, `second_text`,`image`, `profile`, `created_at`) VALUES (LEFT(UUID(), 8), 'Consignação de Máquinas, Equipamentos', 'Em Setembro de 2015, um mecânico de 43 anos enquanto fazia manutenção numa máquina de triturar, caiu e o pé foi atingido pelas lâminas da máquina, tendo que ser amputado. Verificou-se que o dispositivo que trava a máquina durante a manutenção não estava em posição de segurança.#', 'A consignação de máquinas e equipamentos de trabalho, tem lugar antes de se iniciar o trabalho de manutenção ou intervenção junto do equipamento | Transmitir aos colaboradores algumas regras de segurança a observar aquando da realização de trabalhos de manutenção, utilizando casos específicos dos equipamentos que estão à volta do grupo | Clarificar que as regras da empresa devem ser cumpridas de forma exata. Um colaborador não deve intervir no equipamento se não estiver autorizado a fazer isso, mesmo que ache que sabe as regras de bloqueio.', 'Imagem36.jpg', 3, NOW());
        INSERT INTO `SecurityDialog` (`code`, `thema`, `first_text`, `second_text`,`image`, `profile`, `created_at`) VALUES (LEFT(UUID(), 8), 'Trabalhos a Quente', 'São considerados trabalhos a quente: Soldadura, corte, aquecimento ou secagem com chama ou ar quente, uso de rebarbadora, qualquer trabalho do qual resulte chama aberta, superfície quente ou emissão de faísca.#', 'Converse com o grupo sobre as precauções a implementar durante a execução dos trabalhos a quente: Garantir a limpeza e organização do local, durante e após os trabalhos; afastar todos os produtos ou materiais inflamáveis; Usar todos os EPI´s obrigatórios; Criar um perímetro de segurança sob zona de intervenção; Ter à mão o equipamento de combate a incêndios adequado (extintores, manta, etc.); Em caso de incêndio derrame, fuga, etc. Dê primeiro o alarme e só depois tente combater o sinistro. ', 'Imagem37.jpg', 3, NOW());
        INSERT INTO `SecurityDialog` (`code`, `thema`, `first_text`, `second_text`,`image`, `profile`, `created_at`) VALUES (LEFT(UUID(), 8), 'Reciclagem', 'Os resíduos constituem uma preocupação ambiental muito importante que tem sido objeto de muita atenção nos últimos anos. A empresa tem vindo a investir em meios que possibilitem uma adequada recolha seletiva de resíduos com o intuito de reduzir a quantidade de resíduos depositados em aterros e para dar cumprimento à legislação aplicável.#', 'Conhece as principais cores da reciclagem? Pedir ao grupo para identificar algumas dessas cores | AZUL: papel; VERMELHO: latas de bebidas; VERDE: vidro; AMARELO: plástico; PRETO: madeira; Castanho: resíduos orgânicos | Para que a recolha seletiva cumpra os seus objetivos, é essencial que todos os colaboradores assumam a sua responsabilidade relativamente aos resíduos que produzem no desempenho das suas atividades.', 'Imagem38.jpg', 3, NOW());
        INSERT INTO `SecurityDialog` (`code`, `thema`, `first_text`, `second_text`,`image`, `profile`, `created_at`) VALUES (LEFT(UUID(), 8), 'Arrumação e Limpeza', 'A limpeza e arrumação, a desobstrução de passagens (acessos e saídas), a disciplina na colocação de todos os objetos e materiais de trabalho nos lugares que lhes competem, são fatores fundamentais na prevenção dos acidente e incidentes.#', 'Imagine que há uma situação de emergência. O seu espaço de trabalho está cheio de fumo. Há um pequeno foco de incêndio para apagar | Verifique em grupo: se eu tentar sair a correr, onde posso tropeçar? Se eu quiser ir buscar o extintor ele estará livre de obstáculos? | Se detetarem alguma irregularidade qual deve ser a atitude do colaborador? Arruma e limpa ou não faz nada? Se nada fizer qual o risco?| Conclua a conversa por propor que em 3 minutos o grupo arrume o máximo de coisas que conseguir (e que não estejam em ordem nesse preciso momento).', 'Imagem39.png', 3, NOW());
        INSERT INTO `SecurityDialog` (`code`, `thema`, `first_text`, `second_text`,`image`, `profile`, `created_at`) VALUES (LEFT(UUID(), 8), 'Preparação de Áreas Seguras de Trabalho', 'Um homem de 31 anos foi eletrocutado, acabando por morrer, em Março de 2016, quando pintava a parede de uma casa. Tocou com o rolo num cabo em tensão.#', 'No caso descrito, houve preparação do trabalho? | A avaliação de riscos constitui um primeiro passo essencial na prevenção de acidentes de trabalho, a todos os níveis hierárquicos. Mesmo a mais pequena tarefa deve ser pensada. | Quem vai precisar de um determinado EPI, terá maior tendência para não o utilizar se não o tiver consigo antes de iniciar a tarefa. | Porque devemos constantemente fazer esta avaliação no nosso dia-a-dia, peça a cada colaborador que, no seu local de trabalho e antes de iniciar a sua atividade, aplique um método simples de avaliação de riscos (exemplo: 45 segundos da segurança - formação Comportamentos Seguros)  ', 'Imagem40.jpg', 3, NOW());
        INSERT INTO `SecurityDialog` (`code`, `thema`, `first_text`, `second_text`,`image`, `profile`, `created_at`) VALUES (LEFT(UUID(), 8), 'Trabalho por Turnos e Trabalho Noturno', 'O trabalho por turnos e o trabalho noturno têm implicações no estilo de vida dos trabalhadores, exigindo uma adaptação a horários irregulares ou em regime noturno, com consequências a nível físico e psicológico, sendo as implicações maiores quando os turnos são efetuados durante a noite.#', 'O que pode cada um fazer para minimizar os efeitos negativos do trabalho por turnos? Fazer refeições mais leves de noite; Ao sair de um turno da noite fazer uma refeição leve e equilibrada; Dormir sonos de 7/8 horas sempre que possível; Aproximar as condições de dormir àquelas que teria se fosse de noite; Desligar o telefone durante as horas de descanso para evitar que o sono seja interrompido; Dormir uma sesta antes de iniciar o turno para evitar a sonolência durante o trabalho.', 'Imagem41.jpg', 3, NOW());
        INSERT INTO `SecurityDialog` (`code`, `thema`, `first_text`, `second_text`,`image`, `profile`, `created_at`) VALUES (LEFT(UUID(), 8), 'Circulação de Viaturas e Peões na Área Fabril', 'Na União Europeia morrem todos os anos mais de 1800 pessoas em acidentes no local de trabalho relacionados com a condução de viaturas. Os referidos acidentes envolvem normalmente pessoas que são atingidas ou atropeladas por veículos em movimento (por exemplo, durante manobras de marcha atrás ou de inversão de marcha); que caem de veículos; que são atingidas por objetos que caem dos veículos; ou por veículos que capotam.#', 'Na empresa a condução de viaturas ou operação de outros equipamentos ou máquinas, só é permitida a pessoal habilitado e autorizado para tal. | Qual a velocidade limite na área fabril? | Transmitir aos colaboradores algumas regras de segurança a observar na condução de viaturas: Deve realizar inspeções diárias à viatura; Não deve conduzir quando não estiver em boas condições físicas, por exemplo, quando estiver doente ou tiver problemas de visão; Deve prestar atenção ao espaço circundante; É necessário ter atenção às portas, passagens ou vias onde possam aparecer subitamente peões ou veículos. | E sobre os peões? Perguntar ao grupo se respeitaram as passadeiras e corredores de passagem, quando caminharam até este encontro?', 'Imagem42.jpg', 3, NOW());
        INSERT INTO `SecurityDialog` (`code`, `thema`, `first_text`, `second_text`,`image`, `profile`, `created_at`) VALUES (LEFT(UUID(), 8), 'Higiene e Limpeza Pessoal', 'Um laboratório no Brasil, testou 5 capacetes. 1 capacete tinha menos de 1 mês e estava sujo. Os restantes tinham mais de 1 mês. Um deles tinha 1 ano e meio. Estes 4 capacetes foram lavados antes do teste. O capacete novo e sujo tinha 100 vezes mais bactérias que todos os outros. #', 'Peça a cada colaborador que avalie as suas condições de higiene e limpeza dos seus EPI`s | Transmitir aos colaboradores algumas boas práticas de higiene e limpeza: Os EPI´s e vestuário devem ser verificados e limpos, se possível antes, e obrigatoriamente, depois de cada utilização; Se detetar que os seus EPI´s e vestuário de trabalho estão danificados, deve proceder à sua substituição, o mais rapidamente possível. ', 'Imagem43.jpg', 3, NOW());
        INSERT INTO `SecurityDialog` (`code`, `thema`, `first_text`, `second_text`,`image`, `profile`, `created_at`) VALUES (LEFT(UUID(), 8), 'Não inventem!', 'Há vários acidentes na empresa, resultantes de `invenções` que têm a melhor das intenções (trabalhar mais depressa). Mas são perigosas. E para a empresa é uma prioridade que as suas pessoas não se magoem!#', 'Lançar as seguintes questões: Há quantos anos foi fundada a empresa? Cada procedimento e forma de trabalho na empresa, terá já sido feita e analisada por quantas pessoas? O objetivo destas perguntas é clarificar que as regras que existem, tiveram o contributo de muitas pessoas. De muitas gerações. Sempre que alguém inventa uma nova forma ou não cumpre uma regra, está a desaproveitar o conhecimento de quase 50 anos | Claro que se existirem sugestões, são bem vindas. Apresentem-nas. Mas até serem aprovadas, deve ser respeitado o processo de trabalho definido | Pedir ao grupo para descrever invenções na empresa que tenham visto (sem citar nomes) e que as tenham achado perigosas. ', 'Imagem44.jpg', 3, NOW());
        INSERT INTO `SecurityDialog` (`code`, `thema`, `first_text`, `second_text`,`image`, `profile`, `created_at`) VALUES (LEFT(UUID(), 8), 'Lavagem das Mãos', 'Lavar as mãos reduz o risco de doença em 20% e o risco de infeções em 60% (fonte: estudo do Hygiene Council - realizado em onze países, entre eles Portugal). Uma em cada cinco pessoas não lava as mãos depois de utilizar a casa-de-banho, aumentando o risco de transmissão de doenças infecto-contagiosas (fonte: estudo da Faculdade de Ciências Médicas).#', 'Conversar com o grupo sobre o seu dia-a-dia e ajudar a definir rotinas de `Lavar as mãos` (onde e quando o devem fazer) | Por uma questão de simbolismo, propor ao grupo que termine a conversa com deslocação à casa de banho para lavar as mãos.', 'Imagem45.jpg', 3, NOW());
        INSERT INTO `SecurityDialog` (`code`, `thema`, `first_text`, `second_text`,`image`, `profile`, `created_at`) VALUES (LEFT(UUID(), 8), 'Chuveiros e Lava-Olhos de Emergência', 'Estes equipamentos de proteção coletiva são imprescindíveis em locais onde se manuseiam e armazenam produtos químicos. São destinados a eliminar ou minimizar os danos causados por acidentes nos olhos e/ou face e em qualquer parte do corpo.#', 'Na empresa existem diversos produtos químicos que podem representar risco para a saúde dos trabalhadores.| Converse com o grupo sobre os procedimentos de segurança: Antes de iniciar o trabalho, deve-se verificar onde estão instalados os chuveiros e lava olhos de emergência; Se for atingido acidentalmente por um  produto químico recorra, rapidamente,  a  estes equipamentos de proteção. | Peça a cada elemento da equipa que, durante o dia de trabalho, verifique se existem, no seu local de trabalho e zonas circundantes, chuveiros e/ou lava olhos de emergência, e testem o seu funcionamento. Caso surjam dúvidas contactem o departamento da segurança. ', 'Imagem46.jpg', 3, NOW());
        INSERT INTO `SecurityDialog` (`code`, `thema`, `first_text`, `second_text`,`image`, `profile`, `created_at`) VALUES (LEFT(UUID(), 8), 'Derrames de Óleo e Produtos Químicos', 'Sempre que existe um derrame acidental de óleo ou produtos químicos, este deve ser controlado rapidamente, pois pode causar uma explosão, incêndio ou contaminar o solo.#', 'Questione o grupo: sabem o que fazer caso exista um derrame? | Transmitir aos colaboradores alguns dos procedimentos a adotar: Em caso de derrame de óleos ou de outros produtos químicos, proceda à sua rápida contenção e remoção, recorrendo ao uso de substâncias absorventes (areia, kit anti derrame, etc.), estrategicamente distribuídas pelo recinto da fabrica; Se os produtos forem corrosivos NUNCA usar panos, serradura ou qualquer absorvente orgânico; No caso de não ser possível fazê-lo de imediato, deverá sinalizar a área, e contactar, o mais rapidamente possível, o Serviço de Proteção Contra Incêndios ou o Bombeiro de serviço. ', 'Imagem47.jpg', 3, NOW());
        INSERT INTO `SecurityDialog` (`code`, `thema`, `first_text`, `second_text`,`image`, `profile`, `created_at`) VALUES (LEFT(UUID(), 8), 'Ar Comprimido', 'Um jato de ar comprimido mal direcionado pode provocar lesões severas nos olhos, rutura do tímpano, lesões nos pulmões, no esófago, infeções na pele, hemorragias internas, entre outras. Em Maio de 2011, um motorista de camião de 48 anos, caiu em cima de uma mangueira de ar comprimido, quebrando-a. O bico da mangueira perfurou-lhe o corpo, bombeando ar para dentro do seu corpo, que inchou rapidamente. Por sorte, não morreu.#', 'Quem já utilizou o ar comprimido para limpar a roupa? Tinham consciência destes riscos? Nunca use o ar comprimido para limpeza do corpo ou das roupas; Jamais permita que o jacto de ar sob pressão incida sobre o seu corpo ou de um colega; Antes de abrir qualquer válvula de ar comprimido, certifique-se que as conexões, mangueiras e abraçadeiras estejam presas de forma adequada e segura; Nunca abra a válvula ou o registro rapidamente, faça-o sempre devagar; Utilize os EPI´s adequados para cada situação (óculos, viseira, mascara, luvas...) | Identifique no grupo que trabalhos envolvendo ar comprimido serão realizados na próxima semana.', 'Imagem48.png', 3, NOW());
        /*!40000 ALTER TABLE `SecurityDialog` ENABLE KEYS */;
        
        CREATE TABLE IF NOT EXISTS `SecurityDialogAnswer` (
            `idSecurityDialogAnswer` int(11) NOT NULL AUTO_INCREMENT,
            `user` int(11) NOT NULL,
            `securitydialogweek` int(11) NOT NULL,
            `attendance` TEXT NOT NULL,
            `created_at` datetime NOT NULL,
            `deleted_at` datetime NULL,
            `deleted` int(11) DEFAULT '0',
            PRIMARY KEY (`idSecurityDialogAnswer`)
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
          
        DELETE FROM `SecurityDialogAnswer`;
		
        /*!40000 ALTER TABLE `SecurityDialogAnswer` DISABLE KEYS */;
        /*!40000 ALTER TABLE `SecurityDialogAnswer` ENABLE KEYS */;";

        if (parent::createDatabase()) {
            $this->createProfile();
        }
    }

    private function createProfile() {
        $this->create_database = "CREATE TABLE IF NOT EXISTS `Profile` (
            `idProfile` int(11) NOT NULL AUTO_INCREMENT,
            `name` varchar(50) NOT NULL,
            `status` int(11) NOT NULL,
            `created_at` datetime DEFAULT NULL,
            `deleted_at` datetime DEFAULT NULL,
            `deleted` int(11) DEFAULT NULL,
            PRIMARY KEY (`idProfile`)
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

        DELETE FROM `Profile`;
		
        /*!40000 ALTER TABLE `Profile` DISABLE KEYS */;
        INSERT INTO `Profile` (`idProfile`, `name`, `status`, created_at, deleted) VALUES (1, 'Direção de Fábrica', 1, NOW(), 0);
        INSERT INTO `Profile` (`idProfile`, `name`, `status`, created_at, deleted) VALUES (2, 'Direção', 1, NOW(), 0);
        INSERT INTO `Profile` (`idProfile`, `name`, `status`, created_at, deleted) VALUES (3, 'Chefia', 1, NOW(), 0);
        INSERT INTO `Profile` (`idProfile`, `name`, `status`, created_at, deleted) VALUES (4, 'Operacional', 1, NOW(), 0);
        INSERT INTO `Profile` (`idProfile`, `name`, `status`, created_at, deleted) VALUES (5, 'Direção de Segurança', 1, NOW(), 0);
        /*!40000 ALTER TABLE `Profile` ENABLE KEYS */;";
        if (parent::createDatabase()) {
            $this->createSecurityDialogWeek();
        }
    }

    private function createSecurityDialogWeek() {
        $this->create_database = "CREATE TABLE IF NOT EXISTS `SecurityDialogWeek` (
            `idSecurityDialogWeek` int(11) NOT NULL AUTO_INCREMENT,
            `securitydialog` int(11) NOT NULL,
            `year` int(11) NOT NULL,
            `week` int(11) NOT NULL,
            `last_notification` DATETIME NULL,
            `created_at` datetime DEFAULT NULL,
            `deleted_at` datetime DEFAULT NULL,
            `deleted` int(11) DEFAULT '0',
            PRIMARY KEY (`idSecurityDialogWeek`),
            CONSTRAINT `FK_SecurityDialogWeek_SecurityDialog` FOREIGN KEY (`securitydialog`) REFERENCES `SecurityDialog` (`idSecurityDialog`) ON DELETE CASCADE ON UPDATE CASCADE
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

        DELETE FROM `SecurityDialogWeek`;
		
        /*!40000 ALTER TABLE `SecurityDialogWeek` DISABLE KEYS */;
        /*!40000 ALTER TABLE `SecurityDialogWeek` ENABLE KEYS */;";
        if (parent::createDatabase()) {
            $this->createSafetyWalkTables();
        }
    }
    
    private function createSafetyWalkTables() {
        $this->create_database = "CREATE TABLE IF NOT EXISTS `SafetyWalk` (
            `idSafetyWalk` int(11) NOT NULL AUTO_INCREMENT,
            `code` int(11) DEFAULT NULL,
            `started_at` datetime NOT NULL,
            `status` int(11) DEFAULT NULL,
            `type` int(11) NOT NULL,
            `qtt` int(11) NOT NULL,
            `last_notification` datetime NOT NULL,
            `profile` int(11) NOT NULL,
            `created_at` datetime NOT NULL,
            `deleted_at` datetime DEFAULT NULL,
            `deleted` int(11) DEFAULT '0',
            PRIMARY KEY (`idSafetyWalk`),
            UNIQUE KEY `code` (`code`)
          ) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

        DELETE FROM `SafetyWalk`;
		
        /*!40000 ALTER TABLE `SafetyWalk` DISABLE KEYS */;
        /*!40000 ALTER TABLE `SafetyWalk` ENABLE KEYS */;

          CREATE TABLE IF NOT EXISTS `SafetyWalkQuestion` (
            `idSafetyWalkQuestion` int(11) NOT NULL AUTO_INCREMENT,
            `safetywalk` int(11) NOT NULL,
            `text` longtext NOT NULL,
            `checkbox` int(11) NOT NULL,
            `ord` int(11) DEFAULT NULL,
            `created_at` datetime NOT NULL,
            `deleted_at` datetime NULL,
            `deleted` int(11) DEFAULT '0',
            PRIMARY KEY (`idSafetyWalkQuestion`),
            KEY `FK_SafetyWalkQuestion_SafetyWalk` (`safetywalk`)
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

        DELETE FROM `SafetyWalkQuestion`;
		
        /*!40000 ALTER TABLE `SafetyWalkQuestion` DISABLE KEYS */;
        /*!40000 ALTER TABLE `SafetyWalkQuestion` ENABLE KEYS */;

          CREATE TABLE IF NOT EXISTS `SafetyWalkAnswer` (
            `idSafetyWalkAnswer` int(11) NOT NULL AUTO_INCREMENT,
            `safetywalk` int(11) DEFAULT NULL,
            `user` int(11) DEFAULT NULL,
            `sector` int(11) NOT NULL,
            `userfollow` longtext NULL,
            `comment` longtext NULL,
            `created_at` datetime DEFAULT NULL,
            `deleted_at` datetime DEFAULT NULL,
            `deleted` int(11) DEFAULT '0',
            PRIMARY KEY (`idSafetyWalkAnswer`)
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

        DELETE FROM `SafetyWalkAnswer`;
		
        /*!40000 ALTER TABLE `SafetyWalkAnswer` DISABLE KEYS */;
        /*!40000 ALTER TABLE `SafetyWalkAnswer` ENABLE KEYS */;

          CREATE TABLE IF NOT EXISTS `SafetyWalkAnswerQuestion` (
            `idSafetyWalkAnswerQuestion` int(11) NOT NULL AUTO_INCREMENT,
            `safetywalkanswer` int(11) DEFAULT NULL,
            `safetywalkquestion` int(11) DEFAULT NULL,
            `value` LONGTEXT DEFAULT NULL,
            `created_at` datetime DEFAULT NULL,
            `deleted_at` datetime DEFAULT NULL,
            `deleted` int(11) DEFAULT '0',
            PRIMARY KEY (`idSafetyWalkAnswerQuestion`)
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

        DELETE FROM `SafetyWalkAnswerQuestion`;
		
        /*!40000 ALTER TABLE `SafetyWalkAnswerQuestion` DISABLE KEYS */;
        /*!40000 ALTER TABLE `SafetyWalkAnswerQuestion` ENABLE KEYS */;";
        if (parent::createDatabase()) {
            $this->createMonitors();
        }
    }
    
    private function createMonitors() {
        $this->create_database = "CREATE TABLE IF NOT EXISTS `Monitor` (
          `idMonitor` int(11) NOT NULL AUTO_INCREMENT,
          `description` varchar(50) NOT NULL,
          `created_at` datetime DEFAULT NULL,
          `deleted_at` datetime DEFAULT NULL,
          `deleted` int(11) DEFAULT '0',
          PRIMARY KEY (`idMonitor`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

        DELETE FROM `Monitor`;
		
        /*!40000 ALTER TABLE `Monitor` DISABLE KEYS */;
        INSERT INTO `Monitor` (`idMonitor`, `description`, created_at, deleted) VALUES (1, '%%Quality Monitor%%', NOW(), 0);
        INSERT INTO `Monitor` (`idMonitor`, `description`, created_at, deleted) VALUES (2, '%%Surveys%%', NOW(), 0);
        INSERT INTO `Monitor` (`idMonitor`, `description`, created_at, deleted) VALUES (3, '%%Administrator Insecurities Monitor%%', NOW(), 0);
        INSERT INTO `Monitor` (`idMonitor`, `description`, created_at, deleted) VALUES (4, '%%User Insecurities Monitor%%', NOW(), 0);
        /*!40000 ALTER TABLE `Monitor` ENABLE KEYS */;

        CREATE TABLE IF NOT EXISTS `ProfileMonitor` (
          `idProfileMonitor` int(11) NOT NULL AUTO_INCREMENT,
          `profile` int(11) NOT NULL,
          `monitor` int(11) NOT NULL,
          `status` int(11) NOT NULL,
          `created_at` datetime DEFAULT NULL,
          `deleted_at` datetime DEFAULT NULL,
          `deleted` int(11) DEFAULT '0',
          PRIMARY KEY (`idProfileMonitor`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

        DELETE FROM `ProfileMonitor`;
		
        /*!40000 ALTER TABLE `ProfileMonitor` DISABLE KEYS */;
        INSERT INTO `ProfileMonitor` (`idProfileMonitor`, `profile`, `monitor`, `status`, created_at, deleted) VALUES (1, 2, 1, 1, NOW(), 0);
        INSERT INTO `ProfileMonitor` (`idProfileMonitor`, `profile`, `monitor`, `status`, created_at, deleted) VALUES (2, 2, 2, 1, NOW(), 0);
        INSERT INTO `ProfileMonitor` (`idProfileMonitor`, `profile`, `monitor`, `status`, created_at, deleted) VALUES (2, 2, 3, 1, NOW(), 0);
        /*!40000 ALTER TABLE `ProfileMonitor` ENABLE KEYS */;";
        
        if (parent::createDatabase()) {
            $this->createEventsPhase1();
        }
    }
    
    private function createEventsPhase1() {
        $this->create_database = "
            DROP PROCEDURE IF EXISTS ManageSurveyNotifications;
            DROP PROCEDURE IF EXISTS GenerateSurveyNotifications;
            DROP PROCEDURE IF EXISTS ManageSecurityDialogNotifications;
            DROP PROCEDURE IF EXISTS GenerateSecurityDialogNotifications;
            DROP PROCEDURE IF EXISTS ManageSafetyWalkNotifications;
            DROP PROCEDURE IF EXISTS GenerateSafetyWalkNotifications;
        ";
        
        if (parent::createDatabase()) {
            $this->createEventsPhase2();
        }
    }
    
    private function createEventsPhase2() {
        $this->create_database = "
        CREATE PROCEDURE ManageSurveyNotifications(IN tipo INT(11))
        BEGIN
        	DECLARE done BOOLEAN DEFAULT FALSE;
        	DECLARE _idUser BIGINT UNSIGNED;
        	DECLARE _idSurvey BIGINT UNSIGNED;
        	DECLARE _qtt BIGINT UNSIGNED;
        	DECLARE _started_at DATETIME;
            DECLARE _last_notification DATETIME;
            DECLARE _type BIGINT UNSIGNED;
        	DECLARE cur CURSOR FOR 
        	(
        		select u.idUser, s.idSurvey, s.qtt, s.started_at, s.last_notification, s.type
        		from ichooses_main.User u
        		inner join ichooses_main.UserLicense ul on u.idUser = ul.user
        		inner join ichooses_main.Company c on ul.company = c.idCompany and c.data_base in (SELECT DATABASE())
        		inner join (select * from Survey where qtt > 0) s on s.profile = u.profile
        		where 
        			u.deleted = 0 and s.last_notification <= NOW() and s.deleted = 0
        	);
        	DECLARE CONTINUE HANDLER FOR NOT FOUND SET done := TRUE;
        
        	OPEN cur;
        
        	NotifLoop: LOOP
        		FETCH cur INTO _idUser,_idSurvey,_qtt,_started_at,_last_notification,_type;
        		IF done THEN
        			LEAVE NotifLoop;
        		END IF;
                
                case
        			WHEN tipo = 1 THEN 
        				case 
        					WHEN _type = 1 THEN CALL GenerateSurveyNotifications(_qtt, _idUser, _idSurvey, CONCAT(date(DATE_ADD(_last_notification,INTERVAL 1 WEEK)), ' 23:59:59'));
        					WHEN _type = 2 THEN CALL GenerateSurveyNotifications(_qtt, _idUser, _idSurvey, CONCAT(date(DATE_ADD(_last_notification,INTERVAL 1 MONTH)), ' 23:59:59'));
        					WHEN _type = 3 THEN 
        						case
        							WHEN MONTH(NOW()) % 2 <> 0 then CALL GenerateSurveyNotifications(_qtt, _idUser, _idSurvey, CONCAT(date(DATE_ADD(_last_notification,INTERVAL 1 MONTH)), ' 23:59:59'));
                                    WHEN MONTH(NOW()) % 2 <> 1 then CALL GenerateSurveyNotifications(_qtt, _idUser, _idSurvey, CONCAT(date(DATE_ADD(_last_notification,INTERVAL 2 MONTH)), ' 23:59:59'));
        						end case;
        					WHEN _type = 4 THEN 
        						case
        							WHEN MONTH(NOW()) % 2 <> 0 then CALL GenerateSurveyNotifications(_qtt, _idUser, _idSurvey, CONCAT(date(DATE_ADD(_last_notification,INTERVAL 2 MONTH)), ' 23:59:59'));
                                    WHEN MONTH(NOW()) % 2 <> 1 then CALL GenerateSurveyNotifications(_qtt, _idUser, _idSurvey, CONCAT(date(DATE_ADD(_last_notification,INTERVAL 1 MONTH)), ' 23:59:59'));
        						end case; 
                        end case;
                    WHEN tipo = 2 THEN CALL GenerateSurveyNotifications(_qtt, _idUser, _idSurvey, _last_notification);
                end case;
                
        		
        	END LOOP NotifLoop;
        
        	CLOSE cur;
            
            /* Apagar tudo que ja foi ultrapassado */
            update Notification set deleted = 1, deleted_at = NOW() where table1 = 'survey' and date_limit < NOW() and deleted = 0 and type = 1;
        END
        ";
        
        if (parent::createDatabase()) {
            $this->createEventsPhase3();
        }
    }
    
    private function createEventsPhase3() {
        $this->create_database = "
        CREATE PROCEDURE GenerateSurveyNotifications(IN qtd_ INT(11), IN iduser_ INT(11), IN idsurvey_ INT(11), IN datelimit_ datetime)
        BEGIN
        	DECLARE x INT;
            
        	SET x = 0;
        	WHILE x < qtd_ DO
        		insert into Notification (user, table1, value1, date_limit, title, description, created_at, type) 
                VALUES (
        			iduser_,
                    'survey',
                    idsurvey_,
                    datelimit_,
                    '%%Survey to Answer%%',
                    CONCAT('%%Reply to Survey Until%% ',datelimit_),
                    NOW(),
                    1
                );
        
        		SET  x = x + 1; 
        	END WHILE;
            
            update Survey set last_notification = datelimit_ where idSurvey = idsurvey_;
        END
        ";
        
        if (parent::createDatabase()) {
            $this->createEventsPhase4();
        }
    }
    
    private function createEventsPhase4() {
        $this->create_database = "
        CREATE PROCEDURE ManageSecurityDialogNotifications(IN tipo INT(11))
        BEGIN
        	DECLARE done BOOLEAN DEFAULT FALSE;
        	DECLARE _idUser BIGINT UNSIGNED;
        	DECLARE _idSecurityDialog BIGINT UNSIGNED;
            DECLARE _thema LONGTEXT;
            DECLARE _idSecurityDialogWeek BIGINT UNSIGNED;
            DECLARE _last_notification DATETIME;
            DECLARE _week BIGINT UNSIGNED;
        	DECLARE _year BIGINT UNSIGNED;
        	DECLARE cur CURSOR FOR 
        	(
        		select u.idUser, sd.idSecurityDialog, sd.thema, sdw.idSecurityDialogWeek, sdw.last_notification, sdw.week, sdw.year
        		from ichooses_main.User u
        		inner join ichooses_main.UserLicense ul on u.idUser = ul.user
        		inner join ichooses_main.Company c on ul.company = c.idCompany and c.data_base in (SELECT DATABASE())
        		inner join SecurityDialog sd on sd.profile = u.profile
        		inner join SecurityDialogWeek sdw on sd.idSecurityDialog = sdw.securitydialog
        		where 
        			u.deleted = 0 and u.status = 1 and sd.deleted = 0 and sdw.deleted = 0 and
        			sdw.week = WEEK(NOW())+1 and sdw.year = YEAR(NOW()) and sdw.last_notification IS NULL
        	);
        	DECLARE CONTINUE HANDLER FOR NOT FOUND SET done := TRUE;
        
        	OPEN cur;
        
        	NotifLoop: LOOP
        		FETCH cur INTO _idUser,_idSecurityDialog,_thema,_idSecurityDialogWeek,_last_notification,_week,_year;
        		IF done THEN
        			LEAVE NotifLoop;
        		END IF;
                
                CALL GenerateSecurityDialogNotifications(_idUser, _idSecurityDialog, _idSecurityDialogWeek, _week, _year);
        
        	END LOOP NotifLoop;
        
        	CLOSE cur;
            
            /* Apagar tudo que ja foi ultrapassado */
            update Notification set deleted = 1, deleted_at = NOW() where table1 = 'securitydialogweek' and date_limit < NOW() and deleted = 0 and type = 2;
            
        END
        ";
        
        if (parent::createDatabase()) {
            $this->createEventsPhase5();
        }
    }
    
    private function createEventsPhase5() {
        $this->create_database = "
        CREATE PROCEDURE GenerateSecurityDialogNotifications(IN iduser_ INT(11), IN idSecurityDialog_ INT(11), IN idSecurityDialogWeek_ INT(11), IN week_ INT(11), IN year_ INT(11))
        BEGIN
        	insert into Notification (user, table1, value1, date_limit, title, description, created_at, type) 
        	VALUES (
        		iduser_,
        		'securitydialogweek',
        		idSecurityDialogWeek_,
        		CONCAT(DATE_ADD(DATE_ADD(STR_TO_DATE(CONCAT(year_, '-01-01 23:59:59'),'%Y-%m-%d'), INTERVAL 7*week_ DAY), INTERVAL -1 DAY), ' 23:59:59'),
        		'%%Dialogue to Answer%%',
        		CONCAT('%%Reply to Dialogue Until%% ', DATE_ADD(DATE_ADD(STR_TO_DATE(CONCAT(year_, '-01-01 23:59:59'),'%Y-%m-%d'), INTERVAL 7*week_ DAY), INTERVAL -1 DAY), ' 23:59:59'),
        		NOW(),
        		2
        	);
            
            update SecurityDialogWeek set last_notification = CONCAT(DATE_ADD(DATE_ADD(STR_TO_DATE(CONCAT(year_, '-01-01 23:59:59'),'%Y-%m-%d'), INTERVAL 7*week_ DAY), INTERVAL -1 DAY), ' 23:59:59') where idSecurityDialogWeek = idSecurityDialogWeek_;
        END
        ";
        
        if (parent::createDatabase()) {
            $this->createEventsPhase6();
        }
    }
    
    private function createEventsPhase6() {
        $this->create_database = "
        CREATE PROCEDURE ManageSafetyWalkNotifications(IN tipo INT(11))
        BEGIN
        	DECLARE done BOOLEAN DEFAULT FALSE;
        	DECLARE _idUser BIGINT UNSIGNED;
        	DECLARE _idSafetyWalk BIGINT UNSIGNED;
        	DECLARE _qtt BIGINT UNSIGNED;
        	DECLARE _started_at DATETIME;
            DECLARE _last_notification DATETIME;
            DECLARE _type BIGINT UNSIGNED;
        	DECLARE cur CURSOR FOR 
        	(
        		select u.idUser, s.idSafetyWalk, s.qtt, s.started_at, s.last_notification, s.type
        		from ichooses_main.User u
        		inner join ichooses_main.UserLicense ul on u.idUser = ul.user
        		inner join ichooses_main.Company c on ul.company = c.idCompany and c.data_base in (SELECT DATABASE())
        		inner join (select * from SafetyWalk where qtt > 0) s on s.profile = u.profile
        		where 
        			u.deleted = 0 and s.last_notification <= NOW() and s.deleted = 0
        	);
        	DECLARE CONTINUE HANDLER FOR NOT FOUND SET done := TRUE;
        
        	OPEN cur;
        
        	NotifLoop: LOOP
        		FETCH cur INTO _idUser,_idSafetyWalk,_qtt,_started_at,_last_notification,_type;
        		IF done THEN
        			LEAVE NotifLoop;
        		END IF;
                
                case
        			WHEN tipo = 1 THEN 
        				case 
        					WHEN _type = 1 THEN CALL GenerateSafetyWalkNotifications(_qtt, _idUser, _idSafetyWalk, CONCAT(date(DATE_ADD(_last_notification,INTERVAL 1 WEEK)), ' 23:59:59'));
        					WHEN _type = 2 THEN CALL GenerateSafetyWalkNotifications(_qtt, _idUser, _idSafetyWalk, CONCAT(date(DATE_ADD(_last_notification,INTERVAL 1 MONTH)), ' 23:59:59'));
        					WHEN _type = 3 THEN 
        						case
        							WHEN MONTH(NOW()) % 2 <> 0 then CALL GenerateSafetyWalkNotifications(_qtt, _idUser, _idSafetyWalk, CONCAT(date(DATE_ADD(_last_notification,INTERVAL 1 MONTH)), ' 23:59:59'));
                                    WHEN MONTH(NOW()) % 2 <> 1 then CALL GenerateSafetyWalkNotifications(_qtt, _idUser, _idSafetyWalk, CONCAT(date(DATE_ADD(_last_notification,INTERVAL 2 MONTH)), ' 23:59:59'));
        						end case;
        					WHEN _type = 4 THEN 
        						case
        							WHEN MONTH(NOW()) % 2 <> 0 then CALL GenerateSafetyWalkNotifications(_qtt, _idUser, _idSafetyWalk, CONCAT(date(DATE_ADD(_last_notification,INTERVAL 2 MONTH)), ' 23:59:59'));
                                    WHEN MONTH(NOW()) % 2 <> 1 then CALL GenerateSafetyWalkNotifications(_qtt, _idUser, _idSafetyWalk, CONCAT(date(DATE_ADD(_last_notification,INTERVAL 1 MONTH)), ' 23:59:59'));
        						end case; 
                        end case;
                    WHEN tipo = 2 THEN CALL GenerateSafetyWalkNotifications(_qtt, _idUser, _idSafetyWalk, _last_notification);
                end case;
                
        		
        	END LOOP NotifLoop;
        
        	CLOSE cur;
            
            /* Apagar tudo que ja foi ultrapassado */
            update Notification set deleted = 1, deleted_at = NOW() where table1 = 'safetywalk' and date_limit < NOW() and deleted = 0 and type = 3;
        END
        ";
        
        if (parent::createDatabase()) {
            $this->createEventsPhase7();
        }
    }
    
    private function createEventsPhase7() {
        $this->create_database = "
        CREATE PROCEDURE GenerateSafetyWalkNotifications(IN qtd_ INT(11), IN iduser_ INT(11), IN idsafetywalk_ INT(11), IN datelimit_ datetime)
        BEGIN
        	DECLARE x INT;
            
        	SET x = 0;
        	WHILE x < qtd_ DO
        		insert into Notification (user, table1, value1, date_limit, title, description, created_at, type) 
                VALUES (
        			iduser_,
                    'safetywalk',
                    idsafetywalk_,
                    datelimit_,
                    '%%Safety Walk to Answer%%',
                    CONCAT('%%Reply to Safety Walk Until%% ',datelimit_),
                    NOW(),
                    3
                );
        
        		SET  x = x + 1; 
        	END WHILE;
            
            update SafetyWalk set last_notification = datelimit_ where idSafetyWalk = idsafetywalk_;
        END
        ";
        
        if (parent::createDatabase()) {
            return true;
        }
    }

}
