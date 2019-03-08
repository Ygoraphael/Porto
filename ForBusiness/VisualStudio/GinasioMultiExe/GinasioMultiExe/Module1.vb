Imports System.IO
Imports System.Data.SqlClient

Module Module1
    Public axCZKEM1 As New zkemkeeper.CZKEM
    Private bIsConnected = False
    Private iMachineNumber As Integer
    Public tipo As Integer
    Public numero_cartao As String
    Public numero_cliente As Integer
    Public autorizar As Integer
    Public pica01_ip As String
    Public pica01_porta As Integer
    Dim AppPath As String = System.AppDomain.CurrentDomain.BaseDirectory
    Dim connectionString As String
    Public cnn As SqlConnection
    Public command As SqlCommand


    Sub Main()
        Dim clArgs() As String = Environment.GetCommandLineArgs()
        If clArgs.Count() = 1 Then
            Return
        Else
            AbrirBaseDados()
            tipo = clArgs(1)

            'exe para criar cartao
            If tipo = 1 Then
                Console.WriteLine("Criar Cartao")
                If clArgs.Count() <> 4 Then
                    Return
                Else
                    numero_cliente = clArgs(2)
                    numero_cartao = clArgs(3)
                    CriarCartao()
                End If
            End If

            'exe para autorizar_bloquear cartao
            If tipo = 2 Then
                Console.WriteLine("Autorizar/Bloquear Cartao")
                If clArgs.Count() <> 4 Then
                    Return
                Else
                    numero_cliente = clArgs(2)
                    autorizar = clArgs(3)
                    AcessoCartao()
                End If
            End If

            'exe de rotina do leitor
            If tipo = 3 Then
                Console.WriteLine("Rotina Leitor")
                RotinaLeitor()
            End If
        End If
    End Sub

    Sub CriarCartao()
        Dim idwErrorCode As Integer

        If bIsConnected Then
            axCZKEM1.Disconnect()
            bIsConnected = False
        End If

        bIsConnected = axCZKEM1.Connect_Net(pica01_ip, pica01_porta)
        If bIsConnected = True Then
            iMachineNumber = 1
        Else
            axCZKEM1.GetLastError(idwErrorCode)
            Console.WriteLine("Unable to connect the device,ErrorCode=" & idwErrorCode.ToString())
        End If

        'associar cartao
        axCZKEM1.EnableDevice(iMachineNumber, False)
        axCZKEM1.SetStrCardNumber(numero_cartao)
        axCZKEM1.AccGroup = 1
        axCZKEM1.SetUserInfo(iMachineNumber, numero_cliente, numero_cartao, "", 0, True)
        axCZKEM1.SetUserGroup(iMachineNumber, numero_cliente, 1)
        axCZKEM1.RefreshData(iMachineNumber)
        axCZKEM1.EnableDevice(iMachineNumber, True)
        Console.WriteLine("Associado: " & numero_cartao)
    End Sub

    Sub AcessoCartao()
        Dim idwErrorCode As Integer

        If bIsConnected Then
            axCZKEM1.Disconnect()
            bIsConnected = False
        End If

        bIsConnected = axCZKEM1.Connect_Net(pica01_ip, pica01_porta)
        If bIsConnected = True Then
            iMachineNumber = 1
        Else
            axCZKEM1.GetLastError(idwErrorCode)
            Console.WriteLine("Unable to connect the device,ErrorCode=" & idwErrorCode.ToString())
        End If

        'associar cartao
        axCZKEM1.EnableDevice(iMachineNumber, False)
        axCZKEM1.EnableUser(iMachineNumber, numero_cliente, iMachineNumber, 1, autorizar)
        axCZKEM1.EnableDevice(iMachineNumber, True)
        Console.WriteLine("Cartao autorizado/bloqueado com sucesso")
    End Sub

    Sub RotinaLeitor()
        Dim idwErrorCode As Integer

        If bIsConnected Then
            axCZKEM1.Disconnect()
            bIsConnected = False
        End If

        bIsConnected = axCZKEM1.Connect_Net(pica01_ip, pica01_porta)
        If bIsConnected = True Then
            iMachineNumber = 1
        Else
            axCZKEM1.GetLastError(idwErrorCode)
            Console.WriteLine("Unable to connect the device,ErrorCode=" & idwErrorCode.ToString())
        End If

        Dim idwEnrollNumber As Integer
        Dim sName As String = ""
        Dim sPassword As String = ""
        Dim iPrivilege As Integer
        Dim bEnabled As Boolean = False
        Dim sCardnumber As String = ""
        Dim UsersAtivosLeitor As New ArrayList
        Dim UsersAtivosBD As New ArrayList
        Dim UsersBD As New ArrayList
        Dim FuncBD As New ArrayList

        'guardar todos users na bd
        Try
            cnn.Open()
            command = New SqlCommand("select no, u_codval From cl where u_codval <> '' order by no asc", cnn)
            Dim sqlReader As SqlDataReader = command.ExecuteReader()
            If sqlReader.HasRows Then
                Do While sqlReader.Read()
                    UsersBD.Add(sqlReader.Item(0) & "|" & sqlReader.Item(1))
                Loop
            End If

            sqlReader.Close()
            command.Dispose()
            cnn.Close()
        Catch ex As Exception
            Console.WriteLine(ex)
        End Try

        'associar todos cartoes
        axCZKEM1.EnableDevice(iMachineNumber, False)
        For Each item As String In UsersBD
            Dim vars As String() = item.Split("|")
            axCZKEM1.SetStrCardNumber(vars(1))
            axCZKEM1.AccGroup = 1
            axCZKEM1.SetUserInfo(iMachineNumber, Convert.ToInt32(vars(0)), vars(1), "", 0, False)
            axCZKEM1.SetUserGroup(iMachineNumber, Convert.ToInt32(vars(0)), 1)
            axCZKEM1.RefreshData(iMachineNumber)
        Next
        axCZKEM1.EnableDevice(iMachineNumber, True)

        '*******************************************************************

        'guardar todos funcionarios na bd
        Try
            cnn.Open()
            command = New SqlCommand("select no From cl where u_codval <> '' and u_isfunc = 1 order by no asc", cnn)
            Dim sqlReader As SqlDataReader = command.ExecuteReader()
            If sqlReader.HasRows Then
                Do While sqlReader.Read()
                    FuncBD.Add(sqlReader.Item(0))
                Loop
            End If

            sqlReader.Close()
            command.Dispose()
            cnn.Close()
        Catch ex As Exception
            Console.WriteLine(ex)
        End Try

        'guardar users ativos na bd
        Try
            cnn.Open()
            command = New SqlCommand("select no From bo Where ndos = 1 And fechada = 0 And dateadd(year, 1, dataobra) >= getdate() and (case when convert(date, getdate())>dataopen then 0 else 1 end) = 1", cnn)
            Dim sqlReader As SqlDataReader = command.ExecuteReader()
            If sqlReader.HasRows Then
                Do While sqlReader.Read()
                    UsersAtivosBD.Add(sqlReader.Item(0))
                Loop
            End If

            sqlReader.Close()
            command.Dispose()
            cnn.Close()
        Catch ex As Exception
            Console.WriteLine(ex)
        End Try

        'ativar users que deviam estar ativos
        axCZKEM1.EnableDevice(iMachineNumber, False)
        For Each item As String In UsersAtivosBD
            axCZKEM1.EnableUser(iMachineNumber, item, iMachineNumber, 1, 1)
        Next
        axCZKEM1.EnableDevice(iMachineNumber, True)

        'ativar funcionarios
        axCZKEM1.EnableDevice(iMachineNumber, False)
        For Each item As String In FuncBD
            axCZKEM1.EnableUser(iMachineNumber, item, iMachineNumber, 1, 1)
        Next
        'autorizar sempre Admin
        axCZKEM1.EnableUser(iMachineNumber, 1, iMachineNumber, 1, 1)
        axCZKEM1.EnableDevice(iMachineNumber, True)

        Console.WriteLine("Rotina concluida com sucesso")
    End Sub

    Public Sub AbrirBaseDados()
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
        End If

        If LinhasLigacao.Count = 3 Then
            connectionString = LinhasLigacao(0)
            pica01_ip = LinhasLigacao(1)
            pica01_porta = LinhasLigacao(2)

            cnn = New SqlConnection(connectionString)
            Try
                cnn.Open()
                Console.WriteLine("Ligação a base dados efetuada com sucesso")
                cnn.Close()
            Catch ex As Exception
                Console.WriteLine(ex)
            End Try
        End If
    End Sub

End Module
