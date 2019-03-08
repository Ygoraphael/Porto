/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package simple_encrypt;

/**
 *
 * @author tml
 */
public class Simple_Encrypt {

    /**
     * @param args the command line arguments
     */
    public static void main(String[] args) {
        // TODO code application logic here
        String text_to_encrypt = "abc";
        System.out.println( Encrypt(text_to_encrypt) );
        System.out.println( Decrypt(Encrypt(text_to_encrypt)) );
        
    }
    
    public static String Encrypt( String text_to_encrypt ) {
        String var_str = "";
        String tmp_str = "";
        String final_str = "";
        
        for (char ch: text_to_encrypt.toCharArray()) {
            int ascii = (int) ch;
            ascii = (ascii * 2) + 3;
            var_str = String.format("%03d", ascii);
            tmp_str = "" + var_str.charAt(2) + var_str.charAt(0) + var_str.charAt(1);
            final_str += tmp_str;
        }
        
        return final_str;
    }
    
    public static String Decrypt( String text_to_decrypt ) {
        String var_str = "";
        String tmp_str = "";
        String final_str = "";
        Integer index = 0;
        
        while ( index < text_to_decrypt.length() ) {
            tmp_str = "" + text_to_decrypt.charAt(index + 1) + text_to_decrypt.charAt(index + 2) + text_to_decrypt.charAt(index);           
            var_str = Character.toString ((char) ((Integer.parseInt(tmp_str)-3)/2) );
            final_str += var_str;
            index += 3;
        }
        
        return final_str;
    }
    
}
