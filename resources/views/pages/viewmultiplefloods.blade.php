@extends('layouts.masters.frontend-layouts')
@section('page-content')
<div class="row">
	<div class="col-xs-12">
		<h1>Flood Reports</h1>
	</div>
</div>
<?php $counter = 0; ?>
<div class="row">
	@foreach($floods as $flood)
	@if($counter % 3 == 0)
	</div>
	<div class="row">

	@endif
	<div class="col-xs-12 per-accident-wrap">
		<div class="col-xs-12 col-sm-1 datewraptop-f">
			<div class="datewrap-f col-xs-12 np">
				<span class="defsp spmonth"><?php echo date("F", strtotime($flood->date));?></span>
				<span class="defsp spday"><?php echo date("j", strtotime($flood->date));?></span>
				<span class="defsp spyear"><?php echo date("Y", strtotime($flood->date));?></span>
			</div>
		</div>
		<div class="col-xs-12 col-sm-11 per-accident-innerwrap">
			<div class="col-xs-12 np per-accident-wrap-top">
				<span class="defsp spaccidenttitle">{{ $flood->location }}</span>
				<span class="defsp spaccidentdateauthor"><em><?php echo date("g:ia", strtotime($flood->date));?></em></span>
			</div>
			<div class="col-xs-12 np per-accident-wrap-middle">
				<p><?php echo substr($flood->description,0,300); ?> ....</p>
			</div>
			<div class="col-xs-12 np per-accident-wrap-bottom">
				<p>Source: <span>{{$flood->author}}</span></p>
				<p><a href="<?php echo url('viewperflood'); ?>/<?php echo $flood->id?>" class="btn-readmore-flood">Read More</a></p>
			</div>
		</div>
	</div>
	<?php $counter++; ?>
	@endforeach
	
</div>

 @stop
