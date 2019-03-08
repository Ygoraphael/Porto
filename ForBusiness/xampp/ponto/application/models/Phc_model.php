<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Phc_model class.
 * 
 * @extends CI_Model
 */
class Phc_model extends CI_Model {
	
	private $ndos = 4;
	private $nmdos = 'Encomenda';
	private $no = 2;
	
	/**
	 * __construct function.
	 * 
	 * @access public
	 * @return void
	 */
	public function __construct() {
		parent::__construct();
		
		$this->load->database();
	}
	
	public function get_adoc( $adoc, $data,$no ) {
		$query = "Select * from fo where adoc ='".$adoc."' and no = ".$no." and year(data)=year(convert(datetime, replace('".$data."', '-', ''))) ";
		$sql_status = $this->mssql->mssql__select( $query );
		return $sql_status;
	}	
		
	
	public function add_fee_receipts( $data ) {

        $query = "
         BEGIN TRANSACTION [Tran1];
         BEGIN TRY 

         declare 
			@adoc varchar(20), @no decimal(10), @valor decimal(16,6), @data datetime, @design varchar(60), 
			@fostamp varchar(25), @fnstamp varchar(25), @ref varchar(18), 
			@eivain decimal(16,6), @eivav2 decimal(16,6), @ettiva decimal(16,6), @tabiva decimal(5), @iva decimal(5), @u_docpath varchar(254)

            set @adoc = '".$data['adoc']."'
            set @no = ".$data['no']."
            set @valor = ".$data['value']."
            set @data = convert(datetime, replace('".$data['date']."', '-', ''))
            set @design = '".$data['description']."'
            set @u_docpath = '".$data['file']."'

            set @fostamp = suser_sname()+left(newid(),5)+right(newid(),5)+ left(newid(),5)+right(newid(),5) 
            set @fnstamp = suser_sname()+left(newid(),5)+right(newid(),5)+ left(newid(),5)+right(newid(),5)
            set @ref = 'COMAG'

            select 
                @eivain = round(@valor/(1+(case when isnull(taxasiva.codigo, 2)= 0 then 23 else isnull(taxasiva.taxa, 23) end)/100), 2),
                @eivav2 = case 
					when (case when isnull(taxasiva.codigo, 2)= 0 then 2 else isnull(taxasiva.codigo, 2) end) = 2 
					then @valor - round(@valor/(1+(case when isnull(taxasiva.codigo, 2)= 0 then 23 else isnull(taxasiva.taxa, 23) end)/100), 2) 
					else 0 
				end, 
                @ettiva = @valor - round(@valor/(1+(case when isnull(taxasiva.codigo, 2)= 0 then 23 else isnull(taxasiva.taxa, 23) end)/100), 2),
                @tabiva = (case when isnull(taxasiva.codigo, 2)= 0 then 2 else isnull(taxasiva.codigo, 2) end),
                @iva = (case when isnull(taxasiva.codigo, 2)= 0 then 23 else isnull(taxasiva.taxa, 23) end)
            from fl left join taxasiva (nolock) on fl.tabiva = taxasiva.codigo

            where no = @no and estab = 0
         ";                                            
         
         
         $query .= "
                  INSERT INTO dbo.fo 
                  ( 
                        fostamp, 
                        docnome, 
                        adoc, 
                        nome, 
                        etotal, 
                        data, 
                        docdata, 
                        foano, 
                        doccode, 
                        no, 
                        estab, 
                        moeda, 
                        pdata, 
                        eivain, 
                        ettiva, 
                        ettiliq,
                        epaivav2, 
                        epaivain, 
                        epatotal, 
                        memissao, 
                        eivav2, 
                        morada, 
                        local, 
                        codpost, 
                        ncont, 
                        nome2, 
                        ousrinis, 
                        ousrdata, 
                        ousrhora, 
                        usrinis, 
                        usrdata, 
                        usrhora,
						u_docpath
                  ) 
                  select
                        @fostamp, 
                        isnull((select top 1 cmdesc from cm1 (nolock) where cm=100), ''), 
                        @adoc, 
                        fl.nome, 
                        @valor, 
                        @data, 
                        @data, 
                        year(@data), 
                        100, 
                        fl.no, 
                        0, 
                        'EURO', 
                        @data, 
                        @eivain, 
                        @ettiva, 
                        @eivain, 
                        @eivav2,
                        @eivain,  
                        @valor, 
                        'EURO', 
                        @eivav2, 
                        fl.morada, 
                        fl.local, 
                        fl.codpost, 
                        fl.ncont, 
                        fl.nome2, 
                        isnull((select iniciais from us (nolock) where username= suser_sname()), ''),
                        convert(date, getdate()), 
                        left(convert(time, getdate()),8),
                        isnull((select iniciais from us (nolock) where username= suser_sname()), ''),
                        convert(date, getdate()), 
                        left(convert(time, getdate()),8),
						@u_docpath
                  from fl (nolock) 
                  where no = @no and estab = 0

                  INSERT INTO dbo.fo2
                  (
                        fo2stamp, 
                        ivatx1, 
                        ivatx2, 
                        ivatx3, 
                        olcodigo, 
                        taxpointdt
                  )
                  values
                  (
                        @fostamp,
                        6, 
                        23, 
                        13, 
                        'P00001',
                        @data
                  )

                  INSERT INTO dbo.fot
                  (
                        fotstamp, 
                        fostamp,
                        codigo, 
                        ebaseinc, 
                        evalor
                  )
                  values
                  (
                        suser_sname()+left(newid(),5)+right(newid(),5)+ left(newid(),5)+right(newid(),5), 
                        @fostamp,
                        @tabiva, 
                        @eivain,  
                        @ettiva
                  )


                  INSERT INTO dbo.fn
                  (
                        fnstamp,
                        fostamp,
                        lordem,
                        ref, 
                        design, 
                        docnome, 
                        adoc, 
                        qtt, 
                        iva, 
                        tabiva, 
                        armazem, 
                        lrecno, 
                        data, 
                        etiliquido, 
                        epv, 
                        eslvu, 
                        esltt,
                        stns, 
                        familia, 
                        ousrinis, 
                        ousrdata, 
                        ousrhora, 
                        usrinis, 
                        usrdata, 
                        usrhora 
                  )
                  values
                  (
                        @fnstamp, 
                        @fostamp,
                        1000,
                        @ref, 
                        @design, 
                        isnull((select top 1 cmdesc from cm1 (nolock) where cm=100), ''), 
                        @adoc, 
                        1, 
                        @iva,
                        @tabiva, 
                        1, 
                        @fnstamp, 
                        @data, 
                        @eivain, 
                        @eivain, 
                        @eivain, 
                        @eivain, 
                        isnull((select stns from st (nolock) where ref = @ref), 0),
                        isnull((select familia from st (nolock) where ref = @ref), ''),
                        isnull((select iniciais from us (nolock) where username= suser_sname()), ''),
                        convert(date, getdate()), 
                        left(convert(time, getdate()),8),
                        isnull((select iniciais from us (nolock) where username= suser_sname()), ''),
                        convert(date, getdate()), 
                        left(convert(time, getdate()),8)
                  )";
         
         $query .= ";

         COMMIT TRANSACTION [Tran1] 
         END TRY 
         BEGIN CATCH 
         ROLLBACK TRANSACTION [Tran1] 
         PRINT ERROR_MESSAGE() 
         END CATCH
         ";
         
         $sql_status = $this->mssql->mssql__execute( $query );
         return $sql_status;
    }
	
	public function get_drivefx_credential( $op ) {
		$query = "
			select U_DFXCOMP, U_DFXPASS, U_DFXTYPE, U_DFXURL, U_DFXUSER, U_FTAUTO, cae
			from fl (nolock) 
			where 
				u_operador = 'Sim' and 
				no = ".$op." and estab = 0
		";
		$result = $this->mssql->mssql__select( $query );
		return $result;
	}
	
	public function get_agent_fees( $data ) {
		$query = "
				select 
					op.nome agnome, 
					prod.u_name pdnome,
					ft.fdata, 
					ft.fno,
					sum(fi.qtt) qtt,
					avg(case when fi.qtt != 0 then fi.etiliquido/fi.qtt else 0 end) epv, 
					sum(fi.etiliquido) ettiliq,
					sum(fi.etiliquido)*agpcom/100 agcom,
					sum(fi.etiliquido)*s4bpcom/100 s4bcom,
					sum(fi.etiliquido)*s4ppcom/100 + s4pvcom s4pcom,
					sum(fi.etiliquido)*agpcom/100 trec,
					processado,
					case when enc2.IDENTIFICACAO2= 'CASH' then sum(fi.etiliquido) else 0 end tpag,
					enc2.email
				from 
					ft (nolock)
						inner join fi		(nolock) on ft.ftstamp = fi.ftstamp
						inner join u_ccom	(nolock)  on ft.ftstamp=u_ccom.ftstamp
						inner join bo		(nolock) enc on ft.mhstamp = enc.bostamp
						inner join bo2		(nolock) enc2 on enc.bostamp =enc2.bo2stamp
						inner join bo		(nolock) prod on enc.origem = prod.bostamp 
						inner join fl		(nolock) ag on enc2.TKHDID = ag.no and ag.estab = 0
						inner join fl		(nolock) op on enc2.nocts = op.no and op.estab = 0 
				where 
						ft.anulado = 0 
					and (ft.tipodoc not in (4,5) or ft.ndoc = 10)
					and ((not '".$data[0]."' != '') or (ft.fdata >= '".$data[0]."'))
					and ((not '".$data[1]."' != '') or (ft.fdata <= '".$data[1]."'))
					and ((not '".$data[2]."' != '') or (op.flstamp = '".$data[2]."'))
					and ((not '".$data[3]."' != '') or (prod.bostamp = '".$data[3]."'))
					and ((not '".$data[5]."' != '') or (fi.tam = '".$data[5]."'))
					and ag.no='".$data[4]."' --AGENT
				group by 
					op.nome, 
					prod.u_name,
					ft.fdata, 
					ft.fno,
					ft.etotal,
					agpcom,
					s4bpcom,
					s4ppcom,
					s4pvcom,
					processado,
					enc2.email,
					enc2.IDENTIFICACAO2
				order by 
					op.nome, 
					prod.u_name,
					ft.fdata, 
					ft.fno

			";
		$sql_status = $this->mssql->mssql__select( $query );
		return $sql_status;
		
	}
	
	public function get_agent_sales( $data ) {
		$query = "
				select 
					isnull((select nome from fl where no=enc2.nocts and estab = 0), '') opnome,  
					enc2.NOCTS opno, 
					prod.u_name pdnome,
					ft.fdata, 
					ft.fno,
					sum(fi.qtt) qtt,
					avg(case when fi.qtt != 0 then fi.etiliquido/fi.qtt else 0 end) epv, 
					sum(fi.etiliquido) ettiliq,
					enc2.email
					from 
						ft (nolock)
							inner join fi (nolock) on ft.ftstamp = fi.ftstamp
							inner join bo (nolock) enc on ft.mhstamp = enc.bostamp
							inner join bo2 (nolock) enc2 on enc.bostamp =enc2.bo2stamp
							inner join bo (nolock) prod on enc.origem = prod.bostamp 
							inner join fl (nolock) ag on enc2.TKHDID = ag.no and ag.estab = 0          
							
				where 
						ft.anulado = 0 
					and (ft.tipodoc not in (4,5) or ft.ndoc = 10)
					and ((not '".$data[0]."' != '') or (ft.fdata >= '".$data[0]."'))
					and ((not '".$data[1]."' != '') or (ft.fdata <= '".$data[1]."'))
					and ((not '".$data[2]."' != '') or (isnull((select flstamp from fl where no=enc2.nocts and estab = 0), '') = '".$data[2]."'))
					and ((not '".$data[3]."' != '') or (prod.bostamp = '".$data[3]."'))
					and ag.no =".$data[4]." --OPERADOR
				group by 
					enc2.nomects, 
					prod.u_name,
					ft.fdata, 
					ft.fno,
					enc2.nocts,
					enc2.email
				order by 
					enc2.nomects,
					prod.u_name,
					ft.fdata, 
					ft.fno
			";
		$sql_status = $this->mssql->mssql__select( $query );
		return $sql_status;
		
	}
	
	public function get_resources_usage( $data ) {
		$query = "
				select 
					MAX(u_name) Product,
					date_start Start_Date,
					date_end End_Date,
					prec_ref Ref,
					MAX(prec_design) Design,
					SUM(rec_used) Res_Used
				from 
				(
				select 
					prod.u_name,
					prod.obrano,
					cast(enc3.u_sessdate as datetime) + cast(u_psess.ihour as datetime) date_start,
					case
						when prod3.u_estidurt = 'Hours' then dateadd(HOUR, prod3.u_estimdur, cast(enc3.u_sessdate as datetime) + cast(u_psess.ihour as datetime))
						when prod3.u_estidurt = 'Minutes' then dateadd(MINUTE, prod3.u_estimdur, cast(enc3.u_sessdate as datetime) + cast(u_psess.ihour as datetime))
						when prod3.u_estidurt = 'Days' then dateadd(DAY, prod3.u_estimdur, cast(enc3.u_sessdate as datetime) + cast(u_psess.ihour as datetime))
						else cast(enc3.u_sessdate as datetime) + cast(u_psess.ihour as datetime)
					end date_end,
					case 
						when cast(enc3.u_sessdate as datetime) + cast(u_psess.ihour as datetime) >= cast('" . $data[0] . "' as datetime) + cast('09:00' as datetime) and 
							case
								when prod3.u_estidurt = 'Hours' then dateadd(HOUR, prod3.u_estimdur, cast(enc3.u_sessdate as datetime) + cast(u_psess.ihour as datetime))
								when prod3.u_estidurt = 'Minutes' then dateadd(MINUTE, prod3.u_estimdur, cast(enc3.u_sessdate as datetime) + cast(u_psess.ihour as datetime))
								when prod3.u_estidurt = 'Days' then dateadd(DAY, prod3.u_estimdur, cast(enc3.u_sessdate as datetime) + cast(u_psess.ihour as datetime))
								else cast(enc3.u_sessdate as datetime) + cast(u_psess.ihour as datetime)
							end <= cast('" . $data[1] . "' as datetime) + cast('23:59' as datetime) then 1
						else 0
					end enc_colision,
					u_prec.ref prec_ref,
					u_prec.design prec_design,
					case 
						when u_prec.varbilh = 1 then bi.qtt*u_prec.qtt
						else u_prec.qtt
					end rec_used
				from bo enc
					inner join bo prod on enc.origem = prod.bostamp
					inner join bo2 enc2 on enc.bostamp = enc2.bo2stamp
					inner join bo3 enc3 on enc.bostamp = enc3.bo3stamp
					inner join bo3 prod3 on prod.bostamp = prod3.bo3stamp
					inner join bi on enc.bostamp = bi.bostamp
					inner join u_psess on u_psess.u_psessstamp = enc3.u_psessstp
					inner join u_prec on u_prec.bostamp = prod.bostamp
					inner join bo rec on rec.no = " . $data[4] . " and rec.estab = 0 and rec.ndos = 3
					inner join bi recbi on rec.bostamp = recbi.bostamp and recbi.ref = u_prec.ref
				where
					enc.ndos = 4 and
					prod.no = " . $data[4] . " and prod.estab = 0 and
					enc2.ngstatus = 'PROCESSED' 
		";
		
		if( trim($data[2]) != "" )
			$query .= " AND u_prec.ref = '" . trim($data[2]) . "' ";
		
		if( trim($data[3]) != "" )
			$query .= " AND prod.bostamp = '" . trim($data[3]) . "' ";
		
		$query .= "
				) x 
				where x.enc_colision = 1
				group by
					obrano,
					date_start,
					date_end,
					prec_ref
			";
		
		// log_message("ERROR", $query);
		
		$sql_status = $this->mssql->mssql__select( $query );
		return $sql_status;
		
	}
	
	public function delete_extra( $id, $op ) {
		$update_values = array();
		$update_values[] = "R." . $op . "." . $id;
		
		$query = "delete from stobs where ref = ?";
		$sql_status = $this->mssql->mssql__prepare_exec( $query, $update_values );
		
		$query = "delete from st where ref = ?";
		$sql_status = $this->mssql->mssql__prepare_exec( $query, $update_values );
		
		$query = "delete from u_prec where ref = ?";
		$sql_status = $this->mssql->mssql__prepare_exec( $query, $update_values );
		
		$update_values[] = $op;
		$query = "delete from bi where ref = ? and ndos = 3 and no = ?";
		$sql_status = $this->mssql->mssql__prepare_exec( $query, $update_values );
		
		return $sql_status;
	}

	public function update_extras( $data, $op ) {
		
		$res_update = array();
		$data['extras'] = json_decode($data['extras']);
		$this->mssql->utf8_decode_deep( $data['extras'] );
		
		foreach( $data['extras'] as $extra ) {
			$cria_extra = 0;
			if( trim($extra[1]) != '' ) {
				$query = "
					select bi.ref, bi.bistamp
					from bo (nolock) inner join bi (nolock) on bo.bostamp = bi.bostamp
					where 
						bo.ndos = 3 and
						bo.no = ".$op." and
						ref = 'R.' + rtrim(ltrim(convert(varchar(15), bo.no))) + '.".$extra[1]."'
				";
				$result = $this->mssql->mssql__select( $query );
				if( sizeof($result)>0 ) {
					//se id existir, update bi
					$update_values = array();
					$update_values[] = $result[0]['bistamp'];
					
					$query = "update bi set qtt = " . $extra[3] . ", design = '".$extra[2]."' where bistamp = ?";
					$sql_status = $this->mssql->mssql__prepare_exec( $query, $update_values );
					
					//se id existir, update st
					$update_values = array();
					$update_values[] = $result[0]['ref'];
					
					$query = "update st set design = '".$extra[2]."' where ref = ?";
					$sql_status = $this->mssql->mssql__prepare_exec( $query, $update_values );
				}
				else {
					$cria_extra = 1;
				}
			}
			else {
				$cria_extra = 1;
			}
			
			if( $cria_extra ) {
				//ver proximo id
				
				$query = "
					select ref
					from st
					where ref like 'R.".$op.".%'
				";
				$result = $this->mssql->mssql__select( $query );
				$max_id = 0;
				foreach( $result as $ref ) {
					$cur_id = intval(str_replace("R.".$op.".", "", $ref["ref"]));
					if( $cur_id > $max_id )
						$max_id = $cur_id;
				}
				$max_id++;
				//st
				$update_values = array();
				$update_values[] = "R." . $op . "." . $max_id;
				$update_values[] = substr(trim($extra[2]), 0, 60);
				$update_values[] = 'RECURSOS';
				$update_values[] = 'Recursos';
				$update_values[] = 1;
				$update_values[] = 1;
				$update_values[] = $op;
				$update_values[] = $op;
				$update_values[] = 0;
				
				$query = "insert into st (
					ststamp,
					ref,
					design,
					familia,
					faminome,
					stns,
					iva1incl,
					fornec,
					fornecedor,
					texteis,
					tabiva,
					ousrdata,
					ousrhora,
					ousrinis,
					usrdata,
					usrhora,
					usrinis
				) values (
					CONVERT(VARCHAR(25), (select UPPER(suser_sname())+left(newid(),5)+right(newid(),5)+ left(newid(),5)+right(newid(),5))),
					?,
					?,
					?,
					?,
					?,
					?,
					?,
					isnull((select nome from fl where no = ? and estab = 0), ''),
					?,
					2,
					CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000', 
					CONVERT(VARCHAR(5), GETDATE(), 8), 
					UPPER(suser_sname()), 
					CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000', 
					CONVERT(VARCHAR(5), GETDATE(), 8),
					UPPER(suser_sname())
				) 
				";
				
				$sql_status = $this->mssql->mssql__prepare_exec( $query, $update_values );
				
				//stobs
				$update_values = array();
				$update_values[] = "R." . $op . "." . $max_id;
				$update_values[] = 'O';
				
				$query = "insert into stobs (
					stobsstamp,
					ref,
					tipoprod,
					u_bostamp,
					ousrdata,
					ousrhora,
					ousrinis,
					usrdata,
					usrhora,
					usrinis
				) values (
					CONVERT(VARCHAR(25), (select UPPER(suser_sname())+left(newid(),5)+right(newid(),5)+ left(newid(),5)+right(newid(),5))),
					?,
					?,
					isnull((select bostamp from bo where bo.ndos = 3 and bo.no = ".$op."), ''),
					CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000', 
					CONVERT(VARCHAR(5), GETDATE(), 8), 
					UPPER(suser_sname()), 
					CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000', 
					CONVERT(VARCHAR(5), GETDATE(), 8),
					UPPER(suser_sname())
				) 
				";
				
				$sql_status = $this->mssql->mssql__prepare_exec( $query, $update_values );
				
				//bi
				$query = "
					select *
					from bo (nolock)
					where 
						bo.ndos = 3 and
						bo.no = ".$op."
				";
				$result = $this->mssql->mssql__select( $query );
				
				if( sizeof($result)>0 )
					$result = $result[0];
				
				$update_values = array();
				$update_values[] = "R." . $op . "." . $max_id;
				$update_values[] = substr(trim($extra[2]), 0, 60);
				$update_values[] = $extra[3];
				$update_values[] = 'Recurso';
				$update_values[] = $op;
				$update_values[] = 2;
				$update_values[] = 1;
				$update_values[] = 4;
				$update_values[] = $op;
				$update_values[] = 3;
				$update_values[] = $result['dataobra'];
				$update_values[] = $result['dataobra'];
				$update_values[] = $result['dataobra'];
				$update_values[] = 1;
				$update_values[] = $result['local'];
				$update_values[] = $result['morada'];
				$update_values[] = $result['codpost'];
				$update_values[] = $result['nome'];
				$update_values[] = $result['bostamp'];
				
				$query = "insert into bi (
					bistamp,
					ref,
					design,
					qtt,
					nmdos,
					obrano,
					iva,
					tabiva,
					armazem,
					stipo,
					no,
					ndos,
					rdata,
					dataopen,
					dataobra,
					resusr,
					lordem,
					local,
					morada,
					codpost,
					nome,
					bostamp,
					ousrdata,
					ousrhora,
					ousrinis,
					usrdata,
					usrhora,
					usrinis
				) values (
					CONVERT(VARCHAR(25), (select UPPER(suser_sname())+left(newid(),5)+right(newid(),5)+ left(newid(),5)+right(newid(),5))),
					?,
					?,
					?,
					?,
					?,
					isnull((select top 1 taxa from taxasiva where codigo = 2), 23),
					?,
					?,
					?,
					?,
					?,
					?,
					?,
					?,
					?,
					isnull((select max(lordem)+10000 from bi where ndos = 3 and no = $op),10000),
					?,
					?,
					?,
					?,
					?,
					CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000', 
					CONVERT(VARCHAR(5), GETDATE(), 8), 
					UPPER(suser_sname()), 
					CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000', 
					CONVERT(VARCHAR(5), GETDATE(), 8),
					UPPER(suser_sname())
				) 
				";
				
				$sql_status = $this->mssql->mssql__prepare_exec( $query, $update_values );
				
				$res_update[] = array("row" => $extra[0], "id" => $max_id);
			}
		}
		return $res_update;
	}
	
	public function get_product_session_mssql( $bostamp, $op ) {
		$query = "
			select 
				u_psess.*
			from u_psess
				inner join bo on u_psess.bostamp = bo.bostamp
			where
				bo.ndos = 1 and
				bo.no = $op and bo.estab = 0 and bo.bostamp = '".$bostamp."'
		";
		$sessions = $this->mssql->mssql__select( $query );
		return $sessions;
	}
	
	public function create_vouch( $data ) {
		
		$this->mssql->utf8_decode_deep( $data );
		$operator = $data["user"];
		
		$update_values = array();
		
		$data['input'] = json_decode($data['input'],true);
		$data['vouch_table'] = json_decode($data['vouch_table'],true);
		$u_vouchstamp = $this->product_model->stamp();
		
		//input
		foreach( $data['input']["u_vouch"] as $key=>$value ) {
			//$update_query .= $key . " = ?, ";
			$update_values[] = $value;
		}
		
		$query = "
		insert into u_vouch (
			u_vouchstamp,
			no,
			code,
			design,
			type,
			value,
			useqtt,
			validity,
			ousrdata,
			ousrhora,
			ousrinis,
			usrdata,
			usrhora,
			usrinis
		) values (
			'".$u_vouchstamp."',
			".$operator['no'].",
			?,
			?,
			?,
			?,
			?,
			?,
			CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000', 
			CONVERT(VARCHAR(5), GETDATE(), 8), 
			UPPER(suser_sname()), 
			CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000', 
			CONVERT(VARCHAR(5), GETDATE(), 8),
			UPPER(suser_sname())
		)		
		";
		
		$sql_status = $this->mssql->mssql__prepare_exec( $query, $update_values );
		
		//cria em pvouch
		foreach($data['vouch_table'] as $pvouch){
			
			if($pvouch[1] == "1"){
				$query = "
				insert into u_pvouch (
					u_pvouchstamp,
					u_vouchstamp,
					bostamp,
					no,
					code,
					design,
					type,
					value,
					useqtt,
					validity,
					ousrdata,
					ousrhora,
					ousrinis,
					usrdata,
					usrhora,
					usrinis
				) values (
					CONVERT(VARCHAR(25), (select UPPER(suser_sname())+left(newid(),5)+right(newid(),5)+ left(newid(),5)+right(newid(),5))),
					'".$u_vouchstamp."',
					'".$pvouch[0]."',
					".$operator['no'].",
					?,
					?,
					?,
					?,
					?,
					?,
					CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000', 
					CONVERT(VARCHAR(5), GETDATE(), 8), 
					UPPER(suser_sname()), 
					CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000', 
					CONVERT(VARCHAR(5), GETDATE(), 8),
					UPPER(suser_sname())
				)		
				";
				
				$sql_status = $this->mssql->mssql__prepare_exec( $query, $update_values );
			}
			
		}
				
	
		
		
		$result = array();
		$result["success"] = 1;
		
		echo json_encode( $result );
	}
	
	public function update_vouch( $data ) {
		
		$this->mssql->utf8_decode_deep( $data );
		$operator = $data["user"];
		
		$update_values = array();
		
		$data['input'] = json_decode($data['input'],true);
		$data['vouch_table'] = json_decode($data['vouch_table'],true);
		$u_vouchstamp = $data['u_vouchstamp'];
		
		//input
		foreach( $data['input']["u_vouch"] as $key=>$value ) {
			//$update_query .= $key . " = ?, ";
			$update_values[] = $value;
		}
				
		$query = "update u_vouch set code = ?, design = ?, type = ?,value= ?, useqtt= ?,validity = ?  where no = ".$operator['no']." and u_vouchstamp = '".$data['u_vouchstamp']."' ";
		
		$sql_status = $this->mssql->mssql__prepare_exec( $query, $update_values );
		
		//elimina dados_email
		foreach($data['vouch_table'] as $pvouch){
		$query = "delete from u_pvouch where no = ".$operator['no']." and u_vouchstamp = '".$u_vouchstamp."' and bostamp = '".$pvouch[0]."' ";
		
		$sql_status = $this->mssql->mssql__prepare_exec( $query, $update_values );
		
		}
		
		//cria em pvouch
		foreach($data['vouch_table'] as $pvouch){
			
			if($pvouch[1] == "1"){
				$query = "
				insert into u_pvouch (
					u_pvouchstamp,
					u_vouchstamp,
					bostamp,
					no,
					code,
					design,
					type,
					value,
					useqtt,
					validity,
					ousrdata,
					ousrhora,
					ousrinis,
					usrdata,
					usrhora,
					usrinis
				) values (
					CONVERT(VARCHAR(25), (select UPPER(suser_sname())+left(newid(),5)+right(newid(),5)+ left(newid(),5)+right(newid(),5))),
					'".$u_vouchstamp."',
					'".$pvouch[0]."',
					".$operator['no'].",
					?,
					?,
					?,
					?,
					?,
					?,
					CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000', 
					CONVERT(VARCHAR(5), GETDATE(), 8), 
					UPPER(suser_sname()), 
					CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000', 
					CONVERT(VARCHAR(5), GETDATE(), 8),
					UPPER(suser_sname())
				)		
				";
				
				$sql_status = $this->mssql->mssql__prepare_exec( $query, $update_values );
			}
			
		}
				
	
		
		
		$result = array();
		$result["success"] = 1;
		
		echo json_encode( $result );
	}
	
	public function delete_vouch( $data ) {
		
		$this->mssql->utf8_decode_deep( $data );
		$operator = $data["user"];
		
		$update_values = array();
		
		$data['vouch_table'] = json_decode($data['vouch_table'],true);
		$u_vouchstamp = $data['u_vouchstamp'];
	
				
		$query = "delete from u_vouch where no = ".$operator['no']." and u_vouchstamp = '".$u_vouchstamp."'";
		
		$sql_status = $this->mssql->mssql__prepare_exec( $query, $update_values );
		
		//elimina dados_email
		foreach($data['vouch_table'] as $pvouch){
		$query = "delete from u_pvouch where no = ".$operator['no']." and u_vouchstamp = '".$u_vouchstamp."' and bostamp = '".$pvouch[0]."' ";
		
		$sql_status = $this->mssql->mssql__prepare_exec( $query, $update_values );
		
		}
		
		
		$result = array();
		$result["success"] = 1;
		
		echo json_encode( $result );
	}
	
	public function get_profile( $no, $estab ) {
		$query = "
			select 
				*
			from fl
			where
			no = '".$no."' and estab = " . $estab . "
		";
		$sessions = $this->mssql->mssql__select( $query );
		return $sessions;
	}
	
	public function get_agent_operators( $no, $estab ) {
		$query = "
			select
				distinct op.flstamp, op.no, op.estab, op.nome
			from fl ag
				inner join u_agop on ag.flstamp = u_agop.agstamp
				inner join fl op on op.flstamp = u_agop.opstamp
			where
				ag.no = '".$no."' and ag.estab = '".$estab."'
		";
		$operators = $this->mssql->mssql__select( $query );
		return $operators;
	}
	
	public function get_vouchers( $no) {
		$query = "
			select 
				*
			from u_vouch
			where
			no = '".$no."'
		";
		$sessions = $this->mssql->mssql__select( $query );
		return $sessions;
	}
	
	public function get_vouchers_stamp( $no,$stamp) {
		$query = "
			select 
				*
			from u_vouch
			where
			no = '".$no."'and
			u_vouchstamp = '".$stamp."'
		";
		$sessions = $this->mssql->mssql__select( $query );
		return $sessions;
	}
	
	public function get_pvouchers_stamp( $no,$u_vouchstamp) {
		$query = "
			select 
				*
			from u_pvouch
			where
			no = '".$no."'and
			u_vouchstamp = '".$u_vouchstamp."'
		";
		$sessions = $this->mssql->mssql__select( $query );
		return $sessions;
	}
	
	public function get_languages() {
		$query = "
			select ltrim(rtrim(u_lang.language)) language
			from u_lang
		";
		$sessions = $this->mssql->mssql__select( $query );
		return $sessions;
	}
	
	
	public function get_extras_mssql( $op ) {
		$query = "
			select 
				bi.*,
				st.*
			from bo
				inner join bi on bo.bostamp = bi.bostamp
				inner join st on bi.ref = st.ref
			where
				bo.ndos = 3 and
				bo.no = $op and bo.estab = 0
		";
		$extras = $this->mssql->mssql__select( $query );
		return $extras;
	}
	
	public function dissociate_op_agent( $vat, $op_id ) {
		$this->load->model('product_model');
		
		$result = array();
		$this->mssql->utf8_decode_deep( $vat );
		
		$query = "select top 1 ncont, nome, flstamp, no from fl where no = ".$op_id . " and estab = 0";
		$op_data = $this->mssql->mssql__select( $query );
		
		$query = "select top 1 ncont, nome, flstamp, no from fl where ncont = '".$vat."'" . " and estab = 0";
		$agent_data = $this->mssql->mssql__select( $query );
		
		if( sizeof($op_data) > 0 && sizeof($agent_data) > 0 ) {
		
			// remover associacoes agente com produtos do operador
			$update_values = array();
			$update_values[] = $agent_data[0]['no'];
			$update_values[] = $op_data[0]['no'];
			$query = "delete from u_pagent where u_pagent.no = ? and bostamp in (select bostamp from bo where ndos = 1 and bo.no = ?)";
			$sql_status = $this->mssql->mssql__prepare_exec( $query, $update_values );
			
			// remover associacao agente operador
			$update_values = array();
			$update_values[] = $op_data[0]['flstamp'];
			$update_values[] = $agent_data[0]['flstamp'];
			$query = "delete from u_agop where opstamp = ? and agstamp = ?";
			$sql_status = $this->mssql->mssql__prepare_exec( $query, $update_values );
			
			$result['success'] = $sql_status;
			if( !$sql_status ) {
				$result['message'] = 'Agent dissociate procedure error';
			}
			else {
				$result['message'] = 'Agent dissociated successfuly.';
			}
			return $result;
		}
		else {
			$result['success'] = 0;
			$result['message'] = 'Agent not found';
			return $result;
		}
	}
	
	public function create_agent( $data, $op_id ) {
		$this->load->model('product_model');
		
		$result = array();
		
		$data = json_decode($data);
		$this->mssql->utf8_decode_deep( $data );
		
		$query = "select top 1 ncont, nome, flstamp, no from fl where no = ".$op_id. " and estab = 0";
		$op_data = $this->mssql->mssql__select( $query );
		
		$query = "select top 1 ncont, nome, flstamp, no from fl where ncont = '".$data->fl->ncont."'" . " and estab = 0";
		$agent_data = $this->mssql->mssql__select( $query );
		
		//check if agent exists
		if( sizeof($agent_data) > 0 ) {
			$result['success'] = 0;
			$result['message'] = 'An agent with this VAT already exists in our database. Do a association instead';

		}
		else {
			$flstamp = $this->product_model->stamp();
			
			$update_values = array();
			$update_values[] = $flstamp;
			$update_values[] = $data->fl->nome;
			$update_values[] = $data->fl->ncont;
			$update_values[] = $data->fl->email;
			$update_values[] = $data->fl->telefone;
			$update_values[] = utf8_decode('Não');
			$update_values[] = $data->fl->u_local;
			
			$query = "insert into fl (
				flstamp,
				nome,
				no,
				estab,
				moeda,
				ncont,
				email,
				telefone,
				u_autoriz,
				u_agente,
				u_operador,
				u_local,
				ousrdata,
				ousrhora,
				ousrinis,
				usrdata,
				usrhora,
				usrinis
			) values (
				?,
				?,
				(select max(no)+1 from fl),
				0,
				'EURO',
				?,
				?,
				?,
				0,
				'Sim',
				?,
				?,
				CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000', 
				CONVERT(VARCHAR(5), GETDATE(), 8), 
				UPPER(suser_sname()), 
				CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000', 
				CONVERT(VARCHAR(5), GETDATE(), 8),
				UPPER(suser_sname())
			) 
			";
			
			$sql_status = $this->mssql->mssql__prepare_exec( $query, $update_values );
			
			if( $sql_status > 0 ) {
				//associar agente ao operador
				$update_values = array();
					$update_values[] = $op_data[0]['flstamp'];
					$update_values[] = $flstamp;
					$update_values[] = $op_data[0]['nome'];
					
					$query = "insert into u_agop (
						u_agopstamp,
						opstamp,
						agstamp,
						opnome,
						ousrdata,
						ousrhora,
						ousrinis,
						usrdata,
						usrhora,
						usrinis
					) values (
						CONVERT(VARCHAR(25), (select UPPER(suser_sname())+left(newid(),5)+right(newid(),5)+ left(newid(),5)+right(newid(),5))),
						?,
						?,
						?,
						CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000', 
						CONVERT(VARCHAR(5), GETDATE(), 8), 
						UPPER(suser_sname()), 
						CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000', 
						CONVERT(VARCHAR(5), GETDATE(), 8),
						UPPER(suser_sname())
					) 
					";
				
				$sql_status = $this->mssql->mssql__prepare_exec( $query, $update_values );
				
				$result['success'] = $sql_status;
				if( !$sql_status ) {
					$result['message'] = 'Agent creation error';
				}
				else {
					$result['message'] = 'Agent created successfuly. Agent will receive an email when account validated';
				}
			}
			else {
				$result['success'] = 0;
				$result['message'] = 'Agent creation error';
			}
		}
		
		return $result;
	}
	
	public function dashboard_chart($type, $op, $ag, $id) {
		$query = "";
		switch($type) {
			case 1:		
				if ($ag ==1) {
					$query = "						
						select 
							case 
								when ".$op." in (1,2) then convert(varchar(10), fdata, 104)
								when ".$op." in (3,4,5)  then left(DATENAME(month, fdata),3) + case when year(fdata)!=year(getdate()) then ' ' + convert(varchar(10), year(fdata)) else '' end 
								else convert(varchar(10), fdata, 104)
							end periodo,
							sum(ettiliq) valor
							from ft (nolock)
						where 
								anulado = 0 
							and (tipodoc not in (4,5) or ndoc = 10)
							and fdata between
								(
									case 
									when ".$op." = 1 
									then dateadd(day, -7, getdate()) 
									when ".$op." = 2 
									then dateadd(month, -1, getdate()) 
									when ".$op." = 3 
									then dateadd(month, -3, getdate()) 
									when ".$op." = 4
									then dateadd(month, -6, getdate()) 
									when ".$op." = 5
									then dateadd(year, -1, getdate()) 
									end
								)
								and getdate()
								and isnull((select BO2.tkhdid from bo2 where bo2stamp=ft.mhstamp), 0)=".$id."
						group by 
							case 
								when ".$op." in (1,2) then fdata
								when ".$op." in (3,4,5)  then year(fdata)*100 + month(fdata)
								else convert(varchar(10), fdata, 104)
							end,					
							case 
								when ".$op." in (1,2) then convert(varchar(10), fdata, 104)
								when ".$op." in (3,4,5)  then left(DATENAME(month, fdata),3) + case when year(fdata)!=year(getdate()) then ' ' + convert(varchar(10), year(fdata)) else '' end 
								else convert(varchar(10), fdata, 104)
							end

						order by 
							case 
								when ".$op." in (1,2) then fdata
								when ".$op." in (3,4,5)  then year(fdata)*100 + month(fdata)
								else convert(varchar(10), fdata, 104)
							end, 
							case 
								when ".$op." in (1,2) then convert(varchar(10), fdata, 104)
								when ".$op." in (3,4,5)  then left(DATENAME(month, fdata),3) + case when year(fdata)!=year(getdate()) then ' ' + convert(varchar(10), year(fdata)) else '' end 
								else convert(varchar(10), fdata, 104)
							end 
					";
				}
				else {
					$query = "
						select 
							case 
								when ".$op." in (1,2) then convert(varchar(10), fdata, 104)
								when ".$op." in (3,4,5)  then left(DATENAME(month, fdata),3) + case when year(fdata)!=year(getdate()) then ' ' + convert(varchar(10), year(fdata)) else '' end 
								else convert(varchar(10), fdata, 104)
							end periodo,
							sum(ettiliq) valor
							from ft (nolock)
						where 
								anulado = 0 
							and (tipodoc not in (4,5) or ndoc = 10)
							and fdata between
								(
									case 
									when ".$op." = 1 
									then dateadd(day, -7, getdate()) 
									when ".$op." = 2 
									then dateadd(month, -1, getdate()) 
									when ".$op." = 3 
									then dateadd(month, -3, getdate()) 
									when ".$op." = 4
									then dateadd(month, -6, getdate()) 
									when ".$op." = 5
									then dateadd(year, -1, getdate()) 
									end
								)
								and getdate()
								and isnull((select BO2.NOCTS from bo2 where bo2stamp=ft.mhstamp), 0)=".$id."
						group by 
							case 
								when ".$op." in (1,2) then fdata
								when ".$op." in (3,4,5)  then year(fdata)*100 + month(fdata)
								else convert(varchar(10), fdata, 104)
							end,					
							case 
								when ".$op." in (1,2) then convert(varchar(10), fdata, 104)
								when ".$op." in (3,4,5)  then left(DATENAME(month, fdata),3) + case when year(fdata)!=year(getdate()) then ' ' + convert(varchar(10), year(fdata)) else '' end 
								else convert(varchar(10), fdata, 104)
							end

						order by 
							case 
								when ".$op." in (1,2) then fdata
								when ".$op." in (3,4,5)  then year(fdata)*100 + month(fdata)
								else convert(varchar(10), fdata, 104)
							end, 
							case 
								when ".$op." in (1,2) then convert(varchar(10), fdata, 104)
								when ".$op." in (3,4,5)  then left(DATENAME(month, fdata),3) + case when year(fdata)!=year(getdate()) then ' ' + convert(varchar(10), year(fdata)) else '' end 
								else convert(varchar(10), fdata, 104)
							end 

					";		
				}
				$sql_status = $this->mssql->mssql__select($query );			
				break;
			
			case 2:		
				if ($ag ==1) {
					$query = "
						select 
							case 
								when ".$op." in (1,2) then convert(varchar(10), fdata, 104)
								when ".$op." in (3,4,5)  then left(DATENAME(month, fdata),3) + case when year(fdata)!=year(getdate()) then ' ' + convert(varchar(10), year(fdata)) else '' end 
								else convert(varchar(10), fdata, 104)
							end periodo,
							sum( valor*agpcom/100) valor
						from  
						(
							select u_ccom.*, clstamp, fdata, isnull((select 1 from u_pagent where u_pagent.bostamp=u_ccom.pdstamp and u_pagent.no = u_ccom.agno and u_pagent.opstamp=u_ccom.opstamp),0) agop
							from 
								u_ccom (nolock) 
									inner join ft (nolock) on ft.ftstamp=u_ccom.ftstamp
									inner join fl (nolock) on fl.flstamp=u_ccom.opstamp and fl.estab = 0
									inner join cl (nolock) on cl.flno=fl.no and fl.estab = 0
							where 
									processado = 0 
								and  		
								fdata between
								(
									case 
									when ".$op." = 1 
									then dateadd(day, -7, getdate()) 
									when ".$op." = 2 
									then dateadd(month, -1, getdate()) 
									when ".$op." = 3 
									then dateadd(month, -3, getdate()) 
									when ".$op." = 4
									then dateadd(month, -6, getdate()) 
									when ".$op." = 5
									then dateadd(year, -1, getdate()) 
									end
								)
								and getdate()
								and u_ccom.agno = ".$id."
						)x
						group by 
							case 
								when ".$op." in (1,2) then fdata
								when ".$op." in (3,4,5)  then year(fdata)*100 + month(fdata)
								else convert(varchar(10), fdata, 104)
							end,					
							case 
								when ".$op." in (1,2) then convert(varchar(10), fdata, 104)
								when ".$op." in (3,4,5)  then left(DATENAME(month, fdata),3) + case when year(fdata)!=year(getdate()) then ' ' + convert(varchar(10), year(fdata)) else '' end 
								else convert(varchar(10), fdata, 104)
							end

						order by 
							case 
								when ".$op." in (1,2) then fdata
								when ".$op." in (3,4,5)  then year(fdata)*100 + month(fdata)
								else convert(varchar(10), fdata, 104)
							end, 
							case 
								when ".$op." in (1,2) then convert(varchar(10), fdata, 104)
								when ".$op." in (3,4,5)  then left(DATENAME(month, fdata),3) + case when year(fdata)!=year(getdate()) then ' ' + convert(varchar(10), year(fdata)) else '' end 
								else convert(varchar(10), fdata, 104)
							end
					
					";
				}
				else {
					$query = "
						select 
							case 
								when ".$op." in (1,2) then convert(varchar(10), fdata, 104)
								when ".$op." in (3,4,5)  then left(DATENAME(month, fdata),3) + case when year(fdata)!=year(getdate()) then ' ' + convert(varchar(10), year(fdata)) else '' end 
								else convert(varchar(10), fdata, 104)
							end periodo,
							sum( valor*agpcom/100) valor
						from  
						(
							select u_ccom.*, clstamp, fdata, isnull((select 1 from u_pagent where u_pagent.bostamp=u_ccom.pdstamp and u_pagent.no = u_ccom.agno and u_pagent.opstamp=u_ccom.opstamp),0) agop
							from 
								u_ccom (nolock) 
									inner join ft (nolock) on ft.ftstamp=u_ccom.ftstamp
									inner join fl (nolock) on fl.flstamp=u_ccom.opstamp and fl.estab = 0
									inner join cl (nolock) on cl.flno=fl.no and fl.estab = 0
							where 
									processado = 0 
								and  		
								fdata between
								(
									case 
									when ".$op." = 1 
									then dateadd(day, -7, getdate()) 
									when ".$op." = 2 
									then dateadd(month, -1, getdate()) 
									when ".$op." = 3 
									then dateadd(month, -3, getdate()) 
									when ".$op." = 4
									then dateadd(month, -6, getdate()) 
									when ".$op." = 5
									then dateadd(year, -1, getdate()) 
									end
								)
								and getdate()
								and opno = ".$id."
						)x
						group by 
							case 
								when ".$op." in (1,2) then fdata
								when ".$op." in (3,4,5)  then year(fdata)*100 + month(fdata)
								else convert(varchar(10), fdata, 104)
							end,					
							case 
								when ".$op." in (1,2) then convert(varchar(10), fdata, 104)
								when ".$op." in (3,4,5)  then left(DATENAME(month, fdata),3) + case when year(fdata)!=year(getdate()) then ' ' + convert(varchar(10), year(fdata)) else '' end 
								else convert(varchar(10), fdata, 104)
							end

						order by 
							case 
								when ".$op." in (1,2) then fdata
								when ".$op." in (3,4,5)  then year(fdata)*100 + month(fdata)
								else convert(varchar(10), fdata, 104)
							end, 
							case 
								when ".$op." in (1,2) then convert(varchar(10), fdata, 104)
								when ".$op." in (3,4,5)  then left(DATENAME(month, fdata),3) + case when year(fdata)!=year(getdate()) then ' ' + convert(varchar(10), year(fdata)) else '' end 
								else convert(varchar(10), fdata, 104)
							end 

					";		
				}
				$sql_status = $this->mssql->mssql__select($query );			
				break;
				
			case 3:	
				if ($ag ==1) {
					$query = "
						select 
							case 
								when ".$op." in (1,2) then convert(varchar(10), fdata, 104)
								when ".$op." in (3,4,5)  then left(DATENAME(month, fdata),3) + case when year(fdata)!=year(getdate()) then ' ' + convert(varchar(10), year(fdata)) else '' end 
								else convert(varchar(10), fdata, 104)
							end periodo,
							sum(case when tpay= 'CASH' then valor else 0 end) valor
						from  
						(
							select 
								u_ccom.*, 
								isnull((select BO2.identificacao2 from bo2 where bo2stamp=ft.mhstamp), '') tpay,
								clstamp, 
								fdata,  
								isnull((select 1 from u_pagent where u_pagent.bostamp=u_ccom.pdstamp and u_pagent.no = u_ccom.agno and u_pagent.opstamp=u_ccom.opstamp),0) agop
							from 
								u_ccom (nolock) 
									inner join ft (nolock) on ft.ftstamp=u_ccom.ftstamp
									inner join fl (nolock) on fl.flstamp=u_ccom.opstamp and fl.estab = 0
									inner join cl (nolock) on cl.flno=fl.no and fl.estab = 0
							where 
									processado = 0 
								and  		
								fdata between
								(
									case 
									when ".$op." = 1 
									then dateadd(day, -7, getdate()) 
									when ".$op." = 2 
									then dateadd(month, -1, getdate()) 
									when ".$op." = 3 
									then dateadd(month, -3, getdate()) 
									when ".$op." = 4
									then dateadd(month, -6, getdate()) 
									when ".$op." = 5
									then dateadd(year, -1, getdate()) 
									end
								)
								and getdate()
								and u_ccom.agno = ".$id."
						)x
						group by 
							case 
								when ".$op." in (1,2) then fdata
								when ".$op." in (3,4,5)  then year(fdata)*100 + month(fdata)
								else convert(varchar(10), fdata, 104)
							end,					
							case 
								when ".$op." in (1,2) then convert(varchar(10), fdata, 104)
								when ".$op." in (3,4,5)  then left(DATENAME(month, fdata),3) + case when year(fdata)!=year(getdate()) then ' ' + convert(varchar(10), year(fdata)) else '' end 
								else convert(varchar(10), fdata, 104)
							end

						order by 
							case 
								when ".$op." in (1,2) then fdata
								when ".$op." in (3,4,5)  then year(fdata)*100 + month(fdata)
								else convert(varchar(10), fdata, 104)
							end, 
							case 
								when ".$op." in (1,2) then convert(varchar(10), fdata, 104)
								when ".$op." in (3,4,5)  then left(DATENAME(month, fdata),3) + case when year(fdata)!=year(getdate()) then ' ' + convert(varchar(10), year(fdata)) else '' end 
								else convert(varchar(10), fdata, 104)
							end 
					";
				}
				else {			
					$query = "
						select 
							case 
								when ".$op." in (1,2) then convert(varchar(10), fdata, 104)
								when ".$op." in (3,4,5)  then left(DATENAME(month, fdata),3) + case when year(fdata)!=year(getdate()) then ' ' + convert(varchar(10), year(fdata)) else '' end 
								else convert(varchar(10), fdata, 104)
							end periodo,
							sum( ((s4pvcom+s4bvcom) + valor*(s4ppcom+s4pvcom)/100)) valor
						from  
						(
							select u_ccom.*, clstamp, fdata, isnull((select 1 from u_pagent where u_pagent.bostamp=u_ccom.pdstamp and u_pagent.no = u_ccom.agno and u_pagent.opstamp=u_ccom.opstamp),0) agop
							from 
								u_ccom (nolock) 
									inner join ft (nolock) on ft.ftstamp=u_ccom.ftstamp
									inner join fl (nolock) on fl.flstamp=u_ccom.opstamp and fl.estab = 0
									inner join cl (nolock) on cl.flno=fl.no and fl.estab = 0
							where 
									processado = 0 
								and  		
								fdata between
								(
									case 
									when ".$op." = 1 
									then dateadd(day, -7, getdate()) 
									when ".$op." = 2 
									then dateadd(month, -1, getdate()) 
									when ".$op." = 3 
									then dateadd(month, -3, getdate()) 
									when ".$op." = 4
									then dateadd(month, -6, getdate()) 
									when ".$op." = 5
									then dateadd(year, -1, getdate()) 
									end
								)
								and getdate()
								and opno = ".$id."
						)x
						group by 
							case 
								when ".$op." in (1,2) then fdata
								when ".$op." in (3,4,5)  then year(fdata)*100 + month(fdata)
								else convert(varchar(10), fdata, 104)
							end,					
							case 
								when ".$op." in (1,2) then convert(varchar(10), fdata, 104)
								when ".$op." in (3,4,5)  then left(DATENAME(month, fdata),3) + case when year(fdata)!=year(getdate()) then ' ' + convert(varchar(10), year(fdata)) else '' end 
								else convert(varchar(10), fdata, 104)
							end

						order by 
							case 
								when ".$op." in (1,2) then fdata
								when ".$op." in (3,4,5)  then year(fdata)*100 + month(fdata)
								else convert(varchar(10), fdata, 104)
							end, 
							case 
								when ".$op." in (1,2) then convert(varchar(10), fdata, 104)
								when ".$op." in (3,4,5)  then left(DATENAME(month, fdata),3) + case when year(fdata)!=year(getdate()) then ' ' + convert(varchar(10), year(fdata)) else '' end 
								else convert(varchar(10), fdata, 104)
							end 

					";		
				}	
				$sql_status = $this->mssql->mssql__select($query );			
				break;	
				
			case 4:		
				if ($ag ==1) {
					$query = "
						select 
							fi.tam tipo,
							sum(etiliquido) valor
							from ft (nolock) inner join fi (nolock) on ft.ftstamp = fi.ftstamp
						where 
								ft.anulado = 0 
							and (ft.tipodoc not in (4,5) or ft.ndoc = 10)
							and ft.fdata between
								(
									case 
									when ".$op." = 1 
									then dateadd(day, -7, getdate()) 
									when ".$op." = 2 
									then dateadd(month, -1, getdate()) 
									when ".$op." = 3 
									then dateadd(month, -3, getdate()) 
									when ".$op." = 4
									then dateadd(month, -6, getdate()) 
									when ".$op." = 5
									then dateadd(year, -1, getdate()) 
									end
								)
								and getdate()
								and isnull((select BO2.tkhdid from bo2 where bo2stamp=ft.mhstamp), 0)=".$id."
						group by 
							fi.tam

						order by 
							fi.tam					
					";
				}
				else {			
					$query = "
						select 
							fi.tam tipo,
							sum(etiliquido) valor
							from ft (nolock) inner join fi (nolock) on ft.ftstamp = fi.ftstamp
						where 
								ft.anulado = 0 
							and (ft.tipodoc not in (4,5) or ft.ndoc = 10)
							and ft.fdata between
								(
									case 
									when ".$op." = 1 
									then dateadd(day, -7, getdate()) 
									when ".$op." = 2 
									then dateadd(month, -1, getdate()) 
									when ".$op." = 3 
									then dateadd(month, -3, getdate()) 
									when ".$op." = 4
									then dateadd(month, -6, getdate()) 
									when ".$op." = 5
									then dateadd(year, -1, getdate()) 
									end
								)
								and getdate()
								and isnull((select BO2.NOCTS from bo2 where bo2stamp=ft.mhstamp), 0)=".$id."
						group by 
							fi.tam

						order by 
							fi.tam
					";		
				}
				$sql_status = $this->mssql->mssql__select($query );			
				break;	
				
			default:
				echo 'Nothing to do';
				break;
				
				
		};
		return $sql_status;
		
		
	}
	
	public function associate_op_agent( $ag_vat, $op_id ) {
		$result = array();
		
		$query = "select top 1 ncont, nome, flstamp, no from fl where ncont = '".$ag_vat."' and fl.estab = 0";
		$agent_data = $this->mssql->mssql__select( $query );
		
		$query = "select top 1 ncont, nome, flstamp, no from fl where no = ".$op_id . " and fl.estab = 0";
		$op_data = $this->mssql->mssql__select( $query );
		
		//check if me
		if( $op_data[0]['flstamp'] == $agent_data[0]['flstamp'] ) {
			$result['success'] = 0;
			$result['message'] = 'You cant be associated with yourself';
		}
		else {
			//check if already associated
			$query = "select top 1 agstamp from u_agop where opstamp = '".$op_data[0]['flstamp'] . "' and agstamp = '".$agent_data[0]['flstamp'] . "'";
			$num_assoc = $this->mssql->mssql__select( $query );
			
			if( sizeof($num_assoc) > 0 ) {
				$result['success'] = 0;
				$result['message'] = 'Agent is already associated with your account';

			}
			else {
				$update_values = array();
				$update_values[] = $op_data[0]['flstamp'];
				$update_values[] = $agent_data[0]['flstamp'];
				$update_values[] = $op_data[0]['nome'];
				
				$query = "insert into u_agop (
					u_agopstamp,
					opstamp,
					agstamp,
					opnome,
					ousrdata,
					ousrhora,
					ousrinis,
					usrdata,
					usrhora,
					usrinis
				) values (
					CONVERT(VARCHAR(25), (select UPPER(suser_sname())+left(newid(),5)+right(newid(),5)+ left(newid(),5)+right(newid(),5))),
					?,
					?,
					?,
					CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000', 
					CONVERT(VARCHAR(5), GETDATE(), 8), 
					UPPER(suser_sname()), 
					CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000', 
					CONVERT(VARCHAR(5), GETDATE(), 8),
					UPPER(suser_sname())
				) 
				";
				
				$sql_status = $this->mssql->mssql__prepare_exec( $query, $update_values );
				
				//atualiza fornecedor para agente
				$query = "update fl set u_agente = 'Sim' where flstamp = '" . $agent_data[0]['flstamp'] . "'";
				$sql_status2 = $this->mssql->mssql__execute( $query );
				
				$result['success'] = $sql_status;
				if( !$sql_status ) {
					$result['message'] = 'Agent association error';
				}
				else {
					$result['message'] = 'Agent association created successfuly';
				}
			}
		}
		
		return $result;
	}
	
	public function get_sales( $data ) {
		$query = "
				select 
					isnull(ag.nome, 'Direct client') agnome, 
					isnull(ag.no, 0) agno, 
					prod.u_name pdnome,
					ft.fdata, 
					ft.fno,
					sum(fi.qtt) qtt,
					avg(case when fi.qtt != 0 then fi.etiliquido/fi.qtt else 0 end) epv, 
					sum(fi.etiliquido) ettiliq,
					enc2.email,
					enc.site
					from 
						ft (nolock)
							inner join fi (nolock) on ft.ftstamp = fi.ftstamp
							inner join bo (nolock) enc on ft.mhstamp = enc.bostamp
							inner join bo2 (nolock) enc2 on enc.bostamp =enc2.bo2stamp
							inner join bo (nolock) prod on enc.origem = prod.bostamp 
							left join fl (nolock) ag on enc2.TKHDID = ag.no and ag.estab = 0
				where 
						ft.anulado = 0 
					and (ft.tipodoc not in (4,5) or ft.ndoc = 10)
					and ((not '".$data[0]."' != '') or (ft.fdata >= '".$data[0]."'))
					and ((not '".$data[1]."' != '') or (ft.fdata <= '".$data[1]."'))
					and ((not '".$data[2]."' != '') or (ag.flstamp = '".$data[2]."'))
					and ((not '".$data[3]."' != '') or (prod.bostamp = '".$data[3]."'))
					and ((not '".$data[5]."' != '') or (ag.gsecstamp = '".$data[5]."'))
					and isnull((select BO2.NOCTS from bo2 (nolock) where bo2stamp=ft.mhstamp), 0)=".$data[4]." --OPERADOR
				group by 
					ag.nome, 
					prod.u_name,
					ft.fdata, 
					ft.fno,
					ag.no,
					enc2.email,
					enc.site
				order by 
					ag.nome, 
					prod.u_name,
					ft.fdata, 
					ft.fno
			";
		$sql_status = $this->mssql->mssql__select( $query );
		return $sql_status;
		
	}
	
	public function get_event_data( $op ) {
		$query = "
			select *
			from bo
			where ndos = 4 and nocts = ".$op."
		";
		
		$result = $this->mssql->mssql__select( $query );
		$result_data = array();
		
		foreach( $result as $row ) {
			$tmp = array();
			
			$tmp["id"] = $row["obrano"];
			$tmp["title"] = $row["obrano"];
			$tmp["url"] = "";
			$tmp["class"] = "event-success";
			$tmp["start"] = "";
			$tmp["end"] = "";
		}
		
		// return $sql_status;
	}
	
	public function get_agent_treasury( $data ) {
		$no = $data["no"];
		$dataini = $data["dataini"];
		$datafim = $data["datafim"];
		$opno = $data["opno"];
		
		$query = "
			select 
				data, 
				qtt, 
				produto, 
				agno, 
				epv, 
				valor, 
				formapag, 
				conta_destino, 
				ewa, 
				operador, 
				agente, 
				isnull(sum(saldo_ewa) over (order by data, hora, produto),0) saldo_ewa, 
				isnull(sum(saldo_op) over (order by data, hora, produto),0)  saldo_op, 
				isnull(sum(saldo_ag) over (order by data, hora, produto),0)  saldo_ag, 
				status
			from 
			(
				select 
					dateadd(day, -1, '" . $dataini . "') data, 
					'' hora, 
					0 qtt, 
					'PREVIOUS BALANCE' produto, 
					'' agno,  
					0 epv, 
					0 valor, 
					'' formapag, 
					'' conta_destino, 
					0 ewa, 
					0 operador, 
					0 agente, 
					sum(saldo_ewa) saldo_ewa, 
					sum(saldo_op) saldo_op, 
					sum(saldo_ag) saldo_ag, 
					'' status, 
					0 tipo
				from 
				(
					select 
						data,
						hora, 
						qtt, 
						produto,
						isnull((select nome from fl (nolock) where no =x.opno and estab = 0), '') agno,
						epv, 
						valor, 
						formapag, 
						conta_destino, 
						ewa, 
						operador, 
						agente,
						case when conta_destino = 'EWA' then ewa-valor else ewa end saldo_ewa,
						case when conta_destino = 'OPERATOR' then operador-valor else operador end saldo_op, 
						case when conta_destino = 'AGENT' then agente-valor else agente end saldo_ag,
						case when pago = 1 then 'PROCESSED' else 'UNPROCESSED' end status,
						1 tipo
					from 
					(
						select	
							fdata data, 
							ft.ousrhora hora,
							isnull((select sum(qtt) from fi (nolock) where ftstamp=ft.ftstamp), 0) qtt, 
							u_ccom.pdnome produto, 
							u_ccom.opno, 
							isnull((select avg(epv) from fi (nolock) where ftstamp=ft.ftstamp), 0) epv, 
							valor, 
							pago,
							BO2.IDENTIFICACAO2 formapag, 
							case when BO2.IDENTIFICACAO2 = 'CASH' then 'AGENT' else 'EWA' end conta_destino, 
							round((case when bo.site = 'EWASITE' then valor*ewpcom/100+ewvcom  else valor*s4bpcom/100+s4bvcom + valor*s4ppcom/100+s4pvcom end),2) ewa, 
							round(valor - valor*agpcom/100+agvcom - (case when bo.site = 'EWASITE' then valor*ewpcom/100+ewvcom  else valor*s4bpcom/100+s4bvcom + valor*s4ppcom/100+s4pvcom end),2) operador, 
							round(valor*agpcom/100+agvcom,2) agente
						from 
							u_ccom (nolock) 
								inner join ft (nolock) on u_ccom.ftstamp = ft.ftstamp
								inner join bo (nolock) on u_ccom.ecstamp = bo.bostamp
								inner join bo2 (nolock) on u_ccom.ecstamp = bo2.bo2stamp
						where '" . $no . "' = agno and (not ('" . $opno . "'!=0) or ('" . $opno . "' = opno))
					)x

					union all 

					select 
						po.procdata data,
						po.ousrhora, 
						0 qtt, 
						'OPERATOR REIMBURSEMENT' produto,
						'' agno,
						0 epv, 
						sum(pl.erec) valor, 
						'' formapag, 
						'OPERATOR' conta_destino, 
						0 ewa, 
						sum(fn.epv) operador, 
						0 agente,
						sum(fn.epv) saldo_ewa, 
						sum(-fn.epv) saldo_op,
						0 saldo_ag, 
						case when po.process = 1 then 'PROCESSED' else 'UNPROCESSED' end status, 
						2 tipo
					from pl (nolock) 
						inner join po (nolock) on po.postamp = pl.postamp 
						inner join fc (nolock) on fc.fcstamp = pl.fcstamp 
						inner join fo (nolock) on fc.fostamp = fo.fostamp
						inner join fn (nolock) on fo.fostamp = fn.fostamp
						inner join u_ccom (nolock) on fn.bistamp = u_ccom.u_ccomstamp
					where u_ccom.agno = '" . $no . "' and pl.cm = 101 and (not ('" . $opno . "'!=0) or ('" . $opno . "' = po.no))
					group by po.procdata, po.ousrhora, po.process

					union all 

					select 
						po.procdata data,
						po.ousrhora, 
						0 qtt, 
						'AGENT FEE RECEIPT PAYMENT' produto,
						'' agno,
						0 epv, 
						sum(pl.erec) valor, 
						'' formapag, 
						'AGENT' conta_destino, 
						0 ewa, 
						0 operador, 
						sum(pl.erec) agente,
						sum(pl.erec) saldo_ewa, 
						0 saldo_op,
						sum(-pl.erec) saldo_ag, 
						case when po.process = 1 then 'PROCESSED' else 'UNPROCESSED' end status, 
						3 tipo
					from pl (nolock) 
						inner join po (nolock) on po.postamp = pl.postamp 
						inner join fc (nolock) on fc.fcstamp = pl.fcstamp 
						inner join fo (nolock) on fo.fostamp = fc.fostamp
						inner join fo2 (nolock) on fo.fostamp = fo2.fo2stamp
					where pl.cm = 100 and po.no = '" . $no . "' and (not ('" . $opno . "'!=0) or ('" . $opno . "' = fo2.u_opno))
					group by po.procdata, po.process, po.ousrhora

					union all 

					select 
						fo.docdata data, 
						fo.ousrhora,
						0 qtt, 
						'AGENT CASH DEVOLUTION' produto,
						'' agno,
						0 epv, 
						fo.etotal valor, 
						'' formapag, 
						'EWA' conta_destino, 
						fo.etotal ewa, 
						0 operador, 
						0 agente,
						-fo.etotal  saldo_ewa, 
						0 saldo_op,
						fo.etotal  saldo_ag, 
						'PROCESSED'  status,
						4 tipo
					from fo (nolock) inner join fo2 (nolock) on fo.fostamp = fo2.fo2stamp
					where fo.no = '" . $no . "' and fo.doccode = 103  and (not ('" . $opno . "'!=0) or ('" . $opno . "' = fo2.u_opno))

					union all

					select 
						fo.docdata data, 
						fo.ousrhora,
						0 qtt, 
						'AGENT CASH DEVOLUTION (OPERATOR)' produto,
						'' agno,
						0 epv, 
						fo.etotal valor, 
						'' formapag, 
						'OPERATOR' conta_destino, 
						0 ewa, 
						fo.etotal operador, 
						0 agente,
						0  saldo_ewa, 
						-fo.etotal saldo_op,
						fo.etotal  saldo_ag, 
						case when fo.aprovado=1 then 'PROCESSED' else 'UNPROCESSED' end  status,
						5 tipo
					from fo (nolock) inner join fo2 (nolock) on fo.fostamp = fo2.fo2stamp
					where fo.no = '" . $no . "' and fo.doccode = 104 and (not ('" . $opno . "'!=0) or ('" . $opno . "' = fo2.u_opno))
				) x 
				where data <'" . $dataini . "' 

				union all

				select 
					data, 
					hora,
					qtt, 
					produto, 
					agno, 
					epv, 
					valor, 
					formapag, 
					conta_destino, 
					ewa, 
					operador, 
					agente, 
					saldo_ewa saldo_ewa, 
					saldo_op  saldo_op, 
					saldo_ag  saldo_ag, 
					status, 
					tipo
				from 
				(
					select 
						data,
						hora, 
						qtt, 
						produto,
						isnull((select nome from fl (nolock) where no =x.opno and estab = 0), '') agno,
						epv, 
						valor, 
						formapag, 
						conta_destino, 
						ewa, 
						operador, 
						agente,
						case when conta_destino = 'EWA' then ewa-valor else ewa end saldo_ewa,
						case when conta_destino = 'OPERATOR' then operador-valor else operador end saldo_op, 
						case when conta_destino = 'AGENT' then agente-valor else agente end saldo_ag,
						case when pago = 1 then 'PROCESSED' else 'UNPROCESSED' end status,
						1 tipo
					from 
					(
						select	
							fdata data, 
							ft.ousrhora hora,
							isnull((select sum(qtt) from fi (nolock) where ftstamp=ft.ftstamp), 0) qtt, 
							u_ccom.pdnome produto, 
							u_ccom.opno, 
							isnull((select avg(epv) from fi (nolock) where ftstamp=ft.ftstamp), 0) epv, 
							valor, 
							pago,
							BO2.IDENTIFICACAO2 formapag, 
							case when BO2.IDENTIFICACAO2 = 'CASH' then 'AGENT' else 'EWA' end conta_destino, 
							round((case when bo.site = 'EWASITE' then valor*ewpcom/100+ewvcom  else valor*s4bpcom/100+s4bvcom + valor*s4ppcom/100+s4pvcom end),2) ewa, 
							round(valor - valor*agpcom/100+agvcom - (case when bo.site = 'EWASITE' then valor*ewpcom/100+ewvcom  else valor*s4bpcom/100+s4bvcom + valor*s4ppcom/100+s4pvcom end),2) operador, 
							round(valor*agpcom/100+agvcom,2) agente
						from 
							u_ccom (nolock) 
								inner join ft (nolock) on u_ccom.ftstamp = ft.ftstamp
								inner join bo (nolock) on u_ccom.ecstamp = bo.bostamp
								inner join bo2 (nolock) on u_ccom.ecstamp = bo2.bo2stamp
						where '" . $no . "' = agno and (not ('" . $opno . "'!=0) or ('" . $opno . "' = opno))
					)x

					union all 

					select 
						po.procdata data,
						po.ousrhora, 
						0 qtt, 
						'OPERATOR REIMBURSEMENT' produto,
						'' agno,
						0 epv, 
						sum(fn.epv) valor, 
						'' formapag, 
						'OPERATOR' conta_destino, 
						0 ewa, 
						sum(fn.epv) operador, 
						0 agente,
						sum(fn.epv) saldo_ewa, 
						sum(-fn.epv) saldo_op,
						0 saldo_ag, 
						case when po.process = 1 then 'PROCESSED' else 'UNPROCESSED' end status, 
						2 tipo
					from pl (nolock) 
						inner join po (nolock) on po.postamp = pl.postamp 
						inner join fc (nolock) on fc.fcstamp = pl.fcstamp 
						inner join fo (nolock) on fc.fostamp = fo.fostamp
						inner join fn (nolock) on fo.fostamp = fn.fostamp
						inner join u_ccom (nolock) on fn.bistamp = u_ccom.u_ccomstamp
					where u_ccom.agno = '" . $no . "' and pl.cm = 101 and (not ('" . $opno . "'!=0) or ('" . $opno . "' = po.no))
					group by po.procdata, po.ousrhora, po.process

					union all 

					select 
						po.procdata data,
						po.ousrhora, 
						0 qtt, 
						'AGENT FEE RECEIPT PAYMENT' produto,
						'' agno,
						0 epv, 
						sum(pl.erec) valor, 
						'' formapag, 
						'AGENT' conta_destino, 
						0 ewa, 
						0 operador, 
						sum(pl.erec) agente,
						sum(pl.erec) saldo_ewa, 
						0 saldo_op,
						sum(-pl.erec) saldo_ag, 
						case when po.process = 1 then 'PROCESSED' else 'UNPROCESSED' end status, 
						3 tipo
					from pl (nolock) 
						inner join po (nolock) on po.postamp = pl.postamp 
						inner join fc (nolock) on fc.fcstamp = pl.fcstamp 
						inner join fo (nolock) on fo.fostamp = fc.fostamp
						inner join fo2 (nolock) on fo.fostamp = fo2.fo2stamp
					where pl.cm = 100 and po.no = '" . $no . "' and (not ('" . $opno . "'!=0) or ('" . $opno . "' = fo2.u_opno))
					group by po.procdata, po.process, po.ousrhora

					union all 

					select 
						fo.docdata data, 
						fo.ousrhora,
						0 qtt, 
						'AGENT CASH DEVOLUTION' produto,
						'' agno,
						0 epv, 
						fo.etotal valor, 
						'' formapag, 
						'EWA' conta_destino, 
						fo.etotal ewa, 
						0 operador, 
						0 agente,
						-fo.etotal  saldo_ewa, 
						0 saldo_op,
						fo.etotal  saldo_ag, 
						'PROCESSED'  status,
						4 tipo
					from fo (nolock) inner join fo2 (nolock) on fo.fostamp = fo2.fo2stamp
					where fo.no = '" . $no . "' and fo.doccode = 103 and (not ('" . $opno . "'!=0) or ('" . $opno . "' = fo2.u_opno))

					union all 

					select 
						fo.docdata data, 
						fo.ousrhora,
						0 qtt, 
						'AGENT CASH DEVOLUTION (OPERATOR)' produto,
						'' agno,
						0 epv, 
						fo.etotal valor, 
						'' formapag, 
						'OPERATOR' conta_destino, 
						0 ewa, 
						fo.etotal operador, 
						0 agente,
						0  saldo_ewa, 
						-fo.etotal saldo_op,
						fo.etotal  saldo_ag, 
						case when fo.aprovado=1 then 'PROCESSED' else 'UNPROCESSED' end  status,
						5 tipo
					from fo (nolock) inner join fo2 (nolock) on fo.fostamp = fo2.fo2stamp
					where fo.no = '" . $no . "' and fo.doccode = 104 and (not ('" . $opno . "'!=0) or ('" . $opno . "' = fo2.u_opno))
				) x 
				where data between '" . $dataini . "' and '" . $datafim . "'
			)x
			order by data, hora, tipo, produto
			";
		$sql_status = $this->mssql->mssql__select( $query );
		return $sql_status;
	}
	
	public function get_treasury( $data ) {
		$no = $data["no"];
		$dataini = $data["dataini"];
		$datafim = $data["datafim"];
		$agno = $data["agno"];
		$local = $data["local"];
		
		$query = "
			select 
				data, 
				qtt, 
				produto, 
				agno, 
				epv, 
				valor, 
				formapag, 
				conta_destino, 
				ewa, 
				operador, 
				agente, 
				isnull(sum(saldo_ewa) over (order by data, hora, produto),0) saldo_ewa, 
				isnull(sum(saldo_op) over (order by data, hora, produto),0)  saldo_op, 
				isnull(sum(saldo_ag) over (order by data, hora, produto),0)  saldo_ag, 
				status
				from 
				(
				select 
					dateadd(day, -1, '" . $dataini . "') data, 
					'' hora, 
					0 qtt, 
					'PREVIOUS BALANCE' produto, 
					'' agno,  
					0 epv, 
					0 valor, 
					'' formapag, 
					'' conta_destino, 
					0 ewa, 
					0 operador, 
					0 agente, 
					sum(saldo_ewa) saldo_ewa, 
					sum(saldo_op) saldo_op, 
					sum(saldo_ag) saldo_ag, 
					'' status, 
					0 tipo
				from 
				(
					select 				
						data,
						hora, 
						qtt, 
						produto,
						isnull((select nome from fl (nolock) where no =agno and estab = 0), '') agno,
						epv, 
						valor, 
						formapag, 
						conta_destino, 
						ewa, 
						operador, 
						agente,
						case when conta_destino = 'EWA' then ewa-valor else ewa end saldo_ewa,
						case when conta_destino = 'OPERATOR' then operador-valor else operador end saldo_op, 
						case when conta_destino = 'AGENT' then agente-valor else agente end saldo_ag,
						case when pago = 1 then 'PROCESSED' else 'UNPROCESSED' end status,
						1 tipo
					from 
					(
						select	
							fdata data, 
							ft.ousrhora hora,
							isnull((select sum(qtt) from fi (nolock) where ftstamp=ft.ftstamp), 0) qtt, 
							u_ccom.pdnome produto, 
							agno, 
							isnull((select avg(epv) from fi (nolock) where ftstamp=ft.ftstamp), 0) epv, 
							valor, 
							pago,
							BO2.IDENTIFICACAO2 formapag, 
							case when BO2.IDENTIFICACAO2 = 'CASH' then 'AGENT' else 'EWA' end conta_destino, 
							round((case when bo.site = 'EWASITE' then valor*ewpcom/100+ewvcom  else valor*s4bpcom/100+s4bvcom + valor*s4ppcom/100+s4pvcom end),2) ewa, 
							round(valor - valor*agpcom/100+agvcom - (case when bo.site = 'EWASITE' then valor*ewpcom/100+ewvcom  else valor*s4bpcom/100+s4bvcom + valor*s4ppcom/100+s4pvcom end),2) operador, 
							round(valor*agpcom/100+agvcom,2) agente
						from 
							u_ccom (nolock) 
								inner join ft (nolock) on u_ccom.ftstamp = ft.ftstamp
								inner join bo (nolock) on u_ccom.ecstamp = bo.bostamp
								inner join bo2 (nolock) on u_ccom.ecstamp = bo2.bo2stamp
						where '" . $no . "' = opno  and (not('" . $agno . "'!=0) or (agno='" . $agno . "')) and (not('" . $local . "'!='') or (agno in (select no from fl where u_local='" . $local . "' and estab= 0 )))
					)x

					union all 

					select 
						po.procdata data,
						po.ousrhora, 
						0 qtt, 
						'OPERATOR REIMBURSEMENT' produto,
						'' agno,
						0 epv, 
						sum(fn.epv) valor, 
						'' formapag, 
						'OPERATOR' conta_destino, 
						0 ewa, 
						sum(fn.epv) operador, 
						0 agente,
						sum(fn.epv) saldo_ewa, 
						sum(-fn.epv) saldo_op,
						0 saldo_ag, 
						case when po.process = 1 then 'PROCESSED' else 'UNPROCESSED' end status, 
						2 tipo
					from pl (nolock) 
						inner join po (nolock) on po.postamp = pl.postamp 
						inner join fc (nolock) on fc.fcstamp = pl.fcstamp 
						inner join fo (nolock) on fc.fostamp = fo.fostamp
						inner join fn (nolock) on fo.fostamp = fn.fostamp
						inner join u_ccom (nolock) on fn.bistamp = u_ccom.u_ccomstamp
					where po.no = '" . $no . "' and pl.cm = 101 and (not('" . $agno . "'!=0) or (u_ccom.agno = '" . $agno . "')) and (not('" . $local . "'!='') or (u_ccom.agno in (select no from fl where u_local='" . $local . "' and estab= 0 )))
					group by po.procdata, po.ousrhora, po.process

					union all 

					select 
						po.procdata data,
						po.ousrhora, 
						0 qtt, 
						'AGENT FEE RECEIPT PAYMENT' produto,
						isnull((select nome from fl (nolock) where no =agno and estab = 0), '') agno,
						0 epv, 
						sum(pl.erec) valor, 
						'' formapag, 
						'AGENT' conta_destino, 
						0 ewa, 
						0 operador, 
						sum(pl.erec) agente,
						sum(pl.erec) saldo_ewa, 
						0 saldo_op,
						sum(-pl.erec) saldo_ag, 
						case when po.process = 1 then 'PROCESSED' else 'UNPROCESSED' end status, 
						3 tipo
					from pl (nolock) 
						inner join po (nolock) on po.postamp = pl.postamp 
						inner join fc (nolock) on fc.fcstamp = pl.fcstamp 
						inner join fo (nolock) on fo.fostamp = fc.fostamp
						inner join fo2 (nolock) on fo.fostamp = fo2.fo2stamp
					where pl.cm = 100 and fo2.u_opno = '" . $no . "' and (not('" . $agno . "'!=0) or (fo.no = '" . $agno . "')) and (not('" . $local . "'!='') or (fo.no in (select no from fl where u_local='" . $local . "' and estab= 0 )))
					group by po.procdata, po.process, po.ousrhora

					union all 

					select 
						fo.docdata data, 
						fo.ousrhora,
						0 qtt, 
						'AGENT CASH DEVOLUTION' produto,
						isnull((select nome from fl (nolock) where no = fo.no and estab = 0), '') agno,
						0 epv, 
						fo.etotal valor, 
						'' formapag, 
						'EWA' conta_destino, 
						fo.etotal ewa, 
						0 operador, 
						0 agente,
						-fo.etotal  saldo_ewa, 
						0 saldo_op,
						fo.etotal  saldo_ag, 
						'PROCESSED'  status,
						4 tipo
					from fo (nolock) inner join fo2 (nolock) on fo.fostamp=fo2.fo2stamp
					where fo2.u_opno = '" . $no . "' and fo.doccode = 103  and (not('" . $agno . "'!=0) or (fo.no = '" . $agno . "')) and (not('" . $local . "'!='') or (fo.no in (select no from fl where u_local='" . $local . "' and estab= 0 )))

					union all 

					select 
						fo.docdata data, 
						fo.ousrhora,
						0 qtt, 
						'AGENT CASH DEVOLUTION (OPERATOR)' produto,
						isnull((select nome from fl (nolock) where no = fo.no and estab = 0), '') agno,
						0 epv, 
						fo.etotal valor, 
						'' formapag, 
						'OPERATOR' conta_destino, 
						0 ewa, 
						fo.etotal operador, 
						0 agente,
						0  saldo_ewa, 
						-fo.etotal saldo_op,
						fo.etotal  saldo_ag, 
						case when fo.aprovado = 1 then 'PROCESSED' else 'UNPROCESSED' end  status,
						5 tipo
					from fo (nolock) inner join fo2 (nolock) on fo.fostamp=fo2.fo2stamp
					where fo2.u_opno = '" . $no . "' and fo.doccode = 104 and (not('" . $agno . "'!=0) or (fo.no = '" . $agno . "')) and (not('" . $local . "'!='') or (fo.no in (select no from fl where u_local='" . $local . "' and estab= 0 )))

				) x 
				where data <'" . $dataini . "' 

				union all

				select 
					data, 
					hora,
					qtt, 
					produto, 
					agno, 
					epv, 
					valor, 
					formapag, 
					conta_destino, 
					ewa, 
					operador, 
					agente, 
					saldo_ewa saldo_ewa, 
					saldo_op  saldo_op, 
					saldo_ag  saldo_ag, 
					status, 
					tipo
				from 
				(
					select 				
						data,
						hora, 
						qtt, 
						produto,
						isnull((select nome from fl (nolock) where no  = x.agno and estab = 0), '') agno,
						epv, 
						valor, 
						formapag, 
						conta_destino, 
						ewa, 
						operador, 
						agente,
						case when conta_destino = 'EWA' then ewa-valor else ewa end saldo_ewa,
						case when conta_destino = 'OPERATOR' then operador-valor else operador end saldo_op, 
						case when conta_destino = 'AGENT' then agente-valor else agente end saldo_ag,
						case when pago = 1 then 'PROCESSED' else 'UNPROCESSED' end status,
						1 tipo
					from 
					(
						select	
							fdata data, 
							ft.ousrhora hora,
							isnull((select sum(qtt) from fi (nolock) where ftstamp=ft.ftstamp), 0) qtt, 
							u_ccom.pdnome produto, 
							u_ccom.agno, 
							isnull((select avg(epv) from fi (nolock) where ftstamp=ft.ftstamp), 0) epv, 
							valor, 
							pago,
							BO2.IDENTIFICACAO2 formapag, 
							case when BO2.IDENTIFICACAO2 = 'CASH' then 'AGENT' else 'EWA' end conta_destino, 
							round((case when bo.site = 'EWASITE' then valor*ewpcom/100+ewvcom  else valor*s4bpcom/100+s4bvcom + valor*s4ppcom/100+s4pvcom end),2) ewa, 
							round(valor - valor*agpcom/100+agvcom - (case when bo.site = 'EWASITE' then valor*ewpcom/100+ewvcom  else valor*s4bpcom/100+s4bvcom + valor*s4ppcom/100+s4pvcom end),2) operador, 
							round(valor*agpcom/100+agvcom,2) agente
						from 
							u_ccom (nolock) 
								inner join ft (nolock) on u_ccom.ftstamp = ft.ftstamp
								inner join bo (nolock) on u_ccom.ecstamp = bo.bostamp
								inner join bo2 (nolock) on u_ccom.ecstamp = bo2.bo2stamp
						where '" . $no . "' = opno  and (not('" . $agno . "'!=0) or (agno='" . $agno . "')) and (not('" . $local . "'!='') or (agno in (select no from fl where u_local='" . $local . "' and estab= 0 )))
					)x

					union all 

					select 
						po.procdata data,
						po.ousrhora, 
						0 qtt, 
						'OPERATOR REIMBURSEMENT' produto,
						'' agno,
						0 epv, 
						sum(fn.epv) valor, 
						'' formapag, 
						'OPERATOR' conta_destino, 
						0 ewa, 
						sum(fn.epv) operador, 
						0 agente,
						sum(fn.epv) saldo_ewa, 
						sum(-fn.epv) saldo_op,
						0 saldo_ag, 
						case when po.process = 1 then 'PROCESSED' else 'UNPROCESSED' end status, 
						2 tipo
					from pl (nolock) 
						inner join po (nolock) on po.postamp = pl.postamp 
						inner join fc (nolock) on fc.fcstamp = pl.fcstamp 
						inner join fo (nolock) on fc.fostamp = fo.fostamp
						inner join fn (nolock) on fo.fostamp = fn.fostamp
						inner join u_ccom (nolock) on fn.bistamp = u_ccom.u_ccomstamp
					where po.no = '" . $no . "' and pl.cm = 101 and (not('" . $agno . "'!=0) or (u_ccom.agno = '" . $agno . "')) and (not('" . $local . "'!='') or (u_ccom.agno in (select no from fl where u_local='" . $local . "' and estab= 0 )))
					group by po.procdata, po.ousrhora, po.process

					union all 

					select 
						po.procdata data,
						po.ousrhora, 
						0 qtt, 
						'AGENT FEE RECEIPT PAYMENT' produto,
						isnull((select nome from fl (nolock) where no = fo.no and estab = 0), '') agno,
						0 epv, 
						sum(pl.erec) valor, 
						'' formapag, 
						'AGENT' conta_destino, 
						0 ewa, 
						0 operador, 
						sum(pl.erec) agente,
						sum(pl.erec) saldo_ewa, 
						0 saldo_op,
						sum(-pl.erec) saldo_ag, 
						case when po.process = 1 then 'PROCESSED' else 'UNPROCESSED' end status, 
						3 tipo
					from pl (nolock) 
						inner join po (nolock) on po.postamp = pl.postamp 
						inner join fc (nolock) on fc.fcstamp = pl.fcstamp 
						inner join fo (nolock) on fo.fostamp = fc.fostamp
						inner join fo2 (nolock) on fo.fostamp = fo2.fo2stamp
					where pl.cm = 100 and fo2.u_opno = '" . $no . "' and (not('" . $agno . "'!=0) or (fo.no = '" . $agno . "')) and (not('" . $local . "'!='') or (fo.no in (select no from fl where u_local='" . $local . "' and estab= 0 )))
					group by po.procdata, po.process, po.ousrhora, fo.no

					union all 

					select 
						fo.docdata data, 
						fo.ousrhora,
						0 qtt, 
						'AGENT CASH DEVOLUTION' produto,
						isnull((select nome from fl (nolock) where no = fo.no and estab = 0), '') agno,
						0 epv, 
						fo.etotal valor, 
						'' formapag, 
						'EWA' conta_destino, 
						fo.etotal ewa, 
						0 operador, 
						0 agente,
						-fo.etotal  saldo_ewa, 
						0 saldo_op,
						fo.etotal  saldo_ag, 
						'PROCESSED'  status,
						4 tipo
					from fo (nolock) inner join fo2 (nolock) on fo.fostamp=fo2.fo2stamp
					where fo2.u_opno = '" . $no . "' and fo.doccode = 103  and (not('" . $agno . "'!=0) or (fo.no = '" . $agno . "')) and (not('" . $local . "'!='') or (fo.no in (select no from fl where u_local='" . $local . "' and estab= 0 )))

					union all 

					select 
						fo.docdata data, 
						fo.ousrhora,
						0 qtt, 
						'AGENT CASH DEVOLUTION (OPERATOR)' produto,
						isnull((select nome from fl (nolock) where no = fo.no and estab = 0), '') agno,
						0 epv, 
						fo.etotal valor, 
						'' formapag, 
						'OPERATOR' conta_destino, 
						0 ewa, 
						fo.etotal operador, 
						0 agente,
						0  saldo_ewa, 
						-fo.etotal saldo_op,
						fo.etotal  saldo_ag, 
						case when fo.aprovado = 1 then 'PROCESSED' else 'UNPROCESSED' end  status,
						5 tipo
					from fo (nolock) inner join fo2 (nolock) on fo.fostamp=fo2.fo2stamp
					where fo2.u_opno = '" . $no . "' and fo.doccode = 104 and (not('" . $agno . "'!=0) or (fo.no = '" . $agno . "')) and (not('" . $local . "'!='') or (fo.no in (select no from fl where u_local='" . $local . "' and estab= 0 )))
				) x 
				where data between '" . $dataini . "' and '" . $datafim . "'
				)x
				order by data, hora, tipo, produto
			";
		$sql_status = $this->mssql->mssql__select( $query );
		return $sql_status;
	}
	
	public function get_fees( $data ) {
		$query = "
				select 
				ag.nome agnome, 
					prod.u_name pdnome,
					ft.fdata, 
					ft.fno,
					sum(fi.qtt) qtt,
					avg(case when fi.qtt != 0 then fi.etiliquido/fi.qtt else 0 end) epv, 
					sum(fi.etiliquido) ettiliq,
					sum(fi.etiliquido)*agpcom/100 agcom,
					sum(fi.etiliquido)*s4bpcom/100 s4bcom,
					sum(fi.etiliquido)*s4ppcom/100 + s4pvcom s4pcom,
					sum(fi.etiliquido)-sum(fi.etiliquido)*agpcom/100- sum(fi.etiliquido)*s4bpcom/100 - (sum(fi.etiliquido)*s4ppcom/100 + s4pvcom) trec,
					processado,
					sum(fi.etiliquido)*agpcom/100 + sum(fi.etiliquido)*s4bpcom/100 + (sum(fi.etiliquido)*s4ppcom/100 + s4pvcom) tpag,
					enc2.email,
					enc.site
				from 
					ft (nolock)
						inner join fi		(nolock) on ft.ftstamp = fi.ftstamp
						inner join u_ccom	(nolock)  on ft.ftstamp=u_ccom.ftstamp
						inner join bo		(nolock) enc on ft.mhstamp = enc.bostamp
						inner join bo2		(nolock) enc2 on enc.bostamp =enc2.bo2stamp
						inner join bo		(nolock) prod on enc.origem = prod.bostamp 
						inner join fl		(nolock) ag on enc2.TKHDID = ag.no  and ag.estab = 0    
						inner join fl		(nolock) op on enc2.nocts = op.no and op.estab = 0
				where 
						ft.anulado = 0 
					and (ft.tipodoc not in (4,5) or ft.ndoc = 10)
					and ((not '".$data[0]."' != '') or (ft.fdata >= '".$data[0]."'))
					and ((not '".$data[1]."' != '') or (ft.fdata <= '".$data[1]."'))
					and ((not '".$data[2]."' != '') or (ag.flstamp = '".$data[2]."'))
					and ((not '".$data[3]."' != '') or (prod.bostamp = '".$data[3]."'))
					and ((not '".$data[5]."' != '') or (fi.tam = '".$data[5]."'))
					and ((not '".$data[6]."' != '') or (ag.gsecstamp = '".$data[6]."'))
					and op.no='".$data[4]."' --OPERADOR
				group by 
					ag.nome, 
					prod.u_name,
					ft.fdata, 
					ft.fno,
					ft.etotal,
					agpcom,
					s4bpcom,
					s4ppcom,
					s4pvcom,
					processado,
					enc2.email,
					enc.site
				order by 
					ag.nome, 
					prod.u_name,
					ft.fdata, 
					ft.fno

			";
		$sql_status = $this->mssql->mssql__select( $query );
		return $sql_status;
		
	}

	public function check_agent_vat( $vat ) {
		$query = "select top 1 ncont, nome, flstamp, no from fl where ncont = '".$vat."' and fl.estab = 0";
		$sql_status = $this->mssql->mssql__select( $query );
		return $sql_status;
	}
	
	public function update_profile_data( $data ) {
		$data['checkbox'] = json_decode($data['checkbox']);
		
		$update_query = "";
		$update_values = array();
		$update_where = "";
		
		//checkbox
		foreach( $data['checkbox'] as $checkbox ) {
			if (strpos($checkbox[0], 'fl.') !== false) {
				$update_query .= $checkbox[0] . " = '" . $checkbox[1] . "', ";
			}
		}
		
		$update_query = substr($update_query, 0, strlen($update_query) - 2);
		$update_where .= "no = '" . $data['id'] . "' and estab = '" . $data['estab'] . "'";
		
		$query = "update fl set " . $update_query . " where " . $update_where;
		$sql_status = $this->mssql->mssql__execute( $query );
		
		return $sql_status;
	}
	
	public function update_whitelabel( $data ) {
		$res_update = array();
		$data['input'] = json_decode($data['input']);
		$data['checkbox'] = json_decode($data['checkbox']);
		$this->mssql->utf8_decode_deep( $data['input'] );
		
		$update_query = "";
		$update_values = array();
		$update_where = "";
		
		foreach( $data['input']->u_whitelabel as $key=>$value ) {
			$chbfound = 0;
			foreach( $data['checkbox'] as $checkbox ) {
				if( $checkbox[0] == "u_whitelabel." . $key ) {
					$chbfound = 1;
				}
			}
			
			if( !$chbfound ) {
				$update_query .= $key . " = ?, ";
				$update_values[] = $value;
			}
		}
		
		//checkbox
		foreach( $data['checkbox'] as $checkbox ) {
			if (strpos($checkbox[0], 'u_whitelabel.') !== false) {
				$update_query .= $checkbox[0] . " = ?, ";
				$update_values[] = $checkbox[1];
			}
		}
		
		$update_query = substr($update_query, 0, strlen($update_query) - 2);
		$update_where .= "id = '" . $data['id'] . "'";
		
		$query = "update u_whitelabel set " . $update_query . " where " . $update_where;
		$sql_status = $this->mssql->mssql__prepare_exec( $query, $update_values );
		
		$res_update["update_wl"] = $sql_status;
		return $res_update;
	}
	
	public function update_profile( $data ) {
			
		$query = "Update fl set lang ='".$data['lang']."' where no = '".$data['id']."' and estab = " . $data['estab'];
	   
		$sql_status = $this->mssql->mssql__execute( $query );
		
		return $sql_status;
	}
	
	public function get_images($bostamp){
		$query = "select img from u_pimg where bostamp = '".$bostamp."'";
		$sql_status = $this->mssql->mssql__select( $query );
		return $sql_status;
	}
	
	public function get_categ_mssql(){
		$query = "select * from u_categ";
		$sql_status = $this->mssql->mssql__select( $query );
		return $sql_status;
	}
	
	public function get_pcateg_mssql($bostamp){
		$query = "select * from u_pcateg where bostamp = '".$bostamp."'";
		$sql_status = $this->mssql->mssql__select( $query );
		return $sql_status;
	}
	
	public function get_agent( $id ) {
		$query = "
			select * 
			from fl 
			where 
					no=".$id." 
				and estab = 0
				and inactivo = 0 
				and FL.U_AGENTE  = 'Sim'
							
		";		
		$sql_status = $this->mssql->mssql__select($query );			
		return $sql_status;
	}
	
	public function insert_fee($bostamp,$no,$nome, $opstamp, $comissao){

	   $query = "
	   BEGIN TRANSACTION [Tran1];
	   BEGIN TRY 

	   DECLARE @stamp VARCHAR(25);

	   SET @stamp = CONVERT(VARCHAR(25), (select UPPER(suser_sname())+left(newid(),5)+right(newid(),5)+ left(newid(),5)+right(newid(),5)));
	   ";                                            
	   
	   
	   $query .= "
	   INSERT INTO 
			u_pagent (u_pagentstamp,bostamp,no,nome,opstamp,comissao, ousrinis, ousrdata, ousrhora, usrinis, usrdata, usrhora)
	   VALUES
	   (
		   @stamp,
		   '" . $bostamp . "',
		   (select no from bo where bostamp ='".$bostamp."'),
		   (select nome from bo where bostamp ='".$bostamp."'),
		   '".$opstamp."',
		   '".$comissao."',
		   UPPER(suser_sname()),
		   CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000',
		   CONVERT(VARCHAR(5), GETDATE(), 8),
		   UPPER(suser_sname()),
		   CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000',
		   CONVERT(VARCHAR(5), GETDATE(), 8)
	   );";
	   
	   $query .= ";

	   COMMIT TRANSACTION [Tran1] 
	   END TRY 
	   BEGIN CATCH 
	   ROLLBACK TRANSACTION [Tran1] 
	   PRINT ERROR_MESSAGE() 
	   END CATCH
	   ";             
	   
	   $sql_status = $this->mssql->mssql__execute( $query );
	   return $sql_status;
                               
    }
	
	
	public function update_fee($bostamp,$comissao){
                                               
	   $query = "Update u_pagent set comissao ='".$comissao."' where bostamp like '".$bostamp."'";
	   
	   $sql_status = $this->mssql->mssql__execute( $query );
	   return $sql_status;
				   
	}
	
	public function get_image_voucher($bostamp){
		$query = "select u_imgvouch from bo3 where bo3stamp = '".$bostamp."'";
		$sql_status = $this->mssql->mssql__select( $query );
		return $sql_status;
	}
	
	public function insert_wl_sl_img($id,$image,$no){
			
		$query = "
		BEGIN TRANSACTION [Tran1];
		BEGIN TRY 

		DECLARE @stamp VARCHAR(25);

		SET @stamp = CONVERT(VARCHAR(25), (select UPPER(suser_sname())+left(newid(),5)+right(newid(),5)+ left(newid(),5)+right(newid(),5)));
		";			
		
		
		$query .= "
		INSERT INTO 
			u_wlimg (u_wlimgstamp, id, wl_id, img, no, ousrinis, ousrdata, ousrhora, usrinis, usrdata, usrhora)
		VALUES
		(
			@stamp,
			isnull((select max(id)+1 from u_wlimg), 1),
			'".$id."',
			'" . $image . "',
			'".$no."',
			UPPER(suser_sname()),
			CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000',
			CONVERT(VARCHAR(5), GETDATE(), 8),
			UPPER(suser_sname()),
			CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000',
			CONVERT(VARCHAR(5), GETDATE(), 8)
		);";
		
		$query .= ";

		COMMIT TRANSACTION [Tran1] 
		END TRY 
		BEGIN CATCH 
		ROLLBACK TRANSACTION [Tran1] 
		PRINT ERROR_MESSAGE() 
		END CATCH
		";	
		
		// log_message("ERROR", $query);
		
		$sql_status = $this->mssql->mssql__execute( $query );
		return $sql_status;
		
	}
	
	public function insert_image($bostamp,$image){
			
		$query = "
		BEGIN TRANSACTION [Tran1];
		BEGIN TRY 

		DECLARE @stamp VARCHAR(25);

		SET @stamp = CONVERT(VARCHAR(25), (select UPPER(suser_sname())+left(newid(),5)+right(newid(),5)+ left(newid(),5)+right(newid(),5)));
		";			
		
		
		$query .= "
		INSERT INTO 
			u_pimg (u_pimgstamp,bostamp,img, ousrinis, ousrdata, ousrhora, usrinis, usrdata, usrhora)
		VALUES
		(
			@stamp,
			'" . $bostamp . "',
			'".$image."',
			UPPER(suser_sname()),
			CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000',
			CONVERT(VARCHAR(5), GETDATE(), 8),
			UPPER(suser_sname()),
			CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000',
			CONVERT(VARCHAR(5), GETDATE(), 8)
		);";
		
		$query .= ";

		COMMIT TRANSACTION [Tran1] 
		END TRY 
		BEGIN CATCH 
		ROLLBACK TRANSACTION [Tran1] 
		PRINT ERROR_MESSAGE() 
		END CATCH
		";	
		
		$sql_status = $this->mssql->mssql__execute( $query );
		return $sql_status;
		
	}
	
	public function update_image_voucher($bostamp,$image){
		$query = "Update bo3 set u_imgvouch ='".$image."' where bo3stamp like '".$bostamp."'";
		$sql_status = $this->mssql->mssql__execute( $query );
		return $sql_status;
	}
	
	public function remove_image($bostamp ,$image){
		$query = "delete from u_pimg where bostamp like '" . $bostamp . "' and img like '".$image."'";
		$sql_status = $this->mssql->mssql__execute( $query );
		return $sql_status;
	}
	
	public function get_white_label( $user_id ) {
		$query = "select top 1 * from u_whitelabel where no = ".$user_id;
		$sql_status = $this->mssql->mssql__select( $query );
		return $sql_status;
	}
	
	public function get_white_label_slider_img( $id ) {
		$query = "select * from u_wlimg inner join u_whitelabel on u_wlimg.wl_id = u_whitelabel.id where u_whitelabel.id = ".$id;
		$sql_status = $this->mssql->mssql__select( $query );
		return $sql_status;
	}
	
	public function generateRandomString($length = 5) {
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return $randomString;
	}
	
	public function wl_delete_logo() {
		$filename = $this->input->post('name');
		$id = $this->input->post('id');
		$targetFile = base_url() . 'image_product/'.$filename;
		$targetFile_local = getcwd() . '/image_product/'.$filename;

		if( file_exists($targetFile_local) ){
			unlink($targetFile_local);
		}
		
		$result=$this->update_wl_logo($id, '');
		echo $result ;
    }
	
	public function wl_delete_slimg( $data ) {
		$filename = $data['name'];
		$id = $data['id'];
		$targetFile = base_url() . 'image_product/'.$filename;
		$targetFile_local = getcwd() . '/image_product/'.$filename;

		if( file_exists($targetFile_local) ){
			unlink($targetFile_local);
		}
		
		$query = "delete from u_wlimg where wl_id = '" . $id . "' and img like '".$filename."'";
		$sql_status = $this->mssql->mssql__execute( $query );
	
		echo $sql_status;
    }
	
	public function wl_upload_logo( $data ) {
        if (!empty($_FILES)) {
			$tempFile = $_FILES['file']['tmp_name'];
			$fileName = $_FILES['file']['type'];
			$currentSection = explode("/",$fileName);
			$currentSection = $currentSection[1];
			$id = $_POST['id'];
			$targetPath = base_url() . 'image_product/';
			$targetPath_local = getcwd() . '/image_product/';
			$random = $this->generateRandomString();
			$date_str = date('m-d-Y_his');
			$targetFile = $random.$date_str.'.'.$currentSection ;
			$targetFile_local = $targetPath_local.$random.$date_str.'.'.$currentSection ;
			move_uploaded_file($tempFile, $targetFile_local);
			
			$result = $this->update_wl_logo($id, $targetFile);
        }
		echo $result;
    }
	
	public function update_wl_logo($id, $img){
		$query = "update u_whitelabel set logo = '".$img."' where id = ".$id;
		$sql_status = $this->mssql->mssql__execute( $query );
		return $sql_status;
	}
	
	public function get_agent_fee( $id ) {
		$query = "
			select 
				fo.data, fo.etotal, fo.adoc, fn.design, 
				fo.u_docpath, 
				case   
						when fo.aprovado= 0 then 'WAITING APPROVAL'
						when fo.aprovado= 1 and isnull(pl.process, 0)= 0 then 'APPROVED' 
						when fo.aprovado= 1 and isnull(pl.process, 0)= 1 then 'PROCESSED' 
				end status
			from 
				fo 
					inner join fn on fo.fostamp = fn.fostamp 
					left join 
					(
						fc inner join pl on pl.fcstamp = fc.fcstamp
					)
					on fo.fostamp = fc.fostamp 
						 
			where doccode = 100 and fo.no = " . $id . "
		";

		$result = $this->mssql->mssql__select( $query );
		return $result;
	}
	
	public function get_productfee( $id, $op ) {
		$query = "
			select ltrim(rtrim(prod.bostamp)) bostamp, prod.u_name name, isnull(comissao,0) fee, case when  EXISTS(select 1 from bo where bostamp = u_pagent.bostamp) then 1 else 0 end ins
			from 
				bo (nolock) prod 
				left join u_pagent (nolock) on prod.bostamp = u_pagent.bostamp and u_pagent.no = ".$id."
			where 
					prod.no =".$op." 
				and prod.estab = 0
				and prod.fechada = 0
				and prod.ndos = 1
							
		";		
		$sql_status = $this->mssql->mssql__select($query );			
		return $sql_status;
	}
	
	public function get_productfee_agent( $id, $op ) {
		$query = "
			select ltrim(rtrim(u_pagent.bostamp)) bostamp, prod.u_name name, isnull(comissao,0) fee
			from 
				bo (nolock) prod 
				left join u_pagent (nolock) on prod.bostamp = u_pagent.bostamp and u_pagent.no = ".$id."
			where 
					prod.no =".$op." 
				and prod.estab = 0
				and prod.fechada = 0
				and prod.ndos = 1
				and u_pagent.bostamp = prod.bostamp
							
		";		
		$sql_status = $this->mssql->mssql__select($query );			
		return $sql_status;
	}
	
	public function insert_agent_product_fee( $bostamp, $no, $comissao ){
                                               
	   $query = "
			INSERT INTO u_pagent (u_pagentstamp,bostamp,no,nome,opstamp,comissao, ousrinis, ousrdata, ousrhora, usrinis, usrdata, usrhora)
			SELECT	
				CONVERT(VARCHAR(25), (select UPPER(suser_sname())+left(newid(),5)+right(newid(),5)+ left(newid(),5)+right(newid(),5))),		
				'".$bostamp."', 
				".$no.",
				fl.nome, 
				isnull((select flstamp from fl (nolock) where estab = 0 and no = isnull((select no from bo (nolock) where bostamp='".$bostamp."' and estab = 0),0)),''), 
				".$comissao.",
				UPPER(suser_sname()),
				CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000',
				CONVERT(VARCHAR(5), GETDATE(), 8),
				UPPER(suser_sname()),
				CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000',
				CONVERT(VARCHAR(5), GETDATE(), 8)
			from fl 
			where no=".$no." and estab = 0 
		";
	   
	   $sql_status = $this->mssql->mssql__execute( $query );
	   return $sql_status;
    }
	
	public function get__last10_agent_reibursements( $no, $estab ) {
		$query = "
			select top 10 *
			from fo (nolock)
				inner join fo2 (nolock) on fo.fostamp = fo2.fo2stamp
				inner join fl op (nolock) on fo2.u_opno = op.no and op.estab = 0
			where fo.no = '" . $no . "' and fo.estab = '" . $estab . "' and fo.doccode = 104
			order by fo.ousrdata desc, fo.ousrhora desc
		";		
		$query = $this->mssql->mssql__select($query );			
		return $query;
	}
	
	public function get_reimbursements_mssql( $data ) {
		$query = "
			select fo.*, fo2.*
			from fo (nolock)
				inner join fo2 (nolock) on fo.fostamp = fo2.fo2stamp
				inner join fl op (nolock) on fo2.u_opno = op.no and op.estab = 0
			where 
				fo2.u_opno = '" . $data["no"] . "' and 
				fo.estab = 0 and 
				((not '".$data["ag"]."' != '') or (fo.no = '".$data["ag"]."')) and
				((not '".$data["status"]."' != '') or (fo.aprovado = '".$data["status"]."')) and
				((not '".$data["dataini"]."' != '') or (fo.data >= '".$data["dataini"]."')) and
				((not '".$data["datafim"]."' != '') or (fo.data <= '".$data["datafim"]."')) and
				fo.doccode = 104
			order by fo.ousrdata desc, fo.ousrhora desc
		";
		
		$query = $this->mssql->mssql__select($query );			
		return $query;
	}
	
	public function set_reimbursements_processed( $data ) {
		$query = "
			update fo
			set aprovado = 1
			from fo inner join fo2 on fo.fostamp = fo2.fo2stamp
			where
				fo2.u_opno = '" . $data["no"] . "' and
				fo.estab = 0 and
				fo.fostamp in (" . implode(",", $data["fostamps"]) . ")
		";
		
		$query = $this->mssql->mssql__execute($query );			
		return $query;
	}
	
	public function agent_insert_reimbursement( $data ) {
		
		$query = "
         BEGIN TRANSACTION [Tran1];
         BEGIN TRY 

         declare 
            @adoc varchar(20), @formapag varchar(1), @no decimal(10), @opno decimal(10), @valor decimal(16,6), @data datetime, @design varchar(60), 
            @fostamp varchar(25), @fnstamp varchar(25), @ref varchar(18), 
            @eivain decimal(16,6), @eivav2 decimal(16,6), @ettiva decimal(16,6), @tabiva decimal(5), @iva decimal(5)


            set @no = ".$data['no']."
            set @valor = ".$data['amount']."
            set @opno = ".$data['opno']."
            set @adoc = isnull((select max(convert(decimal(10), adoc)) + 1 from fo (nolock) where doccode=104), 1)
            set @formapag = '".$data['formapag']."'

            set @fostamp = suser_sname()+left(newid(),5)+right(newid(),5)+ left(newid(),5)+right(newid(),5) 
            set @fnstamp = suser_sname()+left(newid(),5)+right(newid(),5)+ left(newid(),5)+right(newid(),5)
            set @ref = 'DEVCASH'
            set @data = convert(date, getdate())

            select 
                @eivain = round(@valor/(1+(case when isnull(taxasiva.codigo, 2)= 0 then 23 else isnull(taxasiva.taxa, 23) end)/100), 2),
                @eivav2 = case 
					   when (case when isnull(taxasiva.codigo, 2)= 0 then 2 else isnull(taxasiva.codigo, 2) end) = 2 
					   then @valor - round(@valor/(1+(case when isnull(taxasiva.codigo, 2)= 0 then 23 else isnull(taxasiva.taxa, 23) end)/100), 2) 
					   else 0 
					end, 
                @ettiva = @valor - round(@valor/(1+(case when isnull(taxasiva.codigo, 2)= 0 then 23 else isnull(taxasiva.taxa, 23) end)/100), 2),
                @tabiva = (case when isnull(taxasiva.codigo, 2)= 0 then 2 else isnull(taxasiva.codigo, 2) end),
                @iva = (case when isnull(taxasiva.codigo, 2)= 0 then 23 else isnull(taxasiva.taxa, 23) end)
            from fl left join taxasiva (nolock) on fl.tabiva = taxasiva.codigo

            where no = @no and estab = 0

		  INSERT INTO dbo.fo 
		  ( 
				fostamp, 
				docnome, 
				adoc, 
				nome, 
				etotal, 
				data, 
				docdata, 
				foano, 
				doccode, 
				no, 
				estab, 
				moeda, 
				pdata, 
				eivain, 
				ettiva, 
				ettiliq,
				epaivav2, 
				epaivain, 
				epatotal, 
				memissao, 
				eivav2, 
				morada, 
				local, 
				codpost, 
				ncont, 
				nome2, 
				ousrinis, 
				ousrdata, 
				ousrhora, 
				usrinis, 
				usrdata, 
				usrhora
		  ) 
		  select
				@fostamp, 
				isnull((select top 1 cmdesc from cm1 (nolock) where cm=104), ''), 
				@adoc, 
				fl.nome, 
				@valor, 
				@data, 
				@data, 
				year(@data), 
				104, 
				fl.no, 
				0, 
				'EURO', 
				@data, 
				@eivain, 
				@ettiva, 
				@eivain, 
				@eivav2,
				@eivain,  
				@valor, 
				'EURO', 
				@eivav2, 
				fl.morada, 
				fl.local, 
				fl.codpost, 
				fl.ncont, 
				fl.nome2, 
				isnull((select iniciais from us (nolock) where username= suser_sname()), ''),
				convert(date, getdate()), 
				left(convert(time, getdate()),8),
				isnull((select iniciais from us (nolock) where username= suser_sname()), ''),
				convert(date, getdate()), 
				left(convert(time, getdate()),8)
		  from fl (nolock) 
		  where no = @no and estab = 0

		  INSERT INTO dbo.fo2
		  (
				fo2stamp, 
				ivatx1, 
				ivatx2, 
				ivatx3, 
				olcodigo, 
				taxpointdt, 
				u_opno,
				formapag
		  )
		  values
		  (
				@fostamp,
				6, 
				23, 
				13, 
				'P00001',
				@data, 
				@opno,
				@formapag
		  )

		  INSERT INTO dbo.fot
		  (
				fotstamp, 
				fostamp,
				codigo, 
				ebaseinc, 
				evalor
		  )
		  values
		  (
				suser_sname()+left(newid(),5)+right(newid(),5)+ left(newid(),5)+right(newid(),5), 
				@fostamp,
				@tabiva, 
				@eivain,  
				@ettiva
		  )


		  INSERT INTO dbo.fn
		  (
				fnstamp,
				fostamp,
				lordem,
				ref, 
				design, 
				docnome, 
				adoc, 
				qtt, 
				iva, 
				tabiva, 
				armazem, 
				lrecno, 
				data, 
				etiliquido, 
				epv, 
				eslvu, 
				esltt,
								ivaincl,
				stns, 
				familia, 
				ousrinis, 
				ousrdata, 
				ousrhora, 
				usrinis, 
				usrdata, 
				usrhora 
		  )
		  values
		  (
				@fnstamp, 
				@fostamp,
				1000,
				@ref, 
				isnull((select design from st (nolock) where ref=@ref), ''), 
				isnull((select top 1 cmdesc from cm1 (nolock) where cm=100), ''), 
				@adoc, 
				1, 
				@iva,
				@tabiva, 
				1, 
				@fnstamp, 
				@data, 
				@eivain, 
				@eivain, 
				@eivain, 
				@eivain, 
								isnull((select IVAPCINCL from st (nolock) where ref = @ref), 0),
				isnull((select stns from st (nolock) where ref = @ref), 0),
				isnull((select familia from st (nolock) where ref = @ref), ''),
				isnull((select iniciais from us (nolock) where username= suser_sname()), ''),
				convert(date, getdate()), 
				left(convert(time, getdate()),8),
				isnull((select iniciais from us (nolock) where username= suser_sname()), ''),
				convert(date, getdate()), 
				left(convert(time, getdate()),8)
		  )

         COMMIT TRANSACTION [Tran1] 
         END TRY 
         BEGIN CATCH 
         ROLLBACK TRANSACTION [Tran1] 
         PRINT ERROR_MESSAGE() 
         END CATCH
         ";
         
         $sql_status = $this->mssql->mssql__execute( $query );
         return $sql_status;
		
	}
	
	
	public function update_agent_product_fee($bostamp,$no,$comissao){
                                               
	   $query = "Update u_pagent set comissao ='".$comissao."' where bostamp = '".$bostamp."' and no=".$no."";
	   
	   $sql_status = $this->mssql->mssql__execute( $query );
	   return $sql_status;
				   
	}
	
	public function delete_agent_product_fee($bostamp,$no){
	   $query = "delete from u_pagent where bostamp = '".$bostamp."' and no=".$no."";
	   $sql_status = $this->mssql->mssql__execute( $query );
	   return $sql_status;
				   
	}
	
	public function get_orders( $data ) {
	$var ="";
	$var1 ="";
	if($data[7] == "Sim"){
		$var = "NOCTS";
		$var1 = "TKHDID";
	}else{
		$var = "TKHDID";
		$var1 = "NOCTS";
	}
	$query = "
	select bostamp,bo.nome name, isnull((select u_name from bo a where bostamp=bo.origem), '') product, bo.dataobra date, bo.obrano orderno, BO2.ngstatus status
	from bo (nolock)
	inner join bo2 (nolock) on bo.bostamp = bo2.bo2stamp
	inner join bo3 (nolock) on bo.bostamp = bo3.bo3stamp
	inner join fl (nolock) on bo2.".$var."  =fl.no and bo.estab=fl.estab
	where bo.ndos = 4 
	and BO2.".$var."  =".$data[4]."
	and ((not '".$data[0]."' != '') or (bo.dataobra >= '".$data[0]."'))
	and ((not '".$data[1]."' != '') or (bo.dataobra <= '".$data[1]."'))
	and ((not '".$data[3]."' != '') or (BO.origem = '".$data[3]."'))
	and ((not '".$data[2]."' != '') or (BO2.".$var1." =  '".$data[2]."'))
	and ((not '".$data[5]."' != '') or (BO2.IDENTIFICACAO1 =  '".$data[5]."'))
	and ((not '".$data[6]."' != '') or (fl.ZONA = '".$data[6]."'))
	";
	//log_message("ERROR",$query );
	$sql_status = $this->mssql->mssql__select( $query );
	return $sql_status;

	}

	public function create_order( $data ) {
		
		$query = "";
		$user = $data['user'];	
		$this->mssql->utf8_decode_deep( $data );
		
		$bostamp = $data['reservation_bostamp'];
		$date = $data['reservation_date'];
		$date = explode("/", $date);
		$day = $date[1];
		$month = $date[0];
		$year = $date[2];
		$data_formatada = date("Ymd", strtotime("$year-$month-$day"));
		$origem = $data['origin'];
		
		if($origem == "WHITELABEL") {
			if( $data["client_type"] == "agent" ) {
				$agente = $_SESSION['user_id'];
			}
			else {
				$agente = 0;
			}
		}
		else {
			$agente = 1;
		}
		
		if( $data["client_type"] == "agent" ) {
			$client_name = $data["PaymentData"]['pay_client_name'];
			$client_address = $data["PaymentData"]['pay_client_address'];
			$client_postcode = $data["PaymentData"]['pay_client_postcode'];
			$client_city = $data["PaymentData"]['pay_client_city'];
			$client_country = $data["PaymentData"]['pay_client_country'];
			$client_vat = $data["PaymentData"]['pay_client_vat'];
			$client_email = $data["PaymentData"]['pay_client_email'];
			$client_num = 0;
		}
		else {
			$client_name = $user["first_name"] . ' ' . $user["last_name"];
			$client_address = $user["invoice_address_street"];
			$client_postcode = $user["invoice_address_postcode"];
			$client_city = $user["invoice_address_addinfo"];
			$client_country = $user["invoice_address_country"];
			$client_vat = $user["tax_number"];
			$client_email = $user["email"];
			$client_num = $user["id"];
		}
		
		if( trim($client_name) == '' )
			$client_name = 'Consumidor Final';
		
		if( isset($data["PaymentData"]["PaymentType"]) && ( $data["PaymentData"]["PaymentType"] == 4 || $data["PaymentData"]["PaymentType"] == 5) ) {
			$payment_status = "PROCESSED";
			
			$pay_transaction_id = $data["PaymentData"]['pay_transaction_id'];
			$pay_checked_cash = $data["PaymentData"]['pay_checked_cash'];
			
			if( $data["PaymentData"]["PaymentType"] == 4 ) {
				$payment_type = "TPA-MB";
			}
			else if( $data["PaymentData"]["PaymentType"] == 5 ) {
				$payment_type = "CASH";
			}
			
			$pay_brand = '';
		}
		else {
			$payment = $data['payment'];
			
			if( $payment['STATUS'] == 5 ) {
				$payment_status = "PROCESSED";
			}
			else {
				$payment_status = "WAITING PAYMENT";
			}
			
			$payment_type = "CC/DC";
			$pay_brand = $payment['BRAND'];
		}
		//operador
		$this->db->select('
		no,
		nome
		');
		$this->db->from('bo');
		$this->db->where('bo.bostamp', $bostamp);
		$query_sql = $this->db->get();
		$query_sql = $query_sql->result_array();
		
		if( sizeof($query_sql) > 0 ) {
			foreach( $query_sql as $row ) {
				$operador_id = $row["no"];
				$operador_nome = $row["nome"];
			}
		}
		else {
			$operador_id = '';
			$operador_nome = '';
		}
		
		//produto
		$this->db->select('
		*
		');
		$this->db->from('bo');
		$this->db->join('bo2', 'bo.bostamp = bo2.bo2stamp');
		$this->db->join('bo3', 'bo.bostamp = bo3.bo3stamp');
		$this->db->where('bo.bostamp', $bostamp);
		$query_sql = $this->db->get();
		$produto_dados = $query_sql->result_array();
		
		$cart = $data['checkout_cart'];
		$this->mssql->utf8_decode_deep( $cart );
		$ihour = $cart[0]['session_hour'];
		
		//stamp sessao
		if( $produto_dados[0]["u_quicksel"] == 0 ) {
			$this->db->select('
			u_psessstamp
			');
			$this->db->from('u_psess');
			$this->db->join('bo', 'u_psess.bostamp = bo.bostamp');
			$this->db->join('bo3', 'bo.bostamp = bo3.bo3stamp');
			$this->db->where('bo.bostamp', $bostamp);
			$this->db->where('u_psess.ihour', $ihour);
			$query_sql = $this->db->get();
			$sessao = $query_sql->result_array();
			
			if( sizeof($sessao) > 0 ) {
				$sessao = $sessao[0]["u_psessstamp"];
			}
			else {
				$sessao = '';
			}
		}
		else {
			$sessao = 'QS';
		}
		
		$dfx_data = $this->phc_model->get_drivefx_credential( $operador_id );
		
		//ini var
		$subtotal = 0;
		$vat = 0;
		$other_taxes = 0;
		$total = 0;
		$voucher_value = 0;
		$voucher_discount = 0;
		
		//Taxa IVA
		$taxa_iva = -1;
		$cod_iva = -1;
		$default_tabiva = 2;
		$default_taxaiva = 23;
		
		$taxasiva = $data['taxasiva'];
		foreach( $taxasiva as $taxaiva ) {
			if( sizeof($produto_dados)>0 && $taxaiva["codigo"] == $produto_dados[0]["u_tabiva"] ) {
				$taxa_iva = floatval($taxaiva["taxa"]);
				$cod_iva = $produto_dados[0]["u_tabiva"];
			}
		}
		if( $taxa_iva == -1 || $cod_iva == -1 ) {
			$cod_iva = $default_tabiva;
			$taxa_iva = $default_taxaiva;
		}
		
		//Last Minute
		$lastminute_taxes = $data['lastminute_taxes'];
		if( sizeof($lastminute_taxes)>0 ) {
			foreach( $lastminute_taxes as $lastminute_tax ) {
				foreach( $cart as $key => $cart_prod ) {
					if( $lastminute_tax["formula"] == "-%" ) {
						$cart[$key]["unit_price"] = $cart_prod["unit_price"] = $cart_prod["unit_price"] * ( 1 - ($lastminute_tax["value"]/100) );
					}
					else if( $lastminute_tax["formula"] == "-v" ) {
						$cart[$key]["unit_price"] = $cart_prod["unit_price"] - $lastminute_tax["value"];
					}
				}
			}
		}

		//Calculo subtotal
		foreach( $cart as $cart_prod ) {
			$subtotal += $cart_prod["qtt"] * $cart_prod["unit_price"];
		}
		
		//Voucher
		$voucher = $data['voucher'];
		$vouch_code = '';
		$vouch_formula = '';
		$vouch_value = 0;
		if( isset($voucher["code"]) && $voucher["code"] != '' ) {
			switch( $voucher["formula"] ) {
				case '- %':
					$voucher_value -= $subtotal * floatval( $voucher["value"] ) / 100;
					$voucher_discount = $voucher["value"];
					break;
				case '- V':
					$voucher_value -=  floatval( $voucher["value"] );
					$voucher_discount = number_format($voucher["value"] / $subtotal * 100, 2, '.', '');
					break;
			}
			
			$vouch_code = $voucher["code"];
			$vouch_formula = $voucher["formula"];
			$vouch_value = $voucher["value"];
		}	
		
		//Taxas
		$taxes = $data['taxes'];
		foreach( $taxes as $tax ) {
			$cur_tax_value = 0;
			switch( $tax["formula"] ) {
				case '+%':
					$cur_tax_value += ($subtotal + $voucher_value) * floatval( $tax["value"] ) / 100;
					break;
				case '-%':
					$cur_tax_value -= ($subtotal + $voucher_value) * floatval( $tax["value"] ) / 100;
					break;
				case '+v':
					$cur_tax_value +=  floatval( $tax["value"] );
					break;
				case '-v':
					$cur_tax_value -=  floatval( $tax["value"] );
					break;
			}
			$other_taxes += $cur_tax_value;
			
			$tmp_row = array();
			$tmp_row['ref'] = 'TAX';
			$tmp_row['desc'] = $tax["design"];
			$tmp_row['cor'] = '';
			$tmp_row['tam'] = '';
			$tmp_row['qtt'] = 1;
			$tmp_row['unit_price'] = number_format($cur_tax_value, 2, '.', '');
			$tmp_row['occupied'] = 0;
			$tmp_row['date'] = '';
			$tmp_row['session_hour'] = '';
			
			$cart[] = $tmp_row;
		}
		
		//faturar pelo drivefx
		if( sizeof($dfx_data) > 0 && $dfx_data[0]["U_FTAUTO"] && sizeof($produto_dados) > 0 && !$produto_dados[0]["marcada"] ) {
			$this->load->library('drivefx');
			
			$this->drivefx->set_credentials( $dfx_data[0]["U_DFXURL"], $dfx_data[0]["U_DFXUSER"], $dfx_data[0]["U_DFXPASS"], $dfx_data[0]["U_DFXTYPE"], $dfx_data[0]["U_DFXCOMP"] );
			$this->drivefx->login();
			$this->drivefx->get_td();
			$this->drivefx->get_client();
			
			$dados_ft_lin = array();
			
			foreach( $cart as $cart_prod ) {
				if( substr($cart_prod["ref"], 0, 1) == 'P' || substr($cart_prod["ref"], 0, 1) == 'R') {
					$dfx_desconto = $voucher_discount;
					$dfx_tabiva = $cod_iva;
					$dfx_taxaiva = $taxa_iva;
				}
				else {
					$dfx_desconto = 0;
					$dfx_tabiva = $default_tabiva;
					$dfx_taxaiva = $default_taxaiva;
				}

				$dados_ft_lin[] = array( 
					"ref" => $cart_prod["ref"], 
					"design" => $cart_prod["desc"], 
					"epv" => $cart_prod["unit_price"], 
					"qtt" => $cart_prod["qtt"], 
					"desconto" => $dfx_desconto,
					"tabiva" => $dfx_tabiva,
					"taxaiva" => $dfx_taxaiva,
				);
			}
			
			foreach( $dados_ft_lin as $linha ) {
				$this->drivefx->get_product($linha["ref"], $linha["design"]);
			}
			
			$dados_ft_cab = array( "nome" => $client_name, "ncont" => $client_vat, "morada" => $client_address, "codpost" => $client_postcode, "local" => $client_city, "email" => $client_email );
			
			$num_fat = $this->drivefx->get_fatura( $dados_ft_lin, $dados_ft_cab );
			
			$this->drivefx->set_report();
			
			$dados_email = array( 
								"email" => $client_email, 
								"from" => "info@soft4booking.com", 
								"subject" => "Envio de N/Fatura nº$num_fat", 
								"body" => "Em anexo enviamos o documento: N/Fatura nº$num_fat" );
			
			$this->drivefx->envia_email( $dados_email );
			
			if( trim($this->drivefx->error) != '' )
				log_message("ERROR", "ERROR_DFX: " . print_r(trim($this->drivefx->error), true));
			
			$this->drivefx->logout();
		}
		
		$query .= "
		BEGIN TRANSACTION [Tran1];
		BEGIN TRY 

		DECLARE @stamp VARCHAR(25);
		DECLARE @numero INT;

		SET @stamp = CONVERT(VARCHAR(25), (select UPPER(suser_sname())+left(newid(),5)+right(newid(),5)+ left(newid(),5)+right(newid(),5)));
		SET @numero = isnull((select max(obrano) + 1 from bo where ndos = " . $this->ndos . " and boano = YEAR(GETDATE())), 1);
		";
		
		$ordem = 10000;
		
		foreach( $cart as $cart_prod ) {
			$query .= "
			INSERT INTO 
				bi (bistamp, bostamp, nmdos, ndos, no, cor, tam, obrano, rdata, lobs2, ref, design, qtt, desconto, armazem, lordem, unidade, epcusto, epu, edebito, ettdeb, tabiva, iva, ivaincl, ousrinis, ousrdata, ousrhora, usrinis, usrdata, usrhora, stipo, rescli, resfor, resrec, resusr) 
			values 
			( 
				CONVERT(VARCHAR(25), (select UPPER(suser_sname())+left(newid(),5)+right(newid(),5)+ left(newid(),5)+right(newid(),5))), 
				@stamp, 
				'" . $this->nmdos . "', 
				" . $this->ndos . ", 
				" . $this->no . ", 
				'" . $cart_prod["cor"] . "', 
				'" . $cart_prod["tam"] . "', 
				@numero, 
				CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000', 
				'', 
				'".$cart_prod["ref"]."', 
				'".$cart_prod["desc"]."', 
				" . $cart_prod["qtt"] . ", 
				" . ( (substr($cart_prod["ref"], 0, 1) == 'P' || substr($cart_prod["ref"], 0, 1) == 'R') ? $voucher_discount : 0 ) . ", 
				1, 
				" . $ordem . ", 
				'UN', 
				0, 
				" . $cart_prod["unit_price"] . ", 
				" . $cart_prod["unit_price"] . ", 
				" . ($cart_prod["qtt"] . "*" . $cart_prod["unit_price"]) . ", 
				" . ( (substr($cart_prod["ref"], 0, 1) == 'P' || substr($cart_prod["ref"], 0, 1) == 'R') ? $cod_iva : $default_tabiva ) . ", 
				" . ( (substr($cart_prod["ref"], 0, 1) == 'P' || substr($cart_prod["ref"], 0, 1) == 'R') ? $taxa_iva : $default_taxaiva ) . ", 
				1,
				UPPER(suser_sname()), 
				CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000', 
				CONVERT(VARCHAR(5), GETDATE(), 8), 
				UPPER(suser_sname()), 
				CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000', 
				CONVERT(VARCHAR(5), GETDATE(), 8), 
				1, 
			   isnull((select top 1 rescli from ts where ndos =" . $this->ndos . "),0), 
			   isnull((select top 1 resfor from ts where ndos =" . $this->ndos . "),0), 
			   isnull((select top 1 resrec from ts where ndos =" . $this->ndos . "),0), 
			   isnull((select top 1 resusr from ts where ndos =" . $this->ndos . "),0) 
			);
			";
			
			$ordem += 10000;
		}
		
		$total = $subtotal + $other_taxes + $voucher_value;
		$vat = round($total - ( $total/ (1 + ($taxa_iva/100)) ), 2);
		
		$query .= "
		INSERT INTO 
			bo (bostamp, nmdos, ndos, etotaldeb, etotal, no, nome, morada, local, codpost, nopat, ncont, obrano, boano, dataobra, ousrinis, ousrdata, ousrhora, usrinis, usrdata, usrhora, memissao, moeda, site, origem)
		VALUES
		(
			@stamp, 
			'" . $this->nmdos . "', 
			" . $this->ndos . ", 
			" . $total . ", 
			" . $total . ", 
			" . $this->no . ", 
			'" . $client_name . "', 
			'" . $client_address . "', 
			'" . $client_city . "', 
			'" . $client_postcode . "', 
			" . $client_num . ", 
			'" . $client_vat . "', 
			@numero, 
			YEAR(GETDATE()), 
			CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000',
			UPPER(suser_sname()),
			CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000',
			CONVERT(VARCHAR(5), GETDATE(), 8),
			UPPER(suser_sname()),
			CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000',
			CONVERT(VARCHAR(5), GETDATE(), 8),
			'EURO',
			'EURO',
			'".$origem."',
			'" . $bostamp . "'
		);

		INSERT INTO bo2 (bo2stamp, idserie, tiposaft, ngstatus, tkhdid, nocts, nomects, email, identificacao1, consfinal, identificacao2) values 
		(
			@stamp, 
			'BO', 
			(select top 1 tiposaft from ts where ndos = " . $this->ndos . "), 
			'" . $payment_status . "', 
			" . $agente . ",
			" . $operador_id . ",
			'" . $operador_nome . "',
			'" . $client_email . "',
			'" . $pay_brand . "',
			1,
			'" . $payment_type . "'
		)
		
		INSERT INTO bo3 (bo3stamp, u_sessdate, u_psessstp, u_vouch, u_voucht, u_vouchv) values 
		(
			@stamp, 
			'" . $data_formatada . "', 
			'" . $sessao . "',
			'" . $vouch_code . "',
			'" . $vouch_formula . "',
			" . $vouch_value . "
		)

		";
		
		$query .= ";

		COMMIT TRANSACTION [Tran1] 
		END TRY 
		BEGIN CATCH 
		ROLLBACK TRANSACTION [Tran1] 
		PRINT ERROR_MESSAGE() 
		END CATCH
		";		
		
		$sql_status = $this->mssql->mssql__execute( $query );
		return $sql_status;
		
	}
	
}