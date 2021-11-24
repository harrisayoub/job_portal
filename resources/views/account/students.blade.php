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
					@include('account/inc/sidebar')
				</div>
				<!--/.page-sidebar-->

				<div class="col-sm-9 page-content">
					<div class="inner-box">
							<h2 class="title-2"><i class="icon-docs"></i> {{ t('Students List') }} </h2>

						<div class="table-responsive">
							<form name="listForm" method="POST" action="{{ lurl('account/'.$pagePath.'/delete') }}">
								{!! csrf_field() !!}
								<div class="table-action">
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
										<!-- <th data-type="numeric" data-sort-initial="true"></th> -->
										<th> {{ t('Country') }}</th>
										<th data-sort-ignore="true"> {{ t('Student Name') }} </th>
										<!-- <th> {{ t('Country') }}</th> -->
										<!-- <th> {{ t('Option') }}</th> -->
									</tr>
									</thead>
									<tbody>

									<?php
                                    if (isset($students) && $students->count() > 0):
									foreach($students as $key => $student):

										// Fixed 2
										if (!$countries->has($student->country_code)) continue;

										// Get country flag
										$countryFlagPath = 'images/flags/16/' . strtolower($student->country_code) . '.png';
									?>
									<tr>
                                        <td style="width:10%" class="add-img-td">
                                            @if (file_exists(public_path($countryFlagPath)))
                                                <img src="{{ url($countryFlagPath) }}" data-toggle="tooltip" title="{{ $student->country_code }}">
                                            @endif
										</td>
                                        <td style="width:90%" class="ads-details-td">
                                            {{ $student->name }}
										</td>
									</tr>
									<?php endforeach; ?>
                                    <?php endif; ?>
									</tbody>
								</table>
							</form>
						</div>
							
                        <div class="pagination-bar text-center">
                            {{-- {{ (isset($student)) ? $student->links() : '' }} --}}
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