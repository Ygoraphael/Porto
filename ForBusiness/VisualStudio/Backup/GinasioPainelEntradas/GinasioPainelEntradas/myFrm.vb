Imports System.Data.SqlClient

Public Class myFrm

    Dim xData As Date
    Dim ExisteBO As Boolean
    Dim StampboExistente As String
    Dim LOrdem As Long
    Dim LOrdemR As Long
    Dim fo As String
    Dim rr As String
    Dim des As String
    Dim dat As Date
    Dim dataobra As Date
    Dim hora As String
    Dim nome As String
    Dim Rand As Long
    Dim RandBI As Long
    Dim stamp As String
    Dim bistamp As String
    Dim t As Timer
    Public intervalo_timer As Long
    Dim hora_entrada As String
    Dim data_entrada As String
    Dim ano_entrada As String
    Dim position As String
    Dim deve_bloquear As Boolean
    Dim axCZKEM1 As zkemkeeper.CZKEM
    Public razao As String
    Dim iMachineNumber As Integer
    Dim e_funcionario As String

    Public Sub Registar(devebloq As Boolean, zkem As zkemkeeper.CZKEM, mach_num As Integer, isFunc As String)
        rr = ""
        des = "Entrada"
        deve_bloquear = devebloq
        axCZKEM1 = zkem
        e_funcionario = isFunc
        iMachineNumber = mach_num
        xData = DateTime.Now.ToString("yyyy-MM-dd")
        data_entrada = DateTime.Now.ToString("yyyy-MM-dd") & " 00:00:00.000"
        ano_entrada = DateTime.Now.ToString("yyyy")
        hora_entrada = DateTime.Now.ToString("HH:mm")
        dat = xData
        fo = (Year(dat) * 10000) + 1
        dataobra = xData
        hora = Hour(Now()).ToString()
        nome = ""
        position = Form1.Posicao

        If position = "Sim" Then
            des = razao
        End If

        Rand = Random(1000000, 9999999)
        RandBI = Random(1000000, 9999999)

        stamp = "1" & Replace(Replace(Replace(FormatDateTime(xData, vbShortDate) & FormatDateTime(lblHora.Text, vbLongTime) & Str(Rand), "-", ""), ":", ""), " ", "")
        bistamp = "2" & Replace(Replace(Replace(FormatDateTime(xData, vbShortDate) & FormatDateTime(lblHora.Text, vbLongTime) & Str(RandBI), "-", ""), ":", ""), " ", "")

        VerExisteDossierPonto()

        FuncaoTimer()
    End Sub

    Private Sub VerLordem()
        Try
            Form1.cnn.Open()
            Form1.command = New SqlCommand("Select top 1 lordem from BI (nolock) where ndos=" & Form1.xNDOS & " and obrano=" & fo & " order by lordem desc", Form1.cnn)
            Dim sqlReader As SqlDataReader = Form1.command.ExecuteReader()
            If sqlReader.HasRows Then
                sqlReader.Read()
                LOrdemR = Val(sqlReader.Item(0)) + 1
            Else
                LOrdemR = 1000
            End If

            sqlReader.Close()
            Form1.command.Dispose()
            Form1.cnn.Close()
        Catch ex As Exception
            Console.WriteLine(ex)
        End Try
    End Sub
    Private Sub CriaDossierPontoBO()
        Try
            Form1.cnn.Open()

            Form1.command = New SqlCommand("Select (" & ano_entrada & "*10000)+isnull(max(convert(decimal(10,0), right(convert(varchar(10), obrano), 4))),0) + 1 obrano from bo (nolock) where ndos=" & Form1.xNDOS & " and convert(decimal(10,0), left(convert(varchar(10), obrano), 4)) = " & ano_entrada, Form1.cnn)
            Dim sqlReader As SqlDataReader = Form1.command.ExecuteReader()
            If sqlReader.HasRows Then
                sqlReader.Read()
                If Val(sqlReader.Item(0)) <> 0 Then
                    fo = Val(sqlReader.Item(0))
                End If
            End If
            sqlReader.Close()
            Form1.command.Dispose()

            Dim Str As String
            Str = "INSERT INTO BO (ndos, nmdos, bostamp, obrano, no, nome, dataobra, boano, moeda) VALUES ("
            Str = Str & Form1.xNDOS & ", "
            Str = Str & "'" & Form1.xNMDOS & "', "
            Str = Str & "'" & stamp & "', "
            Str = Str & fo & ", "
            Str = Str & lblNO.Text & ", "
            Str = Str & "'" & lblNome.Text & "', "
            Str = Str & "'" & DateTime.Now.ToString("yyyy-MM-dd") & " 00:00:00.000" & "', "
            Str = Str & Year(Date.Now) & ", "
            Str = Str & "'" & "PTE ou EURO" & "')"

            Form1.command = New SqlCommand(Str, Form1.cnn)

            Console.WriteLine(Str)

            Form1.command.ExecuteNonQuery()
            Form1.command.Dispose()
            Form1.cnn.Close()
        Catch ex As Exception
            Console.WriteLine(ex)
        End Try
    End Sub
    Private Sub CriaDossierPontoBI()
        Dim ref As String
        Dim design As String
        Dim lobs3 As String
        xData = Date.Now
        If UCase(Form1.Posto) = "BAR" Then
            ref = ""
            design = ""
            lobs3 = ""
        Else
            ref = rr
            design = des
            lobs3 = Mid(des, 1, 40)
        End If

        Try
            Form1.command.Dispose()
            Form1.cnn.Close()
        Catch ex As Exception
            Console.WriteLine(ex)
        End Try

        Try
            Form1.cnn.Open()

            Dim Str As String
            Str = "INSERT INTO BI (binum2, posic, ndos, nmdos, bistamp, bostamp, obrano, no, nome, dataobra, rdata, lobs, binum1, lobs2, lordem, oobistamp, ref, design, lobs3) VALUES ("
            Str = Str & Val(Mid(hora, 1, 2)) & ", "
            Str = Str & "'" & position & "', "
            Str = Str & Form1.xNDOS & ", "
            Str = Str & "'" & Form1.xNMDOS & "', "
            Str = Str & "'" & bistamp & "', "

            If ExisteBO = True Then
                Str = Str & "'" & StampboExistente & "', "
            Else
                Str = Str & "'" & stamp & "', "
            End If

            Str = Str & fo & ", "
            Str = Str & lblNO.Text & ", "
            Str = Str & "'" & lblNome.Text & "', "
            Str = Str & "'" & data_entrada & "', "
            Str = Str & "'" & data_entrada & "', "
            Str = Str & "'" & hora_entrada & "', "
            Str = Str & lblNO.Text & ", "
            Str = Str & "'" & Mid(lblNome.Text, 1, 40) & "', "
            Str = Str & LOrdemR & ", "
            Str = Str & "'', "
            Str = Str & "'" & ref & "', "
            Str = Str & "'" & design & "', "
            Str = Str & "'" & lobs3 & "')"

            Console.WriteLine(Str)

            Form1.command = New SqlCommand(Str, Form1.cnn)
            Form1.command.ExecuteNonQuery()
            Form1.command.Dispose()
            Form1.cnn.Close()
        Catch ex As Exception
            Console.WriteLine(ex)
        End Try
    End Sub
    Private Sub VerExisteDossierPonto()
        ExisteBO = False
        StampboExistente = ""

        Try
            Form1.cnn.Open()
            Form1.command = New SqlCommand("Select bostamp from BO (nolock) where year(dataobra)=" & ano_entrada & " and no=" & lblNO.Text & " and ndos=" & Form1.xNDOS, Form1.cnn)
            Dim sqlReader As SqlDataReader = Form1.command.ExecuteReader()
            If sqlReader.HasRows Then
                sqlReader.Read()
                ExisteBO = True
                StampboExistente = RTrim(sqlReader.Item(0))
            End If

            sqlReader.Close()
            Form1.command.Dispose()
            Form1.cnn.Close()
        Catch ex As Exception
            Console.WriteLine(ex)
        End Try
    End Sub

    Function Random(Lowerbound As Long, Upperbound As Long)
        Randomize()
        Random = Int(Rnd() * Upperbound) + Lowerbound
    End Function

    Private Sub Form_Load()
        xData = Date.Now
    End Sub

    Private Sub FuncaoTimer()
        t = New Timer()
        t.Interval = intervalo_timer * 1000
        AddHandler t.Tick, AddressOf HandleTimerTick
        t.Start()
    End Sub

    Private Function LeituraMultipla() As Boolean
        Try
            Form1.cnn.Open()

            Form1.command = New SqlCommand("Select lobs from bi (nolock) where dataobra = '" & data_entrada & "' and no = " & lblNO.Text & " and ndos=" & Form1.xNDOS, Form1.cnn)
            Dim sqlReader As SqlDataReader = Form1.command.ExecuteReader()
            Dim tmp_ret = 0
            If sqlReader.HasRows Then
                While sqlReader.Read()
                    Dim hora_a As TimeSpan = TimeSpan.Parse(sqlReader.Item(0)).Add(TimeSpan.FromMinutes(2))
                    Dim hora_b As TimeSpan = TimeSpan.Parse(sqlReader.Item(0)).Subtract(TimeSpan.FromMinutes(2))
                    Dim hora_c As TimeSpan = TimeSpan.Parse(hora_entrada)

                    Console.WriteLine(hora_b.ToString() & " -- " & hora_a.ToString() & " -- " & hora_c.ToString())

                    If hora_c >= hora_b And hora_c <= hora_a Then
                        Console.WriteLine("Multipla Leitura")
                        tmp_ret = 1
                    End If
                End While
            End If
            sqlReader.Close()
            Form1.command.Dispose()
            Form1.cnn.Close()

            If tmp_ret = 1 Then
                Return True
            Else
                Return False
            End If

        Catch ex As Exception
            Console.WriteLine(ex)
        End Try

        Return False
    End Function

    Private Sub HandleTimerTick(ByVal sender As System.Object, ByVal e As System.EventArgs)
        t.Stop()

        If ExisteBO = False Then
            If Not LeituraMultipla() Then
                VerLordem()
                CriaDossierPontoBO()
                CriaDossierPontoBI()
            End If
        Else
            If Not LeituraMultipla() Then
                VerLordem()
                CriaDossierPontoBI()
            End If
        End If

        If deve_bloquear = True Then
            axCZKEM1.EnableDevice(iMachineNumber, False)
            Dim valor As Integer
            Try
                valor = Convert.ToInt32(lblNO.Text)
            Catch ex As Exception
                valor = 0
            End Try
            axCZKEM1.EnableUser(iMachineNumber, valor, iMachineNumber, 1, False)
            axCZKEM1.EnableDevice(iMachineNumber, True)
        End If

        Me.Close()
    End Sub

End Class