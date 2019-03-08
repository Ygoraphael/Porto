Public Class _Default
    Inherits System.Web.UI.Page

    Public tmp_string As String = ""

    Protected Sub Page_Load(ByVal sender As Object, ByVal e As System.EventArgs) Handles Me.Load
    End Sub

    Private Sub faz_contagem_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles faz_contagem.Click
        Contagens()
    End Sub

    Private Sub ArrayToString(ByVal lista)
        For i As Integer = 0 To lista.Length - 2
            tmp_string += lista(i).ToString() + ", "
        Next
        tmp_string += lista(lista.Length - 1).ToString()
    End Sub

    Private Sub Contagens()

        Dim valores(10) As Integer
        For i As Integer = 0 To 9
            Randomize()
            Dim value As Integer = CInt(Int((6 * Rnd()) + 1))
            valores(i) = value
        Next

        ArrayToString(valores)

    End Sub

End Class