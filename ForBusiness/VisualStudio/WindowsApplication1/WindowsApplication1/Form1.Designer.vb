Imports Excel = Microsoft.Office.Interop.Excel
Imports Office = Microsoft.Office.Core
Imports System.Data.SQLite

<Global.Microsoft.VisualBasic.CompilerServices.DesignerGenerated()> _
Partial Class Form1
    Inherits System.Windows.Forms.Form

    'Form overrides dispose to clean up the component list.
    <System.Diagnostics.DebuggerNonUserCode()> _
    Protected Overrides Sub Dispose(ByVal disposing As Boolean)
        Try
            If disposing AndAlso components IsNot Nothing Then
                components.Dispose()
            End If
        Finally
            MyBase.Dispose(disposing)
        End Try
    End Sub

    'Required by the Windows Form Designer
    Private components As System.ComponentModel.IContainer

    'NOTE: The following procedure is required by the Windows Form Designer
    'It can be modified using the Windows Form Designer.  
    'Do not modify it using the code editor.
    <System.Diagnostics.DebuggerStepThrough()> _
    Private Sub InitializeComponent()
        Me.Button1 = New System.Windows.Forms.Button()
        Me.OpenFileDialog1 = New System.Windows.Forms.OpenFileDialog()
        Me.TextBox1 = New System.Windows.Forms.TextBox()
        Me.TextBox2 = New System.Windows.Forms.TextBox()
        Me.Button2 = New System.Windows.Forms.Button()
        Me.Label1 = New System.Windows.Forms.Label()
        Me.Label2 = New System.Windows.Forms.Label()
        Me.Button3 = New System.Windows.Forms.Button()
        Me.Button4 = New System.Windows.Forms.Button()
        Me.OpenFileDialog2 = New System.Windows.Forms.OpenFileDialog()
        Me.SuspendLayout()
        '
        'Button1
        '
        Me.Button1.Location = New System.Drawing.Point(357, 61)
        Me.Button1.Name = "Button1"
        Me.Button1.Size = New System.Drawing.Size(71, 20)
        Me.Button1.TabIndex = 0
        Me.Button1.Text = "Abrir"
        Me.Button1.UseVisualStyleBackColor = True
        '
        'OpenFileDialog1
        '
        Me.OpenFileDialog1.FileName = "OpenFileDialog1"
        '
        'TextBox1
        '
        Me.TextBox1.Location = New System.Drawing.Point(94, 62)
        Me.TextBox1.Name = "TextBox1"
        Me.TextBox1.Size = New System.Drawing.Size(257, 20)
        Me.TextBox1.TabIndex = 1
        '
        'TextBox2
        '
        Me.TextBox2.Location = New System.Drawing.Point(94, 102)
        Me.TextBox2.Name = "TextBox2"
        Me.TextBox2.Size = New System.Drawing.Size(257, 20)
        Me.TextBox2.TabIndex = 2
        '
        'Button2
        '
        Me.Button2.Location = New System.Drawing.Point(357, 101)
        Me.Button2.Name = "Button2"
        Me.Button2.Size = New System.Drawing.Size(71, 20)
        Me.Button2.TabIndex = 3
        Me.Button2.Text = "Abrir"
        Me.Button2.UseVisualStyleBackColor = True
        '
        'Label1
        '
        Me.Label1.AutoSize = True
        Me.Label1.Location = New System.Drawing.Point(16, 65)
        Me.Label1.Name = "Label1"
        Me.Label1.Size = New System.Drawing.Size(76, 13)
        Me.Label1.TabIndex = 4
        Me.Label1.Text = "Ficheiro Excel:"
        '
        'Label2
        '
        Me.Label2.AutoSize = True
        Me.Label2.Location = New System.Drawing.Point(7, 105)
        Me.Label2.Name = "Label2"
        Me.Label2.Size = New System.Drawing.Size(86, 13)
        Me.Label2.TabIndex = 5
        Me.Label2.Text = "Base Dados XD:"
        '
        'Button3
        '
        Me.Button3.Location = New System.Drawing.Point(94, 159)
        Me.Button3.Name = "Button3"
        Me.Button3.Size = New System.Drawing.Size(109, 54)
        Me.Button3.TabIndex = 6
        Me.Button3.Text = "Importar P/ Excel"
        Me.Button3.UseVisualStyleBackColor = True
        '
        'Button4
        '
        Me.Button4.Location = New System.Drawing.Point(242, 159)
        Me.Button4.Name = "Button4"
        Me.Button4.Size = New System.Drawing.Size(109, 54)
        Me.Button4.TabIndex = 7
        Me.Button4.Text = "Importar P/ XD"
        Me.Button4.UseVisualStyleBackColor = True
        '
        'OpenFileDialog2
        '
        Me.OpenFileDialog2.FileName = "OpenFileDialog2"
        '
        'Form1
        '
        Me.AutoScaleDimensions = New System.Drawing.SizeF(6.0!, 13.0!)
        Me.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font
        Me.ClientSize = New System.Drawing.Size(448, 273)
        Me.Controls.Add(Me.Button4)
        Me.Controls.Add(Me.Button3)
        Me.Controls.Add(Me.Label2)
        Me.Controls.Add(Me.Label1)
        Me.Controls.Add(Me.Button2)
        Me.Controls.Add(Me.TextBox2)
        Me.Controls.Add(Me.TextBox1)
        Me.Controls.Add(Me.Button1)
        Me.Name = "Form1"
        Me.Text = "Form1"
        Me.ResumeLayout(False)
        Me.PerformLayout()

    End Sub
    Friend WithEvents Button1 As System.Windows.Forms.Button
    Friend WithEvents OpenFileDialog1 As System.Windows.Forms.OpenFileDialog
    Friend WithEvents TextBox1 As System.Windows.Forms.TextBox
    Friend WithEvents TextBox2 As System.Windows.Forms.TextBox
    Friend WithEvents Button2 As System.Windows.Forms.Button
    Friend WithEvents Label1 As System.Windows.Forms.Label
    Friend WithEvents Label2 As System.Windows.Forms.Label
    Friend WithEvents Button3 As System.Windows.Forms.Button
    Friend WithEvents Button4 As System.Windows.Forms.Button

    Private Sub Button1_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles Button1.Click
        OpenFileDialog1.Title = "Escolher Ficheiro Excel"
        OpenFileDialog1.InitialDirectory = "C:\Users\Tiago Loureiro\Desktop\Bruno"

        OpenFileDialog1.ShowDialog()
    End Sub

    Private Sub OpenFileDialog1_FileOk(ByVal sender As System.Object, ByVal e As System.ComponentModel.CancelEventArgs) Handles OpenFileDialog1.FileOk
        Dim strm As System.IO.Stream
        strm = OpenFileDialog1.OpenFile()
        TextBox1.Text = OpenFileDialog1.FileName.ToString()
    End Sub
    Friend WithEvents OpenFileDialog2 As System.Windows.Forms.OpenFileDialog

    Private Sub Button2_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles Button2.Click
        OpenFileDialog2.Title = "Escolher Ficheiro XD"
        OpenFileDialog2.InitialDirectory = "C:\Users\Tiago Loureiro\Desktop\Bruno"

        OpenFileDialog2.ShowDialog()
    End Sub

    Private Sub OpenFileDialog2_FileOk(ByVal sender As System.Object, ByVal e As System.ComponentModel.CancelEventArgs) Handles OpenFileDialog2.FileOk
        Dim strm2 As System.IO.Stream
        strm2 = OpenFileDialog2.OpenFile()
        TextBox2.Text = OpenFileDialog2.FileName.ToString()
    End Sub

    Dim xlsApp As Excel.Application
    Dim xlsWB As Excel.Workbook
    Dim xlsSheet As Excel.Worksheet
    Dim xlsCell As Excel.Range
    Dim xlsDatei As String


    Private Sub Button3_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles Button3.Click
        xlsApp = New Excel.Application
        xlsApp.Visible = False
        xlsWB = xlsApp.Workbooks.Open(TextBox1.Text)
        xlsSheet = xlsWB.Worksheets(1)

        Dim cmd As New SQLiteCommand
        Dim dss As New DataSet
        Dim das As New SQLiteDataAdapter

        Dim linha As Integer = 2

        Dim cons As New SQLiteConnection("Data Source =" + TextBox2.Text)
        Dim SQLreader As SQLiteDataReader

        cons.Open()
        cmd = cons.CreateCommand()

        cmd.CommandText = "SELECT Id, Description, IdParent FROM ItemsGroups;"
        SQLreader = cmd.ExecuteReader()

        While (SQLreader.Read)
            xlsSheet.Cells(linha, 1).value() = String.Format(SQLreader(0))
            xlsSheet.Cells(linha, 2).value() = String.Format(SQLreader(1))
            xlsSheet.Cells(linha, 3).value() = String.Format(SQLreader(2))
            linha = linha + 1
        End While

        SQLreader.Close()

        Dim SQLreader2 As SQLiteDataReader
        linha = 2
        xlsSheet = xlsWB.Worksheets(2)
        cmd.CommandText = "SELECT KeyId, Description, ShortName1, RetailPrice1, GroupId, Tax1, UnitOfSale, ItemType, RequiresQuantity, AskingPrice, GroupOnOrders, ServiceTxAuto, GroupOnKitchen, StockControl FROM Items;"
        SQLreader2 = cmd.ExecuteReader()

        While (SQLreader2.Read)
            xlsSheet.Cells(linha, 1).value() = String.Format(SQLreader2(0))
            xlsSheet.Cells(linha, 2).value() = String.Format(SQLreader2(1))
            xlsSheet.Cells(linha, 3).value() = String.Format(SQLreader2(2))
            xlsSheet.Cells(linha, 4).value() = String.Format(SQLreader2(3))
            xlsSheet.Cells(linha, 5).value() = String.Format(SQLreader2(4))
            xlsSheet.Cells(linha, 6).value() = String.Format(SQLreader2(5))
            xlsSheet.Cells(linha, 7).value() = String.Format(SQLreader2(6))
            xlsSheet.Cells(linha, 8).value() = String.Format(SQLreader2(7))
            xlsSheet.Cells(linha, 9).value() = String.Format(SQLreader2(8))
            xlsSheet.Cells(linha, 10).value() = String.Format(SQLreader2(9))
            xlsSheet.Cells(linha, 11).value() = String.Format(SQLreader2(10))
            xlsSheet.Cells(linha, 12).value() = String.Format(SQLreader2(11))
            xlsSheet.Cells(linha, 13).value() = String.Format(SQLreader2(12))
            xlsSheet.Cells(linha, 14).value() = String.Format(SQLreader2(13))

            linha = linha + 1
        End While

        SQLreader2.Close()
        cons.Close()
        xlsApp.Quit()

    End Sub

    Private Function converteBool(ByVal valor As String) As Integer
        If valor = True Then
            Return 1
        Else
            Return 0
        End If
    End Function

    Private Sub Button4_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles Button4.Click
        xlsApp = New Excel.Application
        xlsApp.Visible = False
        xlsApp.Interactive = False
        xlsWB = xlsApp.Workbooks.Open(TextBox1.Text, [ReadOnly]:=True)
        xlsSheet = xlsWB.Worksheets(1)

        Dim cmd As New SQLiteCommand
        Dim cmd2 As New SQLiteCommand

        Dim linha As Integer = 2

        System.IO.File.Copy(TextBox2.Text, TextBox2.Text + "2", True)
        Dim cons As New SQLiteConnection("Data Source =" + TextBox2.Text + "2;Read Only=False;")

        cons.Open()

        cmd = cons.CreateCommand()

        cmd.CommandText = "DELETE FROM ItemsGroups;"
        cmd.ExecuteNonQuery()

        cmd.CommandText = "DELETE FROM Items;"
        cmd.ExecuteNonQuery()

        xlsSheet = xlsWB.Worksheets(1)

        Try
            While Not String.IsNullOrEmpty(xlsSheet.Cells(linha, 1).value().ToString)
                cmd.CommandText = "INSERT INTO ItemsGroups(Id, Description, IdParent) VALUES ('" & xlsSheet.Cells(linha, 1).value() & "', '" & xlsSheet.Cells(linha, 2).value() & "', '" & xlsSheet.Cells(linha, 3).value() & "');"
                cmd.ExecuteNonQuery()
                linha = linha + 1
            End While
        Catch
            Console.WriteLine("Fim Familias")
        End Try

        xlsSheet = xlsWB.Worksheets(2)
        linha = 2

        Try
            While Not String.IsNullOrEmpty(xlsSheet.Cells(linha, 1).value().ToString)
                cmd.CommandText = "INSERT INTO Items(Id, KeyId, Description, ShortName1, RetailPrice1, GroupId, Tax1, UnitOfSale, ItemType, RequiresQuantity, AskingPrice, GroupOnOrders, ServiceTxAuto, GroupOnKitchen, StockControl) VALUES ('" _
                        & xlsSheet.Cells(linha, 1).value() _
                        & "', '" & xlsSheet.Cells(linha, 1).value() _
                        & "', '" & xlsSheet.Cells(linha, 2).value() _
                        & "', '" & xlsSheet.Cells(linha, 3).value() _
                        & "', '" & xlsSheet.Cells(linha, 4).value() _
                        & "', '" & xlsSheet.Cells(linha, 5).value() _
                        & "', '" & xlsSheet.Cells(linha, 6).value() _
                        & "', '" & xlsSheet.Cells(linha, 7).value() _
                        & "', '" & xlsSheet.Cells(linha, 8).value() _
                        & "', '" & converteBool(xlsSheet.Cells(linha, 9).value()) _
                        & "', '" & converteBool(xlsSheet.Cells(linha, 10).value()) _
                        & "', '" & converteBool(xlsSheet.Cells(linha, 11).value()) _
                        & "', '" & converteBool(xlsSheet.Cells(linha, 12).value()) _
                        & "', '" & converteBool(xlsSheet.Cells(linha, 13).value()) _
                        & "', '" & converteBool(xlsSheet.Cells(linha, 14).value()) _
                        & "');"
                cmd.ExecuteNonQuery()
                linha = linha + 1
            End While
        Catch
            Console.WriteLine("Fim Artigos")
        End Try

        cons.Close()
        xlsApp.Quit()

        System.IO.File.Delete(TextBox2.Text)
        System.IO.File.Copy(TextBox2.Text + "2", TextBox2.Text)
        System.IO.File.Delete(TextBox2.Text + "2")
    End Sub
End Class
