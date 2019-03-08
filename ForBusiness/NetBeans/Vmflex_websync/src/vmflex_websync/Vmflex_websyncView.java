/*
 * Vmflex_websyncView.java
 */

package vmflex_websync;

import java.awt.Dimension;
import main_application.*;
import org.jdesktop.application.Action;
import org.jdesktop.application.ResourceMap;
import org.jdesktop.application.SingleFrameApplication;
import org.jdesktop.application.FrameView;
import org.jdesktop.application.TaskMonitor;
import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;
import java.io.IOException;
import java.io.ObjectInputStream;
import java.io.ObjectOutputStream;
import java.net.InetAddress;
import java.net.Socket;
import java.net.UnknownHostException;
import java.util.Iterator;
import java.util.logging.Level;
import java.util.logging.Logger;
import javax.swing.Timer;
import javax.swing.Icon;
import javax.swing.JDialog;
import javax.swing.JFrame;

public class Vmflex_websyncView extends FrameView {

    public static int application_state = 0;

    public Vmflex_websyncView(SingleFrameApplication app) {
        super(app);
        initComponents();
    }

    @Action
    public void showSincBox() {
        if (sincBox == null) {
            JFrame mainFrame = Vmflex_websyncApp.getApplication().getMainFrame();
            sincBox = new Vmflex_websyncSincBox(mainFrame);
            sincBox.setLocationRelativeTo(mainFrame);
        }
        Vmflex_websyncApp.getApplication().show(sincBox);
    }
    
    @Action
    public void showAboutBox() {
        if (aboutBox == null) {
            JFrame mainFrame = Vmflex_websyncApp.getApplication().getMainFrame();
            aboutBox = new Vmflex_websyncAboutBox(mainFrame);
            aboutBox.setLocationRelativeTo(mainFrame);
        }
        Vmflex_websyncApp.getApplication().show(aboutBox);
    }

    @SuppressWarnings("unchecked")

    private void initComponents() {

        ImagePanel mainPanel = new ImagePanel( "bg.png" );
        jButton1 = new javax.swing.JButton();
        jLabel1 = new javax.swing.JLabel();
        jLabel2 = new javax.swing.JLabel();
        jScrollPane1 = new javax.swing.JScrollPane();
        jTextArea1 = new javax.swing.JTextArea();
        menuBar = new javax.swing.JMenuBar();
        javax.swing.JMenu fileMenu = new javax.swing.JMenu();
        javax.swing.JMenuItem exitMenuItem = new javax.swing.JMenuItem();
        javax.swing.JMenu helpMenu = new javax.swing.JMenu();
        javax.swing.JMenuItem aboutMenuItem = new javax.swing.JMenuItem();
        javax.swing.JMenuItem selectsinc = new javax.swing.JMenuItem();

        mainPanel.setName("mainPanel"); // NOI18N
	mainPanel.setPreferredSize( new Dimension( 640, 316 ) );

        org.jdesktop.application.ResourceMap resourceMap = org.jdesktop.application.Application.getInstance(vmflex_websync.Vmflex_websyncApp.class).getContext().getResourceMap(Vmflex_websyncView.class);
        jButton1.setText(resourceMap.getString("jButton1.text")); // NOI18N
        jButton1.setName("jButton1"); // NOI18N
        jButton1.addMouseListener(new java.awt.event.MouseAdapter() {
            public void mouseClicked(java.awt.event.MouseEvent evt) {
                jButton1MouseClicked(evt);
            }
        });

        jLabel1.setText(resourceMap.getString("jLabel1.text")); // NOI18N
        jLabel1.setName("jLabel1"); // NOI18N

        jLabel2.setText(resourceMap.getString("jLabel2.text")); // NOI18N
        jLabel2.setName("jLabel2"); // NOI18N

        jScrollPane1.setName("jScrollPane1"); // NOI18N

        jTextArea1.setColumns(20);
        jTextArea1.setRows(5);
        jTextArea1.setEnabled(false);
        jTextArea1.setName("jTextArea1"); // NOI18N
        jScrollPane1.setViewportView(jTextArea1);
		
        javax.swing.GroupLayout mainPanelLayout = new javax.swing.GroupLayout(mainPanel);
        mainPanel.setLayout(mainPanelLayout);
		
        mainPanelLayout.setHorizontalGroup(
            mainPanelLayout.createParallelGroup(javax.swing.GroupLayout.Alignment.TRAILING)
            .addGroup(javax.swing.GroupLayout.Alignment.LEADING, mainPanelLayout.createSequentialGroup()
                .addContainerGap()
                .addGroup(mainPanelLayout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
                    .addComponent(jScrollPane1)
                    .addGroup(mainPanelLayout.createSequentialGroup()
                        .addComponent(jLabel1, javax.swing.GroupLayout.PREFERRED_SIZE, 53, javax.swing.GroupLayout.PREFERRED_SIZE)
                        .addPreferredGap(javax.swing.LayoutStyle.ComponentPlacement.RELATED)
                        .addComponent(jLabel2, javax.swing.GroupLayout.PREFERRED_SIZE, 121, javax.swing.GroupLayout.PREFERRED_SIZE)
                        .addPreferredGap(javax.swing.LayoutStyle.ComponentPlacement.RELATED)
                        .addComponent(jButton1, javax.swing.GroupLayout.PREFERRED_SIZE, 103, javax.swing.GroupLayout.PREFERRED_SIZE)
                        .addGap(0, 333, Short.MAX_VALUE)))
                .addContainerGap())
        );
        mainPanelLayout.setVerticalGroup(
            mainPanelLayout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
            .addGroup(mainPanelLayout.createSequentialGroup()
                .addContainerGap()
                .addGroup(mainPanelLayout.createParallelGroup(javax.swing.GroupLayout.Alignment.BASELINE)
                    .addComponent(jButton1, javax.swing.GroupLayout.PREFERRED_SIZE, 39, javax.swing.GroupLayout.PREFERRED_SIZE)
                    .addComponent(jLabel2)
                    .addComponent(jLabel1))
                .addGap(18, 18, 18)
                .addComponent(jScrollPane1, javax.swing.GroupLayout.PREFERRED_SIZE, 237, javax.swing.GroupLayout.PREFERRED_SIZE)
                .addContainerGap())
        );

        menuBar.setName("menuBar"); // NOI18N

        fileMenu.setText(resourceMap.getString("fileMenu.text")); // NOI18N
        fileMenu.setName("fileMenu"); // NOI18N

        javax.swing.ActionMap actionMap = org.jdesktop.application.Application.getInstance(vmflex_websync.Vmflex_websyncApp.class).getContext().getActionMap(Vmflex_websyncView.class, this);
        
        selectsinc.setAction(actionMap.get("showSincBox")); // NOI18N
        selectsinc.setText(resourceMap.getString("selMenuItem.text")); // NOI18N
        selectsinc.setToolTipText(resourceMap.getString("selMenuItem.toolTipText")); // NOI18N
        selectsinc.setName("selMenuItem"); // NOI18N
        fileMenu.add(selectsinc);
        
        exitMenuItem.setAction(actionMap.get("quit")); // NOI18N
        exitMenuItem.setText(resourceMap.getString("exitMenuItem.text")); // NOI18N
        exitMenuItem.setToolTipText(resourceMap.getString("exitMenuItem.toolTipText")); // NOI18N
        exitMenuItem.setName("exitMenuItem"); // NOI18N
        fileMenu.add(exitMenuItem);
        
        menuBar.add(fileMenu);

        helpMenu.setText(resourceMap.getString("helpMenu.text")); // NOI18N
        helpMenu.setName("helpMenu"); // NOI18N

        aboutMenuItem.setAction(actionMap.get("showAboutBox")); // NOI18N
        aboutMenuItem.setText(resourceMap.getString("aboutMenuItem.text")); // NOI18N
        aboutMenuItem.setName("aboutMenuItem"); // NOI18N
        helpMenu.add(aboutMenuItem);

        menuBar.add(helpMenu);

        setComponent(mainPanel);		
        setMenuBar(menuBar);
    }
    
    // Variables declaration - do not modify//GEN-BEGIN:variables
    private javax.swing.JButton jButton1;
    private javax.swing.JLabel jLabel1;
    public static javax.swing.JLabel jLabel2;
    private javax.swing.JScrollPane jScrollPane1;
    public static javax.swing.JTextArea jTextArea1;
    private javax.swing.JPanel mainPanel;
    private javax.swing.JMenuBar menuBar;
    // End of variables declaration//GEN-END:variables

    private JDialog aboutBox;
    private JDialog sincBox;
    RunnableThread update_process = null;
    
    private void jButton1MouseClicked(java.awt.event.MouseEvent evt) {//GEN-FIRST:event_jButton1MouseClicked

        if (application_state == 0) {
            jLabel2.setText("A Iniciar...");
            setOutput("A iniciar aplicação..");
            
            update_process = new RunnableThread();
            update_process.resume();
            
            application_state = 1;
            setOutput("Aplicação iniciada..");
            jButton1.setText("Desligar");
        }
        else {
            try {
                update_process.stop();
                jLabel2.setText("A Desconectar...");
                application_state = 0;
                jLabel2.setText("Desconectado...");
                setOutput("Aplicação terminada..");
                jButton1.setText("Ligar");
            } catch (UnknownHostException ex) {
                Logger.getLogger(Vmflex_websyncView.class.getName()).log(Level.SEVERE, null, ex);
            } catch (IOException ex) {
                Logger.getLogger(Vmflex_websyncView.class.getName()).log(Level.SEVERE, null, ex);
            }
        }
    }//GEN-LAST:event_jButton1MouseClicked

    public void setOutput(String message) {
        jTextArea1.setText(jTextArea1.getText() + message + "\n");
        jTextArea1.setCaretPosition(jTextArea1.getDocument().getLength());
    }
}
