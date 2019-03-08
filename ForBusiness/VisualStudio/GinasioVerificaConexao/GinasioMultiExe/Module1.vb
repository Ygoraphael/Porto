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

            Dim idwErrorCode As Integer

            If bIsConnected Then
                axCZKEM1.Disconnect()
                bIsConnected = False
            End If

            bIsConnected = axCZKEM1.Connect_Net(pica01_ip, pica01_porta)
            If bIsConnected = True Then
                iMachineNumber = 1
                Console.WriteLine("Conexão Efetuada")
            Else
                axCZKEM1.GetLastError(idwErrorCode)
                Console.WriteLine("Unable to connect the device,ErrorCode=" & idwErrorCode.ToString())
            End If
        Else
            Console.WriteLine("Ligação.cgf errado")
        End If
    End Sub
End Module
