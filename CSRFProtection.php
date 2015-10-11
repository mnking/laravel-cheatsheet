<input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">

<!-- or -->

<?php echo csrf_field(); ?>

<!-- or using Blade Template Engine -->

{!! csrf_field() !!}

<!-- Using _Token in request header -->
<!-- Do 2 steps -->
<meta name="csrf-token" content="{{ csrf_token() }}">
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

<!-- Using _Token in Cookie -->
<!-- Laravel also stores the CSRF token in a XSRF-TOKEN cookie -->
<?php $request->cookie('XSRF-TOKEN'); ?>

<!-- Excluding URIs From CSRF Protection -->
<!-- Type the URIs that you want except from CSRF Protection in App\Http\Middleware\VerifyCsrfToken  -->
<?php

class VerifyCsrfToken extends BaseVerifier
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        'stripe/*',
    ];
}
