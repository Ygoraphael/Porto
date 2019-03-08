Imports System.Data.Odbc
Imports System.IO
Imports System.Text
Imports System.Net

Public Class Class1

    Public oODBCConnection As OdbcConnection
    Public db_database As String

    Public Function DbConnect(ByVal odbc As String, ByVal db As String, ByVal user As String, ByVal pw As String) As Boolean
        Dim sConnString As String = _
            "Dsn=" & odbc & ";" & _
            "Uid=" & user & ";" & _
            "Pwd=" & pw
        oODBCConnection = New System.Data.Odbc.OdbcConnection(sConnString)
        db_database = db
        Return True
    End Function

    Public Function Teste() As Boolean

        If My.Computer.Network.IsAvailable Then

            Dim queryString As String = "USE " & db_database & "; SELECT ncont FROM e1;"
            Dim command As New OdbcCommand(queryString)
            command.Connection = oODBCConnection
            oODBCConnection.Open()
            Dim myReader As OdbcDataReader = command.ExecuteReader()
            Dim tmp As String = ""
            If myReader.HasRows Then
                myReader.Read()
                tmp = myReader.GetString(myReader.GetOrdinal("ncont"))

                Dim url As String = "http://localhost/teste/teste.php"
                Dim request As WebRequest = WebRequest.Create(url)
                request.Method = "POST"
                Dim postData As String = "ncont=" & tmp
                Dim byteArray As Byte() = Encoding.UTF8.GetBytes(postData)
                request.ContentType = "application/x-www-form-urlencoded"
                request.ContentLength = byteArray.Length
                Dim dataStream As Stream = request.GetRequestStream()
                dataStream.Write(byteArray, 0, byteArray.Length)
                dataStream.Close()
                Dim response As WebResponse = request.GetResponse()
                dataStream = response.GetResponseStream()
                Dim reader As New StreamReader(dataStream)
                Dim responseFromServer As String = reader.ReadToEnd()

                Return responseFromServer
            Else
                Return False
            End If

        End If
        Return True
    End Function

End Class
