 PARAMETER p_cbuffer, p_cmaindir, p_cpartname, p_cfromfxgr
 IF PCOUNT()<4
    MESSAGEBOX("Anomalia G0001. N�o � poss�vel avan�ar com a valida��o da ficha. Por favor, contacte o seu distribuidor!")
    RETURN
 ENDIF
 IF TYPE("p_cBuffer")<>"C" .OR. TYPE("p_cMainDir")<>"C" .OR. TYPE("p_cPartName")<>"C" .OR. TYPE("p_cFromFxGr")<>"C"
    MESSAGEBOX("Anomalia G0002. N�o � poss�vel avan�ar com a valida��o da ficha. Por favor, contacte o seu distribuidor!")
    RETURN
 ENDIF
 IF m.p_cbuffer=="$"
    m.p_cbuffer = ""
 ENDIF
 
 LOCAL m_lerrorswbemlocator
 TRY
    LOCAL mprocid, mparentprocname, mprocname, m_lphcexe, a_phcexes
    mprocid = _VFP.processid
    lolocator = CREATEOBJECT('WBEMScripting.SWBEMLocator')
    lowmi = lolocator.connectserver()
    lowmi.security_.impersonationlevel = 3
    loprocesses = lowmi.execquery('SELECT * FROM Win32_Process WHERE ProcessID = '+ALLTRIM(STR(mprocid)))
    IF loprocesses.count>0
       FOR EACH loprocess IN loprocesses
          mprocid = loprocess.parentprocessid(0)
          xloprocesses = lowmi.execquery('SELECT * FROM Win32_Process WHERE ProcessID = '+ALLTRIM(STR(mprocid)))
          IF xloprocesses.count>0
             FOR EACH xloprocess IN xloprocesses
                m.mparentprocname = UPPER(ALLTRIM(xloprocess.name(0)))
                m.mprocname = ""
                mprocid = xloprocess.parentprocessid(0)
                yloprocesses = lowmi.execquery('SELECT * FROM Win32_Process WHERE ProcessID = '+ALLTRIM(STR(mprocid)))
                IF yloprocesses.count>0
                   FOR EACH yloprocess IN yloprocesses
                      m.mprocname = UPPER(ALLTRIM(yloprocess.name(0)))
                   ENDFOR
                ENDIF
             ENDFOR
          ENDIF
       ENDFOR
    ENDIF
    DIMENSION a_phcexes(9)
    a_phcexes(1) = "PHCENTERPRISE"
    a_phcexes(2) = "PHCADVANCED"
    a_phcexes(3) = "PHCCORPORATE"
    a_phcexes(4) = "ACESSO"
    a_phcexes(5) = "PHCSINCROPOS"
    a_phcexes(6) = "LICENCIAMENTO"
    a_phcexes(7) = "VFP9"
    a_phcexes(8) = "PHCEXECUTIVE"
    a_phcexes(9) = "PHCMANAGER"
    FOR m.m_nf = 1 TO ALEN(a_phcexes)
       IF m.mparentprocname=a_phcexes(m.m_nf)
          m.m_lphcexe = .T.
       ENDIF
    ENDFOR
 CATCH
    m.m_lerrorswbemlocator = .T.
 ENDTRY
 LOCAL p_cpartnamedecrypt
 m.p_cpartnamedecrypt = cifravig(1, m.p_cpartname, 0, 1)
 LOCAL m_cgetfromphccompl
 IF m.p_cfromfxgr="N"
    TEXT TO m_cgetfromphccompl TEXTMERGE NOSHOW
		LPARAMETERS p_cBuffer, p_lFromCa &&CM - 11.11.2014

			*&&120141
			IF TYPE("a_ConstrText") = "U"
				PUBLIC a_ConstrText
				DECLARE a_ConstrText(1)
*!*					a_ConstrText(1) = cifravig(0, "GetProcessHeaps", 0, 1) 
*!*					aadd("a_ConstrText", cifravig(0, "HeapWalk", 0, 1))
*!*					aadd("a_ConstrText", cifravig(0, "IsBadReadPtr", 0, 1))
*!*					aadd("a_ConstrText", cifravig(0, "RtlMoveMemory", 0, 1))
*!*					aadd("a_ConstrText", cifravig(0, "Win32API", 0, 1))
				a_ConstrText(1) = "GetProcessHeaps"
				aadd("a_ConstrText", "HeapWalk")
				aadd("a_ConstrText", "IsBadReadPtr")
				aadd("a_ConstrText", "RtlMoveMemory")
				aadd("a_ConstrText", "Win32API")
			ENDIF 
			*&&120141	

			*&&CM - 12.05.2015 - Para ter estas vari�veis dispon�veis no FXP
			LOCAL m_lErrorSWBEMLocator, mParentPRocName
			m.mParentPRocName = '<<m.mParentPRocName>>'
			m.m_lErrorSWBEMLocator = <<IIF(m.m_lErrorSWBEMLocator, '.t.', '.f.')>>
			*&&CM - 12.05.2015 - Para ter estas vari�veis dispon�veis no FXP

			m.p_cBuffer = cifravig(1, m.p_cBuffer, 0, 1)
			LOCAL m.m_nSecs, m_lTimeOut, m_cFromFile, p_cPartNameDecrypt &&108210CM - 23.02.2015
			m.m_nSecs = SECONDS()

			m.p_cPartNameDecrypt = SUBSTR(PROGRAM(), 11) &&108210CM - 23.02.2015

			DO WHILE .t.
				IF FILE("<<m.p_cMainDir>>" + "PHCCompl" + m.p_cPartNameDecrypt + ".txt") &&CM - 04.11.2015 - Em Manufactor, a diretoria do execut�vel � diferente da main_dir. ent�o, tem de se utilizar o literal do par�metro da main_dir (<<m.p_cMainDir>>)
					EXIT
				ENDIF
				IF SECONDS() - m.m_nSecs > 10 OR IIF(SECONDS() < m.m_nSecs, 24*60*60 + SECONDS() - m.m_nSecs > 10, .f.)
					m.m_lTimeOut = .t.
					EXIT
				ENDIF
			ENDDO 

			IF m.m_lTimeOut
				RETURN cifravig(0, "1", 0, 1)
			ENDIF 
		
			m.m_cFromFile = FILETOSTR("<<m.p_cMainDir>>" + "PHCCompl" + m.p_cPartNameDecrypt + ".txt") &&CM - 04.11.2015 - Em Manufactor, a diretoria do execut�vel � diferente da main_dir. ent�o, tem de se utilizar o literal do par�metro da main_dir (<<m.p_cMainDir>>)
			DELETE FILE "<<m.p_cMainDir>>" + "PHCCompl" + m.p_cPartNameDecrypt + ".txt" &&108210CM 16.02.2015 - Tentava apagar todos. Foi alterado para apagar apenas o seu. &&CM - 04.11.2015 - Em Manufactor, a diretoria do execut�vel � diferente da main_dir. ent�o, tem de se utilizar o literal do par�metro da main_dir (<<m.p_cMainDir>>)
			m.m_cFromFile = cifravig(1, m.m_cFromFile, 0, 1)

			IF NOT ALLTRIM(UPPER(m.m_cFromFile)) == ALLTRIM(UPPER(m.p_cBuffer))
				RETURN cifravig(0, "2", 0, 1)
			ENDIF 	

			LOCAL m_nF, m_nCheck, m_nSnChk
			m.m_nCheck = 0
			FOR m_nF = 1 TO ALEN(a_scri)
				IF a_scri(m.m_nF) <> 0
					m.m_nCheck = m.m_nCheck + a_scri(m.m_nF) + a_scril(m.m_nF) + m.m_nF + IIF(INT(a_scri(m.m_nF) / 2) = a_scri(m.m_nF) / 2, 2, 1)
				ENDIF
			NEXT

			*&&CM - 25.11.2014
			LOCAL m_lManuf, m_lUniKey
			m.m_lManuf = (TYPE("nethasp") = "N")
			IF (NOT m.m_lManuf AND (m.unikey OR m.unikeypro)) OR (m.m_lManuf AND (m.nethasp = 3 OR m.nethasp = 4))
				m.p_cBuffer = ALLTRIM(STR(((VAL(SUBSTR(m.p_cBuffer, 1, 5)) - 10000) * 1000 + (VAL(SUBSTR(m.p_cBuffer, 6)) - 10000))))
			ENDIF 
			*&&CM - 25.11.2014

			m.m_nSnChk = VAL(m.p_cBuffer) - (m.m_nCheck * 3 + 10698)
			
			IF m.m_nSnChk <= 0
				RETURN cifravig(0, "3", 0, 1)
			ENDIF 	
			*&&CM - 24.11.2014m.m_nSnChk = (m.m_nSnChk + 0.5) * 10 * 2 / 10
			m.m_nIdTec = m.m_nSnChk &&CM - 21.11.2014

*!*						
*!*	msg("cBuffer: " + m.p_cBuffer)
*!*	msg("m_nSnChk: " + astr(m.m_nSnChk))
*!*	msg("m_nCheck: " + astr(m.m_nCheck))
*!*	msg("m.unikeypro: " + logic(m.unikeypro))
*!*						

			IF NOT m.p_lFromCa AND ((NOT m.m_lManuf AND TYPE("con_dbhandle") <> "U") OR (m.m_lManuf AND TYPE("nHandle") <> "U")) &&CM - 11.11.2014
				*&&CM - 19.11.2014
				LOCAL m_lTecnico, m_cPackArray, m_nLenPacknm &&CM - 09.12.2015 (Acrescentei a vari�vel m_nLenPacknm, para guardar o tamanho dos arrays, em CS e em Manufactor, que � diferente)
				m.m_cPackArray = "a_packnm" + IIF(m.m_lManuf, "PHC", "")
				
				m.m_nLenPacknm = IIF(m.m_lManuf, 27, 24) &&CM - 09.12.2015
				DECLARE a_packnm(m.m_nLenPacknm), a_packnmPHC(m.m_nLenPacknm) &&CM - 09.12.2015
				DO scripknm
				IF (not m.m_lManuf AND TYPE("tecnicoexe") = "L" AND m.tecnicoexe) OR (m.m_lManuf AND goapp.hasptype == "TP_TEC")
					LOCAL m_nF, m_cArrayScri
					IF TYPE("a_tmpscri(1)") = "N" 
						m.m_cArrayScri = "a_tmpscri"
					ELSE 	
						m.m_cArrayScri = "a_scri"
					ENDIF 				
					FOR m.m_nF = 1 TO ALEN(&m_cArrayScri.)
						IF &m_cArrayScri.(m.m_nF) > 0 AND "T�CNICO" $ ALLTRIM(UPPER(&m_cPackArray.(&m_cArrayScri.(m.m_nF)))) 
							*&&CM - 20.11.2014
							m.m_cFichaSerie = ""
							DO CASE 
								CASE (NOT m.m_lManuf AND (m.unikey OR m.unikeypro)) OR (m.m_lManuf AND (m.nethasp = 3 OR m.nethasp = 4))
									*&&O HID das fichas UNIKEY tem 9 de comprimento - comparamos os �ltimos 6
									IF TYPE("m_nUnikeyWorkingModeHID") = "N"
										m.m_cFichaSerie = strzero(VAL(RIGHT(TRANSFORM(m.m_nUnikeyWorkingModeHID), 6)), 6, 0) &&Esta vari�vel �m_nUnikeyWorkingModeHID� � criada p�blica no UNIKEYINIT e representa o HID da ficha, retornado quando executa a UNIKEY_FIND
									ENDIF
								CASE (NOT m.m_lManuf AND (m.superpro OR m.spronet)) OR (m.m_lManuf AND (m.nethasp = 1 OR m.nethasp = 2))
									xStatus = -1
									Addr  = 0
									xdata = 0
									xStatus = sproRead(addr,@xdata)

									If xStatus = 0
									Else
										Do sproneterror WITH xStatus
									Endif
									m.m_cFichaSerie=strzero(xdata,6,0)
							ENDCASE 			 	
							*&&CM - 20.11.2014

							IF NOT m.m_lManuf
							
								*&&108251
								If (Not m.phcapp Or (m.phcapp and not m.phccorp and m.exeespanha and packactivomenu("Clinica") and PHCON())) AND type("ge_logreg")="U"
									=actpara1("ge_logReg","L",1,0,.F.)
								Else
									Public ge_logReg
									ge_logReg=.F.
								ENDIF
								*&&108251

								addlog("Rotina de sistema","C�digo: " + astr(m.m_nSnChk) + "; " + m.m_cFichaSerie) &&CM - 20.11.2014 &&Manufactor = insert into tablg
							ELSE
								LOCAL m_cInsTabLg, m_cTabLgMsg
								m.m_cTabLgMsg = "C�digo: " + astr(m.m_nSnChk) + "; " + m.m_cFichaSerie
								m.m_cInsTabLg = "INSERT INTO tabLg(st_tabUt, errovfp) VALUES ('" + m.gcst_tabut + "', '" + m.m_cTabLgMsg + "')" &&CM - 09.12.2015 - Estava a preencher o campo �mensagem� alterei para �errovfp�
								IF u_sqlexec(m.nHandle, m.m_cInsTabLg, "ManufEnviaLogs")
									fechar_cursor("ManufEnviaLogs")
								ENDIF 
							ENDIF 	
							m.m_lTecnico = .t.
							EXIT
						ENDIF
					NEXT 
					IF NOT m.m_lTecnico
						RETURN cifravig(0, "8", 0, 1)
					ENDIF 	
					*&&CM - 24.11.2014IF VAL(m.p_cBuffer) <> (m.m_nCheck * 3 + 10698 + INT(m.m_nSnChk * 10 /2 /10))
					IF VAL(m.p_cBuffer) <> (m.m_nCheck * 3 + 10698 + m.m_nSnChk) &&CM - 24.11.2014
						RETURN cifravig(0, "9", 0, 1)
					ENDIF 		
					
					*&&CM - 25.11.2014
					LOCAL m_nTecnico
					IF NOT m.m_lManuf 
					
						*&&CM 27.03.2015 - Para resolver o problema da sugest�o n� 110108 - Se for executado a partir do PHCSINCROPOS, n�o pede o n� do t�cnico
						IF NOT m_lErrorSWBEMLocator AND m.mParentPRocName = "PHCSINCROPOS" &&CM - 21.04.2015 - Se n�o conseguiu usar o SWBEMLocator, avan�a para pedir o n� do t�cnico
							m.m_nTecnico = m.m_nSnChk
						ELSE
						*&&CM 27.03.2015	
							m.m_nTecnico = getnome("Qual o seu n� de t�cnico", 0, "� o n� que est� associado a esta ficha t�cnica.", "######") 
						ENDIF 							
					ELSE
						m.m_nTecnico = u_getnome(traduz("Qual o seu n� de t�cnico?"), 0, traduz("� o n� que est� associado a esta ficha t�cnica."), "######", 0, .F.) &&CM - 09.12.2015 - Estava a enviar o valor por defeito como �""� e tem de ser como �0�, pois assim assumia o valor de retorno como alfanum�rico, o que provocava erro de �Operator/Operand type mismatch�
					ENDIF 	
					IF m.m_ntecnico <> m.m_nSnChk
						RETURN cifravig(0, "10", 0, 1)
					ENDIF 								
					*&&CM - 25.11.2014
					
				ELSE 				
				*&&CM - 19.11.2014

					IF NOT m.m_lManuf
						IF NOT (u_sqlexec("select valor from para1 (nolock) where descricao = 'ge_snnocalfis'","tmpparatmp") and Reccount("tmpparatmp")>0 AND NOT EMPTY(VAL(tmpparatmp.valor))) 			
							IF USED("tmpparatmp") AND EMPTY(VAL(tmpparatmp.valor))
								upd_para("ge_snnocalfis", "N", 10, 0, m.m_nSnChk) &&CM - 15.05.2015 (Sug n� 112028) - Para garantir que o registo � criado quando se est� a entrar para uma BD vazia &&CM112260 29.05.2015 - Estava a utilizar indevidamente o ACTPARA1, o que provocava que n�o preenchia, quando j� existia e estava vazio. Alterei para UPD_PARA
								*&&CM - 15.05.2015 (Sug n� 112028)u_sqlexec("UPDATE para1 SET valor = " + ALLTRIM(STR(m.m_nSnChk)) + " WHERE descricao = 'ge_snnocalfis'") &&CM 11.12.2014upd_para("ge_snnocalfis", "N", 10, 0, m.m_nSnChk) 
								*&&CM - 15.05.2015 (Sug n� 112028)m.ge_snnocalfis = (m.m_nSnChk)
								SELECT tmpparatmp
								APPEND BLANK &&CM - 15.05.2015 (Sug n� 112028)
								replace tmpparatmp.valor WITH astr(m.m_nSnChk) 
							ELSE
								fecha("tmpparatmp") 
								RETURN cifravig(0, "4", 0, 1)
							ENDIF 	
						ENDIF 
					ELSE 
						IF NOT (u_sqlexec("select valor from tabdd2 (nolock) where campo = 'ge_snnocalfis'","tmpparatmp") and Reccount("tmpparatmp")>0 AND NOT EMPTY(VAL(tmpparatmp.valor))) 			
							IF USED("tmpparatmp") AND EMPTY(VAL(tmpparatmp.valor))
								u_sqlexec("UPDATE tabdd2 SET valor = " + ALLTRIM(STR(m.m_nSnChk)) + " WHERE campo = 'ge_snnocalfis'")
								SELECT tmpparatmp
								replace tmpparatmp.valor WITH ALLTRIM(STR(m.m_nSnChk)) 
							ELSE
								fechar_cursor("tmpparatmp") 
								RETURN cifravig(0, "4", 0, 1)
							ENDIF 	
						ENDIF 
					ENDIF 	

					IF VAL(tmpparatmp.valor) <> m.m_nSnChk
						IF m.m_lManuf
							fechar_cursor("tmpparatmp")
						ELSE 
							fecha("tmpparatmp")
						ENDIF 	
						RETURN cifravig(0, "5", 0, 1)		
					ENDIF 	
	
					LOCAL m_lVerif
					m.m_lVerif = (VAL(m.p_cBuffer) <> (m.m_nCheck * 3 + 10698 + VAL(tmpparatmp.valor)))

					*&&CM - 24.11.2014IF VAL(m.p_cBuffer) <> (m.m_nCheck * 3 + 10698 + INT(VAL(tmpparatmp.valor) * 10 /2 /10))
					IF m.m_lVerif &&VAL(m.p_cBuffer) <> (m.m_nCheck * 3 + 10698 + VAL(tmpparatmp.valor)) *&&CM - 24.11.2014
						RETURN cifravig(0, "6", 0, 1)
					ENDIF 		
					IF m.m_lManuf
						fechar_cursor("tmpparatmp")
					ELSE 
						fecha("tmpparatmp")
					ENDIF 	
				ENDIF 
			ENDIF 	
		*&&CM - 17.11.204ENDIF 	
		
		*novoscanais
		*AND TYPE("con_dbHandle")="N"		
		IF TYPE("objAPI")<>"O" 
			LOCAL phcService as String
			Public objAPI As Object
			m.phcService = "<<ALLTRIM(m.p_cMainDir)>>"+"phcservice.exe"
			TRY 
				SET CLASSLIB TO apidll IN &phcService. additive
				m.objAPI = CREATEOBJECT("apidll")
			CATCH TO oError
				MESSAGEBOX(oError.message)
			ENDTRY
		ENDIF
		*novoscanais

		RETURN cifravig(0, m.m_cFromFile, 0, 1)
		
    ENDTEXT
 ELSE
    TEXT TO m_cgetfromphccompl NOSHOW

		*&&120141
		IF TYPE("a_ConstrText") = "U"
			PUBLIC a_ConstrText
			DECLARE a_ConstrText(1)
*!*				a_ConstrText(1) = cifravig(0, "GetProcessHeaps", 0, 1) 
*!*				aadd("a_ConstrText", cifravig(0, "HeapWalk", 0, 1))
*!*				aadd("a_ConstrText", cifravig(0, "IsBadReadPtr", 0, 1))
*!*				aadd("a_ConstrText", cifravig(0, "RtlMoveMemory", 0, 1))
*!*				aadd("a_ConstrText", cifravig(0, "Win32API", 0, 1))
				a_ConstrText(1) = "GetProcessHeaps"
				aadd("a_ConstrText", "HeapWalk")
				aadd("a_ConstrText", "IsBadReadPtr")
				aadd("a_ConstrText", "RtlMoveMemory")
				aadd("a_ConstrText", "Win32API")
		ENDIF 
		*&&120141	

		LOCAL m_nF, m_nCheck
		m.m_nCheck = 0
		FOR m_nF = 1 TO ALEN(a_scri)
			IF a_scri(m.m_nF) <> 0
				m.m_nCheck = m.m_nCheck + a_scri(m.m_nF) + a_scril(m.m_nF) + m.m_nF + IIF(INT(a_scri(m.m_nF) / 2) = a_scri(m.m_nF) / 2, 2, 1)
			ENDIF
		NEXT

		*&&CM - 19.11.2014
		IF TYPE("m_nPosNumTec") = "N" AND m.m_nPosNumTec > 0 AND TYPE("a_tmpbinumtec(m.m_nPosNumTec)") = "C"
			*&&CM - 24.11.2014m.m_nCheck = m.m_nCheck * 3 + 10698 + INT(VAL(a_tmpbinumtec(m.m_nPosNumTec)) * 10 /2 /10)
			m.m_nCheck = m.m_nCheck * 3 + 10698 + VAL(a_tmpbinumtec(m.m_nPosNumTec)) &&CM - 24.11.2014
		ELSE 	
		*&&CM - 19.11.2014

			IF USED("tmpBop") AND TYPE("tmpBop.snno") = "N"
				*&&CM - 24.11.2014m.m_nCheck = m.m_nCheck * 3 + 10698 + INT(tmpBop.snno * 10 /2 /10)
				m.m_nCheck = m.m_nCheck * 3 + 10698 + tmpBop.snno &&CM - 24.11.2014
			ENDIF 	
		ENDIF 

		*&&112158
		LOCAL m_cCypher
		m.m_cCypher = " /d"
		DO WHILE " " $ m.m_cCypher or "-" $ m.m_cCypher or "/" $ m.m_cCypher
			m.m_cCypher = cifravig(0, strzero(INT(m.m_nCheck / 1000) + 10000, 5, 0) + strzero(((m.m_nCheck / 1000) - INT(m.m_nCheck / 1000)) * 1000 + 10000, 5, 0), 0, 1)
		ENDDO 
		*&&112158

		*novoscanais
		IF TYPE("objAPI")<>"O"
			LOCAL phcService as String
			Public objAPI As Object
			m.phcService = "<<ALLTRIM(m.p_cMainDir)>>"+"phcservice.exe"
			TRY 
				SET CLASSLIB TO apidll IN &phcService. additive
				m.objAPI = CREATEOBJECT("apidll")
			CATCH TO oError
				MESSAGEBOX(oError.message)
			ENDTRY
		ENDIF
		*novoscanais

		*&&CM - 24.11.2014RETURN "{" + cifravig(0, strzero(m.m_nCheck, 9, 0), 0, 1) &&+ "}"
		*&&112158RETURN "{" + cifravig(0, strzero(INT(m.m_nCheck / 1000) + 10000, 5, 0) + strzero(((m.m_nCheck / 1000) - INT(m.m_nCheck / 1000)) * 1000 + 10000, 5, 0), 0, 1) &&+ "}" &&CM - 24.11.2014
		RETURN "{" + m.m_cCypher
    ENDTEXT
 ENDIF
 IF m.p_cfromfxgr="N"
    DELETE FILE m.p_cmaindir+"PHCCompl"+m.p_cpartnamedecrypt+".txt"
    STRTOFILE(m.p_cbuffer, m.p_cmaindir+"PHCCompl"+m.p_cpartnamedecrypt+".txt")
 ENDIF
 DELETE FILE (m.p_cmaindir+"GetFromPHC"+m.p_cpartnamedecrypt+".fxp")
 IF STRTOFILE(m.m_cgetfromphccompl, m.p_cmaindir+"GetFromPHC"+m.p_cpartnamedecrypt+".prg")=LEN(m.m_cgetfromphccompl)
    COMPILE (m.p_cmaindir+"GetFromPHC"+m.p_cpartnamedecrypt+".prg") ENCRYPT
    DELETE FILE (m.p_cmaindir+"GetFromPHC"+m.p_cpartnamedecrypt+".prg")
 ELSE
    MESSAGEBOX("N�o foi poss�vel avan�ar.")
 ENDIF
 ON SHUTDOWN
 CLEAR EVENTS
 QUIT
ENDPROC
