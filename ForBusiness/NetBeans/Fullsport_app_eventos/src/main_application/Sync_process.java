/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package main_application;

import flexjson.JSONDeserializer;
import flexjson.JSONSerializer;
import java.io.IOException;
import java.text.DateFormat;
import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Date;
import java.util.Timer;
import java.util.TimerTask;
import javax.swing.JOptionPane;

/**
 *
 * @author Tiago Loureiro
 */
public class Sync_process {
    
    private Site site = null;
    
    public void setOutput(String message) {
        Fullsport_app_eventos.Fullsport_app_eventosView.jTextArea1.setText(Fullsport_app_eventos.Fullsport_app_eventosView.jTextArea1.getText() + message + "\n");
        Fullsport_app_eventos.Fullsport_app_eventosView.jTextArea1.setCaretPosition(Fullsport_app_eventos.Fullsport_app_eventosView.jTextArea1.getDocument().getLength());
    }
    
}
