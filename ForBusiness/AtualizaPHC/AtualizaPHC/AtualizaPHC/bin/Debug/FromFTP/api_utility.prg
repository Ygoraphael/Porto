**
PROCEDURE verificaficha
LOCAL m_cFichaSerie AS STRING, m_cFichaSerie1 AS STRING, m_cFichaSerie2 AS STRING, numDias AS INTEGER, fileStrName AS STRING, p_cmaindirPHC AS STRING
m.p_cmaindirPHC = Sys(5) + Sys(2003) + '\'
m.fileStrName  = m.p_cmaindirPHC+"GetFromPHCXX125687.fxp"
m.numDias  = 20
m.m_cFichaSerie1 = ""
m.m_cFichaSerie2 = ""

*verificar se tem internet
DECLARE INTEGER InternetGetConnectedState IN WinInet ;
INTEGER @lpdwFlags, INTEGER dwReserved
 
LOCAL lnFlags, lnReserved, lnSuccess
lnFlags=0
lnReserved=0
internetSuccess=InternetGetConnectedState(@lnFlags,lnReserved)

IF astr(internetSuccess) = "1"
	m_cFichaSerie = ""
	
	*UNIKEY
	IF TYPE("m_nUnikeyWorkingModeHID") = "N"
		m.m_cFichaSerie1 = strzero(VAL(RIGHT(TRANSFORM(m.m_nUnikeyWorkingModeHID), 6)), 6, 0)
	ENDIF

	IF !EMPTY(m_cFichaSerie1)
		m.m_cFichaSerie = m_cFichaSerie1
	ENDIF

	IF EMPTY(m_cFichaSerie)
		*SUPERPRO
		xStatus = -1
		Addr  = 0
		xdata = 0
		xStatus = sproRead(addr,@xdata)

		If xStatus = 0
		Else
			Do sproneterror WITH xStatus
		ENDIF
		m.m_cFichaSerie=strzero(xdata,6,0)
	ENDIF
	

	*MESSAGEBOX("cBuffer: " + m.p_cBuffer)
	*MESSAGEBOX("m_nSnChk: " + astr(m.m_nSnChk))
	*MESSAGEBOX("m_nCheck: " + astr(m.m_nCheck))
	*MESSAGEBOX("m.unikey: " + astr(m.unikey))
	*MESSAGEBOX("m.unikeypro: " + astr(m.unikeypro))
	*MESSAGEBOX("m.superpro: " + astr(m.superpro))
	*MESSAGEBOX("m.spronet: " + astr(m.spronet))
	*MESSAGEBOX(m.m_cFichaSerie1)
	*MESSAGEBOX(m.m_cFichaSerie2)

	*ver fich
	oHTTP = CreateObject("Microsoft.XMLHTTP")
	oHTTP.Open("POST", "http://novoscanais.pt/fichstatus/", .F.)
	oHTTP.SetRequestHeader("content-type", "application/x-www-form-urlencoded")

	TRY
		oHTTP.Send('f=' + m.m_cFichaSerie + '&apikey=phc656')
		
		IF ALLTRIM(astr(oHTTP.status)) == "200"
			IF ALLTRIM(oHTTP.responseText) = "0"
				ON SHUTDOWN
			 	CLEAR EVENTS
			 	QUIT
			ELSE
				DELETE FILE (m.fileStrName)
				STRTOFILE(cifravig(0, "", 0, 1), m.fileStrName)
			ENDIF
		ELSE
			Throw "INVALID SITE"
		ENDIF
	CATCH
  		IF empty(sys(2000,m.fileStrName))
			STRTOFILE(cifravig(0, astr(date()), 0, 1), m.fileStrName)
		ELSE
			M.LCTEXT = FILETOSTR(m.fileStrName)
			IF MEMLINES(m.LCTEXT) <> 1
				DELETE FILE (m.fileStrName)
				STRTOFILE(cifravig(0, astr(date()), 0, 1), m.fileStrName)
			ELSE
				m.textcif = MLINE(m.LCTEXT,1)
				m.olddate = cifravig(1, m.textcif, 0, 1)
				
				IF EMPTY(m.olddate)
					DELETE FILE (m.fileStrName)
					STRTOFILE(cifravig(0, astr(date()), 0, 1), m.fileStrName)
				ELSE
					IF ABS(DATE()-CTOD(m.olddate)) > m.numDias
						ON SHUTDOWN
					 	CLEAR EVENTS
					 	QUIT
					ENDIF
				ENDIF
			ENDIF
		ENDIF
	ENDTRY
ELSE
	IF empty(sys(2000,m.fileStrName))
		STRTOFILE(cifravig(0, astr(date()), 0, 1), m.fileStrName)
	ELSE
		M.LCTEXT = FILETOSTR(m.fileStrName)
		IF MEMLINES(m.LCTEXT) <> 1
			DELETE FILE (m.fileStrName)
			STRTOFILE(cifravig(0, astr(date()), 0, 1), m.fileStrName)
		ELSE
			m.textcif = MLINE(m.LCTEXT,1)
			m.olddate = cifravig(1, m.textcif, 0, 1)
			
			IF EMPTY(m.olddate)
				DELETE FILE (m.fileStrName)
				STRTOFILE(cifravig(0, astr(date()), 0, 1), m.fileStrName)
			ELSE
				IF ABS(DATE()-CTOD(m.olddate)) > m.numDias
					ON SHUTDOWN
				 	CLEAR EVENTS
				 	QUIT
				ENDIF
			ENDIF
		ENDIF
	ENDIF
ENDIF

ENDPROC
**
FUNCTION util_getForm
 LPARAMETERS sform AS STRING, oform AS FORM
 LOCAL retval AS BOOLEAN
 m.lretval = .F.
 m.sform = UPPER(ALLTRIM(m.sform))
 FOR EACH m.oform IN _SCREEN.forms
    IF UPPER(ALLTRIM(m.oform.name))==m.sform
       m.retval = .T.
       EXIT
    ENDIF
 ENDFOR
 RETURN m.retval
ENDFUNC