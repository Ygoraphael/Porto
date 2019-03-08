/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package ncdataonlineservice;

import java.io.IOException;
import java.io.PrintWriter;
import java.nio.charset.StandardCharsets;
import java.security.InvalidAlgorithmParameterException;
import java.security.InvalidKeyException;
import java.security.NoSuchAlgorithmException;
import java.util.logging.Level;
import java.util.logging.Logger;
import javax.crypto.BadPaddingException;
import javax.crypto.Cipher;
import javax.crypto.IllegalBlockSizeException;
import javax.crypto.NoSuchPaddingException;
import javax.crypto.spec.IvParameterSpec;
import javax.crypto.spec.SecretKeySpec;
import sun.misc.BASE64Decoder;
import static java.nio.charset.StandardCharsets.UTF_16LE;
import java.security.NoSuchProviderException;
import java.security.Security;
import java.security.spec.AlgorithmParameterSpec;
import java.util.Arrays;
import javax.crypto.spec.PBEKeySpec;
import org.bouncycastle.crypto.digests.SHA1Digest;
import org.bouncycastle.crypto.generators.PKCS5S1ParametersGenerator;
import org.bouncycastle.crypto.params.KeyParameter;

/**
 *
 * @author tml
 */
public class StringCipher {
    
    public static String Decrypt(String cyphertext, String initvector, String passphrase)
    {
        if (initvector.length() != 16) {
            System.out.println("initvector tem que ter 16 caracteres");
        }
        if (passphrase.length() != 16) {
            System.out.println("passphrase tem que ter 16 caracteres");
        }
        
        try {
            
            Security.addProvider(new org.bouncycastle.jce.provider.BouncyCastleProvider());
            byte[] saltBytes = initvector.getBytes("UTF8");
            byte[] passBytes = passphrase.getBytes("UTF8");

            PKCS5S1ParametersGenerator generator = new PasswordDeriveBytes(new SHA1Digest());
            generator.init(passBytes, new byte[0], 100);

            byte[] key = ((KeyParameter) generator.generateDerivedParameters(256)).getKey();
            byte[] ivBytes = new byte[32];
            System.arraycopy(key, 0, ivBytes, 0, key.length);
            
            Cipher cipher = Cipher.getInstance("AES/CBC/PKCS5Padding");
            SecretKeySpec keySpec = new SecretKeySpec(ivBytes, "Rijndael");
            
            cipher.init(Cipher.DECRYPT_MODE, keySpec, new IvParameterSpec(saltBytes));

            byte[] encryptedBytes = new BASE64Decoder().decodeBuffer(cyphertext);
            byte[] original = cipher.doFinal(encryptedBytes);
            
            String s = new String(original);
            return s;
            
        } catch (IOException | NoSuchAlgorithmException | NoSuchPaddingException | InvalidKeyException | InvalidAlgorithmParameterException | IllegalBlockSizeException | BadPaddingException ex) {
            Logger.getLogger(StringCipher.class.getName()).log(Level.SEVERE, null, ex);
        }
        return null;
    }
}
