using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Security.Cryptography;
using System.IO;

namespace Rijndael
{
    class Program
    {
        static void Main(string[] args)
        {
            string cyphertext = "XbJtpqjjLusc6phWGICNv3NMNnKz5Q5x3OarSU7N8nlUdVBKd9RSAeIfIrmpknX8s6ko3B2Hih6xDxnGcFN7fLPIcLzr1sRop2kX7bFMTYzSmbXg0Lf4I0willy7hImJLXx3wHEGr/42VvcMBu8l17s7lCb+H7IlX0NVfqMZ2HSSQxIvxVXdDi09WgDX16npARpzrFqremlbob4kl97dw7BMzQQnMPao632iLajpeu7mWjnFvBj86FObKQd+Qe45jvn4iZ9b30ahTr77Khkk8ckelpkHHzndeSbYm5FysZ9C1omUYzQ4tuIixZVZ5VQCJ8vNvXfXjPD7RAiWMnVQutqRGgGJUZguzBcAHXtq9EAVKxtK+nbkX9dMfbELVStG";
            string initvector = "78x3s65a6de9d241";
            string passphrase = "d2c7cb7s5a74a48c";

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
            byte[] rgbKey = new PasswordDeriveBytes(passphrase, null).GetBytes(32);

            ICryptoTransform transform = new RijndaelManaged { Mode = CipherMode.CBC }.CreateDecryptor(rgbKey, bytes);

            Console.WriteLine(rgbKey.Length.ToString());
            //Console.WriteLine(System.Text.Encoding.UTF8.GetString(rgbKey));

            MemoryStream stream = new MemoryStream(buffer);
            CryptoStream stream2 = new CryptoStream(stream, transform, CryptoStreamMode.Read);
            byte[] buffer4 = new byte[buffer.Length];
            int count = stream2.Read(buffer4, 0, buffer4.Length);
            stream.Close();
            stream2.Close();
            //Console.WriteLine(Encoding.UTF8.GetString(buffer4, 0, count));
        }
    }
}
