/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package main_application;

import java.io.UnsupportedEncodingException;
import java.util.Properties;
import javax.mail.Message;
import javax.mail.MessagingException;
import javax.mail.Session;
import javax.mail.Transport;
import javax.mail.internet.InternetAddress;
import javax.mail.internet.MimeMessage;

/**
 *
 * @author tml
 */
public class Email {
    
    String to;
    String from;
    String host;
    String user;
    String password;
    String subject;
    String html;
    
    Email(String to, String from, String host, String user, String password, String subject, String html ) throws UnsupportedEncodingException 
    {
        this.to = to;
        this.from = from;
        this.host = host;
        this.user = user;
        this.password = password;
        this.subject = subject;
        this.html = html;
    }
    
    Boolean send() throws UnsupportedEncodingException {
        Properties properties = System.getProperties();
        properties.setProperty("mail.smtp.host", this.host);
        properties.setProperty("mail.user", this.user);
        properties.setProperty("mail.password", this.password);
        Session session = Session.getDefaultInstance(properties);

        try{
            MimeMessage message = new MimeMessage(session);
            message.setFrom(new InternetAddress(this.from));
            message.addRecipient(Message.RecipientType.TO, new InternetAddress(to));
            
            String encodedSubject = new String (this.subject.getBytes("UTF-8"),"UTF-8");
            
            message.setSubject( encodedSubject, "utf-8" );
            message.setContent( html , "text/html; charset=utf-8" );

            // Send message
            Transport.send(message);
                return true;
            }
            catch (MessagingException mex) {
                mex.printStackTrace();
                return false;
            }
    }
}
