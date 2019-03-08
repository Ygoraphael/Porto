<Global.Microsoft.VisualBasic.CompilerServices.DesignerGenerated()> _
Partial Class myFrm
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
        Me.foto = New System.Windows.Forms.PictureBox()
        Me.lblNO = New System.Windows.Forms.Label()
        Me.lblNome = New System.Windows.Forms.Label()
        Me.imgEstado = New System.Windows.Forms.PictureBox()
        Me.lblRazao = New System.Windows.Forms.Label()
        Me.lblData = New System.Windows.Forms.Label()
        Me.lblHora = New System.Windows.Forms.Label()
        CType(Me.foto, System.ComponentModel.ISupportInitialize).BeginInit()
        CType(Me.imgEstado, System.ComponentModel.ISupportInitialize).BeginInit()
        Me.SuspendLayout()
        '
        'foto
        '
        Me.foto.Location = New System.Drawing.Point(26, 12)
        Me.foto.Name = "foto"
        Me.foto.Size = New System.Drawing.Size(195, 236)
        Me.foto.TabIndex = 0
        Me.foto.TabStop = False
        '
        'lblNO
        '
        Me.lblNO.Font = New System.Drawing.Font("Microsoft Sans Serif", 15.0!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.lblNO.Location = New System.Drawing.Point(23, 257)
        Me.lblNO.Name = "lblNO"
        Me.lblNO.Size = New System.Drawing.Size(420, 23)
        Me.lblNO.TabIndex = 1
        Me.lblNO.Text = "Numero"
        '
        'lblNome
        '
        Me.lblNome.Font = New System.Drawing.Font("Microsoft Sans Serif", 15.0!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.lblNome.Location = New System.Drawing.Point(23, 290)
        Me.lblNome.Name = "lblNome"
        Me.lblNome.Size = New System.Drawing.Size(420, 45)
        Me.lblNome.TabIndex = 2
        Me.lblNome.Text = "Nome"
        '
        'imgEstado
        '
        Me.imgEstado.Location = New System.Drawing.Point(467, 12)
        Me.imgEstado.Name = "imgEstado"
        Me.imgEstado.Size = New System.Drawing.Size(329, 323)
        Me.imgEstado.TabIndex = 3
        Me.imgEstado.TabStop = False
        '
        'lblRazao
        '
        Me.lblRazao.Font = New System.Drawing.Font("Microsoft Sans Serif", 25.0!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.lblRazao.Location = New System.Drawing.Point(23, 347)
        Me.lblRazao.Name = "lblRazao"
        Me.lblRazao.Size = New System.Drawing.Size(773, 66)
        Me.lblRazao.TabIndex = 4
        Me.lblRazao.Text = "Razao"
        '
        'lblData
        '
        Me.lblData.Font = New System.Drawing.Font("Microsoft Sans Serif", 20.0!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.lblData.Location = New System.Drawing.Point(236, 12)
        Me.lblData.Name = "lblData"
        Me.lblData.Size = New System.Drawing.Size(207, 37)
        Me.lblData.TabIndex = 5
        Me.lblData.Text = "Data"
        '
        'lblHora
        '
        Me.lblHora.Font = New System.Drawing.Font("Microsoft Sans Serif", 20.0!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.lblHora.Location = New System.Drawing.Point(236, 65)
        Me.lblHora.Name = "lblHora"
        Me.lblHora.Size = New System.Drawing.Size(207, 37)
        Me.lblHora.TabIndex = 6
        Me.lblHora.Text = "Hora"
        '
        'myFrm
        '
        Me.AutoScaleDimensions = New System.Drawing.SizeF(6.0!, 13.0!)
        Me.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font
        Me.ClientSize = New System.Drawing.Size(808, 427)
        Me.Controls.Add(Me.lblHora)
        Me.Controls.Add(Me.lblData)
        Me.Controls.Add(Me.lblRazao)
        Me.Controls.Add(Me.imgEstado)
        Me.Controls.Add(Me.lblNome)
        Me.Controls.Add(Me.lblNO)
        Me.Controls.Add(Me.foto)
        Me.Name = "myFrm"
        Me.Text = "myFrm"
        CType(Me.foto, System.ComponentModel.ISupportInitialize).EndInit()
        CType(Me.imgEstado, System.ComponentModel.ISupportInitialize).EndInit()
        Me.ResumeLayout(False)

    End Sub
    Friend WithEvents foto As System.Windows.Forms.PictureBox
    Friend WithEvents lblNO As System.Windows.Forms.Label
    Friend WithEvents lblNome As System.Windows.Forms.Label
    Friend WithEvents imgEstado As System.Windows.Forms.PictureBox
    Friend WithEvents lblRazao As System.Windows.Forms.Label
    Friend WithEvents lblData As System.Windows.Forms.Label
    Friend WithEvents lblHora As System.Windows.Forms.Label
End Class
