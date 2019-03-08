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
        Me.lvCard = New System.Windows.Forms.ListView()
        Me.columnHeader1 = CType(New System.Windows.Forms.ColumnHeader(), System.Windows.Forms.ColumnHeader)
        Me.columnHeader3 = CType(New System.Windows.Forms.ColumnHeader(), System.Windows.Forms.ColumnHeader)
        Me.columnHeader6 = CType(New System.Windows.Forms.ColumnHeader(), System.Windows.Forms.ColumnHeader)
        Me.SuspendLayout()
        '
        'Button1
        '
        Me.Button1.Location = New System.Drawing.Point(12, 216)
        Me.Button1.Name = "Button1"
        Me.Button1.Size = New System.Drawing.Size(366, 36)
        Me.Button1.TabIndex = 1
        Me.Button1.Text = "Listar Cartões"
        Me.Button1.UseVisualStyleBackColor = True
        '
        'lvCard
        '
        Me.lvCard.Columns.AddRange(New System.Windows.Forms.ColumnHeader() {Me.columnHeader1, Me.columnHeader3, Me.columnHeader6})
        Me.lvCard.GridLines = True
        Me.lvCard.Location = New System.Drawing.Point(12, 12)
        Me.lvCard.Name = "lvCard"
        Me.lvCard.Size = New System.Drawing.Size(366, 198)
        Me.lvCard.TabIndex = 46
        Me.lvCard.UseCompatibleStateImageBehavior = False
        Me.lvCard.View = System.Windows.Forms.View.Details
        '
        'columnHeader1
        '
        Me.columnHeader1.Text = "UserID"
        Me.columnHeader1.Width = 120
        '
        'columnHeader3
        '
        Me.columnHeader3.Text = "Cardnumber"
        Me.columnHeader3.Width = 120
        '
        'columnHeader6
        '
        Me.columnHeader6.Text = "Enabled"
        Me.columnHeader6.Width = 120
        '
        'Form1
        '
        Me.AutoScaleDimensions = New System.Drawing.SizeF(6.0!, 13.0!)
        Me.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font
        Me.ClientSize = New System.Drawing.Size(394, 262)
        Me.Controls.Add(Me.lvCard)
        Me.Controls.Add(Me.Button1)
        Me.Name = "Form1"
        Me.Text = "Listagem Cartões"
        Me.ResumeLayout(False)

    End Sub
    Friend WithEvents Button1 As System.Windows.Forms.Button
    Private WithEvents lvCard As System.Windows.Forms.ListView
    Private WithEvents columnHeader1 As System.Windows.Forms.ColumnHeader
    Private WithEvents columnHeader3 As System.Windows.Forms.ColumnHeader
    Private WithEvents columnHeader6 As System.Windows.Forms.ColumnHeader

End Class
