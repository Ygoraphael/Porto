package fme;

abstract interface CBData_Comum
{
  public abstract void locate(CHValid_Msg paramCHValid_Msg);
  
  public abstract String getPagina();
  
  public abstract String getParam(String paramString);
  
  public abstract void on_external_update(String paramString);
}
