Imports System.Data.Odbc

Public Class ClassInterop

    Public oODBCConnection As OdbcConnection
    Public db_database As String

    Public Function DbConnect(ByVal odbc As String, ByVal db As String, ByVal user As String, ByVal pw As String) As Boolean
        Dim sConnString As String = _
            "Dsn=" & odbc & ";" & _
            "Uid=" & user & ";" & _
            "Pwd=" & pw
        oODBCConnection = New Odbc.OdbcConnection(sConnString)
        db_database = db
        Return True
    End Function

    Public Function Teste(ByVal no As String, ByVal nome As String) As String
        Using frm As New Form1
            With frm
                .no = no
                .nome = nome
                .oODBCConnection = oODBCConnection
                .db_database = db_database
                .ShowDialog()
            End With
        End Using
        Return "Cliente Nao Existe"
    End Function
End Class
