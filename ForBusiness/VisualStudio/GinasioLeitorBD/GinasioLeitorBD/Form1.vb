Public Class Form1
    Public axCZKEM1 As New zkemkeeper.CZKEM
    Public bIsConnected As Boolean = False
    Dim AppPath As String = System.AppDomain.CurrentDomain.BaseDirectory

    Private Sub Button1_Click(sender As System.Object, e As System.EventArgs) Handles Button1.Click

        Dim file_name As String = AppPath & "\Ligação.cfg"
        Dim TextLine As String = ""
        Dim LinhasLigacao As New ArrayList
        Dim idwEnrollNumber As Integer
        Dim sName As String = ""
        Dim sPassword As String = ""
        Dim iPrivilege As Integer
        Dim bEnabled As Boolean = False
        Dim sCardnumber As String = ""
        Dim iMachineNumber As Integer = 1

        If System.IO.File.Exists(file_name) = True Then
            Dim objReader As New System.IO.StreamReader(file_name)
            Do While objReader.Peek() <> -1
                LinhasLigacao.Add(objReader.ReadLine())
            Loop
        Else
            MsgBox("Ligação.cfg não existe.")
        End If

        Dim pica01_ip As String = LinhasLigacao(1)
        Dim pica01_porta As Integer = LinhasLigacao(2)

        If LinhasLigacao.Count = 3 Then
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

            lvCard.Items.Clear()
            lvCard.BeginUpdate()
            Cursor = Cursors.WaitCursor
            axCZKEM1.EnableDevice(iMachineNumber, False)
            axCZKEM1.ReadAllUserID(iMachineNumber)
            While axCZKEM1.GetAllUserInfo(iMachineNumber, idwEnrollNumber, sName, sPassword, iPrivilege, bEnabled) = True
                If axCZKEM1.GetStrCardNumber(sCardnumber) = True Then
                    Dim list As New ListViewItem
                    list.Text = idwEnrollNumber.ToString()
                    list.SubItems.Add(sCardnumber)
                    If bEnabled = True Then
                        list.SubItems.Add("true")
                    Else
                        list.SubItems.Add("false")
                    End If
                    lvCard.Items.Add(list)
                End If
            End While

            axCZKEM1.EnableDevice(iMachineNumber, True)
            lvCard.EndUpdate()
            Cursor = Cursors.Default
            axCZKEM1.Disconnect()
            bIsConnected = False
        End If
    End Sub
End Class
