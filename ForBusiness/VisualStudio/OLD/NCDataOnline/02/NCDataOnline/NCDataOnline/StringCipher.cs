using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Security.Cryptography;
using System.IO;

namespace NCDataOnline
{
    public static class StringCipher
    {
        // Methods
        public static string Decrypt(string cyphertext, string initvector, string passphrase)
        {
            if (initvector.Length != 0x10)
            {
                throw new Exception("StringCipher.Decrypt" + Environment.NewLine + "initvector tem que ter 16 caracteres");
            }
            if (passphrase.Length != 0x10)
            {
                throw new Exception("StringCipher.Decrypt" + Environment.NewLine + "passphrase tem que ter 16 caracteres");
            }
            byte[] bytes = Encoding.ASCII.GetBytes(initvector);
            byte[] buffer = Convert.FromBase64String(cyphertext);
            byte[] rgbKey = new PasswordDeriveBytes(passphrase, null).GetBytes(0x20);
            ICryptoTransform transform = new RijndaelManaged { Mode = CipherMode.CBC }.CreateDecryptor(rgbKey, bytes);
            MemoryStream stream = new MemoryStream(buffer);
            CryptoStream stream2 = new CryptoStream(stream, transform, CryptoStreamMode.Read);
            byte[] buffer4 = new byte[buffer.Length];
            int count = stream2.Read(buffer4, 0, buffer4.Length);
            stream.Close();
            stream2.Close();
            return Encoding.UTF8.GetString(buffer4, 0, count);
        }

        public static string Encrypt(string plaintext, string initvector, string passphrase)
        {
            if (initvector.Length != 0x10)
            {
                throw new Exception("StringCipher.Encrypt" + Environment.NewLine + "initvector tem que ter 16 caracteres");
            }
            if (passphrase.Length != 0x10)
            {
                throw new Exception("StringCipher.Encrypt" + Environment.NewLine + "passphrase tem que ter 16 caracteres");
            }
            byte[] bytes = Encoding.UTF8.GetBytes(initvector);
            byte[] buffer = Encoding.UTF8.GetBytes(plaintext);
            byte[] rgbKey = new PasswordDeriveBytes(passphrase, null).GetBytes(0x20);
            ICryptoTransform transform = new RijndaelManaged { Mode = CipherMode.CBC }.CreateEncryptor(rgbKey, bytes);
            MemoryStream stream = new MemoryStream();
            CryptoStream stream2 = new CryptoStream(stream, transform, CryptoStreamMode.Write);
            stream2.Write(buffer, 0, buffer.Length);
            stream2.FlushFinalBlock();
            byte[] inArray = stream.ToArray();
            stream.Close();
            stream2.Close();
            return Convert.ToBase64String(inArray);
        }
    }
}
