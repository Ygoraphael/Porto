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
        Me.RemoteDesktop1 = New VncSharp.RemoteDesktop()
        Me.SuspendLayout()
        '
        'RemoteDesktop1
        '
        Me.RemoteDesktop1.AutoScroll = True
        Me.RemoteDesktop1.AutoScrollMinSize = New System.Drawing.Size(608, 427)
        Me.RemoteDesktop1.Location = New System.Drawing.Point(24, 12)
        Me.RemoteDesktop1.Name = "RemoteDesktop1"
        Me.RemoteDesktop1.Size = New System.Drawing.Size(823, 345)
        Me.RemoteDesktop1.TabIndex = 0
        '
        'Form1
        '
        Me.AutoScaleDimensions = New System.Drawing.SizeF(6.0!, 13.0!)
        Me.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font
        Me.ClientSize = New System.Drawing.Size(874, 369)
        Me.Controls.Add(Me.RemoteDesktop1)
        Me.Name = "Form1"
        Me.Text = "Form1"
        Me.ResumeLayout(False)

    End Sub
    Friend WithEvents RemoteDesktop1 As VncSharp.RemoteDesktop

End Class
