/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package nctask;
import flexjson.JSONDeserializer;
import flexjson.JSONSerializer;
import java.io.IOException;
import java.io.UnsupportedEncodingException;
import java.net.URLEncoder;
import java.util.ArrayList;
import java.util.Date;
import java.util.List;
import javax.swing.JOptionPane;
import java.io.*;
import java.text.SimpleDateFormat;
import java.util.Calendar;
import java.util.logging.Level;
import java.util.logging.Logger;
/**
 *
 * @author Tiago Loureiro
 */

public class NCTask {
    
    public static Config conf = new Config();
    public static Site site = new Site();
    public static FileWriter out;
    
    public static void main(String[] args) throws IOException {
        
        writeLog("Iniciou Sincronização");
        
        int num_argumentos = args.length;
        
        if( num_argumentos % 2 == 0)
        {
            for(int i=0; i<num_argumentos; i=i+2)
            {
                if(args[i].equals("-c"))
                {
                    UpdateCliente(args[i+1]);
                }
                else if(args[i].equals("-t"))
                {
                    UpdateTarefa(args[i+1]);
                }
                else if(args[i].equals("-m"))
                {
                    UpdateMovimento(args[i+1]);
                }
                else if(args[i].equals("-ct"))
                {
                    UpdateContrato(args[i+1]);
                }
                else if(args[i].equals("-u"))
                {
                    UpdateUtilizador(args[i+1]);
                }
                else if(args[i].equals("-p"))
                {
                    UpdateProjecto(args[i+1]);
                }
            } 
        }
        
        //envia dados para website
        //syncTarefas();
        //syncUtilizadores();
        //syncClientes();

        //envia dados para website
        //syncContratos();
    }

    public static void writeLog(String texto) throws FileNotFoundException, IOException {
        String logPath = System.getProperty("java.class.path");
        logPath = logPath.substring(0, logPath.length() - 10);
        
        out = new FileWriter(logPath + "NCTASK.log", true);
        String timeStamp = new SimpleDateFormat("yyyy-MM-dd HH:mm:ss").format(Calendar.getInstance().getTime());
        out.write(timeStamp + " - " + texto + "\r\n");
        out.close();
    }
    
    public static void UpdateTarefa(String id) throws IOException {
        String data; 
        String responseText; 
        GenericResponse gr;
        JSONSerializer serializer = new JSONSerializer().exclude("class");

        site.setUrl( conf.getURL() );

        Tarefa tarefa = new Tarefa( conf.getHostname(), conf.getPort(), 
                conf.getUtilizador(), conf.getPassword(), conf.getDB());
        
        tarefa.get( id );
        
        if ( tarefa.dytablestamp != null ) {
            try {
                int errors = 0;
                data = "data=" + 
                URLEncoder.encode(serializer.serialize( tarefa ), "UTF-8") + "&task=UpdateTarefaById";
                site.sendData(data);
                responseText = site.response.readLine(); 

                try {
                    gr = new JSONDeserializer<GenericResponse>().use(null, GenericResponse.class ).
                        deserialize(responseText);
                    if ( !gr.success ) {
                        errors++;
                    }
                } 
                catch ( Exception e ) {
                    writeLog("Erro ao ler resposta na sincronização da tarefa!");
                    System.out.println("Erro ao ler resposta na sincronização da tarefa!");

                    while ((responseText = site.response.readLine()) != null ) {
                        System.out.println(responseText);
                    }
                    System.out.println( e.toString() );
                }

                if ( errors == 0 ) {
                    writeLog("Tarefa actualizada com sucesso.");
                    System.out.println( "Tarefa actualizada com sucesso.");
                } else {
                    writeLog("Ocorreram erros na actualização da tarefa.");
                    System.out.println("Ocorreram erros na actualização da tarefa.");
                }
            } 
            catch (UnsupportedEncodingException ex) {
                System.out.println( ex.toString() );
            } 
            catch (IOException e ) {
                System.out.println( e.toString() );
            }
        } 
        else {
            writeLog("Não existe tarefa para enviar!");
            System.out.println("Não existe tarefa para enviar!");
        }
    }
    
    public static void UpdateContrato(String id_c) throws IOException {
        String data; 
        String responseText; 
        GenericResponse gr;
        JSONSerializer serializer = new JSONSerializer().exclude("class");

        site.setUrl( conf.getURL() );

        Contrato contrato = new Contrato( conf.getHostname(), conf.getPort(), 
                conf.getUtilizador(), conf.getPassword(), conf.getDB());
        
        contrato.get( id_c );
        
        if ( contrato.no > 0 ) {
            try {
                int errors = 0;
                data = "data=" + 
                URLEncoder.encode(serializer.serialize( contrato ), "UTF-8") + "&task=UpdateContratoById";
                site.sendData(data);
                responseText = site.response.readLine(); 

                try {
                    gr = new JSONDeserializer<GenericResponse>().use(null, GenericResponse.class ).
                        deserialize(responseText);
                    if ( !gr.success ) {
                        errors++;
                    }
                } 
                catch ( Exception e ) {
                    writeLog("Erro ao ler resposta na sincronização do contrato!");
                    System.out.println("Erro ao ler resposta na sincronização do contrato!");

                    while ((responseText = site.response.readLine()) != null ) {
                        System.out.println(responseText);
                    }
                    System.out.println( e.toString() );
                }

                if ( errors == 0 ) {
                    writeLog("Contrato actualizado com sucesso.");
                    System.out.println( "Contrato actualizado com sucesso.");
                } else {
                    writeLog("Ocorreram erros na actualização do contrato.");
                    System.out.println("Ocorreram erros na actualização do contrato.");
                }
            } 
            catch (UnsupportedEncodingException ex) {
                System.out.println( ex.toString() );
            } 
            catch (IOException e ) {
                System.out.println( e.toString() );
            }
        } 
        else {
            writeLog("Não existe contrato para enviar!");
            System.out.println("Não existe contrato para enviar!");
        }
    }
    
    public static void UpdateMovimento(String id_mov) throws IOException {
        String data; 
        String responseText; 
        GenericResponse gr;
        JSONSerializer serializer = new JSONSerializer().exclude("class");

        site.setUrl( conf.getURL() );

        Movimento movimento = new Movimento( conf.getHostname(), conf.getPort(), 
                conf.getUtilizador(), conf.getPassword(), conf.getDB());
        
        movimento.get( id_mov );
        
        if ( movimento.id != null ) {
            try {
                int errors = 0;
                data = "data=" + 
                URLEncoder.encode(serializer.serialize( movimento ), "UTF-8") + "&task=UpdateMovimentoById";
                site.sendData(data);
                responseText = site.response.readLine(); 

                try {
                    gr = new JSONDeserializer<GenericResponse>().use(null, GenericResponse.class ).
                        deserialize(responseText);
                    if ( !gr.success ) {
                        errors++;
                    }
                } 
                catch ( Exception e ) {
                    writeLog("Erro ao ler resposta na sincronização do movimento!");
                    System.out.println("Erro ao ler resposta na sincronização do movimento!");

                    while ((responseText = site.response.readLine()) != null ) {
                        System.out.println(responseText);
                    }
                    System.out.println( e.toString() );
                }

                if ( errors == 0 ) {
                    writeLog("Movimento actualizado com sucesso.");
                    System.out.println( "Movimento actualizado com sucesso.");
                } else {
                    writeLog("Ocorreram erros na actualização do movimento.");
                    System.out.println("Ocorreram erros na actualização do movimento.");
                }
            } 
            catch (UnsupportedEncodingException ex) {
                System.out.println( ex.toString() );
            } 
            catch (IOException e ) {
                System.out.println( e.toString() );
            }
        } 
        else {
            writeLog("Não existe movimento para enviar!");
            System.out.println("Não existe movimento para enviar!");
        }
    }    
    
    public static void UpdateProjecto(String ref_projecto) throws IOException {
        String data; 
        String responseText; 
        GenericResponse gr;
        JSONSerializer serializer = new JSONSerializer().exclude("class");

        site.setUrl( conf.getURL() );

        Projecto projecto = new Projecto( conf.getHostname(), conf.getPort(), 
                conf.getUtilizador(), conf.getPassword(), conf.getDB());
        
        projecto.get( ref_projecto );
        
        if ( projecto.referencia != null ) {
            try {
                int errors = 0;
                data = "data=" + 
                URLEncoder.encode(serializer.serialize( projecto ), "UTF-8") + "&task=UpdateProjectoById";
                site.sendData(data);
                responseText = site.response.readLine(); 

                try {
                    gr = new JSONDeserializer<GenericResponse>().use(null, GenericResponse.class ).
                        deserialize(responseText);
                    if ( !gr.success ) {
                        errors++;
                    }
                } 
                catch ( Exception e ) {
                    writeLog("Erro ao ler resposta na sincronização do projecto!");
                    System.out.println("Erro ao ler resposta na sincronização do projecto!");

                    while ((responseText = site.response.readLine()) != null ) {
                        System.out.println(responseText);
                    }
                    System.out.println( e.toString() );
                }

                if ( errors == 0 ) {
                    writeLog("Projecto actualizado com sucesso.");
                    System.out.println( "Projecto actualizado com sucesso.");
                } else {
                    writeLog("Ocorreram erros na actualização do projecto.");
                    System.out.println("Ocorreram erros na actualização do projecto.");
                }
            } 
            catch (UnsupportedEncodingException ex) {
                System.out.println( ex.toString() );
            } 
            catch (IOException e ) {
                System.out.println( e.toString() );
            }
        } 
        else {
            writeLog("Não existe projecto para enviar!");
            System.out.println("Não existe projecto para enviar!");
        }
    }
    
    public static void UpdateUtilizador(String id_utilizador) throws IOException {
        String data; 
        String responseText; 
        GenericResponse gr;
        JSONSerializer serializer = new JSONSerializer().exclude("class");

        site.setUrl( conf.getURL() );

        Utilizador utilizador = new Utilizador( conf.getHostname(), conf.getPort(), 
                conf.getUtilizador(), conf.getPassword(), conf.getDB());
        
        utilizador.get( id_utilizador );
        
        if ( utilizador.userno != null ) {
            try {
                int errors = 0;
                data = "data=" + 
                URLEncoder.encode(serializer.serialize( utilizador ), "UTF-8") + "&task=UpdateUtilizadorById";
                site.sendData(data);
                responseText = site.response.readLine(); 

                try {
                    gr = new JSONDeserializer<GenericResponse>().use(null, GenericResponse.class ).
                        deserialize(responseText);
                    if ( !gr.success ) {
                        errors++;
                    }
                } 
                catch ( Exception e ) {
                    writeLog("Erro ao ler resposta na sincronização do utilizador!");
                    System.out.println("Erro ao ler resposta na sincronização do utilizador!");

                    while ((responseText = site.response.readLine()) != null ) {
                        System.out.println(responseText);
                    }
                    System.out.println( e.toString() );
                }

                if ( errors == 0 ) {
                    writeLog("Utilizador actualizado com sucesso.");
                    System.out.println( "Utilizador actualizado com sucesso.");
                } else {
                    writeLog("Ocorreram erros na actualização do utilizador.");
                    System.out.println("Ocorreram erros na actualização do utilizador.");
                }
            } 
            catch (UnsupportedEncodingException ex) {
                System.out.println( ex.toString() );
            } 
            catch (IOException e ) {
                System.out.println( e.toString() );
            }
        } 
        else {
            writeLog("Não existe utilizador para enviar!");
            System.out.println("Não existe utilizador para enviar!");
        }
    }
    
    public static void UpdateCliente(String id_cliente) throws IOException {
        String data; 
        String responseText; 
        GenericResponse gr;
        JSONSerializer serializer = new JSONSerializer().exclude("class");

        site.setUrl( conf.getURL() );

        Cliente cliente = new Cliente( conf.getHostname(), conf.getPort(), 
                conf.getUtilizador(), conf.getPassword(), conf.getDB());
        
        cliente.get( id_cliente );
        
        if ( cliente.no != null ) {
            try {
                int errors = 0;
                data = "data=" + 
                URLEncoder.encode(serializer.serialize( cliente ), "UTF-8") + "&task=UpdateClienteById";
                site.sendData(data);
                responseText = site.response.readLine(); 

                try {
                    
                    gr = new JSONDeserializer<GenericResponse>().use(null, GenericResponse.class ).
                        deserialize(responseText);
                    if ( !gr.success ) {
                        errors++;
                    }
                    
                } 
                catch ( Exception e ) {
                    writeLog("Erro ao ler resposta na sincronização do cliente!");
                    System.out.println("Erro ao ler resposta na sincronização do cliente!");

                    while ((responseText = site.response.readLine()) != null ) {
                        System.out.println(responseText);
                    }
                    System.out.println( e.toString() );
                }

                if ( errors == 0 ) {
                    writeLog("Cliente actualizado com sucesso.");
                    System.out.println( "Cliente actualizado com sucesso.");
                } else {
                    writeLog("Ocorreram erros na actualização do cliente.");
                    System.out.println("Ocorreram erros na actualização do cliente.");
                }
            } 
            catch (UnsupportedEncodingException ex) {
                System.out.println( ex.toString() );
            } 
            catch (IOException e ) {
                System.out.println( e.toString() );
            }
        } 
        else {
            writeLog("Não existe cliente para enviar!");
            System.out.println("Não existe cliente para enviar!");
        }
    }
    
    //old
    
    public static void syncTarefas() throws FileNotFoundException, IOException {

        String data; 
        String responseText; 
        GenericResponse gr;
        JSONSerializer serializer = new JSONSerializer().exclude("class");

        site.setUrl( conf.getURL() );
        
        Tarefa tarefa = new Tarefa( conf.getHostname(), conf.getPort(), 
                conf.getUtilizador(), conf.getPassword(), conf.getDB());
        
        ArrayList<Tarefa> tarefas = new ArrayList<Tarefa>();
        tarefas = tarefa.list();
        
        writeLog("#Tarefas a sincronizar: " + tarefas.size());
        
        if ( tarefas != null ) {
            if ( tarefas.size() > 0 ) {
                try {
                    int listSize = tarefas.size();
                    int errors = 0;
                    
                    if (listSize > 50) {
                        
                        int page = 50;
                        int pos = 0;
                        List<Tarefa> prods2 = null; 

                        while (pos < listSize) {
                            if ((pos+page)> listSize) {
                                page = listSize - pos;
                            }
                            prods2 = tarefas.subList(pos, pos+page);
                    
                            data = "data=" + 
                            URLEncoder.encode(serializer.serialize( prods2 ), "UTF-8") + "&task=UpdateTarefa";
                            site.sendData(data);
                            pos = pos + page;
                            
                            responseText = site.response.readLine(); 
                            
                            try {
                                gr = new JSONDeserializer<GenericResponse>().use(null, GenericResponse.class ).
                                    deserialize(responseText);
                                if ( !gr.success ) {
                                    errors++;
                                }
                            } 
                            catch ( Exception e ) {
                                System.out.println("Erro ao ler resposta na sincronização de tarefas!");
                                writeLog("Erro ao ler resposta na sincronização de tarefas!");

                                while ((responseText = site.response.readLine()) != null ) {
                                    System.out.println(responseText);
                                }
                                System.out.println( e.toString() );
                            }
                            if ( errors == 0 ) {
                                writeLog("Tarefas actualizados com sucesso.");
                                System.out.println( "Tarefas actualizados com sucesso.");
                            } else {
                                writeLog("Ocorreram erros na actualização das tarefas.");
                                System.out.println("Ocorreram erros na actualização das tarefas.");
                            }
                        }
                    } 
                    else {
                        data = "data=" + URLEncoder.encode(serializer.serialize( tarefas ), "UTF-8") + "&task=UpdateTarefa";
                        site.sendData(data);
                        
                        responseText = site.response.readLine();
                        
                        try {
                            gr = new JSONDeserializer<GenericResponse>().use(null, GenericResponse.class ).
                                deserialize(responseText);
                            
                            if ( gr.success ) {
                                writeLog("Tarefas actualizados com sucesso!");
                                System.out.println("Tarefas actualizados com sucesso!");
                            } else {
                                writeLog("Ocorreu um erro ao sincronizar tarefas!");
                                System.out.println("Ocorreu um erro ao sincronizar tarefas!");
                            }
                        
                        } 
                        catch ( Exception e ) {
                            writeLog("Erro ao ler resposta do servidor!");
                            System.out.println("Erro ao ler resposta do servidor!");
                            
                            while( (responseText = site.response.readLine()) != null ) {
                                System.out.println( responseText);
                            }
                            System.out.println( e.toString() );
                            return;
                        }
                    }
                } 
                catch (UnsupportedEncodingException ex) {
                    System.out.println( ex.toString() );
                    return;
                } 
                catch (IOException e ) {
                    System.out.println( e.toString() );
                    return;
                }

            } 
            else {
                writeLog("As tarefas ja se encontram actualizados");
                System.out.println("As tarefas ja se encontram actualizados");
            }
        } 
        else {
            writeLog("Nao foi possível obter a listagem das tarefas da base de dados!");
            System.out.println("Nao foi possível obter a listagem das tarefas da base de dados!");
        }
    }

    public static void syncClientes() throws IOException {
        String data; 
        String responseText; 
        GenericResponse gr;
        JSONSerializer serializer = new JSONSerializer().exclude("class");

        site.setUrl( conf.getURL() );

        data = "task=CheckClientsLastUpdate";
        site.sendData( data );
        responseText = site.response.readLine();
        
        try {
            gr = new JSONDeserializer<GenericResponse>().use(null, GenericResponse.class).
                        deserialize( responseText );
        } catch ( Exception e ) {
            writeLog("Erro ao obter data de modificação dos clientes!");
            System.out.println( "Erro ao obter data de modificação dos clientes!");
            System.out.println( "O Servidor respondeu: " );
            
            while( (responseText = site.response.readLine()) != null ) {
                System.out.println( responseText );
            }
            System.out.println( e.toString() );
            return; 
        }

        int d = Integer.parseInt( gr.mdate );
        
        Cliente cliente = new Cliente( conf.getHostname(), conf.getPort(), 
                conf.getUtilizador(), conf.getPassword(), conf.getDB());
        
        ArrayList<Cliente> clientes = new ArrayList<Cliente>();
        clientes = cliente.list( d );
        
        writeLog("#Clientes a sincronizar: " + clientes.size());
        
        if ( clientes != null ) {
            if ( clientes.size() > 0 ) {
                try {
                    int listSize = clientes.size();
                    int errors = 0;
                    
                    if (listSize > 50) {
                        
                        int page = 50;
                        int pos = 0;
                        List<Cliente> prods2 = null; 

                        while (pos < listSize) {
                            if ((pos+page)> listSize) {
                                page = listSize - pos;
                            }
                            prods2 = clientes.subList(pos, pos+page);
                    
                            data = "data=" + 
                            URLEncoder.encode(serializer.serialize( prods2 ), "UTF-8") + "&task=UpdateCliente";
                            site.sendData(data);
                            pos = pos + page;
                            
                            responseText = site.response.readLine(); 
                            
                            try {
                                gr = new JSONDeserializer<GenericResponse>().use(null, GenericResponse.class ).
                                    deserialize(responseText);
                                if ( !gr.success ) {
                                    errors++;
                                }
                            } 
                            catch ( Exception e ) {
                                writeLog("Erro ao ler resposta na sincronização de clientes!");
                                System.out.println("Erro ao ler resposta na sincronização de clientes!");

                                while ((responseText = site.response.readLine()) != null ) {
                                    System.out.println(responseText);
                                }
                                System.out.println( e.toString() );
                            }
                            if ( errors == 0 ) {
                                writeLog("Clientes actualizados com sucesso.");
                                System.out.println( "Clientes actualizados com sucesso.");
                            } else {
                                writeLog("Ocorreram erros na actualização dos clientes.");
                                System.out.println("Ocorreram erros na actualização dos clientes.");
                            }
                        }
                    } 
                    else {
                        data = "data=" + URLEncoder.encode(serializer.serialize( clientes ), "UTF-8") + "&task=UpdateCliente";
                        site.sendData(data);
                        
                        responseText = site.response.readLine();
                        
                        try {
                            gr = new JSONDeserializer<GenericResponse>().use(null, GenericResponse.class ).
                                deserialize(responseText);
                            
                            if ( gr.success ) {
                                writeLog("Clientes actualizados com sucesso!");
                                System.out.println("Clientes actualizados com sucesso!");
                            } else {
                                writeLog("Ocorreu um erro ao sincronizar clientes!");
                                System.out.println("Ocorreu um erro ao sincronizar clientes!");
                            }
                        
                        } 
                        catch ( Exception e ) {
                            writeLog("Erro ao ler resposta do servidor!");
                            System.out.println("Erro ao ler resposta do servidor!");
                            
                            while( (responseText = site.response.readLine()) != null ) {
                                System.out.println( responseText);
                            }
                            System.out.println( e.toString() );
                            return;
                        }
                    }
                } 
                catch (UnsupportedEncodingException ex) {
                    System.out.println( ex.toString() );
                    return;
                } 
                catch (IOException e ) {
                    System.out.println( e.toString() );
                    return;
                }

            } 
            else {
                writeLog("Os clientes ja se encontram actualizados");
                System.out.println("Os clientes ja se encontram actualizados");
            }
        } 
        else {
            writeLog("Nao foi possível obter a listagem dos clientes da base de dados!");
            System.out.println("Nao foi possível obter a listagem dos clientes da base de dados!");
        }
    }

    public static void syncUtilizadores() throws IOException {
        String data; 
        String responseText; 
        GenericResponse gr;
        JSONSerializer serializer = new JSONSerializer().exclude("class");

        site.setUrl( conf.getURL() );

        data = "task=CheckUsersLastUpdate";
        site.sendData( data );
        responseText = site.response.readLine();
        
        try {
            gr = new JSONDeserializer<GenericResponse>().use(null, GenericResponse.class).
                        deserialize( responseText );
        } catch ( Exception e ) {
            writeLog("Erro ao obter data de modificação dos utilizadores!");
            System.out.println( "Erro ao obter data de modificação dos utilizadores!");
            System.out.println( "O Servidor respondeu: " );
            
            while( (responseText = site.response.readLine()) != null ) {
                System.out.println( responseText );
            }
            System.out.println( e.toString() );
            return; 
        }
        
        int d = Integer.parseInt( gr.mdate );
        
        Utilizador utilizador = new Utilizador( conf.getHostname(), conf.getPort(), 
                conf.getUtilizador(), conf.getPassword(), conf.getDB());
        
        ArrayList<Utilizador> utilizadores = new ArrayList<Utilizador>();
        utilizadores = utilizador.list( d );
        
        writeLog("#Utilizadores a sincronizar: " + utilizadores.size());
        
        if ( utilizadores != null ) {
            if ( utilizadores.size() > 0 ) {
                try {
                    int listSize = utilizadores.size();
                    int errors = 0;
                    
                    if (listSize > 50) {
                        
                        int page = 50;
                        int pos = 0;
                        List<Utilizador> prods2 = null; 

                        while (pos < listSize) {
                            if ((pos+page)> listSize) {
                                page = listSize - pos;
                            }
                            prods2 = utilizadores.subList(pos, pos+page);
                    
                            data = "data=" + 
                            URLEncoder.encode(serializer.serialize( prods2 ), "UTF-8") + "&task=UpdateUtilizador";
                            site.sendData(data);
                            pos = pos + page;
                            
                            responseText = site.response.readLine(); 
                            
                            try {
                                gr = new JSONDeserializer<GenericResponse>().use(null, GenericResponse.class ).
                                    deserialize(responseText);
                                if ( !gr.success ) {
                                    errors++;
                                }
                            } 
                            catch ( Exception e ) {
                                writeLog("Erro ao ler resposta na sincronização de utilizadores!");
                                System.out.println("Erro ao ler resposta na sincronização de utilizadores!");

                                while ((responseText = site.response.readLine()) != null ) {
                                    System.out.println(responseText);
                                }
                                System.out.println( e.toString() );
                            }
                            if ( errors == 0 ) {
                                writeLog("Utilizadores actualizados com sucesso.");
                                System.out.println( "Utilizadores actualizados com sucesso.");
                            } else {
                                writeLog("Ocorreram erros na actualização dos utilizadores.");
                                System.out.println("Ocorreram erros na actualização dos utilizadores.");
                            }
                        }
                    } 
                    else {
                        data = "data=" + URLEncoder.encode(serializer.serialize( utilizadores ), "UTF-8") + "&task=UpdateUtilizador";
                        site.sendData(data);
                        
                        responseText = site.response.readLine();
                        
                        try {
                            gr = new JSONDeserializer<GenericResponse>().use(null, GenericResponse.class ).
                                deserialize(responseText);
                            
                            if ( gr.success ) {
                                writeLog("Utilizadores actualizados com sucesso!");
                                System.out.println("Utilizadores actualizados com sucesso!");
                            } else {
                                writeLog("Ocorreu um erro ao sincronizar utilizadores!");
                                System.out.println("Ocorreu um erro ao sincronizar utilizadores!");
                            }
                        
                        } 
                        catch ( Exception e ) {
                            
                            writeLog("Erro ao ler resposta do servidor!");
                            System.out.println("Erro ao ler resposta do servidor!");
                            
                            while( (responseText = site.response.readLine()) != null ) {
                                System.out.println( responseText);
                            }
                            System.out.println( e.toString() );
                            return;
                        }
                    }
                } 
                catch (UnsupportedEncodingException ex) {
                    System.out.println( ex.toString() );
                    return;
                } 
                catch (IOException e ) {
                    System.out.println( e.toString() );
                    return;
                }

            } 
            else {
                writeLog("Os utilizadores ja se encontram actualizados");
                System.out.println("Os utilizadores ja se encontram actualizados");
            }
        } 
        else {
            writeLog("Nao foi possível obter a listagem dos utilizadores da base de dados!");
            System.out.println("Nao foi possível obter a listagem dos utilizadores da base de dados!");
        }
    }
    
    public static void syncContratos() throws FileNotFoundException, IOException {

        String data; 
        String responseText; 
        GenericResponse gr;
        JSONSerializer serializer = new JSONSerializer().exclude("class");

        site.setUrl( conf.getURL() );
        
        Contrato contrato = new Contrato( conf.getHostname(), conf.getPort(), 
                conf.getUtilizador(), conf.getPassword(), conf.getDB());
        
        ArrayList<Contrato> contratos = new ArrayList<Contrato>();
        contratos = contrato.list();
        
        if ( contratos != null ) {
            if ( contratos.size() > 0 ) {
                try {
                    int listSize = contratos.size();
                    int errors = 0;
                    
                    if (listSize > 50) {
                        
                        int page = 50;
                        int pos = 0;
                        List<Contrato> prods2 = null; 

                        while (pos < listSize) {
                            if ((pos+page)> listSize) {
                                page = listSize - pos;
                            }
                            prods2 = contratos.subList(pos, pos+page);
                    
                            data = "data=" + 
                            URLEncoder.encode(serializer.serialize( prods2 ), "UTF-8") + "&task=UpdateContrato";
                            site.sendData(data);
                            pos = pos + page;
                            
                            responseText = site.response.readLine(); 
                            
                            try {
                                gr = new JSONDeserializer<GenericResponse>().use(null, GenericResponse.class ).
                                    deserialize(responseText);
                                if ( !gr.success ) {
                                    errors++;
                                }
                            } 
                            catch ( Exception e ) {
                                writeLog("Erro ao ler resposta na sincronização de contratos!");
                                System.out.println("Erro ao ler resposta na sincronização de contratos!");

                                while ((responseText = site.response.readLine()) != null ) {
                                    System.out.println(responseText);
                                }
                                System.out.println( e.toString() );
                            }
                            if ( errors == 0 ) {
                                writeLog("Contratos actualizados com sucesso.");
                                System.out.println( "Contratos actualizados com sucesso.");
                            } else {
                                writeLog("Ocorreram erros na actualização dos contratos.");
                                System.out.println("Ocorreram erros na actualização dos contratos.");
                            }
                        }
                    } 
                    else {
                        data = "data=" + URLEncoder.encode(serializer.serialize( contratos ), "UTF-8") + "&task=UpdateContrato";
                        site.sendData(data);
                        
                        responseText = site.response.readLine();
                        
                        try {
                            gr = new JSONDeserializer<GenericResponse>().use(null, GenericResponse.class ).
                                deserialize(responseText);
                            
                            if ( gr.success ) {
                                writeLog("Contratos actualizados com sucesso!");
                                System.out.println("Contratos actualizados com sucesso!");
                            } else {
                                writeLog("Ocorreu um erro ao sincronizar contratos!");
                                System.out.println("Ocorreu um erro ao sincronizar contratos!");
                            }
                        
                        } 
                        catch ( Exception e ) {
                            
                            writeLog("Erro ao ler resposta do servidor!");
                            System.out.println("Erro ao ler resposta do servidor!");
                            
                            while( (responseText = site.response.readLine()) != null ) {
                                System.out.println( responseText);
                            }
                            System.out.println( e.toString() );
                            return;
                        }
                    }
                } 
                catch (UnsupportedEncodingException ex) {
                    System.out.println( ex.toString() );
                    return;
                } 
                catch (IOException e ) {
                    System.out.println( e.toString() );
                    return;
                }

            } 
            else {
                writeLog("Os contratos ja se encontram actualizados");
                System.out.println("Os contratos ja se encontram actualizados");
            }
        } 
        else {
            writeLog("Nao foi possível obter a listagem dos contratos da base de dados!");
            System.out.println("Nao foi possível obter a listagem dos contratos da base de dados!");
        }
    }
}
