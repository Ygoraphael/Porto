<div class="row-fluid">
	<div class="span3 statbox purple" ontablet="span6" ondesktop="span3">
		<div class="number">
		<?php
			$query = "
				select SUM(ft.ettiliq + ft.ettiva) total
				from ft (nolock)
				where 
					fdata = convert(varchar(10), getdate(), 112) and
					(ft.tipodoc=1 or ft.tipodoc=3) and 
					ft.anulado = 0 
			";
			$result = mssql__select( $query );
			
			echo number_format($result[0]["total"], 2, '.', '') . " €";
		?>
		</div>
		<div class="title">vendas hoje</div>
	</div>

	<div class="span3 statbox purple" ontablet="span6" ondesktop="span3">
		<div class="number">
		<?php
			$query = "
				select SUM(ft.ettiliq + ft.ettiva) total
				from ft (nolock)
				where 
					fdata = convert(varchar(10), dateadd(day, -1, getdate()), 112) and
					(ft.tipodoc=1 or ft.tipodoc=3) and 
					ft.anulado = 0 
			";
			$result = mssql__select( $query );
			
			echo number_format($result[0]["total"], 2, '.', '') . " €";
		?>
		</div>
		<div class="title">vendas ontem</div>
	</div>

	<div class="span3 statbox purple" ontablet="span6" ondesktop="span3">
		<div class="number">
		<?php
			$query = "
				select SUM(ft.ettiliq + ft.ettiva) total
				from ft (nolock)
				where 
					fdata between convert(varchar(10), dateadd(day, -7, getdate()), 112) and getdate() and
					(ft.tipodoc=1 or ft.tipodoc=3) and 
					ft.anulado = 0 
			";
			$result = mssql__select( $query );
			
			echo number_format($result[0]["total"], 2, '.', '') . " €";
		?>
		</div>
		<div class="title">vendas últimos 7 dias</div>
	</div>

	<div class="span3 statbox purple" ontablet="span6" ondesktop="span3">
		<div class="number">
		<?php
			$query = "
				select SUM(ft.ettiliq + ft.ettiva) total
				from ft (nolock)
				where 
					fdata between convert(varchar(10), dateadd(day, -31, getdate()), 112) and getdate() and
					(ft.tipodoc=1 or ft.tipodoc=3) and 
					ft.anulado = 0 
			";
			$result = mssql__select( $query );
			
			echo number_format($result[0]["total"], 2, '.', '') . " €";
		?>
		</div>
		<div class="title">vendas último mês</div>
	</div>
</div>
<div class="row-fluid">
	<div class="span3 statbox green" ontablet="span6" ondesktop="span3">
		<div class="number">
		<?php
			$query = "
				select sum(ft2.epaga1) total
				from ft (nolock) inner join ft2 (nolock) on ft.ftstamp = ft2.ft2stamp
				where 
					fdata = convert(varchar(10), getdate(), 112) and
					(ft.tipodoc=1 or ft.tipodoc=3) and 
					ft.anulado = 0
			";
			$result = mssql__select( $query );
			
			echo number_format($result[0]["total"], 2, '.', '') . " €";
		?>
		</div>
		<div class="title">Multibanco hoje</div>
	</div>

	<div class="span3 statbox green" ontablet="span6" ondesktop="span3">
		<div class="number">
		<?php
			$query = "
				select sum(ft2.epaga1) total
				from ft (nolock) inner join ft2 (nolock) on ft.ftstamp = ft2.ft2stamp
				where 
					fdata = convert(varchar(10), dateadd(day, -1, getdate()), 112) and
					(ft.tipodoc=1 or ft.tipodoc=3) and 
					ft.anulado = 0
			";
			$result = mssql__select( $query );
			
			echo number_format($result[0]["total"], 2, '.', '') . " €";
		?>
		</div>
		<div class="title">Multibanco ontem</div>
	</div>

	<div class="span3 statbox green" ontablet="span6" ondesktop="span3">
		<div class="number">
		<?php
			$query = "
				select sum(ft2.epaga1) total
				from ft (nolock) inner join ft2 (nolock) on ft.ftstamp = ft2.ft2stamp
				where 
					fdata between convert(varchar(10), dateadd(day, -7, getdate()), 112) and getdate() and
					(ft.tipodoc=1 or ft.tipodoc=3) and 
					ft.anulado = 0
			";
			$result = mssql__select( $query );
			
			echo number_format($result[0]["total"], 2, '.', '') . " €";
		?>
		</div>
		<div class="title">Multibanco últimos 7 dias</div>
	</div>

	<div class="span3 statbox green" ontablet="span6" ondesktop="span3">
		<div class="number">
		<?php
			$query = "
				select sum(ft2.epaga1) total
				from ft (nolock) inner join ft2 (nolock) on ft.ftstamp = ft2.ft2stamp
				where 
					fdata between convert(varchar(10), dateadd(day, -31, getdate()), 112) and getdate() and
					(ft.tipodoc=1 or ft.tipodoc=3) and 
					ft.anulado = 0
			";
			$result = mssql__select( $query );
			
			echo number_format($result[0]["total"], 2, '.', '') . " €";
		?>
		</div>
		<div class="title">Multibanco último mês</div>
	</div>
</div>
<div class="row-fluid">
	<div class="span3 statbox blue" ontablet="span6" ondesktop="span3">
		<div class="number">
		<?php
			$query = "
				select sum(ft2.evdinheiro) total
				from ft (nolock) inner join ft2 (nolock) on ft.ftstamp = ft2.ft2stamp
				where 
					fdata = convert(varchar(10), getdate(), 112) and
					(ft.tipodoc=1 or ft.tipodoc=3) and 
					ft.anulado = 0
			";
			$result = mssql__select( $query );
			
			echo number_format($result[0]["total"], 2, '.', '') . " €";
		?>
		</div>
		<div class="title">Numerário hoje</div>
	</div>

	<div class="span3 statbox blue" ontablet="span6" ondesktop="span3">
		<div class="number">
		<?php
			$query = "
				select sum(ft2.evdinheiro) total
				from ft (nolock) inner join ft2 (nolock) on ft.ftstamp = ft2.ft2stamp
				where 
					fdata = convert(varchar(10), dateadd(day, -1, getdate()), 112) and
					(ft.tipodoc=1 or ft.tipodoc=3) and 
					ft.anulado = 0
			";
			$result = mssql__select( $query );
			
			echo number_format($result[0]["total"], 2, '.', '') . " €";
		?>
		</div>
		<div class="title">Numerário ontem</div>
	</div>

	<div class="span3 statbox blue" ontablet="span6" ondesktop="span3">
		<div class="number">
		<?php
			$query = "
				select sum(ft2.evdinheiro) total
				from ft (nolock) inner join ft2 (nolock) on ft.ftstamp = ft2.ft2stamp
				where 
					fdata between convert(varchar(10), dateadd(day, -7, getdate()), 112) and getdate() and
					(ft.tipodoc=1 or ft.tipodoc=3) and 
					ft.anulado = 0
			";
			$result = mssql__select( $query );
			
			echo number_format($result[0]["total"], 2, '.', '') . " €";
		?>
		</div>
		<div class="title">Numerário últimos 7 dias</div>
	</div>

	<div class="span3 statbox blue" ontablet="span6" ondesktop="span3">
		<div class="number">
		<?php
			$query = "
				select sum(ft2.evdinheiro) total
				from ft (nolock) inner join ft2 (nolock) on ft.ftstamp = ft2.ft2stamp
				where 
					fdata between convert(varchar(10), dateadd(day, -31, getdate()), 112) and getdate() and
					(ft.tipodoc=1 or ft.tipodoc=3) and 
					ft.anulado = 0
			";
			$result = mssql__select( $query );
			
			echo number_format($result[0]["total"], 2, '.', '') . " €";
		?>
		</div>
		<div class="title">Numerário último mês</div>
	</div>
</div>
<div class="row-fluid">
	<div class="span3 statbox red" ontablet="span6" ondesktop="span3">
		<div class="number">
		<?php
			$query = "
				select sum(ft2.etroco) total
				from ft (nolock) inner join ft2 (nolock) on ft.ftstamp = ft2.ft2stamp
				where 
					fdata = convert(varchar(10), getdate(), 112) and
					(ft.tipodoc=1 or ft.tipodoc=3) and 
					ft.anulado = 0
			";
			$result = mssql__select( $query );
			
			echo number_format($result[0]["total"], 2, '.', '') . " €";
		?>
		</div>
		<div class="title">Troco hoje</div>
	</div>

	<div class="span3 statbox red" ontablet="span6" ondesktop="span3">
		<div class="number">
		<?php
			$query = "
				select sum(ft2.etroco) total
				from ft (nolock) inner join ft2 (nolock) on ft.ftstamp = ft2.ft2stamp
				where 
					fdata = convert(varchar(10), dateadd(day, -1, getdate()), 112) and
					(ft.tipodoc=1 or ft.tipodoc=3) and 
					ft.anulado = 0
			";
			$result = mssql__select( $query );
			
			echo number_format($result[0]["total"], 2, '.', '') . " €";
		?>
		</div>
		<div class="title">Troco ontem</div>
	</div>

	<div class="span3 statbox red" ontablet="span6" ondesktop="span3">
		<div class="number">
		<?php
			$query = "
				select sum(ft2.etroco) total
				from ft (nolock) inner join ft2 (nolock) on ft.ftstamp = ft2.ft2stamp
				where 
					fdata between convert(varchar(10), dateadd(day, -7, getdate()), 112) and getdate() and
					(ft.tipodoc=1 or ft.tipodoc=3) and 
					ft.anulado = 0
			";
			$result = mssql__select( $query );
			
			echo number_format($result[0]["total"], 2, '.', '') . " €";
		?>
		</div>
		<div class="title">Troco últimos 7 dias</div>
	</div>

	<div class="span3 statbox red" ontablet="span6" ondesktop="span3">
		<div class="number">
		<?php
			$query = "
				select sum(ft2.etroco) total
				from ft (nolock) inner join ft2 (nolock) on ft.ftstamp = ft2.ft2stamp
				where 
					fdata between convert(varchar(10), dateadd(day, -31, getdate()), 112) and getdate() and
					(ft.tipodoc=1 or ft.tipodoc=3) and 
					ft.anulado = 0
			";
			$result = mssql__select( $query );
			
			echo number_format($result[0]["total"], 2, '.', '') . " €";
		?>
		</div>
		<div class="title">Troco último mês</div>
	</div>
</div>
<div class="row-fluid">
	<div class="span3 statbox yellow" ontablet="span6" ondesktop="span3">
		<div class="number">
		<?php
			$query = "
				select SUM(ft.ettiliq + ft.ettiva) total
				from ft (nolock)
				where 
					fdata between '".date('Y')."-01-01' and '".date('Y')."-03-31' and
					(ft.tipodoc=1 or ft.tipodoc=3) and 
					ft.anulado = 0 
			";
			$result = mssql__select( $query );
			
			echo number_format($result[0]["total"], 2, '.', '') . " €";
		?>
		</div>
		<div class="title">vendas 1º Trimestre</div>
	</div>

	<div class="span3 statbox yellow" ontablet="span6" ondesktop="span3">
		<div class="number">
		<?php
			$query = "
				select SUM(ft.ettiliq + ft.ettiva) total
				from ft (nolock)
				where 
					fdata between '".date('Y')."-04-01' and '".date('Y')."-06-30' and
					(ft.tipodoc=1 or ft.tipodoc=3) and 
					ft.anulado = 0 
			";
			$result = mssql__select( $query );
			
			echo number_format($result[0]["total"], 2, '.', '') . " €";
		?>
		</div>
		<div class="title">vendas 2º Trimestre</div>
	</div>

	<div class="span3 statbox yellow" ontablet="span6" ondesktop="span3">
		<div class="number">
		<?php
			$query = "
				select SUM(ft.ettiliq + ft.ettiva) total
				from ft (nolock)
				where 
					fdata between '".date('Y')."-07-01' and '".date('Y')."-09-30' and
					(ft.tipodoc=1 or ft.tipodoc=3) and 
					ft.anulado = 0 
			";
			$result = mssql__select( $query );
			
			echo number_format($result[0]["total"], 2, '.', '') . " €";
		?>
		</div>
		<div class="title">vendas 3º Trimestre</div>
	</div>

	<div class="span3 statbox yellow" ontablet="span6" ondesktop="span3">
		<div class="number">
		<?php
			$query = "
				select SUM(ft.ettiliq + ft.ettiva) total
				from ft (nolock)
				where 
					fdata between '".date('Y')."-10-01' and '".date('Y')."-12-31' and
					(ft.tipodoc=1 or ft.tipodoc=3) and 
					ft.anulado = 0 
			";
			$result = mssql__select( $query );
			
			echo number_format($result[0]["total"], 2, '.', '') . " €";
		?>
		</div>
		<div class="title">vendas 4º Trimestre</div>
	</div>
</div>
<div class="row-fluid">
	<div class="span3 statbox purple" ontablet="span6" ondesktop="span3">
		<div class="number">
		<?php
			// $query = "
				// select top 1 fi.ref, max(fi.design) design, sum(fi.qtt) qtt
				// from ft (nolock) inner join fi (nolock) on ft.ftstamp = fi.ftstamp
				// where 
					// fdata between convert(varchar(10), dateadd(day, -365, getdate()), 112) and getdate() and
					// (ft.tipodoc=1 or ft.tipodoc=3) and 
					// ft.anulado = 0 
				// group by
					// fi.ref
				// order by
					// sum(fi.qtt) desc
			// ";
			// $result = mssql__select( $query );
			
			// echo $result[0]["design"];
			echo "ROUPA";
		?>
		</div>
		<div class="title">artigo mais vendido último ano</div>
	</div>

	<div class="span3 statbox purple" ontablet="span6" ondesktop="span3">
		<div class="number">
		<?php
			// $query = "
				// select top 1 fi.ref, max(fi.design) design, sum(fi.qtt) qtt
				// from ft (nolock) inner join fi (nolock) on ft.ftstamp = fi.ftstamp
				// where 
					// fdata between convert(varchar(10), dateadd(day, -365, getdate()), 112) and getdate() and
					// (ft.tipodoc=1 or ft.tipodoc=3) and 
					// ft.anulado = 0 
				// group by
					// fi.ref
				// order by
					// sum(fi.qtt) asc
			// ";
			// $result = mssql__select( $query );
			
			// echo $result[0]["design"];
			echo "ACESSORIOS";
		?>
		</div>
		<div class="title">artigo menos vendido último ano</div>
	</div>

	<div class="span3 statbox purple" ontablet="span6" ondesktop="span3">
		<div class="number">
		<?php
			$query = "
				select count(ftstamp) total
				from ft (nolock)
				where 
					fdata between convert(varchar(10), dateadd(day, -31, getdate()), 112) and getdate() and
					(ft.tipodoc=1 or ft.tipodoc=3) and 
					ft.anulado = 1
			";
			$result = mssql__select( $query );
			
			echo number_format($result[0]["total"], 0, '.', '');
		?>
		</div>
		<div class="title">nº documentos anulados último mês</div>
	</div>

	<div class="span3 statbox purple" ontablet="span6" ondesktop="span3">
		<div class="number">
		<?php
			$query = "
				select count(ftstamp) total
				from ft (nolock)
				where 
					fdata between convert(varchar(10), dateadd(day, -31, getdate()), 112) and getdate() and
					ft.tipodoc=3 and 
					ft.anulado = 0
			";
			$result = mssql__select( $query );
			
			echo number_format($result[0]["total"], 0, '.', '');
		?>
		</div>
		<div class="title">nº notas crédito último mês</div>
	</div>
</div>