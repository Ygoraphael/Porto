Module Module1

    Public axCZKEM1 As New zkemkeeper.CZKEM
    Private bIsConnected = False
    Private iMachineNumber As Integer
    Public numero_cliente As Integer
    Public autorizar As Integer

    Sub Main()

        Dim clArgs() As String = Environment.GetCommandLineArgs()
        If clArgs.Count() <> 3 Then
            Return
        Else
            numero_cliente = clArgs(1)
            autorizar = clArgs(2)
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

        'autorizar cartao
        axCZKEM1.EnableDevice(iMachineNumber, False)
        axCZKEM1.EnableUser(iMachineNumber, numero_cliente, iMachineNumber, 1, autorizar)
        axCZKEM1.EnableDevice(iMachineNumber, True)
    End Sub
End Module
