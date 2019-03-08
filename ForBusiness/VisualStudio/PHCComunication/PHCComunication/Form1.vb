Imports System.Data.Odbc

Public Class Form1

    Public no As String = ""
    Public nome As String = ""
    Public oODBCConnection As OdbcConnection
    Public db_database As String = ""

    Private Sub Form1_Load(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles MyBase.Load
        Label2.Text = nome
        DataGridView1.Rows.Clear()

        Dim queryString As String = "USE " & db_database & "; SELECT nmdoc, fno, etotal FROM ft where no = " & no & ";"
        Dim command As New OdbcCommand(queryString)
        command.Connection = oODBCConnection
        oODBCConnection.Open()
        Dim myReader As OdbcDataReader = command.ExecuteReader()
        Dim tmp_doc As String = ""
        Dim tmp_num As String = ""
        Dim tmp_total As String = ""

        If myReader.HasRows Then
            Do While myReader.Read()
                tmp_doc = myReader.GetString(myReader.GetOrdinal("nmdoc"))
                tmp_num = myReader.GetString(myReader.GetOrdinal("fno"))
                tmp_total = myReader.GetString(myReader.GetOrdinal("etotal"))

                DataGridView1.Rows.Add(tmp_doc, tmp_num, tmp_total)
            Loop
        End If

        myReader.Close()
        oODBCConnection.Close()

    End Sub

End Class