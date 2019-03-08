package fme;

import java.awt.Color;
import java.awt.Container;
import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;
import java.util.Vector;
import javax.swing.JInternalFrame;
import javax.swing.JMenuItem;
import javax.swing.JPopupMenu;
import javax.swing.plaf.basic.BasicInternalFrameUI;

























































































































































































































class PgHandler
{
  PgHandler() {}
  
  Vector Paginas = new Vector();
  fmePagina pg = null;
  int npg = 0;
  

  int size() { return Paginas.size(); }
  
  void clear() {
    Paginas.clear();
    fmePagina pg = null;
    npg = 0;
  }
  
  void delete(String tag)
  {
    for (int i = 0; i < Paginas.size(); i++) {
      fmePagina f = (fmePagina)Paginas.elementAt(i);
      if (tag.equals(tag)) break;
    }
    Paginas.removeElementAt(i);
  }
  
  void add(JInternalFrame frame, String tag, String caption) {
    fmePagina p = new fmePagina();
    caption = caption;
    tag = tag;
    frame = frame;
    

    ((BasicInternalFrameUI)frame.getUI()).setNorthPane(null);
    

    frame.setVisible(true);
    
    Paginas.addElement(p);
  }
  

  void add_after(String i_tag, JInternalFrame frame, String tag, String caption)
  {
    for (int i = 0; i < Paginas.size(); i++) {
      fmePagina f = (fmePagina)Paginas.elementAt(i);
      if (tag.equals(i_tag)) break;
    }
    fmePagina p = new fmePagina();
    caption = caption;
    tag = tag;
    frame = frame;
    

    ((BasicInternalFrameUI)frame.getUI()).setNorthPane(null);
    

    frame.setVisible(true);
    


    Paginas.insertElementAt(p, i + 1);
  }
  




  void make_menu(JPopupMenu pg)
  {
    pg.removeAll();
    

    int n = Paginas.size();
    JMenuItem item = new JMenuItem();
    int i = 0;
    int x = i;
    int z = 0;
    for (i = 0; i < n; i++)
    {
      fmePagina f = (fmePagina)Paginas.elementAt(i);
      final String tag = tag;
      item = new JMenuItem();
      menuItem = item;
      
      if (tag.endsWith("_N")) {
        z++;
      } else {
        x++;
        z = 0;
      }
      

      item.setText(caption);
      item.setActionCommand(tag);
      item.addActionListener(new ActionListener()
      {
        public void actionPerformed(ActionEvent e) {
          fmeApp.comum.pagina(tag);


        }
        


      });
      pg.add(item);
    }
  }
  
  void SelectTag(String tag) {
    for (int i = 0; i < Paginas.size(); i++) {
      fmePagina f = (fmePagina)Paginas.elementAt(i);
      if (tag.equals(tag)) {
        Select(i);
        return;
      }
    }
  }
  
  JInternalFrame getPage(String tag) {
    for (int i = 0; i < Paginas.size(); i++) {
      fmePagina f = (fmePagina)Paginas.elementAt(i);
      if (tag.equals(tag))
        return frame;
    }
    return null;
  }
  
  JInternalFrame getPage(int n) { fmePagina f = (fmePagina)Paginas.elementAt(n);
    return frame;
  }
  
  void GoTo(String tag)
  {
    String s = pg.frame.getParent().getParent().getParent().getParent().getParent().getParent().getClass().getName();
    
    Object f = pg.frame.getParent().getParent().getParent().getParent().getParent().getParent();
    
    if (((fmeApp.ambiente.equals("frame")) && ((f instanceof fmeFrame))) || ((fmeApp.ambiente.equals("applet")) && ((f instanceof fmeApplet))))
    {

      fmeApp.comum.select_page(tag);
    }
  }
  

  void Select(int n)
  {
    pg = ((fmePagina)Paginas.elementAt(n));
    npg = n;
    
    for (int i = 0; i < Paginas.size(); i++) {
      fmePagina f = (fmePagina)Paginas.elementAt(i);
      menuItem.setEnabled(i != npg);
    }
  }
  
  void SelectNext() {
    if (npg < Paginas.size() - 1) Select(npg + 1);
  }
  
  void SelectPrevious() {
    if (npg > 0) Select(npg - 1);
  }
  
  void SelectFirst() {
    Select(0);
  }
  
  void SelectLast() {
    Select(Paginas.size() - 1);
  }
  
  JInternalFrame getFrame() {
    pg.frame.setBackground(Color.WHITE);
    
    return pg.frame;
  }
  
  String getCaption() {
    return pg.caption;
  }
  
  String getTag() {
    return pg.tag;
  }
  
  String getNPagina(String tag) {
    for (int i = 0; i < Paginas.size(); i++) {
      fmePagina f = (fmePagina)Paginas.elementAt(i);
      if (tag.equals(tag))
        return n_pag;
    }
    return "";
  }
  
  String getCaption(String tag) {
    for (int i = 0; i < Paginas.size(); i++) {
      fmePagina f = (fmePagina)Paginas.elementAt(i);
      if (tag.equals(tag))
        return caption;
    }
    return "";
  }
  

  String getCaption(int n)
  {
    fmePagina f = (fmePagina)Paginas.elementAt(n);
    return caption;
  }
  
  String getTag(int n) {
    fmePagina f = (fmePagina)Paginas.elementAt(n);
    return tag;
  }
  
  boolean isFirst() {
    return npg == 0;
  }
  
  boolean isLast() {
    return npg == Paginas.size() - 1;
  }
}
