@extends('frontend.layouts.master')

@section('content')

<style>

#chart div {
  font: 10px sans-serif;
  background-color: steelblue;
  text-align: right;
  padding: 3px;
  margin: 1px;
  color: white;
}

</style>

<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-brand" href="#">Account</div>

    <a href="{{ url("/account/".$account->id."/") }}" class="btn btn-default navbar-btn">Summary</a>
    <a href="{{ url("/account/".$account->id."/transaction") }}" class="btn btn-default navbar-btn">Transactions</a>
    <a href="{{ url("/account/".$account->id."/chart") }}" class="btn btn-default navbar-btn active">Charts</a>
    <a href="{{ url("/account/".$account->id."/history") }}" class="btn btn-default navbar-btn">History</a>
  </div>
</nav>

<!-- Chart Panel -->
<div class="row">
  <div class="col-md-8">
    <div class="panel panel-default">
      <div id="chart"></div>
    </div>
  </div>
</div>


<!--Script Reference[1]-->
<script src="//d3js.org/d3.v3.min.js" charset="utf-8"></script>
<script>
var data = [4, 8, 15, 16, 23, 42];
var x = d3.scale.linear()
    .domain([0, d3.max(data)])
    .range([0, 420]);

d3.select("#chart")
  .selectAll("div")
    .data(data)
  .enter().append("div")
    .style("width", function(d) { return x(d) + "px"; })
    .text(function(d) { return d; });

</script>

@endsection
