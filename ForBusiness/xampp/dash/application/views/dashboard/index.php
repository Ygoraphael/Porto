<script>
	var globalScript;
</script>

<div class="main"></div>

<script>	
    $(document).ready(function () {
        
        var curIndex = 0;
        var ary = [<?= "'" . implode("','", $appstorun) . "'" ?>];
        
        function processData() {
            if( curIndex == ary.length ) {
                curIndex = 0;
            }
            
            runApp(ary[curIndex]);
            curIndex++;
        }

        if( ary.length == 1 ) {
            processData();
        }
        else if( ary.length > 1 ) {
            processData();
            setInterval(processData, 20000);
        }
    })
</script>