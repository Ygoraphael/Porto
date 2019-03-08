Imports System.IO
Imports System.Data.SqlClient

Public Class Form1

    Dim ExisteCartao As Boolean
    Dim NumeroCliente As Integer
    Dim NomeCartao As String
    Dim TipoCartao As String
    Dim CaminhoIMG As String
    Dim IsFunc As String
    Dim DataConf As Date
    Dim Modalidades As String
    Dim Deve As String
    Public Posicao As String
    Dim ID
    Dim st As String
    Dim iMachineNumber As Integer
    Dim AppPath As String = New System.IO.FileInfo(Application.ExecutablePath).DirectoryName
    Public axCZKEM1 As New zkemkeeper.CZKEM
    Dim bIsConnected As Boolean
    Dim idwErrorCode As Integer
    Dim pica01_ip As String
    Dim pica01_porta As Integer
    Public xNDOS As Integer
    Public tempo_intervalo As Integer
    Public xNMDOS As String
    Public xIMGBAR As Boolean
    Public connectionString As String
    Public Posto As String
    Public cnn As SqlConnection
    Public command As SqlCommand
    Dim ncx As String
    Dim t As Timer

    Private Sub AbrirBaseDados()
        Dim file_name As String = AppPath & "\Ligação.cfg"
        Dim TextLine As String = ""

        Dim LinhasLigacao As New ArrayList

        If System.IO.File.Exists(file_name) = True Then
            Dim objReader As New System.IO.StreamReader(file_name)
            Do While objReader.Peek() <> -1
                LinhasLigacao.Add(objReader.ReadLine())
            Loop
        Else
            MsgBox("Ligação.cfg não existe.")
            Application.Exit()
        End If

        If LinhasLigacao.Count = 4 Then
            connectionString = LinhasLigacao(0)
            pica01_ip = LinhasLigacao(1)
            pica01_porta = LinhasLigacao(2)
            tempo_intervalo = LinhasLigacao(3)
        Else
            MsgBox("Ligação.cfg não está bem preenchido.")
            Application.Exit()
        End If

        file_name = AppPath & "\Posto.cfg"
        TextLine = ""
        If System.IO.File.Exists(file_name) = True Then
            Dim objReader As New System.IO.StreamReader(file_name)
            Do While objReader.Peek() <> -1
                TextLine = TextLine & objReader.ReadLine() & vbNewLine
            Loop
        Else
            MsgBox("Posto.cfg não existe.")
            Application.Exit()
        End If
        Posto = TextLine

        Me.Text = Posto

        If UCase(Posto) = "BAR" Then
            xNDOS = 101
            xNMDOS = "Reg. Entradas B"
            xIMGBAR = True
        Else
            xNDOS = 100
            xNMDOS = "Reg. Entradas"
            xIMGBAR = False
        End If

        cnn = New SqlConnection(connectionString)
        Try
            cnn.Open()
            Console.WriteLine("Ligação a base dados efetuada com sucesso")
            cnn.Close()
        Catch ex As Exception
            Console.WriteLine(ex)
        End Try
    End Sub

    Private Sub RegistoManualToolStripMenuItem_Click(sender As System.Object, e As System.EventArgs) Handles RegistoManualToolStripMenuItem.Click
        Dim ncx As String = ""
        ncx = InputBox("Indique o número de cliente PHC", "Registo de Entrada Manual")
        If ncx <> "" Then
            RegistarPHC(ncx, 2)
        End If
        ncx = ""
    End Sub

    Private Sub VerSeExisteCliente(NCartao As String)
        ExisteCartao = False
        NomeCartao = ""
        CaminhoIMG = ""
        DataConf = "01-01-1900"
        NumeroCliente = 0
        Modalidades = ""
        Posicao = ""
        TipoCartao = ""
        Deve = False

        Try
            cnn.Open()
            command = New SqlCommand("Select no, nome, imagem, u_isfunc from CL (nolock) where u_CodVal='" & NCartao & "'", cnn)
            Dim sqlReader As SqlDataReader = command.ExecuteReader()
            If sqlReader.HasRows Then
                sqlReader.Read()

                ExisteCartao = True
                NumeroCliente = sqlReader.Item(0)
                NomeCartao = sqlReader.Item(1)
                CaminhoIMG = sqlReader.Item(2)
                IsFunc = sqlReader.Item(3)

                sqlReader.Close()
                command.Dispose()
                cnn.Close()
                cnn.Open()
                command = New SqlCommand("select dataopen, tabela1 From bo Where ndos = 1 And fechada = 0 And boano = Year(getdate()) And no=" & Val(NumeroCliente), cnn)
                sqlReader = command.ExecuteReader()
                If sqlReader.HasRows Then
                    sqlReader.Read()

                    DataConf = sqlReader.Item(0)
                    TipoCartao = sqlReader.Item(1)
                End If
            End If

            sqlReader.Close()
            command.Dispose()
            cnn.Close()
        Catch ex As Exception
            Console.WriteLine(ex)
        End Try
    End Sub

    Private Sub VerSeExisteClienteNumero(NCartao As String)
        ExisteCartao = False
        NomeCartao = ""
        CaminhoIMG = ""
        DataConf = "01-01-1900"
        NumeroCliente = 0
        Modalidades = ""
        Posicao = ""
        TipoCartao = ""
        Deve = False

        Try
            cnn.Open()
            command = New SqlCommand("Select no, nome, imagem, u_isfunc from CL (nolock) where no=" & Val(NCartao), cnn)
            Dim sqlReader As SqlDataReader = command.ExecuteReader()
            If sqlReader.HasRows Then
                sqlReader.Read()

                ExisteCartao = True
                NumeroCliente = sqlReader.Item(0)
                NomeCartao = sqlReader.Item(1)
                CaminhoIMG = sqlReader.Item(2)
                IsFunc = sqlReader.Item(3)

                sqlReader.Close()
                command.Dispose()
                cnn.Close()
                cnn.Open()
                command = New SqlCommand("select dataopen, tabela1 From bo Where ndos = 1 And fechada = 0 And boano = Year(getdate()) And no=" & Val(NCartao), cnn)
                sqlReader = command.ExecuteReader()
                If sqlReader.HasRows Then
                    sqlReader.Read()

                    DataConf = sqlReader.Item(0)
                    TipoCartao = sqlReader.Item(1)
                End If
            End If

            sqlReader.Close()
            command.Dispose()
            cnn.Close()
        Catch ex As Exception
            Console.WriteLine(ex)
        End Try
    End Sub

    Private Sub RegistarPHC(myID As String, mTipo As Integer)
        If mTipo = 1 Then
            VerSeExisteCliente(myID)
        Else
            VerSeExisteClienteNumero(myID)
        End If

        If ExisteCartao = True Then
            Dim myFrm As New myFrm
            myFrm.MdiParent = Me
            myFrm.Dock = DockStyle.Fill

            myFrm.intervalo_timer = tempo_intervalo
            myFrm.Text = NomeCartao
            myFrm.lblNO.Text = NumeroCliente
            myFrm.lblNome.Text = NomeCartao
            myFrm.lblData.Text = DateTime.Now.ToString("yyyy/MM/dd")
            myFrm.lblHora.Text = DateTime.Now.ToString("HH:mm:ss")
            myFrm.lblRazao.Text = ""

            If File.Exists(CaminhoIMG) Then
                myFrm.foto.BackgroundImage = Image.FromFile(CaminhoIMG)
                myFrm.foto.BackgroundImageLayout = ImageLayout.Stretch
            Else
                myFrm.foto.BackgroundImage = Image.FromFile(AppPath & "\Imagens\f01.jpg")
                myFrm.foto.BackgroundImageLayout = ImageLayout.Stretch
            End If

            '''' Ver se está pago --------------------------------------
            Dim xData As Date
            xData = Date.Now()
            Dim deve_bloquear As Boolean
            deve_bloquear = False
            myFrm.imgEstado.BackgroundImage = Image.FromFile(AppPath & "\Imagens\01g.gif")
            myFrm.imgEstado.BackgroundImageLayout = ImageLayout.Stretch
            If xData > DataConf Then
                Deve = True
                Posicao = "Sim"
                myFrm.imgEstado.BackgroundImage = Image.FromFile(AppPath & "\Imagens\02g.gif")
                myFrm.imgEstado.BackgroundImageLayout = ImageLayout.Stretch
                myFrm.lblRazao.Text = "Pagamento em Falta desde " & DataConf
                deve_bloquear = True
            Else
                'duas vezes por dia
                If TipoCartao = "Prateado" Then
                    Try
                        cnn.Open()
                        command = New SqlCommand("select count(rdata) num_entradas_dia From bi Where ndos = 100 And rdata = SUBSTRING(CONVERT(VARCHAR(20), getdate(), 20), 0, 11) + ' 00:00:00.000' AND no = " & NumeroCliente, cnn)
                        Dim sqlReader As SqlDataReader = command.ExecuteReader()
                        If sqlReader.HasRows Then
                            sqlReader.Read()

                            If Val(sqlReader.Item(0)) >= 2 Then
                                Deve = True
                                Posicao = "Sim"
                                myFrm.imgEstado.BackgroundImage = Image.FromFile(AppPath & "\Imagens\02g.gif")
                                myFrm.imgEstado.BackgroundImageLayout = ImageLayout.Stretch
                                myFrm.lblRazao.Text = "Nº Máximo de Entradas Diário Excedido"
                            Else
                                Deve = False
                                Posicao = ""
                                myFrm.imgEstado.BackgroundImage = Image.FromFile(AppPath & "\Imagens\01g.gif")
                                myFrm.imgEstado.BackgroundImageLayout = ImageLayout.Stretch
                            End If

                            If Val(sqlReader.Item(0)) >= 1 Then
                                deve_bloquear = True
                            End If
                        End If

                        sqlReader.Close()
                        command.Dispose()
                        cnn.Close()
                    Catch ex As Exception
                        Console.WriteLine(ex)
                    End Try
                Else
                    'uma vez por dia
                    If TipoCartao = "Roxo" Then
                        Try
                            cnn.Open()
                            command = New SqlCommand("select count(rdata) num_entradas_dia From bi Where ndos = 100 And rdata = SUBSTRING(CONVERT(VARCHAR(20), getdate(), 20), 0, 11) + ' 00:00:00.000' AND no = " & NumeroCliente, cnn)
                            Dim sqlReader As SqlDataReader = command.ExecuteReader()
                            If sqlReader.HasRows Then
                                sqlReader.Read()

                                If Val(sqlReader.Item(0)) >= 1 Then
                                    Deve = True
                                    Posicao = "Sim"
                                    myFrm.imgEstado.BackgroundImage = Image.FromFile(AppPath & "\Imagens\02g.gif")
                                    myFrm.imgEstado.BackgroundImageLayout = ImageLayout.Stretch
                                    myFrm.lblRazao.Text = "Nº Máximo de Entradas Diário Excedido"
                                Else
                                    Deve = False
                                    Posicao = ""
                                    myFrm.imgEstado.BackgroundImage = Image.FromFile(AppPath & "\Imagens\01g.gif")
                                    myFrm.imgEstado.BackgroundImageLayout = ImageLayout.Stretch
                                End If

                                If Val(sqlReader.Item(0)) >= 0 Then
                                    deve_bloquear = True
                                End If
                            End If

                            sqlReader.Close()
                            command.Dispose()
                            cnn.Close()
                        Catch ex As Exception
                            Console.WriteLine(ex)
                        End Try
                    End If
                End If
            End If

            myFrm.razao = myFrm.lblRazao.Text
            Console.WriteLine("Deve bloquear: " & deve_bloquear)

            '''' fim de ver se está pago -------------------------------
            If IsFunc = "False" Then
                myFrm.Show()
                myFrm.Registar(deve_bloquear, axCZKEM1, iMachineNumber, IsFunc)
            End If

            'If deve_bloquear = True Then
            't = New Timer()
            't.Interval = tempo_intervalo * 1000
            'AddHandler t.Tick, AddressOf HandleTimerTick
            't.Start()
            'End If
        End If

    End Sub

    'Private Sub HandleTimerTick(ByVal sender As System.Object, ByVal e As System.EventArgs)
    '    t.Stop()
    '    axCZKEM1.EnableDevice(iMachineNumber, False)
    '    axCZKEM1.EnableUser(iMachineNumber, NumeroCliente, iMachineNumber, 1, False)
    '    axCZKEM1.EnableDevice(iMachineNumber, True)
    'End Sub

    Public Sub AxCZKEM1_OnHIDNum(ByVal iCardNumber As Integer)
        Console.WriteLine("Cartão lido: " & iCardNumber)
        RegistarPHC(iCardNumber.ToString(), 1)
    End Sub

    Private Sub Form1_Load(sender As System.Object, e As System.EventArgs) Handles MyBase.Load
        Me.WindowState = FormWindowState.Maximized
        Console.WriteLine("Aplicação Iniciada")
        AbrirBaseDados()
        ncx = ""

        Console.WriteLine("A iniciar ligação ao leitor")
        'inicio leitor sc403
        bIsConnected = False
        iMachineNumber = 1

        If bIsConnected Then
            axCZKEM1.Disconnect()
            bIsConnected = False
        End If

        bIsConnected = axCZKEM1.Connect_Net(pica01_ip, pica01_porta)
        If bIsConnected = True Then
            iMachineNumber = 1
            If axCZKEM1.RegEvent(iMachineNumber, 65535) = True Then
                AddHandler axCZKEM1.OnHIDNum, AddressOf AxCZKEM1_OnHIDNum
            End If
        Else
            axCZKEM1.GetLastError(idwErrorCode)
        End If
    End Sub
End Class
