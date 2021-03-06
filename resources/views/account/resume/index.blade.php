{{--
 

 *

 *

 * -------




--}}
@extends('layouts.master')

@section('content')
	@include('common.spacer')
	<div class="main-container">
		<div class="container">
			<div class="row">
				
				@if (Session::has('flash_notification'))
					<div class="container" style="margin-bottom: -10px; margin-top: -10px;">
						<div class="row">
							<div class="col-lg-12">
								@include('flash::message')
							</div>
						</div>
					</div>
				@endif
				
				<div class="col-sm-3 page-sidebar">
					@include('account.inc.sidebar')
				</div>
				<!--/.page-sidebar-->
				
				<div class="col-sm-9 page-content">
					<div class="inner-box">
						<h2 class="title-2"><i class="icon-town-hall"></i> {{ t('My resumes') }} </h2>
						<div class="mb30">
							<a href="{{ lurl('account/resumes/create') }}" class="btn btn-default"><i class="icon-plus"></i> {{ t('Add a new resume') }}</a>
						</div>
						<br>
						
						<div class="table-responsive">
							<form name="listForm" method="POST" action="{{ lurl('account/resumes/delete') }}">
								{!! csrf_field() !!}
								<div class="table-action">
									<label for="checkAll">
										<input type="checkbox" id="checkAll">
										{{ t('Select') }}: {{ t('All') }} |
										<button type="submit" class="btn btn-sm btn-default delete-action">
											<i class="fa fa-trash"></i> {{ t('Delete') }}
										</button>
									</label>
									<div class="table-search pull-right col-xs-7">
										<div class="form-group">
											<label class="col-xs-5 control-label text-right">{{ t('Search') }} <br>
												<a title="clear filter" class="clear-filter" href="#clear">[{{ t('clear') }}]</a> </label>
											<div class="col-xs-7 searchpan">
												<input type="text" class="form-control" id="filter">
											</div>
										</div>
									</div>
								</div>
								<table id="addManageTable" class="table table-striped table-bordered add-manage-table table demo"
									   data-filter="#filter" data-filter-text-only="true">
									<thead>
									<tr>
										<th data-type="numeric" data-sort-initial="true"></th>
										<th> {{ t('File') }}</th>
										<th data-sort-ignore="true"> {{ t('Name') }} </th>
										<th> {{ t('Option') }}</th>
									</tr>
									</thead>
									<tbody>
									
									<?php
									if (isset($resumes) && $resumes->count() > 0):
									foreach($resumes as $key => $resume):
									?>
									<tr>
										<td style="width:2%" class="add-img-selector">
											<div class="checkbox">
												<label><input type="checkbox" name="entries[]" value="{{ $resume->id }}"></label>
											</div>
										</td>
										<td style="width:14%" class="add-img-td">
											<a class="btn btn-default" href="{{ \Storage::url($resume->filename) }}" target="_blank">
												<i class="icon-attach-2"></i> {{ t('Download') }}
											</a>
										</td>
										<td style="width:58%" class="ads-details-td">
											<div>
												<p>
													{{ str_limit($resume->name, 40) }}
												</p>
											</div>
										</td>
										<td style="width:10%" class="action-td">
											<div>
												@if ($resume->user_id==$user->id)
													<p>
														<a class="btn btn-primary btn-sm" href="{{ lurl('account/resumes/' . $resume->id . '/edit') }}">
															<i class="fa fa-edit"></i> {{ t('Edit') }}
														</a>
													</p>
													<p>
														<a class="btn btn-danger btn-sm delete-action" href="{{ lurl('account/resumes/'.$resume->id.'/delete') }}">
															<i class="fa fa-trash"></i> {{ t('Delete') }}
														</a>
													</p>
												@endif
											</div>
										</td>
									</tr>
									<?php endforeach; ?>
									<?php endif; ?>
									</tbody>
								</table>
							</form>
						</div>
						
						<div class="pagination-bar text-center">
							{{ (isset($resumes)) ? $resumes->links() : '' }}
						</div>
					
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection

@section('after_scripts')
	<script src="{{ url('assets/js/footable.js?v=2-0-1') }}" type="text/javascript"></script>
	<script src="{{ url('assets/js/footable.filter.js?v=2-0-1') }}" type="text/javascript"></script>
	<script type="text/javascript">
		$(function () {
			$('#addManageTable').footable().bind('footable_filtering', function (e) {
				var selected = $('.filter-status').find(':selected').text();
				if (selected && selected.length > 0) {
					e.filter += (e.filter && e.filter.length > 0) ? ' ' + selected : selected;
					e.clear = !e.filter;
				}
			});
			
			$('.clear-filter').click(function (e) {
				e.preventDefault();
				$('.filter-status').val('');
				$('table.demo').trigger('footable_clear_filter');
			});
			
			$('#checkAll').click(function () {
				checkAll(this);
			});
			
			$('a.delete-action, button.delete-action').click(function(e)
			{
				e.preventDefault(); /* prevents the submit or reload */
				var confirmation = confirm("{{ t('Are you sure you want to perform this action?') }}");
				
				if (confirmation) {
					if( $(this).is('a') ){
						var url = $(this).attr('href');
						if (url !== 'undefined') {
							redirect(url);
						}
					} else {
						$('form[name=listForm]').submit();
					}
					
				}
				
				return false;
			});
		});
	</script>
	<!-- include custom script for ads table [select all checkbox]  -->
	<script>
		function checkAll(bx) {
			var chkinput = document.getElementsByTagName('input');
			for (var i = 0; i < chkinput.length; i++) {
				if (chkinput[i].type == 'checkbox') {
					chkinput[i].checked = bx.checked;
				}
			}
		}
	</script>
@endsection
