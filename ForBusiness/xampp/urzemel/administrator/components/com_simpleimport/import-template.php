<?php
header('Content-disposition: attachment; filename=import-template-1.1.csv');
header('Content-type: text/csv');
readfile('import-template-1.1.csv');
?> 