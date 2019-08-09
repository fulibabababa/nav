<script src="{{asset('link/js/devtools-detector.js')}}"></script>
<script>
    devtoolsDetector.addListener(function (isOpen) {
        if (isOpen) {
            console.log('open');
            window.location = '{{route('oops')}}';
        } else {
            console.log('close')
        }
    });
    devtoolsDetector.lanuch();
</script>