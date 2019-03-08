package fme;

import java.awt.Color;
import java.awt.Component;
import java.awt.Dimension;
import java.awt.Graphics;
import java.awt.Graphics2D;
import java.awt.print.PageFormat;
import java.awt.print.Paper;
import java.awt.print.PrinterException;
import java.awt.print.PrinterJob;
import java.util.Vector;
import javax.swing.BorderFactory;
import javax.swing.JCheckBox;
import javax.swing.JComboBox;
import javax.swing.JEditorPane;
import javax.swing.JInternalFrame;
import javax.swing.JLabel;
import javax.swing.JPanel;
import javax.swing.JScrollPane;
import javax.swing.JTable;
import javax.swing.JTextArea;
import javax.swing.JTextField;
import javax.swing.JViewport;
import javax.swing.table.JTableHeader;
import javax.swing.text.Document;
import javax.swing.text.Utilities;

class CHPrint
{
  PrinterJob pj;
  String header = new String();
  String footer_medida = new String();
  String footer_pag = new String();
  String footer_promotor = new String();
  boolean multipage = false;
  
  JInternalFrame frame;
  Vector pComps = new Vector();
  
  public double scale = 1.0D;
  
  int y_offset = 0;
  int n_page = 0;
  int margem_y = 0;
  
  int PY;
  int margem_x = 0;
  int n_page_c = 0;
  
  int dx_expand = 0;
  
  boolean landscape = false;
  
  Paper p;
  static PageFormat pf;
  boolean started = false;
  boolean primeira_caixa = true;
  boolean primeiro_quadro = true;
  
  public CHPrint(JInternalFrame f) {
    frame = f;
    started = false;
  }
  
  void start()
  {
    started = true;
    







    pj = PrinterJob.getPrinterJob();
    
    pf = CHPrintPage.pj.defaultPage();
    p = pf.getPaper();
    
    double margin = 25.0D;
    double x = margin;
    double y = margin;
    double dx = 2.0D * p.getImageableX() + p.getImageableWidth() - 2.0D * x;
    double dy = 2.0D * p.getImageableY() + p.getImageableHeight() - 2.0D * y;
    
    p.setImageableArea(x, y, dx, dy);
    pf.setPaper(p);
    
    pf.setOrientation(1);
  }
  
  public void margem_x(int n) {
    p.setImageableArea(p.getImageableX() + n, p.getImageableY(), p.getImageableWidth(), p.getImageableHeight());
    pf.setPaper(p);
  }
  
  public void setOrientation(int orientation) {
    pf.setOrientation(orientation);
    
    landscape = (orientation == 0);
  }
  




  public void scaleToWidth(int w)
  {
    scale = (pf.getImageableWidth() / w);
    scale = (Math.round(scale * 100.0D) / 100.0D);
  }
  

  public void print_page()
  {
    Component[] comps = frame.getContentPane().getComponents();
    









    PY = ((int)pf.getImageableY() + (int)((pf.getImageableHeight() - 2 * margem_y) / scale));
    PY = ((int)(pf.getImageableHeight() / scale));
    


    n_page_c = 0;
    

    y_offset = margem_y;
    n_page = 0;
    

    for (int i = 0; i < comps.length; i++) {
      for (int j = i + 1; j < comps.length; j++) {
        if (comps[i].getY() > comps[j].getY()) {
          Component c = comps[i];
          comps[i] = comps[j];
          comps[j] = c;
        }
      }
    }
    

    for (int i = 0; i < comps.length; i++)
    {
      Component c = comps[i];
      String s = c.getClass().getName();
      

      if ((s.endsWith("JPanel")) && (c.isVisible()))
      {
        if ((c.getName() == null) || (!c.getName().endsWith("_noprint")))
        {




          if ((c.getName() != null) && (c.getName().endsWith("_texto")))
          {
            painel_texto((JPanel)c);
          }
          else if ((c.getName() != null) && (c.getName().endsWith("_Quadro")))
          {
            painel_quadro((JPanel)c);


          }
          else
          {

            Component cpanel = Clone(c);
            if (cpanel != null) {
              pComps.addElement(cpanel);
              cpanel.setLocation(c.getX(), c.getY() + y_offset);
            }
            


            int cpanel_idx = pComps.size();
            

            Component[] icomps = ((JPanel)c).getComponents();
            int dif_dy = 0;
            for (int j = 0; j < icomps.length; j++) {
              Component ic = icomps[j];
              
              Component pc = Clone(icomps[j]);
              if (pc != null) {
                pComps.addElement(pc);
                pc.setLocation(pc.getX() + cpanel.getX(), pc.getY() + cpanel.getY());
                


                if (pc.getHeight() - icomps[j].getHeight() > dif_dy) {
                  dif_dy = pc.getHeight() - icomps[j].getHeight();
                }
              }
            }
            


            if (dif_dy > 0) {
              cpanel.setSize(cpanel.getWidth(), cpanel.getHeight() + dif_dy);
              y_offset += dif_dy;
            }
            




            int Y = cpanel.getY();
            int n_pagei = Y / PY;
            
            int n_pagef = (Y + cpanel.getHeight() + margem_y) / PY;
            



            if ((n_pagef > n_pagei) || (n_pagef > n_page_c)) {
              dif_dy = n_pagef * PY - Y + margem_y;
              
              int filipa = 0;
              

              cpanel.setLocation(cpanel.getX(), cpanel.getY() + dif_dy + filipa);
              
              y_offset += dif_dy;
              

              for (int j = cpanel_idx; j < pComps.size(); j++) {
                Component cx = (Component)pComps.elementAt(j);
                cx.setLocation(cx.getX(), cx.getY() + dif_dy + filipa);
                
                cx.repaint();
              }
            }
            n_page_c = n_pagef;
          }
          
        }
        

      }
      else if ((c.isVisible()) && (
        (c.getName() == null) || (!c.getName().endsWith("_noprint"))))
      {


        boolean b = c.isVisible();
        c.setVisible(true);
        Component cx = Clone(c);
        c.setVisible(b);
        

        cx.setLocation(cx.getX(), cx.getY() + y_offset);
        
        if ((c.getName() != null) && (c.getName().equals("logo"))) {
          cx.setLocation(cx.getX() + dx_expand, cx.getY());
        }
        pComps.addElement(cx);
      }
    }
    










    pj.setPrintable((java.awt.print.Printable)frame, pf);
    try
    {
      pj.print();
    }
    catch (PrinterException pe) {
      javax.swing.JOptionPane.showMessageDialog(null, "ERRO print...");
    }
  }
  



  Component Clone(Component orig)
  {
    if (!orig.isVisible()) { return null;
    }
    
    Component c = null;
    
    if ((orig.getClass().getName().endsWith("TextField")) || 
      (orig.getClass().getName().endsWith("JComboBox")) || 
      (orig.getClass().getName().endsWith("SteppedComboBox"))) {
      JTextField ct = new JTextField();
      ct.setLocation(orig.getX(), orig.getY());
      ct.setBorder(BorderFactory.createLineBorder(Color.black));
      ct.setBounds(orig.getBounds());
      ct.setFont(fmeComum.letra);
      if (orig.getClass().getName().endsWith("TextField")) {
        ct.setHorizontalAlignment(((JTextField)orig).getHorizontalAlignment());
        ct.setFont(((JTextField)orig).getFont());
      }
      
      if ((orig.getClass().getName().endsWith("JComboBox")) || 
        (orig.getClass().getName().endsWith("SteppedComboBox"))) {
        if (((JComboBox)orig).getSelectedIndex() >= 0) {
          ct.setText(((JComboBox)orig).getSelectedItem().toString());
        }
      } else
        ct.setText(((JTextField)orig).getText());
      c = ct;
      c.setName(orig.getName() + "-clone");
    }
    
    if ((orig.getClass().getName().endsWith("JLabel")) || 
      (orig.getClass().getName().endsWith("Label2020")) || 
      (orig.getClass().getName().endsWith("LabelTitulo"))) {
      JLabel cl = new JLabel();
      cl.setBounds(orig.getBounds());
      cl.setText(((JLabel)orig).getText());
      cl.setHorizontalTextPosition(((JLabel)orig).getHorizontalTextPosition());
      cl.setHorizontalAlignment(((JLabel)orig).getHorizontalAlignment());
      cl.setFont(orig.getFont());
      c = cl;
      
      cl.setIcon(((JLabel)orig).getIcon());
      cl.setBorder(((JLabel)orig).getBorder());
      c.setName(orig.getName() + "-clone");
    }
    
    if (orig.getClass().getName().endsWith("Panel")) {
      JPanel cp = new JPanel();
      cp.setBorder(((JPanel)orig).getBorder());
      cp.setBounds(orig.getBounds());
      
      if (dx_expand > 0) {
        cp.setSize(cp.getWidth() + dx_expand, cp.getHeight());
      }
      
      c = cp;
      c.setName(orig.getName() + "-clone");
    }
    
    if (orig.getClass().getName().endsWith("CheckBox")) {
      JCheckBox chk = new JCheckBox();
      
      chk.setBorder(((JCheckBox)orig).getBorder());
      chk.setBorderPainted(false);
      
      chk.setText(((JCheckBox)orig).getText());
      chk.setFont(((JCheckBox)orig).getFont());
      chk.setBorderPaintedFlat(true);
      chk.setBounds(orig.getBounds());
      chk.setHorizontalTextPosition(((JCheckBox)orig).getHorizontalTextPosition());
      chk.setBackground(Color.white);
      c = chk;
      c.setName(orig.getName() + "-clone");
      chk.setSelected(((JCheckBox)orig).isSelected());
      chk.setHorizontalAlignment(((JCheckBox)orig).getHorizontalAlignment());
    }
    



    if (orig.getClass().getName().endsWith("ScrollPane"))
    {


      JScrollPane sp_org = (JScrollPane)orig;
      Component[] t = sp_org.getViewport().getComponents();
      for (int i = 0; i < t.length; i++)
      {


        if ((t[i].getClass().getName().endsWith("JTable")) || 
          (t[i].getClass().getName().endsWith("JTable_Tip")) || (
          (t[i].getName() != null) && (t[i].getName().endsWith("_Tabela"))))
        {



          JPanel np = new JPanel();
          

          np.setLocation(sp_org.getLocation());
          np.setBorder(sp_org.getBorder());
          
          JTable jt_org = (JTable)t[i];
          JTable jt = new JTable(jt_org.getModel());
          


          jt.setRowHeight(jt_org.getRowHeight());
          
          CHTabela dt = (CHTabela)jt_org.getModel();
          int nrows = dt.getRowCount();
          


          jt.setSize(jt_org.getWidth(), nrows * jt_org.getRowHeight());
          jt.setFont(t[i].getFont());
          jt.setBorder(null);
          jt.setColumnModel(jt_org.getColumnModel());
          
          JTableHeader tbh = new JTableHeader(jt_org.getColumnModel());
          

          int w = getPreferredSizewidth;
          int h = jt_org.getTableHeader().getHeight();
          jt.setTableHeader(tbh);
          tbh.setSize(new Dimension(w, h));
          tbh.setTable(jt);
          
          np.setSize(jt.getWidth() - 1, jt.getHeight() + jt.getTableHeader().getHeight());
          
          np.add(jt, null);
          jt.getTableHeader().setLocation(0, 0);
          jt.setLocation(0, jt.getTableHeader().getHeight() + 1);
          if (d.ui != null) jt.getTableHeader().setUI(d.ui);
          np.add(jt.getTableHeader(), null);
          
          c = np;
          c.setName(orig.getName() + "-clone");
        }
        else if (t[i].getClass().getName().endsWith("EditorPane"))
        {



          JEditorPane jp = new JEditorPane();
          
          jp.setBounds(new java.awt.Rectangle(10, 10, 620, 660));
          
          jp.setFont(t[i].getFont());
          


          java.net.URL URL = fmeFrame.class.getResource("parecer_tecnico.html");
          
          try
          {
            jp.setPage(URL);

          }
          catch (java.io.IOException e)
          {

            System.err.println("Attempted to read a bad URL: " + URL);
          }
          


          jp.revalidate();
          
          jp.repaint();
          

          JScrollPane jsp = new JScrollPane();
          
          jsp.setBounds(new java.awt.Rectangle(10, 10, 620, 660));
          
          jsp.setViewportView(jp);
          

          jsp.repaint();
          

          return jp;
        }
      }
    }
    


    return c;
  }
  





  int print(Graphics g, PageFormat pf, int pageIndex)
  {
    int f_x = (int)pf.getImageableX();
    int f_dx = (int)pf.getImageableWidth();
    
    g.translate(margem_x, 0);
    
    int n_page = pageIndex;
    boolean has_page = false;
    



    ((Graphics2D)g).scale(scale, scale);
    








    g.translate((int)pf.getImageableX(), (int)pf.getImageableY());
    
    for (int i = 0; i < pComps.size(); i++)
    {
      Component c = (Component)pComps.elementAt(i);
      int Y = c.getY();
      








      if ((Y > n_page * PY) && (Y < (n_page + 1) * PY))
      {




        if (c.getClass().getName().endsWith("Panel"))
        {
          if (((JPanel)c).getBorder() != null) {
            g.drawRect(c.getX(), c.getY() - n_page * PY, c.getWidth(), c.getHeight());
          }
          if (f_x == 0) { f_x = c.getX();
          } else if (c.getX() < f_x) f_x = c.getX();
          if (c.getWidth() > f_dx) { f_dx = c.getWidth();
          }
          
          JPanel p = (JPanel)c;
          Component[] icomps = p.getComponents();
          for (int j = 0; j < icomps.length; j++) {
            Component pc = icomps[j];
            
            g.translate(c.getX() + pc.getX(), c.getY() + pc.getY() - n_page * PY);
            


            pc.paint(g);
            
            g.translate(-(c.getX() + pc.getX()), -(c.getY() + pc.getY() - n_page * PY));
            has_page = true;
          }
          

        }
        else
        {
          g.translate(c.getX(), Y - n_page * PY);
          c.paint(g);
          g.translate(-c.getX(), -(Y - n_page * PY));
          has_page = true;
          
          if (f_x == 0) { f_x = c.getX();
          } else if (c.getX() < f_x) f_x = c.getX();
          if (c.getWidth() > f_dx) { f_dx = c.getWidth();
          }
        }
      }
      
      if (Y > (n_page + 1) * PY) {
        multipage = true;
      }
    }
    

    if (has_page)
    {
      JLabel h = new JLabel();
      
      h.setBackground(Color.darkGray);
      h.setFont(fmeComum.letra_titulo);
      h.setForeground(Color.white);
      h.setBorder(null);
      h.setText(header);
      h.setSize(f_dx, 20);
      

      h.setLocation(f_x, 17);
      h.setOpaque(true);
      
      g.translate(h.getX(), h.getY());
      h.paint(g);
      
      g.translate(-h.getX(), -h.getY());
      
      h.setText(footer_medida);
      

      h.setLocation(f_x, PY - 24);
      h.setSize(h.getWidth() - 80, h.getHeight() - 4);
      
      g.translate(h.getX(), h.getY());
      h.paint(g);
      g.translate(-h.getX(), -h.getY());
      
      h.setText(footer_pag);
      if (multipage) { h.setText(footer_pag + "/" + (pageIndex + 1));
      }
      h.setLocation(h.getX() + h.getWidth() - 20, PY - 24);
      h.setSize(101, h.getHeight());
      h.setHorizontalTextPosition(4);
      g.translate(h.getX(), h.getY());
      h.paint(g);
      g.translate(-h.getX(), -h.getY());
      

      h.setBackground(Color.white);
      h.setFont(fmeComum.letra_pequena);
      h.setForeground(Color.black);
      h.setText("Promotor: " + footer_promotor);
      h.setSize(f_dx, 15);
      
      h.setLocation(f_x, PY - 8);
      g.translate(h.getX(), h.getY());
      h.paint(g);
      g.translate(-h.getX(), -h.getY());
    }
    

    if (has_page) return 0;
    return 1;
  }
  



  public static String getWrappedText(JTextArea c)
  {
    int len = c.getDocument().getLength();
    int offset = 0;
    

    StringBuffer buf = new StringBuffer((int)(len * 1.1D));
    try
    {
      while (offset < len) {
        int end = Utilities.getRowEnd(c, offset);
        if (end < 0) {
          break;
        }
        

        end = Math.min(end + 1, len);
        
        String s = c.getDocument().getText(offset, end - offset);
        buf.append(s);
        

        if (!s.endsWith("\n")) {
          buf.append('\n');
        }
        offset = end;
      }
    } catch (Exception localException) {}
    return buf.toString();
  }
  
  public static int getWrappedText_nlines(JTextArea c) {
    int len = c.getDocument().getLength();
    int offset = 0;
    int nlines = 0;
    

    StringBuffer buf = new StringBuffer((int)(len * 1.1D));
    try
    {
      while (offset < len) {
        int end = Utilities.getRowEnd(c, offset);
        if (end < 0) {
          break;
        }
        

        end = Math.min(end + 1, len);
        
        String s = c.getDocument().getText(offset, end - offset);
        buf.append(s);
        

        if (!s.endsWith("\n")) {
          buf.append('\n');
        }
        offset = end;
        nlines++;
      }
    } catch (Exception localException) {}
    return nlines;
  }
  
  public static String getWrappedText_getnlines(JTextArea c, int n)
  {
    int len = c.getDocument().getLength();
    int offset = 0;
    int nlines = 0;
    

    StringBuffer buf = new StringBuffer((int)(len * 1.1D));
    try
    {
      while (offset < len) {
        int end = Utilities.getRowEnd(c, offset);
        if (end < 0) {
          break;
        }
        
        end = Math.min(end + 1, len);
        
        String s = c.getDocument().getText(offset, end - offset);
        buf.append(s);
        

        if (!s.endsWith("\n")) {
          buf.append('\n');
        }
        offset = end;
        nlines++;
        if (nlines >= n) break;
      }
    } catch (Exception localException) {}
    return buf.toString();
  }
  
  public static String getWrappedText_getnlines(JTextArea c, int start, int n) {
    int len = c.getDocument().getLength();
    int offset = 0;
    int nlines = 0;
    

    StringBuffer buf = new StringBuffer((int)(len * 1.1D));
    try
    {
      while (offset < len) {
        int end = Utilities.getRowEnd(c, offset);
        if (end < 0) {
          break;
        }
        
        end = Math.min(end + 1, len);
        
        String s = c.getDocument().getText(offset, end - offset);
        
        if (nlines >= start) {
          buf.append(s);
        }
        
        if ((!s.endsWith("\n")) && 
          (nlines >= start)) {
          buf.append('\n');
        }
        offset = end;
        nlines++;
        if (nlines >= start + n)
          break;
      }
    } catch (Exception localException) {}
    return buf.toString();
  }
  




  void painel_texto(JPanel painel)
  {
    boolean skip_page = false;
    

    JScrollPane sp_texto = null;
    JTextArea txt_area = null;
    
    Component[] t = painel.getComponents();
    for (int i = 0; i < t.length; i++) {
      if (t[i].getClass().getName().endsWith("ScrollPane")) {
        sp_texto = (JScrollPane)t[i];
      }
    }
    
    t = sp_texto.getViewport().getComponents();
    for (int ix = 0; ix < t.length; ix++) {
      if (t[ix].getClass().getName().endsWith("TextArea")) {
        txt_area = (JTextArea)t[ix];
        





        int i_top_margin = sp_texto.getY();
        int i_bottom_margin = painel.getHeight() - i_top_margin - sp_texto.getHeight();
        
        int txt_nlines = getWrappedText_nlines(txt_area);
        
        int txt_nlines_printed = 0;
        




        do
        {
          int dmax;
          



          if (txt_nlines_printed == 0) {
            int dmax = PY - (painel.getY() + y_offset) % PY - i_top_margin - i_bottom_margin - margem_y;
            


            if (dmax < sp_texto.getHeight())
            {



              if (primeira_caixa) {
                dmax = PY - painel.getY() - i_top_margin - i_bottom_margin - 2 * margem_y;
              } else {
                dmax = PY - i_top_margin - i_bottom_margin - 2 * margem_y;
                skip_page = true;
              }
            }
          }
          else
          {
            dmax = PY - i_top_margin - i_bottom_margin - 2 * margem_y;
            skip_page = true;
          }
          int need;
          int need;
          if (txt_nlines == 0) need = txt_area.getHeight(); else
            need = (int)(txt_area.getHeight() * (
              1.0D - txt_nlines_printed / txt_nlines)) + 1;
          int jt_height = need < dmax ? need : dmax;
          


          JTextArea jt = new JTextArea();
          jt.setFont(txt_area.getFont());
          
          jt.setSize(sp_texto.getWidth(), jt_height + 5);
          if (dx_expand > 0)
            jt.setSize(jt.getWidth() + dx_expand, jt.getHeight());
          jt.setLocation(sp_texto.getLocation());
          jt.setBorder(painel.getBorder());
          
          int nprintlines = (int)(jt_height / txt_area.getHeight() * 
            txt_nlines);
          jt.setText(txt_area.getText());
          
          String txt = getWrappedText_getnlines(txt_area, txt_nlines_printed, 
            nprintlines);
          
          jt.setText(txt);
          

          JPanel np = new JPanel();
          np.setBorder(painel.getBorder());
          np.setSize(painel.getSize());
          np.setSize(np.getWidth() + dx_expand, 
            np.getHeight() + jt.getHeight() - sp_texto.getHeight());
          
          np.add(jt, null);
          

          t = painel.getComponents();
          for (int i = 0; i < t.length; i++) {
            if (!t[i].getClass().getName().endsWith("ScrollPane")) {
              Component c = Clone(t[i]);
              
              np.add(c, null);
            }
          }
          
          pComps.addElement(np);
          


          if (!skip_page)
          {
            np.setLocation(painel.getLocation());
            np.setLocation(np.getX(), np.getY() + y_offset);
            




            y_offset = (y_offset + jt.getHeight() - sp_texto.getHeight());


          }
          else
          {

            int dif_y = PY - (painel.getY() + y_offset) + margem_y;
            

            dif_y = PY - (painel.getY() + y_offset) % PY + margem_y;
            

            np.setLocation(painel.getX(), painel.getY() + y_offset + dif_y);
            






            y_offset += 2 * margem_y + np.getHeight();
          }
          





          txt_nlines_printed += nprintlines;
          primeira_caixa = false;
        } while (
        





























































































































          txt_nlines_printed < txt_nlines);
      }
    }
  }
  











  void painel_quadro(JPanel painel)
  {
    JScrollPane sp_tabela = null;
    JTable jt_org = null;
    
    Component[] t = painel.getComponents();
    for (int i = 0; i < t.length; i++)
    {
      if ((t[i].getName() != null) && (t[i].getName().endsWith("_ScrollPane"))) {
        sp_tabela = (JScrollPane)t[i];
      }
    }
    
    t = sp_tabela.getViewport().getComponents();
    for (int i = 0; i < t.length; i++)
    {
      if ((t[i].getName() != null) && (t[i].getName().endsWith("_Tabela"))) {
        jt_org = (JTable)t[i];
      }
    }
    
    int nrows = jt_org.getModel().getRowCount();
    


    int px = jt_org.getWidth() + 2 * sp_tabela.getX();
    


    px = painel.getWidth();
    
    px += dx_expand;
    








    int nprinted_rows = 0;
    int npage = 0;
    
    do
    {
      int py;
      
      if (primeiro_quadro) { int py;
        if (nprinted_rows == 0) {
          py = PY - (painel.getY() + 2 * margem_y) - sp_tabela.getY();
        } else {
          py = PY - 2 * margem_y - sp_tabela.getY();
        }
      }
      else if (nprinted_rows == 0) {
        int disponivel = PY - (painel.getY() + y_offset) % PY - margem_y;
        int py; if (disponivel < painel.getHeight())
        {

          y_offset += disponivel + 2 * margem_y;
          py = PY - 2 * margem_y - sp_tabela.getY();
        }
        else
        {
          int py = PY - 2 * margem_y - painel.getY() - sp_tabela.getY();
          
          int inicio_disponivel = (painel.getY() + y_offset) % PY;
          
          if (inicio_disponivel < painel.getY()) {
            y_offset += painel.getY() - inicio_disponivel;
          }
        }
      }
      else
      {
        py = PY - 2 * margem_y - sp_tabela.getY();
      }
      
      int nprows = (int)((py - jt_org.getTableHeader().getHeight()) / 
        jt_org.getRowHeight() - 1.0D);
      int npprows = nprows;
      




      CHTabela dt = (CHTabela)jt_org.getModel();
      CHTabelaPrint dtp = new CHTabelaPrint(dt);
      
      if (nrows - nprinted_rows < nprows) {
        nprows = nrows - nprinted_rows;
      }
      
      print_rows = nprows;
      row_offset = nprinted_rows;
      



      JPanel np = new JPanel();
      np.setBorder(painel.getBorder());
      
      np.setLocation(painel.getX(), painel.getY() + y_offset);
      np.setSize(px, py);
      


















      JTable jt = new JTable(dtp);
      jt.setRowHeight(jt_org.getRowHeight());
      jt.setSize(jt_org.getWidth(), nprows * jt_org.getRowHeight());
      


      JTableHeader tbh = new JTableHeader(jt_org.getColumnModel());
      
      int w = getPreferredSizewidth;
      int h = jt_org.getTableHeader().getHeight();
      
      tbh.setSize(new Dimension(w, h));
      


      jt.setTableHeader(tbh);
      
      if (d.ui != null) { tbh.setUI(d.ui);
      }
      tbh.setSize(jt_org.getTableHeader().getSize());
      tbh.setTable(jt);
      
      jt.setBorder(null);
      jt.setColumnModel(jt_org.getColumnModel());
      
      jt.setTableHeader(tbh);
      jt.setBorder(BorderFactory.createLineBorder(Color.gray));
      jt.getTableHeader().setBorder(BorderFactory.createLineBorder(Color.gray));
      





      int y_interiores = 0;
      t = painel.getComponents();
      for (int i = 0; i < t.length; i++) {
        if ((t[i].getClass().getName().endsWith("Label")) || (t[i].getClass().getName().endsWith("TextField"))) {
          Component c = Clone(t[i]);
          if (c != null) {
            np.add(c, null);
          }
        }
      }
      
      int j_dx = (np.getWidth() - jt.getWidth()) / 2;
      

      jt.setLocation(j_dx, sp_tabela.getY() + jt.getTableHeader().getHeight());
      jt.getTableHeader().setLocation(j_dx, sp_tabela.getY());
      np.add(jt, null);
      

      int py = painel.getHeight();
      py += jt.getHeight() + jt.getTableHeader().getHeight() - sp_tabela.getHeight();
      np.setSize(px, py);
      




      np.add(tbh, null);
      

      np.repaint();
      pComps.addElement(np);
      
      nprinted_rows += nprows;
      
      if (nprinted_rows < nrows) {
        if ((npage == 0) && (primeiro_quadro)) {
          y_offset += PY - painel.getY();
        } else {
          y_offset += PY;
        }
      }
      else if (npage == 0) {
        y_offset += np.getHeight() - painel.getHeight();
      }
      else {
        y_offset += np.getHeight() - painel.getHeight();
      }
      
      npage++;
      n_page_c += 1;
    } while (
    

































































































































































      nprinted_rows < nrows);
    




    primeiro_quadro = false;
  }
  
  static void show()
  {
    Dialog_Print d = new Dialog_Print();
  }
}
