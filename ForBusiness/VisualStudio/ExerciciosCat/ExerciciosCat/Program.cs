using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;

namespace ExerciciosCat
{
    class Program
    {
        static void Main(string[] args)
        {
            int num1 = Int32.Parse(Console.ReadLine());
            int num2 = Int32.Parse(Console.ReadLine());

            if (num1 > num2)
            {
                for (int i = num2+1; i < num1; i++)
                {
                    Console.Write(i + " ");
                }
                Console.WriteLine("o num1 > num2");
            }
            if (num2 > num1)
            {
                for (int i = num1+1; i < num2; i++)
                {
                    Console.Write(i + " ");
                }
                Console.WriteLine("o num2 > num1");
            }
            
            Console.ReadKey();
        }
    }
}
