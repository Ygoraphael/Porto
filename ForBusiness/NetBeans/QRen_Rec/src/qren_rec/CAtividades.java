package fme;

import java.util.Vector;



























































































































































































































































































































































































































































































































































































































































class CAtividades
  extends CTabela
{
  CAtividades()
  {
    name = "Atividades";
    cCol = 0;
    dCol = 1;
  }
  
  void refresh() {
    data_table.clear();
    
    for (int i = 0; i < Atividadesdados.size(); i++) {
      String accao = CBData.Atividades.getColValue("atividade", i);
      if (accao.length() > 0) {
        String[] d = new String[3];
        d[0] = accao;
        d[1] = CBData.Atividades.getColValue("design", i);
        d[2] = CBData.Atividades.getColValue("tipologia", i);
        data_table.add(d);
      }
    }
  }
}