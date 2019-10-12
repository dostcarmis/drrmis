@extends('layouts.masters.frontend-layouts')
@section('page-content')
<div class="row">
	<div class="col-xs-12">
		<h1>Landslide Reports</h1>
	</div>
</div>
<div class="row">
	<div class="col-xs-12 text-right paginationwrapinner">{{ $landslides->links() }}</div>
</div>
<?php $counter = 0; ?>
<div class="row">
	@foreach($landslides as $landslide)
	@if($counter % 3 == 0)
	</div>
	<div class="row">

	@endif
	<div class="col-xs-12 per-accident-wrap">
		<div class="col-xs-12 col-sm-1 datewraptop">
			<div class="datewrap col-xs-12 np">
				<span class="defsp spmonth"><?php echo date("F", strtotime($landslide->date));?></span>
				<span class="defsp spday"><?php echo date("j", strtotime($landslide->date));?></span>
				<span class="defsp spyear"><?php echo date("Y", strtotime($landslide->date));?></span>
			</div>
		</div>
		<div class="col-xs-12 col-sm-11 per-accident-innerwrap">
			<div class="col-xs-12 np per-accident-wrap-top">
				<span class="defsp spaccidenttitle">{{ $landslide->road_location }}</span>
				<span class="defsp spaccidentdateauthor"><em><?php echo date("g:ia", strtotime($landslide->date));?></em></span>
			</div>
			
			<div class="col-xs-12 np per-accident-wrap-bottom">
				<p>Source: <span>{{$landslide->author}}</span></p>
				<p><a href="<?php echo url('viewperlandslide'); ?>/<?php echo $landslide->id?>" class="btn-readmore-landslide">Read More</a></p>
			</div>
		</div>
	</div>
	<?php $counter++; ?>
	@endforeach
	
</div>
 @stop
