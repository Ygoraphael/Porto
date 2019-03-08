/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package ncdataonlineservice;

import java.io.BufferedReader;
import java.io.File;
import java.io.IOException;
import java.io.InputStreamReader;
import java.net.URLEncoder;
import java.security.KeyManagementException;
import java.security.KeyStoreException;
import java.security.NoSuchAlgorithmException;
import java.security.cert.CertificateException;
import java.security.cert.X509Certificate;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.util.ArrayList;
import java.util.HashMap;
import java.util.Iterator;
import java.util.LinkedHashMap;
import java.util.List;
import java.util.Map;
import java.util.Timer;
import java.util.TimerTask;
import java.util.logging.Level;
import java.util.logging.Logger;
import javax.net.ssl.HostnameVerifier;
import javax.net.ssl.SSLContext;
import org.apache.http.HttpResponse;
import org.apache.http.NameValuePair;
import org.apache.http.client.HttpClient;
import org.apache.http.client.entity.UrlEncodedFormEntity;
import org.apache.http.client.methods.HttpPost;
import org.apache.http.config.Registry;
import org.apache.http.config.RegistryBuilder;
import org.apache.http.conn.socket.ConnectionSocketFactory;
import org.apache.http.conn.socket.PlainConnectionSocketFactory;
import org.apache.http.conn.ssl.SSLConnectionSocketFactory;
import org.apache.http.impl.client.HttpClientBuilder;
import org.apache.http.impl.conn.PoolingHttpClientConnectionManager;
import org.apache.http.message.BasicNameValuePair;
import org.apache.http.ssl.SSLContextBuilder;
import org.apache.http.ssl.TrustStrategy;
import org.codehaus.jackson.map.ObjectMapper;
import org.codehaus.jackson.type.TypeReference;

/**
 *
 * @author tml
 */
public class Sincronizador extends Thread{
    
    static ConfigData config;
    static String configName;
    static String configFileName;
    static String configLogName;
    static Map tmp;
    static Settings settings;
    static Sincronizador first;
    static HashMap<String, Timer> timers;
    
    Sincronizador() {
        try {
            config = new ConfigData();
            configName = "";
            configFileName = "";
            configLogName = "";
            tmp = new HashMap<String,String>();
            settings = new Settings(tmp, "settings", true, "78x3s65a6de9d241", "d2c7cb7s5a74a48c");
            timers = new HashMap<String,Timer>();
        } catch (IOException ex) {
            Logger.getLogger(Sincronizador.class.getName()).log(Level.SEVERE, null, ex);
        }
    }

    public void run(){
        try {
            this.configLogName = Util.GetDirectoryPath() + Util.CleanString(this.configName) + ".log";
            this.configFileName = Util.GetDirectoryPath() + Util.CleanString(this.configName) + ".config";
            
            Log.Write("Windows Service do Sincronizador de Dados para NCDataOnline a arrancar", this.configLogName);
            this.UpdateConfig();
            this.StartTimers();
        } catch (IOException ex) {
            Logger.getLogger(Sincronizador.class.getName()).log(Level.SEVERE, null, ex);
        }
    }
    
    public void RunQuery(String name) 
    {
        System.out.println(name);
        try
        {
            this.UpdateConfig();
            
            if (this.config.query.get(name).get("activoQuery").equals("True"))
            {
                if (this.config.query.get(name).get("conexao").equals("") || !this.config.conexao.containsKey(this.config.query.get(name).get("conexao")))
                {
                    System.out.println("RunQuery necessita uma conexão: " + this.config.query.get("conexao") + " não é uma conexão válida.");
                    throw new IllegalStateException("RunQuery necessita uma conexão: " + this.config.query.get("conexao") + " não é uma conexão válida.");
                }
                this.DoQuery(name);
            }
        }
        catch (Exception ex2) {
            this.ExceptionMessage(ex2);
            if (!this.config.geral.get("debug").equals("True")) {
                this.timers.get("query_"+name).cancel();
            }
        }
    }
    
    private void ExceptionMessage(Exception ex)  {
        try {
            Log.Write("Ocorreu uma excepção:" + System.getProperty("line.separator") + System.getProperty("line.separator") + System.getProperty("line.separator") + ex.getMessage(), this.configLogName);
        } catch (IOException ex1) {
            Logger.getLogger(Sincronizador.class.getName()).log(Level.SEVERE, null, ex1);
        }
    }
    
    public void ReadDataFile(String file, HashMap<String, String> dados)  {
        String text = "";
        File f = new File(file);
        
        if (f.exists()) {
            try {
                text = Util.ReadAllText(file);
            } catch (IOException ex) {
                Logger.getLogger(Sincronizador.class.getName()).log(Level.SEVERE, null, ex);
            }
        }
        if (!text.equals("")) {
            try {
                TypeReference<HashMap<String,Object>> typeRef = new TypeReference<HashMap<String,Object>>() {};
                dados = new ObjectMapper().readValue(text, typeRef);
            } catch (IOException ex) {
                Logger.getLogger(Sincronizador.class.getName()).log(Level.SEVERE, null, ex);
            }
        }
    }
    
    public void DoQuery(String name)  { 
        String text = this.config.query.get(name).get("conexao");
        ResultSet rs = null;
        String connectionString = "";
        try {
            if (this.config.conexao.get(text).get("tipo_basedados").equals("SQLite")) {
                connectionString = SQL.MakeSQLiteConnectionString(this.config.conexao.get(text).get("bd"));
                rs = SQL.ExecutarSQL("SQLite", connectionString, this.config.query.get(name).get("sql"));
            }
            else if (this.config.conexao.get(text).get("tipo_basedados").equals("MSSQL")) {
                connectionString = SQL.MakeMSSQLConnectionString(this.config.conexao.get(text).get("server"), this.config.conexao.get(text).get("bd"), this.config.conexao.get(text).get("user"), this.config.conexao.get(text).get("password"));
                rs = SQL.ExecutarSQL("MSSQL", connectionString, this.config.query.get(name).get("sql"));
            }

            ArrayList<ArrayList<String>> al = Util.RS2AL(rs);

            int rowcount = al.size();
            int colcount = al.get(0).size();
            
            if( rowcount>0 ) {
                HashMap dictionary = new HashMap<String, Object>();

                String text2 = this.config.query.get(name).get("etiqueta");
                Integer num = 50;
                Integer num2 = 10;
                ArrayList<HashMap<String, Object>> list = new ArrayList<HashMap<String, Object>>();
                Integer num3 = 1;

                //cabecalhos
                ArrayList<String> list2 = new ArrayList<String>();
                while ( num3 <= colcount && num3 <= num2) {
                    String text3 = this.config.query.get(name).get( "val" + num3.toString() );
                    if (text3.equals(""))
                    {
                        break;
                    }
                    list2.add(text3);
                    num3++;
                }

                //linhas
                int num4 = 0;
                Iterator it = al.iterator();
                while (it.hasNext() && colcount > 0 && num4 < num) {
                    LinkedHashMap<String, Object> dictionary2 = new LinkedHashMap<String, Object>();
                    ArrayList cur_al = (ArrayList)it.next();

                    for (String temp : list2) {
                        dictionary2.put(temp, cur_al.get(list2.indexOf(temp)));
                    }
                    
                    //System.out.println(new PrettyPrintingMap<String, Object>(dictionary2));
                    
                    list.add(dictionary2);
                    num4++;

                    it.remove();
                }

                if (!dictionary.containsKey(text2))
                {
                    dictionary.put(text2, null);
                }
                
                dictionary.put(text2, list);
                LinkedHashMap<String, Object> obj = new LinkedHashMap<String, Object>();
                obj.put(text2, dictionary.get(text2));

                String json = new ObjectMapper().writeValueAsString(obj);
                
                String url_json = URLEncoder.encode(json, "UTF-8");
                this.PostPush(name, url_json);
            }
        }
        catch (SQLException ex) {
            Logger.getLogger(Sincronizador.class.getName()).log(Level.SEVERE, null, ex);
        } catch (IOException ex) {
            Logger.getLogger(Sincronizador.class.getName()).log(Level.SEVERE, null, ex);
        }
    }
    
    public void PostPush(String name, String json) 
    {
        try {
            if (this.config.geral.get("hash").equals("") || this.config.geral.get("key").equals("") || this.config.query.get(name).get("destinoidQuery").equals(""))
            {
                System.out.println("PostPush faltam dados necessários para efectuar o Push.");
                throw new IllegalStateException("PostPush faltam dados necessários para efectuar o Push.");
            }
            
            HttpClientBuilder b = HttpClientBuilder.create();
            SSLContext sslContext = new SSLContextBuilder().loadTrustMaterial(null, new TrustStrategy() {
                public boolean isTrusted(X509Certificate[] arg0, String arg1) throws CertificateException {
                    return true;
                }
            }).build();
            b.setSslcontext( sslContext);
            HostnameVerifier hostnameVerifier = SSLConnectionSocketFactory.ALLOW_ALL_HOSTNAME_VERIFIER;
            SSLConnectionSocketFactory sslSocketFactory = new SSLConnectionSocketFactory(sslContext, hostnameVerifier);
            Registry<ConnectionSocketFactory> socketFactoryRegistry = RegistryBuilder.<ConnectionSocketFactory>create()
                    .register("http", PlainConnectionSocketFactory.getSocketFactory())
                    .register("https", sslSocketFactory)
                    .build();
            PoolingHttpClientConnectionManager connMgr = new PoolingHttpClientConnectionManager( socketFactoryRegistry);
            b.setConnectionManager( connMgr);
            
            HttpClient client = b.build();
            
            String address = this.settings.GetSettingFromFile("PostPushURL").replace("[%hash%]", this.config.geral.get("hash").toString());
            
            HttpPost post = new HttpPost(address);
            String output = "";
            try {
                List<NameValuePair> data = new ArrayList<NameValuePair>(3);
                
                data.add(new BasicNameValuePair("api_key", this.config.geral.get("key").toString()));
                data.add(new BasicNameValuePair("slot", this.config.query.get(name).get("destinoidQuery")));
                data.add(new BasicNameValuePair("data", json));
                
                post.setEntity(new UrlEncodedFormEntity(data));
                
                HttpResponse response = client.execute(post);
                BufferedReader rd = new BufferedReader(new InputStreamReader(response.getEntity().getContent()));
                String line = "";
                while ((line = rd.readLine()) != null) {
                    output = output + line;
                }
            } catch (IOException e) {
                e.printStackTrace();
            }
            
            TypeReference<HashMap<String,String>> typeRef = new TypeReference<HashMap<String,String>>() {};
            HashMap response = new ObjectMapper().readValue(output, typeRef);
            
            if (! Boolean.parseBoolean(response.get("success").toString())) {
                Log.Write("Problemas no PostPush: " + response.get("error_message").toString(), this.configLogName);
                Log.Write("Output: " + output, this.configLogName);
            }
        } catch (NoSuchAlgorithmException ex) {
            Logger.getLogger(Sincronizador.class.getName()).log(Level.SEVERE, null, ex);
        } catch (KeyStoreException ex) {
            Logger.getLogger(Sincronizador.class.getName()).log(Level.SEVERE, null, ex);
        } catch (KeyManagementException ex) {
            Logger.getLogger(Sincronizador.class.getName()).log(Level.SEVERE, null, ex);
        } catch (IOException ex) {
            Logger.getLogger(Sincronizador.class.getName()).log(Level.SEVERE, null, ex);
        }
    }
    
    public String WriteDataFile(String file, HashMap<String, Object> dados) 
    {
        try {
            String text = new ObjectMapper().writeValueAsString(dados);
            if (!file.equals(""))
            {
                Util.WriteAllText(file, text);
            }
            return text;
        } catch (IOException ex) {
            Logger.getLogger(Sincronizador.class.getName()).log(Level.SEVERE, null, ex);
        }
        return "";
    }
    
    private Timer SetQueryTimer(String name) 
    {
        Integer num = 15;
        
        if (!this.config.query.get(name).get("intervaloQuery").contains(",") && this.config.query.get(name).get("intervaloQuery").contains("."))
        {
            try {
                num = Integer.parseInt(this.config.query.get(name).get("intervaloQuery").replace(",", "."));
            }
            catch(Exception ex) {
                try {
                    Log.Write("Query \"" + name + "\" tem um intervalo que não pode ser convertido para um número", this.configLogName);
                    num = 15;
                } catch (IOException ex1) {
                    Logger.getLogger(Sincronizador.class.getName()).log(Level.SEVERE, null, ex1);
                }
            }
        }
        else {
            try {
                num = Integer.parseInt(this.config.query.get(name).get("intervaloQuery"));
            }
            catch(Exception ex) {
                try {
                    Log.Write("Query \"" + name + "\" tem um intervalo que não pode ser convertido para um número", this.configLogName);
                    num = 15;
                } catch (IOException ex1) {
                    Logger.getLogger(Sincronizador.class.getName()).log(Level.SEVERE, null, ex1);
                }
            }
        }
        
        class MyTimerTask extends TimerTask  {
            Sincronizador param;

            public MyTimerTask(Sincronizador param) {
                this.param = param;
            }

            @Override
            public void run() {
                this.param.RunQuery(name);
            }
       }
        
        Timer timer = new Timer();
        timer.scheduleAtFixedRate(new MyTimerTask(this), num*60*1000, num*60*1000);
        return timer;
    }
    
    public void StartTimers() {
        try
        {
            Iterator it = this.config.query.entrySet().iterator();
            
            while (it.hasNext()) {
                Map.Entry current = (Map.Entry)it.next();

                if (this.config.geral.get("debug") == "True") {
                    this.RunQuery( current.getKey().toString() );
                }
                else {
                    this.timers.put("query_" + current.getKey(), SetQueryTimer(current.getKey().toString()));
                }

                it.remove();
            }
        }
        catch (Exception ex)
        {
            this.ExceptionMessage(ex);
        }
    }
    
    public void Stop()
    {
        try
        {
            Log.Write("Windows Service do Sincronizador de Dados para NCDataOnline a parar", this.configLogName);
            for (Map.Entry<String, Timer> entry : this.timers.entrySet()) {
                entry.getValue().cancel();
            }
            this.timers.clear();
            Log.Write("Windows Service do Sincronizador de Dados para NCDataOnline parou", this.configLogName);
        }
        catch (Exception ex)
        {
            this.ExceptionMessage(ex);
        }
    }
    
    public void StartSinc(String name)
    {
        try
        {
            this.first = new Sincronizador();
            this.first.configName = name;
            this.first.start();
        }
        catch (Exception ex)
        {
            this.ExceptionMessage(ex);
            this.Stop();
        }
    }
    
    public void UpdateConfig() 
    {
        File file = new File(this.configFileName);
        if (!file.exists()) {
            try {
                System.out.println("Não existe ficheiro de configuração: " + this.configFileName);
                Log.Write("Não existe ficheiro de configuração: " + this.configFileName, this.configLogName);
                return;
            } catch (IOException ex) {
                Logger.getLogger(Sincronizador.class.getName()).log(Level.SEVERE, null, ex);
            }
        }

        this.LoadConfig();
    }
    
    public void LoadConfig()
    {
        try
        {
            File file = new File(this.configFileName);
            if (file.exists()) {
                String text = Util.ReadAllText(this.configFileName);
                boolean flag = true;
                flag = this.settings.GetSettingFromFile("UsesCrypt", flag);
                if (flag) {
                    text = StringCipher.Decrypt(text, "78x3s65a6dc9d2x1", "d2c7cb525a74a48c");
                }

                this.config = new ObjectMapper().readValue(text, ConfigData.class);
            }
        }
        catch (Exception ex)
        {
        }
    }
}
