 PARAMETER tnopcao, tcfrase, tnkey, tntipochave
 IF TYPE("tnopcao")<>"N" .OR. TYPE("tcfrase")<>"C"
    RETURN ""
 ENDIF
 IF VARTYPE(tntipochave)="L"
    tntipochave = IIF(tntipochave, 1, 0)
 ENDIF
 RELEASE arraychaves
 LOCAL lcreturn, lcchave, lcfirstline, lcfirstrow
 DO CASE
    CASE VARTYPE(tntipochave)<>"N"
       RETURN ""
    CASE tntipochave=0
       lcfirstrow = " -/1234567890."
    CASE tntipochave=1
       lcfirstrow = " "+REPLICATE("-/ 1234567890.ß£#,AaBbCc«ÁDdEeFfGgHhIiJjKkLlMmNnOoPpQqRrSsTtUuVvWwXxYyZz", 20)
    CASE tntipochave=2
       lcfirstrow = " "+REPLICATE("-/ 1234567890.ß£#,AaBbCc«ÁDdEeFfGgHhIiJjKkLlMmNnOoPpQqRrSsTtUuVvWwXxYyZz"+"¿¡√¬‡·„‚… ÈÍÕÌ”’‘ÛıÙ⁄˙(){}'&;:!?Ä$%<>=+*\_[]™∫"+'"', 3)
 ENDCASE
 DIMENSION arraychaves(LEN(lcfirstrow))
 lcreturn = ""
 arraychaves = ""
 lcchave = setchave(tnopcao, @tcfrase, @tnkey, @lcfirstline, lcfirstrow, tntipochave)
 filltextocifrado(lcfirstline, lcfirstrow)
 DO CASE
    CASE tnopcao=0
       lcreturn = cifra_frase(tcfrase, lcchave)
       lcreturn = ALLTRIM(STR(tnkey))+lcreturn
       lcundo = cifravig(1, lcreturn, .F., tntipochave)
       IF lcundo<>tcfrase
          lcreturn = ""
       ENDIF
    CASE tnopcao=1
       lcreturn = decifra_frase(tcfrase, lcchave)
 ENDCASE
 RELEASE arraychaves
 RETURN lcreturn
ENDFUNC
**
PROCEDURE filltextocifrado
 PARAMETER lcfirstline, tcfirstrow
 LOCAL lncnt, lnlinha, lndeslocamento, lnchavelen
 lndeslocamento = 0
 lnchavelen = LEN(lcfirstline)
 FOR lnlinha = 1 TO ALEN(arraychaves)
    lcstring = ""
    FOR lncnt = 1 TO lnchavelen
       lnpos = lncnt+lndeslocamento
       IF lnpos>lnchavelen
          lnpos = lnpos-lnchavelen
       ENDIF
       lcdummy = SUBSTR(lcfirstline, lnpos, 1)
       lcstring = lcstring+lcdummy
    ENDFOR
    arraychaves(lnlinha) = SUBSTR(tcfirstrow, lnlinha, 1)+lcstring
    lndeslocamento = IIF(lndeslocamento>lnchavelen, 0, lndeslocamento+1)
 ENDFOR
ENDPROC
**
FUNCTION setchave
 LPARAMETERS tnopcao, tcfrase, tnkey, tcfirstline, tcfirstrow, tntipochave
 LOCAL lcchave, tnkey
 DO CASE
    CASE tnopcao=0 .AND. EMPTY(tnkey)
       tnkey = 0
       DO WHILE EMPTY(tnkey)
          tnkey = INT(RAND()*10)
          IF tnkey>9
             lnoverflow = INT(tnkey/10)
             tnkey = tnkey-(10*lnoverflow)
          ENDIF
          IF tnkey>9
             tnkey = 0
          ENDIF
       ENDDO
    CASE tnopcao=1
       tnkey = VAL(SUBSTR(tcfrase, 1, 1))
       tcfrase = STUFF(tcfrase, 1, 1, "")
 ENDCASE
 tcfirstline = ""
 lcchave = ""
 DO CASE
    CASE tnkey=0
       RETURN ""
    CASE tnkey=1
       lcchave = "GUARD"
       DO CASE
          CASE tntipochave=0
             tcfirstline = "FMTLIYRHJZQ/GNDA-EBUXCWKPOSV"
          CASE tntipochave=1
             tcfirstline = "z,bn gRo7lh9u.q83BtseTNkSIaU4VOcZß6D2-r«i£J1AwGKQEFWyYMxmvdÁL#pPX0H/5fCj"
          CASE tntipochave=2
             tcfirstline = "ueÁ<ytJ¡7k&aN·IÌ”‘,AOdwCWSÛH9GPÍTÕ\nE£-«cpf$#'q (F2Q;!√zV[L}5/’ß1=)3%‚‡Z{?U.¿*sr4Ä0]ÙÈ6KbDY+h⁄ıj¬mx…lR:˙B igM„oX>8v_™∫" + '"'	
       ENDCASE
    CASE tnkey=2
       lcchave = "ONPHC"
       DO CASE
          CASE tntipochave=0
             tcfirstline = "JHNCKWZBGEMTI/AYVDQPSRXU-OLF"
          CASE tntipochave=1
             tcfirstline = "pHJG8Pye 0afXhgcm3L5DF#2C-KOd£ßlB/YT«46EunviNRZ,.WÁSQ7MUAsIqkbztVo9rj1wx"
          CASE tntipochave=2
             tcfirstline = "iWF √mP?K%nR12oÈ=#ZÁ[ÌU3jd_YlpMX DBQÍ/qx]c„6Ä{£LT…E!>eu8’ßJGyVbt9H(‚Ù4;A‡¡v‘5ıs0«h.⁄¿7Õ)Cf}ÛkSI*'w+&˙-$·¬z,gO<N∫”a™:r\" + '"'	
       ENDCASE
    CASE tnkey=3
       lcchave = "MANUFACTOR"
       DO CASE
          CASE tntipochave=0
             tcfirstline = "XTYVMJALHU-/QBDZCSNFPIOERGKW"
          CASE tntipochave=1
             tcfirstline = "4ÁVRM2pg«qßmB/,I9J3dwv#iDHebxfWyFchlLjrso7£QaPX1Z-8CnGYEUtkSOA 5KNT.u06z"
          CASE tntipochave=2
             tcfirstline = "ß;˙4P>wQ]rÁ'DÄojA·Em¬h/”u)+Èe$KV_B1%Iq‘cxM‚ly3n7gv£’s= zıF√ÌU[W¿!.5Õ-ba?⁄#JÛ‡Í0\™&LTY∫}{…Z8¡2Hfit:d«N6<„OpGXk*SÙCR,( 9" + '"'	
       ENDCASE
    CASE tnkey=4
       lcchave = "PORTO"
       DO CASE
          CASE tntipochave=0
             tcfirstline = "LPGVITZASKMD-OCYHR/JFXNBQWUE"
          CASE tntipochave=1
             tcfirstline = "r5RF6.0izWP/KI HßlpaAU2OtqMh9«svZxcYC£nfLJwoÁ1VQd,ykjm4XeGb-D7#Tg38NSBuE"
          CASE tntipochave=2
             tcfirstline = "#q*F6jo”(n5fdDbTe9'J3K0!$k„X-;t¬L{&QpNOYS,˙gP/7rMÄRu£.‚Ùlsv>8A√x’ÌU]⁄Ei:HyaG)1∫ÁZ_Vm}h=w?%…ß«‘·IWB+ÛÕ‡È4\2Íc <ı ¿z¡C[™" + '"'	
       ENDCASE
    CASE tnkey=5
       lcchave = "LISBOA"
       DO CASE
          CASE tntipochave=0
             tcfirstline = "PF-GM/QVECHARNKOUTYLWDSBXIZJ"
          CASE tntipochave=1
             tcfirstline = "/wO9L7cs#-0M£px3kQ«VSPlH8KÁvm.eJXNzT4Fg2nZ5,1uUIB RayGoqYCAhjWdirf6EbtDß"
          CASE tntipochave=2
             tcfirstline = "&wY”F1È6™-b«Ù#}AD⁄Epy;·P0*CQ.ÄÌM ¡NJ∫V’)g‘s˙ÕK9]ju'O…‚[e?!=/drıtoz£‡√4ÍSlÛXZßafT>k3<{v¬+„nGWm(,Á%xqL82cH:$h IB5R¿Ui7\_" + '"'	
       ENDCASE
    CASE tnkey=6
       lcchave = "PORTUGAL"
       DO CASE
          CASE tntipochave=0
             tcfirstline = "EBRL/FMGXNJTOHKIC-DUWSZPAVQY"
          CASE tntipochave=1
             tcfirstline = "N£viy,5M«Hj.VXxQE1oßBuaqUdwDfbgL Olz#9ZÁS7GkA/4FWTem8Jrtn2sYIC3K-R06chpP"
          CASE tntipochave=2
             tcfirstline = "7\8m˙qß6{Ù0RınsCu«j!r‡/l=Q¡9dvaA„¿OÈ⁄- +ykÕÍpF¬MY<Uz,#tb%N]&o_3WeSHI>L™’ZPBÁ‘·i[w‚)2?Û.”5 EGh√TDJ*V'K;(}X…c4Ä£:xÌf$1g∫" + '"'	
       ENDCASE
    CASE tnkey=7
       lcchave = "ROFL"
       DO CASE
          CASE tntipochave=0
             tcfirstline = "CNTGYBAJHPROMUFDZ/XVQEIS-LWK"
          CASE tntipochave=1
             tcfirstline = "duvj1ÁlwWgb5#IcEZVAX-3nKFß«eqiQMUN0/t£BhO6Ppy8 a2CJG.Tr9,z4m7DSLsoYkRHfx"
          CASE tntipochave=2
             tcfirstline = "3k2£c¡B$e64P{*…)VXL>D[IR:O˙ßMF«‡a+J]90/m„QHt}U(K‚v√Ùzu_pfAÁÌ”bd7G%Z'¿ =;lqÈ8r’wxiÍ‘<WgE?Ä¬ 5Ts#&1\Y.ınhCÕNj!y⁄-Û·,oS"+'™"∫'
       ENDCASE
    CASE tnkey=8
       lcchave = "SMILE"
       DO CASE
          CASE tntipochave=0
             tcfirstline = "CSVEDJPHQGITARLO/BWNUF-ZXKMY"
          CASE tntipochave=1
             tcfirstline = "yxE.6LCI-GBY,lzgUw4P7JfcboR9£ NTqMpvs1rWnHm5d«ßAkFKSVehDXa#uÁ8jQ2Z/30iOt"
          CASE tntipochave=2
             tcfirstline = "g:9j˙e7IDtR<C'ox,4…S’;MnqcrÌZ[¡ÕOyıNÁam0 ¿⁄/.V*u«B]H!A$2>}ÈQ(f=#£16Ù{”FUTiÛ‡√G5JP -W&lwhEKb·Y%‚\„3z+‘sXdÍÄ8¬?vßL)™k_p" + '∫"'	
       ENDCASE
    CASE tnkey=9
       lcchave = "SHIFT"
       DO CASE
          CASE tntipochave=0
             tcfirstline = "FTSNHMPLV/BKZ-DXRIUOCGQAYJWE"
          CASE tntipochave=1
             tcfirstline = "A7F3 6e1YÁSLbZvp0lOWyz/PC85EGIaVBMNxd#j.-rK«sm2Qß4utUkTnciDHR,fqwhX£9ogJ"
          CASE tntipochave=2
             tcfirstline = "™i\7ErßHLB∫-P:Áz‡G[lvk*5£J $3m'+√’Aq¬xZDÄV‘2 ”SoyfU⁄=atY·e40uOT«pWıÙÌ?/)&.…6h_Í;Û>Xb8,‚%CNRj¡sQngK„(9M˙cFd}!È<I#w{¿Õ1]"+'"'
       ENDCASE
 ENDCASE
 lnrepete = 5
 IF tntipochave<>0
    lnrepete = INT(3000/LEN(lcchave))
 ENDIF
 lcchave = SUBSTR(REPLICATE(lcchave, lnrepete), 1, LEN(tcfirstrow))
 RETURN lcchave
ENDFUNC
**
FUNCTION cifra_frase
 PARAMETER tcfrase, tcchave
 LOCAL lcreturn, lnoverflow, lnval, lnpos, lcchar
 lcreturn = ""
 FOR lnpos = 1 TO LEN(tcfrase)
    lcchar = SUBSTR(tcfrase, lnpos, 1)
    lnlinha = 0
    FOR lncnt = 2 TO ALEN(arraychaves)
       IF SUBSTR(arraychaves(lncnt), 1, 1)=SUBSTR(tcfrase, lnpos, 1)
          lnlinha = lncnt
          EXIT
       ENDIF
    ENDFOR
    lcchar = SUBSTR(tcchave, lnpos, 1)
    lnat = AT(lcchar, arraychaves(1))
    lcnew = SUBSTR(arraychaves(lnlinha), lnat, 1)
    lcreturn = lcreturn+lcnew
 ENDFOR
 RETURN lcreturn
ENDFUNC
**
FUNCTION decifra_frase
 PARAMETER tcfrase, tcchave
 LOCAL lcreturn, lnpos, lclinha
 lcreturn = ""
 FOR lnpos = 1 TO LEN(tcfrase)
    lcnew = ""
    lcheader = SUBSTR(tcchave, lnpos, 1)
    lncoluna = AT(lcheader, arraychaves(1))
    lclook = SUBSTR(tcfrase, lnpos, 1)
    FOR lnlinha = 2 TO ALEN(arraychaves)
       lcstring = " "+SUBSTR(arraychaves(lnlinha), 2)
       IF SUBSTR(lcstring, lncoluna, 1)=lclook
          lcnew = SUBSTR(arraychaves(lnlinha), 1, 1)
          EXIT
       ENDIF
    ENDFOR
    lcreturn = lcreturn+lcnew
 ENDFOR
 RETURN lcreturn
ENDFUNC
**
FUNCTION cria_stringbaralhada
 LOCAL lclinha, lcretval, lncnt, lcchar1, lcchar2, lntam
 lclinha = ""
 IF EMPTY(lclinha)
    RETURN ""
 ENDIF
 lcretval = lclinha
 lntam = LEN(lcretval)
 FOR lncnt = 1 TO lntam
    lnpos = INT(VAL(SUBSTR(STR(RAND(), 6, 6), 2)))
    DO WHILE lnpos>LEN(lcretval)
       lnpos = lnpos-LEN(lcretval)
    ENDDO
    lcchar1 = SUBSTR(lcretval, lncnt, 1)
    lcchar2 = SUBSTR(lcretval, lnpos, 1)
    lcretval = SUBSTR(lcretval, 1, lncnt-1)+lcchar2+SUBSTR(lcretval, lncnt+1)
    lcretval = SUBSTR(lcretval, 1, lnpos-1)+lcchar1+SUBSTR(lcretval, lnpos+1)
 ENDFOR
 FOR lncnt = 1 TO lntam
    lchar1 = SUBSTR(lclinha, lncnt, 1)
    IF AT(lchar1, lcretval)=0
       RETURN
    ENDIF
 ENDFOR
 RETURN lcretval
ENDFUNC
**
