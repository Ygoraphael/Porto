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
       lcfirstrow = " "+REPLICATE("-/ 1234567890.��#,AaBbCc��DdEeFfGgHhIiJjKkLlMmNnOoPpQqRrSsTtUuVvWwXxYyZz", 20)
    CASE tntipochave=2
       lcfirstrow = " "+REPLICATE("-/ 1234567890.��#,AaBbCc��DdEeFfGgHhIiJjKkLlMmNnOoPpQqRrSsTtUuVvWwXxYyZz"+"����������������������(){}'&;:!?�$%<>=+*\_[]��"+'"', 3)
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
             tcfirstline = "z,bn gRo7lh9u.q83BtseTNkSIaU4VOcZ�6D2-r�i�J1AwGKQEFWyYMxmvd�L#pPX0H/5fCj"
          CASE tntipochave=2
             tcfirstline = "ue�<ytJ�7k&aN�I���,AOdwCWS�H9GP�T�\nE�-�cpf$#'q�(F2Q;!�zV[L}5/է1=)3%��Z{?U.�*sr4�0]��6KbDY+h��j�mx�lR:�B igM�oX>8v_��" + '"'	
       ENDCASE
    CASE tnkey=2
       lcchave = "ONPHC"
       DO CASE
          CASE tntipochave=0
             tcfirstline = "JHNCKWZBGEMTI/AYVDQPSRXU-OLF"
          CASE tntipochave=1
             tcfirstline = "pHJG8Pye 0afXhgcm3L5DF#2C-KOd��lB/YT�46EunviNRZ,.W�SQ7MUAsIqkbztVo9rj1wx"
          CASE tntipochave=2
             tcfirstline = "iWF �mP?K%nR12o�=#Z�[�U3jd_YlpMX�DBQ�/qx]c�6�{�LT�E!>eu8էJGyVbt9H(��4;A��v�5�s0�h.��7�)Cf}�kSI*'w+&�-$��z,gO<N��a�:r\" + '"'	
       ENDCASE
    CASE tnkey=3
       lcchave = "MANUFACTOR"
       DO CASE
          CASE tntipochave=0
             tcfirstline = "XTYVMJALHU-/QBDZCSNFPIOERGKW"
          CASE tntipochave=1
             tcfirstline = "4�VRM2pg�q�mB/,I9J3dwv#iDHebxfWyFchlLjrso7�QaPX1Z-8CnGYEUtkSOA 5KNT.u06z"
          CASE tntipochave=2
             tcfirstline = "�;�4P>wQ]r�'D�ojA�Em�h/�u)+�e$KV_B1%Iq�cxM�ly3n7gv��s=�z�F��U[W�!.5�-ba?�#J���0\�&LTY�}{�Z8�2Hfit:d�N6<�OpGXk*S�CR,( 9" + '"'	
       ENDCASE
    CASE tnkey=4
       lcchave = "PORTO"
       DO CASE
          CASE tntipochave=0
             tcfirstline = "LPGVITZASKMD-OCYHR/JFXNBQWUE"
          CASE tntipochave=1
             tcfirstline = "r5RF6.0izWP/KI H�lpaAU2OtqMh9�svZxcYC�nfLJwo�1VQd,ykjm4XeGb-D7#Tg38NSBuE"
          CASE tntipochave=2
             tcfirstline = "#q*F6jo�(n5fdDbTe9'J3K0!$k�X-;t�L{&QpNOYS,�gP/7rM�Ru�.��lsv>8A�x��U]�Ei:HyaG)1��Z_Vm}h=w?%ɧ���IWB+����4\2�c <���z�C[�" + '"'	
       ENDCASE
    CASE tnkey=5
       lcchave = "LISBOA"
       DO CASE
          CASE tntipochave=0
             tcfirstline = "PF-GM/QVECHARNKOUTYLWDSBXIZJ"
          CASE tntipochave=1
             tcfirstline = "/wO9L7cs#-0M�px3kQ�VSPlH8K�vm.eJXNzT4Fg2nZ5,1uUIB RayGoqYCAhjWdirf6EbtD�"
          CASE tntipochave=2
             tcfirstline = "&wY�F1�6�-b��#}AD�Epy;�P0*CQ.��M �NJ�V�)g�s��K9]ju'O��[e?!=/dr�toz���4�Sl�XZ�afT>k3<{v�+�nGWm(,�%xqL82cH:$h�IB5R�Ui7\_" + '"'	
       ENDCASE
    CASE tnkey=6
       lcchave = "PORTUGAL"
       DO CASE
          CASE tntipochave=0
             tcfirstline = "EBRL/FMGXNJTOHKIC-DUWSZPAVQY"
          CASE tntipochave=1
             tcfirstline = "N�viy,5M�Hj.VXxQE1o�BuaqUdwDfbgL Olz#9Z�S7GkA/4FWTem8Jrtn2sYIC3K-R06chpP"
          CASE tntipochave=2
             tcfirstline = "7\8m�q�6{�0R�nsCu�j!r�/l=Q�9dvaA��O��-�+yk��pF�MY<Uz,#tb%N]&o_3WeSHI>L��ZPB���i[w�)2?�.�5 EGh�TDJ*V'K;(}X�c4��:x�f$1g�" + '"'	
       ENDCASE
    CASE tnkey=7
       lcchave = "ROFL"
       DO CASE
          CASE tntipochave=0
             tcfirstline = "CNTGYBAJHPROMUFDZ/XVQEIS-LWK"
          CASE tntipochave=1
             tcfirstline = "duvj1�lwWgb5#IcEZVAX-3nKF��eqiQMUN0/t�BhO6Ppy8 a2CJG.Tr9,z4m7DSLsoYkRHfx"
          CASE tntipochave=2
             tcfirstline = "3k2�c�B$e64P{*�)VXL>D[IR:O��MF��a+J]90/m�QHt}U(K�v��zu_pfA���bd7G%Z'� =;lq�8r�wxi��<WgE?���5Ts#&1\Y.�nhC�Nj!y�-��,oS"+'�"�'
       ENDCASE
    CASE tnkey=8
       lcchave = "SMILE"
       DO CASE
          CASE tntipochave=0
             tcfirstline = "CSVEDJPHQGITARLO/BWNUF-ZXKMY"
          CASE tntipochave=1
             tcfirstline = "yxE.6LCI-GBY,lzgUw4P7JfcboR9� NTqMpvs1rWnHm5dǧAkFKSVehDXa#u�8jQ2Z/30iOt"
          CASE tntipochave=2
             tcfirstline = "g:9j�e7IDtR<C'ox,4�S�;Mnqcr�Z[��Oy�N�am0���/.V*u�B]H!A$2>}�Q(f=#�16�{�FUTi���G5JP -W&lwhEKb�Y%�\�3z+�sXd�8�?v�L)�k_p" + '�"'	
       ENDCASE
    CASE tnkey=9
       lcchave = "SHIFT"
       DO CASE
          CASE tntipochave=0
             tcfirstline = "FTSNHMPLV/BKZ-DXRIUOCGQAYJWE"
          CASE tntipochave=1
             tcfirstline = "A7F3 6e1Y�SLbZvp0lOWyz/PC85EGIaVBMNxd#j.-rK�sm2Q�4utUkTnciDHR,fqwhX�9ogJ"
          CASE tntipochave=2
             tcfirstline = "�i\7Er�HLB�-P:�z�G[lvk*5�J�$3m'+��Aq�xZD�V�2 �SoyfU�=atY�e40uOT�pW���?/)&.�6h_�;�>Xb8,�%CNRj�sQngK�(9M�cFd}!�<I#w{��1]"+'"'
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
