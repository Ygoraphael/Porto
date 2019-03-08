<div class="sparkLineStats span4 widget green" onTablet="span5" onDesktop="span4">
	<ul class="unstyled">
		<li><span class="sparkLineStats3"></span> 
			Tarefas em Aberto: 
			<span class="number">
			<?php
				$query = "
					SELECT count(fref) total
					FROM fref
					WHERE fref != ''
				";
				$result = mssql__select( $query );
				
				echo( $result[0]["total"] );
			?>
			</span>
		</li>
		<li><span class="sparkLineStats4"></span>
			Projectos em Aberto:
			<span class="number">
			<?php
				$query = "
					select count(frefstamp) total
					from fref
					where u_fechado = 0 and fref != ''
				";
				$result = mssql__select( $query );
				
				echo( $result[0]["total"] );
			?>
			</span>
		</li>
		<li><span class="sparkLineStats9"></span>
			Propostas em Aberto: 
			<span class="number">
			<?php
				$query = "
					select count(bostamp) total
					from bo
					where 
						ndos = 3 and
						fechada = 0
				";
				$result = mssql__select( $query );
				
				echo( $result[0]["total"] );
			?>
			</span>
		</li>
		<li><span class="sparkLineStats5"></span>
			Nº Clientes: 
			<span class="number">
			<?php
				$query = "
					select count(clstamp) total
					from cl
					where estab = 0 and inactivo = 0
				";
				$result = mssql__select( $query );
				
				echo( $result[0]["total"] );
			?>
			</span>
		</li>
		<li><span class="sparkLineStats6"></span>
			Nº Contratos em Activo: 
			<span class="number">
			<?php
				$query = "
					select count(csupstamp) total
					from csup
					where datap >= getdate()
				";
				$result = mssql__select( $query );
				
				echo( $result[0]["total"] );
			?>
			</span>
		</li>
		<li><span class="sparkLineStats7"></span>
			Faturação <?php echo (date("Y")-1); ?>: 
			<span class="number">
			<?php
				$query = "
					select 
						sum(case when year(ft.fdata)=".(date("Y")-1)." then ft.eivain1+ft.eivain2+ft.eivain3+ft.eivain4+ft.eivain5+ft.eivain6+ft.eivain7+ft.eivain8 else 0 end) as total 
					from ft (NOLOCK) 
						inner join ft2 on ft.ftstamp = ft2.ft2stamp 
					where 	
						(ft.tipodoc=1 or ft.tipodoc=3) and 
						ft.anulado = 0 and ft.no <> 1077 and
						ccusto not in ('NC CS', 'NCA')
				";
				$result = mssql__select( $query );
				
				echo number_format($result[0]["total"], 2, '.', '') . " €";
			?>
			</span>
		</li>
		<li><span class="sparkLineStats8"></span>
			Faturação <?php echo (date("Y")); ?>: 
			<span class="number">
			<?php
				$query = "
					select 
						sum(case when year(ft.fdata)=".date("Y")." then ft.eivain1+ft.eivain2+ft.eivain3+ft.eivain4+ft.eivain5+ft.eivain6+ft.eivain7+ft.eivain8 else 0 end) as total 
					from ft (NOLOCK) 
						inner join ft2 on ft.ftstamp = ft2.ft2stamp 
					where 	
						(ft.tipodoc=1 or ft.tipodoc=3) and 
						ft.anulado = 0 and ft.no <> 1077 and
						ccusto not in ('NC CS', 'NCA')
				";
				$result = mssql__select( $query );
				
				echo number_format($result[0]["total"], 2, '.', '') . " €";
			?>
			</span>
		</li>
	</ul>
	<div class="clearfix"></div>
</div><!-- End .sparkStats -->
