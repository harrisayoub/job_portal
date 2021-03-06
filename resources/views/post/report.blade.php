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
			<div class="row clearfix">
				
				@if (isset($errors) and $errors->any())
					<div class="col-lg-12">
						<div class="alert alert-danger">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							<h5><strong>{{ t('Oops ! An error has occurred. Please correct the red fields in the form') }}</strong></h5>
							<ul class="list list-check">
								@foreach ($errors->all() as $error)
									<li>{{ $error }}</li>
								@endforeach
							</ul>
						</div>
					</div>
				@endif
					
				<div class="col-md-12">
					<div class="contact-form">
						
						<h3 class="list-title gray" style="margin-top: 20px;">
							<?php $attr = ['slug' => slugify($post->title), 'id' => $post->id]; ?>
							<strong><a href="{{ lurl($post->uri, $attr) }}">{{ $title }}</a></strong>
						</h3>
						
						<h5>{{ t('There\'s something wrong with this ads?') }}</h5>
		
						<form role="form" method="POST" action="{{ lurl('posts/' . $post->id . '/report') }}">
							{!! csrf_field() !!}
							<fieldset>
								<!-- Type -->
								<div class="form-group <?php echo (isset($errors) and $errors->has('report_type_id')) ? 'has-error' : ''; ?>">
									<label for="report_type_id" class="control-label">{{ t('Reason') }}:</label>
									<select id="reportTypeId" name="report_type_id" class="form-control selecter">
										<option value="">{{ t('Select a reason') }}</option>
										@foreach($reportTypes as $reportType)
											<option value="{{ $reportType->id }}" {{ (old('report_type_id', 0)==$reportType->id) ? 'selected="selected"' : '' }}>
												{{ $reportType->name }}
											</option>
										@endforeach
									</select>
								</div>
								
								<!-- Email -->
								@if (auth()->check() and isset(auth()->user()->email))
									<input type="hidden" name="email" value="{{ auth()->user()->email }}">
								@else
									<div class="form-group <?php echo (isset($errors) and $errors->has('email')) ? 'has-error' : ''; ?>">
										<label for="email" class="control-label">{{ t('Your E-mail') }}:</label>
										<div class="input-group">
											<span class="input-group-addon"><i class="icon-mail"></i></span>
											<input id="email" name="email" type="text" maxlength="60" class="form-control" value="{{ old('email') }}">
										</div>
									</div>
								@endif
							
								<!-- Message -->
								<div class="form-group <?php echo (isset($errors) and $errors->has('message')) ? 'has-error' : ''; ?>">
									<label for="message" class="control-label">{{ t('Message') }}: <span class="text-count"></span></label>
									<textarea id="message" name="message" class="form-control" rows="10">{{ old('message') }}</textarea>
								</div>
			
								<!-- Captcha -->
								@if (config('settings.security.recaptcha_activation'))
									<div class="form-group <?php echo (isset($errors) and $errors->has('g-recaptcha-response')) ? 'has-error' : ''; ?>">
										<label class="control-label" for="g-recaptcha-response">{{ t('We do not like robots') }}</label>
										<div>
											{!! Recaptcha::render(['lang' => config('app.locale')]) !!}
										</div>
									</div>
								@endif
			
								<input type="hidden" name="post_id" value="{{ $post->id }}">
								<input type="hidden" name="abuseForm" value="1">
								
								<div class="form-group">
									<a href="{{ URL::previous() }}" class="btn btn-default btn-lg">{{ t('Back') }}</a>
									<button type="submit" class="btn btn-primary btn-lg">{{ t('Send Report') }}</button>
								</div>
							</fieldset>
						</form>
					</div>
				</div>
				
			</div>
		</div>
	</div>
@endsection

@section('after_scripts')
	<script src="{{ url('assets/js/form-validation.js') }}"></script>
@endsection