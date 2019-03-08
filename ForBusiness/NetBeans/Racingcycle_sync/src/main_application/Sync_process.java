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
        racingcycle_sync.PHC_websyncView.jTextArea1.setText(racingcycle_sync.PHC_websyncView.jTextArea1.getText() + message + "\n");
        racingcycle_sync.PHC_websyncView.jTextArea1.setCaretPosition(racingcycle_sync.PHC_websyncView.jTextArea1.getDocument().getLength());
    }
    
}
