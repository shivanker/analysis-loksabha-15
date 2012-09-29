<!DOCTYPE html>
<meta charset="utf-8">
<style>
.bars rect {
  fill: darkmagenta;
}
.shads rect {
  fill: grey;
  fill-opacity: 20%;
}

.axis text {
  font: 10px sans-serif;
}
.axis path, .axis line {
  fill: none;
  stroke: #000;
  shape-rendering: crispEdges;
}
.curve {
  fill: none;
  stroke: black;
  stroke-width: 3;
}

</style>
<body style="padding:3px;margin:3px;font-family:'Palatino Linotype', 'Book Antiqua', Palatino, serif">
<script src="js/d3.v2.js"></script>
<script src="js/histogram-chart.js"></script>
<script>

<?php
  function getvar($vname, $deflt)  { 
    if(isset($_GET[$vname])){
      echo "\"";
      echo urldecode($_GET[$vname]) ;
      echo "\"";
    }
    else
    echo "'$deflt'"; 
  }
?>

  var field =<?php 
			getvar('field','Age');
			?>;
  var state =<?php 
      getvar('state','');
      ?>;
  var party = <?php 
      getvar('party','');
      ?>; 
  var distribution = [];
  d3.csv("MPTrack.csv",function(mps) {
    
    for (var i = mps.length - 1; i >= 0; i--) {
      mps[i][field] = parseFloat(mps[i][field]);
      if ( (state.length == 0 || mps[i]['State'] == state) && (party.length == 0 || mps[i]['Political party'] == party) )
        distribution.push(mps[i][field]);
    }
    
    d3.select("body")
      .datum(distribution)
    .call(histogramChart(field)
      .bins(d3.scale.linear().domain(d3.extent(distribution)).ticks(2.75 * Math.ceil(Math.log(distribution.length)+1)))
    //  .tickFormat(d3.format(".2f"))
    );
    //console.log(d3.scale.linear().domain(d3.extent(distribution)).ticks(5 * Math.ceil(Math.log(distribution.length)+1)));
  
  });

</script>
</body>