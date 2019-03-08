package fme;

import java.awt.Color;
import java.awt.Dimension;
import java.awt.Insets;
import java.awt.Rectangle;
import java.awt.Toolkit;
import java.awt.event.ActionEvent;
import java.awt.event.MouseEvent;
import java.awt.event.WindowEvent;
import javax.swing.ImageIcon;
import javax.swing.JButton;
import javax.swing.JDialog;
import javax.swing.JLabel;
import javax.swing.JPanel;
import javax.swing.JScrollPane;
import javax.swing.JTree;
import javax.swing.JViewport;
import javax.swing.border.MatteBorder;
import javax.swing.tree.DefaultMutableTreeNode;
import javax.swing.tree.TreeNode;
import javax.swing.tree.TreePath;
import javax.swing.tree.TreeSelectionModel;














































































































class Dialog_Valid
  extends JDialog
{
  JPanel contentPane;
  JButton cmdCancelar;
  JButton cmdSair;
  JButton cmdConfirmar;
  public String form;
  public String campo;
  public int row;
  public int col;
  public int erros;
  public int avisos;
  public boolean global;
  public boolean on_send;
  DefaultMutableTreeNode root;
  JLabel lblErro = new JLabel();
  JLabel lblAviso = new JLabel();
  JLabel lblAlerta = new JLabel();
  JScrollPane scrollPane = new JScrollPane();
  private JTree tree;
  JLabel label = new JLabel();
  int nodes_total = 0;
  JPanel pnl = new JPanel();
  
  String cmd = "";
  
  public static ImageIcon erroIcon = new ImageIcon(fmeFrame.class.getResource("erro.gif"));
  public static ImageIcon avisoIcon = new ImageIcon(fmeFrame.class.getResource("aviso.png"));
  
  public Dialog_Valid(DefaultMutableTreeNode _root, int _erros, int _avisos, boolean _global, boolean _on_send) {
    try {
      root = _root;
      erros = _erros;
      avisos = _avisos;
      global = _global;
      on_send = _on_send;
      jbInit();
      pack();
    }
    catch (Exception ex) {
      ex.printStackTrace();
    }
  }
  
  private void jbInit() throws Exception {
    boolean show_alerta = (on_send) && (erros == 0);
    JPanel contentPane = (JPanel)getContentPane();
    contentPane.setLayout(null);
    form = null;
    campo = null;
    
    cmdCancelar = new JButton();
    cmdSair = new JButton();
    cmdConfirmar = new JButton();
    



    cmdCancelar.setText("Cancelar");
    cmdCancelar.setBounds(new Rectangle(390, 120, 80, 25));
    cmdCancelar.addActionListener(new Dialog_Valid_jButton_Cancelar_actionAdapter(this));
    cmdCancelar.setMargin(new Insets(1, 1, 1, 1));
    cmdCancelar.setVisible(show_alerta);
    

    cmdSair.setText(show_alerta ? "Seguinte" : "Sair");
    cmdSair.setBounds(new Rectangle(477, 120, 80, 25));
    cmdSair.addActionListener(new Dialog_Valid_jButton_Close_actionAdapter(this));
    
    String txtAlerta = "<html>Para submissão da candidatura deve concluir o processo de exportação.<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;.&nbsp;Clique em Seguinte para avançar no processo de exportação.<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;.&nbsp;Clique em Cancelar apenas se desejar anular o processo de exportação.<br>A candidatura apenas será aceite após conclusão do processo de exportação. A conclusão do processo de exportação após encerramento do concurso não é da responsabilidade da(s) Autoridade(s) de Gestão envolvida(s), inviabilizando a aceitação da candidatura.</html>";
    









    lblAlerta.setBounds(new Rectangle(5, 13, 550, 100));
    lblAlerta.setText(txtAlerta);
    lblAlerta.setVisible(show_alerta);
    
    lblErro.setBounds(new Rectangle(5, 113, 80, 36));
    lblErro.setIcon(erroIcon);
    lblErro.setVerticalTextPosition(0);
    lblErro.setVerticalAlignment(0);
    lblErro.setHorizontalTextPosition(4);
    lblErro.setHorizontalAlignment(2);
    
    lblAviso.setBounds(new Rectangle(85, 113, 80, 36));
    lblAviso.setIcon(avisoIcon);
    lblAviso.setVerticalTextPosition(0);
    lblAviso.setVerticalAlignment(0);
    lblAviso.setHorizontalTextPosition(4);
    lblAviso.setHorizontalAlignment(2);
    

    scrollPane.setBorder(new MatteBorder(0, 0, 1, 0, new Color(230, 230, 230)));
    scrollPane.setBounds(new Rectangle(0, 0, 570, show_alerta ? 280 : 380));
    pnl.setLayout(null);
    pnl.setBounds(new Rectangle(5, 275, 560, 150));
    
    tree = new JTree(root);
    tree.getSelectionModel().setSelectionMode(1);
    
    tree.setBackground(Color.WHITE);
    tree.setBorder(fmeComum.fieldBorder);
    tree.setOpaque(true);
    tree.setShowsRootHandles(true);
    tree.setRowHeight(0);
    tree.setSelectionRow(0);
    tree.setScrollsOnExpand(true);
    tree.setRootVisible(true);
    tree.setLargeModel(true);
    tree.putClientProperty("JTree.lineStyle", "Horizontal");
    tree.setCellRenderer(new MyTreeRenderer());
    tree.addMouseListener(new Dialog_Valid_tree_mouseAdapter(this));
    expandAll(root);
    
    setTitle("Validações - Lista de Erros e Avisos");
    lblErro.setText(erros + " Erro" + (erros != 1 ? "s" : ""));
    lblAviso.setText(avisos + " Aviso" + (avisos != 1 ? "s" : ""));
    contentPane.add(scrollPane, "North");
    scrollPane.getViewport().add(tree);
    contentPane.add(pnl, "South");
    
    pnl.add(cmdCancelar, null);
    pnl.add(cmdSair, null);
    pnl.add(lblAlerta, null);
    pnl.add(lblErro, null);
    pnl.add(lblAviso, null);
    setModal(true);
    setResizable(false);
    setSize(575, 455);
    setLocation(getDefaultToolkitgetScreenSizewidth / 2 - 
      getSizewidth / 2, 
      getDefaultToolkitgetScreenSizeheight / 2 - 
      getSizeheight / 2);
    setVisible(true);
  }
  
  void tree_mouseClicked(MouseEvent e) {
    if (e.getClickCount() == 2)
      vaiAteForm();
  }
  
  private void expandAll(TreeNode tNode) {
    TreePath tp = new TreePath(((DefaultMutableTreeNode)tNode).getPath());
    tree.expandPath(tp);
    for (int i = 0; i < tNode.getChildCount(); i++)
      expandAll(tNode.getChildAt(i));
  }
  
  protected void processWindowEvent(WindowEvent e) {
    if (e.getID() == 201) {
      jButton_Cancelar_actionPerformed(null);
    }
  }
  
  void jButton_Close_actionPerformed(ActionEvent e) {
    cmd = "X";
    hide();
  }
  
  void jButton_Cancelar_actionPerformed(ActionEvent e) {
    cmd = "G";
    hide();
    if ((on_send) && (erros == 0))
      fmeFrame.cancelar_send();
  }
  
  void vaiAteForm() {
    DefaultMutableTreeNode s = (DefaultMutableTreeNode)tree.getLastSelectedPathComponent();
    if (s == null) return;
    if ((s instanceof CHValid_Msg)) {
      CHValid_Grp h = (CHValid_Grp)s.getParent();
      handler.locate((CHValid_Msg)s);
      cmd = "G";
      hide();
    }
  }
}
