package fme;

import java.awt.Color;
import java.awt.Dimension;
import java.awt.Insets;
import java.awt.Rectangle;
import java.awt.Toolkit;
import java.awt.event.ActionEvent;
import java.awt.print.PrinterJob;
import javax.swing.BorderFactory;
import javax.swing.JButton;
import javax.swing.JCheckBox;
import javax.swing.JDialog;
import javax.swing.JLabel;
import javax.swing.JOptionPane;
import javax.swing.JPanel;
import javax.swing.JScrollPane;
import javax.swing.JViewport;

class Dialog_Print extends JDialog
{
  JPanel contentPane;
  JButton cmdGo;
  JButton cmdSair;
  JButton cmdConfirmar;
  public String form;
  public String campo;
  public int row;
  public int col;
  public int erros;
  public int avisos;
  public int paginas;
  public boolean global;
  JButton cmdMarcar = new JButton();
  JButton cmdDesmarcar = new JButton();
  JButton cmdPrinter = new JButton();
  JScrollPane scrollPane = new JScrollPane();
  JLabel label = new JLabel();
  int nodes_total = 0;
  JPanel pnl = new JPanel();
  
  JCheckBox[] x = new JCheckBox[fmeApp.Paginas.size()];
  
  public Dialog_Print() {
    try {
      jbInit();
      pack();
    }
    catch (Exception ex) {
      ex.printStackTrace();
    }
  }
  
  private void jbInit() throws Exception {
    JPanel contentPane = (JPanel)getContentPane();
    JPanel panel = new JPanel();
    contentPane.setLayout(null);
    form = null;
    campo = null;
    cmdGo = new JButton();
    cmdSair = new JButton();
    cmdConfirmar = new JButton();
    
    int i = 0;
    for (i = 0; i < fmeApp.Paginas.size(); i++) {
      x[i] = new JCheckBox();
      x[i].setText(fmeApp.Paginas.getCaption(i));
      x[i].setFont(fmeComum.letra);
      x[i].setBounds(new Rectangle(20, 20 + 30 * i, 400, 20));
      x[i].setBorder(BorderFactory.createLineBorder(Color.black));
      x[i].setBorderPaintedFlat(true);
      x[i].setContentAreaFilled(true);
      x[i].setBorderPainted(false);
      x[i].setHorizontalTextPosition(11);
      x[i].setHorizontalAlignment(10);
      panel.add(x[i], null);
    }
    
    cmdGo.setText("Imprimir");
    cmdGo.setFont(fmeComum.letra);
    cmdGo.setBounds(new Rectangle(280, 17, 80, 30));
    cmdGo.setMargin(new Insets(2, 2, 2, 2));
    cmdGo.addActionListener(new Dialog_Print_jButton_Go_actionAdapter(this));
    
    cmdSair.setText("Cancelar");
    cmdSair.setFont(fmeComum.letra);
    cmdSair.setBounds(new Rectangle(370, 17, 80, 30));
    cmdSair.setMargin(new Insets(2, 2, 2, 2));
    cmdSair.addActionListener(new Dialog_Print_jButton_Close_actionAdapter(this));
    
    cmdMarcar.setText("Marcar");
    cmdMarcar.setFont(fmeComum.letra);
    cmdMarcar.setBounds(new Rectangle(10, 17, 80, 30));
    cmdMarcar.setMargin(new Insets(2, 2, 2, 2));
    cmdMarcar.addActionListener(new Dialog_Print_cmdMarcar_actionAdapter(this));
    
    cmdDesmarcar.setText("Desmarcar");
    cmdDesmarcar.setFont(fmeComum.letra);
    cmdDesmarcar.setBounds(new Rectangle(100, 17, 80, 30));
    cmdDesmarcar.setMargin(new Insets(2, 2, 2, 2));
    cmdDesmarcar.addActionListener(new Dialog_Print_cmdDesmarcar_actionAdapter(this));
    
    cmdPrinter.setText("Impressora");
    cmdPrinter.setFont(fmeComum.letra);
    cmdPrinter.setBounds(new Rectangle(190, 17, 80, 30));
    cmdPrinter.setMargin(new Insets(2, 2, 2, 2));
    cmdPrinter.addActionListener(new Dialog_Print_cmdPrinter_actionAdapter(this));
    
    scrollPane.setBorder(BorderFactory.createEtchedBorder());
    scrollPane.setBounds(new Rectangle(14, 12, 440, 272));
    scrollPane.setHorizontalScrollBarPolicy(31);
    pnl.setLayout(null);
    pnl.setBounds(new Rectangle(3, 275, 450, 50));
    
    setTitle("Imprimir");
    panel.setLayout(null);
    panel.setPreferredSize(new Dimension(450, 30 + 30 * i));
    contentPane.add(scrollPane, null);
    scrollPane.getViewport().add(panel, null);
    

    contentPane.add(pnl, "South");
    pnl.add(cmdGo, "East");
    pnl.add(cmdSair, null);
    pnl.add(cmdMarcar, null);
    pnl.add(cmdDesmarcar, null);
    
    setModal(true);
    setResizable(false);
    setSize(475, 355);
    setLocation(getDefaultToolkitgetScreenSizewidth / 2 - 
      getSizewidth / 2, 
      getDefaultToolkitgetScreenSizeheight / 2 - 
      getSizeheight / 2);
    setVisible(true);
  }
  
  void jButton_Close_actionPerformed(ActionEvent e) {
    hide();
  }
  
  void cmdMarcar_actionPerformed(ActionEvent e) {
    for (int i = 0; i < x.length; i++) {
      x[i].setSelected(true);
    }
  }
  
  void cmdDesmarcar_actionPerformed(ActionEvent e) {
    for (int i = 0; i < x.length; i++) {
      x[i].setSelected(false);
    }
  }
  
  void cmdPrinter_actionPerformed(ActionEvent e) {
    CHPrintPage.pj.printDialog();
  }
  
  void jButton_Go_actionPerformed(ActionEvent e)
  {
    String frame = fmeApp.Paginas.getTag();
    for (int i = 0; i < x.length; i++) {
      if (x[i].isSelected()) {
        fmeApp.Paginas.GoTo(fmeApp.Paginas.getTag(i));
        ((Pagina_Base)fmeApp.Paginas.getFrame()).print_page();
        paginas += 1;
      }
    }
    fmeApp.Paginas.GoTo(frame);
    
    if (paginas > 0) {
      hide();
    } else {
      JOptionPane.showMessageDialog(this, "Tem de selecionar a(s) Página(s) que pretende imprimir!", "Aviso", 2);
    }
  }
}
