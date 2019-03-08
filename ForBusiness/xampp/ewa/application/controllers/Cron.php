<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cron extends CI_Controller {

	public function index()
	{
	}
	
	public function AgentPaymentCron()
	{
		$this->load->library('multibanco');
		$this->load->model('phc_model');
		
		$ifmb_chaveBO = '0161-1659-8885-9206';
		$ifmb_entidade = '11988';
		$ifmb_subentidade = '287';
		$ifmb_data_hora_inicio = date('d-m-Y H:i',(strtotime('-5 day' ,strtotime(date('d-m-Y 00:00')))));
		$ifmb_data_hora_fim = date('d-m-Y 23:59');
		$ifmb_referencia = '';
		$ifmb_valor = '';
		$ifmb_sandbox = 1; //0 - Ambiente de Produção 1 - Ambiente de Testes
		
		//Invocação da função de chamada ao Webservice
		$resultado = $this->multibanco->getPayments($ifmb_chaveBO, $ifmb_entidade, $ifmb_subentidade, $ifmb_data_hora_inicio, $ifmb_data_hora_fim, $ifmb_referencia, $ifmb_valor, $ifmb_sandbox);

		foreach($resultado as $item)
		{
			$this->phc_model->reimbursement_mb_set_processed($item->Referencia);
		}
		
		$this->phc_model->reimbursement_mb_clean_old();
	}
	
}
