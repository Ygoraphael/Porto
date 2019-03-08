package fme;

import java.awt.Component;
import java.awt.Container;
import java.awt.Dimension;
import java.awt.Graphics;
import java.awt.Rectangle;
import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;
import java.awt.print.PageFormat;
import java.io.PrintStream;
import java.util.HashMap;
import javax.swing.BorderFactory;
import javax.swing.JButton;
import javax.swing.JCheckBox;
import javax.swing.JInternalFrame;
import javax.swing.JLabel;
import javax.swing.JOptionPane;
import javax.swing.JPanel;
import javax.swing.JTabbedPane;
import javax.swing.JTextField;


public class Frame_TabPane
  extends JInternalFrame
  implements Pagina_Base
{
  private static final long serialVersionUID = 1L;
  CHPrint print_handler;
  private JPanel jContentPane = null;
  
  private JTable_Tip jTable_QInv = null;
  
  public Frame_TabPane() {
    initialize();
  }
  
  public Dimension getSize() {
    return new Dimension(fmeApp.width - 35, 450);
  }
  
  String coluna_coop = "N";
  String coluna_conj = "S";
  
  private JTabbedPane jTabbedPane = null;
  
  private JPanel jPanel_1 = null;
  
  private JButton jButton = null;
  
  private JCheckBox jCheckBox = null;
  
  private JLabel jLabel = null;
  
  private JTextField jTextField = null;
  
  private JButton jButton1 = null;
  
  String tag = "";
  
  public void set_params(String _tag, HashMap params) {
    tag = _tag;
  }
  
  private void initialize() {
    setSize(fmeApp.width - 35, 1000);
    setContentPane(getJContentPane());
    setResizable(false);
    setBorder(null);
    getContentPane().setLayout(null);
    setDebugGraphicsOptions(0);
    setMaximumSize(new Dimension(Integer.MAX_VALUE, Integer.MAX_VALUE));
  }
  
  private JPanel getJContentPane() {
    if (jContentPane == null) {
      jContentPane = new JPanel();
      jContentPane.setLayout(null);
      jContentPane.setBorder(BorderFactory.createEmptyBorder(0, 0, 0, 0));
      jContentPane.add(getJTabbedPane(), null);
      jContentPane.add(getJTextField(), null);
      jContentPane.add(getJButton1(), null);
    }
    return jContentPane;
  }
  
  private JTabbedPane getJTabbedPane()
  {
    if (jTabbedPane == null) {
      jTabbedPane = new JTabbedPane();
      jTabbedPane.setBounds(new Rectangle(14, 12, 642, 388));
      
      jTabbedPane.addTab("1", null, new JPanelX("C1"), null);
      jTabbedPane.addTab("2", null, new JPanelX("C2"), null);
    }
    return jTabbedPane;
  }
  
  class JPanelX extends JPanel
  {
    JPanelX(String s)
    {
      jLabel = new JLabel();
      jLabel.setBounds(new Rectangle(64, 52, 160, 23));
      jLabel.setText(s);
      add(jLabel, null);
      
      JTextField jTextField = new JTextField();
      jTextField.setBounds(new Rectangle(64, 90, 160, 23));
      jTextField.setText("TEXTO");
      jTextField.setPreferredSize(new Dimension(120, 20));
      add(jTextField, null);
      
      setName(s);
    }
  }
  



  private JPanel getJPanel_1()
  {
    if (jPanel_1 == null) {
      jLabel = new JLabel();
      jLabel.setBounds(new Rectangle(64, 52, 160, 23));
      jLabel.setText("JLabel");
      jPanel_1 = new JPanel();
      jPanel_1.setLayout(null);
      jPanel_1.add(getJButton(), null);
      jPanel_1.add(getJCheckBox(), null);
      jPanel_1.add(jLabel, null);
    }
    return jPanel_1;
  }
  

  public void print_page() {}
  
  public int print(Graphics g, PageFormat pf, int pageIndex)
  {
    return 0;
  }
  
  public void clear_page() {}
  
  public CHValid_Grp validar_pg()
  {
    CHValid_Grp grp = new CHValid_Grp(fmeApp.Paginas.getCaption(tag));
    grp.add_grp(CBData.QInv.validar(null));
    return grp;
  }
  




  private JButton getJButton()
  {
    if (jButton == null) {
      jButton = new JButton();
      jButton.setBounds(new Rectangle(402, 63, 82, 27));
    }
    return jButton;
  }
  




  private JCheckBox getJCheckBox()
  {
    if (jCheckBox == null) {
      jCheckBox = new JCheckBox();
      jCheckBox.setBounds(new Rectangle(236, 54, 21, 21));
    }
    return jCheckBox;
  }
  




  private JTextField getJTextField()
  {
    if (jTextField == null) {
      jTextField = new JTextField();
      jTextField.setBounds(new Rectangle(96, 434, 122, 20));
      jTextField.setPreferredSize(new Dimension(120, 20));
      jTextField.setText("TEXTO");
    }
    return jTextField;
  }
  




  private JButton getJButton1()
  {
    if (jButton1 == null) {
      jButton1 = new JButton();
      jButton1.setBounds(new Rectangle(271, 441, 73, 22));
      jButton1.addActionListener(new ActionListener() {
        public void actionPerformed(ActionEvent e) {
          System.out.println("actionPerformed()");
          
          JOptionPane.showMessageDialog(null, "click");
          
          String s = jTabbedPane.getComponent(0).getName();
          JOptionPane.showMessageDialog(null, s);
        }
      });
    }
    
    return jButton1;
  }
}
