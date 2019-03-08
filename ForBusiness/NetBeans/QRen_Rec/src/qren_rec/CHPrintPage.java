package fme;

import java.awt.print.PrinterJob;












class CHPrintPage
{
  static PrinterJob pj = ;
  
  CHPrintPage() {
    pj = PrinterJob.getPrinterJob();
  }
  
  static boolean setup() {
    return pj.printDialog();
  }
}
