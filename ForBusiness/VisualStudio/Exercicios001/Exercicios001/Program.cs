using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;

namespace Exercicios001
{
    class Program
    {
        static void Main(string[] args)
        {

            exe26();

            Console.ReadLine();

        }

        static void exe26()
        {
            int num;
            Console.WriteLine("Escolha um numero: ");
            num = Int32.Parse( Console.ReadLine() );
            if (num >= 1 && num <= 10)
            {
                int i;
                int j = 0;
                for (i = 0; i <= 100; i++)
                {
                    if (j == num-1)
                    {
                        Console.WriteLine(i + " ");
                        j = 0;
                    }
                    else
                    {
                        Console.Write(i + " ");
                        j++;
                    }
                }
            }
        }

        static void exe25()
        {
            int num;
            int i;

            num = Int32.Parse(Console.ReadLine());

            if (num > 0 && num <= 9)
            {
                for (i = 1; i <= 10; i++)
                {
                    Console.WriteLine(num + "x" + i + "=" + num * i);
                }
            }
            else
            {
                Console.WriteLine("erro cenas 1 e 9");
            }
        }

        static void ex2324()
        {
            //for           para
            //while         enquanto
            //foreach       para cada um

            //i++ ---> i = i + 1

            int i;
            for (i = 1; i < 11; i++)
            {
                //aqui corre o codigo do ciclo
                Console.Write(i + " ");
            }

            Console.WriteLine();

            for (i = 10; i > 0; i--)
            {
                //aqui corre o codigo do ciclo
                Console.Write(i + " ");
            }

            Console.WriteLine();

            i = 1;
            while (i <= 10)
            {
                Console.Write(i + " ");
                i++;
            }

            Console.WriteLine();

            i = 10;
            while (i >= 1)
            {
                Console.Write(i + " ");
                i--;
            }

            Console.WriteLine();

            int x;
            int y;
            int a;

            x = Int32.Parse(Console.ReadLine());
            y = Int32.Parse(Console.ReadLine());

            if (x > y)
            {
                a = x;
                x = y;
                y = a;

                Console.WriteLine("O maior é o " + y);
            }
            else
            {
                Console.WriteLine("O maior é o " + y);
            }

            for (i = x + 1; i < y; i++)
            {
                Console.Write(i + " ");
            }
        }
    }
}
