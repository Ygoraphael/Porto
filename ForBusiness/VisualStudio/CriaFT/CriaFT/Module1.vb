Module Module1

    Sub Main()
        '<header><intid>666</intid><nome>Tiago Loureiro</nome><morada>Rua de Vilar, 235 6o D</morada><codpost>4050-626</codpost><local>PORTO</local><ncont>123456789</ncont></header><items><item><ref>A001</ref><design>Adufe</design><cor></cor><tam></tam><qtt>10.00</qtt><epv>100.00</epv><desconto>0.00</desconto><ivaincl>0</ivaincl><iva>2</iva></item><item><ref>A002</ref><design>Assobios de caça</design><cor></cor><tam></tam><qtt>2.00</qtt><epv>20.00</epv><desconto>0.00</desconto><ivaincl>0</ivaincl><iva>2</iva></item></items>

        mstamp = "<root>" & mstamp & "</root>"
        Dim output As String = ""
        Try
            ' Tranformação da string recebida pelo webservice em xml
            Dim stream As New System.IO.MemoryStream(Encoding.UTF8.GetBytes(mstamp))
            Dim reader As System.Xml.XmlReader = New System.Xml.XmlTextReader(stream)

            'variaveis fixas
            Dim CreateDocWs As bizlib.ftclass.CreateFTDoc
            Dim column As String = ""
            Dim value As String = ""
            Dim h_docType As Integer = 1
            Dim h_no As Integer = 1
            Dim i_armazem As Integer = 2

            Dim h_acceptable_vars = New String() {"intid", "nome", "morada", "codpost", "local", "ncont"}
            Dim i_acceptable_vars = New String() {"ref", "design", "cor", "tam", "qtt", "epv", "desconto", "iva", "ivaincl"}

            Dim Items As New List(Of Dictionary(Of String, String))
            Dim Item As Dictionary(Of String, String)
            Dim Header As New Dictionary(Of String, String)
            Header.Add("intid", "")
            Header.Add("nome", "")
            Header.Add("morada", "")
            Header.Add("codpost", "")
            Header.Add("local", "")
            Header.Add("ncont", "")

            Dim firstItem As Integer = 0
            Dim curTag As String = ""
            Dim tmpDbl As Double
            Dim tmpInt As Integer

            Do While (reader.Read())
                Select Case reader.NodeType
                    Case System.Xml.XmlNodeType.Element 'Inicio do elemento.
                        column = reader.Name.ToLower

                        If column = "header" Or column = "items" Then
                            curTag = column
                        End If

                        If column = "item" Then
                            If firstItem = 0 Then
                                firstItem = 1
                            Else
                                Items.Add(Item)
                            End If

                            Item = New Dictionary(Of String, String)
                            Item.Add("ref", "")
                            Item.Add("design", "")
                            Item.Add("cor", "")
                            Item.Add("tam", "")
                            Item.Add("qtt", "")
                            Item.Add("epv", "")
                            Item.Add("desconto", "")
                            Item.Add("iva", "")
                            Item.Add("ivaincl", "")
                        End If
                    Case System.Xml.XmlNodeType.Text 'texto/valor em cada elemento.
                        value = reader.Value

                        If curTag = "header" Then
                            If Array.IndexOf(h_acceptable_vars, column) >= 0 Then
                                Header(column) = value
                            End If
                        End If

                        If curTag = "items" Then
                            If Array.IndexOf(i_acceptable_vars, column) >= 0 Then
                                Item(column) = value
                            End If
                        End If
                End Select
            Loop

            If firstItem Then
                Items.Add(Item)
            End If

            If Header("nome").Trim().Length And Header("intid").Length Then
                'Cria o documento de faturação
                CreateDocWs = New bizlib.ftclass.CreateFTDoc(h_docType, h_no, 0)
                CreateDocWs.MainformDataset.Tables(0).Rows(0).Item("cdata") = Date.Now.Date
                CreateDocWs.MainformDataset.Tables(0).Rows(0).Item("chora") = DateTime.Now.ToString("HHmm")

                'cabecalho
                CreateDocWs.MainformDataset.Tables(0).Rows(0).Item("nome") = Header("nome").Trim()
                CreateDocWs.MainformDataset.Tables(0).Rows(0).Item("ncont") = Header("ncont").Trim()
                CreateDocWs.MainformDataset.Tables(0).Rows(0).Item("morada") = Header("morada").Trim()
                CreateDocWs.MainformDataset.Tables(0).Rows(0).Item("local") = Header("local").Trim()
                CreateDocWs.MainformDataset.Tables(0).Rows(0).Item("codpost") = Header("codpost").Trim()
                CreateDocWs.MainformDataset.Tables(0).Rows(0).Item("intid") = Header("intid").Trim()

                'linhas
                For Each row In Items
                    'Adicionar uma nova linha ao documento com a respetiva referência.
                    Dim NewRow As DataRow = CreateDocWs.Addnewline()

                    If row("ref").Trim().Length Then
                        NewRow.Item("ref") = row("ref").Trim()
                        ' Atualizar os dados da referência 
                        CreateDocWs.actLinha(NewRow)
                    End If

                    NewRow.Item("design") = row("design").Trim()
                    NewRow.Item("cor") = row("cor").Trim()
                    NewRow.Item("tam") = row("tam").Trim()

                    Double.TryParse(row("qtt"), tmpDbl)
                    NewRow.Item("qtt") = tmpDbl

                    Double.TryParse(row("epv"), tmpDbl)
                    NewRow.Item("epv") = tmpDbl

                    Double.TryParse(row("desconto"), tmpDbl)
                    NewRow.Item("desconto") = tmpDbl

                    Integer.TryParse(row("iva"), tmpInt)
                    NewRow.Item("iva") = tmpInt

                    Integer.TryParse(row("ivaincl"), tmpInt)
                    NewRow.Item("ivaincl") = tmpInt
                Next

                If CreateDocWs IsNot Nothing Then
                    Dim createSuccess = 0
                    'Gravação do documento
                    Try
                        CreateDocWs.Save()
                        createSuccess = 1
                    Catch ex As Exception
                        output = output + "ERRO: " + ex.Message.ToString() + "|"
                    End Try

                    If createSuccess = 1 Then
                        'saber qual o stamp da fatura
                        Dim MyDocData As DataTable = PhcCommandBuilder.CreateSelect("ftstamp").From("FT").Where("ndoc = @ndoc").And("intid = @intid").OrderBy("fno desc").AddSqlParameter("@ndoc", h_docType).AddSqlParameter("@intid", Header("intid").Trim()).GetDatatable()

                        If MyDocData.NoHaveRows Then
                            'Não existe documento
                            xcutil.formmensagem("Nao encontrei o documento")
                        Else
                            Dim ftstamp As String = ""
                            For Each row As DataRow In MyDocData.Rows
                                ftstamp = row.Item("ftstamp")
                            Next row
                            output = ftstamp
                        End If
                    End If
                    Return output
                Else
                    Return "Não consegui gravar o documento"
                End If
            End If
            Return output
        Catch ex As Exception
            output = output + "ERRO: " + ex.Message.ToString() + "|"
            Return output
        End Try
    End Sub

    Sub imprimeFT()
        '<ftstamp>03a-4877-8ca5-dbf40db3d6c</ftstamp>

        mstamp = "<root>" & mstamp & "</root>"
        Dim h_docType As Integer = 1
        Dim output As String = ""
        Try
            ' Tranformação da string recebida pelo webservice em xml
            Dim stream As New System.IO.MemoryStream(Encoding.UTF8.GetBytes(mstamp))
            Dim reader As System.Xml.XmlReader = New System.Xml.XmlTextReader(stream)

            'variaveis fixas
            Dim column As String = ""
            Dim value As String = ""
            Dim Ftstamp As String = ""

            Do While (reader.Read())
                Select Case reader.NodeType
                    Case System.Xml.XmlNodeType.Element 'Inicio do elemento.
                        column = reader.Name.ToLower
                    Case System.Xml.XmlNodeType.Text 'texto/valor em cada elemento.
                        value = reader.Value
                        If column = "ftstamp" Then
                            Ftstamp = value
                        End If
                End Select
            Loop

            If Ftstamp.Trim().Length Then
                'criar PDF
                Dim MyIduObj As iduclass.IduViewParas = New iduclass.IduViewParas
                MyIduObj.cTabCab = "FT"
                MyIduObj.cTabLin = "FI"
                MyIduObj.cCabCampos = "FTCAMPOS"
                MyIduObj.cLinCampos = "FICAMPOS"
                MyIduObj.cConnection = cconfig.ConnectionString

                MyIduObj.nTipoDocumento = h_docType
                MyIduObj.cStampToImp = Ftstamp
                MyIduObj.cTitulo = "Doc. Fat."

                MyIduObj.nTipoImp = iduclass.IduGeral.TipoImpressoes.Impressoes_Definidas
                MyIduObj.nTipoIdu = iduclass.IduGeral.TipoIdu.OneToMany

                Dim cIduCab As String = "FTIDUC"
                Dim cIduLin As String = "FTIDUL"
                xcsession.SetObject(iduclass.IduViewParas.cKeyCache, MyIduObj)

                'Na query que se segue, a IDU tem de ter ativo os campos Este idu está disponível no Web(digital=1) e Impressão por defeito(impdef=1):
                Dim MyDataTable As DataTable = PhcCommandBuilder.CreateSelect("idustamp,grupo,titulo,orientacao,impdef").From("FTIDUC").Where("(docmulti = 1 or ndos=@ndoc)").And("imptxt = 0 And digital = 1 and impdef = 1").OrderBy("titulo").AddSqlParameter("@ndoc", MyIduObj.nTipoDocumento).GetDatatable

                If MyDataTable.NoHaveRows Then
                    'Não existe IDU definida para este dossier para imprimir no PHC CS Web:
                    output = output + "Erro a tentar imprimir o IDU especificado. O IDU parece estar vazio."
                Else
                    ccache.SetDataTableToCache("IduVisualFox_" + MyIduObj.cTabCab + "_" + MyIduObj.nTipoDocumento.ToString + "_" + Microsoft.VisualBasic.Str(MyIduObj.nTipoImp), MyDataTable)

                    If MyIduObj Is Nothing Then
                        output = output + "A chamada da rotina de impressão é inválida."
                    End If

                    Dim FoxIdu As Object
                    Dim FoxParasIdu As Object

                    Try
                        FoxIdu = Microsoft.VisualBasic.Interaction.CreateObject("iduserver.idu")
                        FoxParasIdu = Microsoft.VisualBasic.Interaction.CreateObject("iduserver.iduparas")
                    Catch ex As System.Exception
                        output = output + "o ficheiro iduserver.dll não está registada no sistema."
                    End Try

                    If FoxIdu Is Nothing OrElse FoxParasIdu Is Nothing Then
                        output = output + "Não foi possível inicial a aplicação de impressão."
                    End If

                    'A ligação base de dados deve conter os dados do DSN do ficheiro appSettings:
                    FoxIdu.idu_connectionstring = "server=192.168.101.85\SQLEXPRESS2012;uid=sa;pwd=sa123;database=MaisProducao22CS;"

                    FoxParasIdu.IDU_BDADOS = cIduCab
                    FoxParasIdu.IDU_BLDADOS = cIduLin
                    FoxParasIdu.IDU_FDADOS = MyIduObj.cTabCab
                    FoxParasIdu.IDU_FLDADOS = MyIduObj.cTabLin
                    FoxParasIdu.IDU_CABCAMPOS = MyIduObj.cCabCampos
                    FoxParasIdu.IDU_LINCAMPOS = MyIduObj.cLinCampos
                    FoxParasIdu.IDU_TIPOIDU = MyIduObj.nTipoIdu.ToString.ToUpper
                    FoxParasIdu.IDU_TIPOIMPRESSAO = 6.0

                    'Colocar campos idustamp da tabela boiduc da tabela
                    FoxParasIdu.IDU_IDUSTAMP = MyDataTable.Rows(0).ItemToString("idustamp")
                    FoxParasIdu.IDU_STAMPTOIMP = MyIduObj.cStampToImp
                    FoxParasIdu.IDU_TIPODOCUMENTO = MyIduObj.nTipoDocumento
                    FoxParasIdu.IDU_ORIENTACAO = 1
                    FoxParasIdu.IDU_PDFTIPOPAPEL = 9
                    FoxParasIdu.IDU_PDFPASSWORD = ""

                    Dim cFileName As String = ""
                    Try
                        cFileName = CType(FoxIdu.imprimeidu(FoxParasIdu), String)
                    Catch ex As System.Exception
                        'Deu erro a imprimir é necessario verificar o ficheiro IduServer_Err.Txt que por defeito está na pasta C:\inetpub\wwwroot\iduserver:
                        output = output + "Não foi possivel imprimir:" + ex.Message.Trim + Microsoft.VisualBasic.Strings.Chr(13) + "Stack: " + ex.StackTrace

                    End Try
                    FoxIdu.desligaserver()

                    If cFileName.IsNullOrEmpty Then
                        'Mensagem de falta de IDU:
                        output = output + "Erro não encontrei o ficheiro de PDF."
                    Else
                        Dim fileBytes = My.Computer.FileSystem.ReadAllBytes(cFileName)
                        Return Convert.ToBase64String(System.IO.File.ReadAllBytes(cFileName))
                        cFileName = System.IO.Path.GetFileName(cFileName)
                        cFileName = Microsoft.VisualBasic.Strings.Replace(cFileName, "\", "/")


                    End If
                End If


            Else
                output = output + "ERRO: Não consegui encontrar o documento|"
            End If
            Return output
        Catch ex As Exception
            output = output + "ERRO: " + ex.Message.ToString() + "|"
            Return output
        End Try

    End Sub
End Module
