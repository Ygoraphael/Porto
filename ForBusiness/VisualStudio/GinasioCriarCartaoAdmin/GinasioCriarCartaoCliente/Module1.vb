Module Module1

    Public axCZKEM1 As New zkemkeeper.CZKEM
    Private bIsConnected = False
    Private iMachineNumber As Integer
    Public numero_cartao As String
    Public numero_cliente As Integer

    Sub Main()

        Dim clArgs() As String = Environment.GetCommandLineArgs()
        If clArgs.Count() <> 3 Then
            Return
        Else
            numero_cliente = clArgs(1)
            numero_cartao = clArgs(2)
        End If

        Dim idwErrorCode As Integer
        Dim pica01_ip As String = "192.168.1.202"
        Dim pica01_porta As Integer = 4370

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
        axCZKEM1.SetUserInfo(iMachineNumber, numero_cliente, numero_cartao, "", 3, True)
        axCZKEM1.SetUserGroup(iMachineNumber, numero_cliente, 1)
        axCZKEM1.RefreshData(iMachineNumber)
        axCZKEM1.EnableDevice(iMachineNumber, True)
        Console.WriteLine("Associado: " & numero_cartao)
    End Sub
End Module
